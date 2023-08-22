<?php include "inc/header.php" ?>
<div class="container">
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3 justify-content-center">
        <div class="col">
            <div class="form-group">
                <h2 class="pb-2 border-bottom mb-3">Create a New Project</h2>
                <form action="inc/signup.inc.php" method="post">
                    <label for="title" class="form-control mb-3">Project Title</label>
                    <input type="text" name="title" id="" class="form-control mb-3" >
                    <label for="sections" class="form-control mb-3">Number of Sections</label>
                    <input type="number" name="sections" id="">
                    <input type="text" name="user_name" id="" placeholder="Username..." class="form-control mb-3" >
                    <input type="password" name="password" id="" placeholder="Password..." class="form-control mb-3" >
                    <input type="password" name="confirm_password" id="" placeholder="Confirm password..." class="form-control mb-3" >
                    <button type="submit" name="submit" class="btn btn-dark" >Sign-Up</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "inc/footer.php" ?>