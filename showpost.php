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

                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="post-card">
                                <!-- Bootstrap Carousel for Images/Videos (No Auto-Slide) -->
                                <div id="post1Carousel" class="carousel slide post-carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="img/car1.jpg" alt="Post Image">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="img/car2.jpg" alt="Post Image">
                                        </div>
                                        <div class="carousel-item">
                                            <video controls>
                                                <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#post1Carousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#post1Carousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                </div>

                                <!-- Post Content -->
                                <div class="post-meta">
                                    <div class="username">@jone_doe</div>
                                    <div class="post-stats">
                                        <span class="likes-count"><i class="fas fa-heart"></i> 20</span>
                                        <span class="comments-count"><i class="fas fa-comment"></i> 15</span>
                                    </div>
                                </div>
                                <div class="description" id="desc1">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam... Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore, error recusandae eaque, cumque accusamus temporibus eius atque doloribus fugit quibusdam laborum iusto, incidunt aliquam exercitationem sit voluptatem. Itaque, dolor quasi?
                                </div>
                                <span class="see-more" onclick="toggleDescription('desc1', this)">See More</span>
                            </div>
                        </div>

                        <!-- Post 2 -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="post-card">
                                <div id="post2Carousel" class="carousel slide post-carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="img/car3.jpg" alt="Post Image">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="img/car1.jpg" alt="Post Image">
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#post2Carousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#post2Carousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                </div>

                                <div class="post-meta">
                                    <div class="username">@jane_smith</div>
                                    <div class="post-stats">
                                        <span class="likes-count"><i class="fas fa-heart"></i> 25</span>
                                        <span class="comments-count"><i class="fas fa-comment"></i> 10</span>
                                    </div>
                                </div>

                                <div class="description" id="desc2">
                                    This is a sample post about a city. It contains beautiful views and stunning buildings... Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore, error recusandae eaque, cumque accusamus temporibus eius atque doloribus fugit quibusdam laborum iusto, incidunt aliquam exercitationem sit voluptatem. Itaque, dolor quasi?
                                </div>
                                <span class="see-more" onclick="toggleDescription('desc2', this)">See More</span>
                            </div>
                        </div>

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