<!-- DB Connection + Header + Libraries -->
<?php ob_start(); ?>
<?php include "inc/db.php"; ?>
<?php include "inc/functions.php"; ?>
<?php require "libs/Parsedown.php"; ?>
<?php include "inc/header.php"; ?>

<?php //include "inc/login.php"; ?>

<!-- Navigation -->
<?php include "inc/navigation.php"; ?>
<!-- Main Content -->
<main class="flex-grow-1 p-3">
    <?php
    // if(isset($_POST['mdContent'])){
    //     $mdText = $_POST['mdContent'];
    //     if(is_readable($mdFile) && !empty($mdText)){
    //         ///Add input to file
    //         file_put_contents($mdFile, $mdText);
    //         //Parse and display file
    //         $Parsedown = new Parsedown();
    //         $Parsedown -> setSafeMode(true);
    //         echo $Parsedown->text(file_get_contents($mdFile));
    //     }else{
    //         include "inc/markdownform.php";
    //     }
    
    //if isset GET 'src' make $source = GET 'src' then switch $source
    if(isset($_GET['src'])){
        $source = $_GET['src'];
        if($source == 'sign_up'){
            include "inc/signup.php";
        }else if($source == 'login'){
            include "inc/login.php";
        }
    }

    //fake data for testing
    $user_id = "101";
    $project_id = "1";
    $section_number = "1";
    $date_created = date('d-m-y');
    $date_updated = date('d-m-y');
    //Create file path
    $md_file = "mdfiles/101_1_1_1692375346.md";
    
    if(isset($_POST['mdContent'])){
        //Get markdown user input from form 
        $md_text = $_POST['mdContent'];

        //Check if file exists and if input is not empty
        if(!empty($md_text)){

            //Add input to file
            file_put_contents($md_file, $md_text);

            // if($md_create = fopen($md_file, 'w')){
            //     fwrite($md_create, $md_text);
            //     fclose($md_create);
            // }else{
            //     echo "Error: Application could not write to the file.";
            // }

            include "inc/documentdisplay.php";
        }else{
            include "inc/markdownform.php";
        }
    }else{
        include "inc/markdownform.php";
    }
    ?>
</main>
<!-- Footer -->
<?php include "inc/footer.php"; ?>