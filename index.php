<!-- Header + Libraries -->
<?php include "inc/header.php"; ?>
<?php include "inc/db.php"; ?>
<?php require "libs/Parsedown.php"; ?>
<!-- Main Content -->
<div class="container">
    <?php
    ob_start();
    // $mdFile = "mdfiles/test.md";
    
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
    
    $user_id = "101";
    $project_id = "1";
    $section_number = "1";
    $date_created = date('d-m-y');
    $date_updated = date('d-m-y');

    $file_id = "{$user_id}_{$project_id}_{$section_number}_" . time();

    $mdFile = "mdfiles/{$file_id}.md";
    
    if(isset($_POST['mdContent'])){
        $mdText = $_POST['mdContent'];

        $query  = "INSERT INTO md_files(file_id, user_id, date_created, date_updated, project_id, section_number)";
        $query .= "VALUES('{$file_id}', '{$user_id}', now(), now(), '{$project_id}', '{$section_number}')";
        
        $create_file_query = mysqli_query($connection, $query);

        if(!$create_file_query){
            die("QUERY FAILED" . mysqli_error($connection));
        }

        if(!empty($mdText)){

            //Add input to file
            if($mdCreate = fopen($mdFile, 'w')){
                fwrite($mdCreate, $mdText);
                fclose($mdCreate);
            }else{
                echo "Error: Application could not write to the file.";
            }

            //Parse and display file
            $Parsedown = new Parsedown();
            $Parsedown -> setSafeMode(true);
            echo $Parsedown->text(file_get_contents($mdFile));

            //Button to go back to index
            echo "<form action='index.php'><div class='row d-flex justify-content-center'>";
            echo "<div class='col-4'><input class='btn btn-primary w-100' type='submit' value='Go Back'></div>";
            echo "</div></form>";
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