<?php
session_start();
include('../includes/db_connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['user_email'];

// Fetch user_id from the users table using the email
$sql = "SELECT id FROM users WHERE email = '$user_email'";
$result = $conn->query($sql);

// Check if the user exists
if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_id = $user['id']; // Get the user ID

    // Fetch the orders of the logged-in user
    $orders_sql = "SELECT * FROM orders WHERE user_id = '$user_id' AND payment_status = 'paid' ORDER BY order_date DESC";
    $orders_result = $conn->query($orders_sql);
} else {
    echo "Error: User not found.";
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <script src="../includes/logout.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .order-status {
            font-weight: bold;
        }
        .buttons {
            background-color: #11114e;
            padding: .5rem 2rem;
            border-radius: .5rem;
            color: white;
        }
        .buttons:hover {
            color: white;
            box-shadow: rgba(20, 20, 20, 0.5) -5px 5px;
            text-decoration: none;
        }
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
        /* Ensure the logo image adjusts automatically */
        .navbar-brand {
            border-radius:100px;
        }
        .navbar-brand img {
            max-height: 60px; /* Maximum height of the logo */
            /* border-radius: 10px; */
            width: auto; /* Keep aspect ratio intact */
            height: auto; /* Maintain the original aspect ratio */
        }

        /* Optional: Adjust navbar height to ensure it looks good with the logo */
        .navbar {
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>



<nav class="navbar navbar-expand-lg navbar-light bg-light">
<a class="navbar-brand" href="../public/index.php" style="color:green;">
            <img src="../images/treasureGifts_logo.png" alt="TreasureGifts Logo"> <!-- Path to your logo -->
            TreasureGifts
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../public/user_dashboard.php">Home</a>
                </li>
                <li class="nav-item">
                    <!-- <a class="nav-link" href="../admin/login.php">Login</a> -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/cart.php">Cart</a>
                    <!-- <a class="nav-link" href="../public/register.php">Sign Up</a> -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/about.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/contact.php">Contact Us</a>
                </li>
                <li class="nav-item">
                </li>
                <li class="nav-item">
                    <!-- <a class="nav-link" href="../public/order_history.php">Order History</a> -->
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#" onclick="confirmLogOut()">Logout</a>
                </li>
            </ul>
        </div>
    </nav>


<div class="container mt-5" style="min-height:55vh">
    <h2>Your Order History</h2>

    <?php if ($orders_result && $orders_result->num_rows > 0): ?>
        <!-- Display each order -->
        <?php while ($order = $orders_result->fetch_assoc()): ?>
            <div class="order-card mt-4 p-3 border border-primary">
                <!-- <h4>Order ID: <?php echo $order['id']; ?></h4> -->
                <h4>Order Date: <?php echo date('d-m-Y', strtotime($order['order_date'])); ?></h4>
                <h4>Payment Status: <?php echo $order['payment_status']; ?></h4>

                <h5 class="order-status" style = "margin: 0 25rem; padding: 1rem 0; color:yellow; text-align:center; background-color:gray; ">Approval Status: <?php echo $order['status']; ?></h5>
                
                <!-- Display ordered products -->
                <h5>Ordered Products:</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Amount</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch products for this order
                        $order_id = $order['id'];
                        $order_details_sql = "SELECT * FROM order_items WHERE order_id = $order_id";
                        $order_details_result = $conn->query($order_details_sql);
                        
                        if ($order_details_result && $order_details_result->num_rows > 0) {
                            while ($order_detail = $order_details_result->fetch_assoc()) {
                                $product_id = $order_detail['product_id'];
                                $product_sql = "SELECT name, price FROM products WHERE id = $product_id";
                                $product_result = $conn->query($product_sql);
                                if ($product_result && $product_result->num_rows > 0) {
                                    $product = $product_result->fetch_assoc();
                                    echo "
                                    <tr>
                                    <td>{$product['name']}</td>
                                    <td>{$order_detail['quantity']}</td>
                                    <td>" . number_format($product['price'], 2) . " NPR</td>
                                    <td>" . number_format(($product['price'] * $order_detail['quantity']), 2) . " NPR</td>
                                    </tr>";
                                }
                            }
                        }
                        
                        ?>
                    </tbody>
                </table>
                
                <h4>Total Price: <?php echo number_format($order['total_price'], 2); ?> NPR</h4>
                
                <button type="submit" class="btn btn-primary" ><a href = "../public/user_dashboard.php" style = "color:white; text-decoration:none;">Back</a></button>
            </div>
            <?php endwhile; ?>
            <?php else: ?>
                <p>No orders found!</p>
                <a href="user_dashboard.php" class="btn btn-primary">Back</a>

                <?php endif; $conn->close();?>
                
            </div>
            
            <!-- Include Footer -->
<?php include('../includes/footer.php'); ?>

</body>
</html>
