<?php
require_once("../controllers/user_controller.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['seller_id'])) {
    $seller_id = (int) $_POST['seller_id'];

    if ($seller_id > 0) {
        $result = deleteSeller($seller_id);

        if ($result) {
            header("Location: ../view/admin_dashboard.php?success=seller_deleted");
        } else {
            header("Location: ../view/admin_dashboard.php?error=seller_deletion_failed");
        }
    } else {
        header("Location: ../view/admin_dashboard.php?error=invalid_seller_id");
    }
}
?>
