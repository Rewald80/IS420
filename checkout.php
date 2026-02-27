<?php
session_start();

$customerName = $_SESSION['customerName'] ?? 'Guest';
$customerEmail = $_SESSION['customerEmail'] ?? 'guest@em.ail';
$username = $_SESSION['username'] ?? 'guest';
$cart = $_SESSION['cart'] ?? [];

$totalItems = 0;
$totalCost = 0;

foreach ($cart as $item) {
    $totalItems += $item['quantity'];
    $totalCost += $item['price'] * $item['quantity'];
}

if (!empty($cart)) {
	$conn = new mysqli("localhost", "root", "", "is420_store");
	if ($conn->connect_error) {
		die("Database connection failed: " . $conn->connect_error);
	}

	$stmt = $conn->prepare("INSERT INTO orders (username, total, items, order_date) VALUES (?, ?, ?, NOW())");
	$stmt->bind_param("sdi", $username, $totalCost, $totalItems);
	$stmt->execute();
	$orderId = $conn->insert_id;

	$itemStmt = $conn->prepare("INSERT INTO order_items (order_id, item_name, qty, price) VALUES (?, ?, ?, ?)");
    foreach ($cart as $item) {
    	$itemName = $item['name'];
    	$qty = $item['quantity'];
    	$price = $item['price'];
    	$itemStmt->bind_param("isid", $orderId, $itemName, $qty, $price);
    	$itemStmt->execute();
}

$itemStmt->close();
$stmt->close();
$conn->close();
}

$_SESSION['cart'] = [];
?>


<!DOCTYPE html>
<html>
<head>
	<title>Checkout - IS420 Store</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 0;
			background-color: #f0f0f0;
		}
		.confimation {
			max-width: 600px;
			margin: 40px auto;
			background-color: white;
			padding: 30px;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0,0,0,0.1);
		}
		.confimation h2 {
			color: #0077cc;
		}
		.btn {
			margin-top: 20px;
			display: inline-block;
			padding: 10px 20px;
			background-color: #0077cc;
			color: white;
			text-decoration: none;
			border-radius: 5px;
		}
		.btn:hover {
			background-color: #005fa3;
		}
	</style>
</head>
<body>

	<div class="confimation">
		<h2>Thank you, <?php echo htmlspecialchars($customerName); ?>!</h2>
		<p>Your order has been recieved.</p>
		<p>Items ordered: <?php echo $totalItems; ?></p>
		<p>Total paid: <?php echo $totalCost; ?></p>

		<a class="btn" href="store.php">Return to Store</a>
	</div>
</body>
</html>
