<?php
session_start();
require_once("../controllers/project_controller.php");

// Ensure the user is logged in as a seller
if (!isset($_SESSION['user']) || $_SESSION['role'] != 2) {
    header("Location: login.php");
    exit();
}

$seller = $_SESSION['user'];
$seller_id = $seller['seller_id'];

// Get the project ID from the query string
if (!isset($_GET['project_id'])) {
    header("Location: my_projects.php");
    exit();
}

$project_id = $_GET['project_id'];
$_SESSION['project_id'] = $project_id;
$project_id = $_SESSION['project_id'];

// Fetch project details
$project = fetchProjectById($project_id);
if (!$project || $project['seller_id'] != $seller_id) {
    echo "You are not authorized to publish this project.";
    exit();
}

// Fetch all categories for the dropdown
$categories = viewCategories(); // Ensure you have a function to fetch categories
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publish Project</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
    <?php include "navbar.php"; ?>
</head>
<body>

<section class="site-banner jarallax padding-large" style="background: url(images/publish-project-banner.jpg) no-repeat; background-position: top;">
    <div class="container text-center">
        <h1 class="page-title">Publish Project</h1>
    </div>
</section>

<section class="publish-project padding-large">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Navigation</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li><a href="seller_profile.php">Profile</a></li>
                            <li><a href="my_projects.php">My Projects</a></li>
                            <li><a href="task_dashboard.php">Task Dashboard</a></li>
                            <li><a href="../actions/logout.php">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <h2>Publish Project</h2>
                <form action="../actions/publish_project_action.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                    
                    <div class="form-group">
                        <label for="project_title">Project Title</label>
                        <input type="text" name="project_title" class="form-control" value="<?php echo $project['project_title']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="project_category">Category</label>
                        <select name="project_category" class="form-control" required>
                            <option value="" disabled>Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['cat_id']; ?>" 
                                    <?php echo $category['cat_id'] == $project['project_cat'] ? 'selected' : ''; ?>>
                                    <?php echo $category['cat_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="project_price">Price</label>
                        <input type="number" step="0.01" name="project_price" class="form-control" value="<?php echo $project['project_price']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="project_desc">Description</label>
                        <textarea name="project_desc" class="form-control" rows="5" required><?php echo $project['project_desc']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="project_keywords">Keywords</label>
                        <input type="text" name="project_keywords" class="form-control" value="<?php echo $project['project_keywords']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="live_demo">Live Demo (Optional)</label>
                        <input type="url" name="link" class="form-control" value="<?php echo $project['link'] ?? ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="project_image">Project Thumbnail (Optional)</label>
                        <input type="file" name="project_image" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="file">Upload Zip File</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="screenshots">Screenshots (Optional)</label>
                        <input type="file" name="sc1" class="form-control mb-2">
                        <input type="file" name="sc2" class="form-control mb-2">
                        <input type="file" name="sc3" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Publish Project</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include "footer.php"; ?>

</body>
</html>
