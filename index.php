<?php include('../includes/header.php'); ?>

<div class="container mt-5">
    <h2 style = "text-align:center;">Welcome to TreasureGifts!</h2>
    <p style = "text-align:center; color:blue; font-size:2rem; ">Choose what you want to gift today.</p>

</div>

<!-- Search Form Positioned at the Top Right -->
<div class="container">
    <form action="index.php" method="GET" class="form-inline mb-4" style="position: absolute; top: 100px; right: 30px;">
        <div class="form-group">
            <input type="text" class="form-control" id="search" name="search" placeholder="Search for products..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        </div>
        <button type="submit" class="btn btn-primary ml-2">Search</button>
    </form>
</div>

<div class="container mt-5">
    <div class="row">
        <?php
        // Fetch products from the database
        include('../includes/db_connect.php');

        // Initialize the SQL query
        $sql = "SELECT * FROM products";

        // Check if search term is provided
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search_term = $_GET['search'];
            $sql .= " WHERE name LIKE '%" . $conn->real_escape_string($search_term) . "%' OR description LIKE '%" . $conn->real_escape_string($search_term) . "%'";
        }

        // Limit to 6 products (you can modify this number)
        $sql .= " LIMIT 6";

        // Execute the query
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($product = $result->fetch_assoc()) {
                echo '
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="' . $product['image_url'] . '" class="card-img-top" alt="' . $product['name'] . '" style="height:50vh; object-fit:cover;">
                            <div class="card-body">
                                <h5 class="card-title">' . $product['name'] . '</h5>
                                <p class="card-text">Price: ' . $product['price'] . ' NPR</p>
                                <a href="product_details.php?id=' . $product['id'] . '" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>';
            }
        } else {
            echo '<p>No products found matching your search!</p>';
        }

        $conn->close();
        ?>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
