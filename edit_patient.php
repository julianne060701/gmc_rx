<?php 
include('auth.php'); 
include('conn.php');

// Fetch patient data
if (isset($_GET['patient_id'])) {
    $patientId = intval($_GET['patient_id']);

    $patientQuery = "SELECT * FROM patients WHERE patient_id = $patientId";
    $patientResult = $conn->query($patientQuery);

    if ($patientResult && $patientResult->num_rows > 0) {
        $row = $patientResult->fetch_assoc();
    } else {
        echo "<script>alert('Patient not found.'); window.location.href='your_patient_list_page.php';</script>";
        exit;
    }

    // Fetch child data
    $childQuery = "SELECT * FROM patient_children WHERE patient_id = $patientId";
    $childResult = $conn->query($childQuery);
    $children = [];
    if ($childResult && $childResult->num_rows > 0) {
        while ($child = $childResult->fetch_assoc()) {
            $children[] = $child;
        }
    }

} else {
    echo "<script>alert('Invalid request.'); window.location.href='your_patient_list_page.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('includes/header.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient Details</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/edit_patient.css">
</head>
<body>
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <div id="wrapper">
        <?php include('includes/sidebar.php'); ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('includes/topbar.php'); ?>

                <div class="container">
                    <div class="header">
                        <h1><i class="fas fa-user-edit"></i> Edit Patient Details</h1>
                        <p>Update patient information and medical records</p>
                    </div>

                    <div class="form-content">
                        <form action="update_patient.php" method="POST" id="patientForm">
                            <input type="hidden" name="patient_id" value="<?php echo $row['patient_id']; ?>">

                <div class="form-grid">
                    <!-- Personal Information Section -->
                    <div class="form-section">
                        <div class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            Personal Information
                        </div>

                        <div class="form-group">
                            <label>Patient Name</label>
                            <input type="text" name="patient_name" class="form-control" value="<?php echo htmlspecialchars($row['patient_name']); ?>" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="gender" class="form-control">
                        <option value="MALE" <?php if ($row['gender'] === 'MALE') echo 'selected'; ?>>MALE</option>
                        <option value="FEMALE" <?php if ($row['gender'] === 'FEMALE') echo 'selected'; ?>>FEMALE</option>
                    </select>
                            </div>

                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input type="date" name="date_of_birth" class="form-control" value="<?php echo htmlspecialchars($row['date_of_birth']); ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Civil Status</label>
                                <select name="civil_status" class="form-control">
                        <option value="SINGLE" <?php if ($row['civil_status'] === 'SINGLE') echo 'selected'; ?>>SINGLE</option>
                        <option value="MARRIED" <?php if ($row['civil_status'] === 'MARRIED') echo 'selected'; ?>>MARRIED</option>
                        <option value="DIVORCED" <?php if ($row['civil_status'] === 'DIVORCED') echo 'selected'; ?>>DIVORCED</option>
                        <option value="WIDOWED" <?php if ($row['civil_status'] === 'WIDOWED') echo 'selected'; ?>>WIDOWED</option>
                    </select>
                            </div>

                            <div class="form-group">
                                <label>Religion</label>
                                <input type="text" name="religion" class="form-control" value="<?php echo htmlspecialchars($row['religion']); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($row['address']); ?>">
                        </div>
                    </div>

                    <!-- Contact & Account Information Section -->
                    <div class="form-section">
                        <div class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            Contact & Account
                        </div>

                        <div class="form-group">
                            <label>Contact Number</label>
                            <input type="text" name="contact_number" class="form-control" value="<?php echo htmlspecialchars($row['contact_number']); ?>">
                        </div>

                        <div class="form-group">
                            <label>Account Number</label>
                            <input type="text" name="account_number" class="form-control" value="<?php echo htmlspecialchars($row['account_number']); ?>">
                        </div>

                        <div class="form-group">
                            <label>PhilHealth ID</label>
                            <input type="text" name="philhealth_id" class="form-control" value="<?php echo htmlspecialchars($row['philhealth_id']); ?>">
                        </div>

                        <div class="form-group">
                            <label>Occupation</label>
                            <input type="text" name="occupation" class="form-control" value="<?php echo htmlspecialchars($row['occupation']); ?>">
                        </div>
                    </div>
                </div>

                <!-- Medical Information Section -->
                <div class="form-section">
                    <div class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        Medical Information
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                        <label>Height (cm)</label>
                        <input type="text" name="height" class="form-control" value="<?php echo htmlspecialchars($row['height']); ?>">
                        </div>

                        <div class="form-group">
                        <label>Weight (kg)</label>
                        <input type="text" name="weight" class="form-control" value="<?php echo htmlspecialchars($row['weight']); ?>">
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label>Critical Information / Medical Notes</label>
                        <textarea name="critical_info" class="form-control" placeholder="Enter any critical medical information, allergies, or special notes..."><?php echo htmlspecialchars($row['critical_info']); ?></textarea>
                    </div>
                </div>

                <!-- Children Information Section -->
                <div class="children-section">
                    <div class="children-header">
                        <div class="section-icon">
                            <i class="fas fa-baby"></i>
                        </div>
                        <h2>Children Information</h2>
                    </div>

                    <?php if (!empty($children)) : ?>
                        <?php foreach ($children as $index => $child) : ?>
                            <div class="child-card">
                                <div class="child-header">
                                    <div class="child-number"><?php echo $index + 1; ?></div>
                                    <div class="child-title">Child <?php echo $index + 1; ?> Details</div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Child Name</label>
                                        <input type="text" name="children[<?php echo $index; ?>][child_name]" class="form-control" value="<?php echo htmlspecialchars($child['child_name']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Child Contact</label>
                                        <input type="text" name="children[<?php echo $index; ?>][child_contact]" class="form-control" value="<?php echo htmlspecialchars($child['child_contact']); ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Child Date of Birth</label>
                                    <input type="date" name="children[<?php echo $index; ?>][child_date]" class="form-control" value="<?php echo htmlspecialchars($child['child_date']); ?>">
                                </div>

                                <input type="hidden" name="children[<?php echo $index; ?>][child_id]" value="<?php echo $child['child_id']; ?>">
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="no-children">
                            <i class="fas fa-info-circle" style="font-size: 2rem; margin-bottom: 10px; color: #a0aec0;"></i>
                            <p>No child records found for this patient.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Update Patient
                    </button>
                    <a href="patient_list.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
</div>

</div>

    <script>
        // Form submission with loading state
        document.getElementById('patientForm').addEventListener('submit', function(e) {
            document.getElementById('loadingOverlay').style.display = 'flex';
        });

        // Add smooth animations to form elements
        const formControls = document.querySelectorAll('.form-control');
        formControls.forEach(control => {
            control.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            control.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Add ripple effect to buttons
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    </script>

    <style>
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    </style>
</body>
</html>