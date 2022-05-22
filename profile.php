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
        <div style="width: 100%; float: left">
            <?php
            if ($user->usertype == 10) {
                include './spinoffs/header-admin.php';
            } elseif ($user->usertype == 20) {
                include './spinoffs/header-client.php';
            }
            ?>
        </div>
        <div class="container light-grey padding-32 padding-large" style="display: block;">
            <div class="content" style="max-width: 600px;display: block; margin-left: auto; margin-right: auto;">
                <h2 class="center" style="padding-top: 100px; text-align: center!important;">
                    <b>Your Profile
                        <?php echo $user->usertypevalue[$user->usertype]?>
                    </b>
                </h2>
                <form method="post" action="upload_application.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="text" name="name" value="<?php echo $user->name; ?>" class="form-control" placeholder="Name" readonly>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="emailadd" value="<?php echo $user->emailadd; ?>" class="form-control" placeholder="Email" readonly>
                    </div>
                    <div class="mb-3">
                        <select class="form-select" name="gender" value="<?php echo $user->gender; ?>" aria-label="Default select example">
                            <option>Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="date" name="birthday" value="<?php echo $user->birthday; ?>" class="form-control" placeholder="Birthday">
                    </div>
                    <div class="mb-3">
                        <input type="number" name="mobileno" maxlength="11" 
                               oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                               class="form-control" placeholder="Mobile No.">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="address" value="<?php echo $user->address; ?>" class="form-control" placeholder="Address">
                    </div>
                    <div class="mb-3 d-flex justify-content-center align-items-center">
                        <input type="hidden" name="userid" value="<?php echo $user->userid; ?>">
                        <input type="submit" name="saveUser" value="Save Profile" class="btn btn-outline-dark col-md-4 ms-4">
                    </div>
                </form>

                <h4 class="center" style="padding-top: 10px; text-align: center!important;">
                    <a>Change Password</a>
                </h4>
                <form method="post" action="upload_application.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Current Password">
                    </div>
                    <div class="mb-3">
                        <input type="password" name="newpassword" class="form-control" placeholder="New Password" required>
                    </div>
                    <div class="mb-3 d-flex justify-content-center align-items-center">
                        <input type="hidden" name="userid" value="<?php echo $user->userid; ?>">
                        <input type="submit" name="changePassword" value="Save New Password" class="btn btn-outline-dark col-md-4 ms-4" required>
                    </div>
                </form>
            </div>
        </div>
        <?php if (isset($_GET['errorpass'])) { ?>
            <div class="flash-data" data-flashdata="<?php echo $_GET['errorpass'] ?>"></div>
        <?php } elseif (isset($_GET['saveporfile'])) { ?>
            <div class="flash-data1" data-flashdata1="<?php echo $_GET['saveporfile'] ?>"></div>
        <?php } ?>
        <script src="./public/jquery.min.js"></script>
        <script src="./public/bootstrap/js/bootstrap.min.js"></script>
        <script src="./public/sweet_alert/sweetalert2.min.js"></script>
        <script>
            const flashdata = $('.flash-data').data('flashdata')
            if (flashdata) {
                swal.fire({
                    type: 'error',
                    icon: 'danger',
                    title: 'Error Password',
                    text: 'Password not match to your data.'
                })
            }
            const flashdata1 = $('.flash-data1').data('flashdata1')
            if (flashdata1) {
                swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: 'Save Profile',
                    text: 'Successfully update profile.'
                })
            }
        </script>
    </body>
</html>
