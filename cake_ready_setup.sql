-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2023 at 06:52 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cake_ready_setup`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `language_id` tinyint(4) NOT NULL DEFAULT 0,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `category_name` varchar(255) NOT NULL,
  `category_configs` varchar(255) DEFAULT '{"icon":"", "isProtected":""}',
  `category_priority` tinyint(4) DEFAULT 99,
  `rec_state` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `language_id`, `parent_id`, `category_name`, `category_configs`, `category_priority`, `rec_state`) VALUES
(9, 2, 0, 'Jet dsfjg sdjadfslfkj dsf ds', '{\"icon\":\"fa-bookmark\",\"isProtected\":\"\"}', 99, 1),
(10, 0, 9, 'AAA', '{\"icon\":\"fa-buysellads\"}', 99, 1),
(11, 1, 9, 'Bus', '{\"icon\":\"fa-bus\"}', 99, 1);

-- --------------------------------------------------------

--
-- Table structure for table `configs`
--

CREATE TABLE `configs` (
  `id` int(11) NOT NULL,
  `config_key` varchar(255) NOT NULL,
  `config_value` text DEFAULT NULL,
  `stat_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `configs`
--

INSERT INTO `configs` (`id`, `config_key`, `config_value`, `stat_updated`) VALUES
(1, 'TRY_USD', '0.52', '2022-12-23 07:42:21'),
(2, 'EUR_USD', '4', '2022-12-23 07:42:21'),
(3, 'GBP_USD', '8', '2022-12-23 07:49:09');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT 0,
  `log_url` varchar(255) NOT NULL COMMENT 'Ex: ["","","","","http//:localhost/ptpms/admin/offices/save/7","Offices","save","7"]',
  `log_changes` mediumtext DEFAULT NULL COMMENT 'Ex: [{"before":null}, {"after":"new val"}]',
  `stat_created` datetime NOT NULL DEFAULT current_timestamp(),
  `rec_state` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=unread, 2=read'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `logs`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `user_token` varchar(255) DEFAULT NULL,
  `user_configs` varchar(255) NOT NULL DEFAULT '{"mobile":"", "address":""}',
  `stat_lastlogin` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `stat_created` datetime NOT NULL,
  `stat_logins` int(11) NOT NULL DEFAULT 0,
  `stat_ip` varchar(255) DEFAULT NULL,
  `rec_state` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_fullname`, `email`, `password`, `user_role`, `user_token`, `user_configs`, `stat_lastlogin`, `stat_created`, `stat_logins`, `stat_ip`, `rec_state`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$iLiy64VgN.bXPhnXY.HhPe7FZ8nO9akhwLhgWNTYm2T4zbmWjSwKu', 'admin.root', '1', '', '2023-04-23 16:34:21', '2021-06-28 11:16:18', 25, '::1', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `configs`
--
ALTER TABLE `configs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3537;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
