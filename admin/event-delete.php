<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "../connection.php";

$id = $_GET['id'] ?? '';

if ($id) {
    mysqli_query($conn, "DELETE FROM events WHERE id=$id");
}

header("Location: events.php");
exit;
