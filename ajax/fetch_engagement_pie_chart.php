<?php
include '../database/db.php';
header('Content-Type: application/json');

// Get filter parameter from AJAX request
$period = isset($_GET['period']) ? $_GET['period'] : 'all';

// Define date conditions for filtering
$dateConditionLikes = "";
$dateConditionComments = "";
$dateConditionSaves = "";

switch ($period) {
    case "today":
        $dateConditionLikes = "WHERE liked_at >= CURDATE()";
        $dateConditionComments = "WHERE created_at >= CURDATE()";
        $dateConditionSaves = "WHERE created_at >= CURDATE()";
        break;
    case "yesterday":
        $dateConditionLikes = "WHERE liked_at >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND liked_at < CURDATE()";
        $dateConditionComments = "WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND created_at < CURDATE()";
        $dateConditionSaves = "WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND created_at < CURDATE()";
        break;
    case "last_week":
        $dateConditionLikes = "WHERE liked_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
        $dateConditionComments = "WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
        $dateConditionSaves = "WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
        break;
    case "last_month":
        $dateConditionLikes = "WHERE liked_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
        $dateConditionComments = "WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
        $dateConditionSaves = "WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
        break;
    default:
        $dateConditionLikes = ""; // No filter for all time
        $dateConditionComments = "";
        $dateConditionSaves = "";
}

// Query to get engagement counts based on selected period
$query = "SELECT 
            (SELECT COUNT(*) FROM likes_master $dateConditionLikes) AS total_likes,
            (SELECT COUNT(*) FROM comments_master $dateConditionComments) AS total_comments,
            (SELECT COUNT(*) FROM save_posts_master $dateConditionSaves) AS total_post_saves";

$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $response = [
        "labels" => ["Likes", "Comments", "Saves"],
        "data" => [$row["total_likes"], $row["total_comments"], $row["total_post_saves"]],
        "colors" => ["#4e73df", "#1cc88a", "#e74a3b"]
    ];
    echo json_encode($response);
} else {
    echo json_encode(["error" => "Failed to fetch data"]);
}
?>
