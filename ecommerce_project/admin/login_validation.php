
<?php
session_start();
include('../includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate admin credentials (you should store these securely)
    $sql1 = "SELECT * FROM admins WHERE email = '$email' AND password = '$password'";
    $sql2 = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

    $result1 = $conn->query($sql1);
    $result2 = $conn->query($sql2);

    if ($result1->num_rows > 0) {
        $admin = $result1->fetch_assoc();
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $admin['email'];
        $_SESSION['admin_password'] = $admin['password'];
        header("Location: dashboard.php");
        exit();
    } else if($result2->num_rows > 0){
        $user = $result2->fetch_assoc();
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_password'] = $user['password'];
        header("Location: ../public/user_dashboard.php");
        exit();

    }else {
        $error = "Invalid credentials.";
    }
}else {
    $error = "Invalid credentials.";
}
$conn->close();
?>
