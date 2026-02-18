<?php
include "../connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $name    = trim($_POST['name'] ?? '');
  $email   = trim($_POST['email'] ?? '');
  $phone   = trim($_POST['phone'] ?? '');
  $subject = trim($_POST['subject'] ?? '');
  $message = trim($_POST['message'] ?? '');

  if (!$name || !$email || !$phone || !$subject || !$message) {
    http_response_code(400);
    echo "Missing fields";
    exit;
  }

  $stmt = $conn->prepare("
    INSERT INTO contact_messages (name, email, phone, subject, message)
    VALUES (?, ?, ?, ?, ?)
  ");
  $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);
  $stmt->execute();

  echo "OK";
}

