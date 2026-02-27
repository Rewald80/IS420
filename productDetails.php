<?php
session_start();

if (!isset($_GET['id'])) {
	header("Location: store.php");
	exit();
}

$product_id = $_GET['id'];

$conn = new mysqli("localhost", "root", "", "is420_store");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
	$stmt->bind_param("i", $product_id);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows === 0) {
		echo "Nothing here.";
		exit();
	}

	$product = $result->fetch_assoc();
	$imagePath= "images/" . $product['id'] . ".jpg";
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo htmlspecialchars($product['name']); ?> - Details</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 0px;
			background: #f9f9f9;
		}
		.header {
			background-color: #0077cc;
            color: white;
            padding: 15px;
            display: flex;
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
        .main {
        	padding: 20px;
        	display: flex;
        	flex-direction: column;
        	max-width: 800px;
        	margin: auto;
        	background: white;
        	border-radius: 8px;
        	text-align: center;
        	align-items: center;
        	box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .main img {
        	max-width: 400px;
        	height: auto;
        	margin-bottom: 20px;
        	border-radius: 8px;
        }
		.product-info {
			margin-top: 15px;
		}
		.product-info p {
			margin: 8px;
		}

		form button {
			margin-top: 10px;
			padding: 8px 14px;
			background-color: #0077cc;
			color: white;
			border: none;
			border-radius: 4px;
			cursor: pointer;
		}

		form button:hover {
			background-color: #005fa3;
		}
		.back-link {
			display: inline-block;
			margin-bottom: 15px;
			text-decoration: none;
			color: #007BFF;
		}
	</style>
</head>
<body>

		<div class="header">
			<span class="menu-icon" onclick="toggleMenu()">&#9776;</span>
			<h2 style="flex: 1;"><?php echo htmlspecialchars($product['name']); ?> - Details</h2>
			<form action="viewCart.php" method="get" style="margin: 0;">
				<button type="submit" style="background-color: white; color: #0077cc; border: 2px solid #0077cc; padding: 8px 14px; font-weight: bold; border-radius: 6px; cursor: pointer;">View Cart
				</button>
			</form>
		</div>
			
		<div id="sideMenu" class="side-menu">
			<a href="store.php" onClick="window.location=this.href;">Home</a>
			<a href="category.php?cat=Electronics">Electronics</a>
    		<a href="category.php?cat=Groceries">Groceries</a>
    		<a href="category.php?cat=Home Goods">Home Goods</a>
    		<a href="accountSettings.php">Account Settings</a>
    		<a href="index.php">Logout</a>
    	</div>

    	<div class="main">
    		<img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
    		<div class="product-info">
				<p>Price: $<?php echo number_format($product['price'], 2); ?></p>
				<p>In Stock: <?php echo $product['quantity']; ?></p>
				<p>Description: <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
			<form method="post" action="addToCart.php">
				<input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            	<input type="hidden" name="name" value="<?php echo htmlspecialchars($product['name']); ?>">
            	<input type="hidden" name="price" value="<?php echo $product['price']; ?>">
            	<button type="submit">Add to Cart</button>
            </form>
        </div>
    </div>

	<script>
		const sideMenu = document.getElementById("sideMenu");

		function toggleMenu() {
			if (sideMenu.style.width === "250px") {
				sideMenu.style.width = "0";
			} else {
				sideMenu.style.width = "250px";
			}
		}

		document.addEventListener("click", function(event) {
			const isClickInside = sideMenu.contains(event.target);
			const isMenuIcon = event.target.classList.contains("menu-icon");

			if (!isClickInside && !isMenuIcon) {
				sideMenu.style.width = "0";
			}
		});
	</script>

</body>
</html>