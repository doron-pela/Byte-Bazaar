<?php
session_start();
require_once("../controllers/message_controller.php");

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$message_id = (int)$_POST['message_id'];

// Delete the message
if (deleteMessage_ctr($message_id)) {
    $_SESSION['success'] = "Message deleted successfully.";
} else {
    $_SESSION['error'] = "Failed to delete message.";
}

header("Location: task_management.php?project_id=" . $_POST['project_id']);
exit();
?>
