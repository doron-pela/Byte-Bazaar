<?php
session_start();
require_once("../controllers/project_controller.php");
require_once("../controllers/application_controller.php");
require_once("../controllers/role_controller.php");

// Ensure the user is logged in as a seller
if (!isset($_SESSION['user']) || $_SESSION['role'] != 2) {
    header("Location: login.php");
    exit();
}

$seller = $_SESSION['user'];
$seller_id = $seller['seller_id'];

if (!isset($_GET['project_id'])) {
    echo "Project ID not provided. Redirecting...";
    header("Location: my_projects.php");
    exit();
}

$project_id = $_GET['project_id'];
$_SESSION['current_project_id'] = $project_id;

// Fetch applications and project members
$applications = fetchApplicationsByProject_ctr($project_id);
$members = fetchProjectMembersByProject_ctr($project_id);

// Fetch roles already created for the project
$project_roles = fetchRolesByProject_ctr($project_id);

// Fetch creator information for the project
$creator = fetchProjectCreator($project_id);

// Check if the logged-in seller is the creator of the project
$is_creator = $creator && isset($creator['seller_id']) && $creator['seller_id'] === $seller_id;

// Add the creator role to the roles array if not already included
if ($creator && isset($creator['seller_id'])) {
    $is_creator_in_roles = false;
    foreach ($project_roles as $role) {
        if ($role['role_name'] === 'Creator') {
            $is_creator_in_roles = true;
            break;
        }
    }
    if (!$is_creator_in_roles) {
        $creator['description'] = 'Creator'; // Set description for the creator
        $creator['takings'] = 'N/A'; // Creator's takings are not applicable
        $creator['taken'] = 1; // Mark as unavailable since the creator role is always taken
        array_unshift($project_roles, $creator); // Add creator at the top
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
    <?php include "navbar.php"; ?>
</head>
<body>

<section class="site-banner jarallax padding-large" style="background: url(images/role-management-banner.jpg) no-repeat; background-position: top;">
    <div class="container text-center">
        <h1 class="page-title">Role Management</h1>
    </div>
</section>

<section class="role-management padding-large">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <?php include "task_navbar.php"; ?>

            <!-- Main Content -->
            <div class="col-md-9">
                <!-- Show Applications Section Only for Creator -->
                <?php if ($is_creator): ?>
                    <h3>Applications</h3>
                    <?php if ($applications): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Applicant Name</th>
                                <th>Role Name</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <?php if ($is_creator): ?>
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($applications as $application): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($application['seller_name']); ?></td>
                                    <td><?php echo htmlspecialchars($application['role_name']); ?></td>
                                    <td><?php echo htmlspecialchars($application['application_statement']); ?></td>
                                    <td>
                                        <?php
                                        if ($application['status'] == 0) {
                                            echo 'Pending';
                                        } elseif ($application['status'] == 1) {
                                            echo 'Approved';
                                        } elseif ($application['status'] == 2) {
                                            echo 'Rejected';
                                        }
                                        ?>
                                    </td>
                                    <?php if ($is_creator): ?>
                                        <td>
                                            <?php if ($application['status'] == 0): // Show actions only for pending applications ?>
                                                <form action="../actions/approve_application_action.php" method="post" class="d-inline">
                                                    <input type="hidden" name="application_id" value="<?php echo $application['application_id']; ?>">
                                                    <button type="submit" class="btn btn-success">Approve</button>
                                                </form>
                                                <form action="../actions/reject_application_action.php" method="post" class="d-inline">
                                                    <input type="hidden" name="application_id" value="<?php echo $application['application_id']; ?>">
                                                    <button type="submit" class="btn btn-danger">Reject</button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted">No Action</span>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <p>No applications available.</p>
                <?php endif; ?>

                <?php endif; ?>

                <!-- Project Members Section -->
                <h3>Project Members</h3>
                <?php if ($members): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Member Name</th>
                                <th>Role Name</th>
                                <th>Role Description</th>
                                <?php if ($is_creator): ?>
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($members as $member): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($member['seller_name']); ?></td>
                                    <td><?php echo htmlspecialchars($member['role_name']); ?></td>
                                    <td><?php echo htmlspecialchars($member['description']); ?></td>
                                    <?php if ($is_creator): ?>
                                        <td>
                                            <?php if ($member['role_name'] !== 'Creator'): ?>
                                                <form action="../actions/remove_member_action.php" method="post">
                                                    <input type="hidden" name="membership_id" value="<?php echo $member['pm_id']; ?>">
                                                    <button type="submit" class="btn btn-danger">Remove</button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted">Not Applicable</span>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No members in this project.</p>
                <?php endif; ?>

                <!-- Show Create New Role Section Only for Creator -->
                <?php if ($is_creator): ?>
                    <h3>Create New Role</h3>
                    <form action="../actions/create_role_action.php" method="post">
                        <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                        <div class="form-group">
                            <label for="role_name">Role Name</label>
                            <input type="text" id="role_name" name="role_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="role_description">Role Description</label>
                            <textarea id="role_description" name="role_description" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="role_takings">Takings (%)</label>
                            <input type="number" id="role_takings" name="takings" class="form-control" placeholder="Enter takings percentage" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Role</button>
                    </form>
                <?php endif; ?>

                <!-- Existing Roles -->
                <h3>Existing Roles</h3>
                <?php if ($project_roles): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Role Name</th>
                                <th>Role Description</th>
                                <th>Takings</th>
                                <th>Status</th>
                                <?php if ($is_creator): ?>
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($project_roles as $role): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($role['role_name']); ?></td>
                                    <td><?php echo htmlspecialchars($role['description']); ?></td>
                                    <td><?php echo $role['takings'] !== 'N/A' ? htmlspecialchars($role['takings']) . '%' : 'N/A'; ?></td>
                                    <td><?php echo isset($role['taken']) && $role['taken'] == 1 ? 'Unavailable' : 'Available'; ?></td>
                                    <?php if ($is_creator): ?>
                                        <td>
                                            <?php if ($role['role_name'] !== 'Creator'): ?>
                                                <form action="../actions/delete_role_action.php" method="post">
                                                    <input type="hidden" name="role_id" value="<?php echo $role['role_id']; ?>">
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted">Not Applicable</span>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No roles created for this project yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include "footer.php"; ?>
</body>
</html>
