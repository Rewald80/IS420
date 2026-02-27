<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // If the item exists in the cart, remove it
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
}

header("Location: viewCart.php");
exit();
?>
