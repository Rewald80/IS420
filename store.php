<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "is420_store";

$conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

$category = isset($_GET['category']) ? $_GET['category'] : '';
$inStock = isset($_GET['in_stock']) ? true : false;
$sortOption = isset($_GET['sort']) ? $_GET['sort'] : '';

$sql = "SELECT * FROM products WHERE 1";
$params = [];
$types = "";

if ($searchQuery) {
    $sql .= " AND name LIKE ?";
    $params[] = '%' . $searchQuery . '%';
    $types .= "s";
}

if ($category) {
    $sql .= " AND category = ?";
    $params[] = $category;
    $types .= "s";
}

if ($inStock) {
    $sql .= " AND quantity > 0";
}

switch ($sortOption) {
    case "price_asc":
        $sql .= " ORDER BY price ASC";
        break;
    case "price_desc":
        $sql .= " ORDER BY price DESC";
        break;
    case "qty_asc":
        $sql .= " ORDER BY quantity ASC";
        break;
    case "qty_desc":
        $sql .= " ORDER BY quantity DESC";
        break;
    default:
        $sql .= " ORDER BY RAND()";
        break;
}

$sql .= " LIMIT 4";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("SQL Error: " . $conn-error);
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>IS420 Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
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

        .main { padding: 20px;
        }

        .products { display: flex; 
            flex-wrap: wrap; 
            gap: 20px; 
        }

        .product-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            width: 400px;
            height: auto;
            text-align: center;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
        }

        .product-card img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
        }

        .product-card .price {
            font-weight: bold; margin-top: 10px;
        }

        .product-card button {
            margin-top: 5px;
            padding: 6px 12px;
            background-color: #0077cc;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .product-card button:hover {
            background-color: #005fa3;
        }

        .search-bar {
            flex: 1;
            max-width: 300px;
            margin-right: 20px;
        }
        
        .search-bar input[type="text"] {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 2px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>
<body>

    <?php if (isset($_GET['added'])): ?>
    <div style="background-color: #d4edda; color: #155724; padding: 10px 15px; margin: 15px; border-left: 5px solid #28a745;">
        <?php echo htmlspecialchars($_GET['added']); ?> was added to cart.
    </div>
    <?php endif; ?>

    <div class="header">
        <span class="menu-icon" onclick="toggleMenu()">&#9776;</span>
        <h2 style="flex: 1;">Welcome to IS420 Store</h2>
        <form method="get" action="store.php" class="search-bar">
            <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($searchQuery); ?>">

            <select name="category">
                <option value="">All Categories</option>
                <option value="Electronics" <?php if(isset($_GET['category']) && $_GET['category'] == 'Electronics') echo 'selected'; ?>>Electronics</option>
                <option value="Groceries" <?php if(isset($_GET['category']) && $_GET['category'] == 'Groceries') echo 'selected'; ?>>Groceries</option>
                <option value="Home Goods" <?php if(isset($_GET['category']) && $_GET['category'] == 'Home Goods') echo 'selected'; ?>>Home Goods</option>
            </select>

            <label>
                <input type="checkbox" name="in_stock" value="1" <?php if(isset($_GET['in_stock'])) echo 'checked'; ?>>
                In Stock Only
            </label>

            <select name="sort">
                <option value="">Sort By</option>
                <option value="price_asc" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'price_asc') echo 'selected'; ?>>Price: Low to High</option>
                <option value="price_desc" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'price_desc') echo 'selected'; ?>>Price: High to Low</option>
                <option value="qty_asc" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'qty_asc') echo 'selected'; ?>>Inventory: Low to High</option>
                <option value="qty_desc" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'qty_desc') echo 'selected'; ?>>Inventory: High to Low</option>
            </select>

            <button type="submit">Apply</button>        
        </form>
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

    <div id="sideMenu" class="side-menu">
        <a href="store.php" onClick="window.location=this.href">Home</a>
        <a href="category.php?cat=Electronics" onclick="window.location=this.href;">Electronics</a>
        <a href="category.php?cat=Groceries">Groceries</a>
        <a href="category.php?cat=Home Goods">Home Goods</a>
        <a href="accountSettings.php">Account Settings</a>
        <a href="index.php">Logout</a>
    </div>

    <div class="main" id="mainContent">
        <?php if (basename($_SERVER['PHP_SELF']) === 'store.php'): ?>
        <h3>Featured Products</h3>
        <div class="products">
            <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $imagePath = "images/" . $row['id'] . ".jpg";
                        if (!file_exists($imagePath)) {
                            $imagePath = "images/default.jpg";
                        }

                        echo '<div class="product-card">';
                        $productUrl = "productDetails.php?id=" . $row['id'];
                        echo '<a href="' . $productUrl . '" style="color: inherit;">';
                        echo '<div class="title">' . htmlspecialchars($row['name']) . '</div>';
                        echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($row['name']) . '">';
                        echo '</a>';
                        echo '<div class="price">$' . number_format($row['price'], 2) . '</div>';
                        echo '<form method="post" action="addToCart.php">';
                        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                        echo '<input type="hidden" name="name" value="' . htmlspecialchars($row['name']) . '">';
                        echo '<input type="hidden" name="price" value="' . $row['price'] . '">';
                        echo '<button type="submit">Add to Cart</button>';
                        echo '</form>';  
                        echo '</div>';
                    }
                } else {
                echo "<p>More inventory coming soon.</p>";
            }
        ?>
    </div>
<?php endif; ?>
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
