<?php 
$page_title = "View Student";
include 'includes/header.php';

$student_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($student_id == 0) {
    header("Location: students.php");
    exit();
}

$sql = "SELECT * FROM students WHERE student_id = $student_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    header("Location: students.php");
    exit();
}

$student = mysqli_fetch_assoc($result);

// Get medical history
$records_sql = "SELECT * FROM medical_records WHERE patient_type = 'Student' AND patient_id = $student_id ORDER BY visit_date DESC LIMIT 10";
$records_result = mysqli_query($conn, $records_sql);
?>

<div class="container">
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3>Student Profile</h3>
            <a href="students.php" class="btn btn-secondary">Back to List</a>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            <div>
                <h4 style="color: #667eea; margin-bottom: 15px;">Personal Information</h4>
                <p><strong>Student Number:</strong> <?php echo $student['student_number']; ?></p>
                <p><strong>Name:</strong> <?php echo $student['first_name'] . ' ' . $student['middle_name'] . ' ' . $student['last_name']; ?></p>
                <p><strong>Date of Birth:</strong> <?php echo date('F d, Y', strtotime($student['date_of_birth'])); ?></p>
                <p><strong>Age:</strong> <?php echo date_diff(date_create($student['date_of_birth']), date_create('today'))->y; ?> years old</p>
                <p><strong>Gender:</strong> <?php echo $student['gender']; ?></p>
                <p><strong>Blood Type:</strong> <?php echo $student['blood_type'] ?: 'Not specified'; ?></p>
            </div>
            
            <div>
                <h4 style="color: #667eea; margin-bottom: 15px;">Contact Information</h4>
                <p><strong>Grade Level:</strong> <?php echo $student['grade_level']; ?></p>
                <p><strong>Section:</strong> <?php echo $student['section'] ?: 'Not assigned'; ?></p>
                <p><strong>Contact Number:</strong> <?php echo $student['contact_number'] ?: 'Not provided'; ?></p>
                <p><strong>Email:</strong> <?php echo $student['email'] ?: 'Not provided'; ?></p>
                <p><strong>Address:</strong> <?php echo $student['address'] ?: 'Not provided'; ?></p>
            </div>
        </div>
        
        <div style="margin-top: 30px;">
            <h4 style="color: #667eea; margin-bottom: 15px;">Emergency Contact</h4>
            <p><strong>Contact Person:</strong> <?php echo $student['emergency_contact'] ?: 'Not provided'; ?></p>
            <p><strong>Relationship:</strong> <?php echo $student['emergency_relationship'] ?: 'Not specified'; ?></p>
            <p><strong>Contact Number:</strong> <?php echo $student['emergency_number'] ?: 'Not provided'; ?></p>
        </div>
        
        <div style="margin-top: 30px;">
            <h4 style="color: #667eea; margin-bottom: 15px;">Medical Information</h4>
            <p><strong>Allergies:</strong> <?php echo $student['allergies'] ?: 'None reported'; ?></p>
            <p><strong>Medical Conditions:</strong> <?php echo $student['medical_conditions'] ?: 'None reported'; ?></p>
            <p><strong>Current Medications:</strong> <?php echo $student['current_medications'] ?: 'None'; ?></p>
        </div>
    </div>
    
    <div class="card" style="margin-top: 20px;">
        <h3>Medical History</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Chief Complaint</th>
                    <th>Diagnosis</th>
                    <th>Treatment</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($records_result) > 0) {
                    while($record = mysqli_fetch_assoc($records_result)) {
                        echo "<tr>";
                        echo "<td>" . date('M d, Y', strtotime($record['visit_date'])) . "</td>";
                        echo "<td>" . $record['chief_complaint'] . "</td>";
                        echo "<td>" . $record['diagnosis'] . "</td>";
                        echo "<td>" . $record['treatment'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' style='text-align:center;'>No medical records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>