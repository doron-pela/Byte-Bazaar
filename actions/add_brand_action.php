<?php

include("../controllers/brand_controller.php");


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $brand_name = $_POST["brand_name"];
    



    // Call the registerUser method in GeneralController
    $Brand = addBrand($brand_name);

    // Check the result and handle accordingly
    if ($Brand !== false) {
        // brand addition successful
        header("Location: ../view/brands.php");
    } else {
        // add brand failed
        $error_message = "Brand addition failed. ";
        echo $error_message . "Handle errors or redirect as needed.";
    }
}
