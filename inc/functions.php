<?php
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