<?php
session_start();
require_once "db.php";

if (isset($_SESSION["user_id"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
  $id   = (int) ($_POST["order_id"] ?? 0);
  $user = (int) $_SESSION["user_id"];
  $stmt = $conn->prepare("DELETE FROM orders WHERE id = ? AND user_id = ?");
  $stmt->bind_param("ii", $id, $user);
  $stmt->execute();
}
header("Location: my_orders.php");
exit;