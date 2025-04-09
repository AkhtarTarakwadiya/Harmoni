<?php
include './database/dao.php';
$dao = new Dao();

$column = 'COUNT(*) as total';
$table = 'user_master';
$where = '';

$users = $dao->select($column, $table, $where);

if ($users && $users->num_rows > 0) {
    $active_users = $users->fetch_assoc()['total'];
} else {
    $active_users = 0;
}

$column = 'user_name';
$table = 'user_master';
$where = 'user_status = 1';
$other = 'ORDER BY user_id DESC LIMIT 1';
$recent_users = $dao->select($column, $table, $where, $other);
if ($recent_users && $recent_users->num_rows > 0) {
    $recent_user = $recent_users->fetch_assoc()['user_name'];
} else {
    $recent_user = 'No User Found';
}

$column = 'COUNT(*) as total';
$table = 'posts';
$where = 'post_status = 1';
$posts = $dao->select($column, $table, $where);
if ($posts && $posts->num_rows > 0) {
    $total_posts = $posts->fetch_assoc()['total'];
} else {
    $total_posts = 0;
}

$column = 'user_name';
$table = 'user_master LEFT JOIN posts ON user_master.user_id = posts.user_id';
$where = 'user_status = 1';
$other = 'ORDER BY post_id DESC LIMIT 1';

$recent_post_users = $dao->select($column, $table, $where, $other);

if ($recent_post_users && $recent_post_users->num_rows > 0) {
    $recent_post = $recent_post_users->fetch_assoc()['user_name'];
} else {
    $recent_post = 'No Post Found';
}


?>

<!-- Total Users Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Total Users</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $active_users ?></div>
                </div>
                <div class="col-auto">
                    <i class="fa-solid fa-users fa-2x text-gray-800"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent User Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Recent User</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $recent_user ?></div>
                </div>
                <div class="col-auto">
                    <i class="fa-solid fa-user fa-2x text-gray-800"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Total Posts Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Active Posts
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $total_posts ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-800"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Posts Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Recent Post By</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $recent_post ?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-comments fa-2x text-gray-800"></i>
                </div>
            </div>
        </div>
    </div>
</div>