<?php
session_start();
include 'config/conn.php';
$MSG = $_GET['message'] ?? '';

$order_id = $_GET['order_id'];


if (!isset($_GET['order_id'])) {
    die("Invalid Order");
}




$orderQuery = "SELECT * FROM orders WHERE id = ?";
$stmt = $conn->prepare($orderQuery);
$stmt->execute([$order_id]);

$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    die("Order Not Found");
}



$itemQuery = "SELECT `oi`.*, `p`.`product_name`
FROM `order_items` `oi`
JOIN `products`  `p` ON `oi`.`product_id` = `p`.`id`
WHERE `oi`.`order_id` = ?";

$stmt = $conn->prepare($itemQuery);
$stmt->execute([$order_id]);

$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>



<!DOCTYPE html>
<html>
<head>
<title>Invoice</title>
<?php
include 'config/css-links.php';
?>
<style>

body{
    font-family:Arial;
    background:#f5f5f5;
}

.invoice{
    width:900px;
    margin:30px auto;
    background:#fff;
    padding:30px;
    box-shadow:0 0 10px #ccc;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th,
table td{
    border:1px solid #ddd;
    padding:10px;
}

table th{
    background:#333;
    color:#fff;
}

h2{
    margin-bottom:20px;
}

</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

<div class="invoice">

<h2>Invoice #<?= $order['id']; ?></h2>

<p><strong>Name:</strong>
<?= $order['first_name']." ".$order['last_name']; ?>
</p>

<p><strong>Phone:</strong>
<?= $order['phone']; ?>
</p>

<p><strong>Email:</strong>
<?= $order['email']; ?>
</p>

<p><strong>Address:</strong>
<?= $order['shipping_address']; ?>
</p>

<p><strong>Payment:</strong>
<?= $order['payment_method']; ?>
</p>

<table>

<tr>

<th>Product</th>

<th>Qty</th>

<th>Price</th>

<th>Total</th>

</tr>

<?php

$grand=0;

foreach($items as $item){

$total=$item['price']*$item['quantity'];

$grand += $total;

?>

<tr>

<td><?= $item['product_name']; ?></td>

<td><?= $item['quantity']; ?></td>

<td>Rs <?= $item['price']; ?></td>

<td>Rs <?= $total; ?></td>

</tr>

<?php } ?>

<tr>

<td colspan="3" align="right"><strong>Grand Total</strong></td>

<td><strong>Rs <?= $grand; ?></strong></td>

</tr>

</table>

<br>

<a href="#" onclick="window.print()">
    <i class="bi bi-printer" style="cursor:pointer;font-size:24px;"></i>
    
</a>

<a href="index.php" style="margin-left: 20px;">
    <i class="bi bi-arrow-left"></i>
</a>
</div>

</body>
</html>