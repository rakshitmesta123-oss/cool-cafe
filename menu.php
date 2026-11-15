<?php
session_start(); require_once "db.php";
if($_SERVER["REQUEST_METHOD"]==="POST"){
 if(!isset($_SESSION["user_id"])){header("Location: login.php");exit;}
 $product_id=(int)($_POST["product_id"]??0);$quantity=max(1,min(20,(int)($_POST["quantity"]??1)));
 $stmt=$conn->prepare("SELECT id FROM products WHERE id=? AND available=1");$stmt->bind_param("i",$product_id);$stmt->execute();
 if($stmt->get_result()->num_rows){$ins=$conn->prepare("INSERT INTO orders(user_id,product_id,quantity) VALUES(?,?,?)");$ins->bind_param("iii",$_SESSION["user_id"],$product_id,$quantity);$ins->execute();header("Location: pay.php?order_id=".$conn->insert_id);exit;}
}
$items=$conn->query("SELECT * FROM products WHERE available=1 ORDER BY category,name");
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Menu | Cool Cafe</title><link rel="stylesheet" href="style.css"><script defer src="script.js"></script></head><body>
<header class="navbar"><a class="logo" href="index.php">☕ Cool Cafe</a><nav><a href="index.php">Home</a><a href="menu.php">Menu</a><?php if(isset($_SESSION["user_id"])): ?><a href="my_orders.php">My Orders</a><a href="logout.php">Logout</a><?php else: ?><a href="login.php">Login</a><?php endif; ?></nav></header>
<main class="container"><h1>Our Menu</h1><input id="menuSearch" class="search" type="search" placeholder="Search food or drinks..."><div class="products" id="menuItems">
<?php while($p=$items->fetch_assoc()): ?><article class="product menu-product" data-name="<?= htmlspecialchars(strtolower($p["name"]." ".$p["category"])) ?>"><div class="food-icon"><?= htmlspecialchars($p["emoji"]) ?></div><span class="category"><?= htmlspecialchars($p["category"]) ?></span><h3><?= htmlspecialchars($p["name"]) ?></h3><p><?= htmlspecialchars($p["description"]) ?></p><strong>₹<?= number_format((float)$p["price"],2) ?></strong>
<form method="post" class="order-form"><input type="hidden" name="product_id" value="<?= (int)$p["id"] ?>"><label>Qty <input type="number" name="quantity" value="1" min="1" max="20" required></label><button class="btn small" type="submit">Order</button></form></article><?php endwhile; ?></div></main><footer>© <?= date('Y') ?> Cool Cafe</footer></body></html>