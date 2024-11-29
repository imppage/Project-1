<?php
session_start();
include('../includes/db_connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: ../admin/login.php");
    exit();
}

$user_email = $_SESSION['user_email'];

// Fetch user_id from the users table using the email
$sql = "SELECT id, username FROM users WHERE email = '$user_email'";
$result = $conn->query($sql);

// Check if the user exists
if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_id = $user['id']; // Get the user ID

    // Now fetch cart items for the logged-in user using the user_id
    $sql = "SELECT cart.product_id, cart.quantity, products.name, products.price, products.image_url, products.stock_quantity 
            FROM cart
            JOIN products ON cart.product_id = products.id
            WHERE cart.user_id = '$user_id'";
    $result = $conn->query($sql);

    // Initialize cart items array
    $cart_items = [];
    $total_price = 0;
    $valid_order = true; // Flag to check if all quantities are valid

    if ($result && $result->num_rows > 0) {
        // Fetch the cart items and product details
        while ($row = $result->fetch_assoc()) {
            $total = $row['price'] * $row['quantity'];
            // Check if the quantity in the cart exceeds available stock
            if ($row['quantity'] > $row['stock_quantity']) {
                $valid_order = false; // Invalid order if quantity exceeds stock
                $row['quantity_error'] = "Only " . $row['stock_quantity'] . " available."; // Error message for this item
            } else {
                $row['quantity_error'] = "";
            }
            $cart_items[] = [
                'product' => $row['name'],
                'price' => $row['price'],
                'quantity' => $row['quantity'],
                'total' => $total,
                'stock_quantity' => $row['stock_quantity'],
                'quantity_error' => $row['quantity_error']
            ];
            $total_price += $total;
        }
    } else {
        echo "<p style='font-size:2rem; text-align: center;'>Your cart is empty!</p>";
        exit();
    }
} else {
    echo "Error: User not found.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
    </style>
</head>
<body>

<!-- Include Header -->
<?php include('../includes/header.php'); ?>

<div class="container mt-5" style="min-height: 60vh;">
    <h2>Review Your Order</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Available Stock</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart_items as $item) { ?>
                <tr>
                    <td><?php echo $item['product']; ?></td>
                    <td><?php echo number_format($item['price'], 2); ?> NPR</td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo $item['stock_quantity']; ?></td>
                    <td><?php echo number_format($item['total'], 2); ?> NPR</td>
                </tr>
                <?php if ($item['quantity_error']) { ?>
                    <tr>
                        <td colspan="5" class="text-danger">
                            <?php echo $item['quantity_error']; ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>

    <h3>Total Price: <?php echo number_format($total_price, 2); ?> NPR</h3>

    <!-- Shipping Address Form -->
    <form method="POST" action="pay_now.php">
        <h4>Shipping Address</h4>
        <div class="form-group">
            <label for="address">Enter your shipping address:</label>
            <textarea id="address" name="address" class="form-control" rows="4" required></textarea>
        </div>

        <!-- Disable Place Order button if the order is invalid -->
        <?php if (!$valid_order) { ?>
            <button type="button" class="btn btn-danger" disabled>Order Not Valid</button>
            <p class="text-danger">Please adjust your quantities to match available stock.</p>
        <?php } else { ?>
            <button type="submit" class="btn btn-success">Proceed to Pay</button>
        <?php } ?>

        <a href="cart.php" class="btn btn-danger">Go Back to Cart</a>
    </form>
</div>

<!-- Include Footer -->
<?php include('../includes/footer.php'); ?>

</body>
</html>
