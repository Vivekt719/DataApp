<?php
session_start();
include 'header.php';
include 'db_connection.php';

// Check if the user is logged in and authorized to view this page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Handle delete user request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<p style='color: green; text-align: center;'>User deleted successfully.</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Failed to delete user.</p>";
    }
    $stmt->close();
}

// Fetch all users
$stmt = $conn->prepare("SELECT id, username, background_image FROM users");
$stmt->execute();
$result = $stmt->get_result();
?>

<h1>Registered Users</h1>
<table border="1" style="width: 100%; text-align: center; margin-top: 20px;">
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
                <a href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="users.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
$stmt->close();
$conn->close();
include 'footer.php';
?>
