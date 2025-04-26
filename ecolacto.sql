-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2025 at 03:06 PM
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
-- Database: `ecolacto`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `consumer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `image` varchar(250) NOT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `active`, `created_at`) VALUES
(8, 'Category 1', 'Categories_Images/advertisement.jpg', 1, '2025-04-15 19:02:28');

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE `meals` (
  `id` int(11) NOT NULL,
  `home_cook_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(250) NOT NULL,
  `price` double NOT NULL,
  `qty` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`id`, `home_cook_id`, `name`, `description`, `image`, `price`, `qty`, `active`, `created_at`) VALUES
(1, 4, 'Meal 1222', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scra', 'Meals_Images/images.jpeg', 55, 5, 1, '2025-04-21 21:21:50');

-- --------------------------------------------------------

--
-- Table structure for table `meals_orders`
--

CREATE TABLE `meals_orders` (
  `id` int(11) NOT NULL,
  `meal_id` int(11) NOT NULL,
  `home_cook_id` int(11) NOT NULL,
  `consumer_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `meals_orders`
--

INSERT INTO `meals_orders` (`id`, `meal_id`, `home_cook_id`, `consumer_id`, `qty`, `status`, `created_at`) VALUES
(1, 1, 4, 5, 2, 'Accepted', '2025-04-21 23:26:13');

-- --------------------------------------------------------

--
-- Table structure for table `meal_keywords`
--

CREATE TABLE `meal_keywords` (
  `id` int(11) NOT NULL,
  `meal_id` int(11) NOT NULL,
  `keyword` varchar(250) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `meal_keywords`
--

INSERT INTO `meal_keywords` (`id`, `meal_id`, `keyword`, `created_at`) VALUES
(1, 1, 'key 1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `consumer_id` int(11) NOT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'Pending',
  `total_price` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `consumer_id`, `status`, `total_price`, `created_at`) VALUES
(19, 4, 'Accepted', 110, '2025-04-21 19:39:16');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `seller_id`, `product_id`, `quantity`, `created_at`) VALUES
(15, 19, 3, 10, 2, '2025-04-21 19:39:16');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `image` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `total_rate` double NOT NULL DEFAULT 0,
  `active` int(11) NOT NULL DEFAULT 1,
  `qty` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `farmer_id`, `name`, `image`, `description`, `price`, `total_rate`, `active`, `qty`, `created_at`) VALUES
(10, 8, 3, 'product 1', 'Product_Images/images.jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scra', 55, 0, 1, 3, '2025-04-20 22:24:52');

-- --------------------------------------------------------

--
-- Table structure for table `seller_feedbacks`
--

CREATE TABLE `seller_feedbacks` (
  `id` int(11) NOT NULL,
  `consumer_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `feedback` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `seller_feedbacks`
--

INSERT INTO `seller_feedbacks` (`id`, `consumer_id`, `seller_id`, `feedback`, `created_at`) VALUES
(2, 4, 3, 'Test review', '2025-04-21 18:45:43');

-- --------------------------------------------------------

--
-- Table structure for table `seller_rate`
--

CREATE TABLE `seller_rate` (
  `id` int(11) NOT NULL,
  `consumer_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `rate` double NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `seller_rate`
--

INSERT INTO `seller_rate` (`id`, `consumer_id`, `seller_id`, `rate`, `created_at`) VALUES
(4, 4, 3, 4, '2025-04-21 21:04:28');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`) VALUES
(1, 'Pending'),
(2, 'Delivering'),
(3, 'Delivered'),
(4, 'Canceled');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `phone` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `total_rate` double NOT NULL DEFAULT 0,
  `image` varchar(250) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `status` varchar(191) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_type_id`, `name`, `email`, `phone`, `password`, `total_rate`, `image`, `description`, `active`, `status`, `created_at`) VALUES
(1, 1, 'Admin', 'admin@ecolacto.com', '0799999999', '1234567890', 0, 'image', NULL, 1, 'Pending', '2025-04-15 19:02:08'),
(3, 2, 'Farmer', 'farmer@yahoo.com', '9876543210', '123456789', 4, 'Farmer_Images/farmer.jpg', 'orem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five cent', 1, 'Accepted', '2025-04-20 22:06:35'),
(4, 3, 'homecook', 'home@yahoo.com', '9876543210', '1234567890', 0, 'Home_Cook_Images/images.jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scra', 1, 'Accepted', '2025-04-21 18:03:52'),
(5, 4, 'Consumer', 'consumer@yahoo.com', '9876543210', '123456', 0, NULL, NULL, 1, 'Pending', '2025-04-21 22:38:17');

-- --------------------------------------------------------

--
-- Table structure for table `users_types`
--

CREATE TABLE `users_types` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users_types`
--

INSERT INTO `users_types` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Farmer'),
(3, 'Home cook'),
(4, 'Consumer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id_cart` (`consumer_id`),
  ADD KEY `product_id_cart` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `home_cook_id_FK` (`home_cook_id`);

--
-- Indexes for table `meals_orders`
--
ALTER TABLE `meals_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meal_if_order_FK` (`meal_id`),
  ADD KEY `consumer_id_order_meal_FK` (`consumer_id`),
  ADD KEY `home_cook_id_FK_meal` (`home_cook_id`);

--
-- Indexes for table `meal_keywords`
--
ALTER TABLE `meal_keywords`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meal_id_keyword_FK` (`meal_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id_order` (`consumer_id`),
  ADD KEY `status_id_fk` (`status`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id_FK` (`order_id`),
  ADD KEY `product_id_order` (`product_id`),
  ADD KEY `seller_id_order_item_FK` (`seller_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id_FK` (`category_id`),
  ADD KEY `sellet_id_FK` (`farmer_id`);

--
-- Indexes for table `seller_feedbacks`
--
ALTER TABLE `seller_feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id_seller_feedback` (`consumer_id`),
  ADD KEY `seller_id_feedback` (`seller_id`);

--
-- Indexes for table `seller_rate`
--
ALTER TABLE `seller_rate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id_rate_seller` (`consumer_id`),
  ADD KEY `seller_id_rate` (`seller_id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uset_type_FK` (`user_type_id`);

--
-- Indexes for table `users_types`
--
ALTER TABLE `users_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `meals`
--
ALTER TABLE `meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `meals_orders`
--
ALTER TABLE `meals_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `meal_keywords`
--
ALTER TABLE `meal_keywords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `seller_feedbacks`
--
ALTER TABLE `seller_feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `seller_rate`
--
ALTER TABLE `seller_rate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users_types`
--
ALTER TABLE `users_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `consumer_id_cart_FK` FOREIGN KEY (`consumer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `product_id_cart_FK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `meals`
--
ALTER TABLE `meals`
  ADD CONSTRAINT `home_cook_id_FK` FOREIGN KEY (`home_cook_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `meals_orders`
--
ALTER TABLE `meals_orders`
  ADD CONSTRAINT `consumer_id_order_meal_FK` FOREIGN KEY (`consumer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `home_cook_id_FK_meal` FOREIGN KEY (`home_cook_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `meal_if_order_FK` FOREIGN KEY (`meal_id`) REFERENCES `meals` (`id`);

--
-- Constraints for table `meal_keywords`
--
ALTER TABLE `meal_keywords`
  ADD CONSTRAINT `meal_id_keyword_FK` FOREIGN KEY (`meal_id`) REFERENCES `meals` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `consumer_id_order_FK` FOREIGN KEY (`consumer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_item_id_FK` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `product_id_item_FK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `seller_id_item_FK` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `category_id_FK` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `farmer_id_FK` FOREIGN KEY (`farmer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `seller_feedbacks`
--
ALTER TABLE `seller_feedbacks`
  ADD CONSTRAINT `consumer_feedback_id_FK` FOREIGN KEY (`consumer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `seller_feedback_id_FK` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `seller_rate`
--
ALTER TABLE `seller_rate`
  ADD CONSTRAINT `consumer_id_rate_FK` FOREIGN KEY (`consumer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `seller_id_rate_FK` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `uset_type_FK` FOREIGN KEY (`user_type_id`) REFERENCES `users_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
