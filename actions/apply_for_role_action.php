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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $role_id = isset($_POST['role_id']) ? intval($_POST['role_id']) : null;
    $reason = isset($_POST['reason']) ? trim($_POST['reason']) : null;

    // Validate input
    if (!$role_id || !$seller_id) {
        echo "Invalid input. Please ensure all required fields are filled.";
        exit();
    }

    // Submit application
    $isSubmitted = submitApplication_ctr($role_id, $seller_id, $reason);

    if ($isSubmitted) {
        // Redirect to project details with a success message
        header("Location: ../view/project_details.php?success=application_submitted");
        exit();
    } else {
        // Redirect to project details with an error message
        header("Location: ../view/project_details.php?error=application_failed");
        exit();
    }
} else {
    // Redirect if the file is accessed directly
    header("Location: ../view/seller_dashboard.php");
    exit();
}
