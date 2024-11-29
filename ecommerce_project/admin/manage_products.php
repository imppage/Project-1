<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include('../includes/db_connect.php');
?>

<div class="container mt-5">
    <h2>Products Available</h2>
    <table class="table mt-3" border = "1" cellspacing = "0">
        <thead>
            <tr>
                <!-- <th>S.N.</th> -->
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $result = $conn->query("SELECT * FROM products");
                if ($result->num_rows > 0)
                {
                    while ($product = $result->fetch_assoc()) {
                        echo "
                            <tr>
                                <!---<td>{$product['id']} </td>-->
                                <td>{$product['name']}</td>
                                <td>NPR. {$product['price']}</td>
                                <td>{$product['stock_quantity']}</td>
                                <td>
                                    <a href='edit_product.php?id={$product['id']}' class='btn btn-warning'>Edit</a>
                                    <a href='delete_product.php?id={$product['id']}' class='btn btn-danger'>Delete</a>
                                </td>
                                </tr>
                        ";
                    }
                }
                else{
                    echo "No products added yet!";
                }
            ?>
        </tbody>
    </table>
    <br><br>
    <a href="add_product.php" class="btn btn-success"><button class= "btn btn-success">Add New Product</button></a>
    <a href="dashboard.php" class="btn btn-success"><button class= "btn btn-success">Back</button></a>
</div>

<?php
$conn->close();
?>
