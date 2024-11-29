<?php
session_start();
include('../includes/db_connect.php');

// Fetch payment response from eSewa (e.g., amount, status)
$order_id = $_GET['order_id'];
$amount = $_GET['amount'];
$status = $_GET['status'];  // Check if the payment is successful

// Verify payment status and update the order in the database
if ($status == 'Success') {
    // Update order status to 'Paid'
    $sql = "UPDATE orders SET status = 'Paid' WHERE id = '$order_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Payment successful! Order has been confirmed.";
    } else {
        echo "Error: Could not update order status.";
    }
} else {
    echo "Payment failed. Please try again.";
}

$conn->close();
?>
