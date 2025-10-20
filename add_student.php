<?php 
$page_title = "Add Student";
include 'includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_number = clean_input($_POST['student_number']);
    $first_name = clean_input($_POST['first_name']);
    $last_name = clean_input($_POST['last_name']);
    $middle_name = clean_input($_POST['middle_name']);
    $date_of_birth = clean_input($_POST['date_of_birth']);
    $gender = clean_input($_POST['gender']);
    $grade_level = clean_input($_POST['grade_level']);
    $section = clean_input($_POST['section']);
    $contact_number = clean_input($_POST['contact_number']);
    $emergency_contact = clean_input($_POST['emergency_contact']);
    $emergency_number = clean_input($_POST['emergency_number']);
    $address = clean_input($_POST['address']);
    $blood_type = clean_input($_POST['blood_type']);
    $allergies = clean_input($_POST['allergies']);
    $medical_conditions = clean_input($_POST['medical_conditions']);
    
    $sql = "INSERT INTO students (student_number, first_name, last_name, middle_name, date_of_birth, gender, grade_level, section, contact_number, emergency_contact, emergency_number, address, blood_type, allergies, medical_conditions) 
            VALUES ('$student_number', '$first_name', '$last_name', '$middle_name', '$date_of_birth', '$gender', '$grade_level', '$section', '$contact_number', '$emergency_contact', '$emergency_number', '$address', '$blood_type', '$allergies', '$medical_conditions')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: students.php?success=added");
        exit();
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<div class="container">
    <div class="card">
        <h3>Add New Student</h3>
        
        <?php if($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-row">
                <div class="form-group">
                    <label>Student Number *</label>
                    <input type="text" name="student_number" required>
                </div>
                
                <div class="form-group">
                    <label>Blood Type</label>
                    <select name="blood_type">
                        <option value="">Select</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Emergency Contact</label>
                    <input type="text" name="emergency_contact">
                </div>
                <div class="form-group">
                    <label>Emergency Number</label>
                    <input type="text" name="emergency_number">
                </div>
            </div>
            
            <div class="form-group">
                <label>Address</label>
                <textarea name="address" rows="3"></textarea>
            </div>
            
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Save Staff</button>
                <a href="staff.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>