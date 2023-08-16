<!-- Header + Libraries -->
<?php include "inc/header.php"; ?>
<?php require "libs/Parsedown.php"; ?>
<!-- Main Content -->
<div class="container">
    <?php
    $mdFile = "mdfiles/test.md";
    
    if(isset($_POST['mdContent'])){
        $mdText = $_POST['mdContent'];

        if(is_readable($mdFile) && !empty($mdText)){
            ///Add input to file
            file_put_contents($mdFile, $mdText);

            //Parse and display file
            $Parsedown = new Parsedown();
            $Parsedown -> setSafeMode(true);
            echo $Parsedown->text(file_get_contents($mdFile));
        }else{
            include "inc/markdownform.php";
        }
    }else{
        include "inc/markdownform.php";
    }
    ?>
</div>
<!-- Footer -->
<?php include "inc/footer.php"; ?>