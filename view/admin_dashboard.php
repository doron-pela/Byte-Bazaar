<?php
session_start();
include("../controllers/category_controller.php");
include("../controllers/project_controller.php");
include("../controllers/user_controller.php");

// Check if user is admin
if (!isset($_SESSION['user']) || $_SESSION['user']['bb_role'] != 3) {
    header("Location: login.php");
    exit();
}

// Fetch existing categories, projects, customers, and sellers
$categories = viewCategories();
$projects = fetchAllProjects();
$customers = fetchAllCustomers();
$sellers = fetchAllSellers();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .section-title {
            margin-bottom: 20px;
            text-align: center;
            font-size: 1.5rem;
            color: #343a40;
            font-weight: bold;
            text-transform: uppercase;
        }

        .card {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .btn {
            border-radius: 50px;
        }

        .form-control {
            border-radius: 50px;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .btn-create {
            background-color: #28a745;
            color: white;
        }

        .btn-create:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <?php include "navbar2.php"; ?>

    <div class="dashboard-container">
        <h1 class="text-center text-primary mb-4">Admin Dashboard</h1>

        <!-- Manage Categories -->
        <section class="mb-5">
            <h2 class="section-title">Manage Categories</h2>
            <div class="card p-4 mb-3">
                <form action="../actions/admin_create_category.php" method="POST" class="form-inline justify-content-center">
                    <input type="text" name="category_name" id="category_name" placeholder="Enter Category Name" class="form-control mr-2" required>
                    <button type="submit" class="btn btn-create">Create Category</button>
                </form>
            </div>
            <div class="card p-4">
                <ul class="list-group">
                    <?php foreach ($categories as $category): ?>
                        <li class="list-group-item text-center"><?php echo htmlspecialchars($category['cat_name']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>

        <!-- Manage Projects -->
        <section class="mb-5">
            <h2 class="section-title">Manage Projects</h2>
            <div class="card p-4">
                <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Project ID</th>
                            <th>Project Title</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects as $project): ?>
                            <tr>
                                <td><?php echo $project['project_id']; ?></td>
                                <td><?php echo htmlspecialchars($project['project_title']); ?></td>
                                <td>
                                    <form action="../actions/admin_delete_project.php" method="POST" class="d-inline">
                                        <input type="hidden" name="project_id" value="<?php echo $project['project_id']; ?>">
                                        <button type="submit" class="btn btn-delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Manage Customers -->
        <section class="mb-5">
            <h2 class="section-title">Manage Customers</h2>
            <div class="card p-4">
                <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Customer ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td><?php echo $customer['customer_id']; ?></td>
                                <td><?php echo htmlspecialchars($customer['customer_name']); ?></td>
                                <td><?php echo htmlspecialchars($customer['customer_email']); ?></td>
                                <td>
                                    <form action="../actions/admin_delete_customer.php" method="POST" class="d-inline">
                                        <input type="hidden" name="customer_id" value="<?php echo $customer['customer_id']; ?>">
                                        <button type="submit" class="btn btn-delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Manage Sellers -->
        <section>
            <h2 class="section-title">Manage Sellers</h2>
            <div class="card p-4">
                <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Seller ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sellers as $seller): ?>
                            <tr>
                                <td><?php echo $seller['seller_id']; ?></td>
                                <td><?php echo htmlspecialchars($seller['seller_name']); ?></td>
                                <td><?php echo htmlspecialchars($seller['seller_email']); ?></td>
                                <td>
                                    <form action="../actions/admin_delete_seller.php" method="POST" class="d-inline">
                                        <input type="hidden" name="seller_id" value="<?php echo $seller['seller_id']; ?>">
                                        <button type="submit" class="btn btn-delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>
