<?php

// Error reporting setup
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/home/runner/movie-project/php-error.log'); // Adjust the path if necessary
error_reporting(E_ALL);

// Session configuration
ini_set('session.gc_maxlifetime', 28800);
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
$sessionCookieExpireTime = 28800; // 8hrs
session_set_cookie_params($sessionCookieExpireTime);

// Check if a session is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'core/config.php';
require_once 'database.php';
