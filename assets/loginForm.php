<!-- Login Form -->
<h1 class="text-center">Login Form</h1>
<form action="index.php" method="post"> 
    <div class="row">
        <label for="username" aria-label="Username"></label>
        <input type="text" name="username" class="form-control" placeholder="Username">
    </div>
    <div class="row">
        <label for="password" aria-label="Password"></label>
        <input type="password" name="password" class="form-control" placeholder="Password">
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-4">
            <input class="btn btn-primary w-100" type="submit" name="login" value="Log In">
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-4">
            <input class="btn btn-outline-secondary w-100" type="submit" name="signup" value="Sign Up">
        </div>
    </div>
</form>