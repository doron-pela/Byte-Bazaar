<?php

session_start();
require_once("../controllers/project_controller.php");

// Ensure the user is logged in
if (!isset($_SESSION['user']) || $_SESSION['role'] != 2) {
    $_SESSION['error'] = "Unauthorized access.";
    header("Location: ../view/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../view/my_projects.php");
    exit();
}

$seller_id = $_SESSION['user']['seller_id'];
//$project_id = $_POST['project_id'];
$project_id = $_SESSION['project_id'];

// Fetch project details
$project = fetchProjectById($project_id);
if (!$project || $project['seller_id'] != $seller_id) {
    $_SESSION['error'] = "You are not authorized to publish this project.";
    header("Location: ../view/my_projects.php");
    exit();
}

// Prepare data
$project_title = $_POST['project_title'];
$project_desc = $_POST['project_desc'];
$project_price = $_POST['project_price'];
$project_keywords = $_POST['project_keywords'];
$project_category = $_POST['project_category'];
$link = $_POST['link'] ?? null;

// Upload directory
$uploads_dir = "../uploads/projects";
if (!is_dir($uploads_dir) || !is_writable($uploads_dir)) {
    $_SESSION['error'] = "Upload directory is not writable.";
    header("Location: ../view/publish_project.php?project_id=$project_id");
    exit();
}

// Initialize files
$project_image = $project['project_image'];
$file = $project['file'];
$sc1 = $project['sc1'];
$sc2 = $project['sc2'];
$sc3 = $project['sc3'];

// Handle file uploads
function uploadFile($field_name, $uploads_dir, $prefix = "")
{
    if (isset($_FILES[$field_name]) && $_FILES[$field_name]['error'] == 0) {
        $filename = time() . "_" . $prefix . basename($_FILES[$field_name]['name']);
        $file_path = "$uploads_dir/$filename";
        if (move_uploaded_file($_FILES[$field_name]['tmp_name'], $file_path)) {
            return $filename;
        }
    }
    return null;
}

$project_image = uploadFile('project_image', $uploads_dir) ?? $project_image;
$file = uploadFile('file', $uploads_dir) ?? $file;
$sc1 = uploadFile('sc1', $uploads_dir, "sc1_") ?? $sc1;
$sc2 = uploadFile('sc2', $uploads_dir, "sc2_") ?? $sc2;
$sc3 = uploadFile('sc3', $uploads_dir, "sc3_") ?? $sc3;

// Update project
$published = 1; // Set published status
$success = updateProjectDetails_ctr(
    $project_id,
    $project_title,
    $project_desc,
    $project_price,
    $project_keywords,
    $project_category,
    $link,
    $project_image,
    $file,
    $sc1,
    $sc2,
    $sc3,
    $published
);

if ($success) {
    $_SESSION['success'] = "Your project has been successfully published.";
    header("Location: ../view/publish_project.php");
} else {
    $_SESSION['error'] = "Failed to publish the project.";
    echo $_SESSION['error'];
    header("Location: ../view/publish_project.php?project_id=$project_id");
}
