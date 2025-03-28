<?php
include '../database/dao.php';
$dao = new Dao();
header('Content-Type: application/json');

$response = [];

$year = isset($_GET['year']) ? intval($_GET['year']) : 2025;

$columns = "DATE_FORMAT(user_created_at, '%b') AS month, COUNT(user_id) AS user_count";
$table = "user_master";
$where = "YEAR(user_created_at) = '$year'";
$other = "GROUP BY month ORDER BY STR_TO_DATE(month, '%b') ASC";

$result = $dao->select($columns,$table,$where,$other);

if (!$result) {
    die(json_encode(["status" => 500, "message" => "Query failed"]));
}

$months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
$user_counts = array_fill(0, 12, 0);

while ($row = mysqli_fetch_assoc($result)) {
    $monthIndex = array_search($row['month'], $months);
    if ($monthIndex !== false) {
        $user_counts[$monthIndex] = $row['user_count']; 
    }
}

$response['months'] = $months;
$response['user_counts'] = $user_counts;
echo json_encode($response);
