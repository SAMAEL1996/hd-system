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
            <div id="content" style="float: left; width: 1116px; height:627px; overflow-y: auto">
                <!-- CONTENT-TOP -->
                <div class="p-2">
                    
                </div>

                <!-- CONTENT-BOTTOM / FOOTER -->
                <div>
                    <div class="p-3">
                        <h1 style="border-bottom: 1px solid gray; margin-bottom: 50px">Reject History</h1>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $clients = ApplicantProfile::find_all_inactive_status();
                                if (empty($clients)) {
                                    
                                }
                                
                                foreach ($clients as $client) {
                                    $cuser = User::find_by_id($client->userid);
                                ?>
                                <tr>
                                    <td><?php echo $cuser->name ?></td>
                                    <td><?php echo $cuser->emailadd ?></td>
                                    <td><?php echo $client->user_contact ?></td>
                                    <td class="text-danger"><?php echo $client->statusvalue[$client->status]; ?></td>
                                    <td>
                                        <a href="view-applicant.php?clientid=<?php echo $client->id; ?>">View</a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </body>
</html>
