<?php
include './database/db.php';

// Fetch Total Active Users
$usersql = "SELECT COUNT(*) as total FROM user_master WHERE user_status = 1";
$result = mysqli_query($conn, $usersql);
$user = mysqli_fetch_assoc($result);
$active_users = $user['total'];

// Fetch Recent User
$recent_usersql = "SELECT user_name FROM user_master WHERE user_status = 1 ORDER BY user_id DESC LIMIT 1";
$result = mysqli_query($conn, $recent_usersql);
$user = mysqli_fetch_assoc($result);
$recent_user = $user['user_name'];

// Fetch Total Posts
$postsql = "SELECT COUNT(*) as total FROM posts WHERE post_status = 1";
$result = mysqli_query($conn, $postsql);
$post = mysqli_fetch_assoc($result);
$total_posts = $post['total'];

// Recent Posts
$recent_postsql = "SELECT post_content FROM posts WHERE post_status = 1 ORDER BY post_id DESC LIMIT 1";
$result = mysqli_query($conn, $recent_postsql);
$post = mysqli_fetch_assoc($result);
$recent_post = $post['post_content'];

$conn->close();
?> 
 
 <!-- Total Users Card Example -->
 <div class="col-xl-3 col-md-6 mb-4">
     <div class="card border-left-primary shadow h-100 py-2">
         <div class="card-body">
             <div class="row no-gutters align-items-center">
                 <div class="col mr-2">
                     <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                         Total Active Users</div>
                     <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $active_users ?></div>
                 </div>
                 <div class="col-auto">
                     <i class="fa-solid fa-users text-gray-800"></i>
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
                     <i class="fa-solid fa-user text-gray-800"></i>
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
                         Recent Posts</div>
                     <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $recent_post ?></div>
                 </div>
                 <div class="col-auto">
                     <i class="fas fa-comments fa-2x text-gray-800"></i>
                 </div>
             </div>
         </div>
     </div>
 </div>