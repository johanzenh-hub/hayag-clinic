<?php 
$page_title = "Students";
include 'includes/header.php';

$success = isset($_GET['success']) ? $_GET['success'] : '';
?>

<div class="container">
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3>Student Records</h3>
            <a href="add_student.php" class="btn btn-primary">+ Add Student</a>
        </div>
        
        <?php if($success == 'added'): ?>
            <div class="alert alert-success">Student added successfully!</div>
        <?php endif; ?>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Student Number</th>
                        <th>Name</th>
                        <th>Grade Level</th>
                        <th>Section</th>
                        <th>Blood Type</th>
                        <th>Contact</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM students ORDER BY last_name, first_name";
                    $result = mysqli_query($conn, $sql);
                    
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['student_number'] . "</td>";
                            echo "<td>" . $row['last_name'] . ", " . $row['first_name'] . "</td>";
                            echo "<td>" . $row['grade_level'] . "</td>";
                            echo "<td>" . $row['section'] . "</td>";
                            echo "<td>" . $row['blood_type'] . "</td>";
                            echo "<td>" . $row['contact_number'] . "</td>";
                            echo "<td>
                                    <a href='view_student.php?id=" . $row['student_id'] . "' class='btn btn-secondary' style='padding: 5px 10px; font-size: 12px;'>View</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align:center;'>No students found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>