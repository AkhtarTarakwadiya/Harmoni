<?php
include 'database/db.php';

// Query to fetch posts, media, likes, and comments count
$fetchPostsQuery = "
    SELECT 
        p.post_id, 
        p.user_id, 
        u.user_name, 
        p.post_content, 
        p.created_at, 
        GROUP_CONCAT(DISTINCT pm.media) AS media_files,
        COUNT(DISTINCT pl.id) AS like_count,
        COUNT(DISTINCT pc.comment_id) AS comment_count
    FROM posts p
    LEFT JOIN user_master u ON p.user_id = u.user_id
    LEFT JOIN posts_media_master pm ON p.post_id = pm.post_id
    LEFT JOIN likes_master pl ON p.post_id = pl.post_id
    LEFT JOIN comments_master pc ON p.post_id = pc.post_id
    WHERE p.post_status = 1
    GROUP BY p.post_id 
    ORDER BY p.created_at DESC";

$result = mysqli_query($conn, $fetchPostsQuery);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Harmoni Admin - Show Posts</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'common/side.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'common/nav.php' ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Show Posts</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <div class="row">
                        <?php while ($row = mysqli_fetch_assoc($result)) {
                            $post_id = (int)$row['post_id'];

                            // Media file formatting - Full URL Path
                            $mediaFiles = !empty($row['media_files'])
                                ? array_map(fn($file) => "http://192.168.4.220/Harmoni/uploads/posts/" . $file, explode(',', $row['media_files']))
                                : [];
                        ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="post-card">
                                    <div id="carousel_<?php echo $post_id; ?>" class="carousel slide post-carousel" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php if (!empty($mediaFiles)) {
                                                $totalMedia = count($mediaFiles);
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
                                                        <div class="media-count-no">
                                                            <span><?php echo ($index + 1) . "/" . $totalMedia; ?></span>
                                                        </div>
                                                    </div>
                                                <?php }
                                            } else { ?>
                                                <div class="carousel-item active">
                                                    <img src="http://192.168.4.220/Harmoni/uploads/default.jpg" alt="No Image Available">
                                                    <div class="media-count"><span>1/1</span></div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel_<?php echo $post_id; ?>" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon"></span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carousel_<?php echo $post_id; ?>" data-bs-slide="next">
                                            <span class="carousel-control-next-icon"></span>
                                        </button>
                                    </div>

                                    <div class="post-meta">
                                        <div class="username">@<?php echo htmlspecialchars($row['user_name']); ?></div>
                                        <div class="post-stats">
                                            <span class="likes-count" data-post="<?php echo $post_id; ?>" onclick="openModal('likes', <?php echo $post_id; ?>)">
                                                <i class="fas fa-heart"></i> <?php echo $row['like_count']; ?>
                                            </span>
                                            <span class="comments-count" data-post="<?php echo $post_id; ?>" onclick="openModal('comments', <?php echo $post_id; ?>)">
                                                <i class="fas fa-comment"></i> <?php echo $row['comment_count']; ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="description" id="desc_<?php echo $post_id; ?>">
                                        <?php echo htmlspecialchars(substr($row['post_content'], 0, 100)) . '...'; ?>
                                    </div>
                                    <span class="see-more" onclick="toggleDescription('desc_<?php echo $post_id; ?>', this)">See More</span>
                                </div>
                            </div>

                        <?php } ?>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include 'common/footer.php' ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Press the "Logout" button if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <!-- <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        function openModal(type, postId) {
            alert("Show " + type + " list for Post ID: " + postId);
        }

        function toggleDescription(id, el) {
            var desc = document.getElementById(id);
            if (desc.style.maxHeight === "60px") {
                desc.style.maxHeight = "none";
                el.textContent = "See Less";
            } else {
                desc.style.maxHeight = "60px";
                el.textContent = "See More";
            }
        }
    </script>

</body>

</html>