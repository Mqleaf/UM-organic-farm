-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-09-24 09:18:45
-- 服务器版本： 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_gmx`
--

-- --------------------------------------------------------

--
-- 表的结构 `categories`
--

CREATE TABLE `categories` (
  `catid` int(10) UNSIGNED NOT NULL,
  `catname` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `categories`
--

INSERT INTO `categories` (`catid`, `catname`) VALUES
(1, 'Grain'),
(2, 'Vegetable'),
(3, 'Fruit');

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `orderid` int(10) UNSIGNED NOT NULL,
  `id` int(11) UNSIGNED NOT NULL,
  `amount` float(6,2) DEFAULT NULL,
  `date` date NOT NULL,
  `ship_name` char(60) NOT NULL,
  `ship_address` varchar(200) NOT NULL,
  `ship_tel` char(60) NOT NULL,
  `order_status` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `order_items`
--

CREATE TABLE `order_items` (
  `orderid` int(10) UNSIGNED NOT NULL,
  `productid` char(13) NOT NULL,
  `item_price` float NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `products`
--

CREATE TABLE `products` (
  `productid` char(13) NOT NULL,
  `title` char(100) DEFAULT NULL,
  `catid` int(10) UNSIGNED NOT NULL,
  `price` float NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `products`
--

INSERT INTO `products` (`productid`, `title`, `catid`, `price`, `description`) VALUES
('fruit1', '500g Organic Fresh Strawberry', 3, 30, 'Beautiful shape,tender pulp.It tastes delicious and special,filled with vitamin C.'),
('fruit2', '500g Organic Green Kumquat', 3, 28.8, 'Tasty juice,fewer seeds,it is delicious and nutritious.'),
('fruit3', '500g Organic Sweet Pitaya', 3, 13.5, 'Delicious and healthy. Rich in fiber, vitamins and minerals.'),
('fruit4', '500g Organic Cherry', 3, 100, 'Abundance of its unique sweet and crisp.It looks brilliant and plump.'),
('grain1', '500g Organic Wheat', 1, 25, 'You can cook it with rice,or smash it to make whole-grain toast'),
('grain2', '500g Organic Millet', 1, 28.6, 'Particles is full and healthy.It will taste well as porridge.'),
('grain3', '500g Organic Barley', 1, 28.8, 'The barley congee is fragrant and waxy.Its particles is full and tasty.'),
('grain4', '500g Organic Ormosia', 1, 32.9, 'Shapely,luster,fresh and delicious.'),
('vegetable1', '500g Organic Pakchoi', 2, 10, 'Organic fertilizer, no pesticide , open field , without any hormones smear , healthy , tasty'),
('vegetable2', '500g Organic Broccoli', 2, 12, 'A seasonal vegetable ,garlic fried will be affordable'),
('vegetable3', '500g Organic Celery', 2, 13, 'Celery benefits to your BP, also fills you up with almost no calories'),
('vegetable4', '500g Organic Spinach', 2, 11, 'Spinach is clean and tastes delicious.It also benefits to your eyesight.');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin', 'dd@44.com', 'e10adc3949ba59abbe56e057f20f883e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`catid`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderid`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`orderid`,`productid`),
  ADD KEY `productid` (`productid`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `categories`
--
ALTER TABLE `categories`
  MODIFY `catid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `orderid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- 限制导出的表
--

--
-- 限制表 `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`);

--
-- 限制表 `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`orderid`) REFERENCES `orders` (`orderid`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`productid`) REFERENCES `products` (`productid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
