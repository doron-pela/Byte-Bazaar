<?php
include("../controllers/brand_controller.php");

// Check if brand ID is set for deletion
if (isset($_POST['brand_name'])) {
    $brand_name = $_POST['brand_name'];

    // Call the deleteBrand method
    $result = deleteBrand($brand_name);

    if ($result) {
        // Redirect to brand view page after successful deletion
        header("Location: ../view/brands.php");
    } else {
        echo "Failed to delete brand. Handle errors or redirect as needed.";
    }
}