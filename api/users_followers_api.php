<?php
include '../database/config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['method'], $_POST['user_id']) && $_POST['method'] === "fetch_followers") {
        $user_id = intval($_POST['user_id']);

        // Base URL for profile pictures
        $base_url = "http://192.168.4.220/Harmoni";

        // Fetch Followers List 
        $fetchFollowers = "SELECT f.follower_id, u.user_name, u.user_profile_photo 
                           FROM follow_master f 
                           JOIN user_master u ON f.follower_id = u.user_id 
                           WHERE f.following_id = $user_id";
        $followersResult = mysqli_query($conn, $fetchFollowers);
        $followers = [];

        if ($followersResult && mysqli_num_rows($followersResult) > 0) {
            while ($row = mysqli_fetch_assoc($followersResult)) {
                $profile_photo = !empty($row['user_profile_photo']) ? $base_url . $row['user_profile_photo'] : null;

                $followers[] = [
                    "user_id" => (int)$row['follower_id'],
                    "username" => htmlspecialchars($row['user_name']),
                    "profile_pic" => $profile_photo
                ];
            }
        }

        $response = [
            "status" => "200",
            "message" => "Followers fetched successfully",
            "total_followers" => count($followers),
            "followers_list" => $followers
        ];
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
