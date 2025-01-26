<?php
session_start();
require_once("../controllers/project_controller.php");

// Ensure the user is logged in as a seller
if (!isset($_SESSION['user']) || $_SESSION['role'] != 2) {
    header("Location: ../view/login.php");
    exit();
}

$seller = $_SESSION['user'];
$seller_id = $seller['seller_id'];

// Retrieve form inputs
$project_title = $_POST['project_title'] ?? '';
$project_description = $_POST['project_description'] ?? '';
$project_price = $_POST['project_price'] ?? 0;
$project_keywords = $_POST['project_keywords'] ?? '';
$project_category = $_POST['project_category'] ?? 0;
$creator_takings = $_POST['creator_takings'] ?? 0;
$roles = $_POST['roles'] ?? [];

// Add the project and creator role
$project_id = addProject_ctr(
    $project_title,
    $project_description,
    $project_price,
    $project_keywords,
    $project_category,
    $seller_id,
    $creator_takings
);

if (!$project_id) {
    $_SESSION['error'] = "Failed to create project.";
    header("Location: ../view/create_project.php");
    exit();
}

// Add additional roles if specified
foreach ($roles as $role) {
    $role_name = $role['role_name'] ?? '';
    $role_description = $role['role_description'] ?? '';
    $role_takings = $role['role_takings'] ?? 0;
    $role_availability = $role['role_availability'] ?? 1;

    if (!empty($role_name)) {
        createRole_ctr($project_id, $role_name, $role_description, $role_takings);
    }
}

$_SESSION['success'] = "Project created successfully.";
header("Location: ../view/seller_dashboard.php");
exit();
?>
