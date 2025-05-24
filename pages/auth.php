<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Not logged in, redirect to login page
    header("Location: ./pages/login.php");
    exit();
}
