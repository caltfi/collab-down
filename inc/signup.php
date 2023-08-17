<!-- Signup Form -->
<h1 class="text-center">Sign-Up</h1>
<div class="row d-flex justify-content-center">
    <div class="col-4">
        <hr>
        <form class="row g-3 needs-validation" novalidate action="index.php" method="post">
            <div class="col-md-6">
                <label for="validationCustom01" class="form-label">First name</label>
                <input type="text" class="form-control" id="validationCustom01" required>
                <div class="valid-feedback">
                Looks good!
                </div>
                <label for="validationCustom02" class="form-label">Last name</label>
                <input type="text" class="form-control" id="validationCustom02" required>
                <div class="valid-feedback">
                Looks good!
                </div>
            </div>
            <div class="col-md-6">
                <img src="assets/profile.jpg" alt="Placeholder Profile Picture" width="100" height="100">
                <label for="user_profile_image">Profile Picture</label>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="col-md-12">
                <label for="validationCustom03" class="form-label">E-mail</label>
                <input type="text" class="form-control" id="validationCustom03" required>
                <div class="invalid-feedback">
                Please provide a valid email address.
                </div>
            </div>
            <div class="col-md-12">
                <label for="validationCustomUsername" class="form-label">Username</label>
                <div class="input-group has-validation">
                <input type="text" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
                <div class="invalid-feedback">
                    Please choose a username.
                </div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationCustomPassword" class="form-label">Password</label>
                <div class="input-group has-validation">
                <input type="password" class="form-control" id="validationCustomPassword" aria-describedby="inputGroupPrepend" required>
                <div class="invalid-feedback">
                    Please enter a Password.
                </div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationCustomPasswordConfirm" class="form-label">Confirm Password</label>
                <div class="input-group has-validation">
                <input type="password" class="form-control" id="validationCustomPasswordConfirm" aria-describedby="inputGroupPrepend" required>
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
                <form action="#">
                    <button class="btn btn-outline-secondary w-100" type="submit">Log-In</button>
                </form>
            </div>
        </form>
    </div>
</div>