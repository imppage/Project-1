<?php
session_start();
include('includes/header.php');
include('includes/db_connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items for the logged-in user
$sql = "SELECT * FROM cart WHERE user_id = $user_id";
$result = $conn->query($sql);
$cart_items = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $product_id = $row['product_id'];
        $quantity = $row['quantity'];
        $product_query = "SELECT * FROM products WHERE id = $product_id";
        $product_result = $conn->query($product_query);
        $product = $product_result->fetch_assoc();

        $cart_items[] = [
            'product' => $product,
            'quantity' => $quantity
        ];
    }
}

$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['product']['price'] * $item['quantity'];
}

// Check if the user wants to place an order
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Insert order into the database
    $sql = "INSERT INTO orders (user_id, total_price) VALUES ($user_id, $total_price)";
    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;
        
        // Insert order details (cart items) into the order details table
        foreach ($cart_items as $item) {
            $product_id = $item['product']['id'];
            $quantity = $item['quantity'];
            $conn->query("INSERT INTO order_details (order_id, product_id, quantity) VALUES ($order_id, $product_id, $quantity)");
        }

        // Clear the cart
        $conn->query("DELETE FROM cart WHERE user_id = $user_id");

        // Redirect to the payment page (eSewa integration will happen here)
        header("Location: payment.php?order_id=$order_id");
        exit();
    }
}

$conn->close();
?>

<div class="container mt-5">
    <h2>Review Your Order</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($cart_items as $item) {
                $product = $item['product'];
                $quantity = $item['quantity'];
                $total = $product['price'] * $quantity;
                echo "
                    <tr>
                        <td>{$product['name']}</td>
                        <td>{$product['price']} NPR</td>
                        <td>{$quantity}</td>
                        <td>{$total} NPR</td>
                    </tr>
                ";
            }
            ?>
        </tbody>
    </table>
    <h3>Total Price: <?php echo $total_price; ?> NPR</h3>
    <form method="POST">
        <button type="submit" class="btn btn-primary">Place Order</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
