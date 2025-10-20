<?php 
$page_title = "Medicine Inventory";
include 'includes/header.php';
?>

<div class="container">
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3>Medicine Inventory</h3>
            <a href="add_medicine.php" class="btn btn-primary">+ Add Medicine</a>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Medicine Name</th>
                        <th>Generic Name</th>
                        <th>Dosage Form</th>
                        <th>Strength</th>
                        <th>Stock</th>
                        <th>Expiry Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM medicine_inventory ORDER BY medicine_name";
                    $result = mysqli_query($conn, $sql);
                    
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $status = '';
                            $style = '';
                            
                            if ($row['quantity_in_stock'] <= $row['reorder_level']) {
                                $status = 'Low Stock';
                                $style = 'color: red; font-weight: bold;';
                            } elseif (strtotime($row['expiry_date']) < strtotime('+3 months')) {
                                $status = 'Near Expiry';
                                $style = 'color: orange; font-weight: bold;';
                            } else {
                                $status = 'Good';
                                $style = 'color: green;';
                            }
                            
                            echo "<tr>";
                            echo "<td>" . $row['medicine_name'] . "</td>";
                            echo "<td>" . $row['generic_name'] . "</td>";
                            echo "<td>" . $row['dosage_form'] . "</td>";
                            echo "<td>" . $row['strength'] . "</td>";
                            echo "<td>" . $row['quantity_in_stock'] . " " . $row['unit'] . "</td>";
                            echo "<td>" . date('M d, Y', strtotime($row['expiry_date'])) . "</td>";
                            echo "<td style='$style'>" . $status . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align:center;'>No medicines found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>