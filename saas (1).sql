-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 27, 2016 at 02:07 AM
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
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `date_of_birth` date NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `saas_company`
--

INSERT INTO `saas_company` (`id`, `company_name`, `owner_first_name`, `owner_last_name`, `max_customers`, `max_employees`, `isActive`, `date_of_birth`, `email`) VALUES
(2, 'lg', 'anaki ', 'moto', 3, 2, 1, '2016-09-15', ''),
(24, 'sony', 'dylan', 'hnhnhh', 3, 2, 1, '2016-09-06', 'ghtyhgy@hty'),
(25, 'nirvana', 'jukhuo', 'yh', 1, 2, 1, '2016-09-21', 'tyjhy'),
(26, 'nirvanalll', 'jukhuo', 'yh', 1, 2, 1, '2016-09-21', 'tyjhy'),
(27, 'courts', 'dfedf', 'fdf', 3, 2, 1, '2016-09-21', 'asheef@gmail.com'),
(28, 'keshia', 'hhh', 'uuuu', 2, 2, 1, '2016-09-24', 'bryanblais1@gmail.com'),
(29, 'nexus', 'black', 'dylanblais', 1, 2, 1, '2016-09-18', 'bryanblais1@gmail.com');

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
(10, 24, 'mahebourg.sony.saasrepair1.xyz', 0, 0),
(11, 25, 'admin.nirvana.saasrepair1.xyz', 1, 1),
(12, 25, 'rosehill.nirvana.saasrepair1.xyz', 1, 1),
(13, 26, 'admin.nirvanalll.saasrepair1.xyz', 1, 1),
(14, 26, 'rosehill.nirvanalll.saasrepair1.xyz', 1, 1),
(15, 24, 'admin.sony.saasrepair1.xyz', 1, 1),
(16, 27, 'admin.courts.saasrepair1.xyz', 1, 1),
(17, 27, 'mahebourg.courts.saasrepair1.xyz', 1, 1),
(18, 27, 'portlouis.courts.saasrepair1.xyz', 1, 1),
(19, 27, 'rosebelle.courts.saasrepair1.xyz', 1, 1),
(20, 28, 'admin.keshia.saasrepair1.xyz', 1, 1),
(21, 28, 'mahebourg.keshia.saasrepair1.xyz', 1, 1),
(22, 29, 'admin.nexus.saasrepair1.xyz', 1, 1),
(23, 29, 'mahebourg.nexus.saasrepair1.xyz', 1, 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `saas_company_location`
--
ALTER TABLE `saas_company_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
