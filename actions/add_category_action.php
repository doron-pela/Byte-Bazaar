<?php

include("../controllers/category_controller.php");


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $category_name = $_POST["category_name"];
    



    // Call the registerUser method in GeneralController
    $cat = addCategory($category_name);

    // Check the result and handle accordingly
    if ($cat !== false) {
        // brand addition successful
        header("Location: ../view/categories.php");
    } else {
        // add brand failed
        $error_message = "category addition failed. ";
        echo $error_message . "Handle errors or redirect as needed.";
    }
}
