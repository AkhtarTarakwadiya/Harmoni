<?php
include '../database/config.php';

header("Content-Type: application/json");
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['method']) || $_POST['method'] !== "reset_password") {
        $response = [
            "status" => "201",
            "message" => "Invalid Request Method"
        ];
        echo json_encode($response);
        exit;
    }

    if (!isset($_POST['email'], $_POST['password'], $_POST['confirm_password'])) {
        $response = [
            "status" => "201",
            "message" => "Email, Password, and Confirm Password are required"
        ];
        echo json_encode($response);
        exit;
    }

    $email = trim($_POST['email']);
    $new_password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($new_password !== $confirm_password) {
        $response = [
            "status" => "201",
            "message" => "Passwords not match"
        ];
        echo json_encode($response);
        exit;
    }

    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    $userQuery = "SELECT user_id FROM user_master WHERE user_email = '$email'";
    $result = mysqli_query($conn, $userQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];

        // Check if OTP is verified
        $otpCheck = "SELECT * FROM otp_verification WHERE user_id = '$user_id' AND is_verified = 1";
        $otpResult = mysqli_query($conn, $otpCheck);

        if ($otpResult && mysqli_num_rows($otpResult) > 0) {

            $updatePassword = "UPDATE user_master SET user_password = '$hashed_password' WHERE user_id = '$user_id'";
            if (mysqli_query($conn, $updatePassword)) {

                $invalidateOTP = "UPDATE otp_verification SET is_verified = 2 WHERE user_id = '$user_id'";
                mysqli_query($conn, $invalidateOTP);

                $response = [
                    "status" => "200",
                    "message" => "Password reset successfully"
                ];
            } else {
                $response = [
                    "status" => "201",
                    "message" => "Failed to update password"
                ];
            }
        } else {
            $response = [
                "status" => "201",
                "message" => "OTP not verified"
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
?>
