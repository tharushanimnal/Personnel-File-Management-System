<?php
header('Content-Type: application/json');
include 'database.php'; 

$sql = "SELECT position, COUNT(*) AS count FROM users GROUP BY position";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$conn->close();

echo json_encode($data);
?>