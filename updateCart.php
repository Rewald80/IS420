<?php
session_start();

if(!isset($_SESSION['cart'])) {
	$_SESSION['cart'] = [];
}

if (isset($_POST['id'], $_POST['quantity'])) {
	$id = $_POST['id'];
	$quantity = (int)$_POST['quantity'];

	if ($quantity <= 0) {
		unset($_SESSION['cart'][$id]);
	} elseif (isset($_SESSION['cart'][$id])) {
			$_SESSION['cart'][$id]['quantity'] = $quantity;
		}
	}

header("Location: viewCart.php");
exit();
?>