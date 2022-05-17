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
            .card {
                display: block;
            }
            .card h1 {
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
                            <div class="card btn-background-slides" style="width: 18rem; border-right: 10px solid #232C27">
                                <a href="employees.php">
                                    <div class="card-body">
                                        <h1 class="card-title text-center"><?php echo empty($employees) ? '0' : $employees ?></h1>
                                        <h4 class="card-subtitle mb-2 text-muted text-center">Employees</h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card" style="width: 18rem; border-right: 10px solid #284854">
                                <a href="applicants.php">
                                    <div class="card-body">
                                        <h1 class="card-title text-center"><?php echo empty($applicants) ? '0' : $applicants ?></h1>
                                        <h4 class="card-subtitle mb-2 text-muted text-center">Applicants</h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card" style="width: 18rem; border-right: 10px solid #60747C">
                                <a href="files.php">
                                    <div class="card-body">
                                        <h1 class="card-title text-center"><?php echo empty($files) ? '0' : $files ?></h1>
                                        <h4 class="card-subtitle mb-2 text-muted text-center">Files</h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="row pb-5">
                        <div class="col-sm-4">
                            <div class="card" style="width: 18rem; border-right: 10px solid #B2B8AA">
                                <a href="job_open.php">
                                    <div class="card-body">
                                        <h1 class="card-title text-center"><?php echo empty($jobs) ? '0' : $jobs ?></h1>
                                        <h4 class="card-subtitle mb-2 text-muted text-center">Job Open</h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card" style="width: 18rem; border-right: 10px solid #D9A774">
                                <a href="history.php">
                                    <div class="card-body">
                                        <h1 class="card-title text-center"><?php echo empty($rejected) ? '0' : $rejected ?></h1>
                                        <h4 class="card-subtitle mb-2 text-muted text-center">Rejected</h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </body>
</html>
