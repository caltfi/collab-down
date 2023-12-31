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
    <a href="index.php" class="d-flex align-items-center text-white text-decoration-none mt-3">
        <img src="./assets/images/logo_white.png" alt="CollabDown Logo" height="75">
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto mt-4">
        <li class="nav-item mb-3">
            <a href="index.php" class="nav-link text-white" aria-current="page">
                <h4><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-house-door-fill me-2" viewBox="0 0 16 16">
                    <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z"/>
                </svg>
                Home</h4>
            </a>
        </li>
        <li class="nav-item mb-3">
            <a href="#" class="nav-link text-white" id="cheat_sheet_link">
                <h4><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-file-earmark-excel-fill me-2" viewBox="0 0 16 16">
                    <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM5.884 6.68 8 9.219l2.116-2.54a.5.5 0 1 1 .768.641L8.651 10l2.233 2.68a.5.5 0 0 1-.768.64L8 10.781l-2.116 2.54a.5.5 0 0 1-.768-.641L7.349 10 5.116 7.32a.5.5 0 1 1 .768-.64z"/>
                </svg>
                Cheat Sheet</h4>
            </a>
        </li>
        <?php 
        //Only show following Document dropdown if user is logged in
        if(isset($_SESSION['username'])){
        ?>
        <li class="nav-item mb-3">
            <a class="nav-link text-white" href="documents.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <h4><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-archive-fill me-2" viewBox="0 0 16 16">
                    <path d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15h9.286zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1zM.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8H.8z"/>
                </svg>
                Documents</h4>
            </a>
            <ul class="dropdown-menu bg-dark mb-2 pe-5" style="border: none; overflow:auto; max-height:590px;">
                <?php
                    $username = $_SESSION['username'];
                    
                    $documents = array();

                    //select docs where user is admin
                    $query = "SELECT * FROM documents WHERE documents_admin = ?;";
                    $prep_stat = mysqli_stmt_init($connection);
                    if(!mysqli_stmt_prepare($prep_stat, $query)) {
                        echo "Error: " . mysqli_error($connection);
                    }
                    mysqli_stmt_bind_param($prep_stat, "s", $username);
                    mysqli_stmt_execute($prep_stat);
                    $result = mysqli_stmt_get_result($prep_stat);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $doc_id = $row['documents_id'];

                        //check if the document with the same ID already exists
                        $exist_doc = array_filter($documents, function($doc)use($doc_id){
                            return $doc['documents_id'] == $doc_id;
                        });

                        if (empty($exist_doc)){
                            //add total word count and user count for the document
                            $wordCount = get_total_word_count_doc($doc_id, $connection);
                            $userCount = get_user_count_for_document($doc_id, $connection);
                            $row['total_word_count'] = $wordCount;
                            $row['user_count'] = $userCount;

                            //add the document to the array
                            $documents[] = $row;
                        }
                    }
                    mysqli_stmt_close($prep_stat);

                    //select docs where user is assigned
                    $query = "SELECT documents.* FROM files INNER JOIN documents ON files.files_document_id = documents.documents_id WHERE files_assign_uid = ?;";
                    $prep_stat = mysqli_stmt_init($connection);
                    if(!mysqli_stmt_prepare($prep_stat, $query)){
                        echo "Error: " . mysqli_error($connection);
                    }
                    mysqli_stmt_bind_param($prep_stat, "s", $username);
                    mysqli_stmt_execute($prep_stat);
                    $result = mysqli_stmt_get_result($prep_stat);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $doc_id = $row['documents_id'];

                        //check if the document with the same ID already exists
                        $exist_doc = array_filter($documents, function($doc)use($doc_id){
                            return $doc['documents_id'] == $doc_id;
                        });

                        if (empty($exist_doc)) {
                            //add total word count and user count for the document
                            $wordCount = get_total_word_count_doc($doc_id, $connection);
                            $userCount = get_user_count_for_document($doc_id, $connection);
                            $row['total_word_count'] = $wordCount;
                            $row['user_count'] = $userCount;

                            //add document to the array
                            $documents[] = $row;
                        }
                    }
                    mysqli_stmt_close($prep_stat);

                    foreach($documents as $document){
                        if($document['documents_no_sections'] == 0){
                            ?>
                            <li>
                                <a class="dropdown-item text-white mb-3" href="edit_document.php?doc_id=<?php echo $document['documents_id'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-file-earmark-fill me-3" viewBox="0 0 16 16">
                                        <path d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm5.5 1.5v2a1 1 0 0 0 1 1h2l-3-3z"/>
                                    </svg>
                                    <?php 
                                        if(strlen($document['documents_title']) > 15){
                                            echo substr($document['documents_title'], 0, 15) . '...';
                                        }else{
                                            echo $document['documents_title'];
                                        }
                                    ?>
                                </a>
                            </li>
                            <?php
                        }else{
                            ?>
                            <li>
                                <a class="dropdown-item text-white mb-3" href="edit_document.php?doc_id=<?php echo $document['documents_id'] ?>">
                                <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-file-earmark-text-fill me-3' viewBox='0 0 16 16'>
                                    <path d='M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z'/>
                                </svg>    
                                <?php 
                                    if(strlen($document['documents_title']) > 15){
                                        echo substr($document['documents_title'], 0, 15) . '...';
                                    }else{
                                        echo $document['documents_title'];
                                    }
                                ?>
                                </a>
                            </li>
                            <?php
                        }
                    }
                ?>
                <li>
                    <a class="dropdown-item text-white" href="" id="new_doc_button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-lg me-2" viewBox="0 0 16 16">
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
        <li class="nav-item mt-2 mb-2 ms-3">
            <form action="inc/new_document.inc.php" id="new_doc_form" method="post" class="text-white mb-2" style="display: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-file-earmark-fill me-2" viewBox="0 0 16 16">
                    <path d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm5.5 1.5v2a1 1 0 0 0 1 1h2l-3-3z"/>
                </svg>
                <input type="text" name="title" id="title_text_input" placeholder="Title..." style="width: 150px;"  autocomplete="off">
            </form>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <ul class="nav nav-pills">
        <?php
            if(isset($_SESSION['username'])){
                $username      = $_SESSION['username'];
                $user_prof_pic = $_SESSION['user_prof_pic'];
                echo "<li class='nav-item'><a class='nav-link text-white' href='profile.php'><img ";
                if(file_exists("assets/user_prof/{$username}/{$user_prof_pic}")){
                    echo "src='assets/user_prof/{$username}/{$user_prof_pic}'";
                }else{
                    echo "src='assets/user_prof/profile.jpg'";
                }
                echo " alt='' width='32' height='32' class='rounded-circle me-2'>Profile</a></li>";
                echo "<li class='nav-item'><a class='nav-link text-white' href='./inc/logout.inc.php'>Log-Out</a></li>";
            }else{
                echo "<li class='nav-item me-3 ms-3'><a href='login.php'><button type='button' class='btn btn-light'>Log-In</button></a></li>";
                echo "<li class='nav-item ms-3'><a href='signup.php'><button type='button' class='btn btn-outline-light me-4'>Sign-Up</button></a></li>";
            }
        ?>
        </ul>
    </div>
</div>
<div class="flex-column flex-shrink-0 p-3 bg-tertiary overflow-y-scroll" style="width: 500px; height: calc(100vh - 72px); display: none; resize: horizontal;" id="cheat_sheet">
    <?php include "mdcheatsheet.php" ?>
</div>