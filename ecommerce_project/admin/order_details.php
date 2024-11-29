<?php
session_start();
include('../includes/db_connect.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$order_id = $_GET['id'];

// Fetch order details
$sql = "SELECT * FROM orders WHERE id = $order_id";
$order_result = $conn->query($sql);

// Check if the order query was successful
if ($order_result && $order_result->num_rows > 0) {
    $order = $order_result->fetch_assoc();
} else {
    echo "Order not found or error fetching order details.";
    exit();
}

// Fetch ordered products
$order_details_sql = "SELECT * FROM order_items WHERE order_id = $order_id";
$order_details_result = $conn->query($order_details_sql);

// Check if the order_details query was successful
if ($order_details_result === false) {
    echo "Error fetching order details: " . $conn->error;
    exit();
}


?>

<div class="container mt-5">
    <h2>Order Details</h2>
    <h4>Order ID: <?php echo $order['id']; ?></h4>
    <p>Total Price: <?php echo $order['total_price']; ?> NPR</p>
    <!-- <p>Status: <?php echo $order['status']; ?></p> -->
    <table class="table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Payment Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // if($order_details_result->num_rows > 0)
            // {
                while ($order_detail = $order_details_result->fetch_assoc()) {
                    $product_id = $order_detail['product_id'];
                    $product_sql = "SELECT * FROM products WHERE id = $product_id";
                    $product_result = $conn->query($product_sql);

                    // Check if the product query was successful
                    if ($product_result && $product_result->num_rows > 0) {
                        $product = $product_result->fetch_assoc();
                        echo "
                            <tr>
                                <td>{$product['name']}</td>
                                <td>{$order_detail['quantity']}</td>
                                <td>{$product['price']} NPR</td>
                                <td style='color:red;''>{$order['payment_status']}</td>
                            </tr>
                        ";
                    } else {
                        echo "<tr><td colspan='3'>Error fetching product details.</td></tr>";
                    }
                }
            // } else {
            //     echo "<tr><td colspan='3'>No products found for this order.</td></tr>";
            // }
            $conn->close();
            ?>
        </tbody>
    </table>
    <h4>Change Order Status:</h4>
    <form method="POST" action="update_order_status.php">
        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
        <select name="status" class="form-control">
            <option value="Pending" <?php echo $order['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
            <option value="Shipped" <?php echo $order['status'] == 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
            <option value="Completed" <?php echo $order['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
            <option value="Cancelled" <?php echo $order['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
        </select>
        <button type="submit" class="btn btn-primary mt-3">Update Status</button>
    </form>
</div>
