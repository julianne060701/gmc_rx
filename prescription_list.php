<?php include('auth.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('includes/header.php'); ?>
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
                                <th>Medicine</th>
                                <th>Diagnosis</th>
                                <th>Prescription</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php
                            include 'conn.php'; // Include your DB connection

                            $query = "SELECT * FROM rx_prescriptions ORDER BY date DESC";
                            $result = $conn->query($query);

                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['patient_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['medicine']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['diagnosis']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['prescription']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='9' class='text-center'>No patient records found.</td></tr>";
                            }

                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <?php include('includes/footer.php'); ?>
</div>

</body>
</html>
