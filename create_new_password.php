<?php include "inc/header.php" ?>
<div class="container">
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3 justify-content-center">
        <div class="col">
            <div class="form-group">
            <?php
            $selector  = $_GET['selector'];
            $validator = $_GET['validator'];

            if(empty($selector) || empty($validator)){
                die("<p>Error! We could not validate your password reset request. Please try again.</p>");
            }else{
                if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false){
                    ?>
                    <form action="inc/create_new_password.inc.php" method="post">
                        <input type="hidden" name="selector" value="<?php echo $selector ?>">
                        <input type="hidden" name="validator" value="<?php echo $validator ?>">
                        <input type="password" name="pwd" id="pwd" placeholder="Enter new password..." class="form-control mb-3" >
                        <input type="password" name="confirm_pwd" id="confirm_pwd" placeholder="Confirm new password..." class="form-control mb-3" >
                        <button type="submit" name="reset-password-submit" class="btn btn-dark">Reset Password</button>
                    </form>
                    <?php
                }
            }

            if(isset($_GET['error'])){
                if($_GET['error'] == "emptyinput"){
                    echo "<p>Please enter a password.</p>";
                }elseif($_GET['error'] == "pwd_nomatch"){
                    echo "<p>Passwords do not match.</p>";
                }elseif($_GET['error'] == "stmtfail"){
                    echo "<p>Something went wrong. Please try again.</p>";
                }elseif($_GET['error'] == "expired"){
                    echo "<p>Your password reset request has expired. Please try again.</p>";
                }
            }
            ?>
            </div>
        </div>   
    </div>
</div>
<?php include "inc/footer.php" ?>