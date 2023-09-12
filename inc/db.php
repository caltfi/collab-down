<?php
    $ini = include 'config.php';

    //Connection to mySQL database
    $servername = $ini['host'];
    $username   = $ini['username'];
    $password   = $ini['password'];
    $dbname     = $ini['dbname'];

    $connection = mysqli_connect($servername, $username, $password, $dbname);

    if(!$connection){
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Error: Cannot connect to database</strong> " . mysqli_connect_error() . "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    }