<?php ob_start() ?>
<?php session_start() ?>
<?php require_once "db.php" ?>
<?php require_once "functions.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-grid.min.css">
    <style>
        .nav > li > .dropdown-menu > li > a:hover { background-color: #292b2c; }
    </style>
    <title>Collabdown - 122111845 Calum Fenton Project</title>
</head>
<body>
<div class="d-flex" style="min-height: 100vh; position:sticky;">
<!--Navigation-->
<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 270px; z-index:5;">
    <a href="index.php" class="d-flex align-items-center text-white text-decoration-none">
        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-hash" viewBox="0 0 16 16">
            <path d="M8.39 12.648a1.32 1.32 0 0 0-.015.18c0 .305.21.508.5.508.266 0 .492-.172.555-.477l.554-2.703h1.204c.421 0 .617-.234.617-.547 0-.312-.188-.53-.617-.53h-.985l.516-2.524h1.265c.43 0 .618-.227.618-.547 0-.313-.188-.524-.618-.524h-1.046l.476-2.304a1.06 1.06 0 0 0 .016-.164.51.51 0 0 0-.516-.516.54.54 0 0 0-.539.43l-.523 2.554H7.617l.477-2.304c.008-.04.015-.118.015-.164a.512.512 0 0 0-.523-.516.539.539 0 0 0-.531.43L6.53 5.484H5.414c-.43 0-.617.22-.617.532 0 .312.187.539.617.539h.906l-.515 2.523H4.609c-.421 0-.609.219-.609.531 0 .313.188.547.61.547h.976l-.516 2.492c-.008.04-.015.125-.015.18 0 .305.21.508.5.508.265 0 .492-.172.554-.477l.555-2.703h2.242l-.515 2.492zm-1-6.109h2.266l-.515 2.563H6.859l.532-2.563z"/>
        </svg>
        <span class="fs-2" style='font-family:"Courier New",Courier,monospace;'>Collabdown</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="index.php" class="nav-link text-white" aria-current="page">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house me-2" viewBox="0 0 16 16">
                    <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z"/>
                </svg>
                Home
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link text-white" id="cheat_sheet_link">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-grid me-2" viewBox="0 0 16 16">
                    <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z"/>
                </svg>
                Cheat Sheet
            </a>
        </li>
        <?php 
        //Only show following Document dropdown if user is logged in
        if(isset($_SESSION['username'])){
        ?>
        <li class="nav-item">
            <a class="nav-link dropdown-toggle text-white" href="documents.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-table me-2" viewBox="0 0 16 16">
                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm15 2h-4v3h4V4zm0 4h-4v3h4V8zm0 4h-4v3h3a1 1 0 0 0 1-1v-2zm-5 3v-3H6v3h4zm-5 0v-3H1v2a1 1 0 0 0 1 1h3zm-4-4h4V8H1v3zm0-4h4V4H1v3zm5-3v3h4V4H6zm4 4H6v3h4V8z"/>
                </svg>
                Documents
            </a>
            <ul class="dropdown-menu bg-dark mb-2" style="border: none;">
                <?php
                    //echo <li> elements for each document in database that user is either documents_admin from documents table or is a files_assign_uid from files table
                    $username = $_SESSION['username'];
                    $query = "SELECT * FROM documents WHERE documents_admin = '$username'";
                    $prep_stat = mysqli_stmt_init($connection);
                    if (!mysqli_stmt_prepare($prep_stat, $query)) {
                        echo "Error: " . mysqli_error($connection);
                    }
                    mysqli_stmt_execute($prep_stat);
                    $result = mysqli_stmt_get_result($prep_stat);
                    while($row = mysqli_fetch_assoc($result)){
                        $title  = $row['documents_title'];
                        $doc_id = $row['documents_id'];
                        echo "<li><a class='dropdown-item text-white mb-2' href='edit_document.php?doc_id={$doc_id}'><svg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='currentColor' class='bi bi-file-earmark-fill me-3' viewBox='0 0 16 16'><path d='M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm5.5 1.5v2a1 1 0 0 0 1 1h2l-3-3z'/></svg>{$title}</a></li>";
                    }
                    mysqli_stmt_close($prep_stat); 
                ?>
                <li>
                    <a class="dropdown-item text-white" href="new_document.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-plus-lg me-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                        </svg>
                        New Document
                    </a>
                </li>
            </ul>
        </li>
        <?php
        }
        ?>
    </ul>
    <hr>
    <div class="dropdown">
        <ul class="nav nav-pills">
        <?php
            if(isset($_SESSION['username'])){
                $profile_pic = $_SESSION['user_prof_pic'];
                echo "<li class='nav-item'><a class='nav-link text-white' href='profile.php'><img src='assets/{$profile_pic}' alt='' width='32' height='32' class='rounded-circle me-2'>Profile</a></li>";
                echo "<li class='nav-item'><a class='nav-link text-white' href='./inc/logout.inc.php'>Log-Out</a></li>";
            }else{
                echo "<li class='nav-item me-3 ms-3'><a href='login.php'><button type='button' class='btn btn-light'>Log-In</button></a></li>";
                echo "<li class='nav-item ms-3'><a href='signup.php'><button type='button' class='btn btn-outline-light me-4'>Sign-Up</button></a></li>";
            }
        ?>
        </ul>
    </div>
</div>
<div class="flex-column flex-shrink-0 p-3 bg-tertiary overflow-y-scroll" style="width: 500px; height: 100vh; display: none; resize: horizontal;" id="cheat_sheet">
    <?php include "mdcheatsheet.php" ?>
</div>