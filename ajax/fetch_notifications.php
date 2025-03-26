<?php
include '../database/dao.php';
$dao = new Dao();

header('Content-Type: application/json');

// $query = "SELECT id, message, created_at, is_read FROM notifications WHERE TYPE = 4 ORDER BY created_at DESC";
// $result = mysqli_query($conn, $query);

$column = 'id, message, created_at, is_read';
$table = 'notifications';
$where = 'TYPE = 4';
$other = 'ORDER BY created_at DESC';
$query = $dao->select($column, $table, $where, $other);


$notifications = [];
$unreadCount = 0;

// Fetch notifications and count unread ones
while ($row = mysqli_fetch_assoc($query)) {
    $row['formatted_date'] = date("F j, Y h:i A", strtotime($row['created_at']));
    if ($row['is_read'] == 0) {
        $unreadCount++; 
    }
    $notifications[] = $row;
}

$response = [
    "unread_count" => $unreadCount,  
    "notifications" => $notifications
];

echo json_encode($response);
?>
