<?php include('auth.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('includes/header.php'); ?>
    <style>
        /* Basic styling for the dropdowns */
        .medicine-dropdown,
        .diagnosis-dropdown,
        .prescription-dropdown {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Ensures padding doesn't push it out of cell */
        }
    </style>
</head>

<body id="page-top">

<div id="wrapper">
    <?php include('includes/sidebar.php'); ?>
    <?php include('includes/topbar.php'); ?>

    <div class="container-fluid">

        <h1 class="h3 mb-2 text-gray-800">RX List</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">RX List</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Patient Name</th>
                                <th>Address</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Medicine(s)</th>
                                <th>Diagnosis(es)</th>
                                <th>Prescription(s)</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php
                            include 'conn.php'; // Include your DB connection

                            // Fetch all prescriptions, ordered by patient name and then date
                            $query = "SELECT patient_name, address, age, gender, medicine, diagnosis, prescription, date 
                                      FROM rx_prescriptions 
                                      ORDER BY patient_name ASC, date DESC"; // Order by date DESC for natural latest view first within groups
                            $result = $conn->query($query);

                            $grouped_prescriptions = [];

                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $patientName = $row['patient_name'];
                                    $date = $row['date'];

                                    // Use patientName and date as compound key for grouping
                                    if (!isset($grouped_prescriptions[$patientName][$date])) {
                                        // Initialize patient-date specific data
                                        $grouped_prescriptions[$patientName][$date] = [
                                            'address' => htmlspecialchars($row['address']),
                                            'age' => htmlspecialchars($row['age']),
                                            'gender' => htmlspecialchars($row['gender']),
                                            'medicines' => [],
                                            'diagnoses' => [],
                                            'prescriptions' => []
                                        ];
                                    }
                                    // Add the medicine, diagnosis, and prescription to the respective arrays
                                    $grouped_prescriptions[$patientName][$date]['medicines'][] = htmlspecialchars($row['medicine']);
                                    $grouped_prescriptions[$patientName][$date]['diagnoses'][] = htmlspecialchars($row['diagnosis']);
                                    $grouped_prescriptions[$patientName][$date]['prescriptions'][] = htmlspecialchars($row['prescription']);
                                }
                            }

                            // Now, iterate through the grouped data to display the table rows
                            if (!empty($grouped_prescriptions)) {
                                foreach ($grouped_prescriptions as $patientName => $dates) {
                                    foreach ($dates as $date => $data) {
                                        echo "<tr>";
                                        echo "<td>" . $patientName . "</td>";
                                        echo "<td>" . $data['address'] . "</td>";
                                        echo "<td>" . $data['age'] . "</td>";
                                        echo "<td>" . $data['gender'] . "</td>";

                                        // Medicines column
                                        echo "<td>";
                                        $unique_medicines = array_unique($data['medicines']);
                                        if (count($unique_medicines) > 1) {
                                            echo "<select class='form-control medicine-dropdown'>";
                                            foreach ($unique_medicines as $med) {
                                                echo "<option>" . $med . "</option>";
                                            }
                                            echo "</select>";
                                        } else {
                                            echo implode(", ", $unique_medicines); // Display if only one or all are same
                                        }
                                        echo "</td>";

                                        // Diagnoses column
                                        echo "<td>";
                                        $unique_diagnoses = array_unique($data['diagnoses']);
                                        if (count($unique_diagnoses) > 1) {
                                            echo "<select class='form-control diagnosis-dropdown'>";
                                            foreach ($unique_diagnoses as $diag) {
                                                echo "<option>" . $diag . "</option>";
                                            }
                                            echo "</select>";
                                        } else {
                                            echo implode(", ", $unique_diagnoses);
                                        }
                                        echo "</td>";

                                        // Prescriptions column
                                        echo "<td>";
                                        $unique_prescriptions = array_unique($data['prescriptions']);
                                        if (count($unique_prescriptions) > 1) {
                                            echo "<select class='form-control prescription-dropdown'>";
                                            foreach ($unique_prescriptions as $pres) {
                                                echo "<option>" . $pres . "</option>";
                                            }
                                            echo "</select>";
                                        } else {
                                            echo implode(", ", $unique_prescriptions);
                                        }
                                        echo "</td>";

                                        echo "<td>" . $date . "</td>";
                                        echo "</tr>";
                                    }
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