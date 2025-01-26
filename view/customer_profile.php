<?php
session_start();
require_once("../controllers/user_controller.php");

// Ensure the user is logged in as a customer
if (!isset($_SESSION['user']) || $_SESSION['role'] != 1) {
    header("Location: login.php");
    exit();
}

$customer = $_SESSION['user'];
$customer_id = $customer['customer_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>
<body>
<section class="profile-section padding-large">
    <div class="container">
        <h1>Customer Profile</h1>
        <form action="../actions/update_customer_action.php" method="post">
            <div class="form-group">
                <label for="customer_name">Full Name</label>
                <input type="text" name="customer_name" class="form-control" value="<?php echo $customer['customer_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $customer['customer_email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="country">Country</label>
                <input type="text" name="country" class="form-control" value="<?php echo $customer['customer_country']; ?>" required>
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" name="city" class="form-control" value="<?php echo $customer['customer_city']; ?>" required>
            </div>
            <div class="form-group">
                <label for="contact_no">Contact Number</label>
                <input type="text" name="contact_no" class="form-control" value="<?php echo $customer['customer_contact']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</section>
</body>
</html>
