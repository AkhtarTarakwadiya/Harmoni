<?php
include '../config/db.php';

$search = isset($_GET['query']) ? mysqli_real_escape_string($conn, $_GET['query']) : '';

$sql = "SELECT 
            user_name, 
            user_full_name, 
            user_email, 
            gender, 
            user_profile_photo, 
            user_bio,  
            (SELECT COUNT(*) FROM posts WHERE user_id = u.user_id AND post_status = 1) AS total_posts,
            (SELECT COUNT(*) FROM follow_master WHERE following_id = u.user_id) AS total_followers,
            (SELECT COUNT(*) FROM follow_master WHERE follower_id = u.user_id) AS total_following 
        FROM user_master u 
        WHERE (user_name LIKE '%$search%' OR user_full_name LIKE '%$search%') 
        AND user_status = 1 
        AND user_isblock = 1";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="row">'; 
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="col-lg-4 col-md-6 mb-4">
                <div class="profile-card">
                    <img src="Harmoni/' . htmlspecialchars($row['user_profile_photo']) . '" class="profile-pic" alt="Profile Pic">
                    <div class="username">@' . htmlspecialchars($row['user_name']) . '</div>
                    <div class="fullname">' . htmlspecialchars($row['user_full_name']) . '</div>
                    <div class="gender">Gender: ' . htmlspecialchars($row['gender']) . '</div>
                    <div class="email">Email: ' . htmlspecialchars($row['user_email']) . '</div>
                    <div class="bio">' . htmlspecialchars($row['user_bio'] ?: 'No bio available') . '</div>
                    <div class="stats">
                        <div><span>' . $row['total_posts'] . '</span> Posts</div>
                        <div><span>' . $row['total_followers'] . '</span> Followers</div>
                        <div><span>' . $row['total_following'] . '</span> Following</div>
                    </div>
                </div>
              </div>';
    }
    echo '</div>';
} else {
    echo '<p class="text-center">No users found.</p>';
}
?>
