<?php
include '../database/config.php';

header("Content-Type: application/json");
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['method']) && $_POST['method'] === "fetch_comments") {
        if (!isset($_POST['post_id'])) {
            $response = [
                "status" => "201",
                "message" => "Post ID is required"
            ];
        } else {
            $post_id = trim($_POST['post_id']);

            // Validate post ID (should be numeric)
            if (!ctype_digit($post_id)) {
                $response = [
                    "status" => "201",
                    "message" => "Invalid Post ID"
                ];
            } else {
                // Fetch comments
                $fetchCommentsQuery = "SELECT c.comment_id, c.user_id, u.user_name, c.comment, c.created_at 
                                      FROM comments_master c 
                                      LEFT JOIN user_master u ON c.user_id = u.user_id
                                      WHERE c.post_id = '$post_id' AND c.comment_status = 1
                                      ORDER BY c.created_at DESC";
                
                $result = mysqli_query($conn, $fetchCommentsQuery);
                
                if (mysqli_num_rows($result) > 0) {
                    $comments = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $comments[] = $row;
                    }
                    $response = [
                        "status" => "200",
                        "message" => "Comments fetched successfully",
                        "data" => $comments
                    ];
                } else {
                    $response = [
                        "status" => "201",
                        "message" => "No comments found"
                    ];
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
