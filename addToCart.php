<?php
session_start();

if (!isset($_SESSION['cart'])) {
	$_SESSION['cart'] = [];
}

if (!isset($_POST['id'], $_POST['name'], $_POST['price'])) {
	die("Missing product info.");
}

$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['quantity'] += 1;
} else {
    $_SESSION['cart'][$id] = [
        'id' => $id,
        'name' => $name,
        'price' => $price,
        'quantity' => 1
    ];
}

$referrer = $_SERVER['HTTP_REFERER'];
$redirectUrl = $referrer . (strpos($referrer, '?') ? '&' : '?') . 'added=' . urlencode($name);
header("Location: $redirectUrl");
exit();
?>