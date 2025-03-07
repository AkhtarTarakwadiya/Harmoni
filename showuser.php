<?php
include './database/db.php';

// Fetch user data
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
        WHERE user_status = 1 AND user_isblock = 1";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Harmoni Admin - Show Users</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include 'common/side.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'common/nav.php'; ?>

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Show Users</h1>
                    </div>

                    <div class="row">
                        <?php while ($row = mysqli_fetch_assoc($result)) { 
                            // Set profile image URL
                            $profileImage = !empty($row['user_profile_photo']) ? 
                                "http://192.168.4.220/Harmoni" . $row['user_profile_photo'] : 
                                "http://192.168.4.220/Harmoni/uploads/default_profile.png";
                        ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="profile-card">
                                    <img src="<?php echo htmlspecialchars($profileImage); ?>" class="profile-pic" alt="Profile Pic">
                                    <div class="username">@<?php echo htmlspecialchars($row['user_name']); ?></div>
                                    <div class="fullname"><?php echo htmlspecialchars($row['user_full_name']); ?></div>
                                    <div class="gender">Gender: <?php echo htmlspecialchars($row['gender']); ?></div>
                                    <div class="email">Email: <?php echo htmlspecialchars($row['user_email']); ?></div>
                                    <div class="bio"><?php echo htmlspecialchars($row['user_bio'] ?: 'No bio available'); ?></div>
                                    <div class="stats">
                                        <div><span><?php echo $row['total_posts']; ?></span> Posts</div>
                                        <div><span><?php echo $row['total_followers']; ?></span> Followers</div>
                                        <div><span><?php echo $row['total_following']; ?></span> Following</div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <?php include 'common/footer.php'; ?>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
</body>

</html>
