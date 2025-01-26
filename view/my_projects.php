<?php 
session_start();
include("../controllers/project_controller.php");

// Ensure the user is logged in as a seller
if (!isset($_SESSION['user']) || $_SESSION['role'] != 2) {
    header("Location: login.php");
    exit();
}

$seller = $_SESSION['user'];
$seller_id = $seller['seller_id'];

// Fetch projects where the seller has membership (including their own created projects)
$joined_projects = fetchProjectsByMembership($seller_id);
if (!is_array($joined_projects)) {
    $joined_projects = [];
}

// Separate published and unpublished projects
$unpublished_projects = array_filter($joined_projects, function ($project) {
    return isset($project['published']) && $project['published'] == 0;
});
$published_projects = array_filter($joined_projects, function ($project) {
    return isset($project['published']) && $project['published'] == 1;
});

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Projects</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
    <?php include "navbar.php"; ?>
</head>
<body>

<section class="site-banner jarallax padding-large" style="background: url(images/seller-banner.jpg) no-repeat; background-position: top;">
  <div class="container text-center">
    <h1 class="page-title">My Projects</h1>
  </div>
</section>

<section class="my-projects padding-large">
  <div class="container">
    <div class="row">
      <!-- Sidebar -->
      <?php include "seller_navbar.php";?>

      <!-- Main Content -->
      <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2>Projects You Are a Member Of</h2>
          <a href="create_project.php" class="btn btn-primary">Create New Project</a>
        </div>

        <!-- Unpublished Projects -->
        <h3>Unpublished Projects</h3>
        <div class="row">
          <?php if ($unpublished_projects): ?>
              <?php foreach ($unpublished_projects as $project): ?>
                  <div class="col-md-4">
                    <div class="card">
                      <div class="card-body">
                        <h5><?php echo htmlspecialchars($project['project_title']); ?></h5>
                        <p><?php echo htmlspecialchars(substr($project['project_desc'], 0, 100)); ?>...</p>
                        <p><strong>Category:</strong> <?php echo htmlspecialchars($project['cat_name'] ?? "N/A"); ?></p>
                        <p><strong>Price:</strong> $<?php echo number_format($project['project_price'], 2); ?></p>
                        
                        <!-- Publish Button (Only for Creator) -->
                        <?php if ($project['seller_id'] == $seller_id): ?>
                            <a href="publish_project.php?project_id=<?php echo $project['project_id']; ?>" class="btn btn-warning">Publish Project</a>
                        <?php endif; ?>
                        
                        <!-- Task Manager -->
                        <a href="task_dashboard.php?project_id=<?php echo $project['project_id']; ?>" class="btn btn-primary">Task Manager</a>
                        
                        <!-- Delete Button (Only for Creator) -->
                        <?php if ($project['seller_id'] == $seller_id): ?>
                            <form action="../actions/delete_project_action.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this project? This action cannot be undone.');" class="mt-2">
                                <input type="hidden" name="project_id" value="<?php echo $project['project_id']; ?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
              <?php endforeach; ?>
          <?php else: ?>
              <p>No unpublished projects available.</p>
          <?php endif; ?>
        </div>

        <!-- Published Projects -->
        <h3>Published Projects</h3>
        <div class="row">
          <?php if ($published_projects): ?>
              <?php foreach ($published_projects as $project): ?>
                  <div class="col-md-4">
                    <div class="card">
                      <div class="card-body">
                        <h5><?php echo htmlspecialchars($project['project_title']); ?></h5>
                        <p><?php echo htmlspecialchars(substr($project['project_desc'], 0, 100)); ?>...</p>
                        <p><strong>Category:</strong> <?php echo htmlspecialchars($project['cat_name'] ?? "N/A"); ?></p>
                        <p><strong>Price:</strong> $<?php echo number_format($project['project_price'], 2); ?></p>
                        
                        <!-- View Project Button -->
                        <a href="project_details.php?project_id=<?php echo $project['project_id']; ?>" class="btn btn-success">View Project</a>
                        
                        <!-- Delete Button (Only for Creator) -->
                        <?php if ($project['seller_id'] == $seller_id): ?>
                            <form action="../actions/delete_project_action.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this project? This action cannot be undone.');" class="mt-2">
                                <input type="hidden" name="project_id" value="<?php echo $project['project_id']; ?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
              <?php endforeach; ?>
          <?php else: ?>
              <p>No published projects available.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include "footer.php"; ?>

</body>
</html>
 