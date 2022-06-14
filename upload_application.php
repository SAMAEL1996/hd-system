<?php

require_once './includes/init.php';

include("vendor/autoload.php");

use \ConvertApi\ConvertApi;

ConvertApi::setApiSecret('KlnyBgyQylCoblzT');

// clint save profile
$submitprofile = filter_input(INPUT_POST, "submitprofile", FILTER_SANITIZE_STRING);
if (isset($submitprofile)) {
    $userid = filter_input(INPUT_POST, "userid", FILTER_VALIDATE_INT);
    $jobid = filter_input(INPUT_POST, "jobid", FILTER_VALIDATE_INT);
    $user_address = filter_input(INPUT_POST, "user_address", FILTER_SANITIZE_STRING);
    $user_contact = filter_input(INPUT_POST, "user_contact", FILTER_SANITIZE_STRING);
    $gender = filter_input(INPUT_POST, "gender", FILTER_SANITIZE_STRING);
    $experience = filter_input(INPUT_POST, "experience", FILTER_VALIDATE_INT);
    $educ_attainment = filter_input(INPUT_POST, "educ_attainment", FILTER_SANITIZE_STRING);
    $birthdate = filter_input(INPUT_POST, "birthdate", FILTER_SANITIZE_STRING);
    $cover_letter = filter_input(INPUT_POST, "cover_letter", FILTER_SANITIZE_STRING);
    $filename = $_FILES['file']['name'];
    
    $user = User::find_by_id($userid);

    //upload file
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $allowed = ['pdf'];

    //check if file type is valid
    if (in_array($ext, $allowed)) {
        //set target directory
        $path = 'uploads/';

        move_uploaded_file($_FILES['file']['tmp_name'], ($path . $filename));
        $result = ConvertApi::convert(
                'png', [
            'File' => $path . $filename,
                ], 'pdf'
        );
        $contents = $result->getFile()->getContents();
        $output = "converted_files/" . $user->name . ".png";
        $fopen = fopen($output, "w");
        fwrite($fopen, $contents);
        fclose($fopen);

        // insert file details into database
        $profile = new ApplicantProfile();
        $profile->userid = $userid;
        $profile->jobid = $jobid;
        $profile->user_address = $user_address;
        $profile->user_contact = $user_contact;
        $profile->gender = $gender;
        $profile->experience = $experience;
        $profile->educ_attainment = $educ_attainment;
        $profile->birthdate = $birthdate;
        $profile->created_at = date("Y-m-d H:i:s");
        $profile->status = 10;
        $profile->file_name = $filename;
        if ($profile->create()) {
            $msg = "Submit profile successful!";
            redirect_to_root("client-page.php?msg=$msg");
        } else {
            $msg = "Error submittion!";
            redirect_to_root("client-page.php?msg=$msg");
        }
    } else {
        redirect_to_root("application-form.php?jobid=$jobid");
    }
}

// update profile user
$saveUser = filter_input(INPUT_POST, "saveUser", FILTER_SANITIZE_STRING);
if (isset($saveUser)) {
    $userid = filter_input(INPUT_POST, "userid", FILTER_VALIDATE_INT);
    $gender = filter_input(INPUT_POST, "gender", FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_STRING);
    $mobileno = filter_input(INPUT_POST, "mobileno", FILTER_SANITIZE_STRING);
    $birthday = filter_input(INPUT_POST, "birthday", FILTER_SANITIZE_STRING);

    $user = User::find_by_id($userid);
    if (!empty($user)) {
        if (!empty($gender)) {
            $user->gender = $gender;
        }
        if (!empty($address)) {
            $user->address = $address;
        }
        if (!empty($mobileno)) {
            $user->mobileno = $mobileno;
        }
        if (!empty($birthday)) {
            $user->birthday = $birthday;
        }
        if ($user->update()) {
            redirect_to_root("profile.php?saveporfile=1");
        }
    }
}

// change password from profile.php
$changePassword = filter_input(INPUT_POST, "changePassword", FILTER_SANITIZE_STRING);
if (isset($changePassword)) {
    $userid = filter_input(INPUT_POST, "userid", FILTER_VALIDATE_INT);
    $password = filter_input(INPUT_POST, "password", FILTER_VALIDATE_INT);
    $newpassword = filter_input(INPUT_POST, "newpassword", FILTER_SANITIZE_STRING);

    $user = User::authenticate_password($userid, $password);
    if ($user) {
        $user->gender = $gender;
        $user->address = $address;
        $user->mobileno = $mobileno;
        $user->birthday = $birthday;
        if ($user->update()) {
            redirect_to_root("profile.php");
        }
    } else {
        redirect_to_root("profile.php?errorpass=1");
    }
}


$initial = filter_input(INPUT_POST, "initial", FILTER_SANITIZE_STRING);
if (isset($initial)) {
    $clientid = filter_input(INPUT_POST, "clientid", FILTER_VALIDATE_INT);
    $client = ApplicantProfile::find_by_id($clientid);
    if (!empty($client)) {
        $client->status = 20;
        if ($client->update()) {
            redirect_to_root("view-applicant.php?clientid=$clientid");
        }
    }
}

$status = filter_input(INPUT_GET, "status", FILTER_SANITIZE_STRING);
$clientid = filter_input(INPUT_GET, 'clientid', FILTER_VALIDATE_INT);
if ($status == "hired") {
    $clforhire = ApplicantProfile::find_by_id($clientid);
    if (!empty($clforhire)) {
        $clforhire->status = 40;
        if ($clforhire->update()) {
            redirect_to_root("view-applicant.php?clientid=$clientid");
        }
    }
} elseif ($status == "reject") {
    $client = ApplicantProfile::find_by_id($clientid);
    if (!empty($client)) {
        $client->status = 100; //100=rejected
        if ($client->update()) {
            redirect_to_root("view-applicant.php?clientid=$clientid");
        }
    }
}

$jobcloseid = filter_input(INPUT_GET, 'jobcloseid', FILTER_VALIDATE_INT);
if ($jobcloseid) {
    $job = Job::find_by_id($jobcloseid);
    if (!empty($job)) {
        $job->status = 20; //20=closed
        if ($job->update()) {
            redirect_to_root("view-job.php?jobid=$jobcloseid");
        }
    }
}

$jobopenid = filter_input(INPUT_GET, 'jobopenid', FILTER_VALIDATE_INT);
if ($jobopenid) {
    $job = Job::find_by_id($jobopenid);
    if (!empty($job)) {
        $job->status = 10; //10=open
        if ($job->update()) {
            redirect_to_root("view-job.php?jobid=$jobopenid");
        }
    }
}

$submitjob = filter_input(INPUT_POST, "submitjob", FILTER_SANITIZE_STRING);
if (isset($submitjob)) {
    $job = filter_input(INPUT_POST, "job", FILTER_SANITIZE_STRING);
    $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
    $jobDesc = $description;

    $existJob = Job::find_by_job($job, $title);
    if ($existJob == FALSE) {
        $jobOpen = new Job();
        $jobOpen->job = $job;
        $jobOpen->title = $title;
        $jobOpen->description = $jobDesc;
        $jobOpen->status = 10;
        $jobOpen->date_created = date("Y-m-d H:i:s");
        if ($jobOpen->create()) {
            redirect_to_root("job_open.php");
        }
    } else {
        $error = "Job position's already exist!";
        redirect_to_root("form.php?error=$error");
    }
}