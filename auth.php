<?php
// Check if a session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to a warning page if the user is not logged in
    header("Location: warning.php");
    exit;
}
?>
