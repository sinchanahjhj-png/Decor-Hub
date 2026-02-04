-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: May 20, 2025 at 08:28 AM
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
-- Database: `admindb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminid` int(11) NOT NULL DEFAULT 1,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminid`, `fullname`, `email`, `phone`, `password`, `gender`) VALUES
(1, 'admin', 'admin@gmail.com', '9807889089', '$2y$10$c2TEEKHEMZLHcx0I0FHdyODOCn/rcPwwii2Cm/IfNm8FsW105gJmC', 'f');

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
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `preview_text` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `designs`
--

INSERT INTO `designs` (`id`, `name`, `price`, `description`, `preview_text`, `image_path`, `category`) VALUES
(1, 'Open Kitchen Design', 128800.00, 'Contemporary kitchen with emerald cabinets.', 'Emerald cabinets with marble top.', '1.jpeg', 'kitchen'),
(2, 'Small Kitchen Design', 15000.99, 'This kitchen features overhead cabinets, deep drawers, and soft-close compartments for seamless organization.', 'Great for small homes.', '2.jpeg', 'kitchen'),
(3, 'L-Shaped Kitchen', 24000.00, 'This modern kitchen offers a combination of sleek cabinetry with upper glass doors for display, ample hidden storage beneath, and a uniquely designed corner unit enhancing organization.', 'Efficient and stylish.', '3.jpeg', 'kitchen'),
(4, 'Aahed Roman Kids Bed', 45000.00, 'Without storage with a smooth deco paint on it. Can be customized using the white laminate instead of deco paint on extra cost.', 'Cozy modern bedroom.', '1.jpeg', 'bedroom'),
(5, 'Minimalist Bed', 23000.00, 'Minimal bed with storage.', 'Space-saving design.', '2.jpeg', 'bedroom'),
(6, 'Sofa Set', 32000.00, 'Luxury sofa set.', 'Comfort meets elegance.', '1.jpeg', 'living'),
(7, 'Modern Bathroom', 12000.00, 'Stylish sink & mirror set.', 'Simple, elegant.', '1.jpeg', 'bathroom'),
(8, 'Wooden Prayer Unit', 7000.00, 'Elegant wooden pooja unit.', 'Spiritual vibes.', '1.jpeg', 'prayer'),
(9, 'Open Kitchen Design', 118800.00, 'Contemporary kitchen with emerald cabinets.', 'Emerald cabinets with marble top.', '4.jpeg', 'kitchen'),
(10, 'U-Shaped Kitchen Design', 26500.99, 'The kitchen features a mix of sleek dark wood and light cabinetry, offering plentiful storage with minimalist handle designs and elegantly illuminated glass shelves for displaying dishware.', 'Emerald cabinets with marble top.', '5.jpeg', 'kitchen'),
(11, 'Parallel Kitchen Design', 75750.00, 'This kitchen showcases high-gloss yellow and cream cabinetry, offering abundant storage space while the sleek, handle-free design creates a contemporary and functional cooking environment.', 'Emerald cabinets with marble top.', '6.jpeg', 'kitchen'),
(12, 'Corner Unit', 10000.99, 'This is one of the best pooja unit decoration ideas for smaller apartments.Designing a puja unit in a corner is a clever move as it elegantly stores all of our sacred items in one place without crowding the living space.', 'Spiritual vibes.', '2.jpeg', 'prayer'),
(13, 'Glass Enclosed Unit', 24000.00, 'We dig the wow factor of glass displays by creating a treasured spiritual collection in all its incredible glory.It allows natural light to illuminate divine space while adding a touch of sophistication to your home interior.', 'Spiritual vibes.', '3.jpeg', 'prayer'),
(14, 'Artistic Unit', 15800.50, 'Corner Pooja Room have become talk of the town due to the space-efficiency they offer in a budget-friendly way.You can add flair to your corner pooja room by designing it with wooden elements and trivial\r\n lighting.', 'Spiritual vibes.', '5.jpeg', 'prayer'),
(15, 'Small Unit', 5750.00, 'Having less space in your newly bought apartment? No worries we can totally make that work with a small pooja unit design.This pooja unit comes with additional storage space to keep all pooja items organized', 'Spiritual vibes.', '6.jpeg', 'prayer'),
(16, 'Classic Master Bedroom Design', 54000.00, 'A spacious swing wardrobe with loft units provides ample storage for clothing and essentials', 'Emerald cabinets.', '3.jpeg', 'bedroom '),
(17, 'Modern Living Room', 70000.99, 'It is an interior design style characterized by a monochromatic color palette, clean lines, minimalism, natural materials, and natural light.', 'Comfort meets elegance.', '2.jpeg', 'living'),
(18, 'Classic Living Room', 44000.00, 'Its sleek compartments provide ample space for media essentials, books, and decorative items, ensuring a clutter-free yet elegant living space.', 'Comfort meets elegance.', '3.jpeg', 'living'),
(19, 'Classic Living Room', 44000.00, 'Its sleek compartments provide ample space for media essentials, books, and decorative items, ensuring a clutter-free yet elegant living space.', 'Comfort meets elegance.', '3.jpeg', 'living'),
(20, 'Contemporary Living Room ', 55800.50, 'The living room is equipped with clever storage solutions, including open wall shelves to keep the space organized.', 'Comfort meets elegance.', '4.jpeg', 'living'),
(21, 'Simple Living Room ', 18000.99, 'A modern living room design may have characteristically clean lines, bold colours and lots of layers for texture and interest.', 'Comfort meets elegance.', '5.jpeg', 'living'),
(22, 'Small Living Room', 15750.00, 'Having less space in your newly bought apartment? No worries,\r\nwe can totally make that work with a small living room design.', 'Comfort meets elegance.', '6.jpeg', 'living'),
(23, 'Rustic Bathroom', 10000.99, 'Recessed shelf above the toilet for additional storage and display of essentials', 'Simple, elegant.', '2.jpeg', 'bathroom'),
(24, 'Modern Bathroom With Freestanding Bathtub', 54000.00, 'Freestanding oval bathtub, sleek and elegant, making it the centerpiece.Soft natural light enhances the calm and serene atmosphere.', 'Simple.', '3.jpeg', 'bathroom'),
(25, 'Industrial Bathroom', 25800.50, 'Glass-enclosed shower with black metal framing, enhancing the industrial-modern theme.', 'Simple.', '4.jpeg', 'bathroom'),
(26, 'Modern Bathroom with Freestanding Tub', 60000.99, 'Freestanding bathtub, centrally placed for a spa-like experience.', 'Simple.', '5.jpeg', 'bathroom'),
(27, 'Modern Bathroom', 18750.00, 'It creates a stylish and functional space.', 'Simple.', '6.jpeg', 'bathroom'),
(28, 'Minimalist Bathroom', 25750.00, 'It showcases for a warm, airy feel, a sleek suede-finish vanity with efficient drawer storage, and a rectangular mirror that enhances depth and light, creating a refined yet practical space.', 'Simple.', '7.jpeg', 'bathroom'),
(29, 'Luxury Wooden Bed', 112000.99, 'A designer creative leather bed that brings style and elegance to a room. This soft leather bed is a perfect product if you want a comfortable sleep and release stress and fatigue. The crystal-like button-tufted headboard and footboard look exquisite', 'Emerald cabinets.', '4.jpeg', 'bedroom '),
(30, 'Classic Bed', 58000.00, 'This is a master bedroom harmonizes classic and contemporary elements, featuring an upholstered bed, gold-accented nightstands, and a plush bench.', 'Emerald cabinets.', '5.jpeg', 'bedroom ');

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

--
-- Dumping data for table `new_arrivals`
--

INSERT INTO `new_arrivals` (`id`, `name`, `price`, `image`) VALUES
(1, 'VLA26T Vega Chair', 4440.00, 'n1.png'),
(2, 'CH28P Lounge Chair', 4595.00, 'n2.png'),
(3, 'Aarsun Handmade Wooden Fainting Couch', 37999.00, 'n3.png'),
(4, 'Classic Sofa', 45540.00, 'n4.png'),
(5, 'Vintage Red Sofa', 50990.00, 'n5.png'),
(6, 'Luxury Chesterfield couch', 51549.00, 'n6.png'),
(7, 'Wooden Bed', 27399.00, 'n7.png'),
(8, 'Sofabed', 19990.00, 'n8.png'),
(9, 'Queen Size Bed', 30990.00, 'n9.png'),
(10, 'Sofa Bed With Armrest Black', 15090.00, 'n10.png'),
(11, 'Koyl Chaira and Table', 16790.00, 'n11.png'),
(12, 'Rosewood furniture', 20990.00, 'n12.png'),
(13, 'Wooden Table Set', 7000.00, 'n13.png'),
(14, 'Antique Round Side Table', 15900.00, 'n14.png'),
(15, 'Brown Side Table With Bobbin Legs', 15990.00, 'n15.png'),
(16, 'Nordic Velvet Sofa', 16000.00, 'n16.png'),
(17, 'White Leather Sofa', 18790.00, 'n17.png'),
(18, 'INMARWAR Wooden Table', 3199.00, 'n18.png');

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

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `name`, `email`, `phone`, `created_at`, `status`, `cancellation_reason`) VALUES
(1, 'sinchana', 'sinchana@gmail.com', '9089099090', '2025-05-03 02:52:15', 'Accepted', NULL),
(2, 'mamatha', 'mamatha@gmail.com', '8907890987', '2025-05-03 02:56:51', 'Accepted', NULL),
(3, 'kruthi', 'kruthi@gmail.com', '8908907890', '2025-05-03 03:07:16', 'Rejected', NULL),
(4, 'samith', 'samith@gmail.com', '9089078909', '2025-05-03 04:01:22', 'Accepted', NULL),
(5, 'virat', 'virat@gmail.com', '9087344567', '2025-05-03 04:23:48', 'Accepted', NULL),
(6, 'kavi', 'kavi@gmail.com', '8954656766', '2025-05-03 06:40:01', 'Rejected', NULL),
(7, 'anil', 'anil@gmail.com', '8954656766', '2025-05-03 06:40:29', 'Pending', NULL),
(8, 'pragathi', 'pragathi@gmail.com', '8986677888', '2025-05-03 06:41:17', 'Pending', NULL),
(9, 'prema', 'prema@gmail.com', '9798088980', '2025-05-03 12:53:51', 'Pending', NULL),
(10, 'pavi', 'pavi@gmail.com', '9809898999099', '2025-05-03 12:54:39', 'Pending', NULL),
(11, 'siri', 'siri@gmail.com', '6879568578', '2025-05-03 20:07:09', 'Pending', NULL),
(17, 'varun', 'varun@gmail.com', '8789888788', '2025-05-03 21:12:12', 'cancelled', 'i change my mind'),
(18, 'sreeni', 's@gmail.com', '9898989898', '2025-05-03 21:26:50', 'Pending', NULL),
(19, 'sree', 's@gmail.com', '9898989898', '2025-05-03 21:28:56', 'Pending', NULL),
(28, 'win', 'win@gmail.com', '9889877583', '2025-05-05 02:33:07', 'Pending', NULL),
(29, 'sin', 'sin@gmail.com', '8945748575', '2025-05-05 02:34:21', 'cancelled', 'other'),
(30, 'Mamatha', 'mamatha2@gmail.com', '9832648819', '2025-05-05 18:41:10', 'Pending', NULL);

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

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `name`, `price`, `quantity`, `image`, `category`) VALUES
(1, 1, 3, 'Aarsun Handmade Wooden Fainting Couch', 37999.00, 1, 'images/new_arrivals/n3.png', NULL),
(2, 2, 4, 'Classic Sofa', 45540.00, 1, 'images/new_arrivals/n4.png', NULL),
(3, 2, 5, 'Vintage Red Sofa', 50990.00, 1, 'images/new_arrivals/n5.png', NULL),
(4, 3, 8, 'CH101 Lounge Chair', 4200.00, 1, 'images/chair/4.png', NULL),
(5, 4, 15, 'Maima Sofa', 22800.00, 2, 'images/sofa/s6.png', 'Unknown'),
(6, 4, 17, 'White Leather Sofa', 18790.00, 1, 'images/new_arrivals/n17.png', 'Unknown'),
(7, 5, 7, 'Modern Bathroom', 12000.00, 1, 'images/bathroom_img/1.jpeg', 'Unknown'),
(8, 6, 18, 'Classic Living Room', 44000.00, 1, 'images/living_img/3.jpeg', 'living'),
(9, 7, 18, 'Classic Living Room', 44000.00, 1, 'images/living_img/3.jpeg', 'living'),
(10, 8, 5, 'Minimalist Bed', 23000.00, 1, 'images/bedroom_img/2.jpeg', 'bedroom'),
(11, 9, 18, 'Round Dinning table', 22000.00, 1, 'images/dinning table/d6.png', 'Unknown'),
(12, 10, 23, 'Rustic Bathroom', 10000.99, 1, 'images/bathroom_img/2.jpeg', 'bathroom'),
(19, 17, 9, 'KK37581 Armchair', 5200.00, 1, 'images/chair/5.png', 'Unknown'),
(20, 17, 12, 'Lounge Sofa', 20500.00, 1, 'images/sofa/s3.png', 'Unknown'),
(21, 17, 17, 'Caspian Furniture Sofa Set', 20000.00, 1, 'images/dinning table/d5.png', 'Unknown'),
(22, 18, 5, 'Minimalist Bed', 23000.00, 1, 'images/bedroom_img/2.jpeg', 'bedroom'),
(23, 18, 7, 'Carl Hansen and Son E015 Embrace Lounge Chair', 6200.00, 1, 'images/chair/3.png', 'Unknown'),
(24, 18, 15, 'Maima Sofa', 22800.00, 1, 'images/sofa/s6.png', 'Unknown'),
(25, 18, 17, 'Caspian Furniture Sofa Set', 20000.00, 1, 'images/dinning table/d5.png', 'Unknown'),
(26, 18, 21, 'Simple Wood Bed', 25090.00, 1, 'images/bed/b2.png', 'Unknown'),
(27, 19, 22, 'Small Living Room', 15750.00, 1, 'images/living_img/6.jpeg', 'living'),
(36, 28, 22, 'Max and Lilly Solid Wood', 11549.00, 1, 'images/bed/b3.png', 'Unknown'),
(37, 29, 18, 'Classic Living Room', 44000.00, 1, 'images/living_img/3.jpeg', 'living'),
(38, 30, 1, 'Comfort Chair', 320.00, 1, 'images/chair/1.png', 'Unknown');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `image`) VALUES
(1, 'Comfort Chair', 'Chairs', 320.00, 'chair/1.png'),
(2, 'Luxury Sofa', 'Sofa', 10850.00, 'sofa/s1.png'),
(3, 'Classic Dining Table', 'DiningTable', 8000.00, 'dinning table/d1.jpg'),
(4, 'King Size Bed', 'Bed', 8500.00, 'bed/b1.png'),
(5, 'Wooden Coffee Table', 'Tables', 450.00, 'table/t1.png'),
(6, 'CH78 Mama Bear Lounge Chair', 'Chairs', 850.00, 'chair/2.png'),
(7, 'Carl Hansen and Son E015 Embrace Lounge Chair', 'Chairs', 6200.00, 'chair/3.png'),
(8, 'CH101 Lounge Chair', 'Chairs', 4200.00, 'chair/4.png'),
(9, 'KK37581 Armchair', 'Chairs', 5200.00, 'chair/5.png'),
(10, 'CH22 Lounge Chair', 'Chairs', 1000.00, 'chair/6.png'),
(11, 'Kurlon Jumeriah Letherrate Sofa', 'Sofa', 18500.00, 'sofa/s2.png'),
(12, 'Lounge Sofa', 'Sofa', 20500.00, 'sofa/s3.png'),
(13, 'Kurl-on Maximo Sofa', 'Sofa', 18200.00, 'sofa/s4.png'),
(14, 'Clever couch Adam linen Sofa', 'Sofa', 21000.00, 'sofa/s5.png'),
(15, 'Maima Sofa', 'Sofa', 22800.00, 'sofa/s6.png'),
(16, 'Solidwood Dinning table', 'DiningTable', 18000.00, 'dinning table/d4.png'),
(17, 'Caspian Furniture Sofa Set', 'DiningTable', 20000.00, 'dinning table/d5.png'),
(18, 'Round Dinning table', 'DiningTable', 22000.00, 'dinning table/d6.png'),
(19, 'Teak Wood Dinning Table', 'DiningTable', 28000.00, 'dinning table/d2.png'),
(20, 'Barreto Dinning table', 'DiningTable', 16000.00, 'dinning table/d3.png'),
(21, 'Simple Wood Bed', 'Bed', 25090.00, 'bed/b2.png'),
(22, 'Max and Lilly Solid Wood', 'Bed', 11549.00, 'bed/b3.png'),
(23, 'HandCrafted Wooden Bed', 'Bed', 29999.00, 'bed/b4.png'),
(24, 'Atwood Platfoem Bed', 'Bed', 25990.00, 'bed/b5.png'),
(25, 'Moonwooden Single Size Bed', 'Bed', 16112.00, 'bed/b6.png'),
(26, 'Trex Outdoor table', 'Tables', 1050.00, 'table/t2.png'),
(27, 'Round Wood Table', 'Tables', 2550.00, 'table/t1.png'),
(28, 'Little Red Table', 'Tables', 999.00, 'table/t4.png'),
(29, 'Glass Wood Table', 'Tables', 3500.00, 'table/t5.png'),
(30, 'Triangle Wood Table', 'Tables', 2100.00, 'table/t6.png');

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
(1, 'sinchana', 'sinchana@gmail.com', '9089090998', '$2y$10$p1IBAmP8.8jz/gIs2hGBpu4ktUpm5W1FYPCbz.Wjlc895zyLTnA46', 'Female', '2025-05-01 18:26:47', 1),
(2, 'mamatha', 'mamatha@gmail.com', '7890789089', '$2y$10$4VDeo8xCpf9dInWlhmgFLetubhDc77fnhZLPvqKZIgSFxr6UlK4W.', 'Female', '2025-05-01 18:27:57', 0),
(3, 'samith', 'samith@gmail.com', '7806789089', '$2y$10$p7X76Kg3d7ms1.rxGZpEde4xjAGr04dAyZdYbp11sWCnUj5NKQuEa', 'Male', '2025-05-01 18:28:46', 0),
(4, 'Bhavana', 'bhav@gmail.com', '9089078900', '$2y$10$2ahHbd6AG29qS7FOTFqCPexM3Jrh4cyATxgADxq31V5LUUvRmQT7y', 'Female', '2025-05-01 18:29:45', 0),
(5, 'kruthi', 'kru@gmail.com', '9089089089', '$2y$10$4YkdJJA78xq3i9tBs3ut6e1bAIjoBC6gdpqUNKPLLBQoeAd.bCv7.', 'Female', '2025-05-01 18:30:49', 0),
(6, 'karan', 'karan@gmail.com', '9089089008', '$2y$10$RtZ8USNYFaeZ2MRNLfcnBelAokVT3SZAdo941C/T7eNgcn6jknLHO', 'Male', '2025-05-01 18:31:49', 0),
(7, 'virat', 'virat@gmail.com', '9098890009', '$2y$10$oeFac7t7xzCvV7zvTq6SHOWocrafA/T6oAWJH6LbWkSLQxkgrGtmS', 'Male', '2025-05-01 18:32:54', 0),
(8, 'siri', 'siri@gmail.com', '9089007890', '$2y$10$7xFMp9tGacwtDLAfqCu1g.gPEoMYUX4waZzfCg5AvHkrXSUnIPP1i', 'Female', '2025-05-01 18:33:43', 1),
(9, 'kavi', 'kavi@gmail.com', '9089078907', '$2y$10$v0DiaoV.MUPiumoC5A/AQeUGpBEB.DIl79QhvlsjHSAZDlgdpgFRK', 'Female', '2025-05-01 18:34:43', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminid`);

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
-- Indexes for table `categories1`
--
ALTER TABLE `categories1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designs`
--
ALTER TABLE `designs`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `categories1`
--
ALTER TABLE `categories1`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `designs`
--
ALTER TABLE `designs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `new_arrivals`
--
ALTER TABLE `new_arrivals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `new_arrivals` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
