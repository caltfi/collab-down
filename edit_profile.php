<!-- DB Connection + Header + Libraries -->
<?php include "inc/db.php"; ?>
<?php include "inc/header.php"; ?>
<!-- Main Content -->
<main class="flex-grow-1 p-3">
    <div class="row">
        <h2 class="text-center mb-5">Edit Your Profile</h2>
    </div>
    <?php
    $username       = $_SESSION['username'];
    $user_full_name = $_SESSION['user_full_name'];
    $email          = $_SESSION['user_email'];
    $profile_pic    = $_SESSION['user_prof_pic'];

    ?>
    <form action="" method="post">
    <div class="row justify-content-center">
        <div class="col-2">
            <img src="assets/<?php echo $profile_pic ?>" height="200" class="rounded-circle border border-dark" alt="...">
        </div>
        <div class="col-2">
            <p><h3>Change your details:</h3></p>
            <h4><input type="text" name="full_name" id="full_name" value="<?php echo $user_full_name ?>" class="w-100"></h4>
            <hr>
            <p><a href="reset_password.php" class="text-body">Reset your password</a></p>
            <p><a href="delete_account.php" class="text-body">Delete your account</a></p>
        </div>
        <div class="col-2 p-3">
            <input type="submit" name="submit" class="btn btn-dark w-100 m-3" value="Save Changes"><br>
            <a href="profile.php" class="btn btn-outline-secondary w-100 m-3">Cancel</a>
        </div>
    </div>
    </form>
    

</main>
<!-- Footer -->
<?php include "inc/footer.php"; ?>