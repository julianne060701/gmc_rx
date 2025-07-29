<?php include('auth.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('includes/header.php'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .form-group {
            margin-bottom: 1rem;
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -5px;
            margin-left: -5px;
        }
        .form-row > .col,
        .form-row > [class*="col-"] {
            padding-right: 5px;
            padding-left: 5px;
        }
        .required {
            color: red;
        }
        .children-table th,
        .children-table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }
        .children-table th {
            background-color: #e9ecef;
        }
        .btn-add-child {
            margin-top: 10px;
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">
        <?php include('includes/sidebar.php'); ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php include('includes/topbar.php'); ?>

                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Patient Record</h1>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                        <form id="patientForm" method="POST" action="save_patient.php">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="patientName"><span class="required">*</span> Patient Name</label>
                <input type="text" class="form-control" id="patientName" name="patient_name" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="accountNumber">Account Number</label>
                <input type="text" class="form-control" id="accountNumber" name="account_number">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="address"><span class="required">*</span> Address</label>
                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="contactNumber"><span class="required">*</span> Contact Number</label>
                <input type="tel" class="form-control" id="contactNumber" name="contact_number" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="gender"><span class="required">*</span> Gender</label>
                <select class="form-control" id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="MALE">MALE</option>
                    <option value="FEMALE">FEMALE</option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="emailAddress"><span class="required">*</span> Email Address</label>
                <input type="email" class="form-control" id="emailAddress" name="email_address" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="dateOfBirth"><span class="required">*</span> Date of Birth</label>
                <input type="date" class="form-control" id="dateOfBirth" name="date_of_birth" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="civilStatus"><span class="required">*</span> Civil Status</label>
                <select class="form-control" id="civilStatus" name="civil_status" required>
                    <option value="">Select Status</option>
                    <option value="SINGLE">SINGLE</option>
                    <option value="MARRIED">MARRIED</option>
                    <option value="DIVORCED">DIVORCED</option>
                    <option value="WIDOWED">WIDOWED</option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="height"><span class="required">*</span> Height</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="height" name="height" step="0.01" required>
                    <div class="input-group-append">
                        <span class="input-group-text">cm</span>
                    </div>
                </div>
            </div>
        </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="weight"><span class="required">*</span> Weight</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="weight" name="weight" step="0.01" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">kg</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="religion"><span class="required">*</span> Religion</label>
                                    <input type="text" class="form-control" id="religion" name="religion" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="occupation"><span class="required">*</span> Occupation</label>
                                    <input type="text" class="form-control" id="occupation" name="occupation" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Children</label>
                                    <table class="children-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Contact Number</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="childrenTableBody">
                                            <tr>
                                                <td>1</td>
                                                <td><input type="text" class="form-control form-control-sm" name="child_name[]"></td>
                                                <td><input type="tel" class="form-control form-control-sm" name="child_contact[]"></td>
                                                <td><input type="date" class="form-control form-control-sm" name="child_date[]"></td>
                                                <td><button type="button" class="btn btn-sm btn-danger" onclick="removeChild(this)">Remove</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-sm btn-success btn-add-child" onclick="addChild()">Add Child</button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="philhealthId">PhilHealth ID</label>
                                    <input type="text" class="form-control" id="philhealthId" name="philhealth_id">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="criticalInfo">Critical Information/Allergies</label>
                                    <textarea class="form-control" id="criticalInfo" name="critical_info" rows="4"></textarea>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="float-right">
                                    <button type="submit" class="btn btn-primary">SAVE</button>
                                    <button type="button" class="btn btn-secondary ml-2" onclick="cancelForm()">CANCEL</button>
                                </div>
                            </div>
                        </div>
                    </form>

                        </div>
                    </div>

                </div>
                </div>
            <?php include('includes/footer.php'); ?>

        </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let childCounter = 1;

        function addChild() {
            childCounter++;
            const tbody = document.getElementById('childrenTableBody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${childCounter}</td>
                <td><input type="text" class="form-control form-control-sm" name="child_name[]"></td>
                <td><input type="tel" class="form-control form-control-sm" name="child_contact[]"></td>
                <td><input type="date" class="form-control form-control-sm" name="child_date[]"></td>
                <td><button type="button" class="btn btn-sm btn-danger" onclick="removeChild(this)">Remove</button></td>
            `;
            tbody.appendChild(newRow);
        }

        function removeChild(button) {
            const row = button.closest('tr');
            row.remove();
            // Renumber the rows
            const rows = document.querySelectorAll('#childrenTableBody tr');
            rows.forEach((row, index) => {
                row.cells[0].textContent = index + 1;
            });
            childCounter = rows.length;
        }

        function cancelForm() {
            Swal.fire({
                title: 'Are you sure?',
                text: "All unsaved changes will be lost!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'add_patient.php'; // Redirect to patients list or appropriate page
                }
            });
        }

        // Form submission with SweetAlert confirmation
        document.getElementById('patientForm').addEventListener('submit', function(e) {
            // First, perform your existing form validation
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault(); // Prevent default submission
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fill in all required fields!',
                });
                return; // Stop the function here
            }

            // If validation passes, show SweetAlert confirmation
            e.preventDefault(); // Prevent default form submission initially

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to add this patient?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, add it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, proceed with actual form submission
                    this.submit();
                }
            });
        });
    </script>

</body>

</html>