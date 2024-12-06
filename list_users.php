<?php
session_start();
include 'auth.php'; // Ensure the user is logged in
include 'db_connection.php';

// Get the logged-in user's username
$currentUsername = $_SESSION['username'];
$currentBackgroundImage = $_SESSION['background_image'];

// Fetch all users
$stmt = $conn->prepare("SELECT id, username, background_image FROM users");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Your Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('<?php echo htmlspecialchars($currentBackgroundImage); ?>') no-repeat center center fixed;
            background-size: cover;
            color: white;
            text-align: center;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.9);
            color: black;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #4A90E2;
            color: white;
        }
        a {
            color: #4A90E2;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .container {
            margin-top: 20px;
        }
        .navigation {
            margin-top: 20px;
        }
        .navigation a {
            margin: 0 10px;
            color: lightblue;
            text-decoration: none;
            font-weight: bold;
        }
        .navigation a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage All Users</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Background Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($row['background_image']); ?>" alt="Background Image" style="width: 100px; height: auto;"></td>
                    <td>
                        <!-- Allow logged-in user to edit or delete only their own account -->
                        <?php if ($row['username'] === $currentUsername): ?>
                            <a href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a> |
                            <a href="delete_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete your account?');">Delete</a>
                        <?php else: ?>
                            <span>Not Allowed</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Navigation Links -->
        <div class="navigation">
        <a href="dashboard.php" style="background: white; color: #4A90E2; padding: 10px 15px; border-radius: 5px; text-decoration: none; font-weight: bold; margin: 5px;">Back to Dashboard</a>
        <a href="logout.php" style="background: white; color: #4A90E2; padding: 10px 15px; border-radius: 5px; text-decoration: none; font-weight: bold; margin: 5px;">Logout</a>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
