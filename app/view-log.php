<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    die('Access denied.');
}

$logFile = '/home/runner/movie-project/php-error.log';

if (!file_exists($logFile)) {
    die('Log file does not exist.');
}

$logContents = file_get_contents($logFile);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Error Log</title>
    <style>
        pre {
            white-space: pre-wrap; /* CSS3 */
            white-space: -moz-pre-wrap; /* Firefox */
            white-space: -pre-wrap; /* Opera <7 */
            white-space: -o-pre-wrap; /* Opera 7 */
            word-wrap: break-word; /* IE */
        }
    </style>
</head>
<body>
    <h1>PHP Error Log</h1>
    <pre><?php echo htmlspecialchars($logContents); ?></pre>
</body>
</html>
