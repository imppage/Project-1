<?php
session_start();
include('../includes/db_connect.php');

// Check if the product_id is set in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $_SESSION['product_id'] = $product_id;

    // Retrieve the product details from the database
    $sql = "SELECT * FROM products WHERE id = '$product_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Product exists, fetch the product details
        $product = $result->fetch_assoc();
    } else {
        // Product not found, redirect to the homepage or show an error
        header("Location: index.php");
        exit();
    }
} else {
    // No product ID provided, redirect to the homepage
    header("Location: index.php");
    exit();
}

// Check if the product is being added to the cart
if (isset($_POST['add_to_cart'])) {
    $user_id = $_SESSION['user_id']; // Assuming the user is logged in
    $quantity = $_POST['quantity'];

     // Initialize the cart session if it's not set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the product is already in the cart
    $sql = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = {$_SESSION['product_id']}";
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

// Check if the product is being added to the wishlist
if (isset($_POST['add_to_wishlist'])) {
    // Check if the wishlist is already in the session and ensure it is an array
$wishlist = isset($_SESSION['wishlist']) && is_array($_SESSION['wishlist']) ? $_SESSION['wishlist'] : [];

// Assuming the user is logged in
$user_id = $_SESSION['user_id']; // Assuming the user is logged in
$quantity = $_POST['quantity'];

// Check if the product is already in the wishlist
$sql = "SELECT * FROM wishlist WHERE user_id = '$user_id' AND product_id = {$_SESSION['product_id']}";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Product already exists in the wishlist
    echo "Product already exists in your wishlist!";
} else {
    // Add product to the wishlist
    $wishlist[$product_id] = [
        'product_id' => $product['id'],
        'name' => $product['name'],
        'price' => $product['price'],
        'image_url' => $product['image_url']
    ];

    // Save the updated wishlist to the session
    $_SESSION['wishlist'] = $wishlist;

    // Insert the product into the database as well
    $insert_sql = "INSERT INTO wishlist (user_id, product_id, product_name, product_price) VALUES ('$user_id', '{$_SESSION['product_id']}','{$product['name']}', '{$product['price']}')";
    $conn->query($insert_sql);
}

// Redirect to the wishlist page or show success message
header("Location: wishlist.php");
exit();

}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - <?php echo $product['name']; ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Include Header -->
    <?php include('../includes/header.php'); ?>

    <div class="container mt-5" style="height:60vh;">
        <div class="row">
            <div class="col-md-6">
                <!-- Product Image -->
                <img src="<?php echo $product['image_url']; ?>" alt="Product Image" class="img-fluid" style="height: 50vh;"/>
            </div>
            <div class="col-md-6">
                <!-- Product Details -->
                <h2><?php echo $product['name']; ?></h2>
                <p><strong>Description:</strong> <?php echo nl2br($product['description']); ?></p>
                <p><strong>Price:</strong> NPR <?php echo number_format($product['price'], 2); ?></p>
                <p><strong>Stock:</strong> <?php echo $product['stock_quantity']; ?> items available</p>

                <!-- Add to Cart Form -->
                <form method="POST">
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="<?php echo $product['stock_quantity']; ?>" required>
                    </div>
                    <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                    <button type="submit" name = "go_back" class="btn btn-primary"><a href="user_dashboard.php" style = "color:white; text-decoration:none;"> Back </a></button>
                    <!-- <button type="submit" name="add_to_wishlist" class="btn btn-danger">Add to Wishlist</button> -->
                </form>
            </div>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include('../includes/footer.php'); ?>

    <!-- Optional Bootstrap JS for interactive elements -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
