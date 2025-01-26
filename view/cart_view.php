<?php
include_once("../controllers/cart_controller.php");
include_once("../controllers/order_controller.php");
session_start(); // Ensure session is started for user verification

// Check if the user is logged in as a customer
if (!isset($_SESSION['user']) || $_SESSION['role'] != 1) {
    // If not a customer, log them out and redirect to login page
    session_destroy();
    header("Location: ../view/login.php?error=unauthorized_access");
    exit();
}

// Fetch the logged-in customer details
$customer = $_SESSION['user'];
$customer_id = $customer['customer_id'];

// Retrieve cart items
$cart_items = viewCart();

// Ensure $cart_items is an array
if (!is_array($cart_items)) {
    $cart_items = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .cart-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .cart-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .cart-header h1 {
            font-size: 2.5rem;
            color: #343a40;
        }

        .table {
            border-collapse: collapse;
            margin-bottom: 20px;
            width: 100%;
        }

        .table th, .table td {
            text-align: center;
            padding: 15px;
            vertical-align: middle;
        }

        .table th {
            background-color: #d6d8db;
            color: #343a40;
            border-radius: 10px 10px 0 0;
        }

        .table td {
            border-bottom: 1px solid #ddd;
        }

        .table th, .table td:not(:last-child) {
            padding-left: 20px;
            padding-right: 20px;
        }

        .form-section {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .form-section h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5rem;
            color: #343a40;
        }

        .btn-primary {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border-radius: 5px;
            background-color: #6c757d;
            border: none;
        }

        .btn-primary:hover {
            background-color: #5a6268;
        }

        .btn-danger {
            background-color: #868e96;
            border: none;
        }

        .btn-danger:hover {
            background-color: #6c757d;
        }

        .continue-shopping {
            text-align: center;
            margin-top: 20px;
        }

        .continue-shopping a {
            text-decoration: none;
            color: #6c757d;
            font-weight: bold;
        }

        .continue-shopping a:hover {
            text-decoration: underline;
        }

        .empty-cart {
            text-align: center;
            margin-top: 50px;
        }

        .empty-cart p {
            font-size: 1.5rem;
            color: #6c757d;
        }
    </style>
    <!-- <script src="https://js.paystack.co/v1/inline.js"></script> -->
</head>
<body>
    <?php include "navbar2.php"; ?>

    <div class="cart-container">
        <div class="cart-header">
            <h1>Your Cart</h1>
        </div>

        <?php if (count($cart_items) > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total_price = 0; 
                    foreach ($cart_items as $item): 
                        $item_total = $item['project_price'] * $item['qty'];
                        $total_price += $item_total;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['project_title']); ?></td>
                        <td><?php echo htmlspecialchars($item['qty']); ?></td>
                        <td>$<?php echo number_format($item['project_price'], 2); ?></td>
                        <td>$<?php echo number_format($item_total, 2); ?></td>
                        <td>
                            <form action="../actions/remove_from_cart_action.php" method="POST" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($item['project_id']); ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3"><strong>Total:</strong></td>
                        <td colspan="2"><strong>$<?php echo number_format($total_price, 2); ?></strong></td>
                    </tr>
                </tbody>
            </table>

            <div class="form-section">
                <h2>Proceed to Payment</h2>
                <form id="paymentForm" action="../actions/process_payment.php" method="POST">
                    <div class="form-group">
                        <label for="payment_reference">Payment Reference:</label>
                        <input type="text" name="payment_reference" id="payment_reference" class="form-control" placeholder="Enter a reference for payment" required>
                    </div>

                    
                    <!-- <input type="hidden" name="customer_name" value="<?php /*echo htmlspecialchars($customer['customer_name']); ?>">
                    <input type="hidden" name="customer_email" value="<?php echo htmlspecialchars($customer['customer_email']); ?>">
                    <input type="hidden" name="customer_contact" value="<?php echo htmlspecialchars($customer['customer_contact']); */?>">-->
                    <input type="hidden" name="total_price" value="<?php echo $total_price; ?>"> 
                    <input type="hidden" name="currency" value="₦"> 

                    <button id="pay-now" type="submit" onclick="payWithPaystack()" class="btn btn-primary">Pay Now</button>
                    
                </form>
                
            </div>
        <?php else: ?>
            <div class="empty-cart">
                <p>Your cart is empty.</p>
                <!-- <a href="shop.php" class="btn btn-primary">Continue Shopping</a> -->
            </div>
        <?php endif; ?>

        <div class="continue-shopping">
            <a href="shop.php">← Continue Shopping</a>
        </div>
    </div>

    <!-- <div class="form-section">
                <h2>Proceed to Payment</h2>
                <form action="../actions/process_payment.php" method="POST">
                    <div class="form-group">
                        <label for="payment_reference">Payment Reference:</label>
                        <input type="text" name="payment_reference" id="payment_reference" class="form-control" placeholder="Enter a reference for payment" required>
                    </div>

                    
                    <input type="hidden" name="customer_name" value="<?php /*echo htmlspecialchars($customer['customer_name']); ?>">
                    <input type="hidden" name="customer_email" value="<?php echo htmlspecialchars($customer['customer_email']); ?>">
                    <input type="hidden" name="customer_contact" value="<?php echo htmlspecialchars($customer['customer_contact']); ?>">
                    <input type="hidden" name="total_price" value="<?php echo $total_price; */?>">

                    <button type="submit" class="btn btn-primary">Pay Now</button>
                    
                </form>
    </div>-->
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script>
        var paymentForm = document.getElementById('paymentForm');

        paymentForm.addEventListener('submit', payWithPaystack, true);

        function payWithPaystack(e) {

            e.preventDefault();
            var handler = PaystackPop.setup({
                key: 'pk_test_a3490fd2768d0f6f1d5ab900a82d772c817851db', // Replace with your public key
                email: '<?php echo htmlspecialchars($customer["customer_email"]); ?>',
                amount: <?php echo $total_price * 100 ; ?>, // Dollar conversion to Naira amount
                currency: 'NGN', // Use GHS for Ghana Cedis or USD for US Dollars
                ref: "" + Math.floor(Math.random() * 1000000000 + 1), // Replace with a reference you generated
                callback: function(response) {
                    $.ajax({
                        url: "checkout_process.php?reference=" + response.reference, // Changed URL to lowercase
                        method: "GET", // Changed METHOD to lowercase
                        success: function (response) {
                            window.location.href = "../actions/process_payment.php";
                            // paymentForm.submit();
                        } // Removed extra closing parenthesis
                    }); // Closed the ajax call properly
                    // This happens after the payment is completed successfully
                    var reference = response.reference;
                    alert('Payment complete! Reference: ' + reference);
                    // Make an AJAX call to your server with the reference to verify the transaction
                },
                onClose: function() {
                    alert('Transaction was not completed, window closed.');
                } // Removed extra comma
            });
            handler.openIframe();
        }

    </script>

    <?php 
    $_SESSION['currency'] = "NGN";
    $_SESSION['total_price'] = $total_price;
    ?>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <?php include "footer.php"; ?>
</body>
</html>
