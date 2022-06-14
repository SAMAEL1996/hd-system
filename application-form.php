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
        $jobid = filter_input(INPUT_GET, "jobid", FILTER_VALIDATE_INT);
        ?>

        <main class="py-5">
            <div class="container pb-5" style="width: 100%">
                <div class="col">
                    <div class="mb-3 d-flex justify-content-center align-items-center fw-bold fs-4 py-2 text-white" style="background-color:#2f4f4f">APPLICATION FORM</div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="frm-result">
                            <?php
                            $job = Job::find_by_id($jobid);
                            ?>
                            <form method="post" action="upload_application.php" enctype="multipart/form-data">
                                <div class="mb-3 d-flex justify-content-center align-items-center fw-bold">Create Profile</div>
                                <div class="mb-3 d-flex justify-content-center align-items-center">
                                    <span class="fs-5">You are applying for a position of <a class="fw-bold"><?php echo " " . $job->job; ?></a></span>
                                    <input type="hidden" name="jobid" value="<?php echo $job->id ?>">
                                </div>
                                <div class="mb-3">
                                    <input type="text" value="<?php echo $user->name ?>" class="form-control" placeholder="Name" required>
                                    <input type="hidden" name="userid" value="<?php echo $user->userid ?>">
                                </div>
                                <div class="mb-3">
                                    <input type="email" value="<?php echo $user->emailadd ?>" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="user_address" class="form-control" placeholder="Home Address" required>
                                </div>
                                <div class="mb-3">
                                    <input type="tel" class="form-control" name="user_contact" placeholder="Phone Number (format: 09********)" pattern="[0-9]{11}" onkeyup="numbersOnly(this)" required>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check-inline">
                                        Sex: 
                                    </div>
                                    <!-- GENDER / radio button -->

                                    <div class="form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="Male" id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Male
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="Female" id="flexRadioDefault2">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Female
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input type="number" name="experience" class="form-control" placeholder="No. of Experience" required>
                                </div>
                                <div class="mb-3">
                                    <!-- Highest Educ Attainment / dropdown -->
                                    <select class="form-select" name="educ_attainment" aria-label="Default select example">
                                        <option selected>Highest Educational Attainment</option>
                                        <option value="No grade complete">No grade complete</option>
                                        <option value="Pre-school">Pre-school</option>
                                        <option value="Elementary">Elementary</option>
                                        <option value="High School">High School</option>
                                        <option value="Post Secondary">Post Secondary</option>
                                        <option value="College Undergraduate">College Undergraduate</option>
                                        <option value="Academic Degree Holder">Academic Degree Holder</option>
                                        <option value="Post Baccalaureate">Post Baccalaureate</option>
                                    </select>
                                </div>
                                <div class="mb-3 justify-content-center align-items-center">
                                    <input class="form-control float-start hidden" name="file" type="file" id="formFile" accept=".pdf" placeholder="Upload CV" required>
                                    <br><a class="fs-6 text-decoration-none text-muted">.pdf file type only</a>
                                </div>
                                <div class="mb-3 d-flex justify-content-center align-items-center">
                                    <input type="submit" name="submitprofile" value="Submit Profile" class="btn btn-outline-dark col-md-4 ms-4">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!--FOOTER-->
        <div class="container">
            <footer class="align-items-center py-3 my-4 border-top">
                <div class="align-items-center text-center">
                    <span class="text-muted">&copy; 2018 Mindwaves Advertising Philippines</span>
                </div>
            </footer>
        </div>
        <script>
            function numbersOnly(input) {
                var number = /[^0-9]/gi;
                input.value = input.value.replace(number, "");
            }
        </script>
    </body>
</html>
