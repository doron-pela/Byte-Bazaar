<?php
session_start();
require_once("../controllers/task_controller.php");
require_once("../controllers/project_controller.php");
require_once("../controllers/message_controller.php");

// Ensure the user is logged in as a project member
if (!isset($_SESSION['user']) || $_SESSION['role'] != 2) {
    header("Location: login.php");
    exit();
}

// Validate and get project ID
if (!isset($_GET['project_id']) || empty($_GET['project_id'])) {
    $_SESSION['error'] = "Project ID is missing or invalid.";
    header("Location: dashboard.php");
    exit();
}

$project_id = $_GET['project_id'];
$seller = $_SESSION['user'];
$seller_id = $seller['seller_id'];

// Fetch project details to get the title
$project = fetchProjectById($project_id);
if (!$project) {
    $_SESSION['error'] = "Project not found.";
    header("Location: dashboard.php");
    exit();
}

// Fetch all tasks for the project
$allTasks = fetchAllTasksByProject_ctr($project_id);

// Filters
$filter = $_GET['filter'] ?? '';
$filteredTasks = filterTasksByCriteria($allTasks, $filter);

// Function to filter tasks based on criteria
function filterTasksByCriteria($tasks, $filter) {
    $filteredTasks = [];
    foreach ($tasks as $task) {
        if (($filter === 'complete' && $task['status'] == 1) ||
            ($filter === 'incomplete' && $task['status'] == 0) ||
            ($filter === 'monthly' && date('Y-m', strtotime($task['deadline'])) == date('Y-m')) ||
            ($filter === 'weekly' && date('W', strtotime($task['deadline'])) == date('W')) ||
            ($filter === 'all' || $filter === '')) {
            $filteredTasks[] = $task;
        }
    }
    return $filteredTasks;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management - <?php echo htmlspecialchars($project['project_title']); ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
    <script src="../scripts/task_management.js"></script>
    <?php include "navbar2.php"; ?>
</head>
<body>
<div class="app-container">
    <style>
        <?php include "task_management.css"; ?>
    </style>
    <!-- Sidebar -->
    <?php include "task_navbar.php"; ?>

    <!-- Main Content -->
    <div class="app-content">
        <div class="projects-section">
            <div class="projects-section-header">
                <!-- Display Project Title -->
                <h2>Project: <?php echo htmlspecialchars($project['project_title']); ?></h2>
                <p class="time"><?php echo date("F, d"); ?></p>
                
                <!-- Add Task Button -->
                <div class="add-task-button">
                    <a href="add_task.php?project_id=<?php echo htmlspecialchars($project_id); ?>" class="btn btn-primary">
                        Add Task
                    </a>
                </div>

                <!-- Filters -->
                <form method="GET" class="mb-4">
                    <input type="hidden" name="project_id" value="<?php echo htmlspecialchars($project_id); ?>">
                    <select name="filter" onchange="this.form.submit()" class="form-control">
                        <option value="all" <?= $filter === 'all' || $filter === '' ? 'selected' : '' ?>>All Tasks</option>
                        <option value="complete" <?= $filter === 'complete' ? 'selected' : '' ?>>Completed Tasks</option>
                        <option value="incomplete" <?= $filter === 'incomplete' ? 'selected' : '' ?>>Incomplete Tasks</option>
                        <option value="monthly" <?= $filter === 'monthly' ? 'selected' : '' ?>>Tasks Due This Month</option>
                        <option value="weekly" <?= $filter === 'weekly' ? 'selected' : '' ?>>Tasks Due This Week</option>
                    </select>
                </form>
            </div>

            <!-- Tasks List -->
            <?php if (!empty($filteredTasks)): ?>
                <div class="project-boxes jsGridView">
                    <?php foreach ($filteredTasks as $task): ?>
                        <div class="project-box-wrapper">
                            <div class="project-box" style="background-color: #fee4cb;">
                                <div class="project-box-header">
                                    <span><?php echo date("F d, Y", strtotime($task['deadline'])); ?></span>
                                </div>
                                <div class="project-box-content-header">
                                    <p class="box-content-header"><?php echo htmlspecialchars($task['task_name']); ?></p>
                                    <p class="box-content-subheader"><?php echo htmlspecialchars($task['task_description']); ?></p>
                                </div>
                                <div class="box-progress-wrapper">
                                    <p class="box-progress-header">Progress</p>
                                    <div class="box-progress-bar">
                                        <span class="box-progress"
                                              style="width: <?php echo $task['progress'] ?? 0; ?>%; background-color: #ff942e"></span>
                                    </div>
                                    <p class="box-progress-percentage"><?php echo $task['progress'] ?? 0; ?>%</p>
                                </div>
                                <div class="project-box-footer">
                                    <button class="add-participant" style="color: #ff942e;"
                                            onclick="location.href='task_details.php?task_id=<?php echo $task['task_id']; ?>'">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No tasks available for this project.</p>
            <?php endif; ?>
        </div>

        <!-- Messaging Section -->
        <div class="messages-section mt-4">
            <div class="messages-section-header">
                <h3>Messages</h3>
                <!-- Send Message Form -->
                <form action="../actions/send_message_action.php" method="POST">
                    <input type="hidden" name="project_id" value="<?php echo htmlspecialchars($project_id); ?>">
                    <div class="form-group">
                        <label for="pm_id2">Send to:</label>
                        <select name="pm_id2" id="pm_id2" class="form-control" required>
                            <?php foreach (fetchProjectMembers_ctr($project_id) as $member): ?>
                                <option value="<?php echo $member['seller_id']; ?>" 
                                    <?php echo isset($_GET['pm_id2']) && $_GET['pm_id2'] == $member['seller_id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($member['seller_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="text">Message:</label>
                        <textarea name="text" id="text" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>

            <!-- Display Messages -->
            <div class="messages mt-4">
                <?php
                $pm_id2 = $_GET['pm_id2'] ?? fetchProjectMembers_ctr($project_id)[0]['seller_id'];
                $messages = fetchMessages_ctr($seller_id, $pm_id2);

                foreach ($messages as $message): ?>
                    <div class="message-box">
                        <p class="message-line time"><?php echo date("F d, Y H:i", strtotime($message['sent_at'])); ?></p>
                        <p class="message-line"><?php echo htmlspecialchars($message['text']); ?></p>
                        <?php if ($message['pm_id1'] == $seller_id): ?>
                            <form action="../actions/delete_message_action.php" method="POST" class="d-inline">
                                <input type="hidden" name="message_id" value="<?php echo $message['message_id']; ?>">
                                <input type="hidden" name="project_id" value="<?php echo htmlspecialchars($project_id); ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>


    </div>
</div>

<?php include "footer.php"; ?>
<script src="../scripts/task_management.js"></script>
</body>
</html>
