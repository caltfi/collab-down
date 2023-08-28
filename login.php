<?php include "inc/header.php" ?>
<div class="container">
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3 justify-content-center">
        <div class="col">
            <div class="form-group">
                <h2 class="pb-2 border-bottom mb-3 text-center">Log-In</h2>
                <form action="inc/login.inc.php" method="post">
                    <input type="text" name="user_name" id="" placeholder="Username or E-mail..." class="form-control mb-3" >
                    <input type="password" name="password" id="" placeholder="Password..." class="form-control mb-3" >
                    <button type="submit" name="submit" class="btn btn-dark" >Log In</button>
                </form>
                <hr>
                <a href="reset_password.php" class="text-body">Forgot your password?</a>
            </div>
            <br>
            <?php
                if(isset($_GET['error'])){
                    if($_GET['error'] == "emptyinput"){
                        echo "<p>Please fill in all fields.</p>";
                    }elseif($_GET['error'] == "wronglogin"){
                        echo "<p>Incorrect login information</p>";
                    }
                }
                if(isset($_GET['result'])){
                    if($_GET['result'] == "signup_success"){
                        echo "<p>You have successfully created an account!</p>";
                    }if($_GET['result'] == "pwd_reset_success"){
                        echo "<p>Your password reset was successful!</p>";
                    }
                }
            ?>
        </div>   
    </div>
</div>
<?php include "inc/footer.php" ?>