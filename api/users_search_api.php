<?php
include '../database/config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['method'], $_POST['search_query']) && $_POST['method'] === "search_user") {
        $search_query = trim($_POST['search_query']);

        // Validate input
        if (empty($search_query)) {
            $response = [
                "status" => "201",
                "message" => "Search query is required."
            ];
            echo json_encode($response);
            exit();
        }

        // Fetch User by Name or Username
        $fetchUserDetails = "SELECT 
                                u.user_id, 
                                u.user_name, 
                                u.user_full_name,
                                u.user_email, 
                                u.user_phone_number,
                                u.gender,
                                u.user_profile_photo,
                                u.user_bio, 
                                (SELECT COUNT(*) FROM posts WHERE user_id = u.user_id AND post_status = 1) AS total_posts,
                                (SELECT COUNT(*) FROM follow_master WHERE following_id = u.user_id) AS total_followers,
                                (SELECT COUNT(*) FROM follow_master WHERE follower_id = u.user_id) AS total_following
                            FROM user_master u
                            WHERE u.user_name LIKE '%$search_query%' 
                               OR u.user_full_name LIKE '%$search_query%' 
                            LIMIT 1"; // Sirf ek user return karega

        $userResult = mysqli_query($conn, $fetchUserDetails);

        if ($userResult && mysqli_num_rows($userResult) > 0) {
            $userData = mysqli_fetch_assoc($userResult);
            $user_id = $userData['user_id'];

            // Fetch User's Posts with Like & Comment Count
            $fetchPostsQuery = "SELECT 
                                    p.post_id, 
                                    p.user_id, 
                                    u.user_name, 
                                    p.post_content, 
                                    p.created_at, 
                                    GROUP_CONCAT(DISTINCT pm.media) AS media_files,
                                    COUNT(DISTINCT pl.id) AS like_count,
                                    COUNT(DISTINCT pc.comment_id) AS comment_count
                                FROM posts p
                                LEFT JOIN user_master u ON p.user_id = u.user_id
                                LEFT JOIN posts_media_master pm ON p.post_id = pm.post_id
                                LEFT JOIN likes_master pl ON p.post_id = pl.post_id
                                LEFT JOIN comments_master pc ON p.post_id = pc.post_id
                                WHERE p.user_id = $user_id AND p.post_status = 1
                                GROUP BY p.post_id 
                                ORDER BY p.created_at DESC";

            $result = mysqli_query($conn, $fetchPostsQuery);
            $posts = [];

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $post_id = (int)$row['post_id'];

                    // Format media files
                    $mediaFiles = !empty($row['media_files'])
                        ? array_map(fn($file) => "http://192.168.4.220/Harmoni/uploads/posts/" . trim($file), explode(',', $row['media_files']))
                        : [];

                    // Fetch Comments for the Post
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
                        "comments" => $comments
                    ];
                }
            } else {
                $posts = ["message" => "No posts found."];
            }

            // Final Response
            $response = [
                "status" => "200",
                "message" => "User found.",
                "user" => [
                    "user_id" => (int)$userData['user_id'],
                    "user_name" => htmlspecialchars($userData['user_name']),
                    "full_name" => htmlspecialchars($userData['user_full_name']),
                    "email" => htmlspecialchars($userData['user_email']),
                    "phone_number" => htmlspecialchars($userData['user_phone_number']),
                    "gender" => htmlspecialchars($userData['gender']),
                    "profile_pic" => $userData['user_profile_photo'] 
                        ? "http://192.168.4.220/Harmoni" . $userData['user_profile_photo'] 
                        : null,
                    "bio" => htmlspecialchars($userData['user_bio']),
                    "total_posts" => (int)$userData['total_posts'],
                    "total_followers" => (int)$userData['total_followers'],
                    "total_following" => (int)$userData['total_following']
                ],
                "posts" => $posts
            ];
        } else {
            $response = [
                "status" => "201",
                "message" => "No user found."
            ];
        }
    } else {
        $response = [
            "status" => "201",
            "message" => "Invalid Request or Missing Search Query"
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
