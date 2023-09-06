<?php
include_once "db.php";
include_once "functions.php";
session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $user_full_name = $_SESSION['user_full_name'];
    $email = $_SESSION['user_email'];
    $user_prof_pic = $_SESSION['user_prof_pic'];

    if(isset($_FILES['user_prof_pic']['name'])){
        $username = $_POST['username'];

        if(empty($_FILES['user_prof_pic']['name'])){
            header("Location: ../edit_profile.php?error=invalidimg");
            exit();
        }

        $img_name      = $_FILES['user_prof_pic']['name'];
        $img_tmp_name  = $_FILES['user_prof_pic']['tmp_name'];
        $img_size      = $_FILES['user_prof_pic']['size'];
        $img_extension = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));

        $valid_img = array('jpg', 'jpeg', 'png');
        if(!in_array($img_extension, $valid_img)){
            header("Location: ../edit_profile.php?error=invalidimg");
            exit();
        }elseif($img_size > 1200000){
            header("Location: ../edit_profile.php?error=imgtoolarge");
            exit();
        }else{
            $new_img_name = $username . uniqid() . '.' . $img_extension;

            //query to update image filename
            $query = "UPDATE users SET users_profile_pic = '$new_img_name' WHERE users_uid = '$username';";
            $result = mysqli_query($connection, $query);
            if(!$result){
                header("Location: ../edit_profile.php?error=stmtfail");
                exit();
            }

            $img_destination = "../assets/user_prof/{$username}/{$new_img_name}";

            if(!file_exists("../assets/user_prof/{$username}")){
                mkdir("../assets/user_prof/{$username}");
                move_uploaded_file($img_tmp_name, $img_destination);
            }else{
                if(file_exists("../assets/user_prof/{$username}/{$user_prof_pic}")){
                    unlink("../assets/user_prof/{$username}/{$user_prof_pic}");
                }
                move_uploaded_file($img_tmp_name, $img_destination);
            }

            $_SESSION['user_prof_pic'] = $new_img_name;
            
            header("Location: ../edit_profile.php?error=none");
            exit();
        } 
    }elseif(isset($_POST['full_name'])){
        $new_full_name = $_POST['full_name'];

        //check if new full name is valid (to avoid SQL injection)
        if(!preg_match("/^[a-zA-Z0-9\s]*$/", $new_full_name)){
            header("Location: ../edit_profile.php?error=stmtfail");
            exit();
        }

        $query = "UPDATE users SET users_name = ? WHERE users_uid = ?;";
        $prep_stat = mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($prep_stat, $query)){
            header("Location: ../edit_profile.php?error=stmtfail");
            exit();
        }
        mysqli_stmt_bind_param($prep_stat, "ss", $new_full_name, $username);
        mysqli_stmt_execute($prep_stat);
        mysqli_stmt_close($prep_stat);

        $_SESSION['user_full_name'] = $new_full_name;

        header("Location: ../edit_profile.php?error=none");
        exit();
    }else{
        header("Location: ../edit_profile.php?error=stmtfail");
        exit();
    }
}else{
    header("Location: ../index.php");
    exit();
}
