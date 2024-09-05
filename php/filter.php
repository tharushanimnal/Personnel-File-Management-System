<?php
include 'database.php';

$increment_date = isset($_GET['increment_date']) ? $_GET['increment_date'] : '';
$report_date = isset($_GET['report_date']) ? $_GET['report_date'] : '';
$efficiency_bar = isset($_GET['rank']) ? $_GET['rank'] : '';
$tdate = isset($_GET['tra_date']) ? $_GET['tra_date'] : ''; 

$query = "SELECT name1, increment_date, appointment_date, grade, date_transfer, retirement_date, efficiency_bar FROM users WHERE 1=1";

if (!empty($increment_date)) {
    $query .= " AND DATE_FORMAT(increment_date, '%Y-%m') = ?";
}
if (!empty($report_date)) {
    $query .= " AND DATE_FORMAT(appointment_date, '%Y-%m') = ?";
}
if (!empty($efficiency_bar)) {
    $query .= " AND efficiency_bar = ?";
}
if (!empty($tdate)) {
    $query .= " AND DATE_FORMAT(date_transfer, '%Y-%m') = ?"; 
}

$stmt = $conn->prepare($query);

$params = [];
$types = "";

if (!empty($increment_date)) {
    $types .= "s";
    $params[] = $increment_date; 
}
if (!empty($report_date)) {
    $types .= "s";
    $params[] = $report_date;
}
if (!empty($efficiency_bar)) {
    $types .= "s";
    $params[] = $efficiency_bar;
}
if (!empty($tdate)) {
    $types .= "s";
    $params[] = $tdate;
}

if (!empty($types)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['name1']) . "</td>";
        echo "<td>" . htmlspecialchars($row['increment_date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['appointment_date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['grade']) . "</td>";
        echo "<td>" . htmlspecialchars($row['date_transfer']) . "</td>";
        echo "<td>" . htmlspecialchars($row['retirement_date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['efficiency_bar']) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No results found</td></tr>";
}

$stmt->close();
?>
