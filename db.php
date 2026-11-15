<?php
// XAMPP default: username=root, password is empty. Change these if your setup differs.
$host = "localhost";
$user = "root";
$password = "";
$database = "cool_cafe";
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>