<?php
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['medicine_name'];
    $type = $_POST['type'];

    $stmt = $conn->prepare("INSERT INTO medicines (medicine_name, type) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $type);

    if ($stmt->execute()) {
        header("Location: medicine.php?success=1");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
