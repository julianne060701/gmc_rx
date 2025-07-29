<?php include('auth.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('includes/header.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/add_rx.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('includes/sidebar.php'); ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('includes/topbar.php'); ?>

                <div class="container-fluid">
                    <div class="rx-form-container mt-5">
                   <form id="rxForm" class="rx-form" method="POST">
    <h2 class="mb-4">Add Prescription</h2>

    <?php include 'conn.php'; ?>

    <div class="row">
        <!-- Patient Name -->
        <div class="form-group col-md-6 mb-3">
            <label for="patient_name">Patient Name:</label>
            <select name="patient_name" id="patient_name" class="form-select" required>
                <option value="" disabled selected>Select Patient</option>
                <?php
                $patient_query = mysqli_query($conn, "SELECT patient_id, patient_name FROM patients");
                while ($row = mysqli_fetch_assoc($patient_query)) {
                    echo "<option value='" . htmlspecialchars($row['patient_name']) . "'>" . htmlspecialchars($row['patient_name']) . "</option>";
                }
                ?>
            </select>
        </div>

        <!-- Date -->
        <div class="form-group col-md-6 mb-3">
            <label for="date">Date:</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>

        <!-- Age -->
        <div class="form-group col-md-6 mb-3">
            <label for="age">Age:</label>
            <input type="text" name="age" id="age" class="form-control" required>
        </div>

        <!-- Gender -->
        <div class="form-group col-md-6 mb-3">
            <label for="gender">Gender:</label>
            <select name="gender" id="gender" class="form-select" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="MALE">MALE</option>
                <option value="FEMALE">FEMALE</option>
            </select>
        </div>

        <!-- Address -->
        <div class="form-group col-md-12 mb-3">
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" class="form-control" required>
        </div>

        <!-- Diagnosis -->
        <div class="form-group col-md-12 mb-4">
            <label for="diagnosis">Diagnosis:</label>
            <textarea name="diagnosis" id="diagnosis" class="form-control" rows="3" required></textarea>
        </div>

        <!-- Prescription Table -->
        <div class="form-group col-md-12">
            <label class="form-label fw-bold">Prescriptions</label>
            <table class="table table-bordered" id="prescriptionTable">
                <thead class="table-light text-center">
                    <tr>
                        <th>#</th>
                        <th>Medicine</th>
                        <th>Prescription (RX)</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="prescriptionBody">
                    <tr>
                        <td class="text-center">1</td>
                        <td>
                            <select name="medicine[]" class="form-select medicine-select" required>
                                <option value="" disabled selected>Select Medicine</option>
                                <?php
                                $med_query = mysqli_query($conn, "SELECT medicine_name FROM medicines");
                                while ($row = mysqli_fetch_assoc($med_query)) {
                                    echo "<option value='" . htmlspecialchars($row['medicine_name']) . "'>" . htmlspecialchars($row['medicine_name']) . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td><input type="text" name="prescription[]" class="form-control" required></td>
                        <td><input type="number" name="quantity[]" class="form-control" min="1" required></td>
                        <td class="text-center"><button type="button" class="btn btn-danger btn-sm remove-btn">Remove</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Action Buttons in One Row -->
        <div class="form-group col-md-12 mt-3 button-group-row">
    <button type="button" class="btn btn-success" id="addRow">Add Prescription</button>
    <button type="submit" class="btn btn-primary">Submit Prescription</button>
    <button type="button" class="btn btn-secondary" onclick="printRX()">🖨️ Print Prescription</button>
</div>

    </div>
                            </div>
</form>

                    </div>
                    <?php include('includes/footer.php'); ?>
                </div>

                <div class="print-receipt" style="display: none;">
                    <div class="prescription-header">
                        <div class="doctor-name">MARIA JANINA L. PAJARO-LORICO, MD, DPDS</div>
                        <div class="specialty">CLINICAL & COSMETIC DERMATOLOGY</div>
                    </div>

                    <div class="clinic-info">
                        <div class="clinic-details">
                            <strong>Gensan Medical Center</strong><br>
                            National Highway, Purok Veterans, Barangay Calumpang<br>
                            City of General Santos City<br>
                            South Cotabato<br>
                            Tel. #: (083)878-4942 || 228-5000<br>
                            Mobile #: (+63)950-267-4792 || (+63)916-519-1372
                        </div>
                        <div class="clinic-hours">
                            <strong>CLINICAL HOURS:</strong><br>
                            Every Thursday<br>
                            10:30 AM - 4:30 PM
                        </div>
                    </div>

                    <div class="patient-info">
                        <div class="patient-line">
                            <label>Name:</label>
                            <span class="value" id="print-name"></span>
                            <label style="margin-left: 20px;">Date:</label>
                            <span class="value" id="print-date" style="width: 120px;"></span>
                        </div>
                        <div class="patient-line">
                            <label>Address:</label>
                            <span class="value" id="print-address"></span>
                            <label style="margin-left: 10px;">Age/Gender:</label>
                            <span class="value" id="print-age-gender" style="width: 80px;"></span>
                        </div>
                        <div class="patient-line">
                            <label>Diagnosis:</label>
                            <span class="value" id="print-diagnosis"></span>
                        </div>
                    </div>

                    <div class="rx-symbol">
    <img src="http://localhost/gmc_rx/img/rx1.png" alt="rxLogo" class="rx-image">
</div>


                    <div class="prescription-content" id="print-prescription-content">
                    </div>

                    <div class="doctor-signature">
                        <div class="signature-line"></div>
                        <strong>MARIA JANINA L. PAJARO-LORICO, MD, DPDS</strong>
                        <div class="license-info">
                            <span>Lic. No. <u>&nbsp;&nbsp;&nbsp;103714&nbsp;&nbsp;&nbsp;</u></span>
                            <span>PTR. No. <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></span>
                            <span>S. No. <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></span>
                        </div>
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                <script>
  $(document).ready(function () {
    let rowCount = 1;

    function initializeSelect2() {
        $('.medicine-select').select2({
            theme: "bootstrap-5",
            width: '100%'
        });
    }

    initializeSelect2();

    $('#addRow').on('click', function () {
        rowCount++;
        let newRow = `
        <tr>
            <td class="text-center">${rowCount}</td>
            <td>
                <select name="medicine[]" class="form-select medicine-select" required>
                    <option value="" disabled selected>Select Medicine</option>
                    <?php
                    $med_query = mysqli_query($conn, "SELECT medicine_name FROM medicines");
                    while ($row = mysqli_fetch_assoc($med_query)) {
                        echo "<option value='" . htmlspecialchars($row['medicine_name']) . "'>" . htmlspecialchars($row['medicine_name']) . "</option>";
                    }
                    ?>
                </select>
            </td>
            <td><input type="text" name="prescription[]" class="form-control" required></td>
            <td><input type="number" name="quantity[]" class="form-control" min="1" required></td>
            <td class="text-center"><button type="button" class="btn btn-danger btn-sm remove-btn">Remove</button></td>
        </tr>`;
        $('#prescriptionBody').append(newRow);
        initializeSelect2();
    });

    $(document).on('click', '.remove-btn', function () {
        $(this).closest('tr').remove();
        rowCount = 1;
        $('#prescriptionBody tr').each(function () {
            $(this).find('td:first').text(rowCount++);
        });
    });
});
                    $(document).ready(function() {
                        // Initialize Select2 for Patient Name
                        $('.patient_name').select2({
                            placeholder: 'Search for a patient...',
                            allowClear: true,
                            ajax: {
                                url: 'get_patients.php', // PHP script to fetch patient names
                                dataType: 'json',
                                delay: 250,
                                data: function(params) {
                                    return {
                                        q: params.term // Search term
                                    };
                                },
                                processResults: function(data) {
                                    return {
                                        results: data.map(item => ({ id: item.patient_name, text: item.patient_name })) // Fixed: use patient_name as both id and text
                                    };
                                },
                                cache: true
                            },
                            minimumInputLength: 1 // Minimum characters to type before searching
                        });

                        // Initialize Select2 for Medicine
                        $('.medicine').select2({
                            placeholder: 'Search for a medicine...',
                            allowClear: true,
                            ajax: {
                                url: 'get_medicines.php', // PHP script to fetch medicine names
                                dataType: 'json',
                                delay: 250,
                                data: function(params) {
                                    return {
                                        q: params.term // Search term
                                    };
                                },
                                processResults: function(data) {
                                    return {
                                        results: data.map(item => ({ id: item.medicine_name, text: item.medicine_name })) // Ensure correct format for Select2
                                    };
                                },
                                cache: true
                            },
                            minimumInputLength: 1 // Minimum characters to type before searching
                        });
                    });

                    document.getElementById('rxForm').addEventListener('submit', function(e) {
                        e.preventDefault(); // Prevent default form submit

                        Swal.fire({
                            title: 'Are you sure?',
                            text: "Do you want to save this prescription?",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, save it!',
                            cancelButtonText: 'Cancel',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Create a FormData object from the form
                                const formData = new FormData(this); // 'this' refers to the form element

                                // Send the form data using AJAX
                                fetch('save_rx.php', {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(response => response.text()) // Get response as text
                                .then(data => {
                                    // Parse the response to check for success or errors
                                    // Assuming save_rx.php returns a simple "success" or "error" message,
                                    // or a JSON object if you modify it to return JSON.
                                    if (data.includes('success')) { // Adjust this condition based on save_rx.php's output
                                        Swal.fire('Saved!', 'Prescription has been saved successfully.', 'success').then(() => {
                                            // Optionally, clear the form or redirect
                                            document.getElementById('rxForm').reset();
                                            $('#patient_name').val('').trigger('change'); // Clear Select2 patient
                                            $('#medicine').val('').trigger('change'); // Clear Select2 medicine
                                        });
                                    } else {
                                        Swal.fire('Error!', 'There was an error saving the prescription: ' + data, 'error');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error during fetch:', error);
                                    Swal.fire('Error!', 'Network error or server unreachable.', 'error');
                                });
                            }
                        });
                    });
                    function printRX() {
    let patientName = '';
    let medicine = '';

    // Get patient name - try Select2 first, fallback to regular select
    if ($('#patient_name').hasClass('select2-hidden-accessible')) {
        const patientData = $('#patient_name').select2('data');
        patientName = patientData && patientData.length > 0 ? patientData[0].text : $('#patient_name').val();
    } else {
        patientName = $('#patient_name option:selected').text();
    }

    // Get medicine name - try Select2 first, fallback to regular select
    if ($('#medicine').hasClass('select2-hidden-accessible')) {
        const medicineData = $('#medicine').select2('data');
        medicine = medicineData && medicineData.length > 0 ? medicineData[0].text : $('#medicine').val();
    } else {
        medicine = $('#medicine option:selected').text();
    }

    const date = document.getElementById('date').value;
    const age = document.getElementById('age').value;
    const gender = document.getElementById('gender').value;
    const address = document.getElementById('address').value;
    const diagnosis = document.getElementById('diagnosis').value;

    let prescriptionsHTML = '<div style="display: flex; flex-direction: column; gap: 6px;">';

$('#prescriptionTable tbody tr').each(function(index) {
    const med = $(this).find('select[name="medicine[]"] option:selected').text().trim();
    const rx = $(this).find('input[name="prescription[]"]').val().trim();
    const qty = $(this).find('input[name="quantity[]"]').val().trim();

    if (med && rx && qty) {
        prescriptionsHTML += `
            <div style="display: flex; justify-content: space-between;">
                <div style="font-weight: bold;">${med}</div>
                <div>${qty}</div>
            </div>
            <div style="margin-left: 10px;">Sig: ${rx}</div>
        `;
    }
});

prescriptionsHTML += '</div>';



if (!patientName || !date || !age || !gender || !address || !diagnosis || prescriptionsHTML.trim() === '') {
    Swal.fire('Error!', 'Please fill in all required fields before printing.', 'error');
    return;
}


    const formattedDate = new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    const printWindow = window.open('', '_blank', 'width=800,height=1000');
    printWindow.document.write(`
<!DOCTYPE html>
<html>
<head>
    <title>Prescription</title>
    <style>
        @page {
            size: 4in 6in;
            margin: 0.1in;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }
        .container {
            border: 2px solid black;
            padding: 8px;
            height: calc(100vh - 16px);
            box-sizing: border-box;
        }
        .header {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        .logo-section {
            display: flex;
            gap: 10px;
            margin-right: 20px;
        }
        .logo-section img {
            height: 35px;
            width: auto;
        }
        .doctor-info {
            flex: 1;
            text-align: center;
        }
        .doctor-name {
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .doctor-specialty {
            font-size: 9px;
            margin-bottom: 8px;
        }
        .clinic-name {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 4px;
            clear: both;
        }
        .clinic-address {
            font-size: 8px;
            line-height: 1.2;
            margin-bottom: 3px;
        }
        .clinic-contact {
            font-size: 8px;
            margin-bottom: 10px;
        }
        .divider {
            border-top: 2px solid black;
            margin: 8px 0;
        }
        .patient-section {
            margin-bottom: 8px;
        }
        .patient-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
            font-size: 9px;
        }
        .patient-field {
            display: flex;
            align-items: center;
            flex: 1;
        }
        .field-label {
            font-weight: normal;
            margin-right: 3px;
        }
        .field-value {
            border-bottom: 1px solid black;
            flex: 1;
            padding-bottom: 1px;
            display: inline-block;
            margin-right: 20px;
        }
        .patient-field:last-child .field-value {
            margin-right: 0;
        }
        .diagnosis-row {
            margin-bottom: 8px;
        }
        .diagnosis-field {
            display: flex;
            align-items: center;
            font-size: 9px;
        }
        .diagnosis-value {
            border-bottom: 1px solid black;
            flex: 1;
            padding-bottom: 1px;
            margin-left: 3px;
        }
        .rx-symbol {
            font-size: 24px;
            font-weight: bold;
            margin: 8px 0;
            font-family: serif;
        }
        .prescription-area {
            min-height: 120px;
            margin-bottom: 20px;
            white-space: pre-wrap;
            font-size: 9px;
            line-height: 1.4;
        }
        .footer-section {
            position: absolute;
            bottom: 20px;
            right: 8px;
            text-align: center;
            font-size: 8px;
        }
        .doctor-signature {
            font-weight: bold;
            font-size: 9px;
            margin-bottom: 8px;
        }
        .license-info {
            text-align: left;
            line-height: 1.4;
        }
        .license-row {
            display: flex;
            align-items: center;
            margin-bottom: 2px;
        }
        .license-label {
            width: 40px;
            text-align: left;
            font-size: 7px;
        }
        .license-line {
            border-bottom: 1px solid black;
            width: 80px;
            height: 12px;
            margin-left: 5px;
            display: inline-block;
            text-align: center;
            padding-top: 1px;
            font-size: 7px;
        }
        .signature-border {
            border: 1px solid black;
            padding: 8px;
            margin-top: 10px;
        }
        @media print {
            .container {
                height: auto;
                min-height: 100vh;
            }
            .footer-section {
                position: fixed;
                bottom: 0.2in;
            }
        }
            .rx-symbol {
            margin-top: 20px;
            text-align: left; /* or center depending on your layout */
        }

        .rx-symbol img.rx-image {
            width: 40px; /* adjust as needed */
            height: auto;
        }
.alagang-logo {
    width: 200px;  /* You can increase to 180px, 200px, etc. */
    height: auto;
}


            
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
           <div class="logo-section">
                <img src="http://localhost/gmc_rx/img/AdminLTELogo.png" alt="GMC Logo">
                <img src="http://localhost/gmc_rx/img/alagang.png" alt="Alagang Logo" class="alagang-logo">
            </div>

            <div class="doctor-info">
                <div class="doctor-name">MARIA JANINA L. PAJARO-LORICO, MD, DPDS</div>
                <div class="doctor-specialty">CLINICAL & COSMETIC DERMATOLOGY</div>
            </div>
        </div>

        <div class="clinic-name">Gensan Medical Center</div>
        <div class="clinic-address">
            National Highway, Purok Veterans, Barangay Calumpang<br>
            City of General Santos City<br>
            South Cotabato
        </div>
        <div class="clinic-contact">
            Tel. #: (083)878-4942 || 228-5000<br>
            Mobile #: (+63)950-287-4792 || (+63)916-519-1372
        </div>

        <div class="divider"></div>

        <div class="patient-section">
            <div class="patient-row">
                <div class="patient-field">
                    <span class="field-label">Name:</span>
                    <span class="field-value">${patientName}</span>
                </div>
                <div class="patient-field">
                    <span class="field-label">Date:</span>
                    <span class="field-value">${formattedDate}</span>
                </div>
            </div>
            <div class="patient-row">
                <div class="patient-field">
                    <span class="field-label">Address:</span>
                    <span class="field-value">${address}</span>
                </div>
                <div class="patient-field">
                    <span class="field-label">Age/Gender:</span>
                    <span class="field-value">${age} / ${gender}</span>
                </div>
            </div>
            <div class="diagnosis-row">
                <div class="diagnosis-field">
                    <span class="field-label">Diagnosis:</span>
                    <span class="diagnosis-value">${diagnosis}</span>
                </div>
            </div>
        </div>

        <div class="rx-symbol">
    <img src="http://localhost/gmc_rx/img/rx1.png" alt="rxLogo" class="rx-image">
</div>


       <div class="prescription-area">${prescriptionsHTML}</div>


        <div class="footer-section">
          
                <div class="doctor-signature">MARIA JANINA L. PAJARO-LORICO, MD, DPDS</div>
                <div class="license-info">
                    <div class="license-row">
                        <span class="license-label">Lic. No.</span>
                        <span class="license-line"><strong>103714</strong></span>
                    </div>
                    <div class="license-row">
                        <span class="license-label">PTR No.</span>
                        <span class="license-line"></span>
                    </div>
                    <div class="license-row">
                        <span class="license-label">S₂No.</span>
                        <span class="license-line"></span>
                    </div>
                
            </div>
        </div>
    </div>
</body>
</html>
    `);

    printWindow.document.close();
    printWindow.focus();

    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 500);
}
</script>
                <script>
                    $('#patient_name').on('change', function () {
                        var selectedPatient = $(this).val();

                        if (selectedPatient) {
                            $.ajax({
                                url: 'fetch_patient_info.php',
                                type: 'POST',
                                data: { patient_name: selectedPatient },
                                dataType: 'json',
                                success: function (response) {
                                    if (response.success) {
                                        $('#gender').val(response.gender);
                                        $('#address').val(response.address);
                                    } else {
                                        Swal.fire('Error', 'Patient not found.', 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error', 'Unable to fetch patient info.', 'error');
                                }
                            });
                        }
                    });

                </script>
   

</body>

</html>