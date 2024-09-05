<?php
include 'database.php'; 

$sql = "SELECT employee_id, name1, position, photo FROM users"; // Replace 'your_table_name' with your actual table name
$result = $conn->query($sql);

$profiles = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $profiles[] = $row;
    }
}


echo json_encode($profiles);

$conn->close();
?>