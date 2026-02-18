<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "../connection.php";
session_start();

if (!isset($_SESSION['admin_id'])) {
    http_response_code(403);
    exit;
}

if (!empty($_FILES['file']['name'])) {

    $filename = time() . "_" . basename($_FILES['file']['name']);
    $target = "../uploads/ads/" . $filename;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {

        $stmt = $conn->prepare(
          "INSERT INTO homepage_ads (image, status) VALUES (?, 'active')"
        );
        $stmt->bind_param("s", $filename);
        $stmt->execute();

        echo "success";
    }
}
