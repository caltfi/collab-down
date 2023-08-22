<!-- DB Connection + Header + Libraries -->
<?php include "inc/db.php"; ?>
<?php include "inc/header.php"; ?>
<!-- Main Content -->
<main class="flex-grow-1 p-3">
    <?php    
    if(isset($_SESSION['user_full_name'])){
        echo "<h1 class='text-center'>Hello there, {$_SESSION['user_full_name']}!</h1>";
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
            //Display file
            include "inc/documentdisplay.php";
        }else{
            //Display form again if input is empty
            include "inc/markdownform.php";
        }
    }else{
        //display form if no input
        include "inc/markdownform.php";
    }
    ?>
</main>
<!-- Footer -->
<?php include "inc/footer.php"; ?>