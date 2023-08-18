<?php
    //if isset POST signup
    if(isset($_POST['signup'])){
        //if the password and confirm password fields match
        if($_POST['password'] == $_POST['password_confirm']){
            //if unique username and email are true
            if(unique_username() && unique_email()){
                //Create variables to store POST values from signup form make them all mysqli_real_escape_string with $connection
                $username   = mysqli_real_escape_string($connection, $_POST['user_name']);
                $password   = mysqli_real_escape_string($connection, $_POST['password']);
                $email      = mysqli_real_escape_string($connection, $_POST['email']);
                $first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
                $last_name  = mysqli_real_escape_string($connection, $_POST['last_name']);

                //temporarily set profile picture to be default "assets/profile.jpg"
                $profile_picture = "assets/profile.jpg";

                // //Create variables to store $_FILES values from signup form + tmp_name
                // $profile_picture      = $_FILES['profile_picture']['name'];
                // $profile_picture_temp = $_FILES['profile_picture']['tmp_name'];
                // //move the uploaded file to the images folder
                // move_uploaded_file($profile_picture_temp, "../images/$profile_picture");
                // //if no image provided use default "assets/profile.jpg"
                // if(empty($profile_picture)){
                //     $profile_picture = "assets/profile.jpg";
                // }
                
                //Hash the password using blowfish crypt with salt
                $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

                //Create query to insert user into database
                $query  = "INSERT INTO users (user_name, password, email, first_name, last_name, profile_picture) ";
                $query .= "VALUES ('{$username}', '{$password}', '{$email}', '{$first_name}', '{$last_name}', '{$profile_picture}')";

                //send query to database
                $create_user = mysqli_query($connection, $query);

                //if query fails die and display error
                if(!$create_user){
                    die("QUERY FAILED: " . mysqli_error($connection));
                }else{
                    echo "<div class='row d-flex text-bg-success p-3'>";
                    echo "<h3  class='text-center'>User Created!</h3>";            
                    echo "</div>";
                }
            }
        }else{
            echo "<div class='row d-flex text-bg-danger p-3'>";
            echo "<h3  class='text-center'>Passwords do not match!</h3>";            
            echo "</div>";
        }
    }
?>
<!-- Signup Form -->
<h1 class="text-center">Sign-Up</h1>
<div class="row d-flex justify-content-center">
    <div class="col-4">
        <hr>
        <form class="row g-3 needs-validation" novalidate action="index.php" method="post">
            <div class="col-md-12">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" name="first_name" id="first_name" required>
                <div class="valid-feedback">
                Looks good!
                </div>
            </div>
            <div class="col-md-12">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="last_name" id="last_name" required>
                <div class="valid-feedback">
                Looks good!
                </div>
            </div>

            <!-- <div class="col-md-6">
                <img src="assets/profile.jpg" alt="Placeholder Profile Picture" width="100" height="100">
                <label for="profile_picture">Profile Picture</label>
                <input type="file" name="profile_picture[]" id="profile_picture" class="form-control">
            </div> -->

            <div class="col-md-12">
                <label for="validationCustom03" class="form-label">E-mail</label>
                <input type="text" class="form-control" name="email" id="validationCustom03" required>
                <div class="invalid-feedback">
                Please provide a valid email address.
                </div>
            </div>
            <div class="col-md-12">
                <label for="validationCustomUsername" class="form-label">Username</label>
                <div class="input-group has-validation">
                <input type="text" class="form-control" name="user_name" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
                <div class="invalid-feedback">
                    Please choose a username.
                </div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationCustomPassword" class="form-label">Password</label>
                <div class="input-group has-validation">
                <input type="password" class="form-control" name="password" id="validationCustomPassword" aria-describedby="inputGroupPrepend" required>
                <div class="invalid-feedback">
                    Please enter a Password.
                </div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationCustomPasswordConfirm" class="form-label">Confirm Password</label>
                <div class="input-group has-validation">
                <input type="password" class="form-control" name="password_confirm" id="validationCustomPasswordConfirm" aria-describedby="inputGroupPrepend" required>
                <div class="invalid-feedback">
                    Please confirm your Password.
                </div>
                </div>
            </div>
            <hr>
            <div class="col-12">
                <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                <label class="form-check-label" for="invalidCheck">
                    Agree to <a href="" class="text-body">Terms and Conditions</a>
                </label>
                <div class="invalid-feedback">
                    You must agree before submitting.
                </div>
                </div>
            </div>
            <div class="col-5">
                <input class="btn btn-primary w-100" type="submit" name="signup" value="Sign-Up">
            </div>
            <div class="col-2">
                <p class="text-center">Or</p>
            </div>
            <div class="col-5">
                <button class="btn btn-outline-secondary w-100"><a href="index.php?src=login"  class="text-body">Log-In</a></button>
            </div>
        </form>
    </div>
</div>