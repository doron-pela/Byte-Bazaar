<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file_path = isset($_POST['file_path']) ? $_POST['file_path'] : null;

    if (!$file_path) {
        echo "Error: No file specified.";
        exit();
    }

    // Define the base upload directory
    $upload_dir = "../uploads/projects/";
    $full_path = $upload_dir . $file_path;

    // Ensure the file exists
    if (!file_exists($full_path)) {
        echo "Error: File not found.";
        exit();
    }

    // Send headers to force the file download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($full_path) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($full_path));

    // Read the file and send it to the output buffer
    readfile($full_path);
    exit();
}
?>
