<?php
// Start the session to access session variables
session_start();

// Include cart controller
include_once("../controllers/cart_controller.php");

// Check if user is logged in (i.e., check for the customer_id in session)
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    // Check if form data is set
    if (isset($_POST['project_id']) && !empty($_POST['project_id'])) {
        // Retrieve form data
        $product_id = $_POST['project_id'];
        $quantity = (int)1;

        // Validate quantity
        if ($quantity < 1) {
            echo "Error: Quantity must be at least 1.";
            exit();
        }

        // Retrieve customer_id from session
        $customer_id = $_SESSION['user_id'];

        // Retrieve IP address
        $ip_address = $_SERVER['REMOTE_ADDR'];

        // Call the controller function to add the product to the cart
        $add_cart_result = addToCart($product_id, $ip_address, $customer_id, $quantity);

        if ($add_cart_result) {
            // Redirect to the cart view page if successful
            header("Location: ../view/cart_view.php");
            exit();
        } else {
            // Log error and show an error message
            error_log("Failed to add product to cart. Product ID: $product_id, Customer ID: $customer_id");
            echo "Error: Could not add product to cart.";
        }
    } else {
        echo "Error: Missing product ID.";
    }
} else {
    // If customer is not logged in, handle it (redirect to login or show an error)
    echo "Error: Customer must be logged in to add items to the cart.";
    header("Location: ../view/login.php");
    exit();
}
