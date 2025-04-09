<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../database/config.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';

header("Content-Type: application/json");
$response = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['method']) || $_POST['method'] !== "send_otp") {
        $response = [
            "status" => "201",
            "message" => "Invalid Request Method"
        ];
        echo json_encode($response);
        exit;
    }

    // Validate email
    if (!isset($_POST['email']) || empty(trim($_POST['email']))) {
        $response = [
            "status" => "201",
            "message" => "Email is required"
        ];
        echo json_encode($response);
        exit;
    }

    $email = trim($_POST['email']);

    // Check if email exists
    $userQuery = "SELECT user_id FROM user_master WHERE user_email = '$email'";
    $result = mysqli_query($conn, $userQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];

        // Generate a 4-digit OTP
        $otp = mt_rand(1000, 9999);

        // Invalidate previous OTPs
        $invalidateQuery = "UPDATE otp_verification SET is_verified = 1 WHERE user_id = '$user_id'";
        mysqli_query($conn, $invalidateQuery);

        // Insert new OTP with expiry (10 minutes after created_at)
        $insertQuery = "INSERT INTO otp_verification (user_id, otp_code, otp_expiry, is_verified, created_at) 
                        VALUES ('$user_id', '$otp', DATE_ADD(NOW(), INTERVAL 10 MINUTE), 0, NOW())";

        if (!mysqli_query($conn, $insertQuery)) {
            $response = [
                "status" => "201",
                "message" => "Database error: " . mysqli_error($conn)
            ];
            echo json_encode($response);
            exit;
        }

        // Send OTP via Email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'services.harmony.app@gmail.com'; 
            $mail->Password = 'bzig xgav cfel tqea'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('services.harmony.app@gmail.com', 'Harmony');
            $mail->addAddress($email);
            $mail->addReplyTo('services.harmony.app@gmail.com', 'Harmony Support');
            $mail->addCustomHeader('Return-Path', 'services.harmony.app@gmail.com');

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body = '
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 500px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #333;
        }
        .otp-box {
            background-color: #007bff;
            color: #ffffff;
            font-size: 24px;
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
            margin: 20px 0;
            letter-spacing: 2px;
        }
        p {
            font-size: 16px;
            color: #666;
        }
        .footer {
            font-size: 12px;
            color: #aaa;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>OTP Verification</h2>
        <p>Your One-Time Password (OTP) for verification is:</p>
        <div class="otp-box">' . $otp . '</div>
        <p>This OTP is valid for <strong>10 minutes</strong>. Please do not share it with anyone.</p>
        <p>If you did not request this, please ignore this email.</p>
        <div class="footer">
            &copy; ' . date("Y") . ' Your Company. All rights reserved.
        </div>
    </div>
</body>
</html>';


            $mail->send();

            $response = [
                "status" => "200",
                "message" => "OTP sent to your email.",
            ];
        } catch (Exception $e) {
            $response = [
                "status" => "201",
                "message" => "Email not sent. Error: " . $mail->ErrorInfo
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
