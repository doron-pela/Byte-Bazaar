<?php
// Include the cart controller to access the cart functionalities
include_once("../controllers/cart_controller.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the posted form data
    $product_id = $_POST['product_id'];
    $ip_address = $_SERVER['REMOTE_ADDR'];  // Retrieve user's IP address
    $customer_id = isset($_POST['customer_id']) ? $_POST['customer_id'] : null;  // Optional for logged in users

    // Call the controller function to remove the product from the cart
    $result = removeFromCart($product_id, $customer_id, $ip_address);

    if ($result) {
        // Redirect back to the cart or display success message
        header("Location: ../view/cart_view.php");
    } else {
        // Redirect with an error message
        header("Location: ../view/cart_view.php");
    }
}