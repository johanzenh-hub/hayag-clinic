<?php 
$page_title = "Add Medicine";
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $medicine_name = clean_input($_POST['medicine_name']);
    $generic_name = clean_input($_POST['generic_name']);
    $description = clean_input($_POST['description']);
    $dosage_form = clean_input($_POST['dosage_form']);
    $strength = clean_input($_POST['strength']);
    $quantity = clean_input($_POST['quantity']);
    $unit = clean_input($_POST['unit']);
    $expiry_date = clean_input($_POST['expiry_date']);
    $supplier = clean_input($_POST['supplier']);
    $reorder_level = clean_input($_POST['reorder_level']);
    
    $sql = "INSERT INTO medicine_inventory (medicine_name, generic_name, description, dosage_form, strength, quantity_in_stock, unit, expiry_date, supplier, reorder_level, date_added) 
            VALUES ('$medicine_name', '$generic_name', '$description', '$dosage_form', '$strength', '$quantity', '$unit', '$expiry_date', '$supplier', '$reorder_level', CURDATE())";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: medicines.php");
        exit();
    }
}
?>

<div class="container">
    <div class="card">
        <h3>Add New Medicine</h3>
        <form method="POST" action="">
            <div class="form-row">
                <div class="form-group">
                    <label>Medicine Name *</label>
                    <input type="text" name="medicine_name" required>
                </div>
                
                <div class="form-group">
                    <label>Generic Name</label>
                    <input type="text" name="generic_name">
                </div>
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="2"></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Dosage Form</label>
                    <select name="dosage_form">
                        <option value="">Select</option>
                        <option value="Tablet">Tablet</option>
                        <option value="Capsule">Capsule</option>
                        <option value="Syrup">Syrup</option>
                        <option value="Suspension">Suspension</option>
                        <option value="Injection">Injection</option>
                        <option value="Ointment">Ointment</option>
                        <option value="Cream">Cream</option>
                        <option value="Drops">Drops</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Strength</label>
                    <input type="text" name="strength" placeholder="e.g., 500mg">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Quantity *</label>
                    <input type="number" name="quantity" required>
                </div>
                
                <div class="form-group">
                    <label>Unit</label>
                    <select name="unit">
                        <option value="pcs">Pieces</option>
                        <option value="bottles">Bottles</option>
                        <option value="boxes">Boxes</option>
                        <option value="tubes">Tubes</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Expiry Date *</label>
                    <input type="date" name="expiry_date" required>
                </div>
                
                <div class="form-group">
                    <label>Reorder Level</label>
                    <input type="number" name="reorder_level" value="10">
                </div>
            </div>
            
            <div class="form-group">
                <label>Supplier</label>
                <input type="text" name="supplier">
            </div>
            
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Save Medicine</button>
                <a href="medicines.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>