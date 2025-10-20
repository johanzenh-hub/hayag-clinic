<?php 
$page_title = "Dashboard";
include 'includes/header.php';

// Get statistics
$total_students = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM students"))['count'];
$total_staff = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM staff"))['count'];
$total_records = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM medical_records"))['count'];
$total_medicines = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM medicine_inventory"))['count'];
$todays_appointments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM appointments WHERE appointment_date = CURDATE() AND status = 'Scheduled'"))['count'];
?>

<div class="container">
    <h1 style="margin: 30px 0;">Welcome, <?php echo $_SESSION['full_name']; ?>!</h1>
    
    <div class="dashboard-grid">
        <div class="stat-card">
            <h3><?php echo $total_students; ?></h3>
            <p>Total Students</p>
        </div>
        
        <div class="stat-card">
            <h3><?php echo $total_staff; ?></h3>
            <p>Total Staff</p>
        </div>
        
        <div class="stat-card">
            <h3><?php echo $total_records; ?></h3>
            <p>Medical Records</p>
        </div>
        
        <div class="stat-card">
            <h3><?php echo $total_medicines; ?></h3>
            <p>Medicines</p>
        </div>
        
        <div class="stat-card">
            <h3><?php echo $todays_appointments; ?></h3>
            <p>Today's Appointments</p>
        </div>
    </div>
    
    <div class="card" style="margin-top: 30px;">
        <h3>Recent Medical Records</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Patient Type</th>
                    <th>Chief Complaint</th>
                    <th>Diagnosis</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM medical_records ORDER BY visit_date DESC, visit_time DESC LIMIT 5";
                $result = mysqli_query($conn, $sql);
                
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . date('M d, Y', strtotime($row['visit_date'])) . "</td>";
                        echo "<td>" . $row['patient_type'] . "</td>";
                        echo "<td>" . $row['chief_complaint'] . "</td>";
                        echo "<td>" . $row['diagnosis'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' style='text-align:center;'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>