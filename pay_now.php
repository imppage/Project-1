<?php
session_start();
include('../includes/db_connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: ../admin/login.php");
    exit();
}


if ((isset($_SESSION['order_id'])) && (!empty($_SESSION['order_id']))) {
    $order_id = intval($_SESSION['order_id']); // Sanitize input
} else {
    echo "Order ID not provided.";
    exit();
}



// $address = $_POST['address'];

// Fetch user_id and order details (for simplicity, let's assume order details are in session)
$sql = "SELECT * FROM order_items WHERE order_id = '$order_id'";
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
    // $shipping_address = $address;

} else {
    echo "No orders.";
    echo "<br> <br> <a href='cart.php' class='btn btn-primary'>Back </a>";

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
                    Total: <?php echo number_format($product['quantity'] * $product['price'], 2); ?> NPR
                </div>
            </div>
        <?php } ?>
    </div>
    
    <hr>

    <!-- Shipping Address and Total Price -->
    <p><strong>Shipping Address:</strong> <?php echo $_SESSION['shipping_address']; ?></p>
    <p><strong>Total Amount: <?php echo number_format($total_price, 2); ?> NPR</strong></p>

    <!-- eSewa Payment Form -->
    <h4>Choose Payment Option:</h4>
    

    <form method="POST" action="https://uat.esewa.com.np/epay/main">
        

        <input type="hidden" name="amt" value="<?php echo $total_price; ?>">
        <input type="hidden" name="pdc" value="0"> <!-- Product delivery charge -->
        <input type="hidden" name="psc" value="0"> <!-- Product service charge -->
        <input type="hidden" name="txAmt" value="0"> <!-- Tax amount -->
        <input type="hidden" name="tAmt" value="<?php echo $total_price; ?>"> <!-- Total amount -->
        <input type="hidden" name="scd" value="EPAYTEST"><!-- Replace with your eSewa merchant code -->
        <input type="hidden" name="oid" value="<?php echo $order_id; ?>">
        <?php $_SESSION['order_id'] = $order_id;?>
        <input type="hidden" name="pid" value="<?php echo 'TRANSACTION_' . uniqid(); ?>">
        <input type="hidden" name="su" value="http://localhost/ecommerce_project/public/esewa_success.php?q=su&&amt=$total_price">
        <input type="hidden" name="fu" value="http://localhost/ecommerce_project/public/esewa_failure.php?q=fu">
        
        <button type="submit" class="btn btn-success">Pay via eSewa</button>
        <a href="delete_order.php?order_id=<?php echo $order_id; ?>" class="btn btn-danger">Delete Order</a>
        </form>

</div>

</body>
</html>
