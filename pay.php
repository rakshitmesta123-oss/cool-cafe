<?php
session_start();
include 'db.php';

$id = (int) $_GET['order_id'];
$stmt = $conn->prepare("SELECT p.price * o.quantity AS total FROM orders o JOIN products p ON p.id = o.product_id WHERE o.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

$upi  = "Rakshit@uboi";  // PUT YOUR REAL UPI ID HERE
$link = "upi://pay?pa=$upi&pn=Cool%20Cafe&am={$order['total']}&cu=INR&tn=Order$id";
?>
<div style="text-align:center; font-family:Arial; margin-top:40px;">
  <h2>Pay ₹<?= $order['total'] ?></h2>
  <div id="qr" style="display:inline-block;"></div>
  <p>Scan with PhonePe / GPay / Paytm</p>
  <p><a href="<?= $link ?>">Or tap here to pay on phone</a></p>
  <p><a href="my_orders.php">I have paid, go to My Orders</a></p>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>new QRCode(document.getElementById("qr"), "<?= $link ?>");</script>