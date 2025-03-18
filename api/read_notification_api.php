<?php
include '../database/config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['method']) || $_POST['method'] !== "mark_notification_read") {
        $response = [
            "status" => "201",
            "message" => "Invalid method"
        ];
    } elseif (!isset($_POST['notification_id']) || empty($_POST['notification_id'])) {
        $response = [
            "status" => "201",
            "message" => "Notification ID is required"
        ];
    } else {
        $notification_id = intval($_POST['notification_id']);

        if ($notification_id <= 0) {
            $response = [
                "status" => "201",
                "message" => "Invalid Notification ID"
            ];
        } else {
            // Check if notification exists and its status
            $checkQuery = "SELECT is_read FROM notifications WHERE id = $notification_id";
            $checkResult = mysqli_query($conn, $checkQuery);

            if ($checkResult && mysqli_num_rows($checkResult) > 0) {
                $row = mysqli_fetch_assoc($checkResult);
                
                if ($row['is_read'] == 1) {
                    // Notification is already marked as read
                    $response = [
                        "status" => "200",
                        "message" => "Notification is already read",
                        "notification_id" => $notification_id
                    ];
                } else {
                    // Update notification as read
                    $updateQuery = "UPDATE notifications SET is_read = 1 WHERE id = $notification_id";

                    if (mysqli_query($conn, $updateQuery)) {
                        $response = [
                            "status" => "200",
                            "message" => "Notification marked as read",
                            "notification_id" => $notification_id
                        ];
                    } else {
                        $response = [
                            "status" => "500",
                            "message" => "Failed to update notification"
                        ];
                    }
                }
            } else {
                $response = [
                    "status" => "201",
                    "message" => "Notification not found"
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
