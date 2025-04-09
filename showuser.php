<?php
include './database/dao.php';

$dao = new Dao();

$columns = "user_id, 
            user_name, 
            user_full_name, 
            user_email, 
            gender, 
            user_profile_photo, 
            user_bio,  
            (SELECT COUNT(*) FROM posts WHERE user_id = u.user_id AND post_status = 1) AS total_posts,
            (SELECT COUNT(*) FROM follow_master WHERE following_id = u.user_id) AS total_followers,
            (SELECT COUNT(*) FROM follow_master WHERE follower_id = u.user_id) AS total_following";

$table = "user_master u";
$where = "user_status = 1 AND user_isblock = 1";
$other = ""; 

$result = $dao->select($columns, $table, $where, $other);

// Fetch counts for each user type
$activeCountQuery = $dao->select("COUNT(*) AS active_count", "user_master", "user_status = 1 AND user_isblock = 1");
$blockCountQuery = $dao->select("COUNT(*) AS block_count", "user_master", "user_isblock = 0");
$deactiveCountQuery = $dao->select("COUNT(*) AS deactive_count", "user_master", "user_status = 0");

// Fetch counts
$activeCount = mysqli_fetch_assoc($activeCountQuery)['active_count'];
$blockCount = mysqli_fetch_assoc($blockCountQuery)['block_count'];
$deactiveCount = mysqli_fetch_assoc($deactiveCountQuery)['deactive_count'];

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

    <link rel="shortcut icon" href="img/logo-removebg-preview.png" type="image/x-icon">
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
                <?php include 'common/nav.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Show Users</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <div class="search d-flex align-items-center gap-3 mb-3">
                        <input type="text" id="searchUser" class="form-control" placeholder="Search by name or username...">

                        <div class="d-flex align-items-center">
                            <select name="filter" id="filter" class="form-select">
                                <option value="active" selected>Active Users (<?php echo $activeCount; ?>)</option>
                                <option value="deactive">Deactive Users (<?php echo $deactiveCount; ?>)</option>
                                <option value="block">Blocked Users (<?php echo $blockCount; ?>)</option>
                            </select>
                        </div>
                    </div>



                    <div id="userResults">
                        <div class="row">
                            <?php while ($row = mysqli_fetch_assoc($result)) {
                                // Set profile image URL
                                $profileImage = !empty($row['user_profile_photo']) ?
                                    "http://192.168.4.220/Harmoni" . $row['user_profile_photo'] :
                                    "http://192.168.4.220/Harmoni/uploads/profile3.webp";
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
                                            <div class="view-posts" data-id="<?php echo $row['user_id']; ?>">
                                                <span><?php echo $row['total_posts']; ?></span> Posts
                                            </div>
                                            <div class="view-followers" data-id="<?php echo $row['user_id']; ?>" data-type="followers">
                                                <span><?php echo $row['total_followers']; ?></span> Followers
                                            </div>
                                            <div class="view-following" data-id="<?php echo $row['user_id']; ?>" data-type="following">
                                                <span><?php echo $row['total_following']; ?></span> Following
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include 'common/footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Followers/Following Modal -->
    <div class="modal fade" id="userListModal" tabindex="-1" role="dialog" aria-labelledby="userListModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userListModalLabel">User List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul id="userList" class="list-group">
                        <!-- User list will be loaded here dynamically -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Follower/following modal end -->

    <!-- User Posts Modal -->
    <div class="modal fade" id="userPostsModal" tabindex="-1" aria-labelledby="userPostsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userPostsModalLabel">User Posts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" id="userPostsGrid">
                        <!-- Posts will be loaded here dynamically -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>


    <script>
        $(document).ready(function() {
            $("#searchUser").on("keyup", function() {
                let query = $(this).val();

                $.ajax({
                    url: "controller/search_users.php",
                    method: "GET",
                    data: {
                        query: query
                    },
                    success: function(response) {
                        $("#userResults").html(response);
                    }
                });
            });

            $(".view-followers, .view-following").on("click", function() {
                let userId = $(this).data("id");
                let type = $(this).data("type");
                let modalTitle = type === "followers" ? "Followers List" : "Following List";

                $("#userListModalLabel").text(modalTitle);

                $.ajax({
                    url: "controller/fetch_users.php",
                    method: "POST",
                    data: {
                        user_id: userId,
                        type: type
                    },
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

            $(document).ready(function() {
                $("#filter").on("change", function() {
                    let filterValue = $(this).val();

                    $.ajax({
                        url: "ajax/fetch_users.php",
                        method: "GET",
                        data: {
                            filter: filterValue
                        },
                        success: function(response) {
                            $("#userResults").html(response);
                        },
                        error: function() {
                            alert("Error fetching users!");
                        }
                    });
                });
            });

        });
        $(document).ready(function() {
            $(".view-posts").on("click", function() {
                let userId = $(this).data("id");

                $.ajax({
                    url: "controller/fetch_user_posts.php", 
                    method: "POST",
                    data: {
                        user_id: userId
                    },
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


</body>

</html>