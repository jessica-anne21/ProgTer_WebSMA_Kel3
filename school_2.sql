-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2025 at 06:17 PM
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
-- Database: `agmsdb`
--
CREATE DATABASE IF NOT EXISTS `agmsdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `agmsdb`;

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(10) NOT NULL,
  `AdminName` varchar(45) DEFAULT NULL,
  `UserName` varchar(50) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `UserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`) VALUES
(1, 'Admin', 'admin', 987654331, 'tester1@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2022-12-29 06:21:53');

-- --------------------------------------------------------

--
-- Table structure for table `tblartist`
--

CREATE TABLE `tblartist` (
  `ID` int(10) NOT NULL,
  `Name` varchar(250) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(250) DEFAULT NULL,
  `Education` mediumtext DEFAULT NULL,
  `Award` mediumtext DEFAULT NULL,
  `Profilepic` varchar(250) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblartist`
--

INSERT INTO `tblartist` (`ID`, `Name`, `MobileNumber`, `Email`, `Education`, `Award`, `Profilepic`, `CreationDate`) VALUES
(1, 'Mohan Das', 7987987987, 'mohan@gmail.com', 'Completed his fine arts from kg fine arts college.\r\nSpecialized in drawing and ceramic.', 'Winner of Hugo Boss Prize in 2019, MacArthur Fellowship\r\n', 'ecebbecf28c2692aeb021597fbddb174.jpg', '2022-12-21 13:31:25'),
(2, 'Dev', 3287987987, 'dev@gmail.com', 'Completed his fine arts from kg fine arts college.\r\nSpecialized in painting and ceramic.', 'Winner of Hugo Boss Prize in 2019, MacArthur Fellowship\r\n', 'ad04ad2d96ae326a9ca9de47d9e2fc74.jpg', '2022-12-21 13:31:25'),
(3, 'Kanha', 9687987987, 'kanha@gmail.com', 'Completed his fine arts from kg fine arts college.\r\nSpecialized in painting and ceramic.', 'Winner of Hugo Boss Prize in 2019, MacArthur Fellowship\r\n', 'ad04ad2d96ae326a9ca9de47d9e2fc74.jpg', '2022-12-21 13:31:25'),
(4, 'Abir Rajwansh', 5687987987, 'abir@gmail.com', 'Completed his fine arts from klijfine arts college.\r\nSpecialized in painting and ceramic.', 'Winner of Hugo Boss Prize in 2019, MacArthur Fellowship\r\n', 'ad04ad2d96ae326a9ca9de47d9e2fc74.jpg', '2022-12-21 13:31:25'),
(5, 'Krisna Dutt', 9187987987, 'krish@gmail.com', 'Completed his fine arts from kg fine arts college.\r\nSpecialized in painting and ceramic.', 'Winner of Hugo Boss Prize in 2019, MacArthur Fellowship\r\n', 'ad04ad2d96ae326a9ca9de47d9e2fc74.jpg', '2022-12-21 13:31:25'),
(6, 'Kajol Mannati', 8187987987, 'kajol@gmail.com', 'Completed his fine arts from kg fine arts college.\r\nSpecialized in painting and ceramic.', 'Winner of Hugo Boss Prize in 2019, MacArthur Fellowship\r\n', 'ad04ad2d96ae326a9ca9de47d9e2fc74.jpg', '2022-12-21 13:31:25'),
(7, 'Meera Singh', 2987987987, 'meera@gmail.com', 'Fine Arts in Painting from College of Art, New Delhi in 2012,\r\nSpecialized in printmaking and ceramic.', 'award-winning artist, and has received a scholarship from the Ministry of Culture, Government of India in 2014 as well as the Jean-Claude Reynal Scholarship (France) in 2019.\r\n', 'ad04ad2d96ae326a9ca9de47d9e2fc74.jpg', '2022-12-21 13:31:25'),
(8, 'Narayan Das', 9987987987, 'narayan@gmail.com', 'Completed his fine arts from hjai fine arts college.\r\nSpecialized in painting and ceramic.', 'Winner of Young Artist Award in 2009, MacArthur Fellowship\r\n', 'ad04ad2d96ae326a9ca9de47d9e2fc74.jpg', '2022-12-21 13:31:25');

-- --------------------------------------------------------

--
-- Table structure for table `tblartmedium`
--

CREATE TABLE `tblartmedium` (
  `ID` int(5) NOT NULL,
  `ArtMedium` varchar(250) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblartmedium`
--

INSERT INTO `tblartmedium` (`ID`, `ArtMedium`, `CreationDate`) VALUES
(1, 'Wood and Bronze', '2022-12-22 04:57:04'),
(2, 'Acrylic on canvas', '2022-12-22 04:57:34'),
(3, 'Resin', '2022-12-22 04:58:00'),
(4, 'Mixed Media', '2022-12-22 06:09:12'),
(5, 'Bronze', '2022-12-22 06:09:35'),
(6, 'Fibre', '2022-12-22 06:09:53'),
(7, 'Steel', '2022-12-22 06:10:16'),
(8, 'Metal', '2022-12-22 06:10:35'),
(9, 'Oil on Canvas', '2022-12-22 06:11:31'),
(10, 'Oil on Linen', '2022-12-22 06:12:12'),
(11, 'Acrylics on paper', '2022-12-22 06:13:11'),
(12, 'Hand-painted on particle wood/MDF', '2022-12-22 06:14:03');

-- --------------------------------------------------------

--
-- Table structure for table `tblartproduct`
--

CREATE TABLE `tblartproduct` (
  `ID` int(5) NOT NULL,
  `Title` varchar(250) DEFAULT NULL,
  `Dimension` varchar(250) DEFAULT NULL,
  `Orientation` varchar(100) DEFAULT NULL,
  `Size` varchar(100) DEFAULT NULL,
  `Artist` int(5) DEFAULT NULL,
  `ArtType` int(5) DEFAULT NULL,
  `ArtMedium` int(5) DEFAULT NULL,
  `SellingPricing` decimal(10,0) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `Image` varchar(250) DEFAULT NULL,
  `Image1` varchar(250) DEFAULT NULL,
  `Image2` varchar(250) DEFAULT NULL,
  `Image3` varchar(250) DEFAULT NULL,
  `Image4` varchar(250) DEFAULT NULL,
  `RefNum` int(10) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblartproduct`
--

INSERT INTO `tblartproduct` (`ID`, `Title`, `Dimension`, `Orientation`, `Size`, `Artist`, `ArtType`, `ArtMedium`, `SellingPricing`, `Description`, `Image`, `Image1`, `Image2`, `Image3`, `Image4`, `RefNum`, `CreationDate`) VALUES
(2, 'Radhe Krishna Painting', '56x56', 'Landscape', 'Medium', 1, 4, 9, 200, 'It is a painting of Radha Krishna.\r\nIt is a painting of Radha Krishna.\r\nIt is a painting of Radha Krishna.It is a painting of Radha Krishna.\r\nIt is a painting of Radha Krishna.It is a painting of Radha Krishna.It is a painting of Radha Krishna.', 'c565ad988a4c6fc0a9f429af43c47cce1671771454.jpg', '48424793dc9ea732f6118d4ba4326509.jpg', '', '', '', 586429003, '2022-12-23 04:57:34'),
(3, 'Shiv Tandav Painting', '100X50 inches', 'Potrait', 'Large', 6, 4, 10, 350, 'It is a painting of shiv tandav.\r\nIt is a painting of shiv tandav.\r\nIt is a painting of shiv tandav.It is a painting of shiv tandav.It is a painting of shiv tandav.It is a painting of shiv tandav.It is a painting of shiv tandav.\r\nIt is a painting of shiv tandav.It is a painting of shiv tandav.', 'cd235e034297cda7b6f935dbd4881a2f1671771582.jpg', 'cd235e034297cda7b6f935dbd4881a2f1671771582.jpg', '', '', '', 686429002, '2022-12-23 04:59:42'),
(4, 'Stutue of Afel Tower', '45 inches tall', 'Landscape', 'Medium', 7, 1, 8, 500, 'It is a stute of afel tower which is made up of metal,It is a stute of afel tower which is made up of metal,It is a stute of afel tower which is made up of metal,It is a stute of afel tower which is made up of metal,It is a stute of afel tower which is made up of metal,It is a stute of afel tower which is made up of metal,It is a stute of afel tower which is made up of metal,', '508652faabdd333b34a0ce4a1dd443411671771753.jpg', '', '', '', '', 686429003, '2022-12-23 05:02:33'),
(5, 'HKjhkj', '100x200', 'Landscape', 'Large', 7, 3, 9, 200, 'gjhgj', '7d108db512f6a6a929cd0d0ad3b593e81671772410.jpg', '', '', '', '', 586429004, '2022-12-23 05:13:30');

-- --------------------------------------------------------

--
-- Table structure for table `tblarttype`
--

CREATE TABLE `tblarttype` (
  `ID` int(5) NOT NULL,
  `ArtType` varchar(250) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblarttype`
--

INSERT INTO `tblarttype` (`ID`, `ArtType`, `CreationDate`) VALUES
(1, 'Sculptures', '2022-12-21 14:21:13'),
(2, 'Serigraphs', '2022-12-21 14:24:46'),
(3, 'Prints', '2022-12-21 14:25:00'),
(4, 'Painting', '2022-12-21 14:25:31'),
(5, 'Street Art', '2022-12-21 14:26:06'),
(6, 'Visual art ', '2022-12-21 14:26:29'),
(7, 'Conceptual art', '2022-12-21 14:26:45');

-- --------------------------------------------------------

--
-- Table structure for table `tblenquiry`
--

CREATE TABLE `tblenquiry` (
  `ID` int(10) NOT NULL,
  `EnquiryNumber` varchar(10) NOT NULL,
  `Artpdid` int(9) DEFAULT NULL,
  `FullName` varchar(120) DEFAULT NULL,
  `Email` varchar(250) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Message` varchar(250) DEFAULT NULL,
  `EnquiryDate` timestamp NULL DEFAULT current_timestamp(),
  `Status` varchar(10) DEFAULT NULL,
  `AdminRemark` varchar(200) NOT NULL,
  `AdminRemarkdate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblenquiry`
--

INSERT INTO `tblenquiry` (`ID`, `EnquiryNumber`, `Artpdid`, `FullName`, `Email`, `MobileNumber`, `Message`, `EnquiryDate`, `Status`, `AdminRemark`, `AdminRemarkdate`) VALUES
(1, '230873611', 4, 'Anuj kumar', 'ak@test.com', 1234567890, 'This is for testing Purpose.', '2023-01-02 18:16:47', 'Answer', 'test purpose', '2023-01-01 18:30:00'),
(2, '227883179', 5, 'Amit Kumar', 'amitk55@test.com', 1234434321, 'I want this painting', '2023-01-02 18:42:42', 'Answer', 'testing purpose', '2023-01-02 18:43:16');

-- --------------------------------------------------------

--
-- Table structure for table `tblpage`
--

CREATE TABLE `tblpage` (
  `ID` int(10) NOT NULL,
  `PageType` varchar(200) DEFAULT NULL,
  `PageTitle` mediumtext DEFAULT NULL,
  `PageDescription` mediumtext DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `UpdationDate` date DEFAULT NULL,
  `Timing` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpage`
--

INSERT INTO `tblpage` (`ID`, `PageType`, `PageTitle`, `PageDescription`, `Email`, `MobileNumber`, `UpdationDate`, `Timing`) VALUES
(1, 'aboutus', 'About Us', '<span style=\"color: rgb(32, 33, 36); font-family: arial, sans-serif; font-size: 16px;\">An art gallery is&nbsp;</span><b style=\"color: rgb(32, 33, 36); font-family: arial, sans-serif; font-size: 16px;\">an exhibition space to display and sell artworks</b><span style=\"color: rgb(32, 33, 36); font-family: arial, sans-serif; font-size: 16px;\">. As a result, the art gallery is a commercial enterprise working with a portfolio of artists. The gallery acts as the dealer representing, supporting, and distributing the artworks by the artists in question.</span><br>', NULL, NULL, NULL, ''),
(2, 'contactus', 'Contact Us', '890,Sector 62, Gyan Sarovar, GAIL Noida(Delhi/NCR)', 'info@gmail.com', 1234567890, NULL, '10:30 am to 7:30 pm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblartist`
--
ALTER TABLE `tblartist`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblartmedium`
--
ALTER TABLE `tblartmedium`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblartproduct`
--
ALTER TABLE `tblartproduct`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblarttype`
--
ALTER TABLE `tblarttype`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblenquiry`
--
ALTER TABLE `tblenquiry`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CardId` (`Artpdid`);

--
-- Indexes for table `tblpage`
--
ALTER TABLE `tblpage`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblartist`
--
ALTER TABLE `tblartist`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblartmedium`
--
ALTER TABLE `tblartmedium`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tblartproduct`
--
ALTER TABLE `tblartproduct`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblarttype`
--
ALTER TABLE `tblarttype`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblenquiry`
--
ALTER TABLE `tblenquiry`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblpage`
--
ALTER TABLE `tblpage`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Database: `fashion`
--
CREATE DATABASE IF NOT EXISTS `fashion` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fashion`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `role_id`, `email`, `password`, `name`) VALUES
(1, 2, 'admin@gmail.com', 'admin', 'Jessica');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `article_id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `kategori` varchar(50) NOT NULL,
  `author` varchar(100) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `isi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`article_id`, `judul`, `tanggal`, `kategori`, `author`, `gambar`, `isi`) VALUES
(2, '5 Tren Fashion yang Wajib Dicoba di Tahun Ini untuk Tampil Stylish!', '2025-01-08 00:33:37', 'Tren Fashion', '', 'uploads/logo.png', '<p><strong>1. Warna Pastel yang Mendominasi</strong><br>Warna pastel kembali mendominasi dunia fashion tahun ini. Pilihlah pakaian dengan palet warna seperti baby blue, lilac, atau mint green untuk menciptakan tampilan yang segar dan menenangkan. Cocok untuk gaya kasual maupun semi-formal!</p>\r\n<p><strong>2. Oversized Blazer untuk Look Profesional</strong><br>Ingin tampil profesional tapi tetap trendi? Oversized blazer adalah jawabannya! Padukan dengan celana panjang berpotongan lurus atau rok mini untuk kombinasi modern dan edgy.</p>\r\n<p><strong>3. Celana Wide-Leg untuk Kenyamanan Maksimal</strong><br>Celana dengan potongan wide-leg menjadi favorit banyak orang karena selain nyaman, juga memberikan kesan elegan. Pasangkan dengan crop top atau kemeja longgar untuk keseimbangan gaya yang sempurna.</p>\r\n<p><strong>4. Aksesori Minimalis untuk Sentuhan Elegan</strong><br>Kalung rantai tipis, anting kecil berbentuk geometris, atau cincin simple adalah pilihan aksesori minimalis yang bisa melengkapi tampilanmu tanpa terlihat berlebihan.</p>\r\n<p><strong>5. Sepatu Chunky yang Tetap Hits</strong><br>Sneakers chunky tetap menjadi tren di kalangan fashionista. Cocok dipadukan dengan jeans, rok, atau bahkan gaun untuk memberikan sentuhan kasual namun stylish.</p>\r\n<p><strong>Kesimpulan</strong><br>Tren fashion tahun ini menonjolkan kenyamanan tanpa mengorbankan gaya. Jadi, jangan ragu untuk mencoba kombinasi baru yang sesuai dengan kepribadianmu. Ingat, fashion adalah tentang mengekspresikan diri dengan percaya diri!</p>'),
(9, 'Menggali Filosofi di Balik Pakaian: Fashion sebagai Self Expression', '2025-01-17 07:05:36', 'Filosofi Fashion', '', NULL, '<p>Fashion bukan hanya tentang apa yang kita kenakan, tetapi juga tentang bagaimana pakaian tersebut mencerminkan identitas kita. Dalam dunia yang semakin cepat berubah ini, pakaian menjadi bahasa universal yang dapat menceritakan siapa kita, apa yang kita yakini, dan bahkan apa yang kita impikan. Mari kita eksplorasi lebih dalam tentang bagaimana fashion dapat menjadi ekspresi diri yang lebih dari sekadar gaya.</p>\r\n<h4><strong>Fashion Sebagai Identitas Diri</strong></h4>\r\n<p>Pakaian yang kita pilih seringkali mencerminkan siapa diri kita, bahkan sebelum kita membuka mulut. Setiap detail, dari warna, potongan, hingga tekstur, memiliki makna yang lebih dalam. Misalnya, seseorang yang mengenakan pakaian monokrom atau warna gelap mungkin ingin tampil serius dan minimalis. Sementara itu, mereka yang memilih warna cerah dan pola berani seringkali menginginkan untuk menonjol dan mengekspresikan diri dengan cara yang lebih terbuka.</p>\r\n<p>Fashion memberi kita kebebasan untuk menunjukkan siapa kita tanpa harus berbicara. Ini adalah bentuk komunikasi non-verbal yang dapat menciptakan koneksi antar individu, bahkan tanpa mengenal mereka secara langsung.</p>\r\n<h4><strong>Membangun Kepercayaan Diri Melalui Fashion</strong></h4>\r\n<p>Ketika kita merasa nyaman dengan apa yang kita kenakan, kita lebih percaya diri. Ini adalah salah satu alasan mengapa pakaian memiliki kekuatan untuk mengubah perasaan kita terhadap diri kita sendiri. Pakaian yang membuat kita merasa baik dapat meningkatkan rasa percaya diri, memberikan energi positif, dan bahkan mempengaruhi bagaimana kita berinteraksi dengan dunia sekitar.</p>\r\n<p>Banyak orang merasa lebih percaya diri ketika mengenakan pakaian yang sesuai dengan bentuk tubuh mereka atau yang mencerminkan gaya pribadi mereka. Ini adalah bukti bahwa fashion bukan hanya tentang mengikuti apa yang ada di pasaran, tetapi tentang merayakan siapa kita sebenarnya.</p>\r\n<h4><strong>Pakaian dan Nilai-nilai yang Kita Anut</strong></h4>\r\n<p>Fashion sering kali berkaitan dengan nilai-nilai yang kita pegang. Misalnya, ada banyak orang yang memilih pakaian yang ramah lingkungan dan berkelanjutan sebagai bagian dari filosofi hidup mereka. Pilihan untuk mengenakan pakaian yang dibuat dari bahan organik atau yang diproduksi secara etis tidak hanya mencerminkan gaya, tetapi juga mencerminkan komitmen terhadap keberlanjutan dan tanggung jawab sosial.</p>\r\n<p>Selain itu, pakaian juga bisa menjadi cara untuk menunjukkan dukungan terhadap suatu gerakan atau ideologi. Banyak brand yang menciptakan koleksi khusus yang berfokus pada isu-isu sosial, dan ini memberi para konsumen kesempatan untuk berkontribusi pada perubahan positif hanya dengan memilih produk yang mereka beli.</p>\r\n<h4><strong>Fashion Sebagai Wadah Kreativitas</strong></h4>\r\n<p>Selain sebagai ekspresi diri, fashion juga merupakan platform bagi kreativitas. Desainer sering kali menggali budaya, sejarah, seni, dan berbagai inspirasi lain untuk menciptakan karya yang tidak hanya fungsional, tetapi juga artistik. Pakaian menjadi kanvas bagi ekspresi seni yang dapat dinikmati oleh banyak orang. Seperti seni lukis atau musik, fashion adalah cara untuk berkomunikasi dengan dunia, mengungkapkan ide-ide dan emosi yang sulit diungkapkan dengan kata-kata.</p>\r\n<h4><strong>Menerima Keberagaman dalam Fashion</strong></h4>\r\n<p>Salah satu keindahan dari fashion adalah kemampuannya untuk merayakan keberagaman. Setiap individu memiliki pilihan dan selera yang berbeda, dan itu adalah sesuatu yang patut dihargai. Dalam dunia fashion, tidak ada satu bentuk atau ukuran yang benar, dan inilah yang membuat dunia fashion begitu inklusif. Dengan semakin banyaknya desainer dan brand yang mendukung keberagaman ukuran tubuh, ras, dan identitas gender, dunia fashion menjadi lebih terbuka untuk semua orang.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `article_id`, `name`, `content`, `created_at`) VALUES
(1, 2, 'Jessica', 'bagus', '2025-01-08 16:40:51'),
(2, 2, 'selin14', 'Wah menarik banget!', '2025-01-08 17:19:59');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'user'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `created_at`, `name`) VALUES
(1, 'selin14', '12345', '2025-01-08 17:17:40', 'Selin'),
(2, 'Jessica21', '12345', '2025-01-09 08:38:27', 'Jess'),
(3, 'jess', '12345', '2025-01-17 07:28:55', 'Jessica'),
(5, 'selin', '12345', '2025-01-17 07:30:12', 'Selin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`article_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `article_id` (`article_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`) ON DELETE CASCADE;
--
-- Database: `new_schema`
--
CREATE DATABASE IF NOT EXISTS `new_schema` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `new_schema`;
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"fashion\",\"table\":\"users\"},{\"db\":\"fashion\",\"table\":\"comments\"},{\"db\":\"fashion\",\"table\":\"admins\"},{\"db\":\"fashion\",\"table\":\"articles\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2025-01-14 07:34:00', '{\"Console\\/Mode\":\"collapse\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `school_2`
--
CREATE DATABASE IF NOT EXISTS `school_2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `school_2`;

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
(13, 'Anne', 'guru_biasa', '081234567895', 'anne@gmail.com', 'Jl. Prof Drg. Surya Sumantri No. 65 Bandung', NULL, '$2y$10$2fKjpksJlhaa8Quj3l2I3uYwq/IqzL0xOKoY0eKn1Ds8q6vX1ZWmK', 1),
(14, 'Christandy', 'guru_biasa', '081234567896', 'chris@gmail.com', 'Jl. Cibogo No. 31', NULL, '$2y$10$92cnb8LkfHhBlf1aQdBfNO7OCBB1A7jNBlyM6hhIieR7RfCg1YSJS', 1),
(15, 'Asep', 'guru_biasa', '0815235236', 'asep@gmail.com', 'Jl. Rajawali', NULL, '$2y$10$kiy.tlQqNuGAlw219sXqDejoxEWWdFMNXyGj5u2228xQ6SYASrHZO', 1),
(16, 'Kylie Jenner', 'guru_biasa', '08123456789', 'kylie@gmail.com', 'Jl. Beverly Hills', NULL, '$2y$10$w8lieycDvLhWM1hw8YpoQeXZa5.9ymD830q1rH7xy2a.4M9Q5NjSG', 1),
(17, 'Lolly', 'guru_biasa', '08123456789', 'lolly@gmail.com', 'Jl. Dago', NULL, '$2y$10$VLmKCmnAZpePKbFbfQjrLOBA62gppIMWXbuiIxJUGFIwbGMN90c8a', 3);

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
(4, 6, 13, '10', 'Senin', '07:00:00', '08:00:00', 'X IPA', 1),
(5, 14, 14, '10', 'Senin', '08:00:00', '09:00:00', 'X IPA', 1),
(6, 11, 11, '10', 'Senin', '09:00:00', '10:00:00', 'X IPA', 1),
(7, 10, 12, '11', 'Selasa', '07:00:00', '08:00:00', 'XI IPA', 1),
(8, 7, 12, '11', 'Rabu', '09:00:00', '10:00:00', 'XI IPA', 1),
(9, 13, 14, '12', 'Kamis', '08:00:00', '09:00:00', 'XII IPA', 1),
(10, 8, 11, '11', 'Kamis', '10:00:00', '11:00:00', 'XI IPS', 1),
(11, 6, 13, '12', 'Jumat', '13:00:00', '14:00:00', 'XII IPA', 1),
(12, 15, 15, '10', 'Selasa', '09:00:00', '10:00:00', 'Lapangan Olahraga', 1),
(13, 16, 17, '12', 'Senin', '08:00:00', '09:00:00', 'XII IPA', 3);

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
(3, 1, 'XII', 'IPA', NULL),
(4, 1, 'X', 'IPS', NULL),
(5, 1, 'XI', 'IPS', NULL),
(6, 1, 'XII', 'IPS', NULL),
(9, 3, 'X', 'IPA', NULL),
(11, 3, 'XI', 'IPA', NULL);

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
(6, 'Biologi', 13, 1),
(7, 'Matematika Peminatan', 12, 1),
(8, 'Sosiologi', 11, 1),
(9, 'Kimia', 13, 1),
(10, 'Fisika', 12, 1),
(11, 'Bahasa Inggris', 11, 1),
(12, 'Sejarah', 14, 1),
(13, 'Bahasa Sunda', 14, 1),
(14, 'Bahasa Mandarin', 14, 1),
(15, 'Olahraga', 15, 1),
(16, 'Biologi', 17, 3);

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
(1, 8, 13, 90.00, 85.00, 100.00, '2024', '12', 1),
(2, 6, 6, 100.00, 91.00, 90.00, '2024', '11', 1),
(3, 9, 8, 100.00, 75.00, 71.00, '2024', '10', 1),
(6, 9, 14, 0.00, 0.00, 0.00, '', '', 1),
(7, 10, 11, 90.00, 90.00, 90.00, '', '', 1);

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
  `tahun_ajaran` varchar(10) NOT NULL,
  `kelas_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nama`, `kelas`, `alamat`, `telepon`, `jenis_kelamin`, `agama`, `email`, `tanggal_lahir`, `password`, `periode_id`, `status`, `tahun_ajaran`, `kelas_id`) VALUES
(6, 'Jessica', '11', 'Jl. Pakar Timur IV ', '081234567890', 'P', 'Kristen', 'jessicaanne@gmail.com', '2002-08-21', '$2y$10$TNAOnfRoZUQB7g1VE5a4f.Ly8q7N83ZZr6ZPXL0aPB5LeLG9WNGGi', 1, 'Aktif', '', 1),
(8, 'Jonathan', '12', 'Jl. Cibogo', '081234567891', 'L', 'Kristen', 'joch@gmail.com', '2001-01-19', '$2y$10$V7WBPuLH1MGVA6rAtgD83O.xlSgWSJPzFCYZP7prNyYZgLxAcABQy', 1, 'Aktif', '', 1),
(9, 'Ujang', '10', 'Jl. Surya Sumantri', '081234567892', 'L', 'Buddha', 'ujang@gmail.com', '2003-01-01', '$2y$10$.fBZRMRlPk2CnZBFPmj6LuhK8OEJXdifSWXGPFYMO2Oikl9dGhBRm', 1, 'Aktif', '', 1),
(10, 'Ucup', '', 'Jl. Surya Sumantri', '08123456789', 'L', 'Islam', 'ucup@gmail.com', '2002-11-11', '$2y$10$y5O0eM0F34mbJONvkjyQmu.1jEf2alBmMUvnq7abLybrmXfXI/1XS', 1, 'Aktif', '', 1),
(11, 'Daniella', '', 'Jl Cibogo', '08123456789', 'P', 'Kristen', 'daniela@gmail.com', '2000-07-01', '$2y$10$8ovJOaz/jZNa8jXJ5BW.UOsWKHg5H3Kowfuthrn6CA5dg7YRMeOWW', 3, 'Aktif', '', NULL),
(12, 'Christian', '', 'Jl Cibogo', '0815235236', 'L', 'Buddha', 'christian@gmail.com', '2001-11-11', '$2y$10$mi4VO5gnmpikzkzcHKtBzef0iLZv0bc0MsA63CHv7pvlJxdIqaFWC', 3, 'Aktif', '', NULL),
(13, 'Udin', '', 'Jl. Cibogo No. 31', '08123456789', 'L', 'Islam', 'udin@gmail.com', '2000-12-12', '$2y$10$3q89oM47rtx5aqXKviNu5un3XwegJck0.DoW5kI6S9CZ4EgWiOw1.', 3, 'Aktif', '', NULL);

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
(6, 11, 8, 1),
(7, 12, 8, 1),
(8, 6, 8, 1),
(9, 8, 8, 1),
(10, 11, 16, 3),
(11, 12, 16, 3);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `periode`
--
ALTER TABLE `periode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `siswa_mapel`
--
ALTER TABLE `siswa_mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
