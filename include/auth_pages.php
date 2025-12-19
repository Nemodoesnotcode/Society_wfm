<?php
// include/auth_pages.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Specifically for ADMIN protection
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirecting from /pages/ to /pages/admin_login.html 
    // We use a simple path because the login file is in the SAME folder
    header("Location: admin_login.html"); 
    exit();
}
?>