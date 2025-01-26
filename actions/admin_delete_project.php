<?php
require_once("../controllers/project_controller.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['project_id'])) {
    $project_id = (int) $_POST['project_id'];

    if ($project_id > 0) {
        $result = deleteProject($project_id);

        if ($result) {
            header("Location: ../view/admin_dashboard.php?success=project_deleted");
        } else {
            header("Location: ../view/admin_dashboard.php?error=project_deletion_failed");
        }
    } else {
        header("Location: ../view/admin_dashboard.php?error=invalid_project_id");
    }
}
?>
