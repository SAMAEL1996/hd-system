<?php

defined("GOOGLE_CLIENT_ID")   ? null : define("GOOGLE_CLIENT_ID", "234448115896-65f76dotpskot9bs52l71e8bvt9tjsdo.apps.googleusercontent.com");
defined("GOOGLE_CLIENT_SECRET") ? null : define("GOOGLE_CLIENT_SECRET", "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");
defined("GOOGLE_OAUTH_SCOPE") ? null : define("GOOGLE_OAUTH_SCOPE", "https://www.googleapis.com/auth/drive");
defined("REDIRECT_URI") ? null : define("REDIRECT_URI", "http://localhost/hiringdev/upload_applicaiton.php");

$googleOathURL = "https://accounts.google.com/o/oauth2/auth?scope='".urlencode(GOOGLE_OAUTH_SCOPE)."'&redirect_uri='".REDIRECT_URI."'&response_type=code&client_id='".GOOGLE_CLIENT_ID."'&access_type=online";