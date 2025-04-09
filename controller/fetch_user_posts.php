<?php
include '../database/db.php';

$db = new connection();
$conn = $db->connect(); 

if (isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);

    $query = "SELECT 
            p.post_id, 
            p.post_content, 
            p.created_at, 
            GROUP_CONCAT(DISTINCT pm.media) AS media_files
          FROM posts p
          LEFT JOIN posts_media_master pm ON p.post_id = pm.post_id
          WHERE p.user_id = $user_id AND p.post_status = 1
          GROUP BY p.post_id
          ORDER BY p.created_at DESC";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $count = 0;
        echo '<div class="row">';
        while ($row = mysqli_fetch_assoc($result)) {

            $mediaFiles = $row['media_files'] ?? ''; 
            $mediaArray = explode(',', $mediaFiles);
            $postImage = !empty($mediaArray[0]) 
                ? "http://192.168.4.220/Harmoni/uploads/posts/" . htmlspecialchars($mediaArray[0]) 
                : "http://192.168.4.220/Harmoni/img/default-post-1.jpeg"; 

            if ($count % 3 == 0 && $count != 0) {
                echo '</div><div class="row">';
            }

            echo '
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="' . $postImage . '" class="card-img-top" style="height: 250px; width: 250px;" alt="Post Image">
                    </div>
                </div>
            ';
            $count++;
        }
        echo '</div>'; 
    } else {
        echo '<p class="text-center">No posts found.</p>';
    }
} else {
    echo '<p class="text-center">Invalid request.</p>';
}
?>
