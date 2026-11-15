<?php
session_start();
require_once "db.php";
$result = $conn->query("SELECT * FROM products WHERE available=1 ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cool Cafe | Home</title><link rel="stylesheet" href="style.css">
</head>
<body>
<header class="navbar"><a class="logo" href="index.php">☕ Cool Cafe</a>
<nav><a href="index.php">Home</a><a href="menu.php">Menu</a>
<?php if(isset($_SESSION['user_id'])): ?><a href="my_orders.php">My Orders</a><a href="logout.php">Logout</a>
<?php else: ?><a href="login.php">Login</a><a href="register.php">Register</a><?php endif; ?></nav></header>
<section class="hero"><div><p class="eyebrow">FRESH • TASTY • MADE WITH LOVE</p><h1>Your favourite food,<br>one click away.</h1><p>Enjoy delicious snacks, meals and refreshing drinks at Cool Cafe.</p><a class="btn" href="menu.php">Explore Menu</a></div></section>
<main class="container"><h2>Popular menu</h2><div class="products">
<?php while($p=$result->fetch_assoc()): ?>
<article class="product"><div class="food-icon"><?= htmlspecialchars($p['emoji']) ?></div><h3><?= htmlspecialchars($p['name']) ?></h3><p><?= htmlspecialchars($p['description']) ?></p><strong>₹<?= number_format((float)$p['price'],2) ?></strong><a class="btn small" href="menu.php">Order now</a></article>
<?php endwhile; ?>
</div></main><footer>© <?= date('Y') ?> Cool Cafe. Made with care.</footer>
</body></html>