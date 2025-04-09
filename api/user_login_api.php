<?php
include '../database/config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['method']) && $_POST['method'] === "login_user") {

        $user_email = trim($_POST['user_email']);
        $user_password = trim($_POST['user_password']);

        if (empty($user_email) || empty($user_password)) {
            $response = [
                "status" => "201",
                "message" => "Email and password are required."
            ];
            echo json_encode($response);
            exit();
        }

        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $response = [
                "status" => "201",
                "message" => "Invalid email format."
            ];
            echo json_encode($response);
            exit();
        }

        // Check if user exists
        $query = "SELECT user_id, user_name, user_full_name, user_email, user_password,user_phone_number,gender,user_bio, user_profile_photo, user_status, user_isblock FROM user_master WHERE user_email = '$user_email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Check if account is active
            if ($user['user_status'] == 0) {
                $response = [
                    "status" => "201",
                    "message" => "Your Account Not Found."
                ];
                echo json_encode($response);
                exit();
            }

            // Check if account is blocked
            if ($user['user_isblock'] == 0) {
                $response = [
                    "status" => "201",
                    "message" => "Your Account is disabled by the admin."
                ];
                echo json_encode($response);
                exit();
            }

            if (password_verify($user_password, $user['user_password'])) {
                $response = [
                    "status" => "200",
                    "message" => "Login successful.",
                    "user" => [
                        "user_id" => $user['user_id'],
                        "user_name" => $user['user_name'],
                        "user_full_name" => $user['user_full_name'],
                        "user_email" => $user['user_email'],
                        "user_phone_number" => $user['user_phone_number'],
                        "gender" => $user['gender'],
                        // "user_bio" => $user['user_bio'],
                        // "user_profile_photo" => "http://192.168.4.220/Harmoni" . $user['user_profile_photo']
                    ]
                ];
            } else {
                $response = [
                    "status" => "201",
                    "message" => "Incorrect password."
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