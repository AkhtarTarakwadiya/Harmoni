<?php
include '../database/dao.php';
$dao = new Dao();

if (isset($_POST['id'])) {
    $id = (int)$_POST['id'];

    $table = 'comments_master';
    $data = ['comment_status' => 0];
    $where = "comment_id = $id";
    
    $result = $dao->updatedata($table, $data, $where);

    if ($result) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "Invalid request";
}
?>
