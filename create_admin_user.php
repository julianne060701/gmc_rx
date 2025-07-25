<?php
include 'conn.php';

$username = 'admin';
$password = password_hash('admin123', PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password);

if ($stmt->execute()) {
    echo "Admin user inserted successfully.";
} else {
    echo "Error inserting user: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
