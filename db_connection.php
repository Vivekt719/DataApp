<?php
$conn = new mysqli('localhost', 'root', 'Jairamji123$', 'demo');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
