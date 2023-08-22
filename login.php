<?php include "inc/header.php" ?>
<div class="container">
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3 justify-content-center">
        <div class="col">
            <div class="form-group">
                <h2 class="pb-2 border-bottom mb-3">Log-In</h2>
                <form action="inc/login.inc.php" method="post">
                    <input type="text" name="user_name" id="" placeholder="Username or E-mail..." class="form-control mb-3" >
                    <input type="password" name="password" id="" placeholder="Password..." class="form-control mb-3" >
                    <button type="submit" name="submit" class="btn btn-dark" >Log In</button>
                </form>
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
            ?>
        </div>   
    </div>
</div>
<?php include "inc/footer.php" ?>