<?php
require_once("../classes/order_class.php");

function createOrder($customer_id) {
    $order = new order_class();
    $order_date = date("Y-m-d H:i:s");
    $order_status = "Paid"; // Default order status
    return $order->createOrder($customer_id, $order_date, $order_status);
}

function addDetailsToLastOrder($customer_id) {
    $order = new order_class();

    // Fetch the last inserted order_id
    $order_id = $order->getLastOrderId($customer_id);

    if (!$order_id) {
        error_log("No recent order found for Customer ID: $customer_id.");
        return false;
    }

    // Fetch cart items
    $cart_items = $order->getCartItems($customer_id);

    if (!empty($cart_items)) {
        foreach ($cart_items as $item) {
            $product_id = $item['p_id'];
            $quantity = $item['qty'];

            if (!$order->addOrderDetails($order_id, $product_id, $quantity)) {
                error_log("Failed to add order details for Product ID: $product_id.");
                return false;
            }
        }
    } else {
        error_log("Cart is empty for Customer ID: $customer_id.");
        return false;
    }

    return true; // Details added successfully
}


function getLastOrderId($customer_id){
    $order = new order_class();
    return $order->getLastOrderId($customer_id);
}


function createOrderWithDetails($customer_id) {
    $order = new order_class();

    // Step 1: Create the order
    $order_date = date("Y-m-d H:i:s");
    $order_status = "Paid"; // Default order status
    $order->createOrder($customer_id, $order_date, $order_status);

    $order_id = "SELECT * FROM orders ORDER BY order_date DESC LIMIT 1";

    if (!$order_id) {
        error_log("Failed to create order for Customer ID: $customer_id.");
        //return false;
    }
    // Debugging
    error_log("Order created successfully. Order ID: $order_id");

    // Step 2: Add order details
    $cart_items = $order->getCartItems($customer_id);

    if (!empty($cart_items)) {
        foreach ($cart_items as $item) {
            $product_id = $item['p_id'];
            $quantity = $item['qty'];

            if (!$order->addOrderDetails($order_id, $product_id, $quantity)) {
                error_log("Failed to add order details for Product ID: $product_id.");
                return false;
            }
        }
    } else {
        error_log("Cart is empty for Customer ID: $customer_id.");
    }

    // Step 3: Clear the cart
    if (!$order->clearCart($customer_id)) {
        error_log("Failed to clear cart for Customer ID: $customer_id.");
    }

    return $order_id;
}

function fetchProjectsByOrder($order_id) {
    $order = new order_class();
    return $order->getOrderProjects($order_id);
}
?>
