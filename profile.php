<!-- DB Connection + Header + Libraries -->
<?php include "inc/db.php"; ?>
<?php include "inc/header.php"; ?>
<!-- Main Content -->
<main class="flex-grow-1 p-3">
    <div class="row">
        <h2 class="text-center mb-5">Your Profile</h2>
    </div>
    <?php
    $username       = $_SESSION['username'];
    $user_full_name = $_SESSION['user_full_name'];
    $email          = $_SESSION['user_email'];
    $user_prof_pic  = $_SESSION['user_prof_pic'];

    //create query to get number of documents where user is the owner
    $query     = "SELECT * FROM documents WHERE documents_admin = ?;";
    $prep_stat = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($prep_stat, $query)) {
        echo "Error: " . mysqli_error($connection);
    }
    mysqli_stmt_bind_param($prep_stat, "s", $username);
    mysqli_stmt_execute($prep_stat);
    $result = mysqli_stmt_get_result($prep_stat);
    $no_of_admin_docs = mysqli_num_rows($result);
    mysqli_stmt_close($prep_stat);

    //Get the total number of documents the user is associated with
    $query     = "SELECT DISTINCT files_document_id FROM files WHERE files_assign_uid = ?;";
    $prep_stat = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($prep_stat, $query)) {
        echo "Error: " . mysqli_error($connection);
    }
    mysqli_stmt_bind_param($prep_stat, "s", $username);
    mysqli_stmt_execute($prep_stat);
    $result = mysqli_stmt_get_result($prep_stat);
    $no_of_contributions = mysqli_num_rows($result);
    mysqli_stmt_close($prep_stat);

    //get all files from DB where user is assigned to section of document to get total word count
    $query     = "SELECT * FROM files WHERE files_assign_uid = ?;";
    $prep_stat = mysqli_stmt_init($connection);
    if(!mysqli_stmt_prepare($prep_stat, $query)){
        echo "Error: " . mysqli_error($connection);
    }
    mysqli_stmt_bind_param($prep_stat, "s", $username);
    mysqli_stmt_execute($prep_stat);
    $result = mysqli_stmt_get_result($prep_stat);

    $total_word_count = get_total_word_count($result);
    
    mysqli_stmt_close($prep_stat);

    ?>
    <div class="row justify-content-center">
        <div class="col-2">
            <img 
            <?php 
                if(file_exists("assets/user_prof/{$username}/{$user_prof_pic}")){
                    echo "src='assets/user_prof/{$username}/{$user_prof_pic}'";
                }else{
                    echo "src='assets/user_prof/profile.jpg'";
                }
            ?> 
            height="200" width="200" class="rounded-circle border border-dark" alt="Profile Picture">
        </div>
        <div class="col-2">
            <h3><?php echo $user_full_name ?></h3>
            <p>@<?php echo $username ?></p>
            <hr>
            <p>
                <h3>E-mail</h3>
            </p>
            <p><?php echo $email ?></p>
            <hr>
            <p>
                <h3>Stats</h3>
            </p>
            <p><strong><h1><?php echo $no_of_contributions ?></h1></strong> documents which you are a contributor</p>
            <p><strong><h1><?php echo $no_of_admin_docs ?></h1></strong> documents which you are admin</p>
            <p><strong><h1><?php echo $total_word_count ?></h1></strong> total number of words contributed</p>
        </div>
        <div class="col-2">
            <a href="edit_profile.php" class="btn btn-dark">Edit Profile</a>
        </div>
    </div>
    

</main>
<!-- Footer -->
<?php include "inc/footer.php"; ?>