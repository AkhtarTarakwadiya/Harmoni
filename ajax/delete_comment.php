<?php
include '../database/dao.php';
$dao = new Dao();

if (isset($_POST['id'])) {
    $id = (int)$_POST['id'];

    // $query = "UPDATE comments_master SET comment_status = 0 WHERE comment_id = $id";

    $table = 'comments_master';
    $data = ['comment_status' => 0];
    $where = ['comment_id' => $id];
    $result = $dao->updatedata($table, $data, $where);
    if ($result) {
        echo "Comment deleted successfully";
    } else {
        echo "Error deleting comment";
    }

    // $result = mysqli_query($conn, $query);

    // if ($result) {
    //     echo "success";
    // } else {
    //     echo "error";
    // }

    // mysqli_close($conn);
}
