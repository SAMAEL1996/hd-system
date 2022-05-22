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
            $status = filter_input(INPUT_GET, "status", FILTER_SANITIZE_STRING);
            $client = ApplicantProfile::find_by_id($clientid);
            $cuser = User::find_by_id($client->userid);
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
            <div id="content" style="float: left; width: 85%; height:627px; overflow-y: auto">
                <!-- CONTENT-TOP -->
                <div class="p-3">
                    <h2 style="border-bottom: 1px solid gray; margin-bottom: 50px;">Schedule Interview</h2>
                    <div class="d-flex justify-content-center" style="width: 100%">
                        <form method="post">
                            <div class="mb-3">
                                <input type="text" class="form-control" value="<?php echo $cuser->name; ?>" readonly="">
                                <input type="hidden" name="clientid" class="form-control" value="<?php echo $client->id; ?>" readonly="">
                            </div>
                            <div class="mb-3">
                                <input type="text" name="action" class="form-control"  value="<?php echo ucfirst($status) . " Interview"; ?>" readonly="">
                                <input type="hidden" name="status" class="form-control" value="<?php echo $status; ?>" readonly="">
                            </div>
                            <div class="mb-3">
                                <?php
                                date_default_timezone_set('Asia/Manila');
                                ?>
                                <input type="datetime-local" name="sched_date" class="form-control">
                            </div>
                            <div class="mb-3 d-flex justify-content-center align-items-center">
                                <input type="submit" name="submitschedule" value="Submit Schedule" class="btn btn-outline-dark">
                            </div>
                        </form>
                        <?php
                        if ($status == "initial") {
                            $submitschedule = filter_input(INPUT_POST, "submitschedule", FILTER_SANITIZE_STRING);
                            if (isset($submitschedule)) {
                                $clientid = filter_input(INPUT_POST, "clientid", FILTER_VALIDATE_INT);
                                $action = filter_input(INPUT_POST, "action", FILTER_SANITIZE_STRING);
                                $sched_time = $_POST['sched_date'];

                                $sched = new Schedule();
                                $sched->clientid = $clientid;
                                $sched->action = $action;
                                $sched->sched_date = date("Y-m-d H:i:s", strtotime($sched_time));
                                if ($sched->create()) {
                                    $client = ApplicantProfile::find_by_id($clientid);
                                    if (!empty($client)) {
                                        $client->status = 20;
                                        if ($client->update()) {
                                            redirect_to_root("view-applicant.php?clientid=$clientid");
                                        }
                                    }
                                }
                            }
                        } elseif ($status == "final") {
                            $submitschedule = filter_input(INPUT_POST, "submitschedule", FILTER_SANITIZE_STRING);
                            if (isset($submitschedule)) {
                                $clientid = filter_input(INPUT_POST, "clientid", FILTER_VALIDATE_INT);
                                $action = filter_input(INPUT_POST, "action", FILTER_SANITIZE_STRING);
                                $sched_time = $_POST['sched_date'];

                                $sched = Schedule::find_by_clientid($clientid);
                                $sched->action = $action;
                                $sched->sched_date = date("Y-m-d H:i:s", strtotime($sched_time));
                                if ($sched->update()) {
                                    $client = ApplicantProfile::find_by_id($clientid);
                                    if (!empty($client)) {
                                        $client->status = 30;
                                        if ($client->update()) {
                                            redirect_to_root("view-applicant.php?clientid=$clientid");
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- CONTENT-BOTTOM / FOOTER -->
                <div>

                </div>
            </div>

        </div>
        <script>
            var today = new Date().toISOString().slice(0, 16);
            document.getElementsByName("sched_date")[0].min = today;
//            $(function () {
//                var dtToday = new Date();
//
//                var month = dtToday.getMonth() + 1;
//                var day = dtToday.getDate();
//                var year = dtToday.getFullYear();
//
//                $('#txtDate').attr('min', maxDate);
//            });
            </script>
    </body>
</html>
