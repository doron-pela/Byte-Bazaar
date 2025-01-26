<?php
include("../controllers/category_controller.php");

// Check if category ID is set for deletion
if (isset($_POST['category_name'])) {
    $category_name = $_POST['category_name'];

    // Call the delete category method
    $result = deleteCategory($category_name);

    if ($result) {
        // Redirect to category view page after successful deletion
        header("Location: ../view/categories.php");
    } else {
        echo "Failed to delete category. Handle errors or redirect as needed.";
    }
}