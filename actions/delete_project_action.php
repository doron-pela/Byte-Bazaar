<?php
include("../controllers/project_controller.php");

// Check if project ID is set for deletion
if (isset($_POST['project_id'])) {
    $project_name = $_POST['project_id'];

    // Call the deleteproject method
    $result = deleteProject($project_name);

    if ($result) {
        // Redirect to project view page after successful deletion
        header("Location: ../view/seller_dashboard.php");
    } else {
        echo "Failed to delete project. Handle errors or redirect as needed.";
    }
}