<?php
include '../database/db.php';

if (isset($_POST['post_id'])) {
    $post_id = intval($_POST['post_id']);

    $query = "SELECT media_id, media FROM posts_media_master WHERE post_id = $post_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<div class="media-grid">';
        while ($row = mysqli_fetch_assoc($result)) {
            $mediaPath = "http://192.168.4.220/Harmoni/uploads/posts/" . htmlspecialchars($row['media']);
            $fileExt = strtolower(pathinfo($row['media'], PATHINFO_EXTENSION));

            echo '<div class="media-item">';
            if (in_array($fileExt, ['jpg', 'jpeg', 'png'])) {
                echo "<img src='$mediaPath' width='200' height='200' style='display: block;'>";
            } elseif (in_array($fileExt, ['mp4', 'mov'])) {
                echo "<video width='200' height='200' controls style='display: block;'><source src='$mediaPath' type='video/$fileExt'></video>";
            }
            echo "<button class='delete-media' data-media-id='{$row['media_id']}' data-media-path='{$row['media']}'>
        <i class='fas fa-trash-alt'></i>
      </button>";

            echo "</div>"; 
        }
        echo '</div>'; 
    } else {
        echo "<p>No media available.</p>";
    }
}
