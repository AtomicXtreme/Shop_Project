-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 30, 2022 at 06:28 PM
-- Server version: 8.0.28-0ubuntu0.20.04.3
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `uuid` binary(16) NOT NULL,
  `identity` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `firstName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lastName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'inactive',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`uuid`, `identity`, `password`, `firstName`, `lastName`, `status`, `created`, `updated`) VALUES
(0x11ec9f8cdf9815da9e43c6fe6be82e91, 'admin', '$2y$11$OwMimRB1aTrv.VH0uRIDFeU3eh7NNraKncCRruhW.lKOPyz/R7Fq6', 'DotKernel', 'Admin', 'active', '2022-03-09 09:39:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_role`
--

CREATE TABLE `admin_role` (
  `uuid` binary(16) NOT NULL,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_role`
--

INSERT INTO `admin_role` (`uuid`, `name`, `created`, `updated`) VALUES
(0x11ec9f8cdf96fe7a89c7c6fe6be82e91, 'superuser', '2022-03-09 09:39:53', NULL),
(0x11ec9f8cdf98133c8a5ec6fe6be82e91, 'admin', '2022-03-09 09:39:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_roles`
--

CREATE TABLE `admin_roles` (
  `userUuid` binary(16) NOT NULL,
  `roleUuid` binary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_roles`
--

INSERT INTO `admin_roles` (`userUuid`, `roleUuid`) VALUES
(0x11ec9f8cdf9815da9e43c6fe6be82e91, 0x11ec9f8cdf96fe7a89c7c6fe6be82e91);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `uuid` binary(16) NOT NULL,
  `title` varchar(50) NOT NULL,
  `status` enum('available','unavailable') NOT NULL DEFAULT 'available',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`uuid`, `title`, `status`, `created`, `updated`) VALUES
(0x11eca5ec3a020d369caeae973b7525af, 'Smartphone', 'unavailable', '2022-03-17 12:17:34', '2022-03-17 12:17:34'),
(0x11eca5eeb91519d6b112ae973b7525af, 'Desktop Pc', 'unavailable', '2022-03-17 12:35:26', '2022-03-17 12:35:26'),
(0x11eca6060c916b5285c7ae973b7525af, 'TV', 'unavailable', '2022-03-17 15:22:25', '2022-03-17 15:22:25');

-- --------------------------------------------------------

--
-- Table structure for table `contact_message`
--

CREATE TABLE `contact_message` (
  `uuid` binary(16) NOT NULL,
  `email` varchar(150) NOT NULL,
  `name` varchar(150) NOT NULL,
  `subject` text NOT NULL,
  `type` enum('report','bug','refund','new_message') NOT NULL DEFAULT 'new_message',
  `message` text NOT NULL,
  `status` enum('inactive','active') NOT NULL DEFAULT 'inactive',
  `platform` enum('website','designer','admin') NOT NULL DEFAULT 'website',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact_message`
--

INSERT INTO `contact_message` (`uuid`, `email`, `name`, `subject`, `type`, `message`, `status`, `platform`, `created`, `updated`) VALUES
(0x11ec9e0f91b574f8b77f1aec5515760d, 'mrs@gmail.com', 'Marius', 'DotKernel Message 2022-03-07 14:10:24', 'bug', 'Something...', 'inactive', 'website', '2022-03-07 12:10:24', '2022-03-14 15:35:33'),
(0x11ec9e1095c4ec3a8b511aec5515760d, 'ion23412@gmail.com', 'Ionut', 'DotKernel Message 2022-03-07 14:17:41', 'new_message', 'Lorem ipsum dolor sit amet', 'active', 'website', '2022-03-07 12:17:41', '2022-03-15 13:15:51'),
(0x11ec9e10eebb1e72bc791aec5515760d, 'adrian43@gmail.com', 'Adi', 'DotKernel Message 2022-03-07 14:20:10', 'refund', 'Test 1', 'inactive', 'website', '2022-03-07 12:20:10', '2022-03-14 15:38:17'),
(0x11ec9e1a1c4ba1a08d4f1aec5515760d, 'trifa.george12@gmail.com', 'Geo', 'DotKernel Message 2022-03-07 15:25:52', 'report', 'Test 2', 'inactive', 'website', '2022-03-07 13:25:52', '2022-03-14 15:38:22'),
(0x11eca465dd4420ca924c16c3224c72f7, 'test@gmail.com', 'Raul', 'DotKernel Message 2022-03-15 15:43:15', 'new_message', 'sds', 'active', 'website', '2022-03-15 13:43:15', '2022-03-15 13:43:26');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `uuid` binary(16) NOT NULL,
  `userUuid` binary(16) NOT NULL,
  `productUuid` binary(16) NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `text` text NOT NULL,
  `status` enum('available','unavailable') NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`uuid`, `userUuid`, `productUuid`, `title`, `text`, `status`, `created`, `updated`) VALUES
(0x11eca904af540b14bdced67ca8ea56d2, 0x11ec9bca7ee1b0d687e44eaed857920e, 0x11eca60662815702ba05ae973b7525af, 'Super Tv', 'sdsdsd', 'available', '2022-03-21 10:50:12', '2022-03-21 10:50:12'),
(0x11eca905e87ddf689596d67ca8ea56d2, 0x11ec9bca7ee1b0d687e44eaed857920e, 0x11eca60662815702ba05ae973b7525af, 'Amazing!', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'available', '2022-03-21 10:58:58', '2022-03-21 10:58:58'),
(0x11eca905fc25b5b8b71cd67ca8ea56d2, 0x11eca861e98bb4ce8c027ad5f85a87f7, 0x11eca60662815702ba05ae973b7525af, 'Good product!', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'available', '2022-03-21 10:59:31', '2022-03-21 10:59:31'),
(0x11eca9061c37f1d69fa2d67ca8ea56d2, 0x11eca861e98bb4ce8c027ad5f85a87f7, 0x11eca5eeb917221c8ac4ae973b7525af, 'Testing..', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'available', '2022-03-21 11:00:24', '2022-03-21 11:00:24'),
(0x11eca9063f660080b3bfd67ca8ea56d2, 0x11eca861e98bb4ce8c027ad5f85a87f7, 0x11eca605ce6a59c49a08ae973b7525af, 'AAAA', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'available', '2022-03-21 11:01:24', '2022-03-21 11:01:24'),
(0x11eca9def35ec4f49e6fc65ce4fc907a, 0x11ec9bca7ee1b0d687e44eaed857920e, 0x11eca6050ff9166ab1ecae973b7525af, 'test', 'aaa', 'available', '2022-03-22 12:52:37', '2022-03-22 12:52:37'),
(0x11ecaba1d9bb427496099253f14289c9, 0x11ec9bca7ee1b0d687e44eaed857920e, 0x11eca9f49a604a609665c65ce4fc907a, 'Test Review', 'Abcdefghsdsdsafasg', 'available', '2022-03-24 18:40:17', '2022-03-24 18:40:17'),
(0x11ecaf3cf248220aaa459af6db5e4ccb, 0x11ec9bca7ee1b0d687e44eaed857920e, 0x11eca9f49a604a609665c65ce4fc907a, 'Good', 'aaaaassddfsfsfs', 'available', '2022-03-29 08:48:03', '2022-03-29 08:48:03'),
(0x11ecaf3d34157250ae7c9af6db5e4ccb, 0x11ec9bca7ee1b0d687e44eaed857920e, 0x11eca9f49a604a609665c65ce4fc907a, 'Test', 'qqq', 'available', '2022-03-29 08:49:54', '2022-03-29 08:49:54');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `version` bigint NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20200416084037, 'DefaultSchema', '2020-09-09 13:52:53', '2020-09-09 13:52:54', 0),
(20200416084050, 'DefaultAdminSchema', '2022-03-09 09:39:23', '2022-03-09 09:39:23', 0),
(20200416154725, 'ContactMessage', '2020-09-09 13:52:54', '2020-09-09 13:52:54', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `uuid` binary(16) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `price` float NOT NULL,
  `status` enum('available','unavailable') NOT NULL DEFAULT 'available',
  `img` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL,
  `categoryUuid` binary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`uuid`, `title`, `description`, `price`, `status`, `img`, `created`, `updated`, `categoryUuid`) VALUES
(0x11eca5ec3a045a008972ae973b7525af, 'Samsung Galaxy A50', 'Dual Sim,Black,120GB,6GB Ram', 450, 'available', 'a50', '2022-03-17 12:17:34', '2022-03-17 12:17:34', 0x11eca5ec3a020d369caeae973b7525af),
(0x11eca5eeb917221c8ac4ae973b7525af, 'ASUS ROG Strix GT15 G15CE', 'Intel® Core™ i7-11700 4.90 GHz, Rocket Lake, 16GB DDR4, 1TB M.2 NVMe™ PCIe® 3.0 SSD, NVIDIA® GeForce® RTX3060 12GB DDR6, No OS', 1699, 'available', 'g35cg', '2022-03-17 12:35:26', '2022-03-17 12:35:26', 0x11eca5eeb91519d6b112ae973b7525af),
(0x11eca6050ff9166ab1ecae973b7525af, 'Samsung Galaxy S21', '5G, 128GB, 8GB RAM, Dual SIM', 700, 'available', 's21', '2022-03-17 15:15:21', '2022-03-17 15:15:21', 0x11eca5ec3a020d369caeae973b7525af),
(0x11eca6056fe2a94299c6ae973b7525af, 'Huawei P40 Pro', '5G, Dual Sim, 256 GB , 8GB Ram', 645, 'available', 'p40', '2022-03-17 15:18:02', '2022-03-17 15:18:02', 0x11eca5ec3a020d369caeae973b7525af),
(0x11eca605ce6a59c49a08ae973b7525af, 'Lenovo IdeaPad 3 15ACH6', 'AMD Ryzen 5 5600H 4.2GHz, 15.6\", Full HD, IPS, 8GB, 512GB SSD, NVIDIA GeForce GTX 1650 4GB, No OS', 1250, 'available', 'Ideapad3', '2022-03-17 15:20:40', '2022-03-22 11:59:39', 0x11eca5eeb91519d6b112ae973b7525af),
(0x11eca60662815702ba05ae973b7525af, 'Samsung Smart TV', 'Ultra HD 4K HDR Smart TV,LED 125 cm', 1450, 'available', '50TU7092', '2022-03-17 15:24:49', '2022-03-29 15:26:45', 0x11eca6060c916b5285c7ae973b7525af),
(0x11eca9f49a604a609665c65ce4fc907a, 'Asus Zenfone3', 'Dual Sim , 256gb', 400, 'available', 'zen3', '2022-03-22 15:27:36', '2022-03-29 13:07:47', 0x11eca5ec3a020d369caeae973b7525af),
(0x11ecaf5864ae9b929dfd6e6cc125eef2, 'Samsung Test', 'aaa', 200, 'unavailable', 'testt', '2022-03-29 12:04:32', '2022-03-30 13:08:13', 0x11eca5ec3a020d369caeae973b7525af);

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE `product_image` (
  `uuid` binary(16) NOT NULL,
  `productUuid` binary(16) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `uuid` binary(16) NOT NULL,
  `productUuid` binary(16) NOT NULL,
  `orderUuid` binary(16) DEFAULT NULL,
  `status` enum('available','unavailable') NOT NULL DEFAULT 'available',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`uuid`, `productUuid`, `orderUuid`, `status`, `created`, `updated`) VALUES
(0x11ecaeab1fe34c18bde122bcd95e1283, 0x11eca9f49a604a609665c65ce4fc907a, 0x11ecaf3c78b245a698389af6db5e4ccb, 'unavailable', '2022-03-28 15:24:13', '2022-03-29 08:44:39'),
(0x11ecaeab1fe551169c1a22bcd95e1283, 0x11eca9f49a604a609665c65ce4fc907a, 0x11ecaf57fda5c880ace76e6cc125eef2, 'unavailable', '2022-03-28 15:24:13', '2022-03-29 12:01:39'),
(0x11ecaeab236b883cb02022bcd95e1283, 0x11eca60662815702ba05ae973b7525af, 0x11ecaeab5079b4ca815322bcd95e1283, 'unavailable', '2022-03-28 15:24:19', '2022-03-28 15:25:35'),
(0x11ecaeab236d7bba96b022bcd95e1283, 0x11eca60662815702ba05ae973b7525af, 0x11ecaeab5079b4ca815322bcd95e1283, 'unavailable', '2022-03-28 15:24:19', '2022-03-28 15:25:35'),
(0x11ecaeab26eab3ca856122bcd95e1283, 0x11eca605ce6a59c49a08ae973b7525af, 0x11ecaf3f931c663a8f0f9af6db5e4ccb, 'unavailable', '2022-03-28 15:24:25', '2022-03-29 09:06:52'),
(0x11ecaeab26ecb472811122bcd95e1283, 0x11eca605ce6a59c49a08ae973b7525af, 0x11ecaf57ed011c32867b6e6cc125eef2, 'unavailable', '2022-03-28 15:24:25', '2022-03-29 12:01:11'),
(0x11ecaeab2a5530c6871f22bcd95e1283, 0x11eca6056fe2a94299c6ae973b7525af, 0x11ecaf57fda5c880ace76e6cc125eef2, 'unavailable', '2022-03-28 15:24:31', '2022-03-29 12:01:39'),
(0x11ecaeab2a57324099e322bcd95e1283, 0x11eca6056fe2a94299c6ae973b7525af, 0x11ecaf5805c15b4ca0026e6cc125eef2, 'unavailable', '2022-03-28 15:24:31', '2022-03-29 12:01:53'),
(0x11ecaeab2d3cecac83c922bcd95e1283, 0x11eca6050ff9166ab1ecae973b7525af, 0x11ecaf57fda5c880ace76e6cc125eef2, 'unavailable', '2022-03-28 15:24:36', '2022-03-29 12:01:39'),
(0x11ecaeab2d3eed18b16b22bcd95e1283, 0x11eca6050ff9166ab1ecae973b7525af, 0x11ecaf5805c15b4ca0026e6cc125eef2, 'unavailable', '2022-03-28 15:24:36', '2022-03-29 12:01:53'),
(0x11ecaeab3044f00c814822bcd95e1283, 0x11eca5eeb917221c8ac4ae973b7525af, 0x11ecaf57fda5c880ace76e6cc125eef2, 'unavailable', '2022-03-28 15:24:41', '2022-03-29 12:01:39'),
(0x11ecaeab3046f3e8b69422bcd95e1283, 0x11eca5eeb917221c8ac4ae973b7525af, 0x11ecaf5805c15b4ca0026e6cc125eef2, 'unavailable', '2022-03-28 15:24:41', '2022-03-29 12:01:53'),
(0x11ecaeab338207bea7da22bcd95e1283, 0x11eca5ec3a045a008972ae973b7525af, 0x11ecaf57fda5c880ace76e6cc125eef2, 'unavailable', '2022-03-28 15:24:46', '2022-03-29 12:01:39'),
(0x11ecaeab3383ede0b66d22bcd95e1283, 0x11eca5ec3a045a008972ae973b7525af, 0x11ecaf5805c15b4ca0026e6cc125eef2, 'unavailable', '2022-03-28 15:24:46', '2022-03-29 12:01:53'),
(0x11ecaf6eb232e7869daf6e6cc125eef2, 0x11eca60662815702ba05ae973b7525af, 0x11ecaf6ec0e125ae94e06e6cc125eef2, 'unavailable', '2022-03-29 14:44:11', '2022-03-29 14:44:35'),
(0x11ecb01287986b82b795566b9d318ac8, 0x11eca9f49a604a609665c65ce4fc907a, NULL, 'available', '2022-03-30 10:16:57', '2022-03-30 10:16:57'),
(0x11ecb012879c8f82ae41566b9d318ac8, 0x11eca9f49a604a609665c65ce4fc907a, NULL, 'available', '2022-03-30 10:16:57', '2022-03-30 10:16:57'),
(0x11ecb012879e8b7a9005566b9d318ac8, 0x11eca9f49a604a609665c65ce4fc907a, NULL, 'available', '2022-03-30 10:16:57', '2022-03-30 10:16:57'),
(0x11ecb0128c41559088dc566b9d318ac8, 0x11eca6050ff9166ab1ecae973b7525af, 0x11ecb02f5e16e3a29235222115dcae8f, 'unavailable', '2022-03-30 10:17:05', '2022-03-30 13:43:23'),
(0x11ecb0128c438fa4bf2a566b9d318ac8, 0x11eca6050ff9166ab1ecae973b7525af, NULL, 'available', '2022-03-30 10:17:05', '2022-03-30 10:17:05'),
(0x11ecb01292474a769375566b9d318ac8, 0x11eca60662815702ba05ae973b7525af, NULL, 'available', '2022-03-30 10:17:15', '2022-03-30 10:17:15'),
(0x11ecb012924974aeba17566b9d318ac8, 0x11eca60662815702ba05ae973b7525af, NULL, 'available', '2022-03-30 10:17:15', '2022-03-30 10:17:15');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uuid` binary(16) NOT NULL,
  `identity` varchar(100) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `status` enum('pending','active') NOT NULL DEFAULT 'pending',
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0',
  `hash` varchar(100) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uuid`, `identity`, `slug`, `password`, `status`, `isDeleted`, `hash`, `created`, `updated`) VALUES
(0x11ec9bca7ee148da93814eaed857920e, 'geo@gmail.com', NULL, '$2y$10$BVMz.1DGjYOACN2teH5B7ueHut9ie9iJgqmvwwsbgwaqLmqz8gk0e', 'active', 0, 'ab047d5aa12ba25c768ac418c793f443b937cd9db43e571d83489078ee55823d', '2022-03-04 14:50:55', '2022-03-04 14:52:20'),
(0x11eca86197bc79ee986e7ad5f85a87f7, 'andrei@gmail.com', NULL, '$2y$10$qiaBemXDE423JzDGDB7MpOmxPrgfj8taJADF7U4TJQmVGfi2pG6jW', 'active', 0, '62bdf4d48be1ab37b96895eb13e600a242268254f4d75e5e1a9e0a30c5511e58', '2022-03-20 15:22:45', '2022-03-20 15:22:57'),
(0x11eca861e98baa6aab8a7ad5f85a87f7, 'darius@gmail.com', NULL, '$2y$10$GUMwst37xwfkmtzp0.NmOuFYmxhMTtAfwETeIDEXEVeB3Q7iLEbKK', 'active', 0, '7db50c212cc5b5913bb4f51aa2bd9ec54a0a3c8a68404cea1ad402f0ad93e6f4', '2022-03-20 15:25:02', '2022-03-22 09:54:04');

-- --------------------------------------------------------

--
-- Table structure for table `user_avatar`
--

CREATE TABLE `user_avatar` (
  `uuid` binary(16) NOT NULL,
  `userUuid` binary(16) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_avatar`
--

INSERT INTO `user_avatar` (`uuid`, `userUuid`, `name`, `created`, `updated`) VALUES
(0x11ecb0004cad7ea2bd19566b9d318ac8, 0x11ec9bca7ee148da93814eaed857920e, 'avatar-6d54421c-b000-11ec-bed7-566b9d318ac8.jpg', '2022-03-30 08:06:27', '2022-03-30 08:07:22');

-- --------------------------------------------------------

--
-- Table structure for table `user_detail`
--

CREATE TABLE `user_detail` (
  `uuid` binary(16) NOT NULL,
  `userUuid` binary(16) NOT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_detail`
--

INSERT INTO `user_detail` (`uuid`, `userUuid`, `firstName`, `lastName`, `created`, `updated`) VALUES
(0x11ec9bca7ee1b0d687e44eaed857920e, 0x11ec9bca7ee148da93814eaed857920e, 'George', 'Trifa', '2022-03-04 14:50:55', '2022-03-20 17:52:39'),
(0x11eca86197bc866e938c7ad5f85a87f7, 0x11eca86197bc79ee986e7ad5f85a87f7, 'Andrei', 'Stanciu', '2022-03-20 15:22:45', '2022-03-20 17:50:00'),
(0x11eca861e98bb4ce8c027ad5f85a87f7, 0x11eca861e98baa6aab8a7ad5f85a87f7, 'Darius', 'Nica', '2022-03-20 15:25:02', '2022-03-20 17:50:10');

-- --------------------------------------------------------

--
-- Table structure for table `user_order`
--

CREATE TABLE `user_order` (
  `uuid` binary(16) NOT NULL,
  `userUuid` binary(16) NOT NULL,
  `status` enum('pending','completed') NOT NULL DEFAULT 'pending',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_order`
--

INSERT INTO `user_order` (`uuid`, `userUuid`, `status`, `created`, `updated`) VALUES
(0x11ecaeab5079b4ca815322bcd95e1283, 0x11ec9bca7ee148da93814eaed857920e, 'pending', '2022-03-28 15:25:35', '2022-03-28 15:25:35'),
(0x11ecaf3c78b245a698389af6db5e4ccb, 0x11ec9bca7ee148da93814eaed857920e, 'pending', '2022-03-29 08:44:39', '2022-03-29 08:44:39'),
(0x11ecaf3f931c663a8f0f9af6db5e4ccb, 0x11ec9bca7ee148da93814eaed857920e, 'pending', '2022-03-29 09:06:52', '2022-03-29 09:06:52'),
(0x11ecaf57ed011c32867b6e6cc125eef2, 0x11ec9bca7ee148da93814eaed857920e, 'pending', '2022-03-29 12:01:11', '2022-03-29 12:01:11'),
(0x11ecaf57fda5c880ace76e6cc125eef2, 0x11ec9bca7ee148da93814eaed857920e, 'pending', '2022-03-29 12:01:39', '2022-03-29 12:01:39'),
(0x11ecaf5805c15b4ca0026e6cc125eef2, 0x11ec9bca7ee148da93814eaed857920e, 'pending', '2022-03-29 12:01:52', '2022-03-29 12:01:53'),
(0x11ecaf6ec0e125ae94e06e6cc125eef2, 0x11eca861e98baa6aab8a7ad5f85a87f7, 'pending', '2022-03-29 14:44:35', '2022-03-29 14:44:35'),
(0x11ecb02f5e16e3a29235222115dcae8f, 0x11ec9bca7ee148da93814eaed857920e, 'pending', '2022-03-30 13:43:22', '2022-03-30 13:43:23');

-- --------------------------------------------------------

--
-- Table structure for table `user_reset_password`
--

CREATE TABLE `user_reset_password` (
  `uuid` binary(16) NOT NULL,
  `userUuid` binary(16) DEFAULT NULL,
  `hash` varchar(100) NOT NULL,
  `status` enum('completed','requested') NOT NULL DEFAULT 'requested',
  `expires` timestamp NULL DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `uuid` binary(16) NOT NULL,
  `name` varchar(150) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`uuid`, `name`, `created`, `updated`) VALUES
(0x11eaf2a3d994f820b7ee001aa006c7d1, 'admin', '2020-09-09 13:53:33', NULL),
(0x11eaf2a3d995e5aa9788001aa006c7d1, 'user', '2020-09-09 13:53:33', NULL),
(0x11eaf2a3d995e78a83c0001aa006c7d1, 'guest', '2020-09-09 13:53:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `userUuid` binary(16) NOT NULL,
  `roleUuid` binary(16) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`userUuid`, `roleUuid`, `created`, `updated`) VALUES
(0x11ec9bca7ee148da93814eaed857920e, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-04 14:50:55', NULL),
(0x11eca86197bc79ee986e7ad5f85a87f7, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-20 15:22:45', NULL),
(0x11eca861e98baa6aab8a7ad5f85a87f7, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-22 09:54:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `uuid` binary(16) NOT NULL,
  `userUuid` binary(16) NOT NULL,
  `value` text NOT NULL,
  `expireAt` datetime NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `userUuid` binary(16) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` enum('upvote','downvote','neutral') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'neutral'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `identity` (`identity`);

--
-- Indexes for table `admin_role`
--
ALTER TABLE `admin_role`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD PRIMARY KEY (`userUuid`,`roleUuid`),
  ADD KEY `roleUuid` (`roleUuid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `contact_message`
--
ALTER TABLE `contact_message`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `userID` (`userUuid`) USING BTREE,
  ADD KEY `productID` (`productUuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `categoryUuid` (`categoryUuid`);

--
-- Indexes for table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `productUuid` (`productUuid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `identity` (`identity`);

--
-- Indexes for table `user_avatar`
--
ALTER TABLE `user_avatar`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `userUuid` (`userUuid`);

--
-- Indexes for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `userUuid` (`userUuid`);

--
-- Indexes for table `user_order`
--
ALTER TABLE `user_order`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `user_reset_password`
--
ALTER TABLE `user_reset_password`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `hash` (`hash`),
  ADD KEY `userUuid` (`userUuid`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`userUuid`,`roleUuid`),
  ADD KEY `roleUuid` (`roleUuid`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `userUuid` (`userUuid`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`userUuid`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD CONSTRAINT `admin_roles_ibfk_1` FOREIGN KEY (`userUuid`) REFERENCES `admin` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_roles_ibfk_2` FOREIGN KEY (`roleUuid`) REFERENCES `admin_role` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`categoryUuid`) REFERENCES `category` (`uuid`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`productUuid`) REFERENCES `product` (`uuid`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user_avatar`
--
ALTER TABLE `user_avatar`
  ADD CONSTRAINT `user_avatar_ibfk_1` FOREIGN KEY (`userUuid`) REFERENCES `user` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD CONSTRAINT `user_detail_ibfk_1` FOREIGN KEY (`userUuid`) REFERENCES `user` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_reset_password`
--
ALTER TABLE `user_reset_password`
  ADD CONSTRAINT `user_reset_password_ibfk_1` FOREIGN KEY (`userUuid`) REFERENCES `user` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`userUuid`) REFERENCES `user` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`roleUuid`) REFERENCES `user_role` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_token`
--
ALTER TABLE `user_token`
  ADD CONSTRAINT `user_token_ibfk_1` FOREIGN KEY (`userUuid`) REFERENCES `user` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
