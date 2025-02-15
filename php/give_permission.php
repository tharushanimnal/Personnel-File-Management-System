<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];

    $sql = "SELECT can_edit_profiles FROM login WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($can_edit_profiles);
    $stmt->fetch();
    $stmt->close();

    if ($can_edit_profiles == 0) {
        $sql_update = "UPDATE login SET can_edit_profiles = 1 WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("i", $user_id);

        if ($stmt_update->execute()) {
            echo "Permission granted!";
        } else {
            echo "Error: Could not update permission.";
        }
        $stmt_update->close();
    } else {
        $sql_update = "UPDATE login SET can_edit_profiles = 0 WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("i", $user_id);

        if ($stmt_update->execute()) {
            echo "Permission revoked!";
        } else {
            echo "Error: Could not update permission.";
        }
        $stmt_update->close();
    }

    $conn->close();
}
?>
