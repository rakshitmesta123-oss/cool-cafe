<?php
session_start(); require_once "db.php"; $error="";
if($_SERVER["REQUEST_METHOD"]==="POST"){
  $email=trim($_POST["email"]??"");$password=$_POST["password"]??"";
  $stmt=$conn->prepare("SELECT id,name,password FROM users WHERE email=?");$stmt->bind_param("s",$email);$stmt->execute();$user=$stmt->get_result()->fetch_assoc();
  if($user && password_verify($password,$user["password"])){session_regenerate_id(true);$_SESSION["user_id"]=$user["id"];$_SESSION["user_name"]=$user["name"];header("Location: menu.php");exit;}
  $error="Incorrect email or password.";
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login | Cool Cafe</title><link rel="stylesheet" href="style.css"></head><body>
<header class="navbar"><a class="logo" href="index.php">☕ Cool Cafe</a><nav><a href="index.php">Home</a><a href="menu.php">Menu</a><a href="register.php">Register</a></nav></header>
<main class="form-wrap"><form class="form-card" method="post"><h1>Welcome back</h1><?php if(isset($_GET["registered"])): ?><p class="success">Registration successful. Please log in.</p><?php endif; ?><?php if($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<label>Email</label><input type="email" name="email" required><label>Password</label><input type="password" name="password" required><button class="btn" type="submit">Login</button><p>New here? <a href="register.php">Create account</a></p></form></main></body></html>