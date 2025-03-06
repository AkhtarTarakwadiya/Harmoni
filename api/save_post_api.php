<?php

include '../database/config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['method']) && $_POST['method'] === "save_post_method") {
        
        // Collect Input Data
        $user_id = isset($_POST['user_id']) ? trim($_POST['user_id']) : '';
        $post_id = isset($_POST['post_id']) ? trim($_POST['post_id']) : '';

        // Validate Input
        if (empty($user_id) || empty($post_id)) {
            $response = [
                "status" => "201",
                "message" => "User ID and Post ID are required."
            ];
            echo json_encode($response);
            exit;
        }

        if (!ctype_digit($user_id) || !ctype_digit($post_id)) {
            $response = [
                "status" => "201",
                "message" => "Invalid ID format. Only numeric values are allowed."
            ];
            echo json_encode($response);
            exit;
        }

        // Convert IDs to integers for safety
        $user_id = (int) $user_id;
        $post_id = (int) $post_id;

        // Check if user and post exist
        $userCheckQuery = "SELECT user_id FROM user_master WHERE user_id = $user_id";
        $postCheckQuery = "SELECT post_id FROM posts WHERE post_id = $post_id";

        $userCheckResult = mysqli_query($conn, $userCheckQuery);
        $postCheckResult = mysqli_query($conn, $postCheckQuery);

        if (mysqli_num_rows($userCheckResult) == 0) {
            $response = [
                "status" => "201",
                "message" => "User not found."
            ];
            echo json_encode($response);
            exit;
        }

        if (mysqli_num_rows($postCheckResult) == 0) {
            $response = [
                "status" => "201",
                "message" => "Post not found."
            ];
            echo json_encode($response);
            exit;
        }

        // Check if a save record exists
        $checkQuery = "SELECT save_post_id, status FROM save_posts_master WHERE user_id = $user_id AND post_id = $post_id";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $row = mysqli_fetch_assoc($checkResult);
            $newStatus = ($row['status'] == 1) ? 0 : 1; // Toggle status (1 → 0, 0 → 1)

            // Update save status
            $updateQuery = "UPDATE save_posts_master SET status = $newStatus, updated_at = NOW() WHERE save_post_id = " . $row['save_post_id'];
            if (mysqli_query($conn, $updateQuery)) {
                $response = [
                    "status" => "200",
                    "message" => ($newStatus == 1) ? "Post saved successfully." : "Post unsaved successfully.",
                    "new_status" => $newStatus
                ];
            } else {
                $response = [
                    "status" => "201",
                    "message" => "Action failed. Please try again."
                ];
            }
        } else {
            // Insert new save record (if never saved before)
            $insertQuery = "INSERT INTO save_posts_master (user_id, post_id, status) VALUES ($user_id, $post_id, 1)";
            if (mysqli_query($conn, $insertQuery)) {
                $response = [
                    "status" => "200",
                    "message" => "Post saved successfully.",
                    "new_status" => 1
                ];
            } else {
                $response = [
                    "status" => "201",
                    "message" => "Save action failed. Please try again."
                ];
            }
        }
    } else {
        $response = [
            "status" => "201",
            "message" => "Invalid request method."
        ];
    }
} else {
    $response = [
        "status" => "201",
        "message" => "Only POST method is allowed."
    ];
}

echo json_encode($response);
?>