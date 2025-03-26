<?php
include '../database/dao.php';
$dao = new Dao();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = intval($_POST['user_id']); 
    $newStatus = intval($_POST['user_status']);

    // $sql = "UPDATE user_master SET user_status = $newStatus WHERE user_id = $userId";
    // $result = mysqli_query($conn, $sql);

    $table = 'user_master';
    $data = ['user_status' => $newStatus];
    $where = "user_id = $userId";
    $result = $dao->updatedata($table, $data, $where);

    if ($result) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update user status"]);
    }

    mysqli_close($conn);
}
?>
