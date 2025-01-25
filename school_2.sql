-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2025 at 10:56 AM
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
-- Database: `school_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `role` enum('guru_biasa','guru_wali') DEFAULT 'guru_biasa',
  `telepon` varchar(15) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `mata_pelajaran` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `periode_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `nama`, `role`, `telepon`, `email`, `alamat`, `mata_pelajaran`, `password`, `periode_id`) VALUES
(11, 'Selin', 'guru_wali', '081234567893', 'selin@gmail.com', 'Jl. Cibogo', NULL, '$2y$10$Kd4ZMd/MvMgQjxdcI1oLhuSy.pWKgaM37acUvKohoArw.R6rkiPiK', 1),
(12, 'Devin', 'guru_wali', '081234567894', 'devin@gmail.com', 'Jl. Cibogo', NULL, '$2y$10$wpfQhbjFkz5jV4iTt9LmKefIUpS4h715a57WBZPOIGbKIQInlbL0G', 1),
(13, 'Jessica Anne', 'guru_biasa', '081234567895', 'anne@gmail.com', 'Jl. Prof Drg. Surya Sumantri No. 65 Bandung', NULL, '$2y$10$p.rzKNCxpeT7dV8XpisPSOQeS3wLTG3ihs6elUYh3aJFBW1mQQjJ2', 1),
(14, 'Christandy', 'guru_wali', '081234567896', 'chris@gmail.com', 'Jl. Cibogo No. 31', NULL, '$2y$10$H5GGAWEA989zyvBVoSlh4.EHZbMJRCMtANCNijgiZ4KC8sd4ya8Ga', 1),
(15, 'Asep Supardi', 'guru_biasa', '0815235236', 'asep@gmail.com', 'Jl. Rajawali', NULL, '$2y$10$RqbTzAcF1iY1.wmzWvQAHuLZ4arDPURFvYy/SXoEllAgN2WWOOmMe', 1),
(16, 'Kylie Jenner', 'guru_biasa', '08123456789', 'kylie@gmail.com', 'Jl. Beverly Hills', NULL, '$2y$10$w8lieycDvLhWM1hw8YpoQeXZa5.9ymD830q1rH7xy2a.4M9Q5NjSG', 1),
(17, 'Lolly', 'guru_biasa', '08123456789', 'lolly@gmail.com', 'Jl. Dago', NULL, '$2y$10$VLmKCmnAZpePKbFbfQjrLOBA62gppIMWXbuiIxJUGFIwbGMN90c8a', 3),
(18, 'Maya', 'guru_wali', '08123456789', 'maya@gmail.com', 'Jl Cibogo', NULL, '$2y$10$WOLruQAxnek/eOyxaiaBhuMFfEvVxtmjN/BkSbXIxOflssBenWp6i', 1),
(19, 'Mario', 'guru_wali', '08123456789', 'mario@gmail.com', 'Jl Cibogo', NULL, '$2y$10$s9r3IKmRnmRJdiDvjaaop.1Uv/0vZIU6jqJUoKHctbD0yW/xrSJ.y', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL,
  `id_mata_pelajaran` int(11) DEFAULT NULL,
  `id_guru` int(11) NOT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `hari` varchar(15) DEFAULT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `ruangan` varchar(20) DEFAULT NULL,
  `periode_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id`, `id_mata_pelajaran`, `id_guru`, `kelas`, `hari`, `jam_mulai`, `jam_selesai`, `ruangan`, `periode_id`) VALUES
(5, 14, 14, '10', 'Senin', '08:00:00', '09:00:00', 'X IPA', 1),
(6, 11, 11, '10', 'Senin', '09:00:00', '10:00:00', 'X IPA', 1),
(7, 10, 12, '11', 'Selasa', '07:00:00', '08:00:00', 'XI IPA', 1),
(8, 7, 12, '11', 'Rabu', '09:00:00', '10:00:00', 'XI IPA', 1),
(9, 13, 14, '12', 'Kamis', '08:00:00', '09:00:00', 'XII IPA', 1),
(10, 8, 11, '11', 'Kamis', '10:00:00', '11:00:00', 'XI IPS', 1),
(11, 6, 16, '10', 'Jumat', '13:00:00', '14:00:00', 'XII IPA', 1),
(12, 15, 15, '10', 'Selasa', '09:00:00', '10:00:00', 'Lapangan Olahraga', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `periode_id` int(11) DEFAULT NULL,
  `kelas_level` enum('X','XI','XII') NOT NULL,
  `kelas_type` enum('IPA','IPS') NOT NULL,
  `guru_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `periode_id`, `kelas_level`, `kelas_type`, `guru_id`) VALUES
(1, 1, 'X', 'IPA', 11),
(2, 1, 'XI', 'IPA', 12),
(3, 1, 'XII', 'IPA', 18),
(4, 1, 'X', 'IPS', 19),
(5, 1, 'XI', 'IPS', NULL),
(6, 1, 'XII', 'IPS', NULL),
(9, 3, 'X', 'IPA', NULL),
(11, 3, 'XI', 'IPA', NULL),
(12, 3, 'XII', 'IPA', NULL),
(13, 3, 'X', 'IPS', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `guru_pengajar` int(11) DEFAULT NULL,
  `periode_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`id`, `nama`, `guru_pengajar`, `periode_id`) VALUES
(6, 'Pendidikan Kewarganegaraan', 16, 1),
(7, 'Matematika Peminatan', 12, 1),
(8, 'Sosiologi', 11, 1),
(9, 'Kimia', 13, 1),
(10, 'Fisika', 12, 1),
(11, 'Bahasa Inggris', 11, 1),
(12, 'Sejarah', 14, 1),
(13, 'Bahasa Sunda', 14, 1),
(14, 'Bahasa Mandarin', 14, 1),
(15, 'Olahraga', 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `id_mata_pelajaran` int(11) DEFAULT NULL,
  `nilai_tugas` decimal(5,2) DEFAULT NULL,
  `nilai_uts` decimal(5,2) DEFAULT NULL,
  `nilai_uas` decimal(5,2) DEFAULT NULL,
  `tahun_ajaran` varchar(20) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `periode_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id`, `id_siswa`, `id_mata_pelajaran`, `nilai_tugas`, `nilai_uts`, `nilai_uas`, `tahun_ajaran`, `kelas`, `periode_id`) VALUES
(2, 6, 6, 100.00, 91.00, 86.00, '2024', '11', 1),
(3, 9, 8, 100.00, 74.00, 71.00, '2024', '10', 1),
(6, 9, 14, 0.00, 0.00, 0.00, '', '', 1),
(7, 10, 11, 90.00, 90.00, 60.00, '', '', 1),
(8, 8, 6, 90.00, 90.00, 90.00, '', '', 1),
(9, 8, 8, 70.00, 80.00, 100.00, '', '', 1),
(10, 8, 13, 90.00, 90.00, 95.00, '', '', 1),
(11, 16, 6, 90.00, 90.00, 90.00, '', '', 1),
(12, 17, 6, 80.00, 80.00, 80.00, '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `periode`
--

CREATE TABLE `periode` (
  `id` int(11) NOT NULL,
  `tahun_ajaran` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `periode`
--

INSERT INTO `periode` (`id`, `tahun_ajaran`) VALUES
(1, '2023/2024'),
(3, '2024/2025');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `agama` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `periode_id` int(11) NOT NULL,
  `status` varchar(20) DEFAULT 'Aktif',
  `kelas_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nama`, `kelas`, `alamat`, `telepon`, `jenis_kelamin`, `agama`, `email`, `tanggal_lahir`, `password`, `periode_id`, `status`, `kelas_id`) VALUES
(6, 'Jessica', '11', 'Jl. Pakar Timur IV ', '081234567890', 'P', 'Kristen', 'jessicaanne@gmail.com', '2002-08-21', '$2y$10$TNAOnfRoZUQB7g1VE5a4f.Ly8q7N83ZZr6ZPXL0aPB5LeLG9WNGGi', 1, 'Aktif', 1),
(8, 'Jonathan', '12', 'Jl. Cibogo', '081234567891', 'L', 'Kristen', 'joch@gmail.com', '2001-01-19', '$2y$10$V7WBPuLH1MGVA6rAtgD83O.xlSgWSJPzFCYZP7prNyYZgLxAcABQy', 1, 'Aktif', 1),
(9, 'Ujang', '10', 'Jl. Surya Sumantri', '081234567892', 'L', 'Buddha', 'ujang@gmail.com', '2003-01-01', '$2y$10$.fBZRMRlPk2CnZBFPmj6LuhK8OEJXdifSWXGPFYMO2Oikl9dGhBRm', 1, 'Aktif', 1),
(10, 'Ucup', '', 'Jl. Surya Sumantri', '08123456789', 'L', 'Islam', 'ucup@gmail.com', '2002-11-11', '$2y$10$y5O0eM0F34mbJONvkjyQmu.1jEf2alBmMUvnq7abLybrmXfXI/1XS', 1, 'Aktif', 1),
(11, 'Daniella', '', 'Jl Cibogo', '08123456789', 'P', 'Kristen', 'daniela@gmail.com', '2000-07-01', '$2y$10$8ovJOaz/jZNa8jXJ5BW.UOsWKHg5H3Kowfuthrn6CA5dg7YRMeOWW', 3, 'Aktif', NULL),
(12, 'Christian', '', 'Jl Cibogo', '0815235236', 'L', 'Buddha', 'christian@gmail.com', '2001-11-11', '$2y$10$mi4VO5gnmpikzkzcHKtBzef0iLZv0bc0MsA63CHv7pvlJxdIqaFWC', 3, 'Aktif', NULL),
(13, 'Udin', '', 'Jl. Cibogo No. 31', '08123456789', 'L', 'Islam', 'udin@gmail.com', '2000-12-12', '$2y$10$3q89oM47rtx5aqXKviNu5un3XwegJck0.DoW5kI6S9CZ4EgWiOw1.', 3, 'Aktif', NULL),
(14, 'Chelsea', '', 'Jl Bojongsoang', '08123456789', 'P', 'Kristen', 'chelsea@gmail.com', '2003-07-12', '$2y$10$9NTrd0R70DwRe66aoW7wVubr9uiR1ZMPzv2AG2Dp/0slKAv6GomIG', 1, 'Aktif', NULL),
(16, 'Milo', '', 'Jl Dago', '081234567895', 'L', 'Kristen', 'milo@gmail.com', '2002-01-01', '$2y$10$KBFQ.9Sgh1BaCerJLu5n3u6BiLM/DQACJx7qp74.HXi3IPOCMkPN6', 1, 'Aktif', 1),
(17, 'Maria', '', 'Jl Dago', '08123456789', 'P', 'Buddha', 'maria@gmail.com', '2002-01-01', '$2y$10$pIHcXOsORUdZRmJqG2.Jlu2QUfRm7bvATFagkrhIamh2m80W2IcpC', 1, 'Aktif', 1);

--
-- Triggers `siswa`
--
DELIMITER $$
CREATE TRIGGER `before_delete_siswa` BEFORE DELETE ON `siswa` FOR EACH ROW BEGIN
    IF EXISTS (SELECT 1 FROM `nilai` WHERE `id_siswa` = OLD.id) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Cannot delete siswa: related nilai data exists.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `siswa_mapel`
--

CREATE TABLE `siswa_mapel` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_mata_pelajaran` int(11) NOT NULL,
  `periode_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa_mapel`
--

INSERT INTO `siswa_mapel` (`id`, `id_siswa`, `id_mata_pelajaran`, `periode_id`) VALUES
(1, 9, 8, 1),
(4, 9, 14, 1),
(5, 10, 11, 1),
(12, 6, 6, 1),
(14, 8, 6, 1),
(15, 8, 6, 1),
(16, 8, 8, 1),
(17, 8, 13, 1),
(18, 16, 6, 1),
(19, 17, 6, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `periode_id` (`periode_id`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mata_pelajaran` (`id_mata_pelajaran`),
  ADD KEY `id_guru` (`id_guru`),
  ADD KEY `fk_periodeid` (`periode_id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_guru_wali` (`guru_id`),
  ADD KEY `fk_periode_id` (`periode_id`);

--
-- Indexes for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guru_pengajar` (`guru_pengajar`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nilai_ibfk_1` (`id_siswa`),
  ADD KEY `nilai_ibfk_2` (`id_mata_pelajaran`),
  ADD KEY `fk_periode_nilai_id` (`periode_id`);

--
-- Indexes for table `periode`
--
ALTER TABLE `periode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kelas` (`kelas_id`);

--
-- Indexes for table `siswa_mapel`
--
ALTER TABLE `siswa_mapel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_mapel` (`id_mata_pelajaran`),
  ADD KEY `fk_periodemapel` (`periode_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `periode`
--
ALTER TABLE `periode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `siswa_mapel`
--
ALTER TABLE `siswa_mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_ibfk_1` FOREIGN KEY (`periode_id`) REFERENCES `periode` (`id`);

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `fk_periodeid` FOREIGN KEY (`periode_id`) REFERENCES `periode` (`id`),
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`id_mata_pelajaran`) REFERENCES `mata_pelajaran` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id`) ON DELETE NO ACTION;

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `fk_periode_id` FOREIGN KEY (`periode_id`) REFERENCES `periode` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD CONSTRAINT `mata_pelajaran_ibfk_1` FOREIGN KEY (`guru_pengajar`) REFERENCES `guru` (`id`) ON DELETE NO ACTION;

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `fk_periode_nilai_id` FOREIGN KEY (`periode_id`) REFERENCES `periode` (`id`),
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`id_mata_pelajaran`) REFERENCES `mata_pelajaran` (`id`) ON DELETE NO ACTION;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `siswa_mapel`
--
ALTER TABLE `siswa_mapel`
  ADD CONSTRAINT `fk_periodemapel` FOREIGN KEY (`periode_id`) REFERENCES `periode` (`id`),
  ADD CONSTRAINT `siswa_mapel_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `siswa_mapel_ibfk_2` FOREIGN KEY (`id_mata_pelajaran`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
