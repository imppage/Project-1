<?php
session_start();

// If the cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty.";
    exit();
}

$cart = $_SESSION['cart'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Your Cart</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($cart as $product_id => $quantity) {
                    // Fetch product details from the database
                    include('../includes/db_connect.php');
                    $sql = "SELECT * FROM products WHERE id = $product_id";
                    $result = $conn->query($sql);
                    $product = $result->fetch_assoc();
                    
                    $total_price = $product['price'] * $quantity;
                    $total += $total_price;
                    
                    echo "
                    <tr>
                        <td>{$product['name']}</td>
                        <td>{$product['price']} NPR</td>
                        <td>{$quantity}</td>
                        <td>{$total_price} NPR</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
        <p><strong>Total Price: <?php echo $total; ?> NPR</strong></p>
        <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
    </div>
</body>
</html>
