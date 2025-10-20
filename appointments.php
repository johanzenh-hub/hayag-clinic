<?php 
$page_title = "Appointments";
include 'includes/header.php';
?>

<div class="container">
    <div class="card">
        <h3>Appointments</h3>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Patient Type</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM appointments ORDER BY appointment_date DESC, appointment_time DESC LIMIT 50";
                    $result = mysqli_query($conn, $sql);
                    
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $status_color = '';
                            switch($row['status']) {
                                case 'Scheduled': $status_color = 'color: blue;'; break;
                                case 'Completed': $status_color = 'color: green;'; break;
                                case 'Cancelled': $status_color = 'color: red;'; break;
                                case 'No Show': $status_color = 'color: gray;'; break;
                            }
                            
                            echo "<tr>";
                            echo "<td>" . date('M d, Y', strtotime($row['appointment_date'])) . "</td>";
                            echo "<td>" . date('h:i A', strtotime($row['appointment_time'])) . "</td>";
                            echo "<td>" . $row['patient_type'] . "</td>";
                            echo "<td>" . $row['reason'] . "</td>";
                            echo "<td style='$status_color font-weight: bold;'>" . $row['status'] . "</td>";
                            echo "<td><a href='#' class='btn btn-secondary' style='padding: 5px 10px; font-size: 12px;'>View</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' style='text-align:center;'>No appointments found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>