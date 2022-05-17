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
            $jobid = filter_input(INPUT_GET, "jobid", FILTER_VALIDATE_INT);
            $job = Job::find_by_id($jobid);
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
            <div id="content" style="float: left; width: 86%; height:100%; overflow-y: auto">
                <!-- CONTENT-TOP -->
                <div class="p-3">
                    <h2 style="border-bottom: 1px solid gray; margin-bottom: 50px;">Job #<?php echo $job->id; ?></h2>
                    <table class="table" style="width: 60%">
                        <tr>
                            <td>Job</td>
                            <td>:</td>
                            <td><?php echo $job->job; ?></td>
                        </tr>
                        <tr>
                            <td>Title</td>
                            <td>:</td>
                            <td><?php echo $job->title; ?></td>
                        </tr>
                        <tr>
                            <td>Date created</td>
                            <td>:</td>
                            <td><?php echo date('F d, Y', strtotime($job->date_created)); ?></td>
                        </tr>
                        <tr>
                            <td>Job Status</td>
                            <td>:</td>
                            <td>
                                <?php echo $job->statusvalue[$job->status]; ?>
                                <?php if ($job->status == 10) { ?>
                                    <a href="upload_application.php?jobcloseid=<?php echo $job->id; ?>" class="btn btn-sm btn-danger close_hiring ms-4" data-id="<?php echo $job->id; ?>">Close Hiring</a>
                                <?php } elseif ($job->status == 20) { ?>
                                    <a href="upload_application.php?jobopenid=<?php echo $job->id; ?>" class="btn btn-sm btn-primary open_hiring ms-4" data-id="<?php echo $job->id; ?>">Open Hiring</a>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Job Description</td>
                            <td>:</td>
                            <td><?php echo nl2br($job->description); ?></td>
                        </tr>
                    </table>
                    <div style="text-align: right; padding-right: 20px">
                        <div class="col-6 col-sm-3">
                            
                        </div>
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
        <script src="./public/job.js"></script>
        <script src="./public/job_1.js"></script>

    </body>
</html>
