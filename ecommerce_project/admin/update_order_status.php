<?php
session_start();
include('../includes/db_connect.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // Update the order status
    $update_sql = "UPDATE orders SET status = '$status' WHERE id = $order_id";
    if ($conn->query($update_sql) === TRUE) {
        // If the update was successful, redirect with a success message
        echo "<script>
                alert('Order status updated successfully.');
                window.location.href = 'manage_orders.php'; // Redirect to the manage orders page
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
