<?php
include 'conn.php';

if (isset($_POST['patient_name'])) {
    $patient_name = mysqli_real_escape_string($conn, $_POST['patient_name']);

    $query = "SELECT gender, address FROM patients WHERE patient_name = '$patient_name' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode([
            'success' => true,
            'gender' => $row['gender'],
            'address' => $row['address']
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
