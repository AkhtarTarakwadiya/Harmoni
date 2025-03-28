<?php
include '../database/dao.php';
$dao = new Dao();
header('Content-Type: application/json');

// Get filter parameter from AJAX request
$period = isset($_GET['period']) ? $_GET['period'] : 'all';

// Define date conditions for filtering
$dateConditionLikes = "";
$dateConditionComments = "";
$dateConditionSaves = "";

switch ($period) {
    case "today":
        $dateConditionLikes = "liked_at >= CURDATE()";
        $dateConditionComments = "created_at >= CURDATE()";
        $dateConditionSaves = "created_at >= CURDATE()";
        break;
    case "yesterday":
        $dateConditionLikes = "liked_at >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND liked_at < CURDATE()";
        $dateConditionComments = "created_at >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND created_at < CURDATE()";
        $dateConditionSaves = "created_at >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND created_at < CURDATE()";
        break;
    case "last_week":
        $dateConditionLikes = "liked_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
        $dateConditionComments = "created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
        $dateConditionSaves = "created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
        break;
    case "last_month":
        $dateConditionLikes = "liked_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
        $dateConditionComments = "created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
        $dateConditionSaves = "created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
        break;
}

// Fetch engagement counts using select function
$total_likes = $dao->select("COUNT(*) AS total_likes", "likes_master", $dateConditionLikes);
$total_comments = $dao->select("COUNT(*) AS total_comments", "comments_master", $dateConditionComments);
$total_post_saves = $dao->select("COUNT(*) AS total_post_saves", "save_posts_master", $dateConditionSaves);

// Get results
$likes_count = mysqli_fetch_assoc($total_likes)["total_likes"] ?? 0;
$comments_count = mysqli_fetch_assoc($total_comments)["total_comments"] ?? 0;
$saves_count = mysqli_fetch_assoc($total_post_saves)["total_post_saves"] ?? 0;

// Prepare and return JSON response
$response = [
    "labels" => ["Likes", "Comments", "Saves"],
    "data" => [$likes_count, $comments_count, $saves_count],
    "colors" => ["#4e73df", "#1cc88a", "#e74a3b"]
];

echo json_encode($response);
