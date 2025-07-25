<?php
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['medicine_name'];
    $type = $_POST['type'];
    $dosage = $_POST['dosage'];
    $stock = $_POST['stock'];
    $expiry = $_POST['expiry_date'];

    $stmt = $conn->prepare("INSERT INTO medicines (medicine_name, type, dosage, stock, expiry_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssds", $name, $type, $dosage, $stock, $expiry);

    if ($stmt->execute()) {
        header("Location: medicine.php?success=1");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
