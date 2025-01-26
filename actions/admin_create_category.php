<?php
require_once("../controllers/category_controller.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category_name'])) {
    $category_name = trim($_POST['category_name']);

    if (!empty($category_name)) {
        $result = addCategory($category_name);

        if ($result) {
            header("Location: ../view/admin_dashboard.php?success=category_created");
        } else {
            header("Location: ../view/admin_dashboard.php?error=category_creation_failed");
        }
    } else {
        header("Location: ../view/admin_dashboard.php?error=invalid_category_name");
    }
}
?>
