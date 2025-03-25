<?php
session_start();
include './database/db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ./login');
    exit();
}
?>
<style>
    .dropdown-list {
        max-height: 300px;
        overflow-y: auto;
        position: relative;
        width: 350px;
    }

    .dropdown-menu {
        max-height: 300px !important;
        overflow-y: auto !important;
    }
</style>
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>


    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span id="notificationCounter" class="badge badge-danger badge-counter" style="display: none;"></span>
            </a>

            <!-- Dropdown - Alerts -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in dropdown-list"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Notifications Center
                </h6>

                <div id="notificationList">
                    <a class="dropdown-item text-center small text-gray-500" href="#">Loading...</a>
                </div>

            </div>

        </li>


        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['admin_name'] ?></span>
                <img class="img-profile rounded-circle"
                    src="img/undraw_profile.svg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="logout">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function fetchNotifications() {
        $.ajax({
            url: "./ajax/fetch_notifications.php",
            type: "GET",
            dataType: "json",
            cache: false,
            success: function(data) {
                let notificationList = $("#notificationList");
                let notificationCounter = $("#notificationCounter");

                notificationList.empty();

                // Update unread count badge
                if (data.unread_count > 0) {
                    notificationCounter.text(data.unread_count).show();
                } else {
                    notificationCounter.hide();
                }

                if (data.notifications.length > 0) {
                    data.notifications.forEach(notif => {
                        let isBold = notif.is_read == 0 ? "font-weight-bold" : "";

                        let notificationItem = `
                        <a class="dropdown-item d-flex align-items-start notification-item" href="#" 
                           data-notification-id="${notif.id}">
                            <div>
                                <div class="small text-gray-500">${notif.formatted_date}</div>
                                <span class="${isBold} d-block">${notif.message}</span>
                            </div>
                        </a>`;

                        notificationList.append(notificationItem);
                    });
                } else {
                    notificationList.append(`<a class="dropdown-item text-center small text-gray-500" href="#">No new notifications</a>`);
                }
            }
        });
    }



    // Mark notification as read when clicked
    $(document).on("click", ".notification-item", function() {
        let notificationId = $(this).data("notification-id");
        let notificationElement = $(this);

        $.ajax({
            url: "./ajax/update_notification.php",
            type: "POST",
            data: {
                notification_id: notificationId
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    notificationElement.find("span").removeClass("font-weight-bold");
                    fetchNotifications(); 
                }
            }
        });
    });

    // Fetch notifications every 10 seconds
    $(document).ready(function() {
        fetchNotifications();
        setInterval(fetchNotifications, 10000);
    });
</script>