<?php
session_start();
require_once("../controllers/project_controller.php");

// Ensure the user is logged in as a seller
if (!isset($_SESSION['user']) || $_SESSION['role'] != 2) {
    header("Location: ../view/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['membership_id'])) {
    $membership_id = $_POST['membership_id'];

    // Call controller function to remove the member
    if (removeProjectMember_ctr($membership_id)) {
        header("Location: ../view/role_management.php?project_id=" . $_SESSION['current_project_id'] . "&success=member_removed");
        exit();
    } else {
        header("Location: ../view/role_management.php?project_id=" . $_SESSION['current_project_id'] . "&error=failed_to_remove_member");
        exit();
    }
} else {
    header("Location: ../view/role_management.php");
    exit();
}
