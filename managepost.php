<?php
include 'database/dao.php';
$dao = new Dao();

$table = "posts p LEFT JOIN user_master u ON p.user_id = u.user_id";
$columns = "p.post_id, u.user_name, p.post_content";
$where = "p.post_status = 1";
$order = "ORDER BY p.created_at DESC";

$result = $dao->select($columns, $table, $where, $order);
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

    <link rel="shortcut icon" href="img/logo-removebg-preview.png" type="image/x-icon">

    <!-- Custom fonts -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>

<body id="page-top">

    <div id="wrapper">

        <?php include 'common/side.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'common/nav.php' ?>

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Manage Posts</h1>
                    </div>

                    <div class="dataTables_wrapper">
                        <table id="datatable" class="display">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>User Name</th>
                                    <th>Post Content</th>
                                    <th>Post Media</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                                        <td><?php echo htmlspecialchars(substr($row['post_content'], 0, 50)) . '...'; ?></td>
                                        <td>
                                            <button class="btn btn-primary btn-sm show-media" data-post-id="<?php echo $row['post_id']; ?>">
                                                Show Media
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-sm delete-post" data-post-id="<?php echo $row['post_id']; ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <?php include 'common/footer.php' ?>

        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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

    <!-- Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/script.js"></script>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>

</body>

</html>
