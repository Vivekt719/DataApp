<?php
session_start();
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db_connection.php';
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, background_image FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hashed_password, $background_image);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            $_SESSION['background_image'] = $background_image;
            header("Location: dashboard.php");
            exit;
        } else {
            echo "<p>Incorrect password.</p>";
        }
    } else {
        echo "<p>User not found.</p>";
    }
    $stmt->close();
    $conn->close();
}
?>

<form method="POST" action="">
    <label>Username:</label><br>
    <input type="text" name="username" required><br>
    <label>Password:</label><br>
    <input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>

<!-- Add link to register page -->
<p style="text-align: left; margin-top: 20px;">
    Don't have an account? <a href="register.php">Register here</a>.
</p>

<?php include 'footer.php'; ?>
