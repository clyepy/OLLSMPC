<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require "../connection.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: forgot-password.php");
  exit;
}

$token = $_POST['token'] ?? '';
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm'] ?? '';

if (!$token || !$password || !$confirm) {
  die("All fields are required.");
}

if ($password !== $confirm) {
  die("Passwords do not match.");
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare(
  "SELECT id FROM admins WHERE reset_token = ? AND reset_expires > NOW()"
);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  die("Invalid or expired token.");
}

$admin = $result->fetch_assoc();

$update = $conn->prepare(
  "UPDATE admins 
   SET password = ?, reset_token = NULL, reset_expires = NULL 
   WHERE id = ?"
);
$update->bind_param("si", $hash, $admin['id']);
$update->execute();

echo "Password successfully updated. <a href='index.php'>Login</a>";
