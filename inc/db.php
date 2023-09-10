<?php
    //Connection to mySQL database
    $servername = 'localhost';
    $username   = 'root';
    $password   = '';
    $dbname     = 'collabdown';

    $connection = mysqli_connect($servername, $username, $password, $dbname);

    if(!$connection){
        echo "ERROR: Cannot connect to database. " . mysqli_connect_error();
    }