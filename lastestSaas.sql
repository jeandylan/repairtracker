-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 05, 2016 at 06:49 AM
-- Server version: 5.7.13-0ubuntu0.16.04.2
-- PHP Version: 7.0.8-0ubuntu0.16.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saas`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_07_05_091411_create_customers_table', 1),
('2016_07_05_091412_create_tickets_table', 1),
('2016_07_16_085455_create_invoices_table', 1),
('2016_07_16_142000_create_stocks_table', 1),
('2016_07_16_160156_create_suppliers_table', 1),
('2016_07_16_160220_create_stock_supplier_table', 1),
('2016_07_17_131134_create_stock_ticket_table', 1),
('2016_07_22_072844_create_employees_table', 1),
('2016_07_22_073202_create_employee_ticket_table', 1),
('2016_07_31_143545_create_customer_address_table', 1),
('2016_07_31_143606_create_customer_telephone_table', 1),
('2016_07_31_151711_create_customer_email_table', 1),
('2016_08_03_093130_create_employee_address_table', 1),
('2016_08_03_093159_create_employee_telephone_table', 1),
('2016_08_03_093212_create_employee_email_table', 1),
('2016_08_03_093232_create_supplier_address_table', 1),
('2016_08_03_093245_create_supplier_telephone_table', 1),
('2016_08_03_093253_create_supplier_email_table', 1),
('2016_09_05_154649_create_custom_text_field_table', 1),
('2016_09_05_154707_create_custom_text_field_data_table', 1),
('2016_09_12_090327_create_tickets_comments_table', 1),
('2016_09_16_162542_create_stocks_location_level', 1),
('2016_09_18_190540_create_stocking_history_table', 1),
('2016_09_18_190604_create_destocking_history', 1),
('2016_09_19_194939_create_estimations_table', 1),
('2016_09_19_200159_create_estimation_item_table', 1),
('2016_09_19_204526_create_estimation_labour_table', 1),
('2016_09_20_195206_create_invoice_labour_table', 1),
('2016_10_01_114626_create_saas_supporter_table', 1),
('2016_10_01_120515_create_saas_messages_table', 1),
('2016_10_01_121152_add_timestamps_to_saas_company', 1),
('2019_07_17_195747_add_foreign_keys_to_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `saas_admin`
--

CREATE TABLE `saas_admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isActive` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `saas_admin`
--

INSERT INTO `saas_admin` (`id`, `email`, `password`, `isActive`) VALUES
(1, 'dylanblais1@gmail.com', 'pass', 1),
(2, 'dylanblais@gmail.com', 'pass', 1);

-- --------------------------------------------------------

--
-- Table structure for table `saas_company`
--

CREATE TABLE `saas_company` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `owner_first_name` varchar(255) NOT NULL,
  `owner_last_name` varchar(255) NOT NULL,
  `max_customers` int(11) NOT NULL DEFAULT '3',
  `max_employees` int(11) NOT NULL DEFAULT '2',
  `isActive` int(11) NOT NULL DEFAULT '1',
  `valid_until` date NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `price_per_month` double(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `saas_company`
--

INSERT INTO `saas_company` (`id`, `company_name`, `owner_first_name`, `owner_last_name`, `max_customers`, `max_employees`, `isActive`, `valid_until`, `date_of_birth`, `email`, `price_per_month`, `created_at`, `updated_at`) VALUES
(2, 'lg', 'anaki', 'moto', 3, 2, 0, '0000-00-00', '0000-00-00', '', 0.00, NULL, '2016-10-02 15:00:51'),
(24, 'sony', 'dylan', 'hnhnhh', 3, 2, 1, '0000-00-00', '2016-09-06', 'ghtyhgy@hty', 0.00, NULL, NULL),
(25, 'nirvana', 'jukhuo', 'yh', 1, 2, 1, '0000-00-00', '2016-09-21', 'tyjhy', 0.00, NULL, NULL),
(26, 'nirvanalll', 'jukhuo', 'yh', 1, 2, 1, '0000-00-00', '2016-09-21', 'tyjhy', 0.00, NULL, NULL),
(27, 'courts', 'test1', 'fdf', 3, 2, 1, '0000-00-00', '2016-09-21', 'asheef@gmail.com', 0.00, NULL, NULL),
(28, 'The Company', 'The Name', 'The Last Name', 200, 2, 0, '0000-00-00', '2016-08-30', 'theemail@address.com', 220.00, '2016-10-02 15:10:15', '2016-10-03 04:58:12'),
(49, 'yahoo', 'joe', 'da', 33, 23, 1, '0000-00-00', '2016-10-02', 'joe.com', 81.50, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `saas_company_location`
--

CREATE TABLE `saas_company_location` (
  `id` int(11) NOT NULL,
  `saas_company_id` int(11) NOT NULL,
  `location_hostname` varchar(50) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `saas_company_location`
--

INSERT INTO `saas_company_location` (`id`, `saas_company_id`, `location_hostname`, `isAdmin`, `isActive`) VALUES
(1, 1, 'kkkk', 0, 1),
(2, 2, 'mahebourg.lg.saasrepair1.xyz', 0, 1),
(5, 17, '545.jm.saasrepair1.xyz', 1, 1),
(6, 18, '545.jmddd.saasrepair1.xyz', 1, 1),
(7, 20, 'admin.juyjt.saasrepair1.xyz', 1, 1),
(8, 21, 'admin.rihanna.saasrepair1.xyz', 1, 1),
(9, 22, 'admin.nirvana.saasrepair1.xyz', 1, 1),
(10, 24, 'mahebourg.sony.saasrepair1.xyz', 0, 1),
(11, 25, 'admin.nirvana.saasrepair1.xyz', 1, 1),
(12, 25, 'rosehill.nirvana.saasrepair1.xyz', 1, 1),
(13, 26, 'admin.nirvanalll.saasrepair1.xyz', 1, 1),
(14, 26, 'rosehill.nirvanalll.saasrepair1.xyz', 1, 1),
(15, 24, 'admin.sony.saasrepair1.xyz', 1, 1),
(16, 27, 'admin.courts.saasrepair1.xyz', 1, 1),
(17, 27, 'mahebourg.courts.saasrepair1.xyz', 1, 1),
(18, 27, 'portlouis.courts.saasrepair1.xyz', 1, 1),
(19, 27, 'rosebelle.courts.saasrepair1.xyz', 1, 1),
(20, 28, 'admin.The Company.saasrepair1.xyz', 1, 1),
(21, 28, 'locOne.The Company.saasrepair1.xyz', 1, 1),
(22, 28, 'locTwo.The Company.saasrepair1.xyz', 1, 1),
(49, 49, 'admin.yahoo.saasrepair1.xyz', 1, 1),
(50, 49, 'mahebourg.yahoo.saasrepair1.xyz', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `saas_messages`
--

CREATE TABLE `saas_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `saas_messages`
--

INSERT INTO `saas_messages` (`id`, `created_at`, `updated_at`, `name`, `email`, `subject`, `message`, `status`) VALUES
(1, '2016-10-02 11:43:41', '2016-10-02 11:43:41', 'Ubeid', 'ubeid@as.com', 'Test', 'test test test test test test test etst est ssete stes t ste st es teste st est es te t est se t est es t est est est et e st set es es t set es tes te stest est es tes te tes te st es tes ts tes t est set est es tes', 1),
(2, '2016-10-02 11:42:41', '2016-10-02 11:42:41', 'Ubeid Jamal', 'ubeidjamal@as.com', 'Test Space', 'test test test test test test test etst est ssete stes t ste st es teste st est es te t est se t est es t est est est et e st set es es t setsds ds ', 1),
(3, '2016-10-02 14:46:50', '2016-10-02 14:46:50', 'secundar ahseef', 'ahseef777@gmail.com', 'Repair Tracker', 'Test this awesome page', 0),
(4, '2016-10-02 16:37:39', '2016-10-02 16:37:39', 'Dylan Blais', 'Dylan@gmail.com', 'Repair Tracker', 'Dylan testing', 0);

-- --------------------------------------------------------

--
-- Table structure for table `saas_supporter`
--

CREATE TABLE `saas_supporter` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `clients` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `saas_supporter`
--

INSERT INTO `saas_supporter` (`id`, `created_at`, `updated_at`, `name`, `email`, `clients`, `status`) VALUES
(1, '2016-10-02 05:02:57', '2016-10-02 16:26:52', 'Ahseef', 'ahseef777@gmail.com', '3', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `saas_admin`
--
ALTER TABLE `saas_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saas_company`
--
ALTER TABLE `saas_company`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_name` (`company_name`);

--
-- Indexes for table `saas_company_location`
--
ALTER TABLE `saas_company_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saas_messages`
--
ALTER TABLE `saas_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saas_supporter`
--
ALTER TABLE `saas_supporter`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `saas_admin`
--
ALTER TABLE `saas_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `saas_company`
--
ALTER TABLE `saas_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `saas_company_location`
--
ALTER TABLE `saas_company_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `saas_messages`
--
ALTER TABLE `saas_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `saas_supporter`
--
ALTER TABLE `saas_supporter`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
