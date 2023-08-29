<div class="row d-flex align-items-center">
    <div class="col d-flex justify-content-center">
        <h1 style="font-family:'Courier New',Courier,monospace;"><?php echo $title; ?></h1>
    </div>
    <hr>
</div>

<!-- Section creation form -->
<form action="inc/create_files.inc.php" method="post">
                <!-- SECTION CONTAINER-->
                <div class="sectionContainer">
                <div class="row d-flex justify-content-center mb-3 align-items-start section">
                    <div class="col-2">
                        <div class="card p-4 mt-4">
                            <h3 class="text-center">Section 1</h3>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card p-4 mt-4">
                            <label for="title1" class="mb-3" aria-label="Title"></label>
                            <input type="text" name="title1" id="title1" class="form-control mb-3" placeholder="Title...">
                            <label for="user1" class="mb-3" aria-label="User"></label>
                            <input type="text" name="user1" id="user1" class="form-control mb-3" placeholder="User...">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="card p-4 mt-4">
                            <button type="button" class="btn btn-outline-danger delete-section-button" style="display: none;">Delete Section</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END SECTION CONTAINER-->

            <div class="row d-flex justify-content-center mb-3 align-items-start">
                <div class="col-6">
                    <div class="card p-4 mt-4">
                        <a href="" class="text-body link-underline link-underline-opacity-0"><p class="card-text text-center" id="create_section_button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                            </svg>
                            <h3 class="text-center">Create New Section</h3>
                        </p></a>
                    </div>
                </div>
            </div>
    <div class="row d-flex justify-content-center mb-3 align-items-start">
        <div class="col-6">
            <div class="card p-4 mt-4">
                <p class="card-text text-center">
                <input type="submit" name="submit" class="btn btn-lg btn-outline-secondary w-50" value="Add Sections to Document">
                </p>
            </div>
        </div>
    </div>
</form>