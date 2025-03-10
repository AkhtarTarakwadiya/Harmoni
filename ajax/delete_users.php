<?php
include '../database/db.php';

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Fetch current status
    $query = "SELECT user_status FROM user_master WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $new_status = $row['user_status'] == 1 ? 0 : 1;

        // Update user_status
        $updateQuery = "UPDATE user_master SET user_status = $new_status WHERE user_id = $user_id";
        if (mysqli_query($conn, $updateQuery)) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to Delete User"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "User not found"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}

mysqli_close($conn);
