<?php
include 'auth.php'; // Include session-based access control

// Get the user's background image from the session
$backgroundImage = isset($_SESSION['background_image']) ? $_SESSION['background_image'] : 'default.jpg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('<?php echo htmlspecialchars($backgroundImage); ?>') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        .container {
            text-align: center;
            padding: 50px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            margin: 50px auto;
            width: 80%;
        }
        a {
            color: lightblue;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to your Dashboard, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>This page is accessible only to logged-in users.</p>
        <a href="list_users.php" style="display: block; margin-top: 20px;">View Registered Users</a>
        <a href="logout.php" style="color: lightblue; text-decoration: none; margin-top: 20px;">Logout</a>
    </div>
</body>
</html>
