<?php
require_once "../controllers/order_controller.php";
require_once "../controllers/project_controller.php";

session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['customer_id'])) {
    error_log("Session 'user' or 'customer_id' is not set.");
    echo "Session issue. Please log in again.";
    exit();
} else {
    error_log("Session customer_id: " . $_SESSION['user']['customer_id']);
}
$customer = $_SESSION['user'];
$customer_id = $customer['customer_id'];

$order_id =  getLastOrderId($customer_id);

if (!$order_id) {
    echo "Error: Order ID is missing.";
    exit();
}

// Fetch the projects associated with the order
$projects = fetchProjectsByOrder($order_id);

if (!$projects) {
    echo "Error: No projects found for this order.";
    echo "$order_id";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script>
        const popup = new PaystackPop()
        popup.resumeTransaction(access_code)               
    </script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
        }

        .order-success-container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .order-success-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .order-success-header h1 {
            font-size: 2.5rem;
            color: #28a745;
            font-weight: bold;
        }

        .order-success-header p {
            font-size: 1.1rem;
            color: #555;
        }

        .project-download-list {
            list-style-type: none;
            padding: 0;
        }

        .project-download-list li {
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f8f8f8;
        }

        .project-download-list li strong {
            font-size: 1.2rem;
            color: #333;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            margin-top: 20px;
            font-weight: bold;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
    <?php include "navbar2.php"; ?>

    <div class="order-success-container">
        <div class="order-success-header">
            <h1>Order Successful!</h1>
            <p>Thank you for your order. Your Order ID is: <strong><?php echo htmlspecialchars($order_id); ?></strong>.</p>
        </div>

        <div class="text-center">
            <h3>Download Your Purchased Projects</h3>
            <ul class="project-download-list">
                <?php foreach ($projects as $project): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($project['project_title']); ?></strong>
                        <form action="download_project_file.php" method="post" style="margin: 0;">
                            <input type="hidden" name="file_path" value="<?php echo htmlspecialchars($project['file']); ?>">
                            <button type="submit" class="btn btn-primary">Download</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="text-center">
            <a href="shop.php" class="btn btn-secondary">Continue Shopping</a>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 Byte Bazaar. All rights reserved.</p>
    </div>
</body>
</html>
