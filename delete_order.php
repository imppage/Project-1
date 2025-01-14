<?php
session_start();
include('../includes/db_connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: ../admin/login.php");
    exit();
}

// Ensure the order ID is passed via GET
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    echo "Invalid request.";
    exit();
}

$order_id = intval($_GET['order_id']); // Sanitize the input

// Fetch user details
$user_email = $_SESSION['user_email'];
$sql = "SELECT id FROM users WHERE email = '$user_email'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_id = $user['id'];
} else {
    echo "Error: User not found.";
    exit();
}

// Verify if the order belongs to the logged-in user
$order_check_sql = "SELECT * FROM orders WHERE id = '$order_id' AND user_id = '$user_id'";
$order_check_result = $conn->query($order_check_sql);

if ($order_check_result && $order_check_result->num_rows > 0) {
    // Delete order items first
    $delete_items_sql = "DELETE FROM order_items WHERE order_id = '$order_id'";
    if ($conn->query($delete_items_sql) === TRUE) {
        // Delete the order itself
        $delete_order_sql = "DELETE FROM orders WHERE id = '$order_id'";
        if ($conn->query($delete_order_sql) === TRUE) {
            echo "<script> alert('Order deleted successfully.'); window.location.href='order_history.php'; </script>";
            // Optionally, redirect to a page with a success message
            //header("Location: order_history.php?message=Order deleted successfully");
            exit();
        } else {
            echo "Error deleting order.";
        }
    } else {
        echo "Error deleting order items.";
    }
} else {
    echo "Order not found or you do not have permission to delete this order.";
    exit();
}

$conn->close();
?>
