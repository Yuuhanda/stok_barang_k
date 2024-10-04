-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2024 at 04:01 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stok_barang_k`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(60) NOT NULL,
  `sku` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `sku`) VALUES
(1, 'test barang ayyy', 'AAA123'),
(2, 'KMS Bismarck Model 1:75', 'BMS0001'),
(3, 'Laptop M3', 'LM3BAAAAA');

-- --------------------------------------------------------

--
-- Table structure for table `barang_unit`
--

CREATE TABLE `barang_unit` (
  `id_unit` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `status` enum('0','1','2','3') DEFAULT '0',
  `id_employee` int(11) DEFAULT NULL,
  `id_gudang` int(11) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `comment` varchar(60) NOT NULL,
  `serial_number` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang_unit`
--

INSERT INTO `barang_unit` (`id_unit`, `id_barang`, `status`, `id_employee`, `id_gudang`, `id_user`, `comment`, `serial_number`) VALUES
(2, 1, '0', NULL, 1, 1, 'available test', 'SN01'),
(3, 1, '1', 1, NULL, 1, 'in use test', 'SN02'),
(4, 1, '2', NULL, NULL, 1, 'in repair test', 'SN03'),
(5, 1, '3', NULL, NULL, 1, 'total lost test', 'SN04'),
(14, 2, '3', NULL, NULL, 1, 'Update test total loss. Water damage, spilt coffee', 'SN05'),
(15, 2, '2', NULL, NULL, 1, 'update test in repair. Sails and Steam Hobby Shop', 'SN06'),
(16, 3, '0', NULL, 3, 5, 'New Unit', 'LM3A001'),
(17, 3, '1', 2, NULL, 5, 'New Unit', 'LM3A002'),
(18, 3, '2', NULL, NULL, 5, 'In Repair in tech shop', 'LM3A003'),
(19, 3, '3', NULL, NULL, 5, 'Water damage on main board', 'LM3A004'),
(20, 3, '0', NULL, 2, 5, 'New Unit', 'LM3A005'),
(21, 3, '0', NULL, 1, 5, 'New Unit', 'LM3A006');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id_employee` int(11) NOT NULL,
  `emp_name` varchar(60) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id_employee`, `emp_name`, `phone`, `email`, `address`) VALUES
(1, 'Johan tumbal', '088888833', 'tumbalayymail@lmao.com', 'this address testtttt'),
(2, 'emma', '088811112222', 'emma@mail.com', 'jalan jalan');

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

CREATE TABLE `gudang` (
  `id_gudang` int(11) NOT NULL,
  `Nama_gudang` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gudang`
--

INSERT INTO `gudang` (`id_gudang`, `Nama_gudang`) VALUES
(1, 'GUDANG Bismarck test2'),
(2, 'Gudang Von Spee'),
(3, 'Gudang Hindenburg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `level` enum('0','1') DEFAULT '0',
  `nama_user` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `level`, `nama_user`, `email`, `password`) VALUES
(1, '0', 'ADMIN SUPER TEST', 'superadmin@mail.com', '123456'),
(2, '1', 'Normal low level admin', 'lowadmin@mail.com', '123456'),
(3, '1', 'New User Test update 2nd', '2ndnewuser@mail.com', '123456'),
(5, '0', 'His Highness Lord Of Poopenfarten Admin The Second', 'adminsecond@mail.com', '123456'),
(6, '1', 'low admin the 3rd', 'lomin@mail.com', '123456');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD UNIQUE KEY `id_barang` (`id_barang`);

--
-- Indexes for table `barang_unit`
--
ALTER TABLE `barang_unit`
  ADD PRIMARY KEY (`id_unit`),
  ADD UNIQUE KEY `id_unit` (`id_unit`),
  ADD KEY `barang_unit_fk1` (`id_barang`),
  ADD KEY `barang_unit_fk3` (`id_employee`),
  ADD KEY `barang_unit_fk4` (`id_gudang`),
  ADD KEY `barang_unit_fk5` (`id_user`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id_employee`),
  ADD UNIQUE KEY `id_employee` (`id_employee`);

--
-- Indexes for table `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`id_gudang`),
  ADD UNIQUE KEY `id_gudang` (`id_gudang`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `barang_unit`
--
ALTER TABLE `barang_unit`
  MODIFY `id_unit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id_employee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gudang`
--
ALTER TABLE `gudang`
  MODIFY `id_gudang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang_unit`
--
ALTER TABLE `barang_unit`
  ADD CONSTRAINT `barang_unit_fk1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`),
  ADD CONSTRAINT `barang_unit_fk3` FOREIGN KEY (`id_employee`) REFERENCES `employee` (`id_employee`),
  ADD CONSTRAINT `barang_unit_fk4` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id_gudang`),
  ADD CONSTRAINT `barang_unit_fk5` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
