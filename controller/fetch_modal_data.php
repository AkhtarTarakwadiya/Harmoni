<?php
include '../database/dao.php';

$dao = new Dao();

$type = isset($_POST['type']) ? $_POST['type'] : '';
$post_id = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;

if (!$post_id || !in_array($type, ['likes', 'comments'])) {
    echo '<p class="text-center">Invalid request.</p>';
    exit;
}

if ($type === 'likes') {
    $columns = "u.user_id, u.user_name, u.user_full_name, u.user_profile_photo";
    $table = "likes_master l LEFT JOIN user_master u ON l.user_id = u.user_id";
    $where = "l.post_id = $post_id AND l.status = 1";
} else {
    $columns = "c.comment_id, c.comment, u.user_id, u.user_name, u.user_full_name, u.user_profile_photo";
    $table = "comments_master c LEFT JOIN user_master u ON c.user_id = u.user_id";
    $where = "c.post_id = $post_id AND c.comment_status = 1";
}

$result = $dao->select($columns, $table, $where);

if (mysqli_num_rows($result) > 0) {
    echo '<ul class="list-group">';
    while ($row = mysqli_fetch_assoc($result)) {
        $profileImage = !empty($row['user_profile_photo']) ?
            "http://192.168.4.220/Harmoni" . htmlspecialchars($row['user_profile_photo']) :
            "http://192.168.4.220/Harmoni/uploads/default_profile.png";

        echo '<li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="d-flex align-items-center">
                    <img src="' . $profileImage . '" class="rounded-circle me-2" width="40" height="40">
                    <div>
                        <strong>@' . htmlspecialchars($row['user_name']) . '</strong>
                        <span class="d-block text-muted">' . htmlspecialchars($row['user_full_name']) . '</span>';

        // Show comment content only for comments
        if ($type === 'comments') {
            echo '<p class="mb-0">' . htmlspecialchars($row['comment']) . '</p>';
            echo '<button class="btn btn-sm text-danger delete-comment" data-id="' . $row['comment_id'] . '" style="position: absolute; right: 10px; top: 10px;">❌</button>';
        }

        echo '  </div>
                </div>
            </li>';
    }
    echo '</ul>';
} else {
    echo '<p class="text-center">This Post has no ' . ($type === 'likes' ? 'likes' : 'comments') . '.</p>';
}
?>
