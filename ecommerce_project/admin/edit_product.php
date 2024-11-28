<?php
session_start();
include('../includes/db_connect.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$product_id = $_GET['id'];

// Fetch the product details from the database
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    
    // Use the existing image URL by default
    $image_url = $product['image_url'];  

    // Check if a new image has been uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_size = $_FILES['image']['size'];
        $file_type = $_FILES['image']['type'];

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
            } else {
                $error = "Failed to upload image.";
            }
        }
    }

    // Update the product details in the database
    $update_sql = "UPDATE products SET name = '$name', description = '$description', price = $price, stock_quantity = $stock_quantity, image_url = '$image_url' WHERE id = $product_id";
    
    if ($conn->query($update_sql) === TRUE) {
        header("Location: manage_products.php");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}

$conn->close();
?>

<div class="container mt-5">
    <h2>Edit Product</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Product Description</label>
            <textarea class="form-control" id="description" name="description" required><?php echo $product['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price (NPR)</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>" required>
        </div>
        <div class="form-group">
            <label for="stock_quantity">Stock Quantity</label>
            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="<?php echo $product['stock_quantity']; ?>" required>
        </div>
        <div class="form-group">
            <label for="image_url">Current Product Image</label>
            <div>
                <img src="<?php echo $product['image_url']; ?>" alt="Product Image" style="width: 100px; height: auto;">
            </div>
            <label for="image">Change Product Image: </label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-success">Update Product</button>
        <a href="dashboard.php"> <button type="submit" class="btn btn-success">Back</button></a>
    </form>
</div>
