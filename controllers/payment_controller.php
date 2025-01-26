<?php
require_once("../classes/payment.php");

function insertPayment($amount, $customer_id,  $currency) {
    $payment = new Payment();
    $order_id = $payment->getLastOrderId($customer_id);
    return $payment->insertPayment($amount, $customer_id, $order_id, $currency);
}

function getLastPaymentId($order_id) {
    $payment = new Payment();
    return $payment->getLastPaymentId($order_id);
}

/*function processPayment($order_id, $amount, $customer_id, $currency)
{
    $payment = new Payment();
    return $payment->processPayment($order_id, $amount, $customer_id, $currency);
}*/

?>
