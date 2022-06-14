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
                    <h1 style="border-bottom: 1px solid gray; margin-bottom: 50px">Schedules</h1>
                    <table class="table">
                        <thead>
                            <tr style="background-color: #fdfd96">
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col">Schedule</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $scheds = Schedule::find_all();
                            if (empty($scheds)) {
                                
                            }

                            foreach ($scheds as $sched) {
                                $app = ApplicantProfile::find_by_id($sched->clientid);
                                $cuser = User::find_by_id($app->userid);
                                ?>
                                <tr>
                                    <td><?php echo $cuser->name ?></td>
                                    <td><?php echo $cuser->emailadd ?></td>
                                    <td><?php echo $app->statusvalue[$app->status]; ?></td>
                                    <td>
                                        <?php echo date("F j, Y", strtotime($sched->sched_date)); ?>
                                    </td>
                                </tr>
                            <?php } ?>
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
