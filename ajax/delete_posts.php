<?php
include '../database/dao.php';
$dao = new Dao();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    // $fetchMediaQuery = "SELECT media FROM posts_media_master WHERE post_id = $post_id";
    // $mediaResult = mysqli_query($conn, $fetchMediaQuery);

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

    // $deleteMediaQuery = "DELETE FROM posts_media_master WHERE post_id = $post_id";
    // mysqli_query($conn, $deleteMediaQuery);

    $table = 'posts_media_master';
    $where = "post_id = $post_id";
    $dao->delete($table, $where);


    // $updatePostQuery = "UPDATE posts SET post_status = 0 WHERE post_id = $post_id";

    $table = 'posts';
    $data = ['post_status' => 0];
    $where = "post_id = $post_id";
    $result = $dao->updatedata($table, $data, $where);

    if ($result) {
        echo "Post deleted successfully.";
    } else {
        echo "Error deleting post: " . mysqli_error($conn);
    }

    // if (mysqli_query($conn, $updatePostQuery)) {
    //     echo "Post deleted successfully.";
    // } else {
    //     echo "Error deleting post: " . mysqli_error($conn);
    // }
}
?>
