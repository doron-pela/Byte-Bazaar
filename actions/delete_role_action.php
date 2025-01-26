<?php
session_start();
require_once("../controllers/role_controller.php");
require_once("../controllers/project_controller.php");

// Ensure the request is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../view/my_projects.php");
    exit();
}

// Ensure the user is logged in
if (!isset($_SESSION['user']) || $_SESSION['role'] != 2) {
    $_SESSION['error'] = "You must be logged in as a seller to perform this action.";
    header("Location: ../view/login.php");
    exit();
}

// Retrieve the user and role data
$user = $_SESSION['user'];
$seller_id = $user['seller_id'];
$role_id = isset($_POST['role_id']) ? (int)$_POST['role_id'] : 0;

// Validate role_id
if ($role_id <= 0) {
    $_SESSION['error'] = "Invalid role ID.";
    header("Location: ../view/my_projects.php");
    exit();
}

// Fetch the project ID associated with the role
$role = fetchRoleById_ctr($role_id);
if (!$role) {
    $_SESSION['error'] = "Role not found.";
    header("Location: ../view/my_projects.php");
    exit();
}

// Check if the current user is the creator of the project
$project_id = $role['project_id'];
$creator = fetchProjectCreator($project_id);

if ($creator['seller_id'] !== $seller_id) {
    $_SESSION['error'] = "You are not authorized to delete this role.";
    header("Location: ../view/role_management.php?project_id=$project_id");
    exit();
}

// Prevent deletion of the "Creator" role
if ($role['role_name'] === 'Creator') {
    $_SESSION['error'] = "The Creator role cannot be deleted.";
    header("Location: ../view/role_management.php?project_id=$project_id");
    exit();
}

// Delete the role
if (deleteRole_ctr($role_id)) {
    $_SESSION['success'] = "Role deleted successfully.";
} else {
    $_SESSION['error'] = "Failed to delete role. Please try again.";
}

// Redirect back to the role management page
header("Location: ../view/role_management.php?project_id=$project_id");
exit();
?>
