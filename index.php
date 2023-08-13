<!-- Header + Libraries -->
<?php include "assets/header.php"; ?>
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
        }
    }else{
    ?>
    <form action="index.php" method="post">
        <div class="row">
            <label for="mdContent" aria-label="Markdown Text Goes Here"></label>
            <textarea name="mdContent" id="mdContent" cols="30" rows="15" placeholder="Markdown Text Here"><?php echo file_get_contents($mdFile);?></textarea>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-4">
                <input class="btn btn-primary w-100" type="submit" name="submit" value="Save">
            </div>
        </div>
    </form>
    <?php
    }
    ?>
</div>
<!-- Footer -->
<?php include "assets/footer.php"; ?>