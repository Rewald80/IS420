-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2026 at 08:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `is420_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `items` int(11) NOT NULL,
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `username`, `total`, `items`, `order_date`) VALUES
(1, 'jake', 27.99, 2, '2025-04-21'),
(2, 'jake', 23.97, 3, '2025-04-21'),
(3, 'JAKE', 42.08, 8, '2025-04-22'),
(4, 'jake', 4.99, 1, '2025-05-07');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `item_name`, `qty`, `price`) VALUES
(1, 1, 'Bookshelf(Tall)', 1, 24.99),
(2, 1, 'Blank Disc', 1, 3.00),
(3, 2, 'Speaker', 1, 14.99),
(4, 2, 'Popcorn', 1, 3.99),
(5, 2, 'Salt & Pepper Shakers', 1, 4.99),
(6, 3, 'Juice(Strawberry Kiwi)', 6, 4.89),
(7, 3, 'Steak(8oz)', 1, 9.99),
(8, 3, 'Plates(4pk)', 1, 2.75),
(9, 4, 'USB-C - USB-C', 1, 4.99);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `category`, `quantity`, `description`) VALUES
(1, 'Water', 1.50, 'groceries', 75, 'A bottle of water. '),
(2, 'Blank Disc', 3.00, 'electronics', 70, '20 blank Compact Discs.'),
(3, 'Chair', 14.99, 'home goods', 15, 'a foldable chair for outdoors.'),
(4, 'Plates(4pk)', 2.75, 'home goods', 25, 'a set of 4 reusable plates.'),
(5, 'USB-C - USB-C', 4.99, 'electronics', 14, 'able to connect USB-C devices to other USB-C devices.'),
(6, 'Carpet', 39.99, 'home goods', 5, 'Decorative rug.'),
(7, 'TV', 249.99, 'electronics', 17, 'Used to watch shows and movies, LCD screen.'),
(8, 'Mouse', 4.99, 'electronics', 15, 'USB connection, no batteries required.'),
(9, 'Steak(8oz)', 9.99, 'groceries', 25, 'Grade \'A\'wesome beef, 1/2lb, raw.\r\n'),
(10, 'Steak(14oz)', 15.99, 'groceries', 20, 'Grade \'A\'wesome beef, 14oz, raw.'),
(11, 'Pretzel', 1.75, 'groceries', 50, 'precooked and frozen, ready to reheat and eat.'),
(12, 'Bread', 1.25, 'groceries', 65, 'Make toast, feed ducks, even slice it!'),
(13, 'Mousepad', 7.99, 'electronics', 10, 'Provide a smooth surface for your mouse to call home.'),
(14, 'Bookshelf(Tall)', 24.99, 'home goods', 15, 'Place books, decorative items, pictures, 6 rows.'),
(15, 'Bookshelf(Short)', 14.99, 'home goods', 7, 'Place books, decorative items, pictures, 3 rows.'),
(16, 'Mirror', 29.99, 'home goods', 3, '****NOT MAGIC*****\r\nBasic reflective surface to view reflections.'),
(17, 'Popcorn', 3.99, 'groceries', 45, 'great for a small snack and watching movies.'),
(18, 'Fan', 19.99, 'home goods', 30, 'Cool off with this amazing device.'),
(19, 'Headphones', 29.99, 'electronics', 20, 'Over the ear, comfortable, wired.'),
(20, 'Earbuds', 19.99, 'electronics', 20, 'tangle free, built in mic.'),
(21, 'Apple(Red)', 0.49, 'groceries', 100, 'A single apple to repel doctors.'),
(22, 'Shrimp(1lb)', 8.99, 'groceries', 35, '16oz raw shrimp, tail on.'),
(23, 'Chicken Nuggets', 8.99, 'groceries', 20, 'They calm the ROAR! of your hunger!'),
(24, 'Tacos(3 pack)', 4.99, 'groceries', 50, 'Perfect food for days between Mondays and Wednesdays!'),
(25, 'Bowls(8 pack)', 9.99, 'home goods', 35, 'Holds 1 Soup, Cereal or Ice cream at a time.'),
(26, 'Silverware set', 2.99, 'home goods', 75, 'Used to prove that you were not raised by wild animals.'),
(27, 'Endtable', 24.99, 'home goods', 25, 'This amazing block of material can be used to place things on and in, and can be used in many places.'),
(28, 'Pillows(2 pack)', 4.99, 'home goods', 40, 'Contains 2 pillows to allow for fair fights.'),
(29, 'Cups(9 pack)', 5.49, 'home goods', 50, 'Similar to our amazing bowl technology, but made taller, holds drinks.'),
(30, 'Micro SD Card', 39.99, 'electronics', 10, 'The SD card you know and love, but now micro.'),
(31, 'USB-C Wall Adapter', 4.99, 'electronics', 20, 'Allows you to charge your home using your phone.'),
(32, 'Batteries(AA)', 4.99, 'e', 35, 'Often required, more often forgotten, power your devices without plugging them in.'),
(33, 'Batteries(AAA)', 4.99, 'electronics', 40, '50% more \"A\" than our \"AA\" batteries.'),
(34, 'Speaker', 14.99, 'electronics', 20, 'Listen to the audio using your own device.'),
(35, 'Couch', 49.99, 'home goods', 15, 'Place to sit while you are waiting to not be sitting.'),
(36, 'Juice(Fruit Punch)', 4.89, 'groceries', 75, 'A drink containing several fruit juices.\r\n*No Fruit was punched*\r\n*The Juice does not punch you*'),
(37, 'Juice(Strawberry Kiwi)', 4.89, 'groceries', 75, 'A drink flavored with fruit juices.\r\n*Drink may attempt to spill*'),
(38, 'Bacon', 8.99, 'groceries', 65, 'Sliced pig meat, Raw, sizzles when cooked.'),
(39, 'Cheese Pizza', 8.99, 'groceries', 35, 'A disc of Cheese and tomato sauce on bread, perfect for parties.'),
(40, 'Pepperoni Pizza', 9.99, 'groceries', 40, 'Premium model of pizza, contains meat circles to upgrade the taste and style.'),
(41, 'Android Phone Case', 14.99, 'electronics', 20, 'Place in an Android device to keep that device from being not in a case.'),
(42, 'Iphone Case', 19.99, 'electronics', 15, 'Place an Iphone in this case because those things are expensive.'),
(43, 'DVD Player', 24.99, 'electronics', 18, 'Connect to your TV to watch DVDs.'),
(44, 'Watch', 29.99, 'electronics', 15, 'Place on your wrist so that you can determine the time quickly.'),
(45, 'Universal Remote', 7.99, 'electronics', 8, 'Programmable to several different TV, DVD and Audio systems.\r\n*May control Universe, use caution if Cosmic events occur*'),
(46, 'Camera', 49.99, 'electonics', 11, 'Trap moments of time to be reviewed when needed.'),
(47, 'Printer', 64.99, 'electronics', 4, 'take the stuff you see on your screen and make it be on paper.'),
(48, 'Printer Toner', 14.99, 'electronics', 7, 'required to make your printer function.\r\n*CYAN LOW!!! Buy more toner!!!!*'),
(49, 'Table Lamp', 4.99, 'home goods', 17, 'Place on a table or other surface to provide a light source.'),
(50, 'Floor Lamp', 12.99, 'home goods', 25, 'Large light source that can be placed on the ground.'),
(51, 'Picture Frame(5x6)', 3.99, 'home goods', 16, 'Place moments of time that you printed in this item to display.'),
(52, 'Picture Frame(8x10)', 7.99, 'home goods', 14, 'Place large moments of time that you printed in this item to display.'),
(53, 'Vacuum', 49.99, 'home goods', 6, 'Collect the crumbs and other small debris quickly.'),
(54, 'Cutting Board', 7.99, 'home goods', 20, 'Place items that need to be cut on this item to protect the other flat surfaces that do not need to be cut.'),
(55, 'Tablecloth', 8.99, 'home goods', 15, 'Place on a table to be fancy.'),
(56, 'Cookies', 4.99, 'groceries', 25, 'great snack, creates crumbs.'),
(57, 'Mac & Cheese', 0.99, 'groceries', 45, 'Noodles, Cheese, Bread Crumbs...\r\nWith their powers combined they are the best food ever.'),
(58, 'Table Salt', 2.99, 'groceries', 80, 'A rock for your food.'),
(59, 'Black Pepper', 2.99, 'groceries', 75, 'Add some flavor to your food.'),
(60, 'Salt & Pepper Shakers', 4.99, 'home goods', 30, 'Store Salt & Pepper.');

-- --------------------------------------------------------

--
-- Table structure for table `usrnames`
--

CREATE TABLE `usrnames` (
  `UserName` varchar(15) NOT NULL,
  `Password` varchar(10) NOT NULL,
  `Email` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usrnames`
--

INSERT INTO `usrnames` (`UserName`, `Password`, `Email`) VALUES
('Jake', 'Pass', 'Jake@email.go'),
('other', '123', 'name@place.ltr'),
('jadsfFDSAFDSAF', 'SFDADSFA', 'SFDADSFA');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
