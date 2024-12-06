<?php
session_start();
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db_connection.php'; // File to handle database connection
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encrypt the password
    $background_image = $_POST['background_image'];

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users (username, password, background_image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $background_image);
    if ($stmt->execute()) {
        echo "<p style='color: green; text-align: center;'>Registration successful. <a href='login.php'>Login here</a>.</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Error: " . $stmt->error . "</p>";
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
    <label>Background Image:</label><br>
    <select name="background_image" id="background_image">
        <option value="" disabled selected>Select a background image</option>
        <option value="../images/1.jpg">Image 1</option>
        <option value="../images/2.jpg">Image 2</option>
    </select>
    <div id="preview"></div><br>
    <button type="submit">Register</button>
</form>

<p style="text-align: left; margin-top: 20px;">
    Already have an account? <a href="login.php">Login here</a>.
</p>

<p style="text-align: left; margin-top: 10px;">
    <a href="dashboard.php">Go to Dashboard</a>
</p>

<script>
document.getElementById('background_image').addEventListener('change', function() {
    const img = document.createElement('img');
    img.src = this.value;
    img.style.width = '200px';
    document.getElementById('preview').innerHTML = '';
    document.getElementById('preview').appendChild(img);
});
</script>

<?php include 'footer.php'; ?>
