<?php
session_start();

if (!isset($_SESSION['username'])) {
	header("Location: custLogin.php");
	exit();
}

$username = $_SESSION['username'];
$page = $_GET['page'] ?? 'details';

$conn = new mysqli("localhost", "root", "", "is420_store");
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM usrnames WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$email = $user['Email'];
$password = $user['Password'];

$orders = [];

$stmt = $conn->prepare("SELECT * FROM orders WHERE username = ? ORDER BY order_date DESC");
$stmt->bind_param("s", $username);
$stmt->execute();
$orderResult = $stmt->get_result();

while ($order = $orderResult->fetch_assoc()) {
	$orderId = $order['order_id'];

	$itemStmt = $conn->prepare("SELECT item_name, qty, price FROM order_items WHERE order_id = ?");
	$itemStmt->bind_param("i", $orderId);
	$itemStmt->execute();
	$itemResult = $itemStmt->get_result();

	$items = [];
	while ($item = $itemResult->fetch_assoc()) {
		$items[] = $item;
	}

	$orders[] = [
		"total" => $order['total'],
		"items" => $order['items'],
		"date" => $order['order_date'],
		"details" => $items
	];
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Account Settings</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			display: flex;
			margin: 0;
		}
		.sidebar {
			width: 200px;
			background-color: #f0f0f0;
			height: 100vh;
			padding-top: 20px;
		}
		.sidebar a {
			display: block;
			padding: 15px;
			text-decoration: none;
			color: #333;
		}
		.sidebar a:hover {
			background-color: #ddd;
		}
		.content {
			flex-grow: 1;
			padding: 20px;
		}
		.top-bar {
			background-color: #007BFF;
			color: white;
			padding: 10px 20px;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}
		.menu-icon {
            font-size: 26px;
            cursor: pointer;
            margin-right: 20px;
        }

        .side-menu {
            height: 100%;
            width: 0;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #333;
            overflow-x: hidden;
            transition: 0.3s;
            padding-top: 60px;
            z-index: 1000;
        }

        .side-menu a {
            padding: 12px 20px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            transition: 0.2s;
        }

        .side-menu a:hover {
            background-color: #575757;
        }
		.order-box {
			border: 1px solid #ccc;
			margin-bottom: 15px;
			padding: 15px;
			background-color: #fafafa;
		}
		.order-details {
			margin-left: 20px;
			font-size: 14px;
		}
		details.order-box {
			border: 1px solid #ccc;
			margin-bottom: 15px;
			padding: 15px;
			background-color: #fafafa;
			border-radius: 6px;
		}
		details.order-box summary {
			cursor: pointer;
			font-weight: bold;
			padding: 5px;
		}
		details.order-box[open] {
			background-color: #e6f0ff;
		}
	</style>
</head>
<body>


	

	<div class="sidebar">		
		<a href="accountSettings.php?page=details">Details</a>
		<a href="accountSettings.php?page=orders">Order History</a>
		<a href="viewCart.php">View Cart</a>
		<a href="store.php">Home</a>
	</div>

	<div class="content">
		<div class="top-bar">
			<span class="menu-icon" onclick="toggleMenu()">&#9776;</span>
			<div id="sideMenu" class="side-menu">
        		<a href="store.php" onClick="window.location=this.href">Home</a>
        		<a href="category.php?cat=Electronics" onclick="window.location=this.href;">Electronics</a>
        		<a href="category.php?cat=Groceries">Groceries</a>
        		<a href="category.php?cat=Home Goods">Home Goods</a>
        		<a href="accountSettings.php">Account Settings</a>
        		<a href="index.php">Logout</a>
    		</div>
			<div>Logged in as: <?php echo htmlspecialchars($username); ?></div>
			<form action="viewCart.php" method="get" style="margin: 0;">
            <button type="submit" style=
            "background-color: white;
            color: #0077cc;
            border: 2px solid #0077cc;
            padding: 8px 14px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            ">View Cart</button>
        </form>
		</div>

		<?php if ($page == "details"): ?>
			<h2>Account Details</h2>
			<p>Username: <?php echo htmlspecialchars($username); ?>
			<p>Password: <?php echo htmlspecialchars($password); ?></p>
			<p>Email: <?php echo htmlspecialchars($email); ?></p>
		<?php elseif ($page == "orders"): ?>
			<h2>Recent Orders</h2>
			<?php foreach ($orders as $index => $order): ?>
				<details class="order-box">
					<summary>
						<strong>Date:</strong> <?php echo $order['date']; ?> |
						<strong>Total:</strong> <?php echo $order['total']; ?> |
						<strong>Items:</strong> <?php echo $order['items']; ?>
					
				</summary>
					<div class="order-details">
						<ul>
							<?php foreach ($order['details'] as $item): ?>
								<li><?php echo $item['qty'] . " x " . $item['item_name'] . " - " . $item['price']; ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
					</details>
					<?php endforeach; ?>
					<?php endif; ?>
				</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
        const sidemenu = document.getElementById("sideMenu");        

        function toggleMenu() {
            var menu = document.getElementById("sideMenu");
            if (menu.style.width === "250px") {
                menu.style.width = "0";
            } else {
                menu.style.width = "250px";
            }
        }

        document.addEventListener("click", function(event) {
            const isClickInsideMenu = sideMenu.contains(event.target);
            const isClickOnIcon = event.target.classList.contains("menu-icon");

            if (!isClickInsideMenu && !isClickOnIcon) {
                sideMenu.style.width = "0";
            }
        });        
    </script>

			</body>
			</html>
