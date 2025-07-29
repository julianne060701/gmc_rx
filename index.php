<?php
include('auth.php');
include('conn.php');

// Count total medicines
$medicine_count_query = "SELECT COUNT(*) AS total_medicines FROM medicines";
$medicine_result = $conn->query($medicine_count_query);
$medicine_count = ($medicine_result && $medicine_result->num_rows > 0) ? $medicine_result->fetch_assoc()['total_medicines'] : 0;

// Count total patients
$patient_count_query = "SELECT COUNT(*) AS total_patients FROM patients";
$patient_result = $conn->query($patient_count_query);
$patient_count = ($patient_result && $patient_result->num_rows > 0) ? $patient_result->fetch_assoc()['total_patients'] : 0;

// Count total prescriptions
$prescription_count_query = "SELECT COUNT(*) AS total_prescriptions FROM rx_prescriptions";
$prescription_result = $conn->query($prescription_count_query);
$prescription_count = ($prescription_result && $prescription_result->num_rows > 0) ? $prescription_result->fetch_assoc()['total_prescriptions'] : 0;

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <?php include('includes/header.php'); ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
    <?php include('includes/sidebar.php'); ?>
    <?php include('includes/topbar.php'); ?>
       

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                       <!-- Medicine -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Medicine</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $medicine_count; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-capsules fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Patient -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Patient Total</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $patient_count; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user-injured fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Prescription -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Prescription Total</div>
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-auto">
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $prescription_count; ?></div>
                                                    </div>
                                                
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-file-prescription fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            </div>
                </div>
            </div>
            <!-- End of Main Content -->

       <?php include('includes/footer.php'); ?>

</body>

</html>