<?php include('auth.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('includes/header.php'); ?>
    <!-- Bootstrap CSS and JS for Modal -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body id="page-top">

<div id="wrapper">
    <?php include('includes/sidebar.php'); ?>
    <?php include('includes/topbar.php'); ?>

    <div class="container-fluid">

        <h1 class="h3 mb-2 text-gray-800">Patient List</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">RX List</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient Name</th>
                            <th>Account Number</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Birth Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        include 'conn.php';

                        $query = "SELECT * FROM patients ORDER BY patient_id DESC";
                        $result = $conn->query($query);

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $patientId = $row['patient_id'];
                                $modalId = "modal_" . $patientId;

                                // Fetch child details for this patient
                                $childQuery = "SELECT child_name, child_contact, child_date FROM patient_children WHERE patient_id = $patientId";
                                $childResult = $conn->query($childQuery);

                                $childInfo = "<p class='text-muted'>No child data found.</p>";
                                if ($childResult && $childResult->num_rows > 0) {
                                    $childInfo = "";
                                    while ($child = $childResult->fetch_assoc()) {
                                        $childInfo .= "<div class='border p-2 mb-2'>
                                            <p><strong>Child Full Name:</strong> " . htmlspecialchars($child['child_name']) . "</p>
                                            <p><strong>Child Contact:</strong> " . htmlspecialchars($child['child_contact']) . "</p>
                                            <p><strong>Child Date:</strong> " . htmlspecialchars($child['child_date']) . "</p>
                                        </div>";
                                    }
                                }

                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['patient_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['patient_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['account_number']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['date_of_birth']) . "</td>";
                                echo "<td class='text-center'>
                                <button class='btn btn-sm btn-info' data-toggle='modal' data-target='#$modalId' title='View'>
                                    <i class='fas fa-eye'></i>
                                </button>
                                <a href='edit_patient.php?patient_id=$patientId' class='btn btn-sm btn-primary' title='Edit'>
                                    <i class='fas fa-edit'></i>
                                </a>
                              </td>";
                        
                                echo "</tr>";

                                // Modal
                                echo "
                                <div class='modal fade' id='$modalId' tabindex='-1' role='dialog' aria-labelledby='modalLabel_$modalId' aria-hidden='true'>
                                    <div class='modal-dialog modal-lg' role='document'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='modalLabel_$modalId'>Patient Details</h5>
                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                    <span aria-hidden='true'>&times;</span>
                                                </button>
                                            </div>
                                            <div class='modal-body'>
                                                <p><strong>Patient Name:</strong> " . htmlspecialchars($row['patient_name']) . "</p>
                                                <p><strong>Account Number:</strong> " . htmlspecialchars($row['account_number']) . "</p>
                                                <p><strong>Contact Number:</strong> " . htmlspecialchars($row['contact_number']) . "</p>
                                                <p><strong>Gender:</strong> " . htmlspecialchars($row['gender']) . "</p>
                                                <p><strong>Address:</strong> " . htmlspecialchars($row['address']) . "</p>
                                                <p><strong>Date of Birth:</strong> " . htmlspecialchars($row['date_of_birth']) . "</p>
                                                <p><strong>Civil Status:</strong> " . htmlspecialchars($row['civil_status']) . "</p>
                                                <p><strong>Height:</strong> " . htmlspecialchars($row['height']) . "</p>
                                                <p><strong>Weight:</strong> " . htmlspecialchars($row['weight']) . "</p>
                                                <p><strong>Religion:</strong> " . htmlspecialchars($row['religion']) . "</p>
                                                <p><strong>Occupation:</strong> " . htmlspecialchars($row['occupation']) . "</p>
                                                <p><strong>PhilHealth ID:</strong> " . htmlspecialchars($row['philhealth_id']) . "</p>
                                                <p><strong>Critical Info:</strong> " . htmlspecialchars($row['critical_info']) . "</p>
                                                <hr>
                                                <h5>Child Information</h5>
                                                $childInfo
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center'>No patient records found.</td></tr>";
                        }

                        $conn->close();
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>
    </div>


    <?php include('includes/footer.php'); ?>
</div>

</body>
</html>
