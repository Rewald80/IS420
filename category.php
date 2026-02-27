<?php
session_start();
require 'store.php';

$category = $_GET['cat'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 9;
$offset = ($page - 1) * $limit;

if (!$category) {
	die("UNAVAILABLE");
}

$conn = new mysqli("localhost", "root", "", "is420_store");
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$totalItemsQuery = $conn->prepare("SELECT COUNT(*) as total FROM products WHERE category = ?");
$totalItemsQuery->bind_param("s", $category);
$totalItemsQuery->execute();
$totalitemsResult = $totalItemsQuery->get_result();
$totalItems = $totalitemsResult->fetch_assoc()['total'];
$totalPages = ceil($totalItems / $limit);

$sql = "SELECT * FROM products WHERE category = ? LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $category, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
	<title>IS420 <?php echo htmlspecialchars($category); ?> Store</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 0;
			background-color: #f4f4f4;
		}
		.header {
			background-color: #0077cc;
			color: white;
			padding: 15px;
			font-size: 24px;
		}
		.products {
			display: grid;
			grid-template-columns: repeat(3, 1fr);
			gap: 20px;
			padding: 20px;
		}
		.product {
			background-color: white;
			border-radius: 10px;
			padding: 15px;
			text-align: center;
			box-shadow: 0 0 8px rgba(0,0,0,0.1);
		}
		.product img {
			width: 200px;
			height: auto;
			object-fit: cover;
			border-radius: 8px;
		}
		.product h3 {
			margin: 10px 0 5px;
		}
		.btn {
			padding: 8px 16px;
			background-color: #0077cc;
			color: white;
			border: none;
			border-radius: 5px;
			cursor: pointer;
			margin-top: 10px;
		}
		.btn:hover {
			background-color: #005fa3;
		}
		.pagination {
			text-align: center;
			margin-bottom: 30px;
		}
	</style>
</head>
<body>

	<div class="header"><?php echo htmlspecialchars($category); ?></div>

	<div class="products">
		<?php while ($row = $result->fetch_assoc()): ?>
			<div class="product">
				<a href="productDetails.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; color: inherit;">
					<img src="images/<?php echo $row['id']; ?>.jpg" alt="<?php echo htmlspecialchars($row['name']); ?>">
					<h3><?php echo htmlspecialchars($row['name']); ?></h3>
				</a>
				<p>$<?php echo number_format($row['price'], 2); ?></p>
				<form action="addToCart.php" method="post">
					<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="name" value="<?php echo htmlspecialchars($row['name']); ?>">
                    <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                    <button type="submit" class="btn">Add to Cart</button>
                </form>
            </div>
            <?php endwhile; ?>
        </div>
        <div class="pagination">
        	<p>Page <?php echo $page; ?> of <?php echo $totalPages; ?></p>
        	<?php for ($i = 1; $i <= $totalPages; $i++): ?>
        		<?php if ($i == $page): ?>
        			<strong style="margin: 0 5px;"><?php echo $i; ?></strong>
        		<?php else: ?>
        			<a href="?cat=<?php echo urlencode($category); ?>&page=<?php echo $i; ?>" style="margin: 0 5px;"><?php echo $i; ?></a>

        		<?php endif; ?>
        	<?php endfor; ?>

        	<?php if ($page < $totalPages): ?>
        		<br>
        		<br>
        		<a href="?cat=<?php echo urlencode($category); ?>&page=<?php echo $page + 1; ?>">
        			<button>View More</button>
        		</a>
        	<?php endif; ?>
        </div>
    </body>
    </html>