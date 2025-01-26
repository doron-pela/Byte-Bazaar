<?php
require_once("../controllers/user_controller.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['customer_id'])) {
    $customer_id = (int) $_POST['customer_id'];

    if ($customer_id > 0) {
        $result = deleteCustomer($customer_id);

        if ($result) {
            header("Location: ../view/admin_dashboard.php?success=customer_deleted");
        } else {
            header("Location: ../view/admin_dashboard.php?error=customer_deletion_failed");
        }
    } else {
        header("Location: ../view/admin_dashboard.php?error=invalid_customer_id");
    }
}
?>
