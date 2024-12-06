<?php
session_start();
include 'header.php';

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<h1>Welcome to the Home Page</h1>
<p>Enjoy your personalized background!</p>

<?php include 'footer.php'; ?>
