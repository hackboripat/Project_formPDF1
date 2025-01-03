-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2025 at 05:19 AM
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
-- Database: `purchase_request`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_purchase_order`
--

CREATE TABLE `detail_purchase_order` (
  `id` text DEFAULT NULL,
  `reason_purchase` text NOT NULL,
  `department` text NOT NULL,
  `volume` text NOT NULL,
  `receipt_number` text NOT NULL,
  `date` date NOT NULL,
  `agency` text NOT NULL,
  `delivery_date` date NOT NULL,
  `purchasing_department` text NOT NULL,
  `date_get_job` date NOT NULL,
  `journalist` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `detail_purchase_order`
--

INSERT INTO `detail_purchase_order` (`id`, `reason_purchase`, `department`, `volume`, `receipt_number`, `date`, `agency`, `delivery_date`, `purchasing_department`, `date_get_job`, `journalist`) VALUES
('1735877217677762614cf85', '1', '2', '3', '4', '2568-01-03', '5', '2025-01-03', '6', '2025-01-03', '7'),
('1735877327677762cf7b448', '1', '2', '3', '4', '2568-01-03', '5', '2025-01-03', '6', '2025-01-03', '7'),
('1735877345677762e1157f1', '1', '2', '3', '4', '2568-01-03', '5', '2025-01-03', '6', '2025-01-03', '7');

-- --------------------------------------------------------

--
-- Table structure for table `list_purchase_order`
--

CREATE TABLE `list_purchase_order` (
  `id` text DEFAULT NULL,
  `number` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `name_and_detail` text NOT NULL,
  `price_per_unit` float NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `list_purchase_order`
--

INSERT INTO `list_purchase_order` (`id`, `number`, `quantity`, `name_and_detail`, `price_per_unit`, `note`) VALUES
('1735877217677762614cf85', 1, 8, '9', 10, '11'),
('1735877217677762614cf85', 2, 12, '13', 14, '15'),
('1735877327677762cf7b448', 1, 8, '9', 10, '11'),
('1735877327677762cf7b448', 2, 12, '13', 14, '15'),
('1735877345677762e1157f1', 1, 8, '9', 10, '11'),
('1735877345677762e1157f1', 2, 12, '13', 14, '15');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
