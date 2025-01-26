<?php
session_start();
require_once("../controllers/task_controller.php");

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../view/login.php");
    exit();
}

$seller_id = $_SESSION['user']['seller_id'];
$role = $_SESSION['role'];

// Fetch task details
$task_id = (int)$_POST['task_id'];
$task = fetchTaskById_ctr($task_id);

if (!$task) {
    $_SESSION['error'] = "Task not found.";
    header("Location: ../view/task_management.php");
    exit();
}

// Determine user permissions
$is_delegate = ($task['delegate'] == $seller_id);
$is_creator_or_admin = ($task['pm_id'] == $seller_id || $role == 3); // Creator or project admin

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($is_delegate) {
        // Delegate can only upload completed_attachment
        if (isset($_FILES['completed_attachment']) && $_FILES['completed_attachment']['error'] == 0) {
            $upload_dir = "../uploads/completed_attachments/";
            $file_name = time() . "_" . basename($_FILES['completed_attachment']['name']);
            $file_path = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['completed_attachment']['tmp_name'], $file_path)) {
                // Save completed attachment
                updateTaskDetails_ctr($task_id, $task['task_name'], $task['task_description'], $task['delegate'], $task['status'], $task['deadline'], $file_name);
            } else {
                $_SESSION['error'] = "File upload failed.";
                header("Location: ../view/task_details.php?task_id=$task_id");
                exit();
            }
        }
    }

    if ($is_creator_or_admin) {
        // Task creators or admins can update all task details
        $task_name = $_POST['task_name'];
        $task_description = $_POST['task_description'];
        $delegate_to = $_POST['delegate_to'];
        $is_complete = isset($_POST['is_complete']) ? 1 : 0;
        $deadline = $_POST['deadline'];

        // Handle new attachment upload
        if (isset($_FILES['task_attachment']) && $_FILES['task_attachment']['error'] == 0) {
            $upload_dir = "../uploads/task_attachments/";
            $file_name = time() . "_" . basename($_FILES['task_attachment']['name']);
            $file_path = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['task_attachment']['tmp_name'], $file_path)) {
                updateTaskDetails_ctr($task_id, $task_name, $task_description, $delegate_to, $is_complete, $deadline, $file_name);
            }
        } else {
            // Update task details without new attachment
            updateTaskDetails_ctr($task_id, $task_name, $task_description, $delegate_to, $is_complete, $deadline);
        }
    }

    header("Location: ../view/task_details.php?task_id=$task_id");
    exit();
}
?>
