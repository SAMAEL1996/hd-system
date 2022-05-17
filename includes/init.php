<?php
defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);

defined("SITE_ROOT") ? null : define("SITE_ROOT", ".");
defined("LIB_PATH") ? null : define("LIB_PATH", SITE_ROOT . DS . "includes");
defined("IMGDIR") ? null : define("IMGDIR", SITE_ROOT . DS . "public" . DS . "images");


require_once(LIB_PATH . DS . 'config.php');
require_once(LIB_PATH . DS . 'database.php');
require_once(LIB_PATH . DS . 'functions.php');
require_once(LIB_PATH . DS . 'Google_Oauth_URL.php');


require_once(LIB_PATH . DS . 'User.php');
require_once(LIB_PATH . DS . 'Session.php');
require_once(LIB_PATH . DS . 'Applicant.php');
require_once(LIB_PATH . DS . 'ApplicantProfile.php');
require_once(LIB_PATH . DS . 'Schedule.php');
require_once(LIB_PATH . DS . 'ResetPassword.php');
require_once(LIB_PATH . DS . 'Job.php');

require_once(LIB_PATH . DS . 'Exception.php');
require_once(LIB_PATH . DS . 'SMTP.php');
require_once(LIB_PATH . DS . 'PHPMailer.php');


defined("TIMEADJFACTOR") ? null : define("TIMEADJFACTOR", 0); 

/*
defined("MINFILESIZE") ? null : define("MINFILESIZE", 10000); //10kB
defined("MAXFILESIZE") ? null : define("MAXFILESIZE", 4000000); //200kB
defined("MINFILESIZEPDF") ? null : define("MINFILESIZEPDF", 100); //100B
defined("MAXFILESIZEPDF") ? null : define("MAXFILESIZEPDF", 4000000); //200kB
 */