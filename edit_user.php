<?php
session_start();
include 'header.php';
include 'db_connection.php';

// Check if the user is logged in and authorized to view this page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Get the user ID
if (!isset($_GET['id'])) {
    echo "<p style='color: red; text-align: center;'>Invalid user ID.</p>";
    exit;
}

$id = intval($_GET['id']);

// Handle form submission to update user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $background_image = $_POST['background_image'];

    $stmt = $conn->prepare("UPDATE users SET username = ?, background_image = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $background_image, $id);

    if ($stmt->execute()) {
        echo "<p style='color: green; text-align: center;'>User updated successfully.</p>";
        // Update session background image if the user is editing their own profile
        if ($_SESSION['username'] === $username) {
            $_SESSION['background_image'] = $background_image;
        }
    } else {
        echo "<p style='color: red; text-align: center;'>Failed to update user.</p>";
    }

    $stmt->close();
}

// Fetch user details
$stmt = $conn->prepare("SELECT username, background_image FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($username, $background_image);
$stmt->fetch();
$stmt->close();
?>

<h1>Edit User</h1>
<form method="POST" action="">
    <label>Username:</label><br>
    <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br>
    <label>Background Image:</label><br>
    <select name="background_image" id="background_image">
        <option value="../images/1.jpg" <?php echo $background_image == '../images/1.jpg' ? 'selected' : ''; ?>>Image 1</option>
        <option value="../images/2.jpg" <?php echo $background_image == '../images/2.jpg' ? 'selected' : ''; ?>>Image 2</option>
    </select>
    <div id="preview" style="margin-top: 10px;">
        <img src="<?php echo htmlspecialchars($background_image); ?>" alt="Current Background" style="width: 100px; height: auto; border: 1px solid #ccc; border-radius: 5px;">
    </div>
    <br><br>
    <button type="submit">Update</button>
</form>

<!-- Link back to the dashboard -->
<p style="text-align: left; margin-top: 20px;">
    <a href="dashboard.php" style="text-decoration: none; color: blue;">Back to Dashboard</a>
</p>

<script>
document.getElementById('background_image').addEventListener('change', function() {
    const selectedImage = this.value;

    // Show the preview dynamically
    const img = document.createElement('img');
    img.src = selectedImage;
    img.alt = 'Selected Background';
    img.style.width = '100px';
    img.style.height = 'auto';
    img.style.border = '1px solid #ccc';
    img.style.borderRadius = '5px';

    const previewDiv = document.getElementById('preview');
    previewDiv.innerHTML = ''; // Clear the current preview
    previewDiv.appendChild(img); // Add the new preview
});
</script>

<?php include 'footer.php'; ?>
