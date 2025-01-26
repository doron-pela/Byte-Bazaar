<?php
require("../controllers/user_controller.php");

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start output buffering to prevent header issues
ob_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email, password, and role are set and not empty
    if (
        isset($_POST["email"], $_POST["password"], $_POST["role"]) &&
        !empty($_POST["email"]) &&
        !empty($_POST["password"]) &&
        in_array($_POST["role"], ['1', '2', '3']) // Ensure valid roles
    ) {
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);
        $role = $_POST["role"];

        // Initialize the user variable
        $user = null;

        // Determine the login method based on the selected role
        switch ($role) {
            case '1': // Customer
                $user = loginCustomer_ctr($email, $password);
                break;
            case '2': // Seller
                $user = loginSeller_ctr($email, $password);
                break;
            case '3': // Admin
                $user = loginAdmin_ctr($email, $password);
                break;
            default:
                // Invalid role handling
                header("Location: ../view/login.php?error=invalid_role");
                exit();
        }

        // Check if login was successful
        if ($user) {
            // Start the session
            session_start();
            $_SESSION['user'] = $user;
            $_SESSION['role'] = (int) $role;

            

            // Redirect based on role
            switch ($role) {
                case '1': // Customer
                    
                    $_SESSION['user_id'] = $user['customer_id'];
                    
                    header("Location: ../view/shop.php");
                    break;

                case '2': // Seller
                    $_SESSION['user_id'] = $user['seller_id'];
                    header("Location: ../view/seller_dashboard.php");
                    break;

                case '3': // Admin
                    $_SESSION['user_id'] = $user['admin_id'];
                    header("Location: ../view/admin_dashboard.php");
                    break;
            }
            exit();
        } else {
            // Redirect to login page with error
            header("Location: ../view/login.php?error=invalid_credentials");
            exit();
        }
    } else {
        // Redirect if required fields are missing or invalid
        header("Location: ../view/login.php?error=missing_fields");
        exit();
    }
} else {
    // Redirect to login if the request method is not POST
    header("Location: ../view/login.php");
    exit();
}
