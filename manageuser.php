<?php
include 'config/db.php';

// Fetch user data from user_master table
$sql = "SELECT * FROM user_master WHERE user_status = 1";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Harmoni Admin - Manage Users</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
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
                        <h1 class="h3 mb-0 text-gray-800">Manage Users</h1>
                    </div>
                    <div class="dataTables_wrapper">
                        <table id="datatable" class="display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Profile Pic</th>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Gender</th>
                                    <th>Bio</th>
                                    <th>Block</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) {

                                    $profileImage = !empty($row['user_profile_photo']) ?
                                        "http://192.168.4.220/Harmoni" . $row['user_profile_photo'] :
                                        "http://192.168.4.220/Harmoni/uploads/default_profile.png";
                                ?>

                                    <tr>
                                        <td><?php echo $row['user_id']; ?></td>
                                        <td> <img src="<?php echo htmlspecialchars($profileImage); ?>" class="profile-pic" alt="Profile Pic" height="50" width="50">
                                        </td>
                                        <td>@<?php echo htmlspecialchars($row['user_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['user_full_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['user_email']); ?></td>
                                        <td><?php echo htmlspecialchars($row['user_phone_number']); ?></td>
                                        <td><?php echo htmlspecialchars($row['gender']); ?></td>
                                        <td><?php echo htmlspecialchars($row['user_bio'] ?: 'No bio available'); ?></td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" class="block-toggle" data-id="<?php echo $row['user_id']; ?>" <?php echo ($row['user_isblock'] == 1) ? 'checked' : ''; ?>>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <a href="edit_user.php?id=<?php echo $row['user_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="delete_user.php?id=<?php echo $row['user_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php include 'common/footer.php'; ?>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                scrollX: true
            });

            $('.block-toggle').on('change', function() {
                let userId = $(this).data('id');
                let isBlocked = $(this).prop('checked') ? 1 : 0;

                $.ajax({
                    url: 'update_block_status.php',
                    method: 'POST',
                    data: {
                        user_id: userId,
                        user_isblock: isBlocked
                    },
                    success: function(response) {
                        console.log(response);
                    }
                });
            });
        });
    </script>

    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 34px;
            height: 20px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 20px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 14px;
            width: 14px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #007bff;
        }

        input:checked+.slider:before {
            transform: translateX(14px);
        }
    </style>
</body>

</html>