<?php

require_once './includes/init.php';

$session->logoutuser();
redirect_to_root("index.php");