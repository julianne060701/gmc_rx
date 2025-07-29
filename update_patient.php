<?php
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Patient data
    $patient_id = $_POST['patient_id'] ?? null;
    $patient_name = $_POST['patient_name'] ?? '';
    $address = $_POST['address'] ?? '';
    $contact_number = $_POST['contact_number'] ?? '';
    $civil_status = $_POST['civil_status'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $height = $_POST['height'] ?? null;
    $weight = $_POST['weight'] ?? null;

    if (!$patient_id || !$patient_name) {
        echo "<script>
            alert('Missing required patient data.');
            window.history.back();
        </script>";
        exit;
    }

    // Update patient record
    $updatePatient = "UPDATE patients SET 
        patient_name = ?, 
        address = ?, 
        contact_number = ?, 
        civil_status = ?, 
        gender = ?, 
        height = ?, 
        weight = ? 
        WHERE patient_id = ?";

    $stmt = $conn->prepare($updatePatient);
    $stmt->bind_param("ssssssdi", $patient_name, $address, $contact_number, $civil_status, $gender, $height, $weight, $patient_id);
    $stmt->execute();
    $stmt->close();

    // Update children data if exists
    if (isset($_POST['children']) && is_array($_POST['children'])) {
        foreach ($_POST['children'] as $child) {
            $child_id = $child['child_id'] ?? null;
            $child_name = $child['child_name'] ?? '';
            $child_contact = $child['child_contact'] ?? '';
            $child_date = $child['child_date'] ?? '';

            if ($child_id) {
                $updateChild = "UPDATE patient_children SET 
                    child_name = ?, 
                    child_contact = ?, 
                    child_date = ? 
                    WHERE child_id = ? AND patient_id = ?";

                $stmt2 = $conn->prepare($updateChild);
                $stmt2->bind_param("sssii", $child_name, $child_contact, $child_date, $child_id, $patient_id);
                $stmt2->execute();
                $stmt2->close();
            }
        }
    }
}
?>

<!-- SweetAlert success and redirect -->
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Update Successful!',
            text: 'Patient record has been updated.',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'patient_list.php';
            }
        });
    </script>
</body>
</html>
