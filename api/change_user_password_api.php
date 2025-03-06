<?php
include '../database/config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['method']) && $_POST['method'] === "change_password") {
        // Collect Input Data
        $user_id = trim($_POST['user_id']);
        $old_password = trim($_POST['old_password']);
        $new_password = trim($_POST['new_password']);

        // Validation
        if (empty($user_id) || empty($old_password) || empty($new_password)) {
            $response = [
                "status" => "201",
                "message" => "All fields are required."
            ];
            echo json_encode($response);
            exit();
        }

        // Check if user exists
        $query = "SELECT user_id, user_password FROM user_master WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            // Verify old password
            if (!password_verify($old_password, $user['user_password'])) {
                $response = [
                    "status" => "201",
                    "message" => "Incorrect old password."
                ];
                echo json_encode($response);
                exit();
            }

            // Hash new password
            $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);

            // Update password in database
            $updateQuery = "UPDATE user_master SET user_password = '$hashed_new_password' WHERE user_id = '$user_id'";
            if (mysqli_query($conn, $updateQuery)) {
                $response = [
                    "status" => "200",
                    "message" => "Password changed successfully."
                ];
            } else {
                $response = [
                    "status" => "201",
                    "message" => "Password update failed. Please try again."
                ];
            }
        } else {
            $response = [
                "status" => "201",
                "message" => "User not found."
            ];
        }
    } else {
        $response = [
            "status" => "201",
            "message" => "Invalid Request Method"
        ];
    }
} else {
    $response = [
        "status" => "201",
        "message" => "Only POST Method Allowed"
    ];
}

echo json_encode($response);
