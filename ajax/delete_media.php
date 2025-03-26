<?php
include '../database/dao.php';
$dao = new Dao();

if (isset($_POST['media_id']) && isset($_POST['media_path'])) {
    $media_id = intval($_POST['media_id']);
    $media_path = $_POST['media_path'];
    $file_path = "../uploads/posts/" . basename($media_path); 

    // $deleteQuery = "DELETE FROM posts_media_master WHERE media_id = $media_id";

    $table = 'posts_media_master';
    $where = "media_id = $media_id";
    $deletemedia = $dao->delete($table, $where);
    if ($deletemedia) {
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        echo "Media deleted successfully.";
    } else {
        echo "Error deleting media: " . mysqli_error($conn);
    }

    // if (mysqli_query($conn, $deleteQuery)) {

    //     if (file_exists($file_path)) {
    //         unlink($file_path);
    //     }
    //     echo "Media deleted successfully.";
    // } else {
    //     echo "Error deleting media: " . mysqli_error($conn);
    // }
} else {
    echo "Invalid request!";
}
?>
