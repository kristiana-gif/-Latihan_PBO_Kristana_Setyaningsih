-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 17, 2026 at 05:00 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_latihan_pbo`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_tiket`
--

CREATE TABLE `tabel_tiket` (
  `id_tiket` int NOT NULL,
  `nama_film` varchar(100) NOT NULL,
  `jadwal_tayang` datetime NOT NULL,
  `jumlah_kursi` int NOT NULL,
  `harga_dasar_tiket` decimal(10,2) NOT NULL,
  `jenis_studio` enum('Regular','IMAX','Velvet') NOT NULL,
  `tipe_audio` varchar(50) DEFAULT NULL,
  `lokasi_baris` varchar(10) DEFAULT NULL,
  `kacamata_3d_id` varchar(20) DEFAULT NULL,
  `efek_gerak_fitur` varchar(50) DEFAULT NULL,
  `bantal_selimut_pack` varchar(20) DEFAULT NULL,
  `layanan_butler` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tabel_tiket`
--

INSERT INTO `tabel_tiket` (`id_tiket`, `nama_film`, `jadwal_tayang`, `jumlah_kursi`, `harga_dasar_tiket`, `jenis_studio`, `tipe_audio`, `lokasi_baris`, `kacamata_3d_id`, `efek_gerak_fitur`, `bantal_selimut_pack`, `layanan_butler`, `created_at`) VALUES
(1, 'Avengers: Endgame', '2026-06-20 14:30:00', 2, 50000.00, 'Regular', 'Dolby Digital 5.1', 'C-12', NULL, NULL, NULL, NULL, '2026-06-17 04:46:49'),
(2, 'Spider-Man: No Way Home', '2026-06-20 17:00:00', 3, 45000.00, 'Regular', 'DTS-HD', 'D-08', NULL, NULL, NULL, NULL, '2026-06-17 04:46:49'),
(3, 'The Batman', '2026-06-21 13:00:00', 2, 48000.00, 'Regular', 'Dolby Atmos', 'E-15', NULL, NULL, NULL, NULL, '2026-06-17 04:46:49'),
(4, 'John Wick: Chapter 4', '2026-06-21 15:30:00', 1, 42000.00, 'Regular', 'Auro 3D', 'B-05', NULL, NULL, NULL, NULL, '2026-06-17 04:46:49'),
(5, 'Interstellar', '2026-06-21 20:00:00', 3, 55000.00, 'Regular', 'Dolby Digital 7.1', 'F-20', NULL, NULL, NULL, NULL, '2026-06-17 04:46:49'),
(6, 'Inception', '2026-06-22 14:00:00', 2, 52000.00, 'Regular', 'DTS:X', 'C-10', NULL, NULL, NULL, NULL, '2026-06-17 04:46:49'),
(7, 'Avatar: The Way of Water', '2026-06-20 15:00:00', 2, 75000.00, 'IMAX', NULL, NULL, 'IMAX-3D-001', 'D-BOX Motion', NULL, NULL, '2026-06-17 04:46:50'),
(8, 'Dune: Part Two', '2026-06-20 19:30:00', 4, 70000.00, 'IMAX', NULL, NULL, 'IMAX-3D-002', '4DX Dynamic', NULL, NULL, '2026-06-17 04:46:50'),
(9, 'Tenet', '2026-06-21 16:00:00', 3, 80000.00, 'IMAX', NULL, NULL, 'IMAX-3D-003', 'Motion Seat', NULL, NULL, '2026-06-17 04:46:50'),
(10, 'Top Gun: Maverick', '2026-06-21 19:00:00', 4, 78000.00, 'IMAX', NULL, NULL, 'IMAX-3D-004', 'D-BOX 2.0', NULL, NULL, '2026-06-17 04:46:50'),
(11, 'Mission: Impossible - Dead Reckoning', '2026-06-22 18:00:00', 2, 72000.00, 'IMAX', NULL, NULL, 'IMAX-3D-005', '4DX Motion', NULL, NULL, '2026-06-17 04:46:50'),
(12, 'The Dark Knight Rises', '2026-06-22 20:30:00', 3, 68000.00, 'IMAX', NULL, NULL, 'IMAX-3D-006', 'D-BOX Classic', NULL, NULL, '2026-06-17 04:46:50'),
(13, 'Oppenheimer', '2026-06-20 16:00:00', 2, 120000.00, 'Velvet', NULL, NULL, NULL, NULL, 'Premium Pack', 'Personal Butler Service', '2026-06-17 04:46:50'),
(14, 'Barbie', '2026-06-20 18:30:00', 3, 100000.00, 'Velvet', NULL, NULL, NULL, NULL, 'Deluxe Pack', '24/7 Concierge', '2026-06-17 04:46:50'),
(15, 'The Little Mermaid', '2026-06-21 13:30:00', 2, 110000.00, 'Velvet', NULL, NULL, NULL, NULL, 'Royal Pack', 'VIP Butler', '2026-06-17 04:46:50'),
(16, 'The Flash', '2026-06-21 16:30:00', 4, 95000.00, 'Velvet', NULL, NULL, NULL, NULL, 'Premium Pack', 'Personal Assistant', '2026-06-17 04:46:50'),
(17, 'Elemental', '2026-06-22 15:00:00', 3, 105000.00, 'Velvet', NULL, NULL, NULL, NULL, 'Deluxe Pack', 'Concierge Service', '2026-06-17 04:46:50'),
(18, 'The Super Mario Bros. Movie', '2026-06-22 17:30:00', 2, 98000.00, 'Velvet', NULL, NULL, NULL, NULL, 'Family Pack', 'Child Care Service', '2026-06-17 04:46:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_tiket`
--
ALTER TABLE `tabel_tiket`
  ADD PRIMARY KEY (`id_tiket`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_tiket`
--
ALTER TABLE `tabel_tiket`
  MODIFY `id_tiket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
