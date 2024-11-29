<?php
session_start();
include('../includes/db_connect.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$product_id = $_GET['id'];

// Delete the product from the database
$sql = "DELETE FROM products WHERE id = $product_id";
if ($conn->query($sql) === TRUE) {
    header("Location: manage_products.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
