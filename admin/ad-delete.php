<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "../connection.php";

$id = intval($_GET['id']);

$res = $conn->query(
  "SELECT image FROM homepage_ads WHERE id=$id"
);

if ($row = $res->fetch_assoc()) {
    $file = "../uploads/ads/" . $row['image'];
    if (file_exists($file)) unlink($file);
    $conn->query("DELETE FROM homepage_ads WHERE id=$id");
}

header("Location: manage-homepage.php");
