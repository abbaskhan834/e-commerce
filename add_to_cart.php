<?php
session_start();
$productId = $_GET['id'];

if (!isset($_SESSION['cart'])) {
    
    $_SESSION['cart'] = [];
    
}

if (isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId]++;
} else {
    $_SESSION['cart'][$productId] = 1;
    
   
}

if (isset($_SERVER['HTTP_REFERER'])) {

    header("Location: " . $_SERVER['HTTP_REFERER']);
    
} else {
    header("Location: index.php");
}

exit;
?>
