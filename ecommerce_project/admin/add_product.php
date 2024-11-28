<?php
session_start();
include('../includes/db_connect.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission for adding a new product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];

    // Handle the image upload
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $file_name = $_FILES['product_image']['name'];
        $file_tmp = $_FILES['product_image']['tmp_name'];
        $file_size = $_FILES['product_image']['size'];
        $file_type = $_FILES['product_image']['type'];

        // Define allowed file types and max file size
        $allowed_extensions = ['image/jpeg', 'image/png', 'image/jpg'];
        $max_size = 5 * 1024 * 1024; // Max size: 5MB

        // Check file type
        if (!in_array($file_type, $allowed_extensions)) {
            $error = "Only JPEG, JPG, and PNG files are allowed.";
        }
        // Check file size
        elseif ($file_size > $max_size) {
            $error = "File size exceeds the 5MB limit.";
        } else {
            // Generate a unique file name to avoid overwriting
            $unique_file_name = time() . '_' . basename($file_name);

            // Define upload directory
            $upload_dir = '../uploads/products/';

            // Create the upload directory if it doesn't exist
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Move the uploaded file to the server
            if (move_uploaded_file($file_tmp, $upload_dir . $unique_file_name)) {
                // Image upload successful, store the file path in the database
                $image_url = $upload_dir . $unique_file_name;

                // Insert the new product into the database
                $insert_sql = "INSERT INTO products (name, description, price, image_url, stock_quantity) 
                               VALUES ('$name', '$description', $price, '$image_url', $stock_quantity)";

                if ($conn->query($insert_sql) === TRUE) {
                    header("Location: manage_products.php");
                    exit();
                } else {
                    $error = "Error: " . $conn->error;
                }
            } else {
                $error = "Failed to upload image.";
            }
        }
    } else {
        $error = "Please select an image to upload.";
    }
}

$conn->close();
?>

<div class="container mt-5">
    <h2>Add New Product</h2>

    <!-- Display error message if any -->
    <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Product Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price (NPR)</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <div class="form-group">
            <label for="stock_quantity">Stock Quantity</label>
            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" required>
        </div>
        <div class="form-group">
            <label for="product_image">Product Image</label>
            <input type="file" class="form-control" id="product_image" name="product_image" required>
        </div>
        <button type="submit" class="btn btn-success">Add Product</button>
        <a href="manage_products.php" class = "btn btn-success">Back</a>
    </form>
</div>
