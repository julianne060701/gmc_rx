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
                            <h2>Add Prescription</h2>

                            <div class="row">
                            <?php include 'conn.php'; ?>

                                <!-- Patient Name (Select2) -->
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

                                <div class="form-group col-md-6 mb-3">
                                    <label for="date">Date:</label>
                                    <input type="date" name="date" id="date" class="form-control" required>
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="age">Age:</label>
                                    <input type="text" name="age" id="age" class="form-control" required>
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="gender">Gender:</label>
                                    <select name="gender" id="gender" class="form-control" required>
                                        <option value="" disabled selected>Select Gender</option>
                                        <option value="MALE">MALE</option>
                                        <option value="FEMALE">FEMALE</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <label for="address">Address:</label>
                                    <input type="text" name="address" id="address" class="form-control" required>
                                </div>
                                  <!-- Medicine (Select2) -->
                                  <div class="form-group col-md-12 mb-3">
                                    <label for="medicine">Medicine:</label>
                                    <select name="medicine" id="medicine" class="form-select" required>
                                        <option value="" disabled selected>Select Medicine</option>
                                        <?php
                                        $med_query = mysqli_query($conn, "SELECT medicine_name FROM medicines");
                                        while ($row = mysqli_fetch_assoc($med_query)) {
                                            echo "<option value='" . htmlspecialchars($row['medicine_name']) . "'>" . htmlspecialchars($row['medicine_name']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-12 mb-3">
                                    <label for="diagnosis">Diagnosis:</label>
                                    <textarea name="diagnosis" id="diagnosis" class="form-control" rows="3" required></textarea>
                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <label for="prescription">Prescription (RX):</label>
                                    <textarea name="prescription" id="prescription" class="form-control" rows="3" required></textarea>
                                </div>

                                <div class="form-group col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Submit Prescription</button>
                                </div>

                                <div class="form-group col-md-12 mt-2 text-center">
                                    <button type="button" class="btn btn-secondary" onclick="printRX()">🖨️ Print Prescription</button>
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

                    <div class="rx-symbol">℞</div>

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

                <script>
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
    const prescription = document.getElementById('prescription').value;

    if (!patientName || !date || !age || !gender || !address || !diagnosis || !prescription) {
        Swal.fire('Error!', 'Please fill in all required fields before printing.', 'error');
        return;
    }

    const formattedDate = new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    const printWindow = window.open('', '_blank', 'width=600,height=800');
    printWindow.document.write(`
<!DOCTYPE html>
<html>
<head>
    <title>Prescription</title>
    <style>
        @page {
            size: 8.5in 5.5in;
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .container {
            border: 2px solid black;
            margin: 10px;
            padding: 15px;
            height: calc(100% - 20px);
            box-sizing: border-box;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .logo {
            display: flex;
            gap: 8px;
        }
        .logo img {
            height: 45px;
        }
        .doctor-info {
            text-align: center;
            flex: 1;
        }
        .doctor-info .name {
            font-size: 14px;
            font-weight: bold;
        }
        .doctor-info .spec {
            font-size: 11px;
        }
        .clinic-name {
            font-size: 13px;
            font-weight: bold;
            margin-top: 10px;
        }
        .clinic-info {
            font-size: 11px;
            line-height: 1.3;
            margin-bottom: 8px;
        }
        .divider {
            border-top: 2px solid black;
            margin: 10px 0;
        }
        .patient-info {
            font-size: 12px;
            margin-bottom: 10px;
        }
        .patient-info div {
            margin: 5px 0;
        }
        .rx {
            font-size: 28px;
            font-weight: bold;
            margin: 10px 0;
        }
        .prescription-box {
            min-height: 90px;
            border: 1px solid #000;
            padding: 10px;
            margin: 10px 0;
            white-space: pre-wrap;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            text-align: right;
        }
        .footer .name {
            font-weight: bold;
            margin-bottom: 6px;
        }
        .footer-line {
            display: block;
            border-bottom: 1px solid #000;
            width: 220px;
            margin-left: 5px;
            display: inline-block;
        }
        .footer-line.text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="http://localhost/gmc_rx/img/AdminLTELogo.png" alt="Logo 1">
                <img src="http://localhost/gmc_rx/img/alagang.png" alt="Logo 2">
            </div>
            <div class="doctor-info">
                <div class="name">MARIA JANINA L. PAJARO-LORICO, MD, DPDS</div>
                <div class="spec">CLINICAL & COSMETIC DERMATOLOGY</div>
            </div>
        </div>

        <div class="clinic-name">Gensan Medical Center</div>
        <div class="clinic-info">
            National Highway, Purok Veterans, Barangay Calumpang<br>
            City of General Santos City, South Cotabato<br>
            Tel. #: (083)878-4942 || 228-5000<br>
            Mobile #: (+63)950-287-4792 || (+63)916-519-1372
        </div>

        <div class="divider"></div>

        <div class="patient-info">
            <div><strong>Name:</strong> ${patientName} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Date:</strong> ${formattedDate}</div>
            <div><strong>Address:</strong> ${address} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Age/Gender:</strong> ${age} / ${gender}</div>
            <div><strong>Diagnosis:</strong> ${diagnosis}</div>
        </div>

        <div class="rx">Rx</div>

        <div class="prescription-box">${prescription}</div>

        <div class="footer">
            <div class="name">MARIA JANINA L. PAJARO-LORICO, MD, DPDS</div>
            <div>
                Lic. No. 
                <span class="footer-line text-center"><strong>103714</strong></span>
            </div>
            <div>
                PTR No. 
                <span class="footer-line"></span>
            </div>
            <div>
                S₂ No. 
                <span class="footer-line"></span>
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