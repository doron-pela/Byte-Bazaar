<?php
require_once "../controllers/order_controller.php";
require_once "../controllers/project_controller.php";
require_once "../controllers/commission_controller.php";
require_once "../controllers/payment_controller.php";

require_once "../controllers/user_controller.php";
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['customer_id'])) {
    error_log("Session 'user' or 'customer_id' is not set.");
    echo "Session issue. Please log in again.";
    exit();
} else {
    error_log("Session customer_id: " . $_SESSION['user']['customer_id']);
}


//$payment_reference = $_GET['reference'];
//$submit = $_POST['payment_reference'];
$customer = $_SESSION['user'];
$customer_id = $customer['customer_id'];

$_SESSION['user'] = fetchCustomerDetails($customer_id);
$customer_id = $customer['customer_id'];

$payment_currency = $_SESSION['currency'];
$payment_amount = $_SESSION['total_price'];


/*
$secret_key = "sk_test_9f0741282e3278aec2468a7d9320ff00a85423b7"; 
$url = "https://api.paystack.co/transaction/verify/" . $payment_reference;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $secret_key",
    "Cache-Control: no-cache"
]);

$response = curl_exec($ch);
curl_close($ch);

$response_data = json_decode($response, true);

if (!$response_data['status']) {
    echo "Payment verification failed: " . $response_data['message'];
    exit();
}

$payment_status = $response_data['data']['status'];
$payment_amount = $response_data['data']['amount'] / 100;
$payment_currency = $response_data['data']['currency'];

if ($payment_status !== "success") {
    echo "Payment failed. Please try again.";
    exit();
}
*/


$order = createOrder($customer_id);
$order_id = addDetailsToLastOrder($customer_id);
//$order_id = createOrderWithDetails($customer_id);

if (!$order_id) {
    echo "Failed to create order.";
    exit();
}


$payment = insertPayment($payment_amount, $customer_id, $payment_currency);

/*$payment_sql = "INSERT INTO payment (amt, customer_id, order_id, currency, payment_date) 
                VALUES ('$payment_amount', '$customer_id', '$order_id', '$payment_currency', NOW())";

$last_payment ="SELECT * FROM payment WHERE order_id = '$order_id' ORDER BY payment_date DESC LIMIT 1"; // Return the last payment

if (!$db->db_query($payment_sql)) {
    echo "Failed to record payment.";
    exit();
}*/

//$payment_id = getLastPaymentId($order_id);

$projects = fetchProjectsByOrder($order_id);


foreach ($projects as $project) {
    $project_id = $project["project_id"];
    $project_price = $project["project_price"];

    processPaymentCommission($project_id, $project_price);
}

header("Location: ../view/order_success.php?order_id=$order_id");
exit();
?>
