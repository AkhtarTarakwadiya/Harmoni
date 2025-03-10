<?php
include '../database/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $type = $_POST['type'];

    if ($type === "followers") {
        $sql = "SELECT u.user_name, u.user_profile_photo 
                FROM follow_master f
                JOIN user_master u ON f.follower_id = u.user_id
                WHERE f.following_id = ?";
    } else {
        $sql = "SELECT u.user_name, u.user_profile_photo 
                FROM follow_master f
                JOIN user_master u ON f.following_id = u.user_id
                WHERE f.follower_id = ?";
    }

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $profileImage = !empty($row['user_profile_photo']) ? "http://192.168.4.220/Harmoni" . $row['user_profile_photo'] : "http://192.168.4.220/Harmoni/uploads/default_profile.png";

            echo '<li class="list-group-item">
                    <img src="'.htmlspecialchars($profileImage).'" alt="Profile Pic" width="40" class="rounded-circle">
                    @'.htmlspecialchars($row['user_name']).'
                  </li>';
        }
    } else {
        echo '<li class="list-group-item text-center">No users found</li>';
    }

    mysqli_stmt_close($stmt);
}
?>
