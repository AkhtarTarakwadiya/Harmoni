<?php
include '../database/config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['method'], $_POST['user_id']) && $_POST['method'] === "fetch_profile") {
        $user_id = intval($_POST['user_id']);

        // Fetch User Details with Post Count, Followers & Following
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
                            WHERE u.user_id = $user_id";

        $userResult = mysqli_query($conn, $fetchUserDetails);

        if ($userResult && mysqli_num_rows($userResult) > 0) {
            $userData = mysqli_fetch_assoc($userResult);

            // Fetch Followers List
            $fetchFollowers = "SELECT f.follower_id, u.user_name 
                               FROM follow_master f 
                               JOIN user_master u ON f.follower_id = u.user_id 
                               WHERE f.following_id = $user_id";
            $followersResult = mysqli_query($conn, $fetchFollowers);
            $followers = [];

            if ($followersResult && mysqli_num_rows($followersResult) > 0) {
                while ($row = mysqli_fetch_assoc($followersResult)) {
                    $followers[] = [
                        "user_id" => (int)$row['follower_id'],
                        "username" => htmlspecialchars($row['user_name'])
                    ];
                }
            }

            // Fetch Following List
            $fetchFollowing = "SELECT f.following_id, u.user_name 
                               FROM follow_master f 
                               JOIN user_master u ON f.following_id = u.user_id 
                               WHERE f.follower_id = $user_id";
            $followingResult = mysqli_query($conn, $fetchFollowing);
            $following = [];

            if ($followingResult && mysqli_num_rows($followingResult) > 0) {
                while ($row = mysqli_fetch_assoc($followingResult)) {
                    $following[] = [
                        "user_id" => (int)$row['following_id'],
                        "username" => htmlspecialchars($row['user_name'])
                    ];
                }
            }

            // Final Response
            $response = [
                "status" => "200",
                "message" => "Profile fetched successfully",
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
                    "total_followers" => count($followers),
                    "total_following" => count($following),
                    "followers_list" => $followers,
                    "following_list" => $following
                ]
            ];
        } else {
            $response = [
                "status" => "201",
                "message" => "User not found"
            ];
        }
    } else {
        $response = [
            "status" => "201",
            "message" => "Invalid Request or Missing User ID"
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
