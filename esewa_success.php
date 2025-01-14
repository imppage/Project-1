<?php
session_start();
include('../includes/db_connect.php');

// Check if the success parameter is set
if (isset($_GET['q']) && $_GET['q'] == 'su') {
    // Fetch required parameters from the URL
    $refId = $_GET['refId'];
    $order_id = $_GET['oid'];
    $total_price = $_GET['amt'];

    // eSewa transaction verification URL (Sandbox)
    $url = "https://uat.esewa.com.np/epay/transrec";

    // Data to be sent for verification
    $data = [
        'amt' => $total_price,
        'rid' => $refId,
        'pid' => $order_id,
        'scd' => 'EPAYTEST', // Sandbox merchant code
    ];

    // Initialize cURL request
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Properly format data
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL and close
    $response = curl_exec($ch);
    curl_close($ch);

    // Parse the XML response
    $xml = simplexml_load_string($response);
    if ($xml && isset($xml->response_code) && trim($xml->response_code) == 'Success') {
        // Payment successful, update the database
        // echo "something";
        $update_order_sql = "UPDATE orders SET payment_status = 'paid' WHERE id = {$_SESSION['order_id']}";
        if ($conn->query($update_order_sql)) {
            // Fetch order items to update product quantities
            $order_items_sql = "SELECT product_id, quantity FROM order_items WHERE order_id = {$_SESSION['order_id']}";
            $order_items_result = $conn->query($order_items_sql);

            if ($order_items_result && $order_items_result->num_rows > 0) {
                while ($item = $order_items_result->fetch_assoc()) {
                    $product_id = $item['product_id'];
                    $quantity_purchased = $item['quantity'];

                    // Reduce the quantity in the products table
                    $update_product_sql = "UPDATE products 
                                           SET stock_quantity = stock_quantity - $quantity_purchased 
                                           WHERE id = $product_id";

                    if (!$conn->query($update_product_sql)) {
                        echo "Error updating product quantity for Product ID $product_id: " . $conn->error;
                        exit();
                    }
                }

                // Clear the user's cart
                $clear_cart_sql = "DELETE FROM cart WHERE user_id = {$_SESSION['user_id']}";
                if ($conn->query($clear_cart_sql)) {
                    echo "<script> alert('Payment made successfully.'); </script>";
                    echo "<br><br><br><br><p style = 'text-align:center; font-size:25px;'>Order ID: $order_id </p><p style = 'text-align:center; font-size:25px;'>Thank you for the purchase {$_SESSION['user_name']}! </p><br><br>";
                } else {
                    echo "Error clearing cart: " . $conn->error;
                }
            } else {
                echo "No items found for this order.";
            }
        } else {
            echo "Database update failed: " . $conn->error;
        }
    } else {
        echo "Payment verification failed. Please try again.";
    }
} else {
    echo "Invalid request.";
}
echo "<a style = 'font-size:20px; width:90px; margin: 0px 40rem;' href='user_dashboard.php' class='btn btn-primary'>OK</a>";
$conn->close();
?>
