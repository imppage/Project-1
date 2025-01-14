<?php
session_start();
// include('../includes/header.php');
include('../includes/db_connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: ../admin/login.php");
    exit();
}

$user_email = $_SESSION['user_email'];
?>

<head>
    <script src = "../includes/logout.js"></script>
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
                    <!-- <a class="nav-link" href="../public/cart.php">Cart</a> -->
                    <!-- <a class="nav-link" href="../public/register.php">Sign Up</a> -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/order_history.php">Order History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/about.php">About Us</a>
                </li>
                <li class="nav-item">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../public/contact.php">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="confirmLogOut()">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

<?php
// Fetch user_id from the users table using the email
$sql = "SELECT id FROM users WHERE email = '$user_email'";
$result = $conn->query($sql);

// Check if the user exists
if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_id = $user['id']; // Get the user ID

    // Now fetch cart items for the logged-in user using the user_id
    $sql = "SELECT * FROM cart WHERE user_id = '$user_id'";
    $result = $conn->query($sql);

    // Initialize cart items array
    $cart_items = [];

    if ($result && $result->num_rows > 0) {
        // Fetch the cart items and product details
        while ($row = $result->fetch_assoc()) {
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];
            $product_query = "SELECT * FROM products WHERE id = '$product_id'";
            $product_result = $conn->query($product_query);

            if ($product_result && $product_result->num_rows > 0) {
                $product = $product_result->fetch_assoc();
                $cart_items[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
        }
    } else {
        echo "<p style = 'font-size:2rem; text-align: center;'>Your cart is empty!!!</p>";
    }

} else {
    echo "Error: User not found.";
}

$conn->close();
?>



<div class="container mt-5" style="min-height:55vh;">
    <h2>Your Cart</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total_price = 0;
            foreach ($cart_items as $item) {
                $product = $item['product'];
                $quantity = $item['quantity'];
                $total = $product['price'] * $quantity;
                $total_price += $total;
                echo "
                    <tr>
                        <td>{$product['name']}</td>
                        <td>{$product['price']} NPR</td>
                        <td>{$quantity}</td>
                        <td>{$total} NPR</td>
                        <td>
                            <a href='remove_from_cart.php?id={$product['id']}' class='btn btn-danger'>Remove</a>
                        </td>
                    </tr>
                ";
            }
            ?>
        </tbody>
    </table>

    <h3>Total Price: <?php echo $total_price; ?> NPR</h3>

    <!-- Show the "Proceed to Checkout" button only if there are items in the cart -->
    <?php if (!empty($cart_items)) {
        echo "<a href='checkout.php?id={$product['id']}' class='btn btn-success'>Proceed to Checkout</a>";
    } ?>

    <a href="user_dashboard.php" class="btn btn-success" style="width:90px; margin-right:10px;">Back</a>
    
</div>
<?php include('../includes/footer.php'); ?>
