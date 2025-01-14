<?php
session_start();
include('../includes/db_connect.php');

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone_no = $_POST['phone_no'];

    // Validate phone number format (e.g., 10 digits)
    if (!preg_match('/^\d{10}$/', $phone_no)) {
        $error = "Invalid phone number. Please enter a valid 10-digit phone number.";
    } elseif ($password != $confirm_password) {
        // Password confirmation
        $error = "Passwords do not match.";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if email already exists
        $check_sql = "SELECT * FROM users WHERE email = '$email' ";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            $error = "Email already exists.";
        } else {
            // Insert new user into the database
            $insert_sql = "INSERT INTO users (username, email, password, phone_no) VALUES ('$username', '$email', '$hashed_password', '$phone_no')";
            if ($conn->query($insert_sql) === TRUE) {
                $_SESSION['user_logged_in'] = true;
                $_SESSION['username'] = $username;
                header("Location: ../admin/login.php");
                exit();
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>User Registration</h2>
        <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-group">
                <label for="phone_no">Phone Number</label>
                <input type="text" class="form-control" id="phone_no" name="phone_no" 
                    pattern="^\d{10}$" title="Please enter a valid 10-digit phone number." 
               required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
            <button type="submit" class="btn btn-primary"><a href="../public/index.php" style = "color:white; text-decoration:none;"> Back</a> </button>
        </form>
        <p>Already have an account? <a href="../admin/login.php">Login</a></p>
    </div>
</body>
</html>
