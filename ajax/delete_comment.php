<?php
include '../database/db.php';

if (isset($_POST['id'])) {
    $id = (int)$_POST['id']; // Ensure ID is integer to prevent SQL Injection
    $query = "UPDATE comments_master SET comment_status = 0 WHERE comment_id = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "success";
    } else {
        echo "error";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
