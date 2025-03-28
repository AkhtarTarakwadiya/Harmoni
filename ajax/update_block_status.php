<?php
include '../database/dao.php';
$dao = new Dao();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $user_isblock = isset($_POST['user_isblock']) ? intval($_POST['user_isblock']) : 0;

    if ($user_id > 0) {

        // $sql = "UPDATE user_master SET user_isblock = $user_isblock WHERE user_id = $user_id";
        // $result = mysqli_query($conn, $sql);

        $table = 'user_master';
        $data = ['user_isblock' => $user_isblock];
        $where = ['user_id' => $user_id];
        $result = $dao->updatedata($table, $data, $where);

        if ($result) {
            echo json_encode(["status" => "success", "message" => "User block status updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid user ID"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}

