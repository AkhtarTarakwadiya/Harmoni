<?php
include '../database/db.php';

if (isset($_POST['media_id']) && isset($_POST['media_path'])) {
    $media_id = intval($_POST['media_id']);
    $media_path = $_POST['media_path'];
    $file_path = "../uploads/posts/" . basename($media_path); // Adjust path accordingly

    // Delete from database
    $deleteQuery = "DELETE FROM posts_media_master WHERE media_id = $media_id";
    if (mysqli_query($conn, $deleteQuery)) {
        // Delete from local folder
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        echo "Media deleted successfully";
    } else {
        echo "Error deleting media: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request!";
}
?>
