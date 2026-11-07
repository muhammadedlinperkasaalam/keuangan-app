<?php
require dirname(__DIR__) . '/includes/init.php';
$_SESSION = [];
session_destroy();
redirect('auth/login.php');