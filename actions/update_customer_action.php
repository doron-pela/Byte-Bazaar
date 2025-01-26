<?php
session_start();
require_once("../controllers/user_controller.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_SESSION['user']['customer_id'];
    $customer_name = $_POST['customer_name'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $contact_no = $_POST['contact_no'];

    if (updateCustomerProfile_ctr($customer_id, $customer_name, $email, $country, $city, $contact_no)) {
        header("Location: ../view/customer_profile.php?success=Profile updated successfully.");
    } else {
        header("Location: ../view/customer_profile.php?error=Unable to update profile. Please try again.");
    }
    exit();
}
?>
