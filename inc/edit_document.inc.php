<?php

if(isset($_POST['save-submit'])){
    $doc_id       = $_POST['doc_id'];
    $file         = $_POST['md_file'];
    $date_updated = date('d-m-y');
    $content      = $_POST['md_content'];

    file_put_contents($file, $content);
    header("Location: ../edit_document.php?doc_id=$doc_id");
    exit();
}

if(isset($_POST['delete-submit'])){
    $doc_id = $_POST['doc_id'];
    $file   = $_POST['md_file'];

    header("Location: ../delete.php");
    exit();
}