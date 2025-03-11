<?php
include 'database/db.php';

$fetchPostsQuery = "
    SELECT 
        p.post_id, 
        u.user_name, 
        p.post_content 
    FROM posts p
    LEFT JOIN user_master u ON p.user_id = u.user_id
    WHERE p.post_status = 1
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

    <title>Harmoni Admin - Manage Posts</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="css/style.css">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'common/side.php' ?>
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
                        <h1 class="h3 mb-0 text-gray-800">Manage Posts</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <div class="dataTables_wrapper">
                        <table id="datatable" class="display">
                            <thead>
                                <tr>
                                    <th>Post ID</th>
                                    <th>User Name</th>
                                    <th>Post Content</th>
                                    <th>Post Media</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo $row['post_id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                                        <td><?php echo htmlspecialchars(substr($row['post_content'], 0, 50)) . '...'; ?></td>
                                        <td>
                                            <button class="btn btn-primary btn-sm show-media" data-post-id="<?php echo $row['post_id']; ?>">
                                                Show Media
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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

    <!-- Modal for Media Display -->
    <div class="modal fade" id="mediaModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Post Media</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="mediaContainer" class="media-grid"></div>
                </div>
            </div>
        </div>
    </div>


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
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();

            $(".show-media").click(function() {
                let postId = $(this).data("post-id");
                $("#mediaContainer").html("<p>Loading...</p>");

                $.ajax({
                    url: "ajax/fetch_media.php",
                    type: "POST",
                    data: {
                        post_id: postId
                    },
                    success: function(response) {
                        $("#mediaContainer").html(response);
                        $("#mediaModal").modal("show");
                    }
                });
            });

            $(document).on("click", ".delete-media", function() {
                let mediaId = $(this).data("media-id");
                let mediaPath = $(this).data("media-path");

                if (confirm("Are you sure you want to delete this media?")) {
                    $.ajax({
                        url: "ajax/delete_media.php",
                        type: "POST",
                        data: {
                            media_id: mediaId,
                            media_path: mediaPath
                        },
                        success: function(response) {
                            alert(response);
                            $("#mediaModal").modal("hide");
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>