<?php
ob_start();
session_start();
require_once("../controllers/task_controller.php");

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data and sanitize inputs
    $pm_id = isset($_POST['pm_id']) ? (int)$_POST['pm_id'] : 0; // Project member ID
    if ($pm_id === 0) {
        $_SESSION['error'] = "Project membership ID is missing.";
        header("Location: ../view/add_task.php?project_id=" . ($_POST['project_id'] ?? 0));
        exit();
    }

    $delegate = isset($_POST['delegate']) ? (int)$_POST['delegate'] : null;
    $task_name = isset($_POST['task_name']) ? trim(htmlspecialchars($_POST['task_name'])) : '';
    $task_description = isset($_POST['task_description']) ? trim(htmlspecialchars($_POST['task_description'])) : '';
    $predecessor_task = isset($_POST['predecessor_task']) && $_POST['predecessor_task'] !== '' ? (int)$_POST['predecessor_task'] : null;
    $successor_task = isset($_POST['successor_task']) && $_POST['successor_task'] !== '' ? (int)$_POST['successor_task'] : null;
    $deadline = isset($_POST['deadline']) ? trim(htmlspecialchars($_POST['deadline'])) : '';
    $task_attachment = '';

    // Validate required inputs
    if (empty($task_name) || empty($task_description) || empty($deadline)) {
        $_SESSION['error'] = "Task name, description, and deadline are required.";
        header("Location: ../view/add_task.php?project_id=" . ($_POST['project_id'] ?? 0));
        exit();
    }

    // Handle file upload for task_attachment
    if (isset($_FILES['task_attachment']) && $_FILES['task_attachment']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "../uploads/task_attachments/";
        $fileName = time() . "_" . basename($_FILES['task_attachment']['name']); // Add timestamp to avoid overwriting
        $targetPath = $uploadDir . $fileName;

        // Ensure the upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
        }

        if (move_uploaded_file($_FILES['task_attachment']['tmp_name'], $targetPath)) {
            $task_attachment = $fileName;
        } else {
            $_SESSION['error'] = "Failed to upload task attachment.";
            header("Location: ../view/add_task.php?project_id=" . ($_POST['project_id'] ?? 0));
            exit();
        }
    }

    // Debugging: Uncomment the following lines for troubleshooting
    // echo "<pre>";
    // print_r([
    //     'pm_id' => $pm_id,
    //     'delegate' => $delegate,
    //     'task_name' => $task_name,
    //     'task_description' => $task_description,
    //     'predecessor_task' => $predecessor_task,
    //     'successor_task' => $successor_task,
    //     'deadline' => $deadline,
    //     'task_attachment' => $task_attachment
    // ]);
    // echo "</pre>";

    // Add the task via controller
    $result = addTask_ctr(
        $pm_id,
        $delegate,
        $task_name,
        $task_description,
        $predecessor_task,
        $successor_task,
        $deadline,
        $task_attachment
    );

    if ($result) {
        $_SESSION['success'] = "Task added successfully.";
        header("Location: ../view/task_management.php?project_id=" . ($_POST['project_id'] ?? 0));
        exit();
    } else {
        $_SESSION['error'] = "Failed to add the task. Please try again.";
        header("Location: ../view/add_task.php?project_id=" . ($_POST['project_id'] ?? 0));
        exit();
    }
}

// Redirect to the form page if accessed directly
header("Location: ../view/add_task.php");
exit();
