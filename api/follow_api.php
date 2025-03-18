<?php
include '../database/config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['method']) && $_POST['method'] === "follow_method") {
        
        // Collect Input Data
        $follower_id = isset($_POST['follower_id']) ? trim($_POST['follower_id']) : '';
        $following_id = isset($_POST['following_id']) ? trim($_POST['following_id']) : '';

        // Validate Input
        if (empty($follower_id) || empty($following_id)) {
            $response = [
                "status" => "201",
                "message" => "Follower ID and Following ID are required."
            ];
            echo json_encode($response);
            exit;
        }

        if (!ctype_digit($follower_id) || !ctype_digit($following_id)) {
            $response = [
                "status" => "201",
                "message" => "Invalid ID format. Only numeric values are allowed."
            ];
            echo json_encode($response);
            exit;
        }

        // Convert IDs to integers for safety
        $follower_id = (int) $follower_id;
        $following_id = (int) $following_id;

        // Prevent self-following
        if ($follower_id == $following_id) {
            $response = [
                "status" => "201",
                "message" => "You cannot follow yourself."
            ];
            echo json_encode($response);
            exit;
        }

        // Check if both users exist
        $userCheckQuery = "SELECT user_id FROM user_master WHERE user_id IN ($follower_id, $following_id)";
        $userCheckResult = mysqli_query($conn, $userCheckQuery);

        if (!$userCheckResult || mysqli_num_rows($userCheckResult) < 2) {
            $response = [
                "status" => "201",
                "message" => "User not found."
            ];
            echo json_encode($response);
            exit;
        }

        // Check if a follow record exists
        $checkQuery = "SELECT id, status FROM follow_master WHERE follower_id = $follower_id AND following_id = $following_id";
        $checkResult = mysqli_query($conn, $checkQuery);

        if ($checkResult && mysqli_num_rows($checkResult) > 0) {
            $row = mysqli_fetch_assoc($checkResult);
            $newStatus = ($row['status'] == 1) ? 0 : 1; // Toggle status (1 → 0, 0 → 1)

            // Update follow status
            $updateQuery = "UPDATE follow_master SET status = $newStatus, followed_at = NOW() WHERE id = " . $row['id'];
            if (mysqli_query($conn, $updateQuery)) {
                $message = ($newStatus == 1) ? "User followed successfully." : "User unfollowed successfully.";

                // Add notification only when a user follows
                if ($newStatus == 1) {
                    // Fetch sender username
                    $senderQuery = "SELECT user_name FROM user_master WHERE user_id = $follower_id";
                    $senderResult = mysqli_query($conn, $senderQuery);
                    $senderUsername = ($senderResult && mysqli_num_rows($senderResult) > 0) ? mysqli_fetch_assoc($senderResult)['user_name'] : "Unknown User";

                    // Insert into notifications table
                    $messageText = "$senderUsername followed you.";
                    $notificationQuery = "INSERT INTO notifications (user_id, sender_id, type, message) 
                                          VALUES ($following_id, $follower_id, 1, '$messageText')";

                    if (!mysqli_query($conn, $notificationQuery)) {
                        error_log("Notification Insert Error: " . mysqli_error($conn)); // Log error
                    }
                }

                $response = [
                    "status" => "200",
                    "message" => $message,
                    "new_status" => $newStatus
                ];
            } else {
                $response = [
                    "status" => "201",
                    "message" => "Action failed. Please try again."
                ];
            }
        } else {
            // Insert new follow record (if never followed before)
            $insertQuery = "INSERT INTO follow_master (follower_id, following_id, status) VALUES ($follower_id, $following_id, 1)";
            if (mysqli_query($conn, $insertQuery)) {
                // Fetch sender username
                $senderQuery = "SELECT user_name FROM user_master WHERE user_id = $follower_id";
                $senderResult = mysqli_query($conn, $senderQuery);
                $senderUsername = ($senderResult && mysqli_num_rows($senderResult) > 0) ? mysqli_fetch_assoc($senderResult)['user_name'] : "Unknown User";

                // Insert into notifications table
                $messageText = "$senderUsername followed you.";
                $notificationQuery = "INSERT INTO notifications (user_id, sender_id, type, message) 
                                      VALUES ($following_id, $follower_id, 1, '$messageText')";

                if (!mysqli_query($conn, $notificationQuery)) {
                    error_log("Notification Insert Error: " . mysqli_error($conn)); // Log error
                }

                $response = [
                    "status" => "200",
                    "message" => "User followed successfully.",
                    "new_status" => 1
                ];
            } else {
                $response = [
                    "status" => "201",
                    "message" => "Follow action failed. Please try again."
                ];
            }
        }
    } else {
        $response = [
            "status" => "201",
            "message" => "Invalid request method."
        ];
    }
} else {
    $response = [
        "status" => "201",
        "message" => "Only POST method is allowed."
    ];
}

echo json_encode($response);
?>
