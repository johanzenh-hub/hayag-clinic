<?php 
$page_title = "Medical Records";
include 'includes/header.php';
?>

<div class="container">
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3>Medical Records</h3>
            <a href="add_medical_record.php" class="btn btn-primary">+ Add Record</a>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Patient Type</th>
                        <th>Chief Complaint</th>
                        <th>Diagnosis</th>
                        <th>Treatment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM medical_records ORDER BY visit_date DESC, visit_time DESC LIMIT 50";
                    $result = mysqli_query($conn, $sql);
                    
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . date('M d, Y', strtotime($row['visit_date'])) . "</td>";
                            echo "<td>" . date('h:i A', strtotime($row['visit_time'])) . "</td>";
                            echo "<td>" . $row['patient_type'] . "</td>";
                            echo "<td>" . $row['chief_complaint'] . "</td>";
                            echo "<td>" . $row['diagnosis'] . "</td>";
                            echo "<td>" . $row['treatment'] . "</td>";
                            echo "<td><a href='view_record.php?id=" . $row['record_id'] . "' class='btn btn-secondary' style='padding: 5px 10px; font-size: 12px;'>View</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align:center;'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>