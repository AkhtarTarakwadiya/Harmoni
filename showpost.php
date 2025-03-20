<?php
include 'database/db.php';

// Count all posts
$allCountQuery = "SELECT COUNT(*) AS total FROM posts WHERE post_status = 1";
$allCountResult = mysqli_query($conn, $allCountQuery);
$allCount = mysqli_fetch_assoc($allCountResult)['total'];

// Count yesterday's posts
$yesterdayQuery = "SELECT COUNT(*) AS total FROM posts WHERE DATE(created_at) = DATE(NOW() - INTERVAL 1 DAY) AND post_status = 1";
$yesterdayResult = mysqli_query($conn, $yesterdayQuery);
$yesterdayCount = mysqli_fetch_assoc($yesterdayResult)['total'];

// Count last week's posts
$lastWeekQuery = "SELECT COUNT(*) AS total FROM posts WHERE created_at >= NOW() - INTERVAL 1 WEEK AND post_status = 1";
$lastWeekResult = mysqli_query($conn, $lastWeekQuery);
$lastWeekCount = mysqli_fetch_assoc($lastWeekResult)['total'];

// Count last month's posts
$lastMonthQuery = "SELECT COUNT(*) AS total FROM posts WHERE created_at >= NOW() - INTERVAL 1 MONTH AND post_status = 1";
$lastMonthResult = mysqli_query($conn, $lastMonthQuery);
$lastMonthCount = mysqli_fetch_assoc($lastMonthResult)['total'];

// Count Most Liked Posts
$mostLikedQuery = "SELECT COUNT(DISTINCT post_id) AS total FROM likes_master WHERE status = 1";
$mostLikedResult = mysqli_query($conn, $mostLikedQuery);
$mostLikedCount = mysqli_fetch_assoc($mostLikedResult)['total'];

// Count Most Commented Posts
$mostCommentedQuery = "SELECT COUNT(DISTINCT post_id) AS total FROM comments_master WHERE comment_status = 1";
$mostCommentedResult = mysqli_query($conn, $mostCommentedQuery);
$mostCommentedCount = mysqli_fetch_assoc($mostCommentedResult)['total'];

// Check if a search query is provided
$searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";

// Base query
$fetchPostsQuery = "
   SELECT 
    p.post_id, 
    p.user_id, 
    u.user_name, 
    p.post_content, 
    p.created_at, 
    GROUP_CONCAT(DISTINCT pm.media ORDER BY pm.media_id SEPARATOR ', ') AS media_files,
    COUNT(DISTINCT CASE WHEN pl.status = 1 THEN pl.id END) AS like_count,  
    COUNT(DISTINCT CASE WHEN pc.comment_status = 1 THEN pc.comment_id END) AS comment_count  
FROM posts p
LEFT JOIN user_master u ON p.user_id = u.user_id
LEFT JOIN posts_media_master pm ON p.post_id = pm.post_id
LEFT JOIN likes_master pl ON p.post_id = pl.post_id
LEFT JOIN comments_master pc ON p.post_id = pc.post_id
WHERE p.post_status = 1";

// Append search condition if needed
if (!empty($searchQuery)) {
    $fetchPostsQuery .= " AND u.user_name LIKE '%$searchQuery%'";
}

// Add GROUP BY and ORDER BY at the end correctly
$fetchPostsQuery .= " GROUP BY p.post_id ORDER BY p.created_at DESC";

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

                    <!-- Search Box -->
                    <div class="search-container d-flex align-items-center gap-3 mb-3">
                        <!-- Search Box -->
                        <input type="text" id="searchBox" class="form-control flex-grow-1" placeholder="Search by username..." value="<?php echo htmlspecialchars($searchQuery); ?>">

                        <div class="dropdowns d-flex gap-3">
                            <!-- Date Filter -->
                            <select id="dateFilter" class="form-select">
                                <option value="" selected>--- Select ---</option>
                                <option value="yesterday">Yesterday (<?php echo $yesterdayCount; ?>)</option>
                                <option value="last_week">Last Week (<?php echo $lastWeekCount; ?>)</option>
                                <option value="last_month">Last Month (<?php echo $lastMonthCount; ?>)</option>
                            </select>

                            <!-- Engagement Filter -->
                            <select id="engagementFilter" class="form-select">
                                <option value="" selected>--- Select ---</option>
                                <option value="most_liked">Most Liked (<?php echo $mostLikedCount; ?>)</option>
                                <option value="most_commented">Most Commented (<?php echo $mostCommentedCount; ?>)</option>
                            </select>
                        </div>

                    </div>


                    <div class="row" id="postContainer">
                        <!-- Posts will be loaded here -->
                    </div>

                    <!-- Load More Button -->
                    <div class="text-center mt-3">
                        <button id="loadMore" class="btn btn-primary mb-3">Load More</button>
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

    <!-- Like & Comment Modal -->
    <div class="modal fade" id="likeCommentModal" tabindex="-1" role="dialog" aria-labelledby="likeCommentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="likeCommentModalLabel">Loading...</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBody">
                    <p>Loading...</p>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <script>
        $(document).ready(function() {
            let offset = 0;
            const limit = 20;

            function loadPosts(reset = false) {
                if (reset) {
                    offset = 0;
                    $("#postContainer").html(""); // Clear previous results when searching
                    $("#loadMore").hide(); // Hide initially until more posts exist
                }

                $.ajax({
                    url: "ajax/fetch_posts.php",
                    method: "GET",
                    data: {
                        offset: offset,
                        limit: limit,
                        date: $("#dateFilter").val(),
                        engagement: $("#engagementFilter").val(),
                        search: $("#searchBox").val().trim() // Include search input
                    },
                    success: function(response) {
                        if (response.trim() === "") {
                            if (offset === 0) {
                                $("#postContainer").html("<p class='text-center text-muted'>No posts found.</p>");
                            }
                            $("#loadMore").hide(); // Hide Load More if no results
                        } else {
                            $("#postContainer").append(response);
                            offset += limit;

                            // Show "Load More" button if there are more posts
                            if ($(response).length >= limit) {
                                $("#loadMore").show();
                            } else {
                                $("#loadMore").hide();
                            }
                        }
                    },
                    error: function() {
                        alert("Error fetching posts!");
                    }
                });
            }

            // Load posts initially
            loadPosts(true);

            // Load more posts on button click
            $("#loadMore").on("click", function() {
                loadPosts();
            });

            // Re-fetch posts when filters change
            $("#dateFilter, #engagementFilter").on("change", function() {
                loadPosts(true);
            });

            // Search dynamically
            $("#searchBox").on("keyup", function() {
                loadPosts(true);
            });
        });


        $(document).on("click", ".view-likes, .view-comments", function() {
            let postId = $(this).data("id");
            let type = $(this).data("type");
            let modalTitle = type === "likes" ? "People who liked this post" : "Comments on this post";

            $("#likeCommentModalLabel").text(modalTitle); // Set modal title

            $.ajax({
                url: "controller/fetch_modal_data.php",
                method: "POST",
                data: {
                    post_id: postId,
                    type: type
                },
                dataType: "html",
                success: function(response) {
                    $("#modalBody").html(response);
                    $("#likeCommentModal").modal("show"); // Show modal
                },
                error: function() {
                    alert("Error fetching data!");
                }
            });
        });



        function toggleDescription(postId, el) {
            var descContainer = document.getElementById("desc_" + postId);
            var shortText = document.getElementById("short_" + postId);
            var fullText = document.getElementById("full_" + postId);
            var postCard = el.closest(".post-card"); // Get only the clicked card

            if (shortText.style.display === "none") {
                // Collapse back
                shortText.style.display = "inline";
                fullText.style.display = "none";
                descContainer.classList.remove("expanded");
                postCard.classList.remove("expanded-card");
                el.textContent = "See More";
            } else {
                // Expand only this one
                shortText.style.display = "none";
                fullText.style.display = "inline";
                descContainer.classList.add("expanded");
                postCard.classList.add("expanded-card");
                el.textContent = "See Less";
            }
        }

        $(document).on("click", ".delete-comment", function(e) {
            e.preventDefault();

            var commentId = $(this).data("id");

            Swal.fire({
                title: "Are you sure?",
                text: "Do you really want to delete this comment?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "ajax/delete_comment.php", // Ensure this matches your actual PHP script
                        type: "POST",
                        data: {
                            id: commentId
                        },
                        success: function(response) {
                            if (response.trim() === "success") {
                                $("#comment-" + commentId).fadeOut();
                                Swal.fire("Deleted!", "The comment has been deleted.", "success");
                            } else {
                                Swal.fire("Error!", "Something went wrong.", "error");
                            }
                        },
                        error: function() {
                            Swal.fire("Error!", "Could not reach the server.", "error");
                        }
                    });
                }
            });
        });



        // $(document).ready(function() {
        //     $("#searchBox").on("keyup", function() {
        //         var searchText = $(this).val().toLowerCase();
        //         $(".post-card-wrapper").each(function() {
        //             var username = $(this).data("username");
        //             $(this).toggle(username.includes(searchText));
        //         });
        //     });
        // });

        $(document).ready(function() {
            function fetchFilteredPosts() {
                let dateFilter = $("#dateFilter").val();
                let engagementFilter = $("#engagementFilter").val();

                $.ajax({
                    url: "ajax/fetch_posts.php",
                    method: "GET",
                    data: {
                        date: dateFilter,
                        engagement: engagementFilter
                    },
                    success: function(response) {
                        $("#postContainer").html(response);
                    },
                    error: function() {
                        alert("Error fetching posts!");
                    }
                });
            }

            // Trigger AJAX when filters change
            $("#dateFilter, #engagementFilter").on("change", function() {
                fetchFilteredPosts();
            });

            // Load all posts initially
            fetchFilteredPosts();
        });
    </script>

</body>

</html>