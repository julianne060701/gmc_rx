<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['medicine_name'];
    $type = $_POST['type'];

    $stmt = $conn->prepare("UPDATE medicines SET medicine_name = ?, type = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $type, $id);

    if ($stmt->execute()) {
        header("Location: medicine.php?updated=1");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
