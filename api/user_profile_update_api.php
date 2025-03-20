<?php
include '../database/config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['method']) && $_POST['method'] === "update_user_profile") {

        $user_id = trim($_POST['user_id']);
        $user_name = trim($_POST['user_name']);
        $user_full_name = trim($_POST['user_full_name']);
        $user_email = trim($_POST['user_email']);
        $user_phone_number = trim($_POST['user_phone_number']);
        $gender = trim($_POST['gender']);
        $user_bio = isset($_POST['user_bio']) ? trim($_POST['user_bio']) : null;

        // Set correct upload directory
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/Harmoni/uploads/";
        $user_profile_photo = "";

        if (isset($_FILES['user_profile_photo']) && $_FILES['user_profile_photo']['error'] == 0) {
            $file_name = time() . '_' . basename($_FILES['user_profile_photo']['name']);
            $file_path = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['user_profile_photo']['tmp_name'], $file_path)) {
                $user_profile_photo = "/uploads/" . $file_name; 
            } else {
                $response = [
                    "status" => "201",
                    "message" => "Profile photo upload failed. Check folder permissions."
                ];
                echo json_encode($response);
                exit();
            }
        }

        if (empty($user_id) || empty($user_name) || empty($user_full_name) || empty($user_email) || empty($user_phone_number) || empty($gender)) {
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

        $checkUserQuery = "SELECT user_id, user_profile_photo FROM user_master WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $checkUserQuery);

        if (mysqli_num_rows($result) == 0) {
            $response = [
                "status" => "201",
                "message" => "User not found."
            ];
            echo json_encode($response);
            exit();
        }

        $existingUser = mysqli_fetch_assoc($result);
        $existing_photo_path = $_SERVER['DOCUMENT_ROOT'] . $existingUser['user_profile_photo'];

        // Delete old profile photo if new one is uploaded
        if (!empty($user_profile_photo) && !empty($existingUser['user_profile_photo']) && file_exists($existing_photo_path)) {
            unlink($existing_photo_path);
        }

        // Check for duplicate username, email, or phone (excluding current user)
        $checkQuery = "SELECT user_id FROM user_master WHERE (user_email = '$user_email' OR user_phone_number = '$user_phone_number' OR user_name = '$user_name') AND user_id != '$user_id'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $response = [
                "status" => "201",
                "message" => "Username, email, or phone number already in use by another account."
            ];
            echo json_encode($response);
            exit();
        }

        // Update user profile
        $updateQuery = "UPDATE user_master SET user_name = '$user_name', user_full_name = '$user_full_name', user_email = '$user_email', user_phone_number = '$user_phone_number', gender = '$gender', user_bio = '$user_bio'";
        if (!empty($user_profile_photo)) {
            $updateQuery .= ", user_profile_photo = '$user_profile_photo'";
        }
        $updateQuery .= " WHERE user_id = '$user_id'";

        if (mysqli_query($conn, $updateQuery)) {
            $response = [
                "status" => "200",
                "message" => "Profile updated successfully."
            ];
        } else {
            $response = [
                "status" => "201",
                "message" => "Profile update failed. Please try again."
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
