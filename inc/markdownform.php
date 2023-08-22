<!-- Markdown Form -->
<h1 class="text-center">Markdown Form</h1>
<div class="row d-flex justify-content-center">
    <div class="col-6">
        <form action="index.php" method="post">
            <div class="row">
                <label for="mdContent" aria-label="Markdown Text Goes Here"></label>
                <textarea name="mdContent" class="form-control" id="mdContent" cols="30" rows="15" placeholder="Markdown Text Here"><?php echo file_get_contents($md_file); ?></textarea>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-4">
                    <input class="btn btn-dark w-100" type="submit" name="submit" value="Save">
                </div>
            </div>
        </form>
    </div>
</div>