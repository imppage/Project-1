<?php
session_start();
include('../includes/db_connect.php');

if (isset($_GET['q']) && $_GET['q'] == 'fu') {
    $sql = "DELETE FROM orders WHERE id = {$_SESSION['order_id']}";
    if($conn->query($sql))
    {

        echo "Payment failed. Please try again.";
    }else{
        echo "Database update failed.";
    }
    
    echo "<br><br><a href='user_dashboard.php' class='btn btn-primary'>Back To Home page</a>";
}
?>