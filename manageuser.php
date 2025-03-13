<?php

ob_start(); // Output buffering start
// session_start();

include 'database/db.php';

// Fetch user data from user_master table
$sql = "SELECT * FROM user_master";
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


    <style>
        /* Manage user page css */
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
                                    <th>Remark</th>
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
                                        <td> <img src="<?php echo htmlspecialchars($profileImage); ?>" class="profile-pic" alt="Profile Pic" style="width: 50px; height: 50px">
                                        </td>
                                        <td>@<?php echo htmlspecialchars($row['user_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['user_full_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['user_email']); ?></td>
                                        <td><?php echo htmlspecialchars($row['user_phone_number']); ?></td>
                                        <td><?php echo htmlspecialchars($row['gender']); ?></td>
                                        <td><?php echo htmlspecialchars($row['user_bio'] ?: 'No bio available'); ?></td>
                                        <td>
                                            <i class="fas <?php echo ($row['user_isblock'] == 0) ? 'fa-lock' : 'fa-unlock'; ?> status-icon toggle-block"
                                                data-id="<?php echo $row['user_id']; ?>"
                                                data-status="<?php echo $row['user_isblock']; ?>"
                                                style="color: <?php echo ($row['user_isblock'] == 0) ? 'red' : 'green'; ?>; font-size: 18px; cursor: pointer;"></i>
                                        </td>


                                        <td>
                                            <?php
                                            $actionText = ($row['user_status'] == 1) ? "Deactivate" : "Activate";
                                            $btnClass = ($row['user_status'] == 1) ? "btn-warning" : "btn-success";
                                            ?>
                                            <a href="#" class="btn <?php echo $btnClass; ?> btn-sm toggle-status" data-id="<?php echo $row['user_id']; ?>" data-status="<?php echo $row['user_status']; ?>">
                                                <?php echo $actionText; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php
                                            $status = ($row['user_status'] == 1) ? "ACTIVE" : "INACTIVE";
                                            $blockStatus = ($row['user_isblock'] == 0) ? "BLOCKED" : "UNBLOCKED";
                                            echo htmlspecialchars("$status | $blockStatus");
                                            ?>
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
    <!-- Include SweetAlert -->
    <!-- Include SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                scrollX: true
            });

            $(document).on('click', '.toggle-block', function() {
                let icon = $(this);
                let userId = icon.data('id');
                let currentStatus = parseInt(icon.data('status'));
                let newStatus = currentStatus === 1 ? 0 : 1;
                let actionText = newStatus === 1 ? "unblock" : "block";

                Swal.fire({
                    title: `Are you sure?`,
                    text: `You want to ${actionText} this user?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: `Yes, ${actionText} it!`
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'ajax/update_block_status.php',
                            method: 'POST',
                            data: {
                                user_id: userId,
                                user_isblock: newStatus
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === "success") {
                                    Swal.fire({
                                        icon: "success",
                                        title: `User has been ${actionText}ed`,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    // ✅ Update the icon and color dynamically
                                    icon
                                        .removeClass(newStatus === 1 ? 'fa-lock' : 'fa-unlock')
                                        .addClass(newStatus === 1 ? 'fa-unlock' : 'fa-lock')
                                        .css('color', newStatus === 1 ? 'green' : 'red')
                                        .data('status', newStatus);

                                    // ✅ Update the "Remark" column correctly
                                    let statusCell = icon.closest('tr').find('.remark-status');
                                    let currentUserStatus = icon.closest('tr').find('.toggle-status').data('status') == 1 ? "ACTIVE" : "INACTIVE";
                                    let blockStatus = newStatus === 1 ? "UNBLOCKED" : "BLOCKED";
                                    statusCell.text(`${currentUserStatus} | ${blockStatus}`);
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: "Something went wrong. Try again!"
                                });
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.toggle-status', function(e) {
                e.preventDefault();
                let button = $(this);
                let userId = button.data('id');
                let currentStatus = button.data('status');
                let newStatus = currentStatus == 1 ? 0 : 1;
                let actionText = newStatus == 1 ? "activate" : "deactivate";

                Swal.fire({
                    title: "Are you sure?",
                    text: `You want to ${actionText} this user?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: `Yes, ${actionText} it!`
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'ajax/delete_users.php',
                            method: 'POST',
                            data: {
                                user_id: userId,
                                user_status: newStatus
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === "success") {
                                    Swal.fire({
                                        icon: "success",
                                        title: `User has been ${actionText}d`,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    // ✅ Update button text and class
                                    button.text(newStatus == 1 ? "Deactivate" : "Activate");
                                    button.toggleClass("btn-warning btn-success");
                                    button.data("status", newStatus);

                                    // ✅ Fix: Get the latest block/unblock status dynamically
                                    let statusCell = button.closest('tr').find('.remark-status');
                                    let blockStatus = button.closest('tr').find('.toggle-block').data('status') == 1 ? "UNBLOCKED" : "BLOCKED";
                                    let userStatus = newStatus == 1 ? "ACTIVE" : "INACTIVE";
                                    statusCell.text(`${userStatus} | ${blockStatus}`);
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: "Something went wrong. Try again!"
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>


</body>

</html>