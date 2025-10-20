<?php
require_once 'config/database.php';
check_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'School Clinic System'; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <h2>🏥 School Clinic System</h2>
            <div class="nav-links">
                <a href="dashboard.php">Dashboard</a>
                <a href="students.php">Students</a>
                <a href="staff.php">Staff</a>
                <a href="medical_records.php">Medical Records</a>
                <a href="medicines.php">Medicines</a>
                <a href="appointments.php">Appointments</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>