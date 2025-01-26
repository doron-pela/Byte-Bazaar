<?php
session_start();
require_once("../controllers/project_controller.php");
require_once("../controllers/role_controller.php");
require_once("../controllers/task_controller.php");

// Ensure the user is logged in
if (!isset($_SESSION['user']) || $_SESSION['role'] != 2) {
    header("Location: login.php");
    exit();
}

// Check if project_id exists in the URL
if (!isset($_GET['project_id']) || empty($_GET['project_id'])) {
    $_SESSION['error'] = "Project ID is missing or invalid.";
    header("Location: task_management.php");
    exit();
}

$project_id = (int)$_GET['project_id']; // Get project ID from the URL
$seller = $_SESSION['user'];
$seller_id = $seller['seller_id'];

// Fetch project memberships for the logged-in seller
$memberships = fetchProjectMembershipsBySeller_ctr($seller_id);
$pm_id = null;

foreach ($memberships as $membership) {
    if ($membership['project_id'] == $project_id) {
        $pm_id = $membership['pm_id'];
        break;
    }
}

if (!$pm_id) {
    $_SESSION['error'] = "You are not a member of this project.";
    header("Location: task_management.php");
    exit();
}

// Fetch roles and associated members for the project
$projectRolesWithMembers = fetchProjectRolesWithMembers_ctr($project_id); // Call the role controller to get roles and members
$existingTasks = fetchTasksByProject_ctr($project_id); // Get existing tasks for predecessor/successor selection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>
<body>
<div class="app-container">
    <?php include "navbar.php"; ?>

    <div class="projects-section">
        <div class="projects-section-header">
            <h2>Add Task</h2>
        </div>

        <form action="../actions/add_task_action.php" method="POST" enctype="multipart/form-data" class="form-container">
            <!-- Project Membership ID -->
            <input type="hidden" name="pm_id" value="<?php echo htmlspecialchars($pm_id); ?>">
            <input type="hidden" name="project_id" value="<?php echo htmlspecialchars($project_id); ?>">

            <!-- Task Delegate -->
            <div class="form-group">
                <label for="delegate">Delegate Task To:</label>
                <select id="delegate" name="delegate" class="form-control" required>
                    <option value="">Select Project Role and Member</option>
                    <?php if (!empty($projectRolesWithMembers)): ?>
                        <?php foreach ($projectRolesWithMembers as $role): ?>
                            <optgroup label="<?php echo htmlspecialchars($role['role_name']); ?>">
                                <?php foreach ($role['members'] as $member): ?>
                                    <option value="<?php echo htmlspecialchars($member['seller_id']); ?>">
                                        <?php echo htmlspecialchars($member['seller_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">No roles or members available</option>
                    <?php endif; ?>
                </select>
            </div>

            <!-- Task Name -->
            <div class="form-group">
                <label for="task_name">Task Name</label>
                <input type="text" id="task_name" name="task_name" class="form-control" required>
            </div>

            <!-- Task Description -->
            <div class="form-group">
                <label for="task_description">Task Description</label>
                <textarea id="task_description" name="task_description" class="form-control" rows="4" required></textarea>
            </div>

            <!-- Task Predecessor -->
            <div class="form-group">
                <label for="predecessor_task">Predecessor Task</label>
                <select id="predecessor_task" name="predecessor_task" class="form-control">
                    <option value="" selected>No Predecessor</option>
                    <?php foreach ($existingTasks as $task): ?>
                        <option value="<?php echo $task['task_id']; ?>">
                            <?php echo htmlspecialchars($task['task_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Task Successor -->
            <div class="form-group">
                <label for="successor_task">Successor Task</label>
                <select id="successor_task" name="successor_task" class="form-control">
                    <option value="" selected>No Successor</option>
                    <?php foreach ($existingTasks as $task): ?>
                        <option value="<?php echo $task['task_id']; ?>">
                            <?php echo htmlspecialchars($task['task_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Task Deadline -->
            <div class="form-group">
                <label for="deadline">Deadline</label>
                <input type="date" id="deadline" name="deadline" class="form-control" required>
            </div>

            <!-- Task Attachment -->
            <div class="form-group">
                <label for="task_attachment">Attachment</label>
                <input type="file" id="task_attachment" name="task_attachment" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Add Task</button>
        </form>
    </div>
</div>

<?php include "footer.php"; ?>
</body>
</html>
