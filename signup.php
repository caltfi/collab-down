<?php include "inc/header.php" ?>
<div class="container">
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3 justify-content-center">
        <div class="col">
            <div class="form-group">
                <h2 class="pb-2 border-bottom mb-3">Sign-Up</h2>
                <form action="inc/signup.inc.php" method="post">
                    <input type="text" name="name" id="" placeholder="Full name..." class="form-control mb-3" >
                    <input type="text" name="email" id="" placeholder="E-mail..." class="form-control mb-3" >
                    <input type="text" name="user_name" id="" placeholder="Username..." class="form-control mb-3" >
                    <input type="password" name="password" id="" placeholder="Password..." class="form-control mb-3" >
                    <input type="password" name="confirm_password" id="" placeholder="Confirm password..." class="form-control mb-3" >
                    <button type="submit" name="submit" class="btn btn-dark" >Sign-Up</button>
                </form>
            </div>
            <br>
            <?php
                if(isset($_GET['error'])){
                    if($_GET['error'] == "emptyinput"){
                        echo "<p>Please fill in all fields.</p>";
                    }elseif($_GET['error'] == "wronglogin"){
                        echo "<p>Please choose a valid username.</p>";
                    }elseif($_GET['error'] == "invalidemail"){
                        echo "<p>Please use a valid e-mail address.</p>";
                    }elseif($_GET['error'] == "passwordnonmatch"){
                        echo "<p>Passwords do not match!</p>";
                    }elseif($_GET['error'] == "usernametaken"){
                        echo "<p>This username /email is already taken.</p>";
                    }elseif($_GET['error'] == "stmtfail"){
                        echo "<p>Something went wrong. Please try again.</p>";
                    }elseif($_GET['error'] == "none"){
                        echo "<p>You have created an account!</p>";
                    }
                }
            ?>
        </div>
    </div>
</div>
<?php include "inc/footer.php" ?>