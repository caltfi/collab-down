<!-- Login Form -->
<h1 class="text-center">Log-In</h1>
<div class="row d-flex justify-content-center">
    <div class="col-4">
        <hr>
        <form class="row g-3" action="index.php" method="post">
            <div class="col-md-12">
                <label for="username" aria-label="Username" class="form-label">E-mail or Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="col-md-12">
                <label for="password" aria-label="Password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <hr>
            <div class="col-5">
                <input class="btn btn-primary w-100" type="submit" name="signup" value="Log-In">
            </div>
            <div class="col-2">
                <p class="text-center">Or</p>
            </div>
            <div class="col-5">
                <form action="#">
                    <button class="btn btn-outline-secondary w-100" type="submit">Sign-Up</button>
                </form>
            </div>
        </form>
    </div>
</div>