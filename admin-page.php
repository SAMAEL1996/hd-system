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
        <style>
            @import url('https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap');

            table {
                --bs-body-font-family: 'PT Sans Narrow', sans-serif;
            }

            .block-content {
                display: block;
            }
            .block-content h1 {
                color: black;
            }
            a:hover::before,
            a:focus::before {
                transform: scaleX(1);
            }
            a{
                transition: color 300ms ease-in-out;
                z-index: 1;
            }
            a:hover,
            a:focus {
                color: white;
                text-decoration: none;
            }
        </style>
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

            <?php
            $employees = ApplicantProfile::count_record_by_sql("select count(*) from applicant_profile where status=40");
            $applicants = ApplicantProfile::count_record_by_sql("select count(*) from applicant_profile where not status=40 and not status=100");
            $files = ApplicantProfile::count_record_by_sql("select count(*) from applicant_profile where file_name is not null");
            $jobs = Job::count_record_by_sql("select count(*) from jobs where status=10");
            $rejected = ApplicantProfile::count_record_by_sql("select count(*) from applicant_profile where status=100");
            ?>

            <!-- CONTENT -->
            <div id="content" style="float: left; width: 1090px; height:627px; overflow-y: auto">
                <!-- CONTENT-TOP -->
                <div class="p-3">
                    ADMINISTRATOR DASHBOARD 
                </div>

                <!-- CONTENT-BOTTOM / FOOTER -->
                <div class="p-3">
                    <div class="row pb-5">
                        <div class="col-sm-4">
                            <div class="card block-content" style="width: 21rem; border-right: 10px solid #232C27">
                                <a href="employees.php">
                                    <div class="card-body">
                                        <h1 class="card-title text-center"><?php echo empty($employees) ? '0' : $employees ?></h1>
                                        <h4 class="card-subtitle mb-2 text-muted text-center">Employees</h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card block-content" style="width: 21rem; border-right: 10px solid #284854">
                                <a href="applicants.php">
                                    <div class="card-body">
                                        <h1 class="card-title text-center"><?php echo empty($applicants) ? '0' : $applicants ?></h1>
                                        <h4 class="card-subtitle mb-2 text-muted text-center">Applicants</h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card block-content" style="width: 21rem; border-right: 10px solid #D9A774">
                                <a href="history.php">
                                    <div class="card-body">
                                        <h1 class="card-title text-center"><?php echo empty($jobs) ? '0' : $jobs ?></h1>
                                        <h4 class="card-subtitle mb-2 text-muted text-center">Jobs</h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                $latestapplicants = ApplicantProfile::find_all_latest();
                $latestemployees = ApplicantProfile::find_all_hired();
                ?>
                <div class="p-3">
                    <div class="row pb-5">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header" style="background-color: #fdfd96">
                                    Latest Applicants
                                </div>
                                <table class="table" style="margin-bottom: 0">
                                    <thead class="text-uppercase text-center text-muted">
                                        <tr>
                                            <th class="fw-bolder" style="border-right: #e5e4e2 1px ridge">Name</th>
                                            <th class="fw-bolder" style="border-right: #e5e4e2 1px ridge">Email</th>
                                            <th class="fw-bolder">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fst-italic">
                                        <?php
                                        foreach ($latestapplicants as $latestapplicant) {
                                            $user = User::find_by_id($latestapplicant->userid);
                                        ?>
                                            <tr style="background-color: #e5e4e2">
                                                <td><small><a href="view-applicant.php?clientid=<?php echo $latestapplicant->id; ?>"><?php echo $user->name; ?></a></small></td>
                                                <td class="text-center"><small><?php echo $user->emailadd; ?></small></td>
                                                <td class="text-center"><small><?php echo time_elapsed_string($latestapplicant->created_at); ?></small></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header" style="background-color: #fdfd96">
                                    Latest Hired Employees
                                </div>
                                <table class="table" style="margin-bottom: 0">
                                    <thead class="text-uppercase text-center text-muted">
                                        <tr>
                                            <th class="fw-bolder" style="border-right: #e5e4e2 1px ridge">Name</th>
                                            <th class="fw-bolder" style="border-right: #e5e4e2 1px ridge">Position</th>
                                            <th class="fw-bolder">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fst-italic">
                                        <?php
                                        foreach ($latestemployees as $latestemployee) {
                                            $user = User::find_by_id($latestemployee->userid);
                                            $job = Job::find_by_id($latestemployee->jobid);
                                        ?>
                                            <tr style="background-color: #e5e4e2">
                                                <td><small><a href="view-applicant.php?clientid=<?php echo $latestemployee->id; ?>"><?php echo $user->name; ?></a></small></td>
                                                <td class="text-center"><small><?php echo $job->job; ?></small></td>
                                                <td class="text-center"><small><?php echo time_elapsed_string($latestapplicant->created_at); ?></small></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </body>
</html>
