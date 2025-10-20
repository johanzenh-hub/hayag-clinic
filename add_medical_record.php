<?php 
$page_title = "Add Medical Record";
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_type = clean_input($_POST['patient_type']);
    $patient_id = clean_input($_POST['patient_id']);
    $visit_date = clean_input($_POST['visit_date']);
    $visit_time = clean_input($_POST['visit_time']);
    $chief_complaint = clean_input($_POST['chief_complaint']);
    $symptoms = clean_input($_POST['symptoms']);
    $temperature = clean_input($_POST['temperature']);
    $blood_pressure = clean_input($_POST['blood_pressure']);
    $heart_rate = clean_input($_POST['heart_rate']);
    $weight = clean_input($_POST['weight']);
    $height = clean_input($_POST['height']);
    $diagnosis = clean_input($_POST['diagnosis']);
    $treatment = clean_input($_POST['treatment']);
    $medicines_given = clean_input($_POST['medicines_given']);
    $remarks = clean_input($_POST['remarks']);
    $attended_by = $_SESSION['user_id'];
    
    $sql = "INSERT INTO medical_records (patient_type, patient_id, visit_date, visit_time, chief_complaint, symptoms, temperature, blood_pressure, heart_rate, weight, height, diagnosis, treatment, medicines_given, remarks, attended_by) 
            VALUES ('$patient_type', '$patient_id', '$visit_date', '$visit_time', '$chief_complaint', '$symptoms', '$temperature', '$blood_pressure', '$heart_rate', '$weight', '$height', '$diagnosis', '$treatment', '$medicines_given', '$remarks', '$attended_by')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: medical_records.php");
        exit();
    }
}
?>

<div class="container">
    <div class="card">
        <h3>Add Medical Record</h3>
        <form method="POST" action="">
            <div class="form-row">
                <div class="form-group">
                    <label>Patient Type *</label>
                    <select name="patient_type" id="patient_type" required onchange="loadPatients()">
                        <option value="">Select</option>
                        <option value="Student">Student</option>
                        <option value="Staff">Staff</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Patient *</label>
                    <select name="patient_id" id="patient_id" required>
                        <option value="">Select patient type first</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Visit Date *</label>
                    <input type="date" name="visit_date" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Visit Time *</label>
                    <input type="time" name="visit_time" value="<?php echo date('H:i'); ?>" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Chief Complaint *</label>
                <textarea name="chief_complaint" rows="2" required></textarea>
            </div>
            
            <div class="form-group">
                <label>Symptoms</label>
                <textarea name="symptoms" rows="3"></textarea>
            </div>
            
            <h4 style="margin: 20px 0 10px 0; color: #667eea;">Vital Signs</h4>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Temperature (°C)</label>
                    <input type="number" step="0.1" name="temperature" placeholder="36.5">
                </div>
                
                <div class="form-group">
                    <label>Blood Pressure</label>
                    <input type="text" name="blood_pressure" placeholder="120/80">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Heart Rate (bpm)</label>
                    <input type="number" name="heart_rate" placeholder="70">
                </div>
                
                <div class="form-group">
                    <label>Weight (kg)</label>
                    <input type="number" step="0.01" name="weight" placeholder="50.5">
                </div>
            </div>
            
            <div class="form-group">
                <label>Height (cm)</label>
                <input type="number" step="0.01" name="height" placeholder="165">
            </div>
            
            <h4 style="margin: 20px 0 10px 0; color: #667eea;">Assessment & Treatment</h4>
            
            <div class="form-group">
                <label>Diagnosis</label>
                <textarea name="diagnosis" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label>Treatment Given</label>
                <textarea name="treatment" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label>Medicines Given</label>
                <textarea name="medicines_given" rows="2"></textarea>
            </div>
            
            <div class="form-group">
                <label>Remarks</label>
                <textarea name="remarks" rows="2"></textarea>
            </div>
            
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Save Record</button>
                <a href="medical_records.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
function loadPatients() {
    var patientType = document.getElementById('patient_type').value;
    var patientSelect = document.getElementById('patient_id');
    
    patientSelect.innerHTML = '<option value="">Loading...</option>';
    
    if (patientType) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_patients.php?type=' + patientType, true);
        xhr.onload = function() {
            if (this.status == 200) {
                patientSelect.innerHTML = this.responseText;
            }
        };
        xhr.send();
    } else {
        patientSelect.innerHTML = '<option value="">Select patient type first</option>';
    }
}
</script>

<?php include 'includes/footer.php'; ?>