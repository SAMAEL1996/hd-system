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
        <div style="width:100%; height: 833px;">

            <?php
            $clientid = filter_input(INPUT_GET, "clientid", FILTER_VALIDATE_INT);
            $client = ApplicantProfile::find_by_id($clientid);
            ?>

            <!-- HEADER -->
            <div style="width: 100%; float: left">
                <?php
                include './spinoffs/header-admin.php';
                ?>
            </div>

            <!-- SIDE-BAR -->
            <div id="side-bar" style="float: left; height: 100%">
                <?php
                include './spinoffs/admin-sidebar.php';
                ?>
            </div>

            <!-- CONTENT -->
            <div id="content" style="float: left; width: 1116px; height:627px; overflow-y: auto">
                <!-- CONTENT-TOP -->
                <div class="p-3" style="margin-left: auto; margin-right: auto;">
                    <h2 style="border-bottom: 1px solid gray; margin-bottom: 50px;">Applicant <?php echo $client->id; ?></h2>
                    <?php
                    $cuser = User::find_by_id($client->userid);
                    ?>
                    <table class="table" style="width: 60%; margin-left: auto; margin-right: auto;">
                        <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td><?php echo $cuser->name; ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td><?php echo $cuser->emailadd; ?></td>
                        </tr>
                        <tr>
                            <td>Contact Number</td>
                            <td>:</td>
                            <td><?php echo $client->user_contact; ?></td>
                        </tr>
                        <tr>
                            <td>Sex</td>
                            <td>:</td>
                            <td><?php echo $client->gender; ?></td>
                        </tr>
                        <tr>
                            <td>No. of experience</td>
                            <td>:</td>
                            <td><?php echo $client->experience; ?></td>
                        </tr>
                        <tr>
                            <td>Highest Educational Attainment</td>
                            <td>:</td>
                            <td><?php echo $client->educ_attainment; ?></td>
                        </tr>
                        <tr>
                            <td>File Uploaded</td>
                            <td>:</td>
                            <td>
                                <form action="preview_pdf.php" method="POST" enctype="multipart/form-data">
                                    <a><?php echo $client->file_name ?></a>
                                    <input type="hidden" name="pngName" value="<?php echo $cuser->name; ?>">
                                    <input type="hidden" name="applicant_id" value="<?php echo $client->id; ?>">
                                    <input type="hidden" name="formFile" value="<?php echo $client->file_name; ?>">
                                    <button class="btn btn-info btn-sm" name="submit">Preview</button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>Application Status</td>
                            <td>:</td>
                            <td><?php echo $client->statusvalue[$client->status]; ?></td>
                        </tr>
                    </table>

                    <div class="d-grid gap-2 col-8 mx-auto">
                        <?php
                        if ($client->status == 40) {
                            
                        } else {
                            ?>
                            <form action="upload_application.php" method="post" class="row align-items-start">
                                <?php if ($client->status == 10) { ?>
                                    <a class="btn btn-sm btn-success" href="schedule_interview.php?clientid=<?php echo $client->id ?>&status=initial">Schedule for Initial Interview</a>
                                <?php } elseif ($client->status == 20) {
                                    ?>
                                    <a class="btn btn-sm btn-success"  href="schedule_interview.php?clientid=<?php echo $client->id ?>&status=final">Schedule for Final Interview</a>
                                <?php } elseif ($client->status == 30) {
                                    ?>
                                    <a class="btn btn-sm btn-success" href="upload_application.php?status=hired&clientid=<?php echo $client->id ?>">HIRE APPLICANT</a>
                                <?php }
                                ?>
                                <?php if ($client->status != 100) { ?>
                                    <br><br><a href="upload_application.php?clientid=<?php echo $client->id; ?>&status=reject" class="btn btn-sm btn-danger delete_product" data-id="<?php echo $client->id; ?>">Reject Application</a>
                                <?php } ?>
                            </form>
                        <?php } ?>
                    </div>
                </div>

                <!-- CONTENT-BOTTOM / FOOTER -->
                <div>

                </div>
            </div>

        </div>

        <script src="./public/jquery.min.js"></script>
        <script src="./public/bootstrap/js/bootstrap.min.js"></script>
        <script src="./public/sweet_alert/sweetalert2.min.js"></script>
        <script src="./public/sweetalert.js"></script>

    </body>
</html>
