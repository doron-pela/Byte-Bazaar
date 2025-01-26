<?php
session_start();
require_once("../controllers/project_controller.php");
require_once("../controllers/role_controller.php");

// Ensure the user is logged in
if (!isset($_SESSION['user']) || $_SESSION['role'] != 2) {
    header("Location: login.php");
    exit();
}

// Get the project ID from the query string
if (!isset($_GET['project_id'])) {
    header("Location: seller_dashboard.php");
    exit();
}

$project_id = (int)$_GET['project_id'];

// Fetch project details
$project = fetchProjectById($project_id);
if (!$project) {
    echo "Project not found.";
    exit();
}

// Fetch roles for the project
$roles = fetchRolesByProjectId($project_id);

// Fetch the creator's details
$creator = fetchProjectCreator($project_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
    <?php include "navbar.php"; ?>
</head>
<body>

<section class="site-banner jarallax padding-large" style="background: url(images/project-banner.jpg) no-repeat; background-position: top;">
    <div class="container text-center">
        <h1 class="page-title">Project Details</h1>
    </div>
</section>

<section class="project-details padding-large">
    <div class="container">

        <!-- Sidebar -->
        <?php include "seller_navbar.php";?>

        <div class="row">
            <div class="col-md-8">
                <div class="project-overview">
                    <h2><?php echo htmlspecialchars($project['project_title']); ?></h2>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($project['project_desc']); ?></p>
                    <p><strong>Price:</strong> $<?php echo number_format($project['project_price'], 2); ?></p>
                    <p><strong>Category:</strong> <?php echo htmlspecialchars($project['cat_name']); ?></p>
                    <p><strong>Keywords:</strong> <?php echo htmlspecialchars($project['project_keywords']); ?></p>

                    <!-- Creator Information -->
                    <p><strong>Created By:</strong> 
                        <?php echo isset($creator['seller_name']) 
                            ? htmlspecialchars($creator['seller_name']) . " (Role: Creator)" 
                            : "Unknown"; ?>
                    </p>
                </div>

                <div class="project-roles mt-5">
                    <h3>Roles</h3>
                    <?php if ($roles): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Role Name</th>
                                        <th>Description</th>
                                        <th>Takings (%)</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>   
                                </thead>
                                <tbody>
                                    <?php foreach ($roles as $role): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($role['role_name']); ?></td>
                                            <td><?php echo htmlspecialchars($role['description'] ?? 'N/A'); ?></td>
                                            <td><?php echo htmlspecialchars($role['takings'] ?? 'N/A'); ?>%</td>
                                            <td>
                                                <?php 
                                                echo ($role['role_name'] === 'Creator') ? 'N/A' 
                                                    : ($role['taken'] == 0 ? 'Available' : 'Taken'); 
                                                ?>
                                            </td>
                                            <td>
                                                <?php if ($role['role_name'] !== 'Creator' && $role['taken'] == 0): ?>
                                                    <a href="application_form.php?role_id=<?php echo $role['role_id']; ?>&project_id=<?php echo $project['project_id']; ?>" class="btn btn-primary">Apply</a>
                                                <?php else: ?>
                                                    <span><?php echo ($role['role_name'] === 'Creator') ? 'Not Applicable' : 'Taken'; ?></span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p>No roles available for this project.</p>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</section>

<?php include "footer.php"; ?>
</body>
</html>
