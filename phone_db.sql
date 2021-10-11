-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2021 at 04:37 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phone_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_phone_book`
--

CREATE TABLE `all_phone_book` (
  `id` int(11) NOT NULL,
  `prefix` varchar(4) NOT NULL COMMENT '+40=ro\r\n+39=de',
  `country_short_code` varchar(100) DEFAULT NULL COMMENT 'country short code IS02',
  `number` varchar(15) NOT NULL COMMENT 'left trimmed all the leading zeroes',
  `name` varchar(80) NOT NULL COMMENT 'associate or client name',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'last update timestamp',
  `deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `all_phone_book`
--

INSERT INTO `all_phone_book` (`id`, `prefix`, `country_short_code`, `number`, `name`, `updated_at`, `deleted`) VALUES
(1, '+40', 'RO', '368401454', 'Rome Contact', '2021-10-10 17:50:48', 0),
(2, '+380', 'UA', '637697939', 'Ukraine Contact', '2021-10-10 17:57:20', 0),
(3, '+49', 'DE', '3067894900', 'German Contact', '2021-10-10 17:57:50', 0),
(4, '+86', 'CN', '2885056019', 'China Contact', '2021-10-10 17:58:23', 0),
(5, '+7', 'RU', '9064313004', 'Russian Contact', '2021-10-10 17:59:36', 0),
(9, '+380', 'UA', '63769793', 'Ukraine Contact Deleted', '2021-10-10 18:37:21', 1),
(10, '+49', 'DE', '33744707611', 'German Contact Deleted', '2021-10-10 20:42:57', 1),
(14, '+92', 'PK', '3071990955', 'Pakistan Contact', '2021-10-11 11:33:29', 0);

-- --------------------------------------------------------

--
-- Table structure for table `all_phone_book_links`
--

CREATE TABLE `all_phone_book_links` (
  `link_id` int(11) NOT NULL COMMENT 'internal index',
  `phone_book_id` int(100) NOT NULL COMMENT 'all_phone_book.id',
  `table_id` int(11) NOT NULL COMMENT 'form_employees.employee_id',
  `table_name` varchar(100) NOT NULL COMMENT 'eg: form_employees'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_phone_book`
--
ALTER TABLE `all_phone_book`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_phone` (`prefix`,`number`);

--
-- Indexes for table `all_phone_book_links`
--
ALTER TABLE `all_phone_book_links`
  ADD PRIMARY KEY (`link_id`),
  ADD UNIQUE KEY `single_refference` (`phone_book_id`,`table_id`,`table_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all_phone_book`
--
ALTER TABLE `all_phone_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `all_phone_book_links`
--
ALTER TABLE `all_phone_book_links`
  MODIFY `link_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'internal index', AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
