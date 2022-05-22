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
        include './spinoffs/header.php';
        ?>

        <?php
        $emailadd = filter_input(INPUT_GET, "emailadd", FILTER_SANITIZE_EMAIL);
        $successreg = filter_input(INPUT_GET, "successreg", FILTER_SANITIZE_STRING);
        $errorlogin = filter_input(INPUT_GET, "errorlogin", FILTER_SANITIZE_STRING);
        $errorauth = filter_input(INPUT_GET, "errorauth", FILTER_SANITIZE_STRING);
        $authenticate = filter_input(INPUT_GET, "authenticate", FILTER_SANITIZE_STRING);
        $authenticate = false;
        $passauth = false;
        $authmsg = "Verification successful.";
        $passauthmsg = "Password not match.";

        include './spinoffs/send-verification-code.php';
        ?>
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <?php
                        if ($authenticate == 1 || $passauth == true) {
                            ?>
                            <div id="mydiv" class="alert alert-success" role="alert">
                                <?php
                                if ($authenticate) {
                                    echo $authmsg;
                                } elseif ($passauth) {
                                    echo $passauthmsg;
                                }
                                ?>
                            </div>
                            <?php
                        } else {
                            if ($errorlogin) {
                                ?>
                                <div id="mydiv" class="alert alert-danger" role="alert">
                                    <?php echo $errorlogin; ?>
                                </div>
                                <?php
                            }
                            if ($successreg) {
                                ?>
                                <div id="mydiv" class="alert alert-success" role="alert">
                                    <?php echo $successreg; ?>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <div class="card">
                            <div class="card-header">Reset Password</div>

                            <div class="card-body">
                                    <form method="POST" action="submit.php">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <input id="email" type="hidden" class="form-control" name="email" value="<?php echo $emailadd; ?>" autofocus>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="password" class="col-md-4 col-form-label text-md-end">New Password</label>

                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control" name="password" required>

                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirm Password</label>

                                            <div class="col-md-6">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                            </div>
                                        </div>

                                        <div class="row mb-0">
                                            <div class="col-md-8 offset-md-4">
                                                <input type="submit" name="resetpassword" value="Submit Reset Password" class="btn btn-info">
                                            </div>
                                        </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php
        include './spinoffs/footer.php';
        ?>
        <script src="./public/js/fadeDIV.js"></script>
    </body>
</html>
