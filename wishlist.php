<?php
session_start();

include "../includes/header.php";
// If the wishlist is empty
if (!isset($_SESSION['wishlist']) || empty($_SESSION['wishlist'])) {
    echo "Your wishlist is empty.<br> <br>";
    echo "
    <tr> <td><a href='user_dashboard.php' class='btn btn-success'>Back </a></td></tr>";
    exit();
}

$wishlist = $_SESSION['wishlist'];
//$product_id = $_SESSION['product_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Wishlist</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Your Wishlist</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include ('../includes/db_connect.php');
                $user_id = $_SESSION['user_id'];

                if(!isset($user_id) || empty($user_id))
                {
                    echo "user is not logged in.";
                    exit();
                }

                foreach ($wishlist as $product_id) {
                    // Fetch specific product details from the products table
                    $sql = "SELECT * FROM products WHERE id = {$_SESSION['product_id']}";  // Now we're fetching product details by product_id
                    $result = $conn->query($sql);
                    
                    if ($result && $result->num_rows > 0) {
                        $product = $result->fetch_assoc();
                
                        // Output the product details
                        echo "
                        <tr>
                            <td>{$product['name']}</td>
                            <td>{$product['price']} NPR</td>
                            <td>
                                <a href='product_details.php?id={$product['id']}' class='btn btn-success'>Add to Cart</a>
                            </td>
                        </tr>";
                    }
                }
                
                    ?>
            </tbody>
        </table>
        <a href='user_dashboard.php' class='btn btn-success'>Back </a>

    </div>
</body>
</html>
