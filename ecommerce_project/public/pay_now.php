<?php
session_start();
include('../includes/db_connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: ../admin/login.php");
    exit();
}

$user_email = $_SESSION['user_email'];
$address = $_POST['address'];

// Fetch user_id and order details (for simplicity, let's assume order details are in session)
$sql = "SELECT * FROM cart WHERE user_id = {$_SESSION['user_id']}";
$order_result = $conn->query($sql);

// Check if order exists
if ($order_result && $order_result->num_rows > 0) {
    $total_price = 0;  // Initialize total price
    $products_details = [];  // Initialize an empty array to store product details

    while ($order = $order_result->fetch_assoc()) {
        $product_id = $order['product_id'];
        $product_quantity = $order['quantity'];

        $sql2 = "SELECT * FROM products WHERE id = $product_id";
        $order_result2 = $conn->query($sql2);

        if ($order_result2 && $order_result2->num_rows > 0) {
            $product = $order_result2->fetch_assoc();
            $product_name = $product['name'];
            $product_price = $product['price'];
            $product_image_url = $product['image_url'];

            // Calculate the total price for this product
            $total_price += $product_quantity * $product_price;

            // Add the product details to the array
            $products_details[] = [
                'name' => $product_name,
                'price' => $product_price,
                'quantity' => $product_quantity,
                'image_url' => $product_image_url
            ];
        } else {
            echo "Product not found.";
            exit();
        }
    }

    // Shipping address from POST request
    $shipping_address = $address;

} else {
    echo "No products in cart.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - eSewa</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Payment Details</h2>
    
    <!-- Displaying Product Details -->
    <h4>Purchased Products:</h4>
    <div class="list-group">
        <?php foreach ($products_details as $product) { ?>
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <img src="<?php echo $product['image_url']; ?>" alt="Product Image" style="width: 50px; height: auto;">
                    <strong><?php echo $product['name']; ?></strong><br>
                    Quantity: <?php echo $product['quantity']; ?><br>
                    Price per item: <?php echo number_format($product['price'], 2); ?> NPR
                </div>
                <div>
                    <strong>Total: <?php echo number_format($product['quantity'] * $product['price'], 2); ?> NPR</strong>
                </div>
            </div>
        <?php } ?>
    </div>
    
    <hr>

    <!-- Shipping Address and Total Price -->
    <p><strong>Shipping Address:</strong> <?php echo $shipping_address; ?></p>
    <p><strong>Total Amount:</strong> <?php echo number_format($total_price, 2); ?> NPR</p>

    <!-- eSewa Payment Form -->
    <h4>Choose Payment Option:</h4>
    <form method="POST" action="esewa_payment_gateway.php">
        <input type="hidden" name="amount" value="<?php echo $total_price; ?>">
        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
        
        <!-- Display the payment options -->
        <button type="submit" class="btn btn-primary">Pay via eSewa</button>
    </form>
</div>

</body>
</html>
