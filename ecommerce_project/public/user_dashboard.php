<?php
session_start();

// include '../includes/header.php';
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: ../admin/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .buttons{
            background-color: #11114e;
            padding: .5rem 2rem;
            border-radius:.5rem;
            color: white;
        }
        .buttons:hover{
            color: white;
            box-shadow: rgba(20, 20, 20, 0.5) -5px 5px;
            text-decoration: none;
        }
    </style>
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
                    <a class="nav-link" href="../public/index.php">Home</a>
                </li>
                <li class="nav-item">
                    <!-- <a class="nav-link" href="../admin/login.php">Login</a> -->
                </li>
                <li class="nav-item">
                    <!-- <a class="nav-link" href="../public/register.php">Sign Up</a> -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/about.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/contact.php">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/cart.php">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/order_history.php">Order History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5" >
        <div style = "display: flex; justify-content: space-evenly; font-size:1.5rem">
            <!-- <p><a href="../public/cart.php" class = "buttons" >Go to Cart</a></p> -->
            <!-- <p><a href="wishlist.php" class = "buttons" >Go to Wishlist</a></p> -->
            <!-- <p><a href="order_history.php" class = "buttons" >Order History</a></p> -->
            <!-- <p><a href="../admin/logout.php" class = "buttons" >Logout</a></p> -->
        </div>
        <h2 style = "text-align:center;">Welcome, <?php echo $_SESSION['user_name']; ?>!</h2>
        <p style = "text-align:center; color:blue; font-size:2rem; ">Choose what you want to gift today.</p>
        <div class="row">
        <?php
        // Fetch products from the database
        include('../includes/db_connect.php');
        $result = $conn->query("SELECT * FROM products LIMIT 6");

        if ($result->num_rows > 0) {
            while($product = $result->fetch_assoc()) {
                echo '
                    <div class="col-md-4">
                        <div class="card">
                            <img src="' . $product['image_url'] . '" class="card-img-top" alt="' . $product['name'] . '" style="height: 50vh;">
                            <div class="card-body">
                                <h5 class="card-title">' . $product['name'] . '</h5>
                                <p class="card-text">Price: ' . $product['price'] . ' NPR</p>
                                <a href="product_details.php?id=' . $product['id'] . '" class="btn btn-primary">View Product</a>
                            </div>
                        </div>
                    </div>';
            }
        } else {
            echo "No products found!";
        }

        $conn->close();
        ?>
    </div>

    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
