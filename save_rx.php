<?php
include 'conn.php';

header('Content-Type: text/plain');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get patient info
    $patient_name = trim($_POST['patient_name']);
    $date = $_POST['date'];
    $address = trim($_POST['address']);
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $diagnosis = trim($_POST['diagnosis']);

    // Get the arrays of medicine, prescription, and quantity
    $medicines = $_POST['medicine'];
    $prescriptions = $_POST['prescription'];
    $quantities = $_POST['quantity'];

    // Prepare insert statement
    $stmt = $conn->prepare("INSERT INTO rx_prescriptions (patient_name, date, address, age, gender, medicine, diagnosis, qty, prescription) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        echo "error: " . $conn->error;
        exit();
    }

    // Loop through each medicine entry
    for ($i = 0; $i < count($medicines); $i++) {
        $medicine = trim($medicines[$i]);
        $prescription = trim($prescriptions[$i]);
        $qty = $quantities[$i];

        $stmt->bind_param("sssssssss", $patient_name, $date, $address, $age, $gender, $medicine, $diagnosis, $qty, $prescription);

        if (!$stmt->execute()) {
            echo "error on row $i: " . $stmt->error;
            exit();
        }
    }

    $stmt->close();
    $conn->close();

    echo "success";
} else {
    echo "Invalid request method.";
}
