-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2023 at 07:57 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `kodeKategori` int(11) NOT NULL,
  `namaKategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`kodeKategori`, `namaKategori`) VALUES
(1, 'Chicken'),
(2, 'Wagyu'),
(3, 'Local Cow'),
(4, 'Goat');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `kodePelanggan` int(11) NOT NULL,
  `alamatPelanggan` varchar(100) DEFAULT NULL,
  `passwordPelanggan` varchar(256) NOT NULL,
  `usernamePelanggan` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`kodePelanggan`, `alamatPelanggan`, `passwordPelanggan`, `usernamePelanggan`) VALUES
(5, 'Banyu Urip Va 112', 'a9f0e71fd97a882a27b3e2614026758a27de262ab3df7c18a01a7ff25e092ba5', 'g@gmail.com'),
(6, 'Telang Indah Timur Va 12', 'a9f0e71fd97a882a27b3e2614026758a27de262ab3df7c18a01a7ff25e092ba5', 'g2@gmail.com'),
(7, 'Land of Dawn 123', 'a9f0e71fd97a882a27b3e2614026758a27de262ab3df7c18a01a7ff25e092ba5', 'g3@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `kodeJabatan` int(11) NOT NULL,
  `namaJabatan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`kodeJabatan`, `namaJabatan`) VALUES
(1, 'admin'),
(2, 'manager');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `kodeKaryawan` int(11) NOT NULL,
  `kodeJabatan` int(11) DEFAULT NULL,
  `usernameKaryawan` varchar(100) DEFAULT NULL,
  `passwordKaryawan` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`kodeKaryawan`, `kodeJabatan`, `usernameKaryawan`, `passwordKaryawan`) VALUES
(4, 1, 'glendy', 'a9f0e71fd97a882a27b3e2614026758a27de262ab3df7c18a01a7ff25e092ba5'),
(5, 2, 'glendyM', 'a9f0e71fd97a882a27b3e2614026758a27de262ab3df7c18a01a7ff25e092ba5');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE `orderdetail` (
  `kodeProduk` int(11) NOT NULL,
  `kodePesanan` int(11) NOT NULL,
  `subHarga` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderdetail`
--

INSERT INTO `orderdetail` (`kodeProduk`, `kodePesanan`, `subHarga`, `qty`) VALUES
(72, 75, 845000, 5),
(72, 87, 676000, 4),
(73, 82, 500000, 1),
(73, 83, 2500000, 5),
(77, 84, 59000, 1),
(79, 76, 69000, 1),
(79, 81, 69000, 1),
(80, 79, 99000, 1),
(80, 86, 99000, 1),
(80, 89, 198000, 2),
(81, 75, 108000, 2),
(81, 77, 54000, 1),
(81, 78, 54000, 1),
(83, 87, 117000, 3),
(84, 88, 34000, 1),
(86, 80, 200000, 5),
(86, 85, 120000, 3),
(87, 81, 155000, 5),
(92, 80, 144000, 4),
(93, 80, 196000, 4),
(93, 87, 196000, 4),
(95, 75, 158000, 2),
(95, 88, 158000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `kodePesanan` int(11) NOT NULL,
  `kodePelanggan` int(11) NOT NULL,
  `tanggalPesan` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `keterangan` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`kodePesanan`, `kodePelanggan`, `tanggalPesan`, `keterangan`) VALUES
(75, 6, '2023-11-28 12:22:38', 'belum'),
(76, 7, '2023-11-28 12:56:01', 'sudah'),
(77, 7, '2023-11-28 12:56:30', 'sudah'),
(78, 7, '2023-11-28 13:01:23', 'sudah'),
(79, 7, '2023-11-28 13:07:42', 'sudah'),
(80, 5, '2023-11-29 06:40:03', 'sudah'),
(81, 5, '2023-11-29 07:05:56', 'sudah'),
(82, 7, '2023-11-29 06:42:06', 'sudah'),
(83, 7, '2023-11-30 02:58:55', 'sudah'),
(84, 5, '2023-11-29 07:06:21', 'sudah'),
(85, 5, '2023-11-29 07:07:20', 'sudah'),
(86, 5, '2023-11-29 07:07:42', 'sudah'),
(87, 5, '2023-11-29 09:06:09', 'sudah'),
(88, 7, '2023-11-30 02:59:06', 'belum'),
(89, 5, '2023-11-30 03:51:29', 'belum');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `kodePembayaran` int(11) NOT NULL,
  `kodePesanan` int(11) NOT NULL,
  `waktuBayar` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total` int(11) NOT NULL,
  `metode` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`kodePembayaran`, `kodePesanan`, `waktuBayar`, `total`, `metode`) VALUES
(3, 76, '2023-11-28 12:56:01', 69000, 'DANA'),
(4, 77, '2023-11-28 12:56:30', 54000, 'DANA'),
(5, 78, '2023-11-28 13:01:23', 54000, 'DANA'),
(6, 79, '2023-11-28 13:07:42', 99000, 'DANA'),
(7, 80, '2023-11-29 06:40:03', 540000, 'DANA'),
(8, 82, '2023-11-29 06:42:06', 500000, 'GOPAY'),
(9, 81, '2023-11-29 07:05:56', 224000, 'OVO'),
(10, 84, '2023-11-29 07:06:21', 59000, 'GOPAY'),
(11, 85, '2023-11-29 07:07:20', 120000, 'DANA'),
(12, 86, '2023-11-29 07:07:42', 99000, 'DANA'),
(13, 87, '2023-11-29 09:06:09', 989000, 'DANA'),
(14, 83, '2023-11-30 02:58:55', 2500000, 'DANA');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `kodeProduk` int(11) NOT NULL,
  `kodeKategori` int(11) NOT NULL,
  `kodeSuplaier` int(11) DEFAULT NULL,
  `namaProduk` varchar(100) NOT NULL,
  `gambarProduk` varchar(255) NOT NULL,
  `hargaProduk` int(11) NOT NULL,
  `stokProduk` int(11) NOT NULL,
  `deskripsiProduk` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`kodeProduk`, `kodeKategori`, `kodeSuplaier`, `namaProduk`, `gambarProduk`, `hargaProduk`, `stokProduk`, `deskripsiProduk`) VALUES
(71, 2, 18, 'Saikoro Wagyu Beef Cube', '65642600e95d2.jpeg', 160000, 119, '1 kg'),
(72, 2, 18, 'Tenderloin Meltique Wagyu', '656426a09b9fc.jpeg', 169000, 71, '800 gr'),
(73, 2, 18, 'Nishiawa Beef Yakiniku Cut', '656427722245a.jpeg', 500000, 126, '100 gr A5'),
(74, 2, 19, 'Wagyu Beef Thin Slices', '656428dfc006a.jpeg', 149000, 99, '200 gr'),
(75, 2, 19, 'Omi Beef', '6564298961c5b.jpeg', 600000, 155, '500 gram'),
(76, 2, 19, 'Wagyu Bone Marrow', '65642a5794092.jpeg', 49000, 199, '2 pcs'),
(77, 1, 16, 'Whole Chicken', '65642cecbfd65.jpeg', 59000, 179, '1 pcs'),
(78, 1, 16, 'Fillet Chicken Breast', '65642e749e66f.jpeg', 109000, 100, '1 kg'),
(79, 1, 16, 'Chicken Leg', '65642ee2085aa.jpeg', 69000, 186, '1 kg'),
(80, 1, 16, 'Fillet Chicken Thigh', '65642f45d915d.jpeg', 99000, 241, '1 kg'),
(81, 1, 16, 'Chicken Drumstick', '65642fd4d2397.jpeg', 54000, 108, '1 kg'),
(82, 1, 16, 'Chicken Wings', '656430540c883.jpeg', 49000, 176, '1 kg'),
(83, 1, 16, 'Chicken Neck', '656430f12b112.jpeg', 39000, 163, '1 kg'),
(84, 3, 17, 'Rib Eye', '65645e2437a88.jpeg', 34000, 63, '200 gr'),
(85, 3, 17, 'Chuck Eye', '65645e76b18c5.jpeg', 41000, 97, '200 gr'),
(86, 3, 17, 'T Bone', '65645efff21fd.jpeg', 40000, 114, '200 gr'),
(87, 3, 17, 'Round Cut', '65645f85ef738.jpeg', 31000, 129, '200 gr'),
(88, 3, 17, 'Brisket Cut', '65645fed8d890.jpeg', 46000, 235, '200 gr'),
(89, 3, 17, 'Tomahawk Cut', '656460c03e757.jpeg', 54000, 188, '400 gr'),
(90, 4, 20, 'Forequarter Cut', '656462000f93a.jpeg', 59000, 177, '250 gr'),
(91, 4, 20, 'Breast Flap', '6564631830ffc.jpeg', 54000, 43, '300 gr'),
(92, 4, 20, 'Leg Chump', '656464980879e.jpeg', 36000, 39, '200 gr'),
(93, 4, 20, 'Square Cut Shoulder', '6564651524f61.jpeg', 49000, 126, '300 gr'),
(94, 4, 20, 'Short Loin Goat', '65646579290a0.jpeg', 69000, 376, '400 gr'),
(95, 4, 20, 'Tenderloin Goat', '6564664359c7a.jpeg', 79000, 165, '300 gr');

-- --------------------------------------------------------

--
-- Table structure for table `suplaier`
--

CREATE TABLE `suplaier` (
  `kodeSuplaier` int(11) NOT NULL,
  `namaSuplaier` varchar(100) NOT NULL,
  `telpSuplaier` varchar(15) NOT NULL,
  `alamatSuplaier` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suplaier`
--

INSERT INTO `suplaier` (`kodeSuplaier`, `namaSuplaier`, `telpSuplaier`, `alamatSuplaier`) VALUES
(16, 'PT ABC Meat', '08123456789', 'Jl Raya No 123 Jakarta'),
(17, 'CV MeatLand', '087798765432', 'Jl Gatot Subroto No 45 Surabaya'),
(18, 'PT Sakura Import', '089654321098', 'Jl Importir No 7 Jakarta'),
(19, 'PT Nippon Delights', '081543215678', 'Jl Nihon No 5 Surabaya'),
(20, 'PT GoatKings', '08976543235', 'Jl Telang Indah Timur V no 11');

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE `wallet` (
  `kodeWallet` int(11) NOT NULL,
  `kodePelanggan` int(11) NOT NULL,
  `namaWallet` varchar(64) NOT NULL,
  `nomorWallet` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wallet`
--

INSERT INTO `wallet` (`kodeWallet`, `kodePelanggan`, `namaWallet`, `nomorWallet`) VALUES
(4, 5, 'DANA', '0987656743'),
(5, 5, 'GOPAY', '098765433345'),
(6, 5, 'OVO', '098886876857'),
(7, 6, 'DANA', '1234567899'),
(8, 6, 'GOPAY', '123456789000'),
(9, 6, 'OVO', '123456789011'),
(10, 7, 'DANA', '098767465323'),
(11, 7, 'GOPAY', '0976475831214'),
(12, 7, 'OVO', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`kodeKategori`) USING BTREE;

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`kodePelanggan`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`kodeJabatan`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`kodeKaryawan`),
  ADD UNIQUE KEY `usernameKaryawan` (`usernameKaryawan`),
  ADD KEY `fk_kodeJabatan` (`kodeJabatan`);

--
-- Indexes for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`kodeProduk`,`kodePesanan`),
  ADD KEY `fk_orders_orderdetail` (`kodePesanan`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`kodePesanan`),
  ADD KEY `FK_MEMESAN` (`kodePelanggan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`kodePembayaran`),
  ADD KEY `fk_kodePesanan` (`kodePesanan`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`kodeProduk`) USING BTREE,
  ADD KEY `fk_products_mempunyai_kategori` (`kodeKategori`) USING BTREE,
  ADD KEY `fk_kodeSuplaier` (`kodeSuplaier`);

--
-- Indexes for table `suplaier`
--
ALTER TABLE `suplaier`
  ADD PRIMARY KEY (`kodeSuplaier`);

--
-- Indexes for table `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`kodeWallet`),
  ADD KEY `fk_wallet_kodePelanggan` (`kodePelanggan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `kodeKategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `kodePelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `kodeJabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `kodeKaryawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `kodePesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `kodePembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `kodeProduk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `suplaier`
--
ALTER TABLE `suplaier`
  MODIFY `kodeSuplaier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `wallet`
--
ALTER TABLE `wallet`
  MODIFY `kodeWallet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `fk_kodeJabatan` FOREIGN KEY (`kodeJabatan`) REFERENCES `jabatan` (`kodeJabatan`);

--
-- Constraints for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `fk_orders_orderdetail` FOREIGN KEY (`kodePesanan`) REFERENCES `orders` (`kodePesanan`),
  ADD CONSTRAINT `fk_produk_orderdetail` FOREIGN KEY (`kodeProduk`) REFERENCES `products` (`kodeProduk`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_MEMESAN` FOREIGN KEY (`kodePelanggan`) REFERENCES `customers` (`kodePelanggan`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_kodePesanan` FOREIGN KEY (`kodePesanan`) REFERENCES `orders` (`kodePesanan`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_kodeSuplaier` FOREIGN KEY (`kodeSuplaier`) REFERENCES `suplaier` (`kodeSuplaier`),
  ADD CONSTRAINT `fk_products_mempunyai_kategori` FOREIGN KEY (`kodeKategori`) REFERENCES `categories` (`kodeKategori`) ON UPDATE CASCADE;

--
-- Constraints for table `wallet`
--
ALTER TABLE `wallet`
  ADD CONSTRAINT `fk_wallet_kodePelanggan` FOREIGN KEY (`kodePelanggan`) REFERENCES `customers` (`kodePelanggan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
