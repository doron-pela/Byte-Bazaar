<?php
session_start();
require_once("../controllers/message_controller.php");

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$pm_id1 = $_SESSION['user']['seller_id'];
$pm_id2 = (int)$_POST['pm_id2'];
$text = $_POST['text'];

if (empty($text)) {
    $_SESSION['error'] = "Message text cannot be empty.";
    header("Location: ../view/task_management.php?project_id=" . $_POST['project_id']);
    exit();
}

// Send the message
if (sendMessage_ctr($pm_id1, $pm_id2, $text)) {
    $_SESSION['success'] = "Message sent successfully.";
} else {
    $_SESSION['error'] = "Failed to send message.";
}

header("Location: ../view/task_management.php?project_id=" . $_POST['project_id']);
exit();
?>
