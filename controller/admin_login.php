<?php
session_start();
include '../database/dao.php';
$dao =  new Dao();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $column = 'admin_id, admin_name, admin_email, admin_password';  
    $table = 'admin_master';
    $where = 'admin_email = "' . $email . '"';
    $other = '';

    $result = $dao->select($column, $table, $where, $other);

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        if (password_verify($password, $admin['admin_password'])) {
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['admin_name'];
            $_SESSION['admin_email'] = $admin['admin_email'];

            echo json_encode(["status" => "success"]);
            exit();
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid Password!"]);
            exit();
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Admin Not Found!"]);
        exit();
    }
}
?>
