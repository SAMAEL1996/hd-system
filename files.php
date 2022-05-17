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

            <div id="content" style="float: left; width: 85%; height:627px; overflow-y: auto">
                <!-- CONTENT-TOP -->
                <div class="p-3">
                    <h1 style="border-bottom: 1px solid gray; margin-bottom: 50px">Files</h1>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Applicant ID</th>
                                <th scope="col">Applicant Name</th>
                                <th scope="col">Date Applied</th>
                                <th scope="col">File Uploaded</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $num = 1;
                            $applicants = ApplicantProfile::find_all();
                            if (empty($clients)) {
                                
                            }

                            foreach ($applicants as $applicant) {
                                $cuser = User::find_by_id($applicant->userid);
                                ?>
                                <tr>
                                    <td><?php echo $num ?></td>
                                    <td><?php echo $cuser->iduser ?></td>
                                    <td><?php echo $cuser->name ?></td>
                                    <td><?php echo date('F d, Y H:i:s', strtotime($applicant->created_at)); ?></td>
                                    <td>
                                        <a href="uploads/<?php echo $applicant->file_name; ?>" download><?php echo $applicant->file_name ?></a>
                                    </td>
                                </tr>
                                <?php
                                $num = $num + 1;
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
