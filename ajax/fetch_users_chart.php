<?php
include '../database/db.php';  // Database connection

$response = [];

$query = "SELECT 
            DATE_FORMAT(user_created_at, '%b') AS month, 
            COUNT(user_id) AS user_count 
          FROM user_master 
          WHERE user_created_at >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR) 
          GROUP BY DATE_FORMAT(user_created_at, '%Y-%m') 
          ORDER BY DATE_FORMAT(user_created_at, '%Y-%m')";

$result = mysqli_query($conn, $query);

$months = [];
$user_counts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $months[] = $row['month'];
    $user_counts[] = $row['user_count'];
}

$response['months'] = $months;
$response['user_counts'] = $user_counts;

echo json_encode($response);
?>
