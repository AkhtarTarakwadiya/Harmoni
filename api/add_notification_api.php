<?php
include '../database/config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['method'], $_POST['user_id'], $_POST['type']) && $_POST['method'] === "add_notification") {
        $user_id = intval($_POST['user_id']);
        $sender_id = isset($_POST['sender_id']) ? intval($_POST['sender_id']) : null;
        $type = intval($_POST['type']);
        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : null;

        // Fetch Receiver Username
        $userQuery = "SELECT user_name FROM user_master WHERE user_id = $user_id";
        $userResult = mysqli_query($conn, $userQuery);
        $receiverUsername = ($userResult && mysqli_num_rows($userResult) > 0) ? mysqli_fetch_assoc($userResult)['user_name'] : "User";

        // Fetch Sender Username (if applicable)
        $senderUsername = "Admin"; // Default for system notifications
        if ($sender_id) {
            $senderQuery = "SELECT user_name FROM user_master WHERE user_id = $sender_id";
            $senderResult = mysqli_query($conn, $senderQuery);
            $senderUsername = ($senderResult && mysqli_num_rows($senderResult) > 0) ? mysqli_fetch_assoc($senderResult)['user_name'] : "Unknown User";
        }

        // Notification Messages Based on Type
        $messages = [
            1 => "$senderUsername followed you.",
            2 => "$senderUsername liked your post.",
            3 => "$senderUsername commented on your post.",
            4 => "A new post has been added.",
            5 => "Your account has been blocked by the admin.",
            6 => "Your account has been disabled."
        ];

        $message = isset($messages[$type]) ? $messages[$type] : "Unknown notification type";

        // Insert Notification Query
        $insertQuery = "INSERT INTO notifications (user_id, sender_id, type, post_id, message) 
                        VALUES ($user_id, " . ($sender_id ? $sender_id : "NULL") . ", $type, " . ($post_id ? $post_id : "NULL") . ", '$message')";

        if (mysqli_query($conn, $insertQuery)) {
            $response = [
                "status" => "200",
                "message" => "Notification added successfully",
                "notification" => [
                    "receiver" => $receiverUsername,
                    "sender" => $senderUsername,
                    "type" => $type,
                    "message" => $message
                ]
            ];
        } else {
            $response = [
                "status" => "500",
                "message" => "Failed to add notification"
            ];
        }
    } else {
        $response = [
            "status" => "201",
            "message" => "Invalid Request or Missing Required Fields"
        ];
    }
} else {
    $response = [
        "status" => "201",
        "message" => "Only POST Method Allowed"
    ];
}

echo json_encode($response);
?>
