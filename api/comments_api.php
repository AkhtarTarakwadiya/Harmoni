<?php
include '../database/config.php';

header("Content-Type: application/json");
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['method']) && $_POST['method'] === "add_comment") {
        if (!isset($_POST['user_id']) || !isset($_POST['post_id']) || !isset($_POST['comment'])) {
            $response = [
                "status" => "201",
                "message" => "User ID, Post ID, and Comment are required"
            ];
        } else {
            $user_id = trim($_POST['user_id']);
            $post_id = trim($_POST['post_id']);
            $comment = trim($_POST['comment']);

            if (!ctype_digit($user_id) || !ctype_digit($post_id)) {
                $response = [
                    "status" => "201",
                    "message" => "Invalid User ID or Post ID"
                ];
            } elseif (strlen($comment) < 3) {
                $response = [
                    "status" => "201",
                    "message" => "Comment must be at least 3 characters long"
                ];
            } else {
                // Check if post exists and get post owner ID
                $postQuery = "SELECT user_id FROM posts WHERE post_id = '$post_id'";
                $postResult = mysqli_query($conn, $postQuery);

                if (mysqli_num_rows($postResult) == 0) {
                    $response = [
                        "status" => "201",
                        "message" => "Post not found"
                    ];
                } else {
                    $postData = mysqli_fetch_assoc($postResult);
                    $postOwnerId = $postData['user_id']; // User ID of the post owner

                    // Fetch commenter's username
                    $commenterQuery = "SELECT user_name FROM user_master WHERE user_id = '$user_id'";
                    $commenterResult = mysqli_query($conn, $commenterQuery);
                    $commenterData = mysqli_fetch_assoc($commenterResult);
                    $commenterUsername = $commenterData['user_name'];

                    // Fetch post owner's username
                    $postOwnerQuery = "SELECT user_name FROM user_master WHERE user_id = '$postOwnerId'";
                    $postOwnerResult = mysqli_query($conn, $postOwnerQuery);
                    $postOwnerData = mysqli_fetch_assoc($postOwnerResult);
                    $postOwnerUsername = $postOwnerData['user_name'];

                    // Insert Comment
                    $insertCommentQuery = "INSERT INTO comments_master (post_id, user_id, comment) VALUES ('$post_id', '$user_id', '$comment')";
                    
                    if (mysqli_query($conn, $insertCommentQuery)) {
                        // Insert Notification with Username
                        $notificationMessage = "$commenterUsername commented on your post.";
                        $notificationQuery = "INSERT INTO notifications (user_id, sender_id, type, post_id, message) 
                                              VALUES ('$postOwnerId', '$user_id', 3, '$post_id', '$notificationMessage')";

                        mysqli_query($conn, $notificationQuery); // Execute Notification Query

                        $response = [
                            "status" => "200",
                            "message" => "Comment added successfully"
                        ];
                    } else {
                        $response = [
                            "status" => "201",
                            "message" => "Failed to add comment"
                        ];
                    }
                }
            }
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
?>
