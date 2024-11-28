<?php
session_start();
include('../includes/db_connect.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM orders ORDER BY order_date DESC";
$result = $conn->query($sql);

$conn->close();
?>

<div class="container mt-5">
    <h2>Manage Orders</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Payment Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($order = $result->fetch_assoc()) {
                echo "
                    <tr>
                        <td>{$order['id']}</td>
                        <td>{$order['user_id']}</td>
                        <td>{$order['total_price']} NPR</td>
                        <td>{$order['status']}</td>
                        <td>{$order['payment_status']}</td>
                        <td>
                            <a href='order_details.php?id={$order['id']}' class='btn btn-info'>View Details</a>
                        </td>
                    </tr>
                ";
            }
            ?>
        </tbody>
    </table>
    <a href="dashboard.php"><button class="btn btn-success">Back</button></a>
</div>
