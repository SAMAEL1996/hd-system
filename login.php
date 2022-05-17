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
        $successreg = filter_input(INPUT_GET, "successreg", FILTER_SANITIZE_STRING);
        $errorlogin = filter_input(INPUT_GET, "errorlogin", FILTER_SANITIZE_STRING);

        $login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_STRING);
        if (isset($login)) {
            $msg = "";
            $emailadd = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

            $pw = trim($password);
            $users = User::authenticate($emailadd, $pw);
            if ($users) {
                $session->loginuser($users);
                if($session->getusertype() == 20) {
                    redirect_to_root("client-page.php");
                } elseif ($session->getusertype() == 10) {
                    redirect_to_root("admin-page.php");
                } else {
                    $errorlogin = "Error login. User type not found.";
                    redirect_to_root("register.php?errorlogin=$errorlogin");
                }
            } else {
                $msg = "Error login. Please try again.";
            }
        }
        ?>
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <?php
                        if (isset($msg)) {
                            ?>
                        <div id="mydiv" class="alert alert-danger" role="alert">
                                <?php echo $msg; ?>
                            </div>
                            <?php
                        }
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
                        ?>
                        <div class="card">
                            <div class="card-header">Login</div>

                            <div class="card-body">
                                <form method="POST" action="login.php">
                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>
                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                                        </div>
                                    </div>

                                    <div class="row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" name="login" class="btn btn-primary">Login</button>
                                            Forgot password? <a class="btn-link" href="reset-password.php">Click here</a>
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
