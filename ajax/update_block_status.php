<?php
include '../database/dao.php'; // Include DAO class

header('Content-Type: application/json'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $user_isblock = isset($_POST['user_isblock']) ? intval($_POST['user_isblock']) : 0;

    if ($user_id > 0) {
        $dao = new Dao(); // Create DAO instance

        // Prepare update data
        $data = ["user_isblock" => $user_isblock];
        $where = "user_id = $user_id";

        // Update user block status
        $result = $dao->updatedata("user_master", $data, $where);

        if ($result) {
            echo json_encode(["status" => "success", "message" => "User block status updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update user block status"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid user ID"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
