<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require "../connection.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: forgot-password.php");
  exit;
}

$username = trim($_POST['username']);

$stmt = $conn->prepare(
  "SELECT id FROM admins WHERE username = ?"
);

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  die("No admin account found with this username.");
}

$token = bin2hex(random_bytes(32));
$expires = date("Y-m-d H:i:s", time() + 3600);

$update = $conn->prepare(
  "UPDATE admins 
   SET reset_token = ?, reset_expires = ?
   WHERE username = ?"
);

$update->bind_param("sss", $token, $expires, $username);
$update->execute();

$resetLink = "reset-password.php?token=" . urlencode($token);


echo "
  <h2>Password Reset</h2>
  <p>Use the link below to reset your password:</p>
  <a href='$resetLink'>$resetLink</a>
";
