<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <img src="http://localhost/gmc_rx/img/AdminLTELogo.png" alt="GMC Logo" style="width: 40px; height: 40px;">
        </div>
        <div class="sidebar-brand-text mx-3">GensanMed</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item <?= ($currentPage == 'index.php') ? 'active' : '' ?>">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Patient List -->
    <li class="nav-item <?= ($currentPage == 'patient_list.php') ? 'active' : '' ?>">
        <a class="nav-link" href="patient_list.php">
            <i class="fas fa-fw fa-table"></i>
            <span>Patient List</span>
        </a>
    </li>

    <!-- Add Patient -->
    <li class="nav-item <?= ($currentPage == 'add_patient.php') ? 'active' : '' ?>">
        <a class="nav-link" href="add_patient.php">
            <i class="fas fa-fw fa-user-plus"></i>
            <span>Add Patient</span>
        </a>
    </li>

    <!-- Add RX -->
    <li class="nav-item <?= ($currentPage == 'add_rx.php') ? 'active' : '' ?>">
        <a class="nav-link" href="add_rx.php">
            <i class="fas fa-fw fa-plus"></i>
            <span>Add RX</span>
        </a>
    </li>

    <!-- Prescription List -->
    <li class="nav-item <?= ($currentPage == 'prescription_list.php') ? 'active' : '' ?>">
        <a class="nav-link" href="prescription_list.php">
            <i class="fas fa-fw fa-list"></i>
            <span>Prescription List</span>
        </a>
    </li>

    <!-- Add Medicine -->
    <li class="nav-item <?= ($currentPage == 'medicine.php') ? 'active' : '' ?>">
        <a class="nav-link" href="medicine.php">
            <i class="fas fa-fw fa-pills"></i>
            <span>Add Medicine</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (optional) -->
    <!-- 
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    -->

</ul>
<!-- End of Sidebar -->
