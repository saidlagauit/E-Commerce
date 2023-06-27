-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2023 at 08:14 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `a_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `biographical` text NOT NULL,
  `phone` varchar(10) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `fullname`, `email`, `biographical`, `phone`, `created`) VALUES
(1, 'lagauit', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'said lagauit', 'contact@lagauit.co', 'I\'m a web developer and I love to build things.', '0669612125', '2023-06-19 21:44:00');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `currency` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `currency`) VALUES
(2, 'MAD'),
(1, 'USD');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name_customer` varchar(20) NOT NULL,
  `email_customer` varchar(255) NOT NULL,
  `phone_customer` varchar(10) NOT NULL,
  `date_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name_customer`, `email_customer`, `phone_customer`, `date_at`) VALUES
(5, 'Saad Ahmed', 'contact@saad.ahmed.com', '0663812666', '2023-06-20 22:32:10'),
(6, 'Khalid Mamhod', 'contact@mamhod.com', '0623065055', '2023-06-21 14:03:34'),
(7, 'Nassreddine Zitouni', 'contact@zitouni.com', '0625453421', '2023-06-21 15:49:54');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `orders_number` varchar(20) NOT NULL,
  `customer_id` int(20) NOT NULL,
  `product_name` text NOT NULL,
  `product_quantity` varchar(20) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `currency` enum('MAD','USD') NOT NULL DEFAULT 'USD',
  `subtotal` varchar(20) NOT NULL,
  `note_customer` text NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_status` enum('pending','cancelled','processing','pending payment','completed','failed') NOT NULL DEFAULT 'pending payment'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `orders_number`, `customer_id`, `product_name`, `product_quantity`, `product_price`, `currency`, `subtotal`, `note_customer`, `order_date`, `order_status`) VALUES
(4, '#23380', 5, 'Netflix Premium 4K 1 Month', '2', 4.49, 'USD', '8.98', 'saad ahmed', '2023-06-20 22:32:10', 'completed'),
(8, '#68817', 6, 'Netflix Premium 4K 1 Month', '1', 4.49, 'USD', '4.49', '', '2023-06-21 16:23:27', 'completed'),
(9, '#18661', 7, 'Netflix Premium 4K 1 Month', '3', 4.49, 'USD', '13.47', 'urg', '2023-06-21 15:49:54', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name_product` text NOT NULL,
  `description_product` text NOT NULL,
  `price_product` decimal(10,2) NOT NULL,
  `currency` enum('MAD','USD') NOT NULL DEFAULT 'USD',
  `img_product` varchar(255) NOT NULL,
  `stock_product` varchar(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name_product`, `description_product`, `price_product`, `currency`, `img_product`, `stock_product`, `created_at`) VALUES
(1, 'Canva Pro 1 Year', '✅ 1 year subscription\r\n\r\n✅ Non-stop\r\n\r\n✅ Auto renew\r\n\r\n✅ Upgrade your own account or give you a new one\r\n\r\n✅ Private account (You can change the email and password)\r\n\r\n✅ Full Warranty\r\n\r\n✅ If you need help or anything, you can contact us anytime, and we\'ll be happy to assist you.', 4.49, 'USD', '646d6246a868f.webp', '10', '2023-06-19 22:20:00'),
(3, 'Netflix Premium 4K 1 Month', '✅ Works on any device.\r\n\r\n✅ You can change the language while watching.\r\n\r\n✅ The account won\'t stop working if you don\'t change credentials (email, password).\r\n\r\n✅ Contact us for any issue, if the account stops working before the duration\r\n\r\n✅ Safety Account Warranty 100%\r\n\r\n✅ If you have any questions or need a custom deal you can contact us.\r\n\r\n✅ Support 24/7\r\n\r\n✅ Delivery Full Info when you made Purchase', 4.49, 'USD', '64920750bf3d4.jpg', '6', '2023-06-20 19:43:37');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'pending'),
(2, 'cancelled'),
(3, 'processing'),
(4, 'pending payment'),
(5, 'completed'),
(6, 'failed');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`,`phone`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `currency` (`currency`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
