<?php
include '../database/config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['method']) && $_POST['method'] === "like_method") {
        
        $user_id = isset($_POST['user_id']) ? trim($_POST['user_id']) : '';
        $post_id = isset($_POST['post_id']) ? trim($_POST['post_id']) : '';

        if (empty($user_id) || empty($post_id)) {
            echo json_encode(["status" => "201", "message" => "User ID and Post ID are required."]);
            exit;
        }

        if (!ctype_digit($user_id) || !ctype_digit($post_id)) {
            echo json_encode(["status" => "201", "message" => "Invalid ID format. Only numeric values are allowed."]);
            exit;
        }

        $user_id = (int) $user_id;
        $post_id = (int) $post_id;

        $userCheckQuery = "SELECT user_name FROM user_master WHERE user_id = $user_id";
        $postCheckQuery = "SELECT user_id FROM posts WHERE post_id = $post_id"; // Fetching post owner
        
        $userCheckResult = mysqli_query($conn, $userCheckQuery);
        $postCheckResult = mysqli_query($conn, $postCheckQuery);

        if (mysqli_num_rows($userCheckResult) == 0) {
            echo json_encode(["status" => "201", "message" => "User not found."]);
            exit;
        }

        if (mysqli_num_rows($postCheckResult) == 0) {
            echo json_encode(["status" => "201", "message" => "Post not found."]);
            exit;
        }

        // Fetch the sender's username
        $userData = mysqli_fetch_assoc($userCheckResult);
        $senderName = $userData['user_name'];

        // Fetch the post owner (receiver of notification)
        $postOwner = mysqli_fetch_assoc($postCheckResult)['user_id'];

        $checkQuery = "SELECT id, status FROM likes_master WHERE user_id = $user_id AND post_id = $post_id";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $row = mysqli_fetch_assoc($checkResult);
            $newStatus = ($row['status'] == 1) ? 0 : 1;

            $updateQuery = "UPDATE likes_master SET status = $newStatus, liked_at = NOW() WHERE id = " . $row['id'];
            if (mysqli_query($conn, $updateQuery)) {
                $message = ($newStatus == 1) ? "Post liked successfully." : "Post unliked successfully.";
                $response = ["status" => "200", "message" => $message, "new_status" => $newStatus];

                // Insert Notification Only When Liked (newStatus = 1)
                if ($newStatus == 1 && $postOwner != $user_id) {
                    $insertNotification = "INSERT INTO notifications (user_id, sender_id, type, post_id, message) 
                                           VALUES ($postOwner, $user_id, 2, $post_id, '$senderName liked your post.')";

                    mysqli_query($conn, $insertNotification);
                }
            } else {
                $response = ["status" => "201", "message" => "Action failed. Please try again."];
            }
        } else {
            $insertQuery = "INSERT INTO likes_master (user_id, post_id, status) VALUES ($user_id, $post_id, 1)";
            if (mysqli_query($conn, $insertQuery)) {
                $response = ["status" => "200", "message" => "Post liked successfully.", "new_status" => 1];

                // Insert Notification Only When Liked
                if ($postOwner != $user_id) {
                    $insertNotification = "INSERT INTO notifications (user_id, sender_id, type, post_id, message) 
                                           VALUES ($postOwner, $user_id, 2, $post_id, '$senderName liked your post.')";

                    mysqli_query($conn, $insertNotification);
                }
            } else {
                $response = ["status" => "201", "message" => "Like action failed. Please try again."];
            }
        }
    } else {
        $response = ["status" => "201", "message" => "Invalid request method."];
    }
} else {
    $response = ["status" => "201", "message" => "Only POST method is allowed."];
}

echo json_encode($response);
?>
