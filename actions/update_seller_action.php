<?php
session_start();
require_once("../controllers/user_controller.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $seller_id = $_SESSION['user']['seller_id'];

    $seller_name = $_POST['name'] ?? null;
    $country = $_POST['country'] ?? null;
    $city = $_POST['city'] ?? null;
    $contact_no = $_POST['contact'] ?? null;
    $password = $_POST['password'] ?? null;
    $confirm_password = $_POST['confirm_password'] ?? null;
    $profile_picture = null;

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = "../uploads/profile_pictures/";
        $file_tmp = $_FILES['profile_picture']['tmp_name'];
        $file_ext = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $new_file_name = "seller_{$seller_id}_" . time() . ".$file_ext";
        if (move_uploaded_file($file_tmp, $upload_dir . $new_file_name)) {
            $profile_picture = $new_file_name;
        }
    }

    // Validate passwords
    if ($password && $password === $confirm_password) {
        $password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $password = null; // Do not update if empty or mismatch
    }

    if (updateSellerProfile_ctr($seller_id, $seller_name, $country, $city, $contact_no, $profile_picture, $password)) {
        header("Location: ../view/seller_profile.php?success=Profile updated successfully.");
    } else {
        header("Location: ../view/seller_profile.php?error=Error updating profile. Please try again.");
    }
    exit();
}
