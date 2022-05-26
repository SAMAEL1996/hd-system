<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once './includes/init.php';
?>
<html>
    <head>
        <?php
        include './spinoffs/head.php';
        ?>
    </head>
    <body class="antialiased">
        <?php
        $id = $session->getuserid();
        $user = User::find_by_id($id);
        ?>

        <?php
        include './spinoffs/header-client.php';

        include './spinoffs/insert-cv.php';
        ?>

        <?php
        $msg = filter_input(INPUT_GET, "msg", FILTER_SANITIZE_STRING);
        ?>

        <div class="container pt-3" style="text-transform:uppercase;">
            <?php
            $client = ApplicantProfile::find_by_userid($user->userid);
            if (empty($client)) {
                ?>
                Application status: <span class="text-danger">*No applications yet.</span>
                <?php
            } else {
                $sched = Schedule::find_by_clientid($client->id);
                ?>
                YOUR APPLICATION STATUS: <br>
                <?php
                if ($client->status == 10) {
                    ?>
                    <span class="text-primary ms-5">Application submitted. Please wait for company's response.</span>
                    <?php
                } elseif ($client->status == 20) {
                    ?>
                    <span class="text-primary ms-5">FOR INITIAL INTERVIEW</span> @ <?php echo date("F j, Y, g:i a", strtotime($sched->sched_date)); ?>
                    <?php
                } elseif ($client->status == 30) {
                    ?>
                    <span class="text-primary ms-5">FOR FINAL INTERVIEW</span> @ <?php echo date("F j, Y, g:i a", strtotime($sched->sched_date)); ?>
                    <?php
                } elseif ($client->status == 40) {
                    ?>
                    <span class="text-success ms-5">HIRED</span>
                    <?php
                } elseif ($client->status == 100) {
                    ?>
                    <span class="text-primary ms-5">APPLICATION REJECTED</span>
                    <?php
                }
                ?>
                <?php if ($msg) {
                    ?>
                    <div id="mydiv" class="alert alert-success" role="alert">
                        <?php echo $msg; ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>

        <?php
        $jobs = Job::find_all_active();
        if (empty($jobs)) {
            ?>
            <div class="container pt-3">
                <div class="card text-center">
                    <div class="card-header">
                        NO JOB VACANCY
                    </div>
                </div>
            </div>
            <?php
        }
        $num = 1;

        foreach ($jobs as $job) {
            $num += 1;
            ?>
            <div class="container pt-3">
                <div class="card text-center">
                    <div class="card-header" style="background-color: #FCF55F">
                        <?php echo $job->job; ?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-tite"><?php echo $job->title; ?></h5>
                        <button id="show_<?php echo $job->id;?>" onclick="show(this.id)" class="btn btn-outline-dark btn-sm btn-show-desc" type="button">Show Job Description</button>
                        <br>
                        <div id="blah_<?php echo $job->id; ?>" style="display: none">
                            <p class="card-text"><?php echo nl2br($job->description); ?></p>
                        </div><br>
                        <?php if (empty($client->jobid)) { ?>
                            <a href="application-form.php?jobid=<?php echo $job->id; ?>" class="btn btn-outline-dark col-md-4 ms-4">Apply Now</a>
                        <?php } elseif ($client->jobid == $job->id) {
                            ?>
                            <h3 class="card-text text-info fs-4">YOUR APPLICATION IS SUBMITTED</h3>
                        <?php } else { ?>
                            <?php if ($job->status == 20) { ?>
                                <h3 class="card-text text-danger fs-4">CLOSED APPLICATION</h3>
                            <?php } else { ?>
                                <a href="application-form.php?jobid=<?php echo $job->id; ?>" class="btn btn-outline-dark col-md-4 ms-4">Apply Now</a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="card-footer text-muted">
                        Last upload: <a class="fw-bold"><?php echo time_elapsed_string($job->date_created); ?></a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>

        <!--FOOTER-->
        <!--        <div class="container pt-0" style="background-color: white">
                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="facebook" viewBox="0 0 16 16">
                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                    </symbol>
                    <symbol id="instagram" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                    </symbol>
                    <symbol id="twitter" viewBox="0 0 16 16">
                        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                    </symbol>
                    </svg>
                    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
                        <div class="col-md-4 d-flex align-items-center">
                            <span class="text-muted">&copy; 2018 Mindwaves Advertising Philippines</span>
                        </div>
        
                        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                            <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"/></svg></a></li>
                            <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"/></svg></a></li>
                            <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"/></svg></a></li>
                        </ul>
                    </footer>
                </div>-->
        <script src="./public/js/fadeDIV.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <script type="text/javascript">
            function show(id)
            {
                var arr = id.split('_');
                var x = $("#blah_"+arr[1]);
                if (x.is(':hidden')) {
                    x.fadeIn('fast');
                } else {
                    x.fadeOut('fast');
                }
            }
//            $(".btn-show-desc").click(function () {
//                var id = $(this).attr('id');
//                var n = id.replace("show", '');
//                $("#blah" + n).hide();
//            });
        </script>
    </body>
</html>
