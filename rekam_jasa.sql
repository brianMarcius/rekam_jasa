-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2021 at 06:50 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rekam_jasa`
--

-- --------------------------------------------------------

--
-- Table structure for table `asset`
--

CREATE TABLE `asset` (
  `id_asset` int(11) NOT NULL,
  `idcat` int(11) NOT NULL,
  `idbrand` int(11) NOT NULL,
  `id_aloc` int(11) NOT NULL,
  `id_sup` int(11) NOT NULL,
  `idtipe` int(11) NOT NULL,
  `asset_no` varchar(50) NOT NULL,
  `nama_asset` varchar(50) NOT NULL,
  `sn` varchar(50) NOT NULL,
  `pd` date NOT NULL,
  `harga` varchar(50) NOT NULL,
  `status` enum('Active','Rusak','Hilang','Perbaikan') NOT NULL,
  `descr` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `asset`
--

INSERT INTO `asset` (`id_asset`, `idcat`, `idbrand`, `id_aloc`, `id_sup`, `idtipe`, `asset_no`, `nama_asset`, `sn`, `pd`, `harga`, `status`, `descr`) VALUES
(1, 6, 4, 1, 1, 2, 'ASSET00001', 'asdasdasdasdasd', '00200200020002', '2019-01-14', '150.000', 'Active', '');

-- --------------------------------------------------------

--
-- Table structure for table `asset_loc`
--

CREATE TABLE `asset_loc` (
  `id_aloc` int(11) NOT NULL,
  `aloc_no` varchar(50) NOT NULL,
  `aloc_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `asset_loc`
--

INSERT INTO `asset_loc` (`id_aloc`, `aloc_no`, `aloc_name`) VALUES
(1, 'ALOC00001', 'ndasuloasd');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `idbrand` int(11) NOT NULL,
  `namabrand` varchar(50) NOT NULL,
  `brand_no` varchar(50) NOT NULL,
  `idcat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`idbrand`, `namabrand`, `brand_no`, `idcat`) VALUES
(1, 'sayur', 'BRND00001', 7),
(2, 'darat', 'BRND00002', 6),
(3, 'laut', 'BRND00003', 6),
(4, 'air tawar', 'BRND00004', 6),
(5, 'mabur', 'BRND00005', 6),
(6, 'suket', 'BRND00006', 7),
(7, 'angkasa', 'BRND00007', 7);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `idcat` int(11) NOT NULL,
  `namacat` varchar(50) NOT NULL,
  `cat_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`idcat`, `namacat`, `cat_no`) VALUES
(6, 'kewan', 'CAT00001'),
(7, 'taneman', 'CAT00002'),
(9, 'tes', 'CAT00003');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `idcust` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `addr` varchar(150) NOT NULL,
  `phn` varchar(50) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `ins` date NOT NULL,
  `exp` date NOT NULL,
  `cust_no` varchar(50) NOT NULL,
  `id_type` enum('KTP','NPWP','PASSPORT','SIM') NOT NULL,
  `status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`idcust`, `nama`, `addr`, `phn`, `nik`, `ins`, `exp`, `cust_no`, `id_type`, `status`) VALUES
(9, 'kadalnggledak', 'kadalgurun', '1235+6214632', '08132132400003', '2021-09-01', '2021-11-30', 'CUST00001', 'NPWP', 'Active'),
(10, 'pitikss', 'kadalgurunas', '086769988554', '08132132400003', '2021-08-28', '2021-08-04', 'CUST00002', 'NPWP', 'Active'),
(12, 'ndasulo', 'goronggorong', '789789789', '456456456', '2021-10-01', '2021-10-10', 'CUST00003', 'SIM', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `jasa`
--

CREATE TABLE `jasa` (
  `idjasa` int(11) NOT NULL,
  `jasa_nama` varchar(128) DEFAULT NULL,
  `jasa_harga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jasa`
--

INSERT INTO `jasa` (`idjasa`, `jasa_nama`, `jasa_harga`) VALUES
(1, 'Jilid Biasa', 6000),
(3, 'Jilid Melingkar Biasa', 20000),
(4, 'Jilid Melingkar Press', 25000),
(5, 'Jilid Semi Lux', 40000),
(6, 'Jilid Lux/Hard Cover', 50000),
(7, 'Jilid Spiral Biasa (Ring Plastik)', 15000),
(8, 'ngudut', 21000);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `idpengguna` int(11) NOT NULL,
  `pengguna_nama` varchar(64) DEFAULT NULL,
  `pengguna_username` varchar(32) DEFAULT NULL,
  `pengguna_password` varchar(128) DEFAULT NULL,
  `pengguna_level` enum('Admin','User') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`idpengguna`, `pengguna_nama`, `pengguna_username`, `pengguna_password`, `pengguna_level`) VALUES
(1, 'Administrator', 'admin', '$2y$10$S3tmXPhEJbUXEqtatyx7ne18zgRsxLOUPiYcijXwJGHccUDc4yBNq', 'Admin'),
(2, 'User', 'user', '$2y$10$BhY35ynWc/wOfAdA1aRMvep.cmXJ976e9yjK4bogUiBMc34UQyjcy', 'User');

-- --------------------------------------------------------

--
-- Table structure for table `sup`
--

CREATE TABLE `sup` (
  `id_sup` int(11) NOT NULL,
  `sup_no` varchar(50) NOT NULL,
  `sup_name` varchar(50) NOT NULL,
  `sup_addr` varchar(50) NOT NULL,
  `sup_phn` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sup`
--

INSERT INTO `sup` (`id_sup`, `sup_no`, `sup_name`, `sup_addr`, `sup_phn`) VALUES
(1, 'SUP00001', 'helokiti', 'babydol', '987987987');

-- --------------------------------------------------------

--
-- Table structure for table `tipe`
--

CREATE TABLE `tipe` (
  `idtipe` int(11) NOT NULL,
  `namatipe` varchar(50) NOT NULL,
  `tipe_no` varchar(50) NOT NULL,
  `idcat` int(11) NOT NULL,
  `idbrand` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tipe`
--

INSERT INTO `tipe` (`idtipe`, `namatipe`, `tipe_no`, `idcat`, `idbrand`) VALUES
(1, 'kemambang', 'TYP00001', 7, 4),
(2, 'elel', 'TYP00002', 6, 4),
(3, 'tai', 'TYP00003', 7, 4),
(4, 'jmbt', 'TYP00004', 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `idtransaksi` int(11) NOT NULL,
  `jasa_id` int(11) NOT NULL,
  `transaksi_no` varchar(20) DEFAULT NULL,
  `transaksi_tgl` int(11) DEFAULT NULL,
  `transaksi_nama` varchar(128) DEFAULT NULL,
  `transaksi_jumlah` varchar(5) DEFAULT NULL,
  `transaksi_total_harga` varchar(15) DEFAULT NULL,
  `pengguna_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`idtransaksi`, `jasa_id`, `transaksi_no`, `transaksi_tgl`, `transaksi_nama`, `transaksi_jumlah`, `transaksi_total_harga`, `pengguna_id`) VALUES
(3, 6, 'TRX00003', 1615911472, 'Pelanggan 1', '2', '100000', 1),
(4, 3, 'TRX00004', 1632451729, 'Pelanngan 2', '5', '100000', 1),
(5, 6, 'TRX00005', 1632805614, 'Pelanggan asu', '96', '4800000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `un` varchar(50) NOT NULL,
  `pw` varchar(50) NOT NULL,
  `lv` enum('Admin','User') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `un`, `pw`, `lv`) VALUES
(1, 'bbbbbccc', 'aaaaaa', '$2y$10$fZJULPgt1U03LoOtp16ZIuBtEAJJVB2sqP8sou.HvES', 'User'),
(2, 'adminnn', 'admin', '$2y$10$Yy4Ji00BeeBU.Q7AeM4HL.keMjGptrdRhZwSN/iVbsw', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asset`
--
ALTER TABLE `asset`
  ADD PRIMARY KEY (`id_asset`),
  ADD KEY `fk_asset_brand` (`idbrand`),
  ADD KEY `fk_asset_cat` (`idcat`),
  ADD KEY `fk_asset_tipe` (`idtipe`),
  ADD KEY `fk_asset_aloc` (`id_aloc`),
  ADD KEY `fk_asset_sup` (`id_sup`);

--
-- Indexes for table `asset_loc`
--
ALTER TABLE `asset_loc`
  ADD PRIMARY KEY (`id_aloc`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`idbrand`),
  ADD KEY `fk_brand_cat` (`idcat`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`idcat`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`idcust`);

--
-- Indexes for table `jasa`
--
ALTER TABLE `jasa`
  ADD PRIMARY KEY (`idjasa`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`idpengguna`);

--
-- Indexes for table `sup`
--
ALTER TABLE `sup`
  ADD PRIMARY KEY (`id_sup`);

--
-- Indexes for table `tipe`
--
ALTER TABLE `tipe`
  ADD PRIMARY KEY (`idtipe`),
  ADD KEY `fk_tipe_brand` (`idbrand`),
  ADD KEY `fk_tipe_cat` (`idcat`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`idtransaksi`,`jasa_id`,`pengguna_id`),
  ADD KEY `fk_transaksi_jasa_idx` (`jasa_id`),
  ADD KEY `fk_transaksi_pengguna1_idx` (`pengguna_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asset`
--
ALTER TABLE `asset`
  MODIFY `id_asset` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `asset_loc`
--
ALTER TABLE `asset_loc`
  MODIFY `id_aloc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `idbrand` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `idcat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `idcust` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jasa`
--
ALTER TABLE `jasa`
  MODIFY `idjasa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `idpengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sup`
--
ALTER TABLE `sup`
  MODIFY `id_sup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tipe`
--
ALTER TABLE `tipe`
  MODIFY `idtipe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `idtransaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `asset`
--
ALTER TABLE `asset`
  ADD CONSTRAINT `fk_asset_aloc` FOREIGN KEY (`id_aloc`) REFERENCES `asset_loc` (`id_aloc`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_asset_brand` FOREIGN KEY (`idbrand`) REFERENCES `brand` (`idbrand`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_asset_cat` FOREIGN KEY (`idcat`) REFERENCES `category` (`idcat`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_asset_sup` FOREIGN KEY (`id_sup`) REFERENCES `sup` (`id_sup`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_asset_tipe` FOREIGN KEY (`idtipe`) REFERENCES `tipe` (`idtipe`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `brand`
--
ALTER TABLE `brand`
  ADD CONSTRAINT `fk_brand_cat` FOREIGN KEY (`idcat`) REFERENCES `category` (`idcat`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tipe`
--
ALTER TABLE `tipe`
  ADD CONSTRAINT `fk_tipe_brand` FOREIGN KEY (`idbrand`) REFERENCES `brand` (`idbrand`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tipe_cat` FOREIGN KEY (`idcat`) REFERENCES `category` (`idcat`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_transaksi_jasa` FOREIGN KEY (`jasa_id`) REFERENCES `jasa` (`idjasa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_transaksi_pengguna1` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`idpengguna`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
