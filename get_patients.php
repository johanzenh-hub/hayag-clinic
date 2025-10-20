<?php
require_once 'config/database.php';
check_login();

$type = isset($_GET['type']) ? clean_input($_GET['type']) : '';

if ($type == 'Student') {
    $sql = "SELECT student_id as id, CONCAT(last_name, ', ', first_name, ' - ', student_number) as name FROM students ORDER BY last_name, first_name";
} elseif ($type == 'Staff') {
    $sql = "SELECT staff_id as id, CONCAT(last_name, ', ', first_name, ' - ', staff_number) as name FROM staff ORDER BY last_name, first_name";
} else {
    echo '<option value="">Invalid patient type</option>';
    exit();
}

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<option value="">Select ' . $type . '</option>';
    while($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
    }
} else {
    echo '<option value="">No ' . $type . ' found</option>';
}
?>