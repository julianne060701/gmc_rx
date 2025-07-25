<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
require_once 'conn.php'; // Make sure conn.php contains your database connection ($conn)

// Initialize response array
$response = array('success' => false, 'message' => '');

try {
    // Check if form was submitted
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Validate required fields
    $required_fields = [
        'patient_name', 'address', 'contact_number', 'gender',
        'email_address', 'date_of_birth', 'civil_status',
        'height', 'weight', 'religion', 'occupation'
    ];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("'$field' is required."); // Improved error message
        }
    }

    // Sanitize and validate input data ('active' removed)
    $patient_name = trim($_POST['patient_name']);
    $account_number = trim($_POST['account_number'] ?? '');
    $address = trim($_POST['address']);
    $contact_number = trim($_POST['contact_number']);
    $gender = $_POST['gender'];
    $email_address = trim($_POST['email_address']);
    $date_of_birth = $_POST['date_of_birth'];
    $civil_status = $_POST['civil_status'];
    $height = floatval($_POST['height']);
    $weight = floatval($_POST['weight']);
    $religion = trim($_POST['religion']);
    $occupation = trim($_POST['occupation']);
    $philhealth_id = trim($_POST['philhealth_id'] ?? '');
    $critical_info = trim($_POST['critical_info'] ?? '');

    // Validate email format
    if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email address format.');
    }

    // Validate gender
    if (!in_array($gender, ['MALE', 'FEMALE'])) {
        throw new Exception('Invalid gender selection.');
    }

    // Validate civil status against ENUM values
    if (!in_array($civil_status, ['SINGLE', 'MARRIED', 'DIVORCED', 'WIDOWED'])) {
        throw new Exception('Invalid civil status selection.');
    }

    // Validate height and weight
    if ($height <= 0 || $height > 300) { // Height in cm, assuming max 300 cm
        throw new Exception('Height must be between 1 and 300 cm.');
    }

    if ($weight <= 0 || $weight > 500) { // Weight in kg, assuming max 500 kg
        throw new Exception('Weight must be between 1 and 500 kg.');
    }

    // Start transaction
    $conn->autocommit(FALSE);

    // Check if email already exists (for new patients)
    $check_email = $conn->prepare("SELECT patient_id FROM patients WHERE email_address = ?");
    if (!$check_email) {
        throw new Exception('Prepare check_email failed: ' . $conn->error);
    }
    $check_email->bind_param("s", $email_address);
    $check_email->execute();
    $result = $check_email->get_result();

    if ($result->num_rows > 0) {
        throw new Exception('Email address already exists for another patient.');
    }
    $check_email->close(); // Close this statement after use

    // Generate account number if empty
    if (empty($account_number)) {
        // Basic account number generation, ensure uniqueness in real system
        $account_number = 'PAT-' . date('Y') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }

    // Insert patient data ('active' column removed from here)
    $sql = "INSERT INTO patients (
        patient_name, account_number, address, contact_number,
        gender, email_address, date_of_birth, civil_status, height, weight,
        religion, occupation, philhealth_id,
        critical_info, created_by, created_at
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    // Count the '?' placeholders here: there are exactly 15.

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('Prepare patient insert failed: ' . $conn->error);
    }

    $user_id = $_SESSION['user_id']; // ID of the logged-in user creating the record

    // THIS IS LINE 119 in the provided code structure:
    // Corrected bind_param: 15 parameters matching 15 '?' placeholders and 15 variables
    // New types: s s s s s s s s d d s s s s i (15 total characters)
    $stmt->bind_param(
        "ssssssssddssssi", // CORRECTED type string (8 's' at the start)
        $patient_name, $account_number, $address, $contact_number,
        $gender, $email_address, $date_of_birth, $civil_status, $height, $weight,
        $religion, $occupation, $philhealth_id,
        $critical_info, $user_id
    ); // These are exactly 15 variables

    if (!$stmt->execute()) {
        throw new Exception('Failed to save patient data: ' . $stmt->error);
    }

    // Get the inserted patient ID
    $patient_id = $conn->insert_id;
    $stmt->close(); // Close patient insert statement

    // Handle children data
    if (isset($_POST['child_name']) && is_array($_POST['child_name'])) {
        $child_names = $_POST['child_name'];
        $child_contacts = $_POST['child_contact'] ?? [];
        $child_dates = $_POST['child_date'] ?? [];

        $child_sql = "INSERT INTO patient_children (patient_id, child_name, child_contact, child_date, created_at) VALUES (?, ?, ?, ?, NOW())";
        $child_stmt = $conn->prepare($child_sql);

        if (!$child_stmt) {
            throw new Exception('Child prepare failed: ' . $conn->error);
        }

        for ($i = 0; $i < count($child_names); $i++) {
            $child_name = trim($child_names[$i]);
            // Only insert if child name is not empty
            if (!empty($child_name)) {
                $child_contact = trim($child_contacts[$i] ?? '');
                $child_date = !empty($child_dates[$i]) ? $child_dates[$i] : null;

                // Bind parameters for child data
                $child_stmt->bind_param("isss", $patient_id, $child_name, $child_contact, $child_date);

                if (!$child_stmt->execute()) {
                    throw new Exception('Failed to save child data: ' . $child_stmt->error);
                }
            }
        }
        $child_stmt->close();
    }

    // Commit transaction
    $conn->commit();
    $conn->autocommit(TRUE); // Revert to autocommit mode

    $response['success'] = true;
    $response['message'] = 'Patient record saved successfully.';
    $response['patient_id'] = $patient_id;

} catch (Exception $e) {
    // Rollback transaction on error
    if (isset($conn) && !$conn->autocommit) { // Only rollback if autocommit is off
        $conn->rollback();
        $conn->autocommit(TRUE); // Revert to autocommit mode
    }

    $response['message'] = $e->getMessage();

    // Log error for debugging (consider writing to a file instead of just error_log)
    error_log("Patient save error: " . $e->getMessage() . " on line " . $e->getLine() . " in " . $e->getFile());
}

// Close connection
if (isset($conn)) {
    $conn->close();
}

// Return JSON response for AJAX requests (if this was called via AJAX)
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// Handle regular form submission (redirection)
if ($response['success']) {
    $_SESSION['success_message'] = $response['message'];
    header("Location: add_patient.php?id=" . $response['patient_id']); // Assuming a view_patient page
} else {
    $_SESSION['error_message'] = $response['message'];
    header("Location: add_patient.php"); // Redirect back to the add form on error
}
exit();
?>