<!-- DB Connection + Header + Libraries -->
<?php include "inc/db.php"; ?>
<?php include "inc/header.php"; ?>
<!-- Main Content -->
<main class="flex-grow-1 p-3">
    <?php
    if(isset($_GET['error'])){
        if($_GET['error'] == "stmtfail"){
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Something went wrong!</strong> Please try again.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }elseif($_GET['error'] == "imgtoolarge"){
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Image size must be less than 1.2MB.</strong> Please try again.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }elseif($_GET['error'] == 'invalidimg'){
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Invalid image file.</strong> Please try again.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }elseif($_GET['error'] == 'none'){
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Profile updated successfully!</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }
    }
    ?>
    <div class="row">
        <h2 class="text-center mb-5">Edit Your Profile</h2>
    </div>
    <?php
    if(isset($_SESSION['username'])){
        $username       = $_SESSION['username'];
        $user_full_name = $_SESSION['user_full_name'];
        $email          = $_SESSION['user_email'];
        $user_prof_pic  = $_SESSION['user_prof_pic'];
        ?>
        <div class="row d-flex align-content-start justify-content-center">
            <div class="col-2 d-flex align-content-between flex-wrap justify-content-center">
                <form action="inc/edit_profile.inc.php" enctype="multipart/form-data" id="user_prof_pic_form"  method="post">
                <img 
                <?php 
                    if(file_exists("assets/user_prof/{$username}/{$user_prof_pic}")){
                        echo "src='assets/user_prof/{$username}/{$user_prof_pic}'";
                    }else{
                        echo "src='assets/user_prof/profile.jpg'";
                    }
                ?> 
                height="200" width="200" class="rounded-circle border border-dark mb-3" alt="...">
                <input type="hidden" name="username" value="<?php echo $username ?>">
                <input type="file" name="user_prof_pic" id="user_prof_pic" accept=".jpg, .jpeg, .png" class="form-control">
                </form>
            </div>
            <div class="col-2">
                <p><h3>Change your details:</h3></p>
                <form action="inc/edit_profile.inc.php" id="name_change_form" method="post">
                <h4><input type="text" name="full_name" id="full_name_text_input" value="<?php echo $user_full_name ?>" class="w-100"></h4>
                </form>
                <hr>
                <p><a href="./inc/logout.inc.php?source=reset_password" class="text-body">Reset your password</a></p>
                <p><a href="./delete.php?user_id=<?php echo $username ?>" class="text-body">Delete your account</a></p>
                <br>
                <a href="profile.php" class="btn btn-secondary w-100">Done</a>
            </div>
        </div>
        <?php 
    }
    ?>
</main>
<!-- Footer -->
<?php include "inc/footer.php"; ?>