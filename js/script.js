$(document).ready(function () {

    // Ajax for Login Form
    $(document).ready(function () {
        $("#loginForm").submit(function (event) {
            event.preventDefault();
    
            var email = $("#email").val().trim();
            var password = $("#password").val().trim();
            var isValid = true;
    
            // Email validation
            if (email === "") {
                isValid = false;
                Swal.fire({
                    title: "Field Required",
                    text: "Email is required!",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                return;
            }
    
            // Password validation
            if (password === "") {
                isValid = false;
                Swal.fire({
                    title: "Field Required",
                    text: "Password is required!",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                return;
            }
    
            if (isValid) {
                $.ajax({
                    url: "controller/admin_login.php",
                    type: "POST",
                    data: { email: email, password: password },
                    dataType: "json",
                    success: function (response) {
                        if (response.status === "success") {
                            Swal.fire({
                                title: "Login Successful!",
                                text: "You are being redirected...",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then(() => {
                                window.location.href = "index";
                            });
                        } else {
                            Swal.fire({
                                title: "Login Failed!",
                                text: response.message,
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }
                    }
                });
            }
        });
    });
    

    

    // Ajax For Show Media of Posts in Modal
    $(document).on("click", ".show-media", function () {
        let postId = $(this).data("post-id");
        $("#mediaContainer").html("<p>Loading...</p>");

        $.ajax({
            url: "ajax/fetch_media.php",
            type: "POST",
            data: {
                post_id: postId
            },
            success: function (response) {
                $("#mediaContainer").html(response);
                $("#mediaModal").modal("show");
            }
        });
    });

    // Ajax For Delete Media of Posts
    $(document).on("click", ".delete-media", function () {
        let mediaId = $(this).data("media-id");
        let mediaPath = $(this).data("media-path");

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "ajax/delete_media.php",
                    type: "POST",
                    data: {
                        media_id: mediaId,
                        media_path: mediaPath
                    },
                    success: function (response) {
                        Swal.fire({
                            title: "Deleted!",
                            text: response,
                            icon: "success"
                        }).then(() => {
                            $("#mediaModal").modal("hide"); // Close modal after deletion
                            location.reload(); // Refresh the page to reflect changes
                        });
                    },
                    error: function () {
                        Swal.fire("Error!", "There was an error deleting the media.", "error");
                    }
                });
            }
        });
    });


    // Ajax For Delete Posts
    $(document).on("click", ".delete-post", function () {
        let postId = $(this).data("post-id");

        Swal.fire({
            title: "Are you sure?",
            text: "This post will be marked as deleted and its media files will be removed.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "ajax/delete_posts.php",
                    type: "POST",
                    data: {
                        post_id: postId
                    },
                    success: function (response) {
                        Swal.fire({
                            title: "Deleted!",
                            text: response,
                            icon: "success"
                        }).then(() => {
                            location.reload(); // Refresh page to reflect changes
                        });
                    },
                    error: function () {
                        Swal.fire("Error!", "Failed to delete the post.", "error");
                    }
                });
            }
        });
    });

    // Ajax For Update User Status Like Block/Unblock
    $(document).on('click', '.toggle-block', function () {
        let icon = $(this);
        let userId = icon.data('id');
        let isBlocked = icon.data('status') == 1 ? 0 : 1; // Toggle status
        let actionText = isBlocked ? "unblock" : "block";

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
                        user_isblock: isBlocked
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === "success") {
                            Swal.fire({
                                icon: "success",
                                title: `User has been ${actionText}ed`,
                                showConfirmButton: false,
                                timer: 1500
                            });

                            // **Update the icon, color, and data-status attribute**
                            if (isBlocked) {
                                icon.removeClass('fa-lock').addClass('fa-unlock').css('color', 'green');
                            } else {
                                icon.removeClass('fa-unlock').addClass('fa-lock').css('color', 'red');
                            }
                            icon.data('status', isBlocked);

                            // **Update the "Remark" column dynamically**
                            let statusCell = icon.closest('tr').find('td:last');
                            let currentStatus = icon.closest('tr').find('.toggle-status').data('status') == 1 ? "ACTIVE" : "INACTIVE";
                            let blockStatus = isBlocked ? "UNBLOCKED" : "BLOCKED";
                            statusCell.text(`${currentStatus} | ${blockStatus}`);
                        }
                    },
                    error: function () {
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



    // Ajax For Soft Delete Users 
    $(document).on('click', '.toggle-status', function (e) {
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
                    success: function (response) {
                        if (response.status === "success") {
                            Swal.fire({
                                icon: "success",
                                title: `User has been ${actionText}d`,
                                showConfirmButton: false,
                                timer: 1500
                            });

                            // **Toggle button text and class dynamically**
                            button.text(newStatus == 1 ? "Deactivate" : "Activate");
                            button.toggleClass("btn-danger btn-success");
                            button.data("status", newStatus);

                            // **Update the status text in the table dynamically**
                            let statusCell = button.closest('tr').find('td:last');
                            let blockStatus = button.closest('tr').find('.toggle-block').data('status') == 0 ? "BLOCKED" : "UNBLOCKED";
                            let userStatus = newStatus == 1 ? "ACTIVE" : "INACTIVE";
                            statusCell.text(`${userStatus} | ${blockStatus}`);
                        }
                    },
                    error: function () {
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