<?php
include '../database/config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['method']) || $_POST['method'] !== "fetch_unread_notifications") {
        $response = [
            "status" => "201",
            "message" => "Invalid method"
        ];
    } elseif (!isset($_POST['user_id']) || empty($_POST['user_id'])) {
        $response = [
            "status" => "201",
            "message" => "User ID is required"
        ];
    } else {
        $user_id = intval($_POST['user_id']);

        if ($user_id <= 0) {
            $response = [
                "status" => "201",
                "message" => "Invalid User ID"
            ];
        } else {
            // Fetch All Notifications
            $fetchQuery = "SELECT n.id, n.sender_id, n.type, n.message, n.post_id, n.created_at, 
                                  COALESCE(u1.user_name, 'System') AS sender_name
                           FROM notifications n
                           LEFT JOIN user_master u1 ON n.sender_id = u1.user_id
                           WHERE n.user_id = $user_id AND n.TYPE != 4
                           ORDER BY n.created_at DESC";

            $result = mysqli_query($conn, $fetchQuery);
            $notifications = [];

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $notifications[] = [
                        "notification_id" => (int)$row['id'],
                        "sender" => htmlspecialchars($row['sender_name']),
                        "type" => (int)$row['type'],
                        "message" => htmlspecialchars($row['message']),
                        "post_id" => $row['post_id'] ? (int)$row['post_id'] : null,
                        "created_at" => $row['created_at']
                    ];
                }
                $response = [
                    "status" => "200",
                    "message" => "notifications fetched successfully",
                    "total_notifications" => count($notifications),
                    "notifications" => $notifications
                ];
            } else {
                $response = [
                    "status" => "201",
                    "message" => "No notifications found"
                ];
            }
        }
    }
} else {
    $response = [
        "status" => "201",
        "message" => "Only POST Method Allowed"
    ];
}

echo json_encode($response);
?>
