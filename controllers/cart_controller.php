<?php
// Include the cart class
require_once("../classes/cart_class.php");


function addToCart($product_id, $ip_address, $customer_id, $quantity) {
    $cart = new cart_class();
    return $cart->addToCart($product_id, $ip_address, $customer_id, $quantity);
}


function removeFromCart($product_id, $customer_id, $ip_address) {
    $cart = new cart_class();
    return $cart->removeFromCart($product_id, $customer_id, $ip_address);
}


function viewCart(){
    $cart = new cart_class();
    return $cart->viewCart();
}


function updateCartQuantity($p_id, $ip_add, $c_id, $qty) {
    $cart = new cart_class();
    return $cart->updateCartQuantity($p_id, $ip_add, $c_id, $qty);
}
