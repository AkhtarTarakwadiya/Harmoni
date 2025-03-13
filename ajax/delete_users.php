<?php
include '../database/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = intval($_POST['user_id']); // Ensuring it's an integer
    $newStatus = intval($_POST['user_status']);

    $sql = "UPDATE user_master SET user_status = $newStatus WHERE user_id = $userId";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update user status"]);
    }

    mysqli_close($conn);
}
?>
