<?php
include 'database/db.php';
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_new_password = password_hash($password, PASSWORD_BCRYPT);
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    $sql = "INSERT INTO `admin_master` (`admin_name`, `admin_email`, `admin_phone`,`admin_password`)
                                 VALUES ('$name', '$email', '$phone', '$hashed_new_password')";
    $result = $conn->query($sql);
    if ($result) {
        echo "Admin registered successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="admin_reg.php" method="post">
        <input type="text" name="name" placeholder="Name">
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <input type="text" name="phone" placeholder="Phone">
        <button type="submit" name="submit">Submit</button>
    </form>
</body>
</html>