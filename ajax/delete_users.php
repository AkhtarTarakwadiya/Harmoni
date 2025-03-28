<?php
include '../database/dao.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $newStatus = isset($_POST['user_status']) ? intval($_POST['user_status']) : 0;

    if ($userId > 0) {
        $dao = new Dao();

        $table = 'user_master';
        $data = ['user_status' => $newStatus];
        $where = "user_id = $userId";

        $result = $dao->updatedata($table, $data, $where);

        if ($result) {
            echo json_encode(["status" => "success", "message" => "User status updated successfully"]);
            exit; 
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update user status"]);
            exit;
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid user ID"]);
        exit;
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}
?>
