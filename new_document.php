<?php include "inc/header.php" ?>
<div class="container">
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3 justify-content-center">
        <div class="col">
            <div class="form-group">
                <h2 class="pb-2 border-bottom mb-3">Create a New Document</h2>
                <form action="inc/new_document.inc.php" method="post">
                    <label for="title" class="mb-3">Document Title</label>
                    <input type="text" name="title" id="title" class="form-control mb-3" >
                    <label for="sections" class="mb-3">Number of Sections</label>
                    <input type="range" name="sections" id="sections"  min="3" max="12" value="3" step="1" class="form-control form-range mb-3">
                    <span><h3  id="sections_value">3</h3></span><hr>
                    <button type="submit" name="submit" class="btn btn-dark" >Create!</button>
                </form>
            </div>
            <br>
            <?php
                if(isset($_GET['error'])){
                    if($_GET['error'] == "emptyinput"){
                        echo "<p>Please give your document a title.</p>";
                    }elseif($_GET['error'] == "stmtfailed"){
                        echo "<p>Something went wrong, please try again.</p>";
                    }elseif($_GET['error'] == "notloggedin"){
                        echo "<p>You must be logged in to create a document.</p>";
                    }elseif($_GET['error'] == "none"){
                        echo "<p>You have created a new document!</p>";
                    }
                }
            ?>
        </div>
    </div>
</div>
<script>
    const sections_input = document.getElementById('sections');
    const sections_value = document.getElementById('sections_value');
    
    sections_input.addEventListener('input', function() {
        // Update the span with the current value of the range
        sections_value.textContent = sections_input.value;
    });
</script>
<?php include "inc/footer.php" ?>