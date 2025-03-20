<?php
include '../database/config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['method'], $_POST['user_id']) && $_POST['method'] === "fetch_following") {
        $user_id = intval($_POST['user_id']);

        // Base URL for profile pictures
        $base_url = "http://192.168.4.220/Harmoni";

        // Fetch Following List 
        $fetchFollowing = "SELECT f.following_id, u.user_name, u.user_profile_photo 
                           FROM follow_master f 
                           JOIN user_master u ON f.following_id = u.user_id 
                           WHERE f.follower_id = $user_id";
        $followingResult = mysqli_query($conn, $fetchFollowing);
        $following = [];

        if ($followingResult && mysqli_num_rows($followingResult) > 0) {
            while ($row = mysqli_fetch_assoc($followingResult)) {
                $profile_photo = !empty($row['user_profile_photo']) ? $base_url . $row['user_profile_photo'] : null;

                $following[] = [
                    "user_id" => (int)$row['following_id'],
                    "username" => htmlspecialchars($row['user_name']),
                    "profile_pic" => $profile_photo
                ];
            }
        }

        $response = [
            "status" => "200",
            "message" => "Following list fetched successfully",
            "total_following" => count($following),
            "following_list" => $following
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
