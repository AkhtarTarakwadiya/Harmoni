<?php

ob_start(); // Output buffering start
// session_start();

include 'database/dao.php'; 

$dao = new Dao();

$columns = "*";
$table = "user_master";
$result = $dao->select($columns, $table);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Harmoni Admin - Manage Users</title>

    <link rel="shortcut icon" href="img/logo-removebg-preview.png" type="image/x-icon">
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
                                    <th>Sr. No</th>
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
                                <?php $i = 1; ?>
                                <?php while ($row = mysqli_fetch_assoc($result)) {

                                    $profileImage = !empty($row['user_profile_photo']) ?
                                        "http://192.168.4.220/Harmoni" . $row['user_profile_photo'] :
                                        "http://192.168.4.220/Harmoni/uploads/default_profile.png";
                                ?>

                                    <tr>
                                        <td><?php echo $i++; ?></td>
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
                                            $blockStatus = ($row['user_isblock'] == 1) ? "UNBLOCKED" : "BLOCKED";
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                scrollX: true
            });
        });
    </script>
    <script src="js/script.js"></script>
</body>
</html>
