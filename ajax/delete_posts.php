<?php
include '../database/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    // Fetch media files linked to the post
    $fetchMediaQuery = "SELECT media FROM posts_media_master WHERE post_id = $post_id";
    $mediaResult = mysqli_query($conn, $fetchMediaQuery);

    while ($row = mysqli_fetch_assoc($mediaResult)) {
        $mediaPath = '../uploads/posts/' . $row['media']; // Adjust path if needed
        if (file_exists($mediaPath)) {
            unlink($mediaPath); // Delete from local storage
        }
    }

    // Delete media records from database
    $deleteMediaQuery = "DELETE FROM posts_media_master WHERE post_id = $post_id";
    mysqli_query($conn, $deleteMediaQuery);

    // Update post status from 1 to 0 (soft delete)
    $updatePostQuery = "UPDATE posts SET post_status = 0 WHERE post_id = $post_id";
    if (mysqli_query($conn, $updatePostQuery)) {
        echo "Post deleted successfully.";
    } else {
        echo "Error deleting post: " . mysqli_error($conn);
    }
}
?>
