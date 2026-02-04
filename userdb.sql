-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: May 20, 2025 at 08:29 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `userdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Chairs'),
(2, 'Sofas'),
(3, 'Dining Tables'),
(4, 'Beds'),
(5, 'Tables');

-- --------------------------------------------------------

--
-- Table structure for table `categories1`
--

CREATE TABLE `categories1` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories1`
--

INSERT INTO `categories1` (`id`, `name`) VALUES
(1, 'Prayer Room'),
(2, 'Kitchen'),
(3, 'Bedroom'),
(4, 'Living Room'),
(5, 'Bathroom');

-- --------------------------------------------------------

--
-- Table structure for table `designs`
--

CREATE TABLE `designs` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `preview` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `designs`
--

INSERT INTO `designs` (`id`, `name`, `price`, `description`, `preview`, `image`, `category_id`) VALUES
(1, 'Open Kitchen Design', 118800.00, 'Contemporary kitchen with emerald cabinets.', 'Emerald cabinets with marble top.', 'kitchen_img/1.jpeg', 2),
(2, 'Small Kitchen Design', 15000.99, 'Compact kitchen with storage.', 'Great for small homes.', 'kitchen_img/2.jpeg', 2),
(3, 'L-Shaped Kitchen', 24000.00, 'Modern L-shaped kitchen.', 'Efficient and stylish.', 'kitchen_img/3.jpeg', 2),
(4, 'Modern Bedroom Set', 45000.00, 'Spacious bed with wardrobe.', 'Cozy modern bedroom.', 'bedroom_img/1.jpeg', 3),
(5, 'Minimalist Bed', 23000.00, 'Minimal bed with storage.', 'Space-saving design.', 'bedroom_img/2.jpeg', 3),
(6, 'Sofa Set', 32000.00, 'Luxury sofa set.', 'Comfort meets elegance.', 'living_img/1.jpeg', 4),
(7, 'Modern Bathroom', 12000.00, 'Stylish sink & mirror set.', 'Simple, elegant.', 'bathroom_img/1.jpeg', 5),
(8, 'Wooden Prayer Unit', 7000.00, 'Elegant wooden pooja unit.', 'Spiritual vibes.', 'pr_img/1.jpeg', 1),
(9, 'Open Kitchen Design', 118800.00, 'Contemporary kitchen with emerald cabinets.', 'Emerald cabinets with marble top.', 'kitchen_img/1.jpeg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `new_arrivals`
--

CREATE TABLE `new_arrivals` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending',
  `cancellation_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `category_id`) VALUES
(1, 'Comfort Chair', 320.00, 'chair/1.png', 1),
(2, 'Luxury Sofa', 850.00, 'sofa/s1.png', 2),
(3, 'Dining Table', 3000.00, 'dinning table/d1.jpg', 3),
(4, 'King Size Bed', 8500.00, 'bed/b1.png', 4),
(5, 'Wooden Coffee Table', 450.00, 'table/t1.png', 5),
(6, 'CH78 Mama Bear Lounge Chair', 580.00, 'chair/2.png', 1),
(7, 'Carl Hansen and Son E015 Embrace Lounge Chair', 6200.00, 'chair/3.png', 1),
(8, 'CH101 Lounge Chair', 4200.00, 'chair/4.png', 1),
(9, 'KK37581 Armchair', 5200.00, 'chair/5.png', 1),
(10, 'CH22 Lounge Chair', 1000.00, 'chair/6.png', 1),
(11, 'Kurlon Jumeriah Letherrate Sofa', 18500.00, 'sofa/s2.png', 2),
(12, 'Lounge Sofa', 20500.00, 'sofa/s3.png', 2),
(13, 'Kurl-on Maximo Sofa', 18200.00, 'sofa/s4.png', 2),
(14, 'Clever couch Adam linen Sofa', 21000.00, 'sofa/s5.png', 2),
(15, 'Maima Sofa', 22800.00, 'sofa/s6.png', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_logged_in` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `phone`, `password`, `gender`, `created_at`, `is_logged_in`) VALUES
(1, 'sinchana', 'sinchana@gmail.com', '9089090998', '$2y$10$p1IBAmP8.8jz/gIs2hGBpu4ktUpm5W1FYPCbz.Wjlc895zyLTnA46', '1', '2025-05-02 02:26:47', 1),
(2, 'mamatha', 'mamatha@gmail.com', '7890789089', '$2y$10$4VDeo8xCpf9dInWlhmgFLetubhDc77fnhZLPvqKZIgSFxr6UlK4W.', '1', '2025-05-02 02:27:57', 1),
(3, 'samith', 'samith@gmail.com', '7806789089', '$2y$10$p7X76Kg3d7ms1.rxGZpEde4xjAGr04dAyZdYbp11sWCnUj5NKQuEa', '0', '2025-05-02 02:28:46', 1),
(4, 'Bhavana', 'bhav@gmail.com', '9089078900', '$2y$10$2ahHbd6AG29qS7FOTFqCPexM3Jrh4cyATxgADxq31V5LUUvRmQT7y', 'Female', '2025-05-02 02:29:45', 0),
(5, 'kruthi', 'kru@gmail.com', '9089089089', '$2y$10$4YkdJJA78xq3i9tBs3ut6e1bAIjoBC6gdpqUNKPLLBQoeAd.bCv7.', 'Female', '2025-05-02 02:30:49', 0),
(6, 'karan', 'karan@gmail.com', '9089089008', '$2y$10$RtZ8USNYFaeZ2MRNLfcnBelAokVT3SZAdo941C/T7eNgcn6jknLHO', '0', '2025-05-02 02:31:49', 1),
(7, 'virat', 'virat@gmail.com', '9098890009', '$2y$10$oeFac7t7xzCvV7zvTq6SHOWocrafA/T6oAWJH6LbWkSLQxkgrGtmS', '0', '2025-05-02 02:32:54', 1),
(8, 'siri', 'siri@gmail.com', '9089007890', '$2y$10$7xFMp9tGacwtDLAfqCu1g.gPEoMYUX4waZzfCg5AvHkrXSUnIPP1i', 'Female', '2025-05-02 02:33:43', 0),
(9, 'kavi', 'kavi@gmail.com', '9089078907', '$2y$10$v0DiaoV.MUPiumoC5A/AQeUGpBEB.DIl79QhvlsjHSAZDlgdpgFRK', 'Female', '2025-05-02 02:34:43', 0),
(10, 'pavan', 'pavan@gmail.com', '9089078900', '$2y$10$.vOo2.n5SrXHSdnc8Ne4NeojXLyIMDrA9oYIXA7XAjBFcjA3EcvpS', '0', '2025-05-01 18:41:16', 1),
(11, 'prema', 'prema@gmail.com', '9798088980', '$2y$10$0yz6Vub7Lmyh0oExZucaaupgY2aEaszBUbD5H/lrFbwMTzfSRHy86', 'Female', '2025-05-03 20:18:49', 1),
(12, 'sree', 's@gmail.com', '9898989898', '$2y$10$1q9lXUdohv8zN.nxZIg6O.vXToTadmJ560FNvy9SBXZJlegCrUBgG', '0', '2025-05-03 21:24:55', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designs`
--
ALTER TABLE `designs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `new_arrivals`
--
ALTER TABLE `new_arrivals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `designs`
--
ALTER TABLE `designs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `new_arrivals`
--
ALTER TABLE `new_arrivals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `new_arrivals` (`id`);

--
-- Constraints for table `designs`
--
ALTER TABLE `designs`
  ADD CONSTRAINT `designs_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `admindb`.`categories1` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
