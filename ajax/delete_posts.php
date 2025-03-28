<?php
include '../database/dao.php';
$dao = new Dao();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    $column = 'media';
    $table = 'posts_media_master';
    $where = "post_id = $post_id";
    $mediaResult = $dao->select($column, $table, $where);

    while ($row = mysqli_fetch_assoc($mediaResult)) {
        $mediaPath = '../uploads/posts/' . $row['media'];
        if (file_exists($mediaPath)) {
            unlink($mediaPath);
        }
    }

    $table = 'posts_media_master';
    $where = "post_id = $post_id";
    $dao->delete($table, $where);

    $table = 'posts';
    $data = ['post_status' => 0];
    $where = "post_id = $post_id";
    $result = $dao->updatedata($table, $data, $where);

    if ($result) {
        echo "Post deleted successfully.";
    } else {
        echo "Error deleting post: " . mysqli_error($conn);
    }
}
