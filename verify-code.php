<?php

require_once './includes/init.php';

$verifycode = filter_input(INPUT_POST, "verifycode", FILTER_SANITIZE_STRING);
if (isset($verifycode)) {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $code = filter_input(INPUT_POST, "code", FILTER_VALIDATE_INT);
    
    $user = ResetPassword::authenticateCode($email, $code);
    if($user == true) {
        $authenticate = true;
        redirect_to_root("createNewPass.php?authenticate=$authenticate");
    } else {
        $errorauth = "Verification code failed. Email and code not verify.";
        redirect_to_root("reset-password.php?errorauth=$errorauth");
    }
}