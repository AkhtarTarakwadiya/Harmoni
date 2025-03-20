<?php
include '../database/db.php';
header('Content-Type: application/json');

// Query to get engagement counts
$query = "SELECT 
            (SELECT COUNT(*) FROM likes_master) AS total_likes,
            (SELECT COUNT(*) FROM comments_master) AS total_comments,
            (SELECT COUNT(*) FROM save_posts_master) AS total_post_saves"; 

$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $response = [
        "labels" => ["Likes", "Comments", "Saves"],
        "data" => [$row["total_likes"], $row["total_comments"], $row["total_post_saves"]],
        "colors" => ["#4e73df", "#1cc88a", "#e74a3b"] // Blue, Green, Red
    ];
    echo json_encode($response);
} else {
    echo json_encode(["error" => "Failed to fetch data"]);
}
?>
