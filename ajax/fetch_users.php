<?php
include '../database/db.php';

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'active';

if ($filter == 'active') {
    $sql = "SELECT 
                u.user_id,
                u.user_name, 
                u.user_full_name, 
                u.user_email, 
                u.gender, 
                u.user_profile_photo, 
                u.user_bio,
                (SELECT COUNT(*) FROM posts WHERE user_id = u.user_id AND post_status = 1) AS total_posts,
                (SELECT COUNT(*) FROM follow_master WHERE following_id = u.user_id) AS total_followers,
                (SELECT COUNT(*) FROM follow_master WHERE follower_id = u.user_id) AS total_following
            FROM user_master u 
            WHERE user_status = 1 AND user_isblock = 1";
} elseif ($filter == 'block') {
    $sql = "SELECT 
                u.user_id,
                u.user_name, 
                u.user_full_name, 
                u.user_email, 
                u.gender, 
                u.user_profile_photo, 
                u.user_bio,
                (SELECT COUNT(*) FROM posts WHERE user_id = u.user_id AND post_status = 1) AS total_posts,
                (SELECT COUNT(*) FROM follow_master WHERE following_id = u.user_id) AS total_followers,
                (SELECT COUNT(*) FROM follow_master WHERE follower_id = u.user_id) AS total_following
            FROM user_master u 
            WHERE user_isblock = 0";
} elseif ($filter == 'deactive') {
    $sql = "SELECT 
                u.user_id,
                u.user_name, 
                u.user_full_name, 
                u.user_email, 
                u.gender, 
                u.user_profile_photo, 
                u.user_bio,
                (SELECT COUNT(*) FROM posts WHERE user_id = u.user_id AND post_status = 1) AS total_posts,
                (SELECT COUNT(*) FROM follow_master WHERE following_id = u.user_id) AS total_followers,
                (SELECT COUNT(*) FROM follow_master WHERE follower_id = u.user_id) AS total_following
            FROM user_master u 
            WHERE user_status = 0";
}

$result = mysqli_query($conn, $sql);

$output = '<div class="row">'; // Start row div

while ($row = mysqli_fetch_assoc($result)) {
    $profileImage = !empty($row['user_profile_photo']) ? 
        "http://192.168.4.220/Harmoni" . $row['user_profile_photo'] : 
        "http://192.168.4.220/Harmoni/uploads/profile3.webp";

    $output .= '<div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="profile-card">
                        <img src="'.htmlspecialchars($profileImage).'" class="profile-pic" alt="Profile Pic">
                        <div class="username">@'.htmlspecialchars($row['user_name']).'</div>
                        <div class="fullname">'.htmlspecialchars($row['user_full_name']).'</div>
                        <div class="gender">Gender: '.htmlspecialchars($row['gender']).'</div>
                        <div class="email">Email: '.htmlspecialchars($row['user_email']).'</div>
                        <div class="bio">'.htmlspecialchars($row['user_bio'] ?: 'No bio available').'</div>
                        <div class="stats">
                            <div style="cursor: pointer;" class="view-posts" data-id="'.htmlspecialchars($row['user_id']).'">
                                <span>'.htmlspecialchars($row['total_posts']).'</span> Posts
                            </div>
                            <div style="cursor: pointer;" class="view-followers" data-id="'.htmlspecialchars($row['user_id']).'" data-type="followers">
                                <span>'.htmlspecialchars($row['total_followers']).'</span> Followers
                            </div>
                            <div style="cursor: pointer;" class="view-following" data-id="'.htmlspecialchars($row['user_id']).'" data-type="following">
                                <span>'.htmlspecialchars($row['total_following']).'</span> Following
                            </div>
                        </div>
                    </div>
                </div>';
}

$output .= '</div>'; 

echo $output;
?>

<script>
    $(document).ready(function() {

        $(document).on("click", ".view-followers, .view-following", function() {
        let userId = $(this).data("id");
        let type = $(this).data("type");
        let modalTitle = type === "followers" ? "Followers List" : "Following List";

        $("#userListModalLabel").text(modalTitle);

        $.ajax({
            url: "controller/fetch_users.php",
            method: "POST",
            data: { user_id: userId, type: type },
            dataType: "html",
            success: function(response) {
                $("#userList").html(response);
                $("#userListModal").modal("show"); 
            },
            error: function() {
                alert("Error fetching users!");
            }
        });
    });

    $(document).on("click", ".view-posts", function() {
        let userId = $(this).data("id");

        $.ajax({
            url: "controller/fetch_user_posts.php", 
            method: "POST",
            data: { user_id: userId },
            dataType: "html",
            success: function(response) {
                $("#userPostsGrid").html(response);
                $("#userPostsModal").modal("show"); 
            },
            error: function() {
                alert("Error fetching posts!");
            }
        });
    });
});

</script>