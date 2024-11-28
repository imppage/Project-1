<?php
session_start();
include('../includes/db_connect.php');

// Initialize error message variable
$error = "";

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the input data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate admin credentials
    $sql1 = "SELECT * FROM admins WHERE email = '$email'";
    $sql2 = "SELECT * FROM users WHERE email = '$email'";

    $result1 = $conn->query($sql1);
    $result2 = $conn->query($sql2);

    // Check if credentials match admin
    if ($result1->num_rows > 0) {
        $admin = $result1->fetch_assoc();

        // Verify password using password_verify()
        if ($password == $admin['password']) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_name'] = $admin['name'];
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_email'] = $admin['email'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid credentials.";
        }
    } 
    // Check if credentials match user
    else if ($result2->num_rows > 0) {
        $user = $result2->fetch_assoc();

        // Verify password using password_verify()
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_name'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            header("Location: ../public/user_dashboard.php");
            exit();
        } else {
            $error = "Invalid credentials.";
        }
    } 
    // No match found
    else {
        $error = "Invalid credentials.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Login</h2>
        
        <!-- Display error message only after form is submitted and credentials are invalid -->
        <?php if (!empty($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <button type="submit" class="btn btn-primary" ><a href = "../public/index.php" style = "color:white; text-decoration:none;">Back</a></button>
            <p>New to the website? <a href="../public/register.php">Register</a> </p>
        </form>
    </div>
</body>
</html>
