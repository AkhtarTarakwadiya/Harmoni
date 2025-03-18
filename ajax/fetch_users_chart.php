<?php
include '../database/db.php';  // Database connection
$response = [];

if (!$conn) {
  die(json_encode(["status" => 500, "message" => "Database connection failed"]));
}

$query = "SELECT 
    DATE_FORMAT(MIN(user_created_at), '%b') AS month, 
    COUNT(user_id) AS user_count 
FROM user_master 
WHERE user_created_at >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR) 
GROUP BY DATE_FORMAT(user_created_at, '%Y-%m') 
ORDER BY MIN(user_created_at);
";

$result = mysqli_query($conn, $query);

if (!$result) {
  die(json_encode(["status" => 500, "message" => "Query failed: " . mysqli_error($conn)]));
}

$months = [];
$user_counts = [];

while ($row = mysqli_fetch_assoc($result)) {
  $months[] = $row['month'];
  $user_counts[] = $row['user_count'];
}

$response['months'] = $months;
$response['user_counts'] = $user_counts;

header('Content-Type: application/json');
echo json_encode($response);
