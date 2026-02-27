<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$customerName = $_SESSION['customerName'] ?? 'Guest';
$customerEmail = $_SESSION['customerEmail'] ?? 'guest@em.ail';

$cart = $_SESSION['cart'];

$totalItems = 0;
$totalCost = 0;
foreach ($cart as $item) {
    $totalItems += $item['quantity'];
    $totalCost += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Cart - IS420 Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f7f7f7;
        }

        .header {
            background-color: #0077cc;
            color: white;
            padding: 15px;
            font-size: 24px;
        }

        .container {
            display: flex;
            padding: 20px;
            gap: 20px;
        }

        .left {
            flex: 3;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
        }

        .item {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-right: 20px;
            border-radius: 8px;
        }

        .item-info {
            flex: 1;
        }

        .item-name {
            font-size: 18px;
            font-weight: bold;
        }

        .item-controls {
            margin-top: 5px;
        }

        .item-price {
            font-size: 16px;
            font-weight: bold;
            color: #0077cc;
        }

        .right {
            flex: 1;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            height: fit-content;
        }

        .summary-box h3 {
            margin-top: 0;
        }

        .summary-box p {
            margin: 10px 0;
        }

        .btn {
            padding: 8px 16px;
            background-color: #0077cc;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #005fa3;
        }

        .input-qty {
            width: 40px;
            padding: 4px;
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
    </style>
</head>
<body>


    <div class="header"><span class="menu-icon" onclick="toggleMenu()">&#9776;</span>Welcome, <?php echo htmlspecialchars($customerName); ?>!
        
    </div>

    <div id="sideMenu" class="side-menu">
        <a href="store.php" onClick="window.location=this.href;">Home</a>
        <a href="category.php?cat=Electronics">Electronics</a>
        <a href="category.php?cat=Groceries">Groceries</a>
        <a href="category.php?cat=Home Goods">Home Goods</a>
        <a href="accountSettings.php">Account Settings</a>
        <a href="index.php">Logout</a>
    </div>

    <div class="container">
        <div class="left">
            <?php foreach ($cart as $item): ?>
                <?php $product_id = $item['id']; ?>
                <div class="item">
                    <img src="images/<?php echo $product_id; ?>.jpg" alt="<?php echo htmlspecialchars($item['name']); ?>">
                    <div class="item-info">
                        <div class="item-name"><?php echo htmlspecialchars($item['name']); ?></div>
                        <div class="item-controls">
                            <form action="updateCart.php" method="post" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $product_id; ?>">
                                Quantity:
                                <input class="input-qty" type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="0">
                                <button type="submit" class="btn">Update</button>
                            </form>
                            <form action="removeFromCart.php" method="post" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $product_id; ?>">
                                <button type="submit" class="btn" style="background-color: red;">Remove</button>
                            </form>
                        </div>
                    </div>
                    <div class="item-price">$<?php echo number_format($item['price'], 2); ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="right">
            <div class="summary-box">
                <h3>Cart Summary</h3>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($customerEmail); ?></p>
                <p><strong>Items in Cart:</strong> <?php echo $totalItems; ?></p>
                <p><strong>Total:</strong> $<?php echo number_format($totalCost, 2); ?></p>
                <form action="checkout.php" method="post">
                    <button type="submit" class="btn">Proceed to Checkout</button>
                </form>
                <form action="store.php" method="get">
                    <button type="submit" class="btn" style="margin-top: 10px;">Continue Shopping</button>
                </form>
            </div>
        </div>
    </div>

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