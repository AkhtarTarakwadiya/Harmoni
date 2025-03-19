<?php
include '../database/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['notification_id'])) {
    $notification_id = intval($_POST['notification_id']); // Ensure it's an integer

    $query = "UPDATE notifications SET is_read = 1 WHERE id = $notification_id";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["success" => true, "message" => "Notification marked as read"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update notification"]);
    }

    mysqli_close($conn);
}
?>
