<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ollsmpc";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
