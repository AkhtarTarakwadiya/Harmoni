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

// Query to get engagement counts based on selected period
$resultLikes = $dao->select("COUNT(*) AS total_likes", "likes_master", $dateConditionLikes ? $dateConditionLikes : "");
$resultComments = $dao->select("COUNT(*) AS total_comments", "comments_master", $dateConditionComments ? $dateConditionComments : "");
$resultSaves = $dao->select("COUNT(*) AS total_post_saves", "save_posts_master", $dateConditionSaves ? $dateConditionSaves : "");

$rowLikes = mysqli_fetch_assoc($resultLikes);
$rowComments = mysqli_fetch_assoc($resultComments);
$rowSaves = mysqli_fetch_assoc($resultSaves);

$response = [
    "labels" => ["Likes", "Comments", "Saves"],
    "data" => [
        $rowLikes["total_likes"] ?? 0, 
        $rowComments["total_comments"] ?? 0, 
        $rowSaves["total_post_saves"] ?? 0
    ],
    "colors" => ["#4e73df", "#1cc88a", "#e74a3b"]
];

echo json_encode($response);
