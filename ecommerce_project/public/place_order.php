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
} else {
    echo "Error: User not found.";
    exit();
}

// Fetch the shipping address from the form
$shipping_address = $_POST['address'];

// Fetch cart items from the database
$sql = "SELECT cart.product_id, cart.quantity, products.name, products.price FROM cart
        JOIN products ON cart.product_id = products.id
        WHERE cart.user_id = '$user_id'";
$result = $conn->query($sql);

$total_price = 0;
$order_items = [];

if ($result && $result->num_rows > 0) {
    // Process the cart items and calculate the total price
    while ($row = $result->fetch_assoc()) {
        $total_price += $row['price'] * $row['quantity'];
        $order_items[] = [
            'product_id' => $row['product_id'],
            'quantity' => $row['quantity'],
            'name' => $row['name'],
            'price' => $row['price']
        ];
    }

    // Insert order into the orders table
    $order_sql = "INSERT INTO orders (user_id, total_price, shipping_address, status) 
                  VALUES ('$user_id', '$total_price', '$shipping_address', 'Pending')";

    // Check if the order insertion was successful
    if ($conn->query($order_sql) === TRUE) {
        // Get the last inserted order_id
        $order_id = $conn->insert_id;
        $_SESSION['order_id'] = $order_id;

        // Insert order items into the order_items table
        foreach ($order_items as $item) {
            $order_item_sql = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                               VALUES ('$order_id', '{$item['product_id']}', '{$item['quantity']}', '{$item['price']}')";
            $conn->query($order_item_sql);
        }

        // Clear the cart
        $conn->query("DELETE FROM cart WHERE user_id = '$user_id'");

        // Redirect to order confirmation page
        header("Location: pay_now.php");
        exit();
    } else {
        echo "Error placing order.";
        exit();
    } // <-- Closing the if statement for the order insertion
} else {
    echo "No items in cart.";
    exit();
}

$conn->close();
?>
