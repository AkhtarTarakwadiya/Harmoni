<?php
include '../database/db.php';
header('Content-Type: application/json');

$response = [];

if (!$conn) {
  die(json_encode(["status" => 500, "message" => "Database connection failed"]));
}

// Get year parameter from AJAX request (default to 2025)
$year = isset($_GET['year']) ? intval($_GET['year']) : 2025;

// Query to fetch new user count per month for the selected year
$query = "
    SELECT 
        DATE_FORMAT(user_created_at, '%b') AS month, 
        COUNT(user_id) AS user_count 
    FROM user_master 
    WHERE YEAR(user_created_at) = '$year' 
    GROUP BY month
    ORDER BY STR_TO_DATE(month, '%b') ASC;
";


$result = mysqli_query($conn, $query);

if (!$result) {
  die(json_encode(["status" => 500, "message" => "Query failed: " . mysqli_error($conn)]));
}

// Initialize arrays for months and user counts
$months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
$user_counts = array_fill(0, 12, 0); // Default 0 for all months

while ($row = mysqli_fetch_assoc($result)) {
  $monthIndex = array_search($row['month'], $months); // Find index of month
  if ($monthIndex !== false) {
    $user_counts[$monthIndex] = $row['user_count']; // Assign user count to correct month
  }
}

// Return data as JSON
$response['months'] = $months;
$response['user_counts'] = $user_counts;
echo json_encode($response);
