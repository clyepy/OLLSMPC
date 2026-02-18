<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "../connection.php";

header('Content-Type: application/json');

// Check if ID exists
if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'No ID provided'
    ]);
    exit;
}

$id = intval($_POST['id']);

// Get current status
$result = $conn->query("SELECT status FROM homepage_ads WHERE id=$id");

if (!$result || $result->num_rows == 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Ad not found'
    ]);
    exit;
}

$row = $result->fetch_assoc();
$current = $row['status'];

// Toggle
$newStatus = ($current === 'active') ? 'inactive' : 'active';

// Update
$conn->query("UPDATE homepage_ads SET status='$newStatus' WHERE id=$id");

// Return response
echo json_encode([
    'success' => true,
    'status' => $newStatus
]);
