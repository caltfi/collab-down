<?php
    //Function to create new markdown file in mdfiles folder and add entry to database table with unique file id
    function create_md_file($user_id, $project_id, $section_number){
        global $connection;
        //Create unique file id
        $file_id = "{$user_id}_{$project_id}_{$section_number}_" . time();
        //Create entry for file in mdfiles database table
        $query  = "INSERT INTO md_files(file_id, user_id, date_created, date_updated, project_id, section_number)";
        $query .= "VALUES('{$file_id}', '{$user_id}', now(), now(), '{$project_id}', '{$section_number}')";
        //Send query to database
        $create_file_query = mysqli_query($connection, $query);
        //Check if query was successful
        if(!$create_file_query){
            die("QUERY FAILED" . mysqli_error($connection));
        }
        //Create file
        $md_file = "mdfiles/{$file_id}.md";
        if($md_create = fopen($md_file, 'w')){
            fclose($md_create);
        }else{
            echo "Error: Application could not create file.";
        }
    }

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

    //Function to check if username is unique
    function unique_username(){
        global $connection;
        //make sure username is unique
        $query = "SELECT user_name FROM users WHERE user_name = '{$_POST['user_name']}'";
        $check_username = mysqli_query($connection, $query);
        if(!$check_username){
            die("QUERY FAILED: " . mysqli_error($connection));
        }
        if(mysqli_num_rows($check_username) > 0){
            echo "<div class='row d-flex text-bg-danger p-3'>";
            echo "<h3  class='text-center'>Username already exists!</h3>";            
            echo "</div>";
            return false;
        }else{
            return true;
        }
    }

    //Function to check if email is unique
    function unique_email(){
        global $connection;
        //make sure email is unique
        $query = "SELECT email FROM users WHERE email = '{$_POST['email']}'";
        $check_email = mysqli_query($connection, $query);
        if(!$check_email){
            die("QUERY FAILED: " . mysqli_error($connection));
        }
        if(mysqli_num_rows($check_email) > 0){
            echo "<div class='row d-flex text-bg-danger p-3'>";
            echo "<h3  class='text-center'>Email already exists!</h3>";            
            echo "</div>";
        }else{
            return true;
        }
    }
?>