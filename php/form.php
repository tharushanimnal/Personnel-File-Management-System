<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $employee_id = filter_var($_POST['employee-id'], FILTER_SANITIZE_STRING);
    $nic = filter_var($_POST['nic'], FILTER_SANITIZE_STRING);
    $name1 = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $position = filter_var($_POST['option1'], FILTER_SANITIZE_STRING);
    $appointment_date = filter_var($_POST['input1'], FILTER_SANITIZE_STRING);
    $permanent = filter_var($_POST['option4'], FILTER_SANITIZE_STRING);
    $grade = filter_var($_POST['input2'], FILTER_SANITIZE_STRING);
    $salary_code = filter_var($_POST['option2'], FILTER_SANITIZE_STRING);
    $increment_date = filter_var($_POST['input3'], FILTER_SANITIZE_STRING);
    $efficiency_bar = filter_var($_POST['option3'], FILTER_SANITIZE_STRING);
    $Diciplinary_investigations = filter_var($_POST['option5'], FILTER_SANITIZE_STRING);
    $dob = filter_var($_POST['dob'], FILTER_SANITIZE_STRING);
    $address1 = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
    $gender = filter_var($_POST['gender'], FILTER_SANITIZE_STRING);
    $status1 = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $whatsapp = filter_var($_POST['whatsapp'], FILTER_SANITIZE_STRING);

    // cal retierment date
    $dob_date = new DateTime($dob);
    $dob_date->modify('+60 years');
    $retirement_date = $dob_date->format('Y-m-d');

    // cal transfer date
    $appointment_date_obj = new DateTime($appointment_date);
    $appointment_date_obj->modify('+5 years');
    $date_transfer = $appointment_date_obj->format('Y-m-d');

    echo "Appointment Date: " . $appointment_date . "<br>";
    echo "Calculated Transfer Date: " . $date_transfer . "<br>";

    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/Personnel-File-Management-System/uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); 
    }

    $photo_name = $_FILES['photo']['name'];
    $photo_tmp_name = $_FILES['photo']['tmp_name'];
    $photo_folder = $upload_dir . $photo_name; 

    if (move_uploaded_file($photo_tmp_name, $photo_folder)) {
        $relative_path = 'uploads/' . $photo_name; 

        $stmt = $conn->prepare("INSERT INTO users (employee_id, nic, name1, position, appointment_date, permanent, grade, salary_code, increment_date, efficiency_bar, Diciplinary_investigations, date_transfer, retirement_date, dob, address1, gender, status1, email, whatsapp, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ssssssssssssssssssss", $employee_id, $nic, $name1, $position, $appointment_date, $permanent, $grade, $salary_code, $increment_date, $efficiency_bar, $Diciplinary_investigations, $date_transfer, $retirement_date, $dob, $address1, $gender, $status1, $email, $whatsapp, $relative_path);

        if ($stmt->execute()) {
            header("Location: /Personnel-File-Management-System/form.html?success=1");
            exit();
        } else {
            echo "Execute failed: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Failed to upload photo.";
    }
}

//next employee_id
$sql = "SELECT MAX(employee_id) as max_id FROM users";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $next_employee_id = $row['max_id'] + 1;
    echo json_encode(['next_employee_id' => $next_employee_id]);
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
