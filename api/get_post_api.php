<?php
include '../database/config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['method']) && $_POST['method'] === "fetch_posts") {
        $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0; 

        $fetchPostsQuery = "SELECT 
                                p.post_id, 
                                p.user_id, 
                                u.user_name, 
                                p.post_content, 
                                p.created_at, 
                                GROUP_CONCAT(DISTINCT pm.media) AS media_files,
                                COUNT(DISTINCT pl.id) AS like_count,
                                COUNT(DISTINCT pc.comment_id) AS comment_count,
                                IF(EXISTS (SELECT 1 FROM likes_master WHERE post_id = p.post_id AND user_id = $user_id), 1, 0) AS is_liked,
                                IF(EXISTS (SELECT 1 FROM comments_master WHERE post_id = p.post_id AND user_id = $user_id), 1, 0) AS is_commented,
                                IF(EXISTS (SELECT 1 FROM save_posts_master WHERE post_id = p.post_id AND user_id = $user_id), 1, 0) AS is_saved,
                                IF(EXISTS (SELECT 1 FROM follow_master WHERE following_id = p.user_id AND follower_id = $user_id), 1, 0) AS is_followed
                            FROM posts p
                            LEFT JOIN user_master u ON p.user_id = u.user_id
                            LEFT JOIN posts_media_master pm ON p.post_id = pm.post_id
                            LEFT JOIN likes_master pl ON p.post_id = pl.post_id
                            LEFT JOIN comments_master pc ON p.post_id = pc.post_id
                            WHERE p.post_status = 1
                            GROUP BY p.post_id 
                            ORDER BY p.created_at DESC";

        $result = mysqli_query($conn, $fetchPostsQuery);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $posts = [];

                while ($row = mysqli_fetch_assoc($result)) {
                    $post_id = (int)$row['post_id'];

                    // Media file formatting
                    $mediaFiles = !empty($row['media_files'])
                        ? array_map(fn($file) => "http://192.168.4.220/Harmoni/uploads/posts/" . $file, explode(',', $row['media_files']))
                        : [];

                    // Fetch comments with commenter name
                    $fetchCommentsQuery = "SELECT 
                                                c.comment_id, 
                                                c.comment, 
                                                u.user_name AS commenter_name
                                           FROM comments_master c
                                           LEFT JOIN user_master u ON c.user_id = u.user_id
                                           WHERE c.post_id = $post_id";

                    $commentResult = mysqli_query($conn, $fetchCommentsQuery);
                    $comments = [];

                    if ($commentResult && mysqli_num_rows($commentResult) > 0) {
                        while ($commentRow = mysqli_fetch_assoc($commentResult)) {
                            $comments[] = [
                                "comment_id" => (int)$commentRow['comment_id'],
                                "commenter_name" => htmlspecialchars($commentRow['commenter_name']),
                                "comment" => htmlspecialchars($commentRow['comment'])
                            ];
                        }
                    }

                    $posts[] = [
                        "post_id" => $post_id,
                        "user_id" => (int)$row['user_id'],
                        "username" => htmlspecialchars($row['user_name']),
                        "post_content" => htmlspecialchars($row['post_content']),
                        "created_at" => $row['created_at'],
                        "media_files" => $mediaFiles,
                        "like_count" => (int)$row['like_count'],
                        "comment_count" => (int)$row['comment_count'],
                        "comments" => $comments,
                        "is_liked" => (int)$row['is_liked'],
                        "is_commented" => (int)$row['is_commented'],
                        "is_saved" => (int)$row['is_saved'],
                        "is_followed" => (int)$row['is_followed']
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
