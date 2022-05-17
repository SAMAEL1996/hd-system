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
            <div id="content" style="float: left; width: 85%; height:627px; overflow-y: auto">
                <!-- CONTENT-TOP -->
                <div class="p-3">
                    <div class="bg-body-light">
                        <div class="content content-full">
                            <div class="d-flex flex-column justify-content-sm-between" style="border-bottom: 1px solid gray; margin-bottom: 50px">
                                <h1 class="float-start my-2">Job Open</h1>

                            </div>
                        </div>
                    </div>
                    <div class="mb-3" style="width: 100%; text-align: right;">
                        <a href="form.php" class="btn btn-primary btn-sm mr-1"><i class="si si-plus"></i>Add new</a>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Date created</th>
                                <th scope="col">Job Title</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $num = 0;
                            $jobs = Job::find_all();
                            if (empty($jobs)) {
                                
                            } else {
                                foreach ($jobs as $job) {
                                    $num ++;
                                    ?>
                                    <tr>
                                        <td><?php echo $num ?></td>
                                        <td><?php echo date('F d, Y', strtotime($job->date_created)) ?></td>
                                        <td><?php echo $job->title ?></td>
                                        <td><?php echo $job->statusvalue[$job->status]; ?></td>
                                        <td>
                                            <a href="view-job.php?jobid=<?php echo $job->id; ?>">View</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- CONTENT-BOTTOM / FOOTER -->
                <div>

                </div>
            </div>

        </div>

    </body>
</html>
