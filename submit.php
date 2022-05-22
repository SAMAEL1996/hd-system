<?php

require_once './includes/init.php';

date_default_timezone_set("Asia/Manila");
$register = filter_input(INPUT_POST, "register", FILTER_SANITIZE_STRING);
if (isset($register)) {
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
    $password_confirmation = filter_input(INPUT_POST, "password_confirmation", FILTER_SANITIZE_STRING);

    if ($password == $password_confirmation) {
        $sql = "select * from useraccounts where emailadd='" . $email . "'";
        $users = User::find_by_sql($sql);
        if (empty($users)) {
            $user = new User();
            $user->name = $name;
            $user->emailadd = $email;
            $pwsh2 = sha1($password);
            $pwcr2 = crypt($pwsh2, "us");
            $pwcr12 = substr($pwcr2, 2);
            $user->password = $pwcr12;
            $random_number = rand(100000, 999999);
            $usertype = 20;
            $user->usertype = $usertype;
            $user->recadddate = date("Y-m-d H:i:s");
            if ($user->create()) {
                $successreg = "Signup successful.";
                redirect_to_root("login.php?successreg=$successreg");
            }
        } else {
            $msg = "Email already registered. Register new email or login old email.";
            redirect_to_root("register.php?msg=$msg");
        }
    } else {
        $msg = "Password not match.";
        redirect_to_root("register.php?msg=$msg");
    }
}

$resetpassword = filter_input(INPUT_POST, "resetpassword", FILTER_SANITIZE_STRING);
if (isset($resetpassword)) {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
    $password_confirmation = filter_input(INPUT_POST, "password_confirmation", FILTER_SANITIZE_STRING);

    $user = User::find_by_email($email);
    if (!empty($user)) {
        // User exist
        if ($password == $password_confirmation) {
            $pwsh2 = sha1($password);
            $pwcr2 = crypt($pwsh2, "us");
            $pwcr12 = substr($pwcr2, 2);
            $user->password = $pwcr12;  
            if ($user->update()) {
                $successreg = "Reset password successful.";
                redirect_to_root("login.php?successreg=$successreg");
            }
        } else {
            $passauth = true;
            return $passauth;
        }
    } else {
        // User not exist
        $passauth = true;
        return $passauth;
    }
}