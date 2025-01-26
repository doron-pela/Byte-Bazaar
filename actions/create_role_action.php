<?php
session_start();
require_once("../controllers/role_controller.php");

// Ensure the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure user is logged in
    if (!isset($_SESSION['user']) || $_SESSION['role'] != 2) {
        header("Location: ../pages/login.php");
        exit();
    }

    // Fetch and sanitize inputs
    $project_id = (int) $_POST['project_id'];
    $role_name = htmlspecialchars(trim($_POST['role_name']));
    $role_description = htmlspecialchars(trim($_POST['role_description']));
    $takings = isset($_POST['takings']) ? (int) $_POST['takings'] : null;

    // Validate inputs
    if (empty($role_name) || empty($role_description)) {
        $_SESSION['error'] = "Role name and description cannot be empty.";
        header("Location: ../view/role_management.php?project_id=$project_id");
        exit();
    }

    if ($takings === null || $takings < 0 || $takings > 100) {
        $_SESSION['error'] = "Takings must be a number between 0 and 100.";
        header("Location: ../view/role_management.php?project_id=$project_id");
        exit();
    }

    // Call the controller to create the role
    if (createRole_ctr($project_id, $role_name, $role_description, $takings)) {
        $_SESSION['success'] = "Role created successfully.";
        header("Location: ../view/role_management.php?project_id=$project_id");
        exit();
    } else {
        // Log the error for debugging
        error_log("Failed to create role for project_id: $project_id, role_name: $role_name");
        $_SESSION['error'] = "Failed to create role. Please try again.";
        header("Location: ../view/role_management.php?project_id=$project_id");
        exit();
    }
} else {
    // Redirect if accessed via a method other than POST
    header("Location: ../view/role_management.php");
    exit();
}
?>
