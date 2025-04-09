<?php
require '../database/config.php';

header("Content-Type: application/json");
$response = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_POST['method']) || $_POST['method'] !== "verify_otp") {
        $response = [
            "status" => "201",
            "message" => "Invalid Request Method"
        ];
        echo json_encode($response);
        exit;
    }

    
    if (!isset($_POST['email'], $_POST['otp']) || empty(trim($_POST['email'])) || empty(trim($_POST['otp']))) {
        $response = [
            "status" => "201",
            "message" => "Email and OTP are required"
        ];
        echo json_encode($response);
        exit;
    }

    $email = trim($_POST['email']);
    $otp = trim($_POST['otp']);

    $userQuery = "SELECT user_id FROM user_master WHERE user_email = '$email'";
    $result = mysqli_query($conn, $userQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];

        // Check if OTP is valid and within 10 minutes of created_at
        $otpQuery = "SELECT * FROM otp_verification 
                     WHERE user_id = '$user_id' 
                     AND otp_code = '$otp' 
                     AND created_at >= NOW() - INTERVAL 10 MINUTE
                     AND is_verified = 0";

        $otpResult = mysqli_query($conn, $otpQuery);

        if (!$otpResult) {
            $response = [
                "status" => "201",
                "message" => "Query Error: " . mysqli_error($conn)
            ];
            echo json_encode($response);
            exit;
        }

        if (mysqli_num_rows($otpResult) > 0) {

            $updateQuery = "UPDATE otp_verification SET is_verified = 1 WHERE user_id = '$user_id' AND otp_code = '$otp'";
            mysqli_query($conn, $updateQuery);

            $response = [
                "status" => "200",
                "message" => "OTP verified successfully"
            ];
        } else {
            $response = [
                "status" => "201",
                "message" => "Invalid or expired OTP"
            ];
        }
    } else {
        $response = [
            "status" => "201",
            "message" => "Email not found"
        ];
    }
} else {
    $response = [
        "status" => "201",
        "message" => "Only POST Method Allowed"
    ];
}

echo json_encode($response);
