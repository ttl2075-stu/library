-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 20, 2025 at 03:24 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thu_vien`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id_author` int NOT NULL,
  `ten` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `chuc_danh` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `dia_chi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id_sach` int NOT NULL,
  `ma_sach` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `ten_sach` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `linh_vuc` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_author`
--

CREATE TABLE `book_author` (
  `id1` int NOT NULL,
  `id_book` int NOT NULL,
  `id_author` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_category`
--

CREATE TABLE `book_category` (
  `id2` int NOT NULL,
  `id_book` int NOT NULL,
  `id_category` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_print`
--

CREATE TABLE `book_print` (
  `id_print` int NOT NULL,
  `ma_print` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `id_book` int NOT NULL,
  `id_nxb` int NOT NULL,
  `nam_xuat_ban` smallint NOT NULL,
  `so_trang` smallint NOT NULL,
  `kho_sach` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `gia` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `card_type`
--

CREATE TABLE `card_type` (
  `id_cd_type` int NOT NULL,
  `ten` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phat` int NOT NULL COMMENT '% giá sách',
  `sl_duoc_muon` int NOT NULL,
  `tg_muon` int NOT NULL COMMENT 'tính theo ngày',
  `tg_het_han` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `card_type`
--

INSERT INTO `card_type` (`id_cd_type`, `ten`, `phat`, `sl_duoc_muon`, `tg_muon`, `tg_het_han`) VALUES
(1, 'Thông thường', 10, 3, 30, 365);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id_category` int NOT NULL,
  `ten` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id_category`, `ten`) VALUES
(3, 'Báo'),
(2, 'Giáo trình'),
(1, 'Sách');

-- --------------------------------------------------------

--
-- Table structure for table `field`
--

CREATE TABLE `field` (
  `id_field` int NOT NULL,
  `ten` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `field`
--

INSERT INTO `field` (`id_field`, `ten`) VALUES
(1, 'Công nghệ thông tin'),
(13, 'Hoá học'),
(47, 'Vật lý');

-- --------------------------------------------------------

--
-- Table structure for table `phieu`
--

CREATE TABLE `phieu` (
  `id_phieu` int NOT NULL,
  `id_rd_card` int NOT NULL,
  `id_print` int NOT NULL,
  `ngay_muon` date NOT NULL,
  `ngay_het_han` date NOT NULL,
  `ngay_tra` date DEFAULT NULL,
  `muc_phat` int NOT NULL,
  `tien_phat` int DEFAULT '0',
  `tinh_trang_tra` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

CREATE TABLE `publisher` (
  `id_nxb` int NOT NULL,
  `ten` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dia_chi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `thanh_lap` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publisher`
--

INSERT INTO `publisher` (`id_nxb`, `ten`, `dia_chi`, `thanh_lap`) VALUES
(1, 'NXB Bách khoa Hà Nội', 'Số 1 Đường Đại Cồ Việt, Hai Bà Trưng , Hà Nội.', '2015-09-08'),
(2, 'NXB Trẻ', '161B Lý Chính Thắng, phường Võ Thị Sáu, Quận 3, TP. Hồ Chí Minh', '1981-03-24'),
(4, 'NXB Đại học Sư phạm Hà Nội', '136 Đường Xuân Thủy - Q.Cầu Giấy - Hà Nội', NULL),
(11, 'NXB Kim đồng', 'Hà Nội', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reader`
--

CREATE TABLE `reader` (
  `id_reader` int NOT NULL,
  `cccd` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ten` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `ngay_sinh` date NOT NULL,
  `chuc_danh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dia_chi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `sdt` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reader_card`
--

CREATE TABLE `reader_card` (
  `id_rd_card` int NOT NULL,
  `id_reader` int NOT NULL,
  `id_cd_type` int NOT NULL,
  `ngay_dk` date NOT NULL,
  `ngay_hh` date NOT NULL,
  `ky_gui` int NOT NULL,
  `sl_con_lai` smallint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','quanly','nhanvien','') COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `fullname`, `role`, `password`) VALUES
(1, 'admin', 'Quản trị viên', 'admin', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id_author`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id_sach`);

--
-- Indexes for table `book_author`
--
ALTER TABLE `book_author`
  ADD PRIMARY KEY (`id1`);

--
-- Indexes for table `book_category`
--
ALTER TABLE `book_category`
  ADD PRIMARY KEY (`id2`);

--
-- Indexes for table `book_print`
--
ALTER TABLE `book_print`
  ADD PRIMARY KEY (`id_print`),
  ADD UNIQUE KEY `ma_print` (`ma_print`);

--
-- Indexes for table `card_type`
--
ALTER TABLE `card_type`
  ADD PRIMARY KEY (`id_cd_type`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`),
  ADD UNIQUE KEY `name` (`ten`);

--
-- Indexes for table `field`
--
ALTER TABLE `field`
  ADD PRIMARY KEY (`id_field`),
  ADD UNIQUE KEY `name` (`ten`);

--
-- Indexes for table `phieu`
--
ALTER TABLE `phieu`
  ADD PRIMARY KEY (`id_phieu`);

--
-- Indexes for table `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`id_nxb`),
  ADD UNIQUE KEY `ten` (`ten`);

--
-- Indexes for table `reader`
--
ALTER TABLE `reader`
  ADD PRIMARY KEY (`id_reader`),
  ADD UNIQUE KEY `cccd` (`cccd`),
  ADD UNIQUE KEY `sdt` (`sdt`);

--
-- Indexes for table `reader_card`
--
ALTER TABLE `reader_card`
  ADD PRIMARY KEY (`id_rd_card`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id_author` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id_sach` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `book_author`
--
ALTER TABLE `book_author`
  MODIFY `id1` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `book_category`
--
ALTER TABLE `book_category`
  MODIFY `id2` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `book_print`
--
ALTER TABLE `book_print`
  MODIFY `id_print` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `card_type`
--
ALTER TABLE `card_type`
  MODIFY `id_cd_type` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `field`
--
ALTER TABLE `field`
  MODIFY `id_field` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `phieu`
--
ALTER TABLE `phieu`
  MODIFY `id_phieu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `publisher`
--
ALTER TABLE `publisher`
  MODIFY `id_nxb` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reader`
--
ALTER TABLE `reader`
  MODIFY `id_reader` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reader_card`
--
ALTER TABLE `reader_card`
  MODIFY `id_rd_card` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
