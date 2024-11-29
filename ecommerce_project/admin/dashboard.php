<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My E-Commerce Website</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">E-Commerce</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" style="color:black;" href="../public/index.php">Home</a>
                </li>
                <li class="nav-item">
                    <!-- <a class="nav-link" href="../admin/login.php">Login</a> -->
                </li>
                <li class="nav-item">
                    <!-- <a class="nav-link" href="../public/register.php"></a> -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color:black;" href="logout.php">Log out</a>
                </li>
            </ul>
        </div>
    </nav>


    <div class="container mt-5">
        <h2>Admin Dashboard</h2>
        <div style = "margin-top: 4rem;">
            <a href="manage_orders.php" class="btn btn-success">Manage Orders</a>
            <br><br>    
            <a href="manage_products.php" class="btn btn-success">Manage Products</a>
        </div>
    </div>
</body>
</html>

