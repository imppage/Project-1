<?php
// Check if the product is being added to the cart
if (isset($_POST['add_to_cart'])) {
    $user_id = $_SESSION['user_id']; // Assuming the user is logged in
    $quantity = $_POST['quantity'];

    // Check if the product is already in the cart
    $sql = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Update the quantity if the product is already in the cart
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity;
        $update_sql = "UPDATE cart SET quantity = '$new_quantity' WHERE id = '{$row['id']}'";
        $conn->query($update_sql);
    } else {
        // Insert the product into the cart if it's not already there
        $insert_sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')";
        $conn->query($insert_sql);
    }

    // Redirect to cart page
    header("Location: cart.php");
    exit();
}
?>