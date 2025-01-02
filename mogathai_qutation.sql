-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2024 at 05:44 PM
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
-- Database: `mogathai_qutation`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `date` date NOT NULL,
  `customer_name` text NOT NULL,
  `taxpayer_identification_number` text NOT NULL,
  `telephone_number` text NOT NULL,
  `address` text NOT NULL,
  `volume` text NOT NULL,
  `receipt_number` text NOT NULL,
  `order_number` text NOT NULL,
  `quotation_number` text NOT NULL,
  `make_payment` text NOT NULL,
  `subtotal` double NOT NULL,
  `vat` double NOT NULL,
  `grand_total` double NOT NULL,
  `payment` text NOT NULL,
  `payment_cash` text NOT NULL,
  `payment_check` text NOT NULL,
  `bank` text NOT NULL,
  `branch` text NOT NULL,
  `check_number` text NOT NULL,
  `check_date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`date`, `customer_name`, `taxpayer_identification_number`, `telephone_number`, `address`, `volume`, `receipt_number`, `order_number`, `quotation_number`, `make_payment`, `subtotal`, `vat`, `grand_total`, `payment`, `payment_cash`, `payment_check`, `bank`, `branch`, `check_number`, `check_date`) VALUES
('2024-12-23', '1', '3', '4', '2', '5', '6', '7', '8', '9', 240, 16.8, 256.8, 'การชำระเงินผ่านเงินสด', 'true', 'true', '10', '11', '12', '2024-12-23'),
('2024-12-23', '1', '3', '4', '2', '5', '6', '7', '8', '9', 240, 16.8, 256.8, '-', 'false', 'false', '10', '11', '12', '2024-12-23'),
('2024-12-23', '1', '3', '4', '2', '5', '6', '7', '8', '9', 240, 16.8, 256.8, '-', 'false', 'false', '10', '11', '12', '2024-12-23'),
('2024-12-23', '1', '3', '4', '2', '5', '6', '7', '8', '9', 240, 16.8, 256.8, 'เช็คธนาคาร10', 'false', 'true', '10', '11', '12', '2024-12-23'),
('2024-12-23', '1', '3', '4', '2', '5', '6', '7', '8', '9', 240, 16.8, 256.8, 'เช็คธนาคาร10', '', '1', '10', '11', '12', '2024-12-23'),
('2024-12-23', '1', '3', '4', '2', '5', '6', '7', '8', '9', 240, 16.8, 256.8, 'เช็คธนาคาร10', '', '1', '10', '11', '12', '2024-12-23'),
('2024-12-23', '1', '3', '4', '2', '5', '6', '7', '8', '9', 240, 16.8, 256.8, 'การชำระเงินผ่านเงินสด', '1', '1', '10', '11', '12', '2024-12-23');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `product_number` int(11) NOT NULL,
  `product_name` text NOT NULL,
  `product_unit` text NOT NULL,
  `product_price` double NOT NULL,
  `product_amount` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`product_number`, `product_name`, `product_unit`, `product_price`, `product_amount`) VALUES
(1, '13', '14', 16, 15),
(1, '13', '14', 16, 15),
(1, '13', '14', 16, 15),
(1, '13', '14', 16, 15),
(1, '13', '14', 16, 15),
(1, '13', '14', 16, 15),
(1, '13', '14', 16, 15),
(1, '13', '14', 16, 15),
(1, '13', '14', 16, 15),
(1, '13', '14', 16, 15),
(1, '13', '14', 16, 15);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
