<?php
session_destroy();

// Redirect to the login page or home page
header("Location: ../view/login.php"); // Or use index.php for the homepage
exit();
?>
