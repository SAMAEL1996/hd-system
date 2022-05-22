<?php
require_once './includes/init.php';
include("vendor/autoload.php");

$id = $session->getuserid();
$user = User::find_by_id($id);

use \ConvertApi\ConvertApi;

ConvertApi::setApiSecret('KlnyBgyQylCoblzT');

$output = "";
if (isset($_POST["submit"])) {
    $pngName = $_POST['pngName'];
    $filename = $_POST['formFile'];
    
    $applicant_id = $_POST["applicant_id"];
    $dir = 'uploads/' . $filename;

    $result = ConvertApi::convert(
                    'png', [
                'File' => $dir,
                    ], 'pdf'
    );
    $contents = $result->getFile()->getContents();
    $output = "converted_files/" . $pngName . ".png";
    $fopen = fopen($output, "w");
    fwrite($fopen, $contents);
    fclose($fopen);
}
?>
<!doctype html>
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
        $applicant = ApplicantProfile::find_by_id($applicant_id);
        ?>
        <div class="container light-grey padding-32 padding-large" style="display: block;">
            <div class="content" style="max-width: 600px;display: block; margin-left: auto; margin-right: auto;">
                <form action="upload_application.php" method="post" class="row align-items-start">
                    <div class="center" style="padding-top: 50px; text-align: center!important;">
                        <a class="btn btn-success text-white" href="uploads/<?php echo $applicant->file_name; ?>" download>Download PDF</a>
                    </div>
                </form>

                <img src="<?php echo $output; ?>" alt="" class="img-fluid">
            </div>
        </div>
    </body>
</html>