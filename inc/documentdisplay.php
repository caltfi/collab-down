<?php
    //Parse and display file
    $Parsedown = new Parsedown();
    $Parsedown -> setSafeMode(true);
    echo $Parsedown->text(file_get_contents($mdFile));
?>
<form action='index.php'>
    <div class='row d-flex justify-content-center'>
        <div class='col-4'>
            <input class='btn btn-primary w-100' type='submit' value='Go Back'>
        </div>
    </div>
</form>