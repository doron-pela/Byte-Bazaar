<?php
require_once "../controllers/order_controller.php";
require_once "../controllers/payment_controller.php";
require_once "../controllers/commission_controller.php";

session_start();

// Check if customer is logged in
$customer_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;

if (!$customer_id) {
    header("Location: ../view/login.php");
    exit();
}

// Create a new order
$order_id = createOrderWithDetails($customer_id);

if ($order_id) {
    echo "Order created successfully! Your Order ID is $order_id.";

    // Fetch total price from session
    if (!isset($_SESSION["total_price"])) {
        echo "Total price is missing. Cannot process payment.";
        exit();
    }

    $total_price = $_SESSION["total_price"];
    $currency = "USD";

    // Process payment
    $paymentSuccess = processPayment($order_id, $total_price, $customer_id, $currency);

    if ($paymentSuccess) {
        // Retrieve the last inserted payment ID
        $payment_id = mysqli_insert_id((new db_connection())->db_conn());

        // Fetch the projects associated with the order
        $projectDetails = fetchProjectsByOrder($order_id); // Ensure you have this function in your controller

        // Process commission for each project in the order
        $commissionController = new commission_class();
        foreach ($projectDetails as $project) {
            $project_id = $project["project_id"];
            $project_price = $project["project_price"];

            // Pass the required arguments
            $commissionController->processPaymentCommission($payment_id, $project_id, $project_price);
        }

        
        header("Location: ../view/order_success.php?order_id=$order_id");
        
    } else {
        echo "Order created but payment entry failed.";
        exit();
    }
} else {
    echo "Failed to process your order.";
}
?>
