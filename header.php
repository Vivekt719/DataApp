<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-image: url('<?php echo isset($_SESSION["background_image"]) ? htmlspecialchars($_SESSION["background_image"]) : ""; ?>');
            background-size: cover;
        }
    </style>
</head>
<body>
    <?php if (isset($_SESSION['username'])): ?>
        <p>Logged in as <?php echo htmlspecialchars($_SESSION['username']); ?> | <a href="logout.php">Logout</a></p>
    <?php endif; ?>
