<?php
//Functions.php

//Function to get content from markdown file section, parse it and echo it
function display_md_file($md_file){
    if(is_readable($md_file)){
        //Parse and display file
        $Parsedown = new Parsedown();
        $Parsedown -> setSafeMode(true);
        echo $Parsedown->text(file_get_contents($md_file));
    }else{
        echo "<div class='row d-flex text-bg-danger p-3'>";
        echo "<h3  class='text-center'>Error, File is not readable!</h3>";
        echo "</div>";
    }
}

//Function to check if signup form input is empty   
function empty_signup_input($name, $user_name, $email, $password, $confirm_pwd){
    if(empty($name) || empty($user_name) || empty($email) || empty($password) || empty($confirm_pwd)){
        return true;
    }else{
        return false;
    }
}

//Function to check if username is valid
function invalid_user_name($user_name){
    if(!preg_match("/^[a-zA-Z0-9]*$/", $user_name)){
        return true;
    }else{
        return false;
    }
}

//Function to check if email is valid
function invalid_email($email){
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }else{
        return false;
    }
}

//Function to check if signup passwords match
function password_non_match($password, $confirm_pwd){
    if($password !== $confirm_pwd){
        return true;
    }else{
        return false;
    }
}

//Function to check if email or username already exists
function user_name_exists($connection, $user_name, $email, $page){
    $query     = "SELECT * FROM users WHERE users_uid = ? OR users_email = ?;";
    $prep_stat = mysqli_stmt_init($connection);
    if(!mysqli_stmt_prepare($prep_stat, $query)){
        header("Location: ../{$page}.php?error=stmtfail");
        exit();
    }
    mysqli_stmt_bind_param($prep_stat, "ss", $user_name, $email);
    mysqli_stmt_execute($prep_stat);
    $result = mysqli_stmt_get_result($prep_stat);
    if($row = mysqli_fetch_assoc($result)){
        return $row;
    }else{
        return false;
    }
    mysqli_stmt_close($prep_stat);
}

//Function to create new user in database
function create_user($connection, $name, $email, $user_name, $password, $profile_pic){
    $query = "INSERT INTO users (users_name, users_email, users_uid, users_pwd, users_profile_pic) VALUES (?, ?, ?, ?, ?);";
    $prep_stat = mysqli_stmt_init($connection);
    if(!mysqli_stmt_prepare($prep_stat, $query)){
        header("Location: ../signup.php?error=stmtfail");
        exit();
    }

    $hash_pwd = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($prep_stat, "sssss", $name, $email, $user_name, $hash_pwd, $profile_pic);
    mysqli_stmt_execute($prep_stat);
    mysqli_stmt_close($prep_stat);
    header("Location: ../login.php?result=signup_success");
    exit();
}

//Function to create new file
function create_file($filename) {
    if ($md_create = fopen($filename, 'w')) {
        fclose($md_create);
        return true;
    } else {
        return false;
    }
}

//Function to insert file data into database
function insert_file_data($connection, $file_id, $assign_uid, $date, $document_id, $section_number) {
    $query = "INSERT INTO files (files_id, files_assign_uid, files_date_created, files_date_updated, files_document_id, files_section_number) VALUES (?, ?, ?, ?, ?, ?);";
    $prep_stat = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($prep_stat, $query)) {
        header("Location: ../new_document.php?error=stmtfail");
        exit();
    }
    mysqli_stmt_bind_param($prep_stat, "ssssii", $file_id, $assign_uid, $date, $date, $document_id, $section_number);
    mysqli_stmt_execute($prep_stat);
    mysqli_stmt_close($prep_stat);
}

//Function to create a new document
function create_document($connection, $title, $sections, $date, $admin){
    $query     = "INSERT INTO documents (documents_title, documents_date, documents_admin, documents_no_sections) VALUES (?, ?, ?, ?);";
    $prep_stat = mysqli_stmt_init($connection);
    if(!mysqli_stmt_prepare($prep_stat, $query)){
        header("Location: ../new_document.php?error=stmtfail");
        exit();
    }
    mysqli_stmt_bind_param($prep_stat, "ssss", $title, $date, $admin, $sections);
    mysqli_stmt_execute($prep_stat);
    mysqli_stmt_close($prep_stat);
}

//Function to check if login form input is empty   
function empty_login_input($user_name, $password){
    if(empty($user_name) || empty($password)){
        return true;
    }else{
        return false;
    }
}

//Function to verify login details and begin user session   
function login_user($connection, $user_name, $password){
    // Check if username OR email matches existing user, returns -> row mysqli fetch assoc
    $uid_exists = user_name_exists($connection, $user_name, $user_name, "login");
    if($uid_exists === false){
        header("Location: ../login.php?error=wronglogin");
        exit();
    }

    $pwd_hashed = $uid_exists["users_pwd"];
    $check_pwd  = password_verify($password, $pwd_hashed);
    if($check_pwd === false){
        header("Location: ../login.php?error=wronglogin");
        exit();
    }elseif($check_pwd === true){
        session_start();
        $_SESSION['user_full_name'] = $uid_exists["users_name"];
        $_SESSION['user_email']     = $uid_exists["users_email"];
        $_SESSION['username']       = $uid_exists["users_uid"];
        $_SESSION['user_prof_pic']  = $uid_exists["users_profile_pic"];
        header("Location: ../index.php");
        exit();
    }
}

//Function to get total word count
function get_total_word_count($result){
    //initialise word count to 0
    $total_word_count = 0;
    //Go through each file and count words, if file doesn't exist for some reason just add 0 to total word count
    while($row = mysqli_fetch_assoc($result)){
        $file_id = $row['files_id'];
        $file_path = "mdfiles/$file_id.md";

        if(file_exists($file_path)){
            $file       = fopen($file_path, "r");
            $word_count = 0;
            while(!feof($file)){
                $word_count += str_word_count(fgets($file));
            }
            $total_word_count += $word_count;
            fclose($file);
        }else{$total_word_count += 0;}
    }
    return $total_word_count;
}