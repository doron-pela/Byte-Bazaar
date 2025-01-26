<?php
session_start();
require_once("../controllers/task_controller.php");
require_once("../controllers/project_controller.php");

// Ensure the user is logged in
if (!isset($_SESSION['user']) || $_SESSION['role'] != 2) {
    header("Location: login.php");
    exit();
}

$seller = $_SESSION['user'];
$seller_id = $seller['seller_id'];

// Fetch task details
if (!isset($_GET['task_id'])) {
    header("Location: task_management.php");
    exit();
}

$task_id = (int)$_GET['task_id'];
$task = fetchTaskById_ctr($task_id);

// Fetch project creator details
$project_creator = fetchProjectCreator($task['project_id']);

// Check permissions
$is_creator = ($task['pm_id'] == $seller_id || $project_creator['seller_id'] == $seller_id);
$is_delegate = ($task['delegate'] == $seller_id);

$completed_attachment_path = "../uploads/completed_attachments/";
$task_attachment_path = "../uploads/task_attachments/";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <?php include "navbar.php"; ?>
    <style>
        <?php include "task_management.css"; ?>
    </style>
</head>
<body>
<div class="app-container">
    <!-- Sidebar -->
    <?php include "task_navbar.php"; ?>

    <div class="app-content">
        <div class="projects-section">
            <h2>Task Details</h2>
            <p>Task Name: <?php echo htmlspecialchars($task['task_name']); ?></p>
            <p>Description: <?php echo htmlspecialchars($task['task_description']); ?></p>
            <p>Deadline: <?php echo date("F d, Y", strtotime($task['deadline'])); ?></p>
            <p>Status: <?php echo $task['status'] == 1 ? 'Completed' : 'Incomplete'; ?></p>

            <div class="projects-section-header">
                <!-- Task Attachment -->
                <div>
                    <h3>Task Attachment</h3>
                    <?php if (!empty($task['task_attachment'])): ?>
                        <a href="<?php echo $task_attachment_path . htmlspecialchars($task['task_attachment']); ?>" download>
                            Download Task Attachment
                        </a>
                    <?php else: ?>
                        <p>No task attachment available.</p>
                    <?php endif; ?>
                </div>

                <!-- Completed Attachment -->
                <div>
                    <h3>Completed Attachment</h3>
                    <?php if (!empty($task['completed_attachment'])): ?>
                        <a href="<?php echo $completed_attachment_path . htmlspecialchars($task['completed_attachment']); ?>" download>
                            Download Completed Attachment
                        </a>
                    <?php else: ?>
                        <p>No completed file uploaded yet.</p>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($is_creator): ?>
                <form method="POST" action="../actions/update_task_action.php" enctype="multipart/form-data">
                    <!-- Editable fields -->
                    <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
                    <label for="task_name">Task Name:</label>
                    <input type="text" name="task_name" id="task_name" value="<?php echo htmlspecialchars($task['task_name']); ?>" required>
                    <label for="task_description">Description:</label>
                    <textarea name="task_description" id="task_description" required><?php echo htmlspecialchars($task['task_description']); ?></textarea>
                    <label for="deadline">Deadline:</label>
                    <input type="date" name="deadline" id="deadline" value="<?php echo $task['deadline']; ?>" required>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            <?php endif; ?>

            <?php if ($is_delegate): ?>
                <form method="POST" action="../actions/upload_completed_attachment_action.php" enctype="multipart/form-data">
                    <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
                    <label for="completed_attachment">Upload Task Submission:</label>
                    <input type="file" name="completed_attachment" id="completed_attachment" required>
                    <button type="submit" class="btn btn-secondary">Upload</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
</body>
</html>
