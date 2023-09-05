<div class="row d-flex align-items-center">
    <div class="col-10 d-flex justify-content-center">
        <h1><?php echo $title; ?></h1>
    </div>
    <hr>
</div>
<!-- Section creation form -->
<form action="inc/create_files.inc.php?doc_id=<?php echo $doc_id ?>" method="post">
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
                    <label for="title" class="mb-3" aria-label="Title"></label>
                    <input type="text" name="title[0]" id="title1" class="form-control mb-3" placeholder="Title...">
                    <label for="user" class="mb-3" aria-label="User"></label>
                    <input type="text" name="user[0]" id="user1" class="form-control mb-3" placeholder="User...">
                </div>
            </div>
            <div class="col-2">
                <div class="card p-4 mt-4">
                    <button type="button" class="btn btn-outline-danger delete-section-button" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                        </svg>
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION CONTAINER-->

    <div class="row d-flex justify-content-center mb-3 align-items-start">
        <div class="col-10">
            <div class="card p-4 mt-4">
                <p class="card-text text-center" id="create_section_button" style="cursor:pointer;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                    </svg>
                    <h3 class="text-center">Create New Section</h3>
                </p>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-center mb-5 align-items-start">
        <div class="col-10">
            <div class="card p-4 mt-4 mb-5">
                <p class="card-text text-center w-40">
                <input type="submit" name="submit-files" class="btn btn-lg btn-secondary" value="Add Sections to Document">
                </p>
            </div>
        </div>
    </div>
</form>