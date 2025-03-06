<?php
include '../database/config.php';

header("Content-Type: application/json");
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['method']) && $_POST['method'] === "add_comment") {
        // Collect Input Data
        if (!isset($_POST['user_id']) || !isset($_POST['post_id']) || !isset($_POST['comment'])) {
            $response = [
                "status" => "201",
                "message" => "User ID, Post ID, and Comment are required"
            ];
        } else {
            $user_id = trim($_POST['user_id']);
            $post_id = trim($_POST['post_id']);
            $comment = trim($_POST['comment']);

            // Validate user ID and post ID (should be numeric)
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
                // Check if post exists
                $checkPostQuery = "SELECT post_id FROM posts WHERE post_id = '$post_id'";
                $postResult = mysqli_query($conn, $checkPostQuery);

                if (mysqli_num_rows($postResult) == 0) {
                    $response = [
                        "status" => "201",
                        "message" => "Post not found"
                    ];
                } else {
                    // Insert Comment into `comment_master`
                    $insertCommentQuery = "INSERT INTO comments_master (post_id, user_id, comment) VALUES ('$post_id', '$user_id', '$comment')";
                    if (mysqli_query($conn, $insertCommentQuery)) {
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
