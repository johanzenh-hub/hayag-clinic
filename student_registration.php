<?php
require_once 'config/database.php';

// Don't require login for this page - it's public
if (isset($_SESSION['user_id'])) {
    // If already logged in, redirect to dashboard
    header("Location: dashboard.php");
    exit();
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $student_number = clean_input($_POST['student_number']);
    $first_name = clean_input($_POST['first_name']);
    $last_name = clean_input($_POST['last_name']);
    $middle_name = clean_input($_POST['middle_name']);
    $date_of_birth = clean_input($_POST['date_of_birth']);
    $gender = clean_input($_POST['gender']);
    $grade_level = clean_input($_POST['grade_level']);
    $section = clean_input($_POST['section']);
    $contact_number = clean_input($_POST['contact_number']);
    $email = clean_input($_POST['email']);
    $emergency_contact = clean_input($_POST['emergency_contact']);
    $emergency_number = clean_input($_POST['emergency_number']);
    $relationship = clean_input($_POST['relationship']);
    $address = clean_input($_POST['address']);
    $blood_type = clean_input($_POST['blood_type']);
    $allergies = clean_input($_POST['allergies']);
    $medical_conditions = clean_input($_POST['medical_conditions']);
    $medications = clean_input($_POST['medications']);
    
    // Validate required fields
    if (empty($student_number) || empty($first_name) || empty($last_name) || empty($date_of_birth) || empty($gender) || empty($grade_level)) {
        $error = "Please fill in all required fields.";
    } else {
        // Check if student number already exists
        $check_sql = "SELECT student_id FROM students WHERE student_number = '$student_number'";
        $check_result = mysqli_query($conn, $check_sql);
        
        if (mysqli_num_rows($check_result) > 0) {
            $error = "Student number already exists!";
        } else {
            // Insert student record
            $sql = "INSERT INTO students (
                student_number, first_name, last_name, middle_name, 
                date_of_birth, gender, grade_level, section, 
                contact_number, email, emergency_contact, emergency_number, 
                emergency_relationship, address, blood_type, allergies, 
                medical_conditions, current_medications
            ) VALUES (
                '$student_number', '$first_name', '$last_name', '$middle_name',
                '$date_of_birth', '$gender', '$grade_level', '$section',
                '$contact_number', '$email', '$emergency_contact', '$emergency_number',
                '$relationship', '$address', '$blood_type', '$allergies',
                '$medical_conditions', '$medications'
            )";
            
            if (mysqli_query($conn, $sql)) {
                $success = "Registration successful! Your student ID is: $student_number";
                
                // Log the registration
                $student_id = mysqli_insert_id($conn);
                $log_sql = "INSERT INTO activity_log (action, table_name, record_id, description) 
                           VALUES ('REGISTER', 'students', $student_id, 'New student registration: $first_name $last_name')";
                mysqli_query($conn, $log_sql);
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - School Clinic System</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .registration-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 20px;
        }
        
        .registration-box {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        
        .registration-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .registration-header h1 {
            color: #333;
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .registration-header p {
            color: #666;
            font-size: 16px;
        }
        
        .section-title {
            color: #667eea;
            font-size: 20px;
            font-weight: bold;
            margin: 30px 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }
        
        .required {
            color: red;
        }
        
        .success-box {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 16px;
        }
        
        .success-box strong {
            font-size: 18px;
            display: block;
            margin-bottom: 10px;
        }
        
        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
        }
        
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <div class="registration-box">
            <div class="registration-header">
                <h1>🏥 Student Registration</h1>
                <p>School Clinic Management System</p>
            </div>
            
            <?php if($success): ?>
                <div class="success-box">
                    <strong>✓ Registration Successful!</strong>
                    <?php echo $success; ?>
                    <div style="margin-top: 15px;">
                        <a href="student_registration.php" class="btn btn-primary">Register Another Student</a>
                        <a href="login.php" class="btn btn-secondary">Go to Login</a>
                    </div>
                </div>
            <?php else: ?>
                
                <?php if($error): ?>
                    <div class="alert alert-error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <!-- Basic Information -->
                    <div class="section-title">Basic Information</div>
                    
                    <div class="form-group">
                        <label>Student Number <span class="required">*</span></label>
                        <input type="text" name="student_number" required placeholder="e.g., 2024-001">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name <span class="required">*</span></label>
                            <input type="text" name="first_name" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Last Name <span class="required">*</span></label>
                            <input type="text" name="last_name" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Middle Name</label>
                            <input type="text" name="middle_name">
                        </div>
                        
                        <div class="form-group">
                            <label>Date of Birth <span class="required">*</span></label>
                            <input type="date" name="date_of_birth" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Gender <span class="required">*</span></label>
                            <select name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Blood Type</label>
                            <select name="blood_type">
                                <option value="">Select Blood Type</option>
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
                    
                    <!-- Academic Information -->
                    <div class="section-title">Academic Information</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Grade Level <span class="required">*</span></label>
                            <select name="grade_level" required>
                                <option value="">Select Grade Level</option>
                                <option value="Grade 7">Grade 7</option>
                                <option value="Grade 8">Grade 8</option>
                                <option value="Grade 9">Grade 9</option>
                                <option value="Grade 10">Grade 10</option>
                                <option value="Grade 11">Grade 11</option>
                                <option value="Grade 12">Grade 12</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Section</label>
                            <input type="text" name="section" placeholder="e.g., Section A">
                        </div>
                    </div>
                    
                    <!-- Contact Information -->
                    <div class="section-title">Contact Information</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Contact Number</label>
                            <input type="text" name="contact_number" placeholder="09XX-XXX-XXXX">
                        </div>
                        
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" placeholder="student@example.com">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Home Address</label>
                        <textarea name="address" rows="2" placeholder="Complete home address"></textarea>
                    </div>
                    
                    <!-- Emergency Contact -->
                    <div class="section-title">Emergency Contact Information</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Emergency Contact Name</label>
                            <input type="text" name="emergency_contact" placeholder="Parent/Guardian Name">
                        </div>
                        
                        <div class="form-group">
                            <label>Emergency Contact Number</label>
                            <input type="text" name="emergency_number" placeholder="09XX-XXX-XXXX">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Relationship</label>
                        <select name="relationship">
                            <option value="">Select Relationship</option>
                            <option value="Mother">Mother</option>
                            <option value="Father">Father</option>
                            <option value="Guardian">Guardian</option>
                            <option value="Sibling">Sibling</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    
                    <!-- Medical Information -->
                    <div class="section-title">Medical Information</div>
                    
                    <div class="form-group">
                        <label>Known Allergies</label>
                        <textarea name="allergies" rows="2" placeholder="List any known allergies (food, medicine, etc.)"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Medical Conditions</label>
                        <textarea name="medical_conditions" rows="2" placeholder="Any existing medical conditions (asthma, diabetes, etc.)"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Current Medications</label>
                        <textarea name="medications" rows="2" placeholder="List any medications currently being taken"></textarea>
                    </div>
                    
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary" style="flex: 1;">Submit Registration</button>
                        <button type="reset" class="btn btn-secondary">Clear Form</button>
                    </div>
                </form>
                
                <div class="back-link">
                    <a href="login.php">← Back to Login</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>