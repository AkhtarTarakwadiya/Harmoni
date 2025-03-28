<?php
include '../database/dao.php';
$dao = new Dao();

if (isset($_POST['id'])) {
    $id = (int)$_POST['id'];

    // Update comment status instead of deleting it
    $table = 'comments_master';
    $data = ['comment_status' => 0];
    $where = "comment_id = $id"; // `updatedata()` expects where condition as a string

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
