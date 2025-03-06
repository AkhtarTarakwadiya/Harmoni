<?php

include '../database/config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['method']) && $_POST['method'] === "get_saved_posts") {

        // Collect and Validate User ID
        $user_id = isset($_POST['user_id']) ? trim($_POST['user_id']) : '';

        if (empty($user_id) || !ctype_digit($user_id)) {
            $response = [
                "status" => "201",
                "message" => "Valid User ID is required."
            ];
            echo json_encode($response);
            exit;
        }

        $user_id = (int) $user_id;

        // Define the media base path
        $media_base_url = "http://192.168.4.220/Harmoni/uploads/posts/";

        // Fetch saved posts with media and post author's username
        $query = "SELECT p.post_id, p.post_content, MAX(spm.created_at) AS saved_at, 
                         p.created_at AS post_created_at, u.user_name AS post_author, 
                         GROUP_CONCAT(pm.media) AS media_urls 
                  FROM save_posts_master spm 
                  JOIN posts p ON spm.post_id = p.post_id 
                  JOIN user_master u ON p.user_id = u.user_id 
                  LEFT JOIN posts_media_master pm ON p.post_id = pm.post_id
                  WHERE spm.user_id = $user_id AND spm.status = 1
                  GROUP BY p.post_id, p.post_content, p.created_at, u.user_name 
                  ORDER BY saved_at DESC";

        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $saved_posts = [];
            while ($row = mysqli_fetch_assoc($result)) {
                // Convert comma-separated media names into an array
                $media_files = !empty($row['media_urls']) ? explode(',', $row['media_urls']) : [];

                // Add base path to each media file
                $row['media_urls'] = array_map(function ($media) use ($media_base_url) {
                    return $media_base_url . $media;
                }, $media_files);

                $saved_posts[] = $row;
            }

            $response = [
                "status" => "200",
                "message" => "Saved posts retrieved successfully.",
                "data" => $saved_posts
            ];
        } else {
            $response = [
                "status" => "201",
                "message" => "No saved posts found."
            ];
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
