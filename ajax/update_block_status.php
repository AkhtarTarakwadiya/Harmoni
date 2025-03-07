<?php
include '../database/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $user_isblock = isset($_POST['user_isblock']) ? intval($_POST['user_isblock']) : 0;

    if ($user_id > 0) {
        $sql = "UPDATE user_master SET user_isblock = ? WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $user_isblock, $user_id);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo json_encode(["status" => "success", "message" => "User block status updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update block status"]);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid user ID"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}

mysqli_close($conn);
?>
