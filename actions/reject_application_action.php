<?php
session_start();
require_once("../controllers/application_controller.php");

// Ensure the user is logged in as a seller
if (!isset($_SESSION['user']) || $_SESSION['role'] != 2) {
    header("Location: ../view/login.php");
    exit();
}

$seller = $_SESSION['user'];
$seller_id = $seller['seller_id'];

// Check if application_id is provided
if (!isset($_POST['application_id'])) {
    echo "Application ID is missing.";
    header("Location: ../view/role_management.php");
    exit();
}

$application_id = $_POST['application_id'];

// Reject the application
if (rejectApplication_ctr($application_id)) {
    // Redirect back to role management page
    header("Location: ../view/role_management.php?success=application_rejected");
} else {
    echo "Failed to reject application. Please try again.";
}
?>
