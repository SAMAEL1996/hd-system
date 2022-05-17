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
        ?>

        <main class="py-5">
            <div class="container" style="width: 100%">
                <?php
                $sql = "select * from applicant_profile where userid='" . $user->userid . "'";
                $appuser = ApplicantProfile::find_by_sql($sql);
                foreach ($appuser as $au) {
                    ?>
                    <a href="uploads/<?php echo $au->file_name; ?>" download><?php echo $au->file_name ?></a><br>
                <?php } ?>
            </div>
        </main>

        <!--FOOTER-->
        <?php
        include './spinoffs/footer.php';
        ?>
    </body>
</html>
