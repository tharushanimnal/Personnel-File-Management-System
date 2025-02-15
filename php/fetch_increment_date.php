<?php
include 'database.php';

$employee_id = isset($_GET['employee_id']) ? mysqli_real_escape_string($conn, $_GET['employee_id']) : '';

$query = "SELECT increment_date FROM users WHERE employee_id = '$employee_id'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode(['increment_date' => $row['increment_date']]);
} else {
    echo json_encode(['increment_date' => '']);
}
?>
