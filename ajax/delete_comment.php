<?php
include '../database/db.php';

if (isset($_POST['id'])) {
    $id = (int)$_POST['id']; // Ensure ID is integer to prevent SQL Injection

    $query = "UPDATE comments_master SET comment_status = 0 WHERE comment_id = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "success";
    } else {
        echo "error";
    }

    mysqli_close($conn);
}
