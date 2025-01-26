<?php 
session_start();
include_once("../controllers/project_controller.php");
include_once("../controllers/category_controller.php");

// Ensure the user is logged in as a customer
if (!isset($_SESSION['user']) || $_SESSION['user']['bb_role'] != 1) {
    header("Location: login.php");
    exit();
}

// Fetch the logged-in customer's details
$customer = $_SESSION['user'];
$customer_id = $customer['customer_id'];

// Get filtering parameters from the GET request
$filter_keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$filter_min_price = isset($_GET['min_price']) ? $_GET['min_price'] : '';
$filter_max_price = isset($_GET['max_price']) ? $_GET['max_price'] : '';
$filter_category = isset($_GET['category_id']) ? $_GET['category_id'] : '';

// Fetch published projects with filters
$filtered_projects = fetchPublishedProjectsBy($filter_keyword, $filter_min_price, $filter_max_price, $filter_category);

// Fetch all categories
$categories = viewAllCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Byte Bazaar - Digital Store</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="icomoon/icomoon.css">
    <link rel="stylesheet" type="text/css" href="css/vendor.css">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <style>
        /* Product Grid */
        .product-store {
            margin-top: 30px;
        }

        .product-item {
            background: #fff;
            border-radius: 8px;
            margin: 10px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .product-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .product img {
            max-width: 100%;
            transition: transform 0.3s ease;
        }

        .product img:hover {
            transform: scale(1.1);
        }

        .product-info {
            padding: 20px;
            text-align: center;
        }

        .product-info h2 {
            font-size: 1.25rem;
            color: #333;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .product-info .price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #555;
        }

        .product-actions {
            margin-top: 20px;
        }

        /* Button Styling */
        .product-actions button, .product-actions a {
            background: #000;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .product-actions button:hover, .product-actions a:hover {
            background: #fff;
            color: #000;
            border: 1px solid #000;
        }

        /* Sidebar Styling */
        .sidebar {
            padding: 15px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .sidebar h5 {
            font-weight: bold;
            color: #333;
        }

        .sidebar .form-control {
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .sidebar .btn {
            background: #000;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .sidebar .btn:hover {
            background: #fff;
            color: #000;
            border: 1px solid #000;
        }

        /* Responsive Styling */
        @media (max-width: 768px) {
            .product-item {
                margin: 5px;
            }

            .sidebar {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
<?php include "navbar.php"; ?>

<section class="site-banner jarallax min-height300 padding-large" style="background: url(images/hero-image.jpg) no-repeat; background-position: top;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title">Shop Page</h1>
                <div class="breadcrumbs">
                    <span class="item">
                        <a href="../index.php">Home /</a>
                    </span>
                    <span class="item">Shop</span>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="shopify-grid padding-large">
    <div class="container">
        <div class="row">
            <!-- Sidebar Filters -->
            <aside class="col-md-3">
                <div class="sidebar">
                    <!-- Filter by Categories -->
                    <div class="widgets">
                        <h5 class="widget-title">Filter by Categories</h5>
                        <form method="GET" action="shop.php">
                            <select name="category_id" class="form-control mb-2">
                                <option value="">All Categories</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo htmlspecialchars($category['cat_id']); ?>" <?php echo $filter_category == $category['cat_id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($category['cat_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">Apply Filter</button>
                        </form>
                    </div>

                    <!-- Filter by Keywords -->
                    <div class="widgets">
                        <h5 class="widget-title">Filter by Keywords</h5>
                        <form method="GET" action="shop.php">
                            <input type="text" name="keyword" placeholder="Enter keyword" class="form-control mb-2" value="<?php echo htmlspecialchars($filter_keyword); ?>">
                            <button type="submit" class="btn btn-primary btn-sm">Apply Filter</button>
                        </form>
                    </div>

                    <!-- Filter by Price -->
                    <div class="widgets">
                        <h5 class="widget-title">Filter by Price</h5>
                        <form method="GET" action="shop.php">
                            <input type="number" name="min_price" placeholder="Min price" class="form-control mb-2" value="<?php echo htmlspecialchars($filter_min_price); ?>">
                            <input type="number" name="max_price" placeholder="Max price" class="form-control mb-2" value="<?php echo htmlspecialchars($filter_max_price); ?>">
                            <button type="submit" class="btn btn-primary btn-sm">Apply Filter</button>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Main Products Section -->
            <section id="selling-products" class="col-md-9 product-store">
                <div class="container">
                    <!-- Product Grid -->
                    <div class="row d-flex flex-wrap">
                        <?php if (!empty($filtered_projects)): ?>
                            <?php foreach ($filtered_projects as $project): ?>
                                <div class="product-item col-lg-4 col-md-6 col-sm-6">
                                    <article class="product">
                                        <img src="../uploads/projects/<?php echo htmlspecialchars($project['project_image']); ?>" alt="<?php echo htmlspecialchars($project['project_title']); ?>">
                                        <div class="product-info">
                                            <h2><?php echo htmlspecialchars($project['project_title']); ?></h2>
                                            <p class="description"><?php echo htmlspecialchars($project['project_desc']); ?></p>
                                            <p class="price">$<?php echo number_format($project['project_price'], 2); ?></p>
                                            <div class="product-actions">
                                                <form action="../actions/add_to_cart_action.php" method="POST" style="display:inline;">
                                                    <input type="hidden" name="project_id" value="<?php echo htmlspecialchars($project['project_id']); ?>">
                                                    <input type="hidden" name="customer_id" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>">
                                                    <button type="submit" class="btn-wrap cart-link d-flex align-items-center">
                                                        Add to Cart <i class="icon icon-arrow-io"></i>
                                                    </button>
                                                </form>
                                                <a href="customer_project_details.php?project_id=<?php echo $project['project_id']; ?>" class="btn-want">Project Details</a>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-center">No projects match your filter criteria.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
</body>
</html>
