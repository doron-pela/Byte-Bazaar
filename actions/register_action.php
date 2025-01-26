<?php

include("../controllers/user_controller.php");


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $customer_name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $country = $_POST["country"];
    $city = $_POST["city"];
    $contact_no = $_POST["contact_no"];
    $user_role = 1;






    // Call the registerUser method in GeneralController
    $registrationResult = registerCustomer_ctr($customer_name, $email, $password, $country, $city, $contact_no, $user_role);

    // Check the result and handle accordingly
    if ($registrationResult !== false) {
        // Registration successful
        header("Location: ../view/login.php");
    } else {
        // Registration failed
        $error_message = "Registration failed. ";
        echo $error_message . "Handle errors or redirect as needed.";
    }
}
