<?php
session_start();
require_once("../controllers/project_controller.php");
require_once("../controllers/role_controller.php");

// Ensure the user is logged in as a seller
if (!isset($_SESSION['user']) || $_SESSION['role'] != 2) {
    header("Location: login.php");
    exit();
}

$seller = $_SESSION['user'];
$seller_id = $seller['seller_id'];

// Get the role ID and project ID from the query string
if (!isset($_GET['role_id']) || !isset($_GET['project_id'])) {
    header("Location: seller_dashboard.php");
    exit();
}

$role_id = $_GET['role_id'];
$project_id = $_GET['project_id'];

// Fetch project details
$project = fetchProjectById($project_id);
if (!$project) {
    echo "Project not found.";
    exit();
}

// Fetch role details
$role = fetchRolesByProjectId($project_id);
$selected_role = null;
foreach ($role as $r) {
    if ($r['role_id'] == $role_id) {
        $selected_role = $r;
        break;
    }
}
if (!$selected_role) {
    echo "Role not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Role</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
    <?php include "navbar.php"; ?>
</head>
<body>

<section class="site-banner jarallax padding-large" style="background: url(images/apply-banner.jpg) no-repeat; background-position: top;">
    <div class="container text-center">
        <h1 class="page-title">Apply for Role</h1>
    </div>
</section>

<section class="application-form padding-large">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="../actions/apply_for_role_action.php" method="post">
                    <div class="form-group">
                        <label for="project_title">Project Title</label>
                        <input type="text" class="form-control" value="<?php echo $project['project_title']; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="role_name">Role Name</label>
                        <input type="text" class="form-control" value="<?php echo $selected_role['role_name']; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="role_description">Role Description</label>
                        <textarea class="form-control" rows="4" readonly><?php echo $selected_role['description']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="reason">Why are you applying for this role? (Optional)</label>
                        <textarea name="reason" class="form-control" rows="4" placeholder="Write your reason here..."></textarea>
                    </div>

                    <!-- Hidden inputs to pass role and project IDs -->
                    <input type="hidden" name="role_id" value="<?php echo $role_id; ?>">
                    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                    <input type="hidden" name="seller_id" value="<?php echo $seller_id; ?>">

                    <button type="submit" class="btn btn-primary btn-block">Submit Application</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include "footer.php"; ?>
</body>
</html>
