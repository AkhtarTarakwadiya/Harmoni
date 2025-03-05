<?php
include '../database/config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['method']) && $_POST['method'] === "fetch_posts") {
        // Validate and sanitize the page parameter
        $page = isset($_POST['page']) && ctype_digit($_POST['page']) ? intval($_POST['page']) : 1;

        $limit = 5; // Number of posts per page
        $offset = ($page - 1) * $limit;

        // Fetch only posts where status = 1
        $fetchPostsQuery = "SELECT p.post_id, p.user_id, p.post_content, p.created_at, 
                            GROUP_CONCAT(pm.media) AS media_files
                            FROM posts p
                            LEFT JOIN posts_media_master pm ON p.post_id = pm.post_id
                            WHERE p.post_status = 1
                            GROUP BY p.post_id 
                            ORDER BY p.created_at DESC 
                            LIMIT $limit OFFSET $offset";

        $result = mysqli_query($conn, $fetchPostsQuery);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $posts = [];

                while ($row = mysqli_fetch_assoc($result)) {
                    // Ensure proper format for media files
                    $mediaFiles = !empty($row['media_files'])
                        ? array_map(fn($file) => "http://localhost/Harmoni/uploads/posts/" . $file, explode(',', $row['media_files']))
                        : [];

                    $posts[] = [
                        "post_id" => (int)$row['post_id'],
                        "user_id" => (int)$row['user_id'],
                        "post_content" => htmlspecialchars($row['post_content']), // Prevent XSS
                        "created_at" => $row['created_at'],
                        "media_files" => $mediaFiles
                    ];
                }

                $response = [
                    "status" => "200",
                    "message" => "Posts fetched successfully",
                    "posts" => $posts
                ];
            } else {
                $response = [
                    "status" => "201",
                    "message" => "No posts found"
                ];
            }
        } else {
            $response = [
                "status" => "500",
                "message" => "Database query failed: " . mysqli_error($conn)
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
