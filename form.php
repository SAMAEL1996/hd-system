<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once './includes/init.php';

$id = $session->getuserid();
$user = User::find_by_id($id);
?>
<html>
    <head>
        <?php
        include './spinoffs/head.php';
        ?>
    </head>
    <body>
        <div style="width: 100%; float: left">
            <?php
            include './spinoffs/header-admin.php';
            ?>
        </div>
        <?php
        $error = filter_input(INPUT_GET, 'error', FILTER_SANITIZE_STRING);
        ?>
        <div class="container light-grey padding-32 padding-large" style="display: block;">
            <div class="content" style="max-width: 600px;display: block; margin-left: auto; margin-right: auto;">
                <h2 class="center" style="padding-top: 100px; text-align: center!important;">
                    <b>Add new Job Opening</b>
                </h2>
                <form method="post" action="upload_application.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="text" name="job" class="form-control" placeholder="Jop Position" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="title" class="form-control" placeholder="Job Title" required>
                    </div>
                    <div class="mb-3">
                        <textarea type="text" name="description" class="form-control" style="white-space: pre-wrap;" placeholder="Job Description" required></textarea>
                    </div>
                    <div class="mb-3 d-flex justify-content-center align-items-center">
                        <input type="submit" name="submitjob" value="Submit Job Opening" class="btn btn-outline-dark col-md-4 ms-4">
                    </div>
                </form>
                <?php
                if (isset($error)) {
                    ?>
                    <div id="mydiv" class="alert alert-danger text-center" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <script src="./public/js/fadeDIV.js"></script>
    </body>
</html>
