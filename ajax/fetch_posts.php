<?php
include '../database/dao.php';
$dao = new Dao();

$limit = 20;
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$dateFilter = isset($_GET['date']) ? $_GET['date'] : 'all';
$engagementFilter = isset($_GET['engagement']) ? $_GET['engagement'] : 'all';
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : "";

// Base conditions
$whereConditions = ["p.post_status = 1"];

// Apply Search Filter
if (!empty($searchQuery)) {
    $whereConditions[] = "u.user_name LIKE '%" . $dao->getConnection()->real_escape_string($searchQuery) . "%'";
}

// Apply Date Filter
if ($dateFilter == "yesterday") {
    $whereConditions[] = "DATE(p.created_at) = DATE(NOW() - INTERVAL 1 DAY)";
} elseif ($dateFilter == "last_week") {
    $whereConditions[] = "p.created_at >= NOW() - INTERVAL 1 WEEK";
} elseif ($dateFilter == "last_month") {
    $whereConditions[] = "p.created_at >= NOW() - INTERVAL 1 MONTH";
}

// Convert conditions array into WHERE clause
$whereClause = !empty($whereConditions) ? implode(" AND ", $whereConditions) : "1";

// Define sorting order based on engagement filter
$orderClause = "ORDER BY p.created_at DESC";
if ($engagementFilter == "most_liked") {
    $orderClause = "ORDER BY like_count DESC";
} elseif ($engagementFilter == "most_commented") {
    $orderClause = "ORDER BY comment_count DESC";
}

// Fetch posts with DAO
$columns = "
    p.post_id, 
    p.user_id, 
    u.user_name, 
    p.post_content, 
    p.created_at, 
    GROUP_CONCAT(DISTINCT pm.media ORDER BY pm.media_id SEPARATOR ',') AS media_files,
    COUNT(DISTINCT CASE WHEN pl.status = 1 THEN pl.id END) AS like_count,  
    COUNT(DISTINCT CASE WHEN pc.comment_status = 1 THEN pc.comment_id END) AS comment_count
";

$joinTables = "
    posts p
    LEFT JOIN user_master u ON p.user_id = u.user_id
    LEFT JOIN posts_media_master pm ON p.post_id = pm.post_id
    LEFT JOIN likes_master pl ON p.post_id = pl.post_id
    LEFT JOIN comments_master pc ON p.post_id = pc.post_id
";

$otherClauses = "GROUP BY p.post_id $orderClause LIMIT $limit OFFSET $offset";

$result = $dao->select($columns, $joinTables, $whereClause, $otherClauses);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $post_id = (int)$row['post_id'];
        $mediaFiles = !empty($row['media_files'])
            ? array_map(fn($file) => "http://192.168.4.220/Harmoni/uploads/posts/" . $file, explode(',', $row['media_files']))
            : [];
        $totalMedia = !empty($mediaFiles) ? count($mediaFiles) : 0;
?>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4 post-card-wrapper">
            <div class="post-card">
                <div id="carousel_<?php echo $post_id; ?>" class="carousel slide post-carousel" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php if (!empty($mediaFiles)) {
                            foreach ($mediaFiles as $index => $media) {
                                $fileExtension = pathinfo($media, PATHINFO_EXTENSION);
                        ?>
                                <div class="carousel-item <?php echo $index == 0 ? 'active' : ''; ?>">
                                    <?php if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])) { ?>
                                        <img src="<?php echo htmlspecialchars($media); ?>" alt="Post Image">
                                    <?php } elseif (in_array(strtolower($fileExtension), ['mp4', 'webm', 'ogg'])) { ?>
                                        <video controls>
                                            <source src="<?php echo htmlspecialchars($media); ?>" type="video/<?php echo $fileExtension; ?>">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php } ?>
                                    <div class="media-count">
                                        <span><?php echo ($index + 1) . "/" . $totalMedia; ?></span>
                                    </div>
                                </div>
                            <?php }
                        } else { ?>
                            <div class="carousel-item active">
                                <img src="http://192.168.4.220/Harmoni/img/default-post-1.jpeg" alt="No Image Available">
                                <div class="media-count"><span>1/1</span></div>
                            </div>
                        <?php } ?>
                    </div>

                    <?php if ($totalMedia > 1) { ?>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel_<?php echo $post_id; ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel_<?php echo $post_id; ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    <?php } ?>
                </div>
                <div class="post-meta">
                    <div class="username">@<?php echo htmlspecialchars($row['user_name']); ?></div>
                    <div class="post-stats">
                        <button class="btn btn-sm btn-light view-likes" data-id="<?php echo $post_id; ?>" data-type="likes">
                            <i class="fas fa-heart"></i> <?php echo $row['like_count']; ?>
                        </button>
                        <button class="btn btn-sm btn-light view-comments" data-id="<?php echo $post_id; ?>" data-type="comments">
                            <i class="fas fa-comment"></i> <?php echo $row['comment_count']; ?>
                        </button>
                    </div>
                </div>
                <div class="description" id="desc_<?php echo $row['post_id']; ?>">
                    <span id="short_<?php echo $post_id; ?>">
                        <?php echo htmlspecialchars(substr($row['post_content'], 0, 50)) . (strlen($row['post_content']) > 50 ? '...' : ''); ?>
                    </span>
                    <span id="full_<?php echo $post_id; ?>" style="display: none;">
                        <?php echo htmlspecialchars($row['post_content']); ?>
                    </span>
                    <?php if (strlen($row['post_content']) > 50) { ?>
                        <span class="see-more" onclick="toggleDescription(<?php echo $post_id; ?>, this)">See More</span>
                    <?php } ?>
                </div>
            </div>
        </div>
<?php }
} else {
    if (!empty($searchQuery)) {
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'No User Found',
                text: 'No posts found for this username!',
                confirmButtonText: 'OK'
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'info',
                title: 'No More Posts',
                text: 'You have seen all the available posts!',
                confirmButtonText: 'OK'
            });
        </script>";
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
