-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 17, 2026 at 06:55 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `watch_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Chirag Gohel', 'chiraggohel@gmail.com', 'chiraggohel', '2026-08-10 03:18:11'),
(2, 'Rolex Admin', 'rolexadmin1@gmail.com', 'rolexadmin1', '2026-09-13 07:58:15');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int NOT NULL,
  `user_id` int NOT NULL,
  `watch_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `message_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`message_id`, `user_id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 2, 'viraj chavda', 'viraj@gmail.com', 'test', 'bas amnamj karyu tu bhai', '2026-08-23 14:48:24');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `subscribed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `newsletter_subscribers`
--

INSERT INTO `newsletter_subscribers` (`id`, `email`, `subscribed_at`) VALUES
(1, 'viraj@gmail.com', '2026-08-23 14:51:58');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` varchar(50) NOT NULL DEFAULT 'Pending',
  `order_status` varchar(50) NOT NULL DEFAULT 'Processing',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `address_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `customer_name`, `phone`, `amount`, `payment_status`, `order_status`, `created_at`, `address_id`) VALUES
(1, 2, 'viraj chavda', '9924022723', 12000.00, 'Pending', 'Delivered', '2026-08-23 14:20:41', 1),
(2, 1, 'Riddhi', '9924011778', 10500.00, 'Pending', 'Placed', '2026-09-08 10:54:01', 2),
(3, 4, 'Chirag Gohel', '9512770809', 65000.00, 'Pending', 'Delivered', '2026-09-12 17:08:35', 3),
(4, 4, 'Chirag Gohel', '9512770809', 49000.00, 'Pending', 'Delivered', '2026-09-12 17:10:52', 4),
(5, 4, 'John Snow', '9512770809', 22000.00, 'Pending', 'Placed', '2026-09-23 17:56:51', 5),
(6, 2, 'viraj chavda', '9924022721', 57500.00, 'Pending', 'Placed', '2026-09-23 19:19:34', 6);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int NOT NULL,
  `order_id` int NOT NULL,
  `watch_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `watch_id`, `quantity`, `price`, `created_at`) VALUES
(1, 1, 15, 1, 12000.00, '2026-08-23 14:20:41'),
(2, 2, 17, 1, 10500.00, '2026-09-08 10:54:01'),
(3, 3, 24, 1, 65000.00, '2026-09-12 17:08:35'),
(4, 4, 23, 1, 49000.00, '2026-09-12 17:10:52'),
(5, 5, 5, 1, 22000.00, '2026-09-23 17:56:51'),
(6, 6, 80, 1, 57500.00, '2026-09-23 19:19:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `created_at`) VALUES
(1, 'Riddhi', 'riddhi@gmail.com', '9924011778', '$2y$10$mqC/lFajIKq4taKiTR.gzO9QIpNZ.BJbBuK8HKcUodx5tnwZuL16y', '2026-08-10 03:15:48'),
(2, 'viraj chavda', 'viraj@gmail.com', '9924022721', '$2y$10$.Y7obT8TTIYbhxQhx2IQMePujxLh6W84F2a51DKHqUyoNWQLdcwB6', '2026-08-11 03:30:23'),
(3, 'Karan', 'karan@gmail.com', '9512770323', '$2y$10$tGOI8zCuL1KlsNMsz0SrzO/DORKfUqKaI8k/D8ZQXWuU9vAMhuqp2', '2026-09-08 17:54:10'),
(4, 'John Snow', 'johnsnow@gmail.com', '9512770809', '$2y$10$E9RLLkbpRT00eP8Jgi42EOqtjqePRu7CUldarTUAHTx5QMlxBPafm', '2026-09-12 16:46:12');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `address_id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`address_id`, `user_id`, `name`, `phone`, `address`, `city`, `state`, `pincode`, `created_at`) VALUES
(1, 2, 'viraj chavda', '9924022723', 'Mahike gam, thebachda road,', 'rajkot', 'gujarat', '360003', '2026-08-23 14:20:33'),
(2, 1, 'Riddhi', '9924011778', 'Radhe heights, santkabir road,', 'rajkot', 'gujarat', '360003', '2026-09-08 10:53:51'),
(3, 4, 'Chirag Gohel', '9512770809', 'Gohel Villa, Morbi Road,', 'Rajkot', 'Gujarat', '360003', '2026-09-12 17:08:24'),
(4, 4, 'Chirag Gohel', '9512770809', 'Gohel Villa, Morbi Road,', 'Rajkot', 'Gujarat', '360003', '2026-09-12 17:10:48'),
(5, 4, 'John Snow', '9512770809', 'sivdhara soc. Morbi road,', 'Rajkot', 'Gujarat', '360003', '2026-09-23 17:56:49'),
(6, 2, 'viraj chavda', '9924022721', 'Mahika,', 'Rajkot', 'Gujarat', '360003', '2026-09-23 19:19:05');

-- --------------------------------------------------------

--
-- Table structure for table `watches`
--

CREATE TABLE `watches` (
  `watch_id` int NOT NULL,
  `watch_name` varchar(150) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `description` text,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `watches`
--

INSERT INTO `watches` (`watch_id`, `watch_name`, `price`, `stock`, `description`, `image`, `created_at`) VALUES
(1, 'Rolex Perpetual 1908', 28000.00, 5, 'Case Material: 18k White Gold | Case Size: 39mm | Dial Color: Intense White / Black | Water Resistance: 50m / 165 feet', '1789285035_4467.png', '2026-08-23 07:29:20'),
(2, 'Rolex Submariner No-Date', 11500.00, 10, 'Case Material: Oystersteel | Case Size: 41mm | Dial Color: Black | Water Resistance: 300m / 1,000 feet', 'm124060-0001.png', '2026-08-23 07:29:20'),
(3, 'Rolex Deepsea Challenge', 27000.00, 0, 'Case Material: RLX Titanium | Case Size: 50mm | Dial Color: Intense Black | Water Resistance: 11,000m / 36,090 feet', 'm126067-0002.png', '2026-08-23 07:29:20'),
(4, 'Rolex Datejust 41', 12500.00, 8, 'Case Material: Oystersteel | Case Size: 41mm | Dial Color: Mint Green | Water Resistance: 100m / 330 feet', 'm126334.png', '2026-08-23 07:29:20'),
(5, 'Rolex Cosmograph Daytona', 22000.00, 3, 'Case Material: Yellow Rolesor (Oystersteel & 18k Yellow Gold) | Case Size: 40mm | Dial Color: Golden / Black | Water Resistance: 100m / 330 feet', 'm126503-0003.png', '2026-08-23 07:29:20'),
(6, 'Rolex Cosmograph Daytona Platinum', 78000.00, 2, 'Case Material: 950 Platinum | Case Size: 40mm | Dial Color: Ice Blue | Water Resistance: 100m / 330 feet', 'm126506-0001.png', '2026-08-23 07:29:20'),
(7, 'Rolex Cosmograph Daytona Gold', 34000.00, 3, 'Case Material: 18k Yellow Gold | Case Size: 40mm | Dial Color: Golden / Black | Water Resistance: 100m / 330 feet', 'm126508-0008.png', '2026-08-23 07:35:12'),
(8, 'Rolex Cosmograph Daytona White Gold', 36000.00, 5, 'Case Material: 18k White Gold | Case Size: 40mm | Dial Color: Bright Black | Water Resistance: 100m / 330 feet', 'm126509-0001.png', '2026-08-23 07:35:12'),
(9, 'Rolex Sea-Dweller', 16500.00, 7, 'Case Material: Yellow Rolesor (Oystersteel & 18k Yellow Gold) | Case Size: 43mm | Dial Color: Black | Water Resistance: 1,220m / 4,000 feet', 'm126603-0001.png', '2026-08-23 07:35:12'),
(10, 'Rolex Submariner Date Bluesy', 14500.00, 8, 'Case Material: Yellow Rolesor (Oystersteel & 18k Yellow Gold) | Case Size: 41mm | Dial Color: Royal Blue | Water Resistance: 300m / 1,000 feet', 'm126613lb-0002.png', '2026-08-23 07:35:12'),
(11, 'Rolex Yacht-Master II', 17000.00, 4, 'Case Material: Oystersteel | Case Size: 44mm | Dial Color: Intense White | Water Resistance: 100m / 330 feet', 'm126680-0001.png', '2026-08-23 07:35:12'),
(12, 'Rolex GMT-Master II Batman', 11000.00, 6, 'Case Material: Oystersteel | Case Size: 40mm | Dial Color: Black | Water Resistance: 100m / 330 feet', 'm126710blnr-0003.png', '2026-08-23 07:35:12'),
(13, 'Rolex GMT-Master II Bruce Wayne', 11500.00, 5, 'Case Material: Oystersteel | Case Size: 40mm | Dial Color: Black | Water Resistance: 100m / 330 feet', 'm126710grnr-0003.png', '2026-08-23 07:35:12'),
(14, 'Rolex GMT-Master II Root Beer', 15500.00, 4, 'Case Material: Everose Rolesor (Oystersteel & 18k Everose Gold) | Case Size: 40mm | Dial Color: Black | Water Resistance: 100m / 330 feet', 'm126711chnr-0002.png', '2026-08-23 07:35:12'),
(15, 'Rolex GMT-Master II Sprite', 12000.00, 2, 'Case Material: Oystersteel | Case Size: 40mm | Dial Color: Black | Water Resistance: 100m / 330 feet', 'm126720vtnr-0001.png', '2026-08-23 07:35:12'),
(16, 'Rolex Air-King', 7500.00, 12, 'Case Material: Oystersteel | Case Size: 40mm | Dial Color: Black | Water Resistance: 100m / 330 feet', 'm126900-0001.png', '2026-08-23 07:35:12'),
(17, 'Rolex Land-Dweller White Dial', 10500.00, 4, 'Case Material: Stainless Steel | Case Size: 40mm | Dial Color: White | Water Resistance: 100m / 330 feet', 'm127334-0001.png', '2026-08-23 07:45:19'),
(18, 'Rolex Day-Date 36 Ombre Green', 38000.00, 3, 'Case Material: 18k Everose Gold | Case Size: 36mm | Dial Color: Ombre Green | Water Resistance: 100m / 330 feet', 'm128235-0085.png', '2026-08-23 07:45:19'),
(19, 'Rolex Day-Date 31 Orange Carnelian', 42000.00, 2, 'Case Material: 18k Yellow Gold | Case Size: 31mm | Dial Color: Orange Carnelian | Water Resistance: 100m / 330 feet', 'm128348rbr-0049.png', '2026-08-23 07:45:19'),
(20, 'Rolex Deepsea D-Blue Dial', 13500.00, 8, 'Case Material: Oystersteel | Case Size: 44mm | Dial Color: D-Blue (Blue to Black) | Water Resistance: 3,900m / 12,800 feet', 'm136660-0005.png', '2026-08-23 07:45:19'),
(21, 'Rolex Deepsea 18k Yellow Gold', 45000.00, 2, 'Case Material: 18k Yellow Gold | Case Size: 44mm | Dial Color: Royal Blue | Water Resistance: 3,900m / 12,800 feet', 'm136668lb-0001.png', '2026-08-23 07:45:19'),
(22, 'Rolex Yacht-Master 42 Yellow Gold', 28500.00, 4, 'Case Material: 18k Yellow Gold | Case Size: 42mm | Dial Color: Black | Water Resistance: 100m / 330 feet', 'm226658-0001.png', '2026-08-23 07:45:19'),
(23, 'Rolex Day-Date 40 Diamond Pave', 49000.00, 1, 'Case Material: 18k Yellow Gold | Case Size: 40mm | Dial Color: Diamond Pave | Water Resistance: 100m / 330 feet', 'm228238-0054.png', '2026-08-23 07:45:19'),
(24, 'Rolex Day-Date 40 Platinum', 65000.00, 0, 'Case Material: 950 Platinum | Case Size: 40mm | Dial Color: Ice Blue with Baguette Diamonds | Water Resistance: 100m / 330 feet', 'm228396tbr-0042.png', '2026-08-23 07:45:19'),
(25, 'Rolex Yacht-Master 37 Everose Rolesor', 13000.00, 6, 'Case Material: Everose Rolesor (Oystersteel & 18k Everose Gold) | Case Size: 37mm | Dial Color: Chocolate | Water Resistance: 100m / 330 feet', 'm268621-0003.png', '2026-08-23 07:45:19'),
(26, 'Rolex Datejust 31 Red Aubergine', 31000.00, 5, 'Case Material: 18k Yellow Gold | Case Size: 31mm | Dial Color: Deep Red Sunray with Diamonds | Water Resistance: 100m / 330 feet', 'm278288rbr-0041.png', '2026-08-23 07:45:19'),
(27, 'Rolex Datejust 41 Yellow Rolesor', 32999.00, 7, 'Case Material: Yellow Rolesor (Oystersteel & 18k Yellow Gold) | Case Size: 41mm | Dial Color: Black with Diamond Markers | Water Resistance: 100m / 330 feet', 'm126303-0005.png', '2026-09-13 01:16:27'),
(28, 'Rolex Datejust 41 Gold Dial', 29999.00, 5, 'Case Material: Yellow Rolesor (Oystersteel & 18k Yellow Gold) | Case Size: 41mm | Dial Color: Champagne / Gold | Water Resistance: 100m / 330 feet', 'm126333-0010.png', '2026-09-13 01:16:27'),
(29, 'Rolex Datejust 41 Blue Diamond Dial', 28999.00, 9, 'Case Material: White Rolesor (Oystersteel & 18k White Gold Bezel) | Case Size: 41mm | Dial Color: Bright Blue with Diamonds | Water Resistance: 100m / 330 feet', 'm126334-0016.png', '2026-09-13 01:16:27'),
(30, 'Rolex Datejust 41 Mint Green Dial', 27999.00, 6, 'Case Material: White Rolesor (Oystersteel & 18k White Gold Fluted Bezel) | Case Size: 41mm | Dial Color: Mint Green | Water Resistance: 100m / 330 feet', 'm126334-0033.png', '2026-09-13 01:16:27'),
(31, 'Rolex Cosmograph Daytona Yellow Gold', 39999.00, 3, 'Case Material: 18k Yellow Gold | Case Size: 40mm | Dial Color: Intense White | Water Resistance: 100m / 330 feet', 'm126508-0001.png', '2026-09-13 01:16:27'),
(32, 'Rolex Cosmograph Daytona Everose Oysterflex', 38999.00, 4, 'Case Material: 18k Everose Gold with Cerachrom Bezel | Case Size: 40mm | Dial Color: Sundust with Black Counters | Water Resistance: 100m / 330 feet', 'm126515ln-0006.png', '2026-09-13 01:16:27'),
(33, 'Rolex Cosmograph Daytona Chocolate Dial', 37999.00, 2, 'Case Material: 18k Everose Gold | Case Size: 40mm | Dial Color: Chocolate with Black Counters | Water Resistance: 100m / 330 feet', 'm126515ln-0010.png', '2026-09-13 01:16:27'),
(34, 'Rolex Cosmograph Daytona Diamond Bezel', 49999.00, 2, 'Case Material: 18k White Gold with Diamond Bezel | Case Size: 40mm | Dial Color: Bright Black and Mother-of-Pearl | Water Resistance: 100m / 330 feet', 'm126589rbr-0001.png', '2026-09-13 01:16:27'),
(35, 'Rolex Land-Dweller 40 Everose Gold', 34999.00, 5, 'Case Material: 18k Everose Gold | Case Size: 40mm | Dial Color: White Honeycomb Motif | Water Resistance: 100m / 330 feet', 'm127335-0001.png', '2026-09-13 01:16:27'),
(36, 'Rolex Day-Date 36 Diamond Pave', 45999.00, 3, 'Case Material: 18k Everose Gold with Diamond Bezel | Case Size: 36mm | Dial Color: Silvered Diamond-Set | Water Resistance: 100m / 330 feet', 'm128345rbr-0082.png', '2026-09-13 01:16:27'),
(73, 'Rolex Day-Date 36 (White Gold Diamond-Paved)', 82000.00, 5, 'Case Material: 18k White Gold with Diamonds | Case Size: 36mm | Dial Color: Silver / Diamond-Paved | Water Resistance: 100m / 330 feet', 'm128349rbr-0013.png', '2026-09-13 01:19:40'),
(74, 'Rolex Day-Date 36 (Everose Gold Chocolate)', 108000.00, 3, 'Case Material: 18k Everose Gold with Diamond Bezel | Case Size: 36mm | Dial Color: Chocolate / Brown Ombre | Water Resistance: 100m / 330 feet', 'm128395tbr-0024.png', '2026-09-13 01:19:40'),
(75, 'Rolex Day-Date 36 (White Gold Pink Dial)', 110000.00, 2, 'Case Material: 18k White Gold with Diamond Bezel | Case Size: 36mm | Dial Color: Opaline Pink / Diamond Markers | Water Resistance: 100m / 330 feet', '1789283536_9010.png', '2026-09-13 01:19:40'),
(76, 'Rolex Day-Date 40 (Everose Gold Green Jadeite)', 66000.00, 4, 'Case Material: 18k Everose Gold | Case Size: 40mm | Dial Color: Green Aventurine / Jadeite | Water Resistance: 100m / 330 feet', 'm228235jg-0003.png', '2026-09-13 01:19:40'),
(77, 'Rolex Datejust 31 (Two-Tone Yellow Gold & Steel)', 17500.00, 8, 'Case Material: Oystersteel & 18k Yellow Gold | Case Size: 31mm | Dial Color: Dark Mother of Pearl with Diamonds | Water Resistance: 100m / 330 feet', 'm278243-0024.png', '2026-09-13 01:19:40'),
(78, 'Rolex Lady-Datejust (White Gold & Steel White Dial)', 11800.00, 10, 'Case Material: Oystersteel & White Gold Fluted Bezel | Case Size: 28mm | Dial Color: White Roman Numerals | Water Resistance: 100m / 330 feet', '1789283466_8608.png', '2026-09-13 01:19:40'),
(79, 'Rolex Lady-Datejust (Everose Gold Aubergine)', 38500.00, 3, 'Case Material: 18k Everose Gold | Case Size: 28mm | Dial Color: Aubergine / Purple Diamond Dial | Water Resistance: 100m / 330 feet', 'm279175-0020.png', '2026-09-13 01:19:40'),
(80, 'Rolex Sky-Dweller (Everose Gold Intense White/Chocolate)', 57500.00, 1, 'Case Material: 18k Everose Gold | Case Size: 42mm | Dial Color: Intense Chocolate / Rose | Water Resistance: 100m / 330 feet', 'm336935-0006.png', '2026-09-13 01:19:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `watch_id` (`watch_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `watch_id` (`watch_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `watches`
--
ALTER TABLE `watches`
  ADD PRIMARY KEY (`watch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `message_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `address_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `watches`
--
ALTER TABLE `watches`
  MODIFY `watch_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`watch_id`) REFERENCES `watches` (`watch_id`) ON DELETE CASCADE;

--
-- Constraints for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `contact_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`watch_id`) REFERENCES `watches` (`watch_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `user_addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
