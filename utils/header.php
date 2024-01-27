<?php
// Check if session is not already started
if (session_status() == PHP_SESSION_NONE) {
    // Start the session
    session_start();
}

include 'utils/db.php';
include 'utils/tools.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
    
