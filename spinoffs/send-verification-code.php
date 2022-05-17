<?php

require_once './includes/init.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$sendcode = filter_input(INPUT_POST, "sendcode", FILTER_SANITIZE_STRING);
if (isset($sendcode)) {

    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $checkEmailadd = User::check_if_emailaddress_exists($email);
    if ($checkEmailadd = TRUE) {
        $user = User::find_by_email($email);


        //Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer();

        try {
            //Enable verbose debug output
            $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;
            
            //Send using SMTP
            $mail->isSMTP();

            //Set the SMTP server to send through smtp.gmail.com
            //$mail->Host = 'smtp.mailtrap.io';
            $mail->Host = 'smtp.gmail.com';

            //Enable SMTP authentication
            $mail->SMTPAuth = true;

            //Enable TLS encryption;
            $mail->SMTPSecure = 'tls';

            //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->Port = 587;

            //SMTP username
            $mail->Username = 'rportilano@pcu.edu.ph';
            
            //SMTP password
            $mail->Password = 'samael2020';

            //Recipients
            $mail->setFrom('rportilano@pcu.edu.ph', 'Mindwaves Advertising Philippines');

            //Add a recipient
            $mail->addAddress($email, $user->name);

            //Set email format to HTML
            $mail->isHTML(true);

            $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

            $mail->Subject = 'Email verification';
            $mail->Body = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';

            $mail->send();
            // echo 'Message has been sent';
            // insert in users table
            $reset = new ResetPassword();
            $reset->email = $email;
            $reset->verification_code = $verification_code;
            $reset->created_at = date("Y-m-d H:i:s");
            $reset->create();

            $successreg = "Send verification code successful.";
            redirect_to_root("reset-password.php?successreg=$successreg");
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $errorlogin = "Send verification code failed. Email not found.";
        redirect_to_root("reset-password.php?errorlogin=$errorlogin");
    }
}


$verifycode = filter_input(INPUT_POST, "verifycode", FILTER_SANITIZE_STRING);
if (isset($verifycode)) {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $code = filter_input(INPUT_POST, "code", FILTER_VALIDATE_INT);
    
    $user = ResetPassword::authenticateCode($email, $code);
    if($user == true) {
        $authenticate = true;
        return $authenticate;
    } else {
        $errorauth = "Verification code failed. Email and code not verify.";
        redirect_to_root("reset-password.php?errorauth=$errorauth");
    }
}