-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2024 at 06:29 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bytebazaar`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `admin_pass` varchar(150) NOT NULL,
  `bb_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_email`, `admin_pass`, `bb_role`) VALUES
(1, 'admin@gmail.com', '$2y$10$meYoALsb.er1L35GFm.3uegY8rbYyVlHSbFUWzwqjeUtdkNIRD4TS', 3);

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `application_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `application_statement` varchar(250) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`application_id`, `seller_id`, `role_id`, `application_statement`, `status`) VALUES
(6, 6, 5, 'I am good with database', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `p_id` int(11) NOT NULL,
  `ip_add` varchar(50) NOT NULL,
  `c_id` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`p_id`, `ip_add`, `c_id`, `qty`) VALUES
(30, '::1', 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`) VALUES
(7, 'category2'),
(11, 'category6'),
(16, 'categoryn'),
(17, 'category 3'),
(18, 'Web Applications'),
(19, 'PWAs'),
(20, 'Cross Platform'),
(21, 'Native (Android)'),
(22, 'Native (IOS)'),
(23, 'Sites'),
(24, 'Aesthetics'),
(25, 'Miscellaneous');

-- --------------------------------------------------------

--
-- Table structure for table `commision`
--

CREATE TABLE `commision` (
  `commision_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `charge` double NOT NULL,
  `remainder` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `commision`
--

INSERT INTO `commision` (`commision_id`, `payment_id`, `project_id`, `charge`, `remainder`) VALUES
(16, 0, 31, 9, 51),
(17, 0, 31, 9, 51),
(18, 0, 31, 9, 51),
(19, 0, 30, 5, 45),
(20, 0, 31, 9, 51),
(21, 0, 31, 9, 51),
(22, 0, 31, 9, 51),
(23, 0, 31, 9, 51),
(24, 0, 31, 9, 51),
(25, 0, 31, 9, 51),
(26, 0, 30, 5, 45),
(27, 0, 31, 9, 51),
(28, 0, 31, 9, 51),
(29, 0, 31, 9, 51),
(30, 0, 30, 5, 45),
(31, 0, 31, 9, 51),
(32, 0, 31, 9, 51),
(33, 0, 31, 9, 51),
(34, 0, 30, 5, 45),
(35, 0, 31, 9, 51),
(36, 0, 31, 9, 51),
(37, 0, 31, 9, 51),
(38, 0, 30, 5, 45),
(39, 0, 31, 9, 51),
(40, 0, 31, 9, 51),
(41, 0, 31, 9, 51),
(42, 0, 30, 5, 45),
(43, 0, 31, 9, 51),
(44, 0, 31, 9, 51),
(45, 0, 31, 9, 51),
(46, 0, 30, 5, 45),
(47, 0, 30, 5, 45),
(48, 0, 31, 9, 51),
(49, 0, 31, 9, 51),
(50, 0, 31, 9, 51),
(51, 0, 30, 5, 45),
(52, 0, 31, 9, 51),
(53, 0, 31, 9, 51),
(54, 0, 31, 9, 51),
(55, 0, 30, 5, 45),
(56, 0, 30, 5, 45),
(57, 0, 31, 9, 51),
(58, 0, 31, 9, 51),
(59, 0, 31, 9, 51),
(60, 0, 31, 9, 51),
(61, 0, 30, 5, 45),
(62, 0, 31, 9, 51),
(63, 0, 31, 9, 51),
(64, 0, 31, 9, 51),
(65, 0, 30, 5, 45),
(66, 0, 30, 5, 45),
(67, 0, 31, 9, 51),
(68, 0, 31, 9, 51),
(69, 0, 31, 9, 51),
(70, 0, 31, 9, 51),
(71, 0, 31, 9, 51),
(72, 0, 30, 5, 45),
(73, 0, 31, 9, 51),
(74, 0, 31, 9, 51),
(75, 0, 31, 9, 51),
(76, 0, 30, 5, 45),
(77, 0, 30, 5, 45),
(78, 0, 31, 9, 51),
(79, 0, 31, 9, 51),
(80, 0, 31, 9, 51),
(81, 0, 31, 9, 51),
(82, 0, 31, 9, 51),
(83, 0, 31, 9, 51),
(84, 0, 30, 5, 45),
(85, 0, 31, 9, 51),
(86, 0, 31, 9, 51),
(87, 0, 31, 9, 51),
(88, 0, 30, 5, 45),
(89, 0, 30, 5, 45),
(90, 0, 31, 9, 51),
(91, 0, 31, 9, 51),
(92, 0, 31, 9, 51),
(93, 0, 31, 9, 51),
(94, 0, 31, 9, 51),
(95, 0, 31, 9, 51),
(96, 0, 31, 9, 51),
(97, 0, 30, 5, 45),
(98, 0, 31, 9, 51),
(99, 0, 31, 9, 51),
(100, 0, 31, 9, 51),
(101, 0, 30, 5, 45),
(102, 0, 30, 5, 45),
(103, 0, 31, 9, 51),
(104, 0, 31, 9, 51),
(105, 0, 31, 9, 51),
(106, 0, 31, 9, 51),
(107, 0, 31, 9, 51),
(108, 0, 31, 9, 51),
(109, 0, 31, 9, 51),
(110, 0, 30, 5, 45);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(50) NOT NULL,
  `customer_pass` varchar(150) NOT NULL,
  `customer_country` varchar(30) NOT NULL,
  `customer_city` varchar(30) NOT NULL,
  `customer_contact` varchar(15) NOT NULL,
  `customer_image` varchar(100) DEFAULT NULL,
  `bb_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_email`, `customer_pass`, `customer_country`, `customer_city`, `customer_contact`, `customer_image`, `bb_role`) VALUES
(9, 'Doron Uyi Pela', 'alepnorod@gmail.com', '$2y$10$baQGC4oCLYmzhvPEkEJameB8DxvLd.6Wzic30xU2IlmT0ruShLpw2', 'Nigeria', 'Lagos', '09064108594', NULL, 1),
(10, 'Doron Uyi Pela', 'doronpela3@gmail.com', '$2y$10$14Kh1Xj0nQXRX.GbkAV3kO81ePjbLND0c4KcYSU/FEHgjc21f1vfW', 'Nigeria', 'Lagos', '09064108594', NULL, 1),
(11, 'John', 'johndavid@gmail.com', '$2y$10$hi2iSbVcJwKsnMiTDjKOg.8744nrYf7l04YI/AM/sdtGImHKOf4lW', 'Nigeria', 'Lagos', '09064108594', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `pm_id1` int(11) NOT NULL,
  `pm_id2` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `pm_id1`, `pm_id2`, `text`, `sent_at`) VALUES
(1, 2, 4, 'Complete your task please', '2024-12-06 12:03:37'),
(2, 2, 4, 'Complete your task please', '2024-12-06 12:04:21'),
(3, 2, 2, 'You still have something pending\r\n', '2024-12-06 12:04:35'),
(4, 2, 7, 'Final task left', '2024-12-06 12:04:45'),
(5, 4, 2, 'Finish your work', '2024-12-06 12:07:16'),
(6, 4, 4, 'Do your work', '2024-12-06 12:09:58'),
(7, 4, 4, 'Do your work', '2024-12-06 12:20:10'),
(8, 4, 1, 'Hi creator', '2024-12-06 12:21:39'),
(9, 4, 2, 'Whatsup Ui designer\r\n', '2024-12-06 12:21:55'),
(10, 4, 2, 'Whatsuo UI designer?', '2024-12-06 12:22:16'),
(11, 1, 4, 'Hi john\r\n', '2024-12-06 12:25:57'),
(12, 4, 1, 'I saw your work breakdown structure. Its too complex.', '2024-12-06 12:27:26');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unique_detail` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`order_id`, `product_id`, `qty`, `unique_detail`) VALUES
(1, 31, 1, 53),
(1, 30, 1, 54);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `invoice_no` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `order_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `invoice_no`, `order_date`, `order_status`) VALUES
(68, 9, 0, '2024-12-07', 'Paid'),
(69, 9, 0, '2024-12-07', 'Paid'),
(70, 9, 0, '2024-12-07', 'Paid'),
(71, 9, 0, '2024-12-07', 'Paid'),
(72, 9, 0, '2024-12-07', 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `pay_id` int(11) NOT NULL,
  `amt` double NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `currency` text NOT NULL,
  `payment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`pay_id`, `amt`, `customer_id`, `order_id`, `currency`, `payment_date`) VALUES
(20, 60, 9, 1, 'USD', '2024-12-06'),
(21, 60, 9, 1, 'USD', '2024-12-06'),
(22, 60, 9, 1, 'USD', '2024-12-07'),
(23, 60, 9, 1, 'USD', '2024-12-07'),
(24, 50, 9, 1, 'USD', '2024-12-07'),
(25, 60, 9, 1, 'USD', '2024-12-07'),
(26, 60, 9, 1, 'USD', '2024-12-07'),
(27, 60, 9, 1, 'USD', '2024-12-07'),
(28, 50, 9, 1, 'USD', '2024-12-07'),
(29, 50, 9, 1, 'USD', '2024-12-07'),
(30, 50, 9, 1, 'USD', '2024-12-07'),
(31, 60, 9, 1, 'USD', '2024-12-07'),
(32, 60, 9, 1, 'USD', '2024-12-07'),
(33, 60, 9, 1, 'USD', '2024-12-07'),
(34, 60, 9, 1, 'USD', '2024-12-07'),
(35, 60, 9, 1, 'USD', '2024-12-07'),
(36, 60, 9, 1, 'USD', '2024-12-07'),
(37, 50, 9, 1, 'USD', '2024-12-07');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `project_cat` int(11) DEFAULT NULL,
  `project_title` varchar(200) NOT NULL,
  `project_price` double DEFAULT NULL,
  `project_desc` varchar(500) DEFAULT NULL,
  `project_image` varchar(100) DEFAULT NULL,
  `project_keywords` varchar(100) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `published` int(1) NOT NULL DEFAULT 0,
  `seller_id` int(11) NOT NULL,
  `sc1` varchar(255) DEFAULT NULL,
  `sc2` varchar(255) DEFAULT NULL,
  `sc3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `project_cat`, `project_title`, `project_price`, `project_desc`, `project_image`, `project_keywords`, `link`, `file`, `published`, `seller_id`, `sc1`, `sc2`, `sc3`) VALUES
(19, 16, 'Closet', 20, 'AI stylist', NULL, 'React, AI, machine learning', NULL, NULL, 0, 2, NULL, NULL, NULL),
(24, 11, 'Shopify clone', 20, 'An ecommerce clone of shopify that is better', NULL, 'E-commerce, React, WebApp', NULL, NULL, 0, 1, NULL, NULL, NULL),
(25, 16, 'Gym Management', 30, 'Website for managing gym membership', NULL, 'PHP, Laravel, WebApp', NULL, NULL, 0, 1, NULL, NULL, NULL),
(26, 7, 'Aamazon', 29.98, 'Amazon clone', NULL, 'E-commerce, React, WebApp', NULL, NULL, 0, 4, NULL, NULL, NULL),
(28, 16, 'Figma', 49.97, 'Figma clone', NULL, 'React, Framework, Team', NULL, NULL, 0, 1, NULL, NULL, NULL),
(29, 16, 'Project n', 50, 'new project', NULL, 'E-commerce, React, WebApp', NULL, NULL, 0, 2, NULL, NULL, NULL),
(30, 16, 'Project p', 50, 'Description of project p', '1733505470_model.jpg', 'React, AI, machine learning', 'https://themewagon.github.io/Bookly/', '1733505470_Bookly-1.0.0.zip', 1, 1, '', '', ''),
(31, 11, 'Woody', 60, 'For testing delete', '1733506840_dev_desk2.jpg', 'React, AI, machine learning', 'https://themewagon.github.io/woody/', '1733506840_woody-1.0.0.zip', 1, 1, '1733506840_sc1_simple_software_icon_banner.jpg', '1733506840_sc2_react.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `project_membership`
--

CREATE TABLE `project_membership` (
  `pm_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_membership`
--

INSERT INTO `project_membership` (`pm_id`, `seller_id`, `role_id`, `created_at`) VALUES
(9, 1, 12, '2024-12-06 02:16:30'),
(10, 4, 13, '2024-12-06 03:36:15'),
(11, 2, 15, '2024-12-06 03:39:10'),
(12, 7, 15, '2024-12-06 03:53:00'),
(13, 2, 16, '2024-12-06 11:30:20'),
(14, 1, 17, '2024-12-06 16:29:32'),
(15, 1, 18, '2024-12-06 17:39:22');

-- --------------------------------------------------------

--
-- Table structure for table `project_role`
--

CREATE TABLE `project_role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(30) NOT NULL,
  `project_id` int(11) NOT NULL,
  `taken` tinyint(4) NOT NULL DEFAULT 0,
  `description` varchar(255) DEFAULT NULL,
  `takings` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_role`
--

INSERT INTO `project_role` (`role_id`, `role_name`, `project_id`, `taken`, `description`, `takings`) VALUES
(1, 'UI designer', 1, 1, 'Design the UI', 30),
(2, 'Backend engineer', 1, 1, 'Backend logic', 30),
(3, 'UI designer', 1, 1, 'Design the UI', 20),
(4, 'Front End engineer', 24, 1, 'Design the interface', 20),
(5, 'Databse Admin', 25, 0, 'Manage the database', 20),
(6, 'UI designer', 26, 1, 'For designing amazon', 30),
(11, 'Backend Dev', 26, 1, 'Back end', 0),
(12, 'Creator', 28, 1, 'Creator', 29.98),
(13, 'Backend Dev', 28, 1, 'Develop the backend', 30),
(15, 'Front end developer', 28, 1, 'Figma front end dev', 30),
(16, 'Creator', 29, 1, 'Creator', 99.98),
(17, 'Creator', 30, 1, 'Creator', 100),
(18, 'Creator', 31, 1, 'Creator', 100);

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `seller_id` int(11) NOT NULL,
  `seller_name` varchar(100) NOT NULL,
  `seller_email` varchar(50) NOT NULL,
  `seller_pass` varchar(150) NOT NULL,
  `seller_country` varchar(30) NOT NULL,
  `seller_city` varchar(30) NOT NULL,
  `seller_contact` varchar(15) NOT NULL,
  `seller_image` varchar(100) DEFAULT NULL,
  `account_balance` double DEFAULT NULL,
  `bb_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`seller_id`, `seller_name`, `seller_email`, `seller_pass`, `seller_country`, `seller_city`, `seller_contact`, `seller_image`, `account_balance`, `bb_role`) VALUES
(1, 'First seller', 'doronpela@gmail.com', '$2y$10$bMhDuvZfIinBah2RVVrDb.H.NMScymmmuedOuMiHFJrOKzWJVwVM2', '', '', '', 'seller_1_1733349377.jpg', 4701, 2),
(2, 'Doron Uyi Pela', 'alepnorod@gmail.com', '$2y$10$LFHagExRKcDmDNq3df84vurcu4W2gNI6OpsQXCgih7AA93Fpx8j0q', 'Nigeria', 'Lagos', '09064108594', NULL, NULL, 2),
(4, 'John', 'johndavid@gmail.com', '$2y$10$7i5h5a1ysgAdlEJ9DML1Pu2W8e2Tsvzj2iyvZ6Crwnqm0UrZBnoMS', 'Nigeria', 'Lagos', '09064108594', NULL, NULL, 2),
(6, 'Seller4', 'seller4@gmail.com', '$2y$10$5YXAz4fJdke.G6skCc0lEuNpdNwif6ssy3A3Wzp8Op.cS7fe0CXl.', 'Nigeria', 'Lagos', '09064108594', NULL, NULL, 2),
(7, 'seller5', 'seller5@gmail.com', '$2y$10$QmzwzEZs434dlMm7Hh7kuOFl2uDOQ/HO9DSwH2DKRRB4NTtBPjCqm', 'Nigeria', 'Lagos', '09064108594', NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `seller_credit`
--

CREATE TABLE `seller_credit` (
  `credit_id` int(11) NOT NULL,
  `pm_id` int(11) NOT NULL,
  `remuneration` double DEFAULT NULL,
  `commision_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seller_credit`
--

INSERT INTO `seller_credit` (`credit_id`, `pm_id`, `remuneration`, `commision_id`) VALUES
(15, 15, 51, 0),
(16, 15, 51, 0),
(17, 15, 51, 0),
(18, 14, 45, 0),
(19, 15, 51, 0),
(20, 15, 51, 0),
(21, 15, 51, 0),
(22, 15, 51, 0),
(23, 15, 51, 0),
(24, 15, 51, 0),
(25, 14, 45, 0),
(26, 15, 51, 0),
(27, 15, 51, 0),
(28, 15, 51, 0),
(29, 14, 45, 0),
(30, 15, 51, 0),
(31, 15, 51, 0),
(32, 15, 51, 0),
(33, 14, 45, 0),
(34, 15, 51, 0),
(35, 15, 51, 0),
(36, 15, 51, 0),
(37, 14, 45, 0),
(38, 15, 51, 0),
(39, 15, 51, 0),
(40, 15, 51, 0),
(41, 14, 45, 0),
(42, 15, 51, 0),
(43, 15, 51, 0),
(44, 15, 51, 0),
(45, 14, 45, 0),
(46, 14, 45, 0),
(47, 15, 51, 0),
(48, 15, 51, 0),
(49, 15, 51, 0),
(50, 14, 45, 0),
(51, 15, 51, 0),
(52, 15, 51, 0),
(53, 15, 51, 0),
(54, 14, 45, 0),
(55, 14, 45, 0),
(56, 15, 51, 0),
(57, 15, 51, 0),
(58, 15, 51, 0),
(59, 15, 51, 0),
(60, 14, 45, 0),
(61, 15, 51, 0),
(62, 15, 51, 0),
(63, 15, 51, 0),
(64, 14, 45, 0),
(65, 14, 45, 0),
(66, 15, 51, 0),
(67, 15, 51, 0),
(68, 15, 51, 0),
(69, 15, 51, 0),
(70, 15, 51, 0),
(71, 14, 45, 0),
(72, 15, 51, 0),
(73, 15, 51, 0),
(74, 15, 51, 0),
(75, 14, 45, 0),
(76, 14, 45, 0),
(77, 15, 51, 0),
(78, 15, 51, 0),
(79, 15, 51, 0),
(80, 15, 51, 0),
(81, 15, 51, 0),
(82, 15, 51, 0),
(83, 14, 45, 0),
(84, 15, 51, 0),
(85, 15, 51, 0),
(86, 15, 51, 0),
(87, 14, 45, 0),
(88, 14, 45, 0),
(89, 15, 51, 0),
(90, 15, 51, 0),
(91, 15, 51, 0),
(92, 15, 51, 0),
(93, 15, 51, 0),
(94, 15, 51, 0),
(95, 15, 51, 0),
(96, 14, 45, 0),
(97, 15, 51, 0),
(98, 15, 51, 0),
(99, 15, 51, 0),
(100, 14, 45, 0),
(101, 14, 45, 0),
(102, 15, 51, 0),
(103, 15, 51, 0),
(104, 15, 51, 0),
(105, 15, 51, 0),
(106, 15, 51, 0),
(107, 15, 51, 0),
(108, 15, 51, 0),
(109, 14, 45, 0);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` int(11) NOT NULL,
  `pm_id` int(11) NOT NULL,
  `predecessor_task` int(11) DEFAULT NULL,
  `successor_task` int(11) DEFAULT NULL,
  `completed_attachment` varchar(255) DEFAULT NULL,
  `task_attachment` varchar(255) DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `task_name` varchar(50) DEFAULT NULL,
  `task_description` varchar(255) DEFAULT NULL,
  `delegate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `pm_id`, `predecessor_task`, `successor_task`, `completed_attachment`, `task_attachment`, `deadline`, `status`, `task_name`, `task_description`, `delegate`) VALUES
(1, 6, NULL, NULL, NULL, '1733381104_Literature Matrix.xlsx', '2024-12-21', 1, 'Task 1', 'Task first', 2),
(12, 0, NULL, NULL, NULL, '', '2024-12-20', 0, 'Task 2', 'Task 2 anyine', NULL),
(13, 0, NULL, NULL, NULL, '', '2024-12-20', 0, 'Task 2', 'Descript', 7),
(14, 0, NULL, NULL, NULL, '', '2024-12-25', 0, 'Task 5', 'Task 5 desc', 2),
(15, 9, NULL, NULL, NULL, NULL, '2024-12-11', 0, 'Task 1', 'For developing the backend', 4),
(16, 9, 15, NULL, '1733481632_RELIGION IN AFRICA--SOAN--227--FINAL PRESENTATIONS--FALL 2024--DEC 5.doc', NULL, '2024-12-14', 0, 'Task 2', 'For the Interface design', 2),
(17, 9, 16, NULL, NULL, '1733477990_Final_Updated_Literature_Matrix.xlsx', '2024-12-16', 0, 'Task 3', 'UI design', 7),
(18, 11, 17, 16, NULL, 'NULL', '2024-12-18', 0, 'Additional task', 'Bonus', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`admin_email`);

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`application_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD KEY `p_id` (`p_id`),
  ADD KEY `c_id` (`c_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `commision`
--
ALTER TABLE `commision`
  ADD PRIMARY KEY (`commision_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `customer_email` (`customer_email`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`unique_detail`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`pay_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `project_membership`
--
ALTER TABLE `project_membership`
  ADD PRIMARY KEY (`pm_id`);

--
-- Indexes for table `project_role`
--
ALTER TABLE `project_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`seller_id`),
  ADD UNIQUE KEY `email` (`seller_email`);

--
-- Indexes for table `seller_credit`
--
ALTER TABLE `seller_credit`
  ADD PRIMARY KEY (`credit_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `commision`
--
ALTER TABLE `commision`
  MODIFY `commision_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `unique_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `project_membership`
--
ALTER TABLE `project_membership`
  MODIFY `pm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `project_role`
--
ALTER TABLE `project_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `seller_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `seller_credit`
--
ALTER TABLE `seller_credit`
  MODIFY `credit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`p_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`c_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
