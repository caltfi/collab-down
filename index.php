<!-- DB Connection + Header + Libraries -->
<?php include "inc/db.php"; ?>
<?php include "inc/header.php"; ?>
<!-- Main Content -->
<main class="flex-grow-1 p-3">
<div class='row mb-4'>
    <?php    
    if(isset($_SESSION['user_full_name'])){
        //echo "<div class='row mb-4'>";
        echo "<h1 class='text-center mb-2'>Hello {$_SESSION['user_full_name']}, welcome!</h1>";
    ?>
    <hr>
    </div>
    <div class="row">
        <h2 class="text-center mb-5">Your Documents</h2>
    <?php
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
        $admin  = $row['documents_admin'];
        ?>
            <div class="col-2 ms-5 me-3">
                <div class="card border-top-0 shadow-lg mb-5" style="width: 18rem;">
                    <img src="assets/spiral.jpg" class="card-img-top" alt="Document">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $title ?></h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">@<?php echo $admin ?></h6>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Word Count: </li>
                        <li class="list-group-item">Something Else:</li>
                    </ul>
                    <div class="card-body">
                        <a href="#" class="btn btn-outline-secondary">View Document</a>
                    </div>
                </div>
            </div>
        <?php
    }
    }else{
        ?>
        <div class="col">
            <h1 class='text-center mt-5 mb-5'>Welcome to #Collabdown!</h1>
            <h2 class='text-center mb-5'><strong>Log-In</strong> to get started.</h2>
            <div class="text-center" style="margin-top: 35px; margin-right: 580px;">
                <img src='assets/arrow.jpg' height="200" style="transform: rotate(-45deg);" alt='Arrow'>
            </div>
            </div>
        <?php
    }
    
    // if(isset($_POST['mdContent'])){
    //     //Get markdown user input from form 
    //     $md_text = $_POST['mdContent'];

    //     //Check if file exists and if input is not empty
    //     if(!empty($md_text)){
    //         //Add input to file
    //         file_put_contents($md_file, $md_text);
    //         //Display file
    //         include "inc/documentdisplay.php";
    //     }else{
    //         //Display form again if input is empty
    //         include "inc/markdownform.php";
    //     }
    // }else{
    //     //display form if no input
    //     include "inc/markdownform.php";
    // }
    ?>
    </div>
</main>
<!-- Footer -->
<?php include "inc/footer.php"; ?>