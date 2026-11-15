<?php
session_start(); require_once "db.php";
$error="";
if($_SERVER["REQUEST_METHOD"]==="POST"){
  $name=trim($_POST["name"]??""); $email=trim($_POST["email"]??"");
  $password=$_POST["password"]??"";
  if($name==="" || !filter_var($email,FILTER_VALIDATE_EMAIL) || strlen($password)<6){$error="Enter a name, valid email and password (at least 6 characters).";}
  else{
    $check=$conn->prepare("SELECT id FROM users WHERE email=?"); $check->bind_param("s",$email); $check->execute();
    if($check->get_result()->num_rows){$error="This email is already registered.";}
    else{$hash=password_hash($password,PASSWORD_DEFAULT);$stmt=$conn->prepare("INSERT INTO users(name,email,password) VALUES(?,?,?)");$stmt->bind_param("sss",$name,$email,$hash);$stmt->execute();header("Location: login.php?registered=1");exit;}
  }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Register | Cool Cafe</title><link rel="stylesheet" href="style.css"></head><body>
<header class="navbar"><a class="logo" href="index.php">☕ Cool Cafe</a><nav><a href="index.php">Home</a><a href="menu.php">Menu</a><a href="login.php">Login</a></nav></header>
<main class="form-wrap"><form class="form-card" method="post"><h1>Create account</h1><?php if($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<label>Full name</label><input name="name" required maxlength="100"><label>Email</label><input type="email" name="email" required><label>Password</label><input type="password" name="password" minlength="6" required><button class="btn" type="submit">Register</button><p>Already registered? <a href="login.php">Login</a></p></form></main></body></html>