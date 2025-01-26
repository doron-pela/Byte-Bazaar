<?php
session_start();
require_once("../controllers/user_controller.php");
require_once("../controllers/project_controller.php");
require_once("../controllers/commission_controller.php");

// Ensure the user is logged in as a seller
if (!isset($_SESSION['user']) || $_SESSION['role'] != 2) {
    header("Location: login.php");
    exit();
}

$seller = $_SESSION['user'];
$seller_id = $seller['seller_id'];

// Fetch seller details directly from the database to get updated information
$seller_details = fetchSellerDetails($seller_id); // Ensure fetchSellerDetails() is defined in user_controller.php
if (!$seller_details) {
    echo "Seller not found.";
    exit();
}

// Update session with the latest seller details
$_SESSION['user'] = $seller_details;
$seller_id = $seller_details['seller_id'];

// Fetch seller's account balance
$account_balance = $seller_details['account_balance'] ?? 0.00;



function calculateSellerBalance($seller_id) {
    //require_once("../settings/db_class.php");
    $db = new db_connection();
    $total_balance = 0.00;

    // Query to calculate seller's balance based on their pm_id and role's takings
    $sql = "
        SELECT 
            sc.remuneration,
            pr.takings
        FROM 
            seller_credit AS sc
        INNER JOIN 
            project_membership AS pm ON sc.pm_id = pm.pm_id
        INNER JOIN 
            project_role AS pr ON pm.role_id = pr.role_id
        WHERE 
            pm.seller_id = '$seller_id'
    ";

    // Fetch results
    $results = $db->db_fetch_all($sql);

    // Check if results exist
    if ($results) {
        foreach ($results as $row) {
            $remuneration = (float) $row['remuneration'];
            $takings_percentage = (float) $row['takings'] / 100;

            // Calculate the seller's share
            $total_balance += $remuneration * $takings_percentage;
        }
    }

    // Update the seller's account balance in the database
    updateSellerBalance($seller_id, $total_balance);

    return $total_balance;
}

function fetchRemunerationsByProjectMembership($pm_id) {
    //require_once("../settings/db_class.php");
    $db = new db_connection();
    $pm_id = (int)$pm_id;

    $sql = "SELECT remuneration FROM seller_credit WHERE pm_id = '$pm_id'";
    return $db->db_fetch_all($sql);
}

function updateSellerBalance($seller_id, $total_balance) {
    //require_once("../settings/db_class.php");
    $db = new db_connection();
    $seller_id = (int)$seller_id;
    $total_balance = (float)$total_balance;

    $sql = "UPDATE seller SET account_balance = '$total_balance' WHERE seller_id = '$seller_id'";
    $db->db_query($sql);
}

// Fetch projects collaborated
$collaborated_projects = fetchProjectsByMembership($seller_id);

// Fetch roles and calculate updated account balance dynamically
$roles = fetchRolesBySeller_ctr($seller_id);
$updated_account_balance = calculateSellerBalance( $seller_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Profile - ByteBazaar</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>

<body>
    <?php include "navbar.php"; ?>

    <section class="site-banner jarallax padding-large" style="background: url(images/seller-profile-banner.jpg) no-repeat; background-position: top;">
        <div class="container text-center">
            <h1 class="page-title">My Profile</h1>
        </div>
    </section>

    <section class="seller-profile padding-large">
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
                                <li><a href="seller_dashboard.php">Dashboard</a></li>
                                <li><a href="my_projects.php">My Projects</a></li>
                                <li><a href="task_dashboard.php">Task Dashboard</a></li>
                                <li><a href="../actions/logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-md-9">
                    <!-- Account Balance -->
                    <div class="account-balance mb-4">
                        <h3>Account Balance</h3>
                        <p class="lead">₦<?php echo number_format($updated_account_balance, 2); ?></p>
                    </div>

                    <!-- Profile Details -->
                    <div class="profile-details mb-5">
                        <h3>Profile Details</h3>
                        <div class="profile-picture text-center mb-4">
                            <?php if ($seller_details['seller_image']): ?>
                                <img src="../uploads/profile_pictures/<?php echo htmlspecialchars($seller_details['seller_image']); ?>" alt="Profile Picture" class="img-thumbnail rounded-circle" width="150">
                            <?php else: ?>
                                <div class="placeholder-image d-flex justify-content-center align-items-center"
                                     style="width: 150px; height: 150px; background: #f0f0f0; border-radius: 50%; font-size: 16px; color: #888;">
                                    No Image
                                </div>
                                <p class="mt-2 text-muted">You haven't uploaded a profile picture yet.</p>
                            <?php endif; ?>
                        </div>
                        <form action="../actions/update_seller_action.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($seller_details['seller_name']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($seller_details['seller_email']); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" name="country" class="form-control" value="<?php echo htmlspecialchars($seller_details['seller_country']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" name="city" class="form-control" value="<?php echo htmlspecialchars($seller_details['seller_city']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="contact">Contact Number</label>
                                <input type="text" name="contact" class="form-control" value="<?php echo htmlspecialchars($seller_details['seller_contact']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="profile_picture">Profile Picture</label>
                                <input type="file" name="profile_picture" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">New Password (Optional)</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm New Password</label>
                                <input type="password" name="confirm_password" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>

                    <!-- Projects Collaborated -->
                    <div class="projects-collaborated">
                        <h3>Projects Collaborated</h3>
                        <?php if ($collaborated_projects): ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Category</th>
                                        <th>Role</th>
                                        <th>Takings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($collaborated_projects as $project): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($project['project_title']); ?></td>
                                            <td><?php echo htmlspecialchars($project['cat_name']); ?></td>
                                            <td><?php echo htmlspecialchars($project['role_name']); ?></td>
                                            <td><?php echo htmlspecialchars($project['takings']). "%"; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>No collaborated projects yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include "footer.php"; ?>
</body>

</html>
