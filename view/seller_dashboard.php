<?php
session_start();
include("../controllers/project_controller.php");

// Ensure the user is logged in as a seller
if (!isset($_SESSION['user']) || $_SESSION['role'] != 2) {
    header("Location: login.php");
    exit();
}

// Fetch the logged-in seller details
$seller = $_SESSION['user'];
$seller_id = $seller['seller_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
    <?php include "navbar.php"; ?>
</head>
<body>

<section class="site-banner jarallax padding-large" style="background: url(images/seller-banner.jpg) no-repeat; background-position: top;">
  <div class="container text-center">
    <h1 class="page-title">Seller Dashboard</h1>
  </div>
</section>
<section class="seller-dashboard padding-large">
  <div class="container">
    <div class="row">
      <!-- Sidebar -->
      <?php include "seller_navbar.php";?>

      <!-- Main Content -->
      <div class="col-md-9">
        <h2 class="section-title">Unpublished Projects</h2>
        <div class="row d-flex flex-wrap">
          <?php
          // Fetch all unpublished projects
          $unpublished_projects = fetchAllUnpublishedProjects();

          // Check if query failed
          if ($unpublished_projects === false) {
              echo '<p>Error fetching projects. Please try again later.</p>';
          } elseif (empty($unpublished_projects)) {
              // No projects available
              echo '<p>No unpublished projects available at the moment.</p>';
          } else {
              // Display projects in a grid format
              foreach ($unpublished_projects as $project) {
                  echo '
                  <div class="col-lg-4 col-md-6 col-sm-6">
                    <article class="product">
                      <img src="images/project-placeholder.jpg" alt="' . htmlspecialchars($project['project_title']) . '">
                      <div class="product-info">
                        <h2>' . htmlspecialchars($project['project_title']) . '</h2>
                        <p>' . htmlspecialchars(substr($project['project_desc'], 0, 100)) . '...</p>
                        <p><strong>Category:</strong> ' . htmlspecialchars($project['cat_name']) . '</p>
                        <p><strong>Price:</strong> $' . htmlspecialchars($project['project_price']) . '</p>
                        <div class="product-actions">
                          <a href="project_details.php?project_id=' . htmlspecialchars($project['project_id']) . '" class="btn btn-primary">View Details</a>
                        </div>
                      </div>
                    </article>
                  </div>';
              }
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include "footer.php"; ?>

</body>
</html>
