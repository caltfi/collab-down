<?php include "inc/header.php" ?>
<div class="container">
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3 justify-content-center">
        <div class="col">
            <div class="form-group">
                <h2 class="pb-2 border-bottom mb-3 text-center">Sign-Up</h2>
                <form action="inc/signup.inc.php" method="post">
                    <input type="text" name="name" id="" placeholder="Full name..." class="form-control mb-3" >
                    <input type="text" name="email" id="" placeholder="E-mail..." class="form-control mb-3" >
                    <input type="text" name="user_name" id="" placeholder="Username..." class="form-control mb-3" >
                    <input type="password" name="password" id="" placeholder="Password..." class="form-control mb-3" >
                    <input type="password" name="confirm_password" id="" placeholder="Confirm password..." class="form-control mb-3" >
                    <div class="form-check mb-3 ps-0">
                        <div class="btn-group me-2" role="group" aria-label="Basic checkbox toggle button group">
                            <input type="checkbox" class="btn-check" id="btncheck1" autocomplete="off" required>
                            <label class="btn btn-sm btn-outline-success d-flex align-items-center" for="btncheck1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                                </svg>
                            </label>
                        </div>
                        <label class="form-check-label" for="btncheck1">
                            I agree to the <a href="terms.php" class="link-dark link-opacity-25-hover">Terms and Conditions</a>
                        </label>
                    </div>
                    <button type="submit" name="submit" class="btn btn-dark" >Sign-Up</button>
                </form>
            </div>
            <br>
            <?php
                if(isset($_GET['error'])){
                    if($_GET['error'] == "emptyinput"){
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                <strong>Error!</strong> Please fill in all fields.
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                    }elseif($_GET['error'] == "invalidusername"){
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                <strong>Error!</strong> Please choose a valid username.
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                    }elseif($_GET['error'] == "invalidemail"){
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                <strong>Error!</strong> Please use a valid e-mail address.
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                    }elseif($_GET['error'] == "passwordnonmatch"){
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                <strong>Sorry</strong> Passwords do not match. Try again!
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                    }elseif($_GET['error'] == "usernametaken"){
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                <strong>Sorry</strong> This username /email is already taken.
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                    }elseif($_GET['error'] == "stmtfail"){
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                <strong>Sorry</strong> Something went wrong. Please try again.
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                    }
                }
            ?>
        </div>
    </div>
</div>
<?php include "inc/footer.php" ?>