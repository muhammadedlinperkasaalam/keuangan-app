<?php
require dirname(__DIR__) . '/includes/init.php';
redirect(is_logged_in() ? 'dahsboard/' : 'auth/login.php');