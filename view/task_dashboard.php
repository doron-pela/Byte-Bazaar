<?php
session_start();

// Ensure the user is logged in as a seller
if (!isset($_SESSION['user']) || $_SESSION['role'] != 2) {
    header("Location: login.php");
    exit();
}

$seller = $_SESSION['user'];
$seller_id = $seller['seller_id'];

include("../controllers/project_controller.php");

// Fetch projects the seller created
$created_projects = fetchProjectsBySeller($seller_id);

// Fetch projects the seller is a member of
$member_projects = fetchProjectsByMembership($seller_id);

// Fetch projects the seller has joined
$joined_projects = fetchJoinedProjects($seller_id); // Ensure this function exists in the project controller
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">

    <?php include "navbar.php"; ?>
</head>
<body>

<section class="site-banner jarallax padding-large" style="background: url(images/task-dashboard-banner.jpg) no-repeat; background-position: top;">
    <div class="container text-center">
        <h1 class="page-title">Task Dashboard</h1>
    </div>
</section>

<section class="task-dashboard padding-large">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <?php include "task_navbar.php"; ?>

            <!-- Main Content -->
            <div class="col-md-9">
                <h2>Welcome to the Task Dashboard</h2>
                <p>Select a section from the navigation menu to manage tasks, roles, or publish your project.</p>

                <!-- Projects Section -->
                <h3>Your Projects</h3>

                <!-- Created Projects -->
                <div class="projects-section">
                    <h4>Projects You Created</h4>
                    <?php if ($created_projects): ?>
                        <ul class="list-group">
                            <?php foreach ($created_projects as $project): ?>
                                <li class="list-group-item">
                                    <strong><?php echo $project['project_title']; ?></strong>
                                    <br>Description: <?php echo $project['project_desc']; ?>
                                    <br>Price: $<?php echo $project['project_price']; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No projects created.</p>
                    <?php endif; ?>
                </div>

                <!-- Member Projects -->
                <div class="projects-section">
                    <h4>Projects You Are a Member Of</h4>
                    <?php if ($member_projects): ?>
                        <ul class="list-group">
                            <?php foreach ($member_projects as $project): ?>
                                <li class="list-group-item">
                                    <strong><?php echo $project['project_title']; ?></strong>
                                    <br>Description: <?php echo $project['project_desc']; ?>
                                    <br>Role: <?php echo $project['role_name']; ?>
                                    <br>Price: $<?php echo $project['project_price']; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No member projects.</p>
                    <?php endif; ?>
                </div>

                <!-- Joined Projects 
                 
                    <div class="projects-section">
                    <h4>Projects You Joined</h4>
                    <?php /* if ($joined_projects): ?>
                        <ul class="list-group">
                            <?php foreach ($joined_projects as $project): ?>
                                <li class="list-group-item">
                                    <strong><?php echo $project['project_title']; ?></strong>
                                    <br>Description: <?php echo $project['project_description']; ?>
                                    <br>Price: $<?php echo $project['project_price']; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No joined projects.</p>
                    <?php endif; */ ?>
                    </div>
                
                -->
                
            </div>
        </div>
    </div>
</section>

<?php include "footer.php"; ?>

</body>
</html>
