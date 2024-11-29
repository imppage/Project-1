<?php include('../includes/header.php'); ?>

<div class="container mt-5">
    <h2>Welcome to Our E-Commerce Store!</h2>
    <div class="row">
        <?php
        // Fetch products from the database
        include('../includes/db_connect.php');
        $result = $conn->query("SELECT * FROM products LIMIT 6");

        if ($result->num_rows > 0) {
            while($product = $result->fetch_assoc()) {
                echo '
                    <div class="col-md-4">
                        <div class="card">
                            <img src="' . $product['image_url'] . '" class="card-img-top" alt="' . $product['name'] . '">
                            <div class="card-body">
                                <h5 class="card-title">' . $product['name'] . '</h5>
                                <p class="card-text">Price: ' . $product['price'] . ' NPR</p>
                                <a href="product_details.php?id=' . $product['id'] . '" class="btn btn-primary">View Product</a>
                            </div>
                        </div>
                    </div>';
            }
        } else {
            echo "No products found!";
        }

        $conn->close();
        ?>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
