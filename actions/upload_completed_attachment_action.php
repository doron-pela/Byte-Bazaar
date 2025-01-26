<?php
session_start();
require_once("../controllers/task_controller.php");

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../view/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = (int)$_POST['task_id'];
    $task = fetchTaskById_ctr($task_id);

    // Check if the user is the delegate
    if ($task['delegate'] != $_SESSION['user']['seller_id']) {
        $_SESSION['error'] = "You do not have permission to upload for this task.";
        header("Location: ../view/task_details.php?task_id=$task_id");
        exit();
    }

    // Handle file upload
    if (isset($_FILES['completed_attachment']) && $_FILES['completed_attachment']['error'] == 0) {
        $upload_dir = "../uploads/completed_attachments/";
        $file_name = time() . "_" . basename($_FILES['completed_attachment']['name']);
        $file_path = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['completed_attachment']['tmp_name'], $file_path)) {
            // Save the file name in the database
            updateCompletedAttachment_ctr($task_id, $file_name);
            $_SESSION['success'] = "Attachment uploaded successfully.";
        } else {
            $_SESSION['error'] = "File upload failed.";
        }
    } else {
        $_SESSION['error'] = "No file selected or upload error.";
    }

    header("Location: ../view/task_details.php?task_id=$task_id");
    exit();
}
