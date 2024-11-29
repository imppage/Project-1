<?php
session_start();
include('../includes/db_connect.php');

// eSewa Details
$merchant_code = "YOUR_MERCHANT_CODE";  // Replace with your eSewa Merchant Code
$merchant_username = "YOUR_MERCHANT_USERNAME";  // Replace with your eSewa Merchant Username
$merchant_secret = "YOUR_MERCHANT_SECRET";  // Replace with your eSewa Merchant Secret Key

// Payment Details (from the POST request)
$order_id = $_POST['order_id'];
$amount = $_POST['amount'];

// Create the payment URL for eSewa
$eSewa_url = "https://esewa.com.np/epay/main";
$checksum = generateChecksum($merchant_code, $merchant_username, $amount, $order_id);

// Send payment details to eSewa
$payment_url = $eSewa_url . "?amount=" . urlencode($amount) . "&order_id=" . urlencode($order_id) . "&checksum=" . urlencode($checksum);

// Redirect user to eSewa for payment
header("Location: " . $payment_url);
exit();

function generateChecksum($merchant_code, $merchant_username, $amount, $order_id) {
    // You will need to implement this function according to eSewa's checksum generation method
    // For simplicity, we're assuming a placeholder function
    return md5($merchant_code . $merchant_username . $amount . $order_id . $merchant_secret);
}
?>
