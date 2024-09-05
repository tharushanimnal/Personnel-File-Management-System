<?php
include 'database.php';

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO salary_increments (employee_id, increment_date, increment_active, increment_reduction, reduction_duration, temporary_suspension, permanent_suspension, suspension_duration) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind the parameters
$stmt->bind_param("ssisssss", $employee_id, $increment_date, $increment_active, $increment_reduction, $reduction_duration, $temporary_suspension, $permanent_suspension, $suspension_duration);

// Assign POST data to variables
$employee_id = $_POST['employee-id'];
$increment_date = $_POST['sinc'];
$increment_active = $_POST['salarys'] === 'yes' ? 1 : 0;
$increment_reduction = $_POST['salaryr'];
$reduction_duration = $_POST['timep'];
$temporary_suspension = $_POST['timetp'];
$permanent_suspension = $_POST['salarysp'] === 'yes' ? 1 : 0;
$suspension_duration = $_POST['timesp'];

// Execute the statement
if ($stmt->execute()) {
    // Redirect to the form page with a success message
    header("Location: /Personnel-File-Management-System/salary.html?success=1");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and database connection
$stmt->close();
$conn->close();
?>
