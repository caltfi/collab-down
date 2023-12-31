<?php include "inc/header.php" ?>
<div class="container">
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3 justify-content-center">
        <div class="col">
            <div class="form-group">
                <h2 class="pb-2 border-bottom mb-3 text-center">Reset Password</h2>
                <p>Please enter the e-mail address linked to your account in the following field. You will receive an e-mail with instructions on how to reset your password.</p>
                <form action="inc/reset_password.inc.php" method="post">
                    <input type="text" name="email" id="" placeholder="Enter your e-mail address..." class="form-control mb-3" >
                    <button type="submit" name="reset-submit" class="btn btn-dark" >Send</button>
                </form>
            </div>
            <br>
            <?php
                if(isset($_GET['error'])){
                    if($_GET['error'] == "emptyinput"){
                        echo "<p>Please enter an e-mail address.</p>";
                    }elseif($_GET['error'] == "invalidemail"){
                        echo "<p>Please enter a valid e-mail address.</p>";
                    }elseif($_GET['error'] == "stmtfail"){
                        echo "<p>Something went wrong. Please try again.</p>";
                    }elseif($_GET['error'] == "none"){
                        echo "<p>Email has been sent!</p>";
                    }
                }
            ?>
        </div>   
    </div>
</div>
<?php include "inc/footer.php" ?>