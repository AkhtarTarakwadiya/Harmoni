<?php
include '../database/config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['method']) && $_POST['method'] === "register_user") {
        // Collect Input Data
        $user_name = trim($_POST['user_name']);
        $user_full_name = trim($_POST['user_full_name']);
        $user_email = trim($_POST['user_email']);
        $user_phone_number = trim($_POST['user_phone_number']);
        $user_password = trim($_POST['user_password']);
        $gender = trim($_POST['gender']);
        $user_profile_photo = isset($_POST['user_profile_photo']) ? trim($_POST['user_profile_photo']) : "";

        // Default profile image if not provided
        if (empty($user_profile_photo)) {
            $user_profile_photo = "/uploads/profile3.webp";  // Set default image path
        }

        $user_bio = isset($_POST['user_bio']) ? trim($_POST['user_bio']) : null;

        // Validation
        if (empty($user_name) || empty($user_full_name) || empty($user_email) || empty($user_phone_number) || empty($user_password) || empty($gender)) {
            $response = [
                "status" => "201",
                "message" => "All fields except profile photo are required."
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

        if (!preg_match('/^[0-9]{10}$/', $user_phone_number)) {
            $response = [
                "status" => "201",
                "message" => "Phone number must be 10 digits."
            ];
            echo json_encode($response);
            exit();
        }

        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);

        // Check if username, email, or phone already exists
        $checkQuery = "SELECT user_id, user_name, user_email, user_phone_number FROM user_master 
                       WHERE user_email = '$user_email' OR user_phone_number = '$user_phone_number' OR user_name = '$user_name'";
        $result = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($result) > 0) {
            $existingUser = mysqli_fetch_assoc($result);
            if ($existingUser['user_name'] === $user_name) {
                $response = [
                    "status" => "201",
                    "message" => "Username already used."
                ];
            } elseif ($existingUser['user_email'] === $user_email) {
                $response = [
                    "status" => "201",
                    "message" => "Email already registered."
                ];
            } elseif ($existingUser['user_phone_number'] === $user_phone_number) {
                $response = [
                    "status" => "201",
                    "message" => "Phone number already registered."
                ];
            }
            echo json_encode($response);
            exit();
        }

        // Insert new user
        $query = "INSERT INTO user_master (user_name, user_full_name, user_email, user_phone_number, user_password, gender, user_profile_photo, user_bio) 
                  VALUES ('$user_name', '$user_full_name', '$user_email', '$user_phone_number', '$hashed_password', '$gender', '$user_profile_photo', '$user_bio')";

        if (mysqli_query($conn, $query)) {
            $response = [
                "status" => "200",
                "message" => "Registration successful."
            ];
        } else {
            $response = [
                "status" => "201",
                "message" => "Registration failed. Please try again."
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
