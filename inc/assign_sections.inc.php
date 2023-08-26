<div class="row d-flex align-items-center">
    <div class="col d-flex justify-content-center">
        <h1 style="font-family:'Courier New',Courier,monospace;"><?php echo $title; ?></h1>
    </div>
    <hr>
</div>

<!-- Section creation form -->
<form action="create_files.inc.php" method="post">
    <div class="row d-flex justify-content-center mb-3 align-items-start">
        <div class="col-8 border rounded p-5">
            <h3 class="text-center">Section 1</h3>
                <label for="title1" class="mb-3">Section Title</label>
                <input type="text" name="title1" id="title1" class="form-control mb-3" placeholder="Title...">
                <label for="user1" class="mb-3">Assigned User</label>
                <input type="text" name="user1" id="user1" class="form-control mb-3" placeholder="User...">
        </div>
    </div>
    <!-- <div class="row d-flex justify-content-center mb-3 align-items-start">
        <div class="col-8 border rounded p-5">
            <a href="#" class="text-body link-underline link-underline-opacity-0"><p class="card-text text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                </svg>
                <h3 class="text-center">Create New Section</h3>
            </p></a>
        </div>
    </div> -->
    <div class="row d-flex justify-content-center mb-3 align-items-start">
        <div class="col-8 border rounded p-5 text-center">
            <input type="submit" name="submit" class="btn btn-lg btn-outline-secondary" value="Add">
        </div>
    </div>
</form>