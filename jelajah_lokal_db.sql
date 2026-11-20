-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20261110.f2beb4ceee
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 20, 2026 at 09:52 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jelajah_lokal_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `destinasi_wisata`
--
CREATE TABLE `destinasi_wisata` (
  `id` int NOT NULL,
  `nama_tempat` varchar(150) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga_tiket` int NOT NULL,
  `gambar_url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `destinasi_wisata`
--

INSERT INTO `destinasi_wisata` (`id`, `nama_tempat`, `kategori`, `lokasi`, `deskripsi`, `harga_tiket`, `gambar_url`, `created_at`) VALUES
(5, 'Museum Konferensi Asia Afrika', 'Sejarah & Edukasi', 'Jl. Asia Afrika No.65, Bandung', 'Museum bersejarah yang memperingati Konferensi Asia-Afrika tahun 1955. Menyimpan berbagai koleksi foto arsip konferensi, pidato pemimpin dunia, dan ruang sidang utama yang megah dengan arsitektur art deco.', 5000, 'http://localhost/HiddenGems/frontend/images/museum.jpg', '2026-11-18 12:46:46'),
(6, 'Gunung Burangrang', 'Alam', 'Bandung Barat', 'Gunung Burangrang adalah gunung non-aktif dengan ketinggian 2.050 meter di atas permukaan laut(mpdp) dan termasuk bagian dari Pegunungan Sunda Purba, bersebelahan dengan Gunung Tangkuban Perahu Lokasinya dapat diakses dari beberapa titik, termasuk Desa Kertawangi, Kecamatan Cisarua, Kabupaten Bandung Barat, serta wilayah Cikalong Wetan di Purwakarta', 30000, 'http://localhost/HiddenGems/frontend/images/gunung.jpg', '2026-11-18 12:50:53'),
(8, 'Curug Malela', 'Alam', 'Bandung Barat', 'Asal muasal penamaan Curug Malela diambil dari sebuah nama dari penguasa kawasan curug. Seperti kalian ketahui curug artinya air terjun sedangkan Malela diambil dari nama Eyang Tadjimalela. Konon katanya Eyang Tadjimalela terkadang akan menampakkan dirinya dengan sosok kakek-kakek berjenggot dengan menggunakan pakaian yang serba putih.', 10000, 'http://localhost/HiddenGems/frontend/images/curug.jpg', '2026-11-18 13:06:00'),
(9, 'Bakmi Pelita 2', 'Kuliner', 'Jl. PH. H. Mustofa Gg. Pelita II No. 3, Surapati, Bandung.', 'Di sebuah gang belakang kampus Universitas Widyatama terdapat tempat makan bakmi Halal yang enak, namanya Bakmi Pelita 2. Meskipun lokasinya tersembunyi dalam gang, tapi tempat ini cukup legendaris lho karena sudah ada di sini sejak 1998. Bakmi langganan anak kampus ini didirikan oleh Ibu Senli/Lili yang bernama asli Lie Ngiun Tjie.', 50000, 'https://nibble-images.b-cdn.net/nibble/original_images/hidden_bakmi_pelita_07daae3ffb.jpg', '2026-11-20 08:27:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'Budi', 'budi123@gmail.com', '$2y$10$XTxMnIlPf95FZpLBL4BLg.us.LbvL.TlIgnr865oJ75gw/cZShAEu', '2026-11-18 13:37:37', 'user'),
(2, 'admin', 'admin@gmail.com', '$2y$10$iZMXr51ogjkvS14iYTgT2e3yx/QZ9k3jJZyHPiZZ.PsZbOsuDS06i', '2026-11-19 00:08:49', 'admin'),
(3, 'Yono', 'yono@gmail.com', '$2y$10$10wp32KXisDr0ICxCxqcUOXlWaffoukKvlSOCD5aCFBES.onZ9Xja', '2026-11-20 08:23:13', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `destinasi_wisata`
--
ALTER TABLE `destinasi_wisata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `destinasi_wisata`
--
ALTER TABLE `destinasi_wisata`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
