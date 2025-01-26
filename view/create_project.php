<?php
session_start();
include("../controllers/project_controller.php");
require_once("../settings/db_class.php");

// Ensure the user is logged in as a seller
if (!isset($_SESSION['user']) || $_SESSION['role'] != 2) {
    header("Location: login.php");
    exit();
}

$seller = $_SESSION['user'];
$seller_id = $seller['seller_id'];

// Fetch categories from the database
function fetchCategories() {
    $db = new db_connection();
    $sql = "SELECT * FROM categories";
    return $db->db_fetch_all($sql);
}

$categories = fetchCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Project</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
    <?php include "navbar.php"; ?>
</head>
<body>

<section class="site-banner jarallax padding-large" style="background: url(images/seller-banner.jpg) no-repeat; background-position: top;">
  <div class="container text-center">
    <h1 class="page-title">Create Project</h1>
  </div>
</section>

<section class="create-project padding-large">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <form action="../actions/add_project_action.php" method="post" id="createProjectForm">
          <div class="form-group">
            <label for="project_title">Project Title</label>
            <input type="text" name="project_title" class="form-control" placeholder="Enter project title" required>
          </div>

          <div class="form-group">
            <label for="project_description">Description</label>
            <textarea name="project_description" class="form-control" rows="4" placeholder="Enter project description" required></textarea>
          </div>

          <div class="form-group">
            <label for="project_price">Price</label>
            <input type="number" step="0.01" name="project_price" class="form-control" placeholder="Enter project price" required>
          </div>

          <div class="form-group">
            <label for="project_keywords">Keywords</label>
            <input type="text" name="project_keywords" class="form-control" placeholder="Enter keywords (comma-separated)">
          </div>

          <div class="form-group">
            <label for="project_category">Category</label>
            <select name="project_category" class="form-control" required>
                <option value="" disabled selected>Select category</option>
                <?php
                if (!empty($categories)) {
                    foreach ($categories as $category) {
                        echo "<option value='" . $category['cat_id'] . "'>" . $category['cat_name'] . "</option>";
                    }
                } else {
                    echo "<option value='' disabled>No categories available</option>";
                }
                ?>
            </select>
          </div>

          <!-- Creator's Role -->
          <div class="form-group">
            <label for="creator_takings">Creator Role Takings (%)</label>
            <input type="number" step="0.01" name="creator_takings" class="form-control" placeholder="Enter your takings as creator" required>
          </div>

          <!-- Additional Roles (Optional) -->
          <div class="form-group">
            <label for="roles">Additional Roles (Optional)</label>
            <div id="roles-container">
              <!-- Additional roles can be dynamically added here -->
            </div>
            <button type="button" id="addRole" class="btn btn-secondary mt-2">Add Role</button>
          </div>

          <input type="hidden" name="seller_id" value="<?php echo $seller_id; ?>">

          <button type="submit" class="btn btn-primary btn-block mt-4">Create Project</button>
        </form>
      </div>
    </div>
  </div>
</section>

<?php include "footer.php"; ?>

<script>
  let roleIndex = 0;

  document.getElementById("addRole").addEventListener("click", function () {
    const rolesContainer = document.getElementById("roles-container");

    const roleHTML = `
      <div class="role-item mb-3">
        <input type="text" name="roles[${roleIndex}][role_name]" class="form-control mb-2" placeholder="Role Name">
        <textarea name="roles[${roleIndex}][role_description]" class="form-control mb-2" rows="2" placeholder="Role Description"></textarea>
        <input type="number" name="roles[${roleIndex}][role_takings]" class="form-control mb-2" placeholder="Takings (%)">
        <select name="roles[${roleIndex}][role_availability]" class="form-control">
          <option value="1">Available</option>
          <option value="0">Unavailable</option>
        </select>
      </div>
    `;

    rolesContainer.insertAdjacentHTML("beforeend", roleHTML);
    roleIndex++;
  });
</script>

</body>
</html>
