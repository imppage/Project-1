<?php
session_start();
include('../includes/db_connect.php');

// Get the order_id from the query string
$order_id = $_GET['order_id'];

// Fetch order details from the orders table
$order_sql = "SELECT * FROM orders WHERE id = $order_id";
$order_result = $conn->query($order_sql);

// Check if the order exists
if ($order_result && $order_result->num_rows > 0) {
    $order = $order_result->fetch_assoc();
} else {
    echo "Order not found.";
    exit();
}

// Fetch order items from the order_items table
$order_details_sql = "SELECT * FROM order_items WHERE order_id = $order_id";
$order_details_result = $conn->query($order_details_sql);

// Check if the order details query executed successfully
if (!$order_details_result) {
    echo "Error fetching order details: " . $conn->error;
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Order Confirmation</h2>
        <p>Thank you for your order! Your order ID is <?php echo $order['id']; ?>.</p>
        <h4>Shipping Address: </h4>
        <p><?php echo $order['shipping_address']; ?></p>
        
        <h4>Order Details: </h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                while ($order_detail = $order_details_result->fetch_assoc()) {
                    $product_id = $order_detail['product_id'];
                    $product_sql = "SELECT * FROM products WHERE id = $product_id";
                    $product_result = $conn->query($product_sql);

                    // Check if the product query was successful
                    if ($product_result && $product_result->num_rows > 0) {
                        $product = $product_result->fetch_assoc();
                        $total_price = $product['price'] * $order_detail['quantity'];
                        $total += $total_price;

                        echo "
                        <tr>
                            <td>{$product['name']}</td>
                            <td>{$order_detail['quantity']}</td>
                            <td>{$product['price']} NPR</td>
                            <td>{$total_price} NPR</td>
                        </tr>";
                    } else {
                        echo "<tr><td colspan='4'>Product not found for ID: $product_id</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <h4>Total: <?php echo $total; ?> NPR</h4>
    </div>

    

    <?php
    // Close the database connection after all queries are done
    $conn->close();
    ?>
</body>
</html>
