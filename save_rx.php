<?php
include 'conn.php'; // DB connection

// Set header for JSON response (optional, but good practice for AJAX)
header('Content-Type: text/plain'); // Or 'application/json' if you return JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form values
    $patient_name = trim($_POST['patient_name']);
    $date = $_POST['date'];
    $address = trim($_POST['address']);
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $medicine = trim($_POST['medicine']); // Make sure to trim this as well
    $diagnosis = trim($_POST['diagnosis']);
    $prescription = trim($_POST['prescription']);

    // SQL Insert statement - Ensure the number of '?' matches the number of columns and bound parameters
    // There are 8 columns: patient_name, date, address, age, gender, medicine, diagnosis, prescription
    // So there should be 8 placeholders and 8 's' in bind_param
    $sql = "INSERT INTO rx_prescriptions (patient_name, date, address, age, gender, medicine, diagnosis, prescription) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)"; // Added one more '?' for medicine

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Corrected bind_param: "ssssssss" for 8 string parameters
        $stmt->bind_param("ssssssss", $patient_name, $date, $address, $age, $gender, $medicine, $diagnosis, $prescription);

        if ($stmt->execute()) {
            // Echo a simple success message for the AJAX call
            echo "success"; 
        } else {
            // Echo an error message for the AJAX call
            error_log("Database error: " . $stmt->error); // Log the error for debugging
            echo "error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        // Echo an SQL preparation error message
        error_log("SQL preparation error: " . $conn->error); // Log the error
        echo "error: SQL preparation failed - " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>