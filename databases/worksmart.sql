-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 15, 2024 at 06:25 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `worksmart`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `workshop_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `user_id`, `workshop_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 3, 5, 'Workshop yang sangat bermanfaat dan menarik.', '2024-12-01 09:00:00'),
(2, 19, 3, 5, 'Materi workshop cukup bagus, tetapi bisa lebih interaktif.', '2024-12-05 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `registration_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` datetime DEFAULT current_timestamp(),
  `payment_method` enum('bank_transfer','e-wallet') NOT NULL,
  `payment_status` enum('successful','failed') NOT NULL DEFAULT 'failed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `registration_id`, `amount`, `payment_date`, `payment_method`, `payment_status`) VALUES
(1, 1, 100000.00, '2024-11-11 15:12:00', 'bank_transfer', 'failed'),
(2, 2, 200000.00, '2024-11-11 15:35:00', 'bank_transfer', 'failed'),
(3, 3, 200000.00, '2024-11-11 15:35:00', 'bank_transfer', 'successful');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `registration_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `workshop_id` int(11) NOT NULL,
  `registration_date` datetime DEFAULT current_timestamp(),
  `status` enum('registered','cancelled','completed') NOT NULL DEFAULT 'registered',
  `payment_status` enum('paid','pending','failed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`registration_id`, `user_id`, `workshop_id`, `registration_date`, `status`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, 1, 3, '2024-11-11 15:10:00', 'registered', 'paid', '2024-11-11 08:10:00', '2024-11-15 16:56:33'),
(2, 7, 3, '2024-11-11 15:30:00', 'registered', 'pending', '2024-11-11 08:30:00', '2024-11-15 16:56:36'),
(3, 19, 3, '2024-11-11 15:30:00', 'registered', 'paid', '2024-11-11 08:30:00', '2024-11-15 16:56:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `role` enum('admin','mitra','user') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `first_name`, `last_name`, `email`, `phone`, `role`, `created_at`, `updated_at`) VALUES
(1, 'peserta_coba', '$2y$10$eubCoaVJ/JGKQOfnHp6HTeoWQXVlM1PXyizk2OVlBY12qEWOqGIN6', 'Budi', 'Setiadi', 'peserta_coba@gmail.com', '62895339046899', 'user', '2024-11-10 21:34:00', '2024-11-11 23:29:44'),
(6, 'admin', '$2y$10$u/1/HGSto.CpUobrij9PWuQma3n7UjAlfjRQTXIBsTOzXFPkXX9R2', 'Admin', 'admin', 'admin@gmail.com', '62895339046899', 'admin', '2024-11-11 14:10:50', '2024-11-11 14:11:20'),
(7, 'hartosup', '$2y$10$Q0vBLeJeWo3WuB8OYKXJFuKaTqrW/xnZpHs.fxTw4MFm4Svw6eIyO', 'Harto', 'Supratman', 'coba@gmail.com', '62823443324311', 'user', '2024-11-11 14:36:09', '2024-11-12 18:27:33'),
(8, 'mitra_sss', '$2y$10$fgWyKsC4I8NkL5LyoeDZaOlvWJ8NLu4UyyaDF3jKUT3PJYDOuYisK', 'Mitra', 'Satu', 'mitrasatu@gmail.com', '6289235335225', 'mitra', '2024-11-11 21:25:10', '2024-11-12 19:04:48'),
(9, 'mitra_2', '$2y$10$s9fYJqIDJsWu/1C2xeIbneJYUpqZMWuKiNx7p8BoHf9wqfIfRuDru', 'Mitra', 'Dua', 'mitradua@gmail.com', '62895339046899', 'mitra', '2024-11-11 21:26:07', '2024-11-11 21:26:07'),
(18, 'mitratiga', '$2y$10$JXANhM21J9./i5G7yxXZE.cRTwA.fNHODjAxKaby94Niyj2kleEeK', 'Mitra', 'Tiga', 'mitra3@gmail.com', '62895339046899', 'mitra', '2024-11-12 19:01:17', '2024-11-12 19:01:17'),
(19, 'trisnanugraha', '$2y$10$CQCbw5fL5myhCAptcjCcJOmWkPcLzBpC4bsOBKbvc/tOKSQ5Yd1cq', 'Trisna', 'Nugraha', 'trisnanugraha87@gmail.com', '62895339046899', 'user', '2024-11-15 07:55:30', '2024-11-15 07:55:30');

-- --------------------------------------------------------

--
-- Table structure for table `workshops`
--

CREATE TABLE `workshops` (
  `workshop_id` int(11) NOT NULL,
  `mitra_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `banner` varchar(100) NOT NULL,
  `training_overview` text NOT NULL,
  `trained_competencies` text NOT NULL,
  `training_session` text NOT NULL,
  `requirements` text NOT NULL,
  `benefits` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `status` enum('active','inactive','cancelled') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workshops`
--

INSERT INTO `workshops` (`workshop_id`, `mitra_id`, `title`, `description`, `banner`, `training_overview`, `trained_competencies`, `training_session`, `requirements`, `benefits`, `price`, `location`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(3, 8, 'UI/UX Design', 'Pelatihan untuk menjadi desainer UI/UX profesional.', 'sample.jpg', 'Dasar-dasar desain UI/UX, riset pengguna, prototipe, dan testing.', 'Riset UX, Wireframing, Prototyping', '2 hari (8 jam/hari)', 'Laptop dengan software Figma atau Adobe XD', 'Sertifikat resmi, materi pelatihan, dan akses komunitas', 300000.00, 'Yogyakarta', '2024-12-10 08:00:00', '2024-12-11 16:00:00', 'active', '2024-11-15 09:02:38', '2024-11-15 09:11:00'),
(4, 9, 'Data Science Basics', 'Pengantar analisis data untuk pemula.', 'sample.jpg', 'Pengantar Python, analisis data, dan visualisasi.', 'Python, Pandas, Matplotlib', '1 hari (8 jam)', 'Laptop dengan Python terinstal', 'Sertifikat resmi dan contoh dataset', 250000.00, 'Jakarta', '2024-12-15 09:00:00', '2024-12-15 17:00:00', 'active', '2024-11-15 09:02:38', '2024-11-15 09:11:05'),
(5, 18, 'Public Speaking Mastery', 'Workshop untuk menguasai seni berbicara di depan umum.', 'sample.jpg', 'Strategi komunikasi efektif, melatih kepercayaan diri, dan penguasaan audiens.', 'Komunikasi verbal, penguasaan emosi', '1 hari (6 jam)', 'Antusiasme belajar', 'Sertifikat, rekaman sesi, dan konsultasi', 150000.00, 'Surabaya', '2024-12-20 10:00:00', '2024-12-20 16:00:00', 'active', '2024-11-15 09:02:38', '2024-11-15 09:11:08'),
(6, 18, 'Digital Illustration', 'Belajar ilustrasi digital menggunakan tablet grafis.', 'sample.jpg', 'Teknik menggambar digital, pewarnaan, dan rendering.', 'Menguasai software CorelDRAW/Photoshop', '2 hari (6 jam/hari)', 'Laptop atau tablet grafis', 'Sertifikat, contoh desain, dan akses forum', 400000.00, 'Malang', '2024-12-25 09:00:00', '2024-12-26 15:00:00', 'active', '2024-11-15 09:02:38', '2024-11-15 09:11:11'),
(7, 18, 'Business Strategy', 'Strategi membangun bisnis yang berkelanjutan.', 'sample.jpg', 'Analisis SWOT, manajemen risiko, dan inovasi bisnis.', 'Manajemen bisnis, strategi pasar', '1 hari (7 jam)', 'Antusiasme untuk bisnis', 'Sertifikat, workbook strategi bisnis', 500000.00, 'Bandung', '2024-12-30 09:00:00', '2024-12-30 16:00:00', 'active', '2024-11-15 09:02:38', '2024-11-15 09:11:14'),
(8, 8, 'Photography Basics', 'Dasar-dasar fotografi untuk pemula.', 'sample.jpg', 'Pengaturan kamera, komposisi, dan editing dasar.', 'Keterampilan fotografi dasar', '1 hari (5 jam)', 'Kamera DSLR atau smartphone', 'Sertifikat dan hasil foto', 200000.00, 'Bali', '2025-01-05 08:00:00', '2025-01-05 13:00:00', 'active', '2024-11-15 09:02:38', '2024-11-15 09:11:17'),
(9, 18, 'Cloud Computing', 'Pengantar komputasi awan untuk bisnis dan IT.', 'sample.jpg', 'Konsep dasar cloud, praktik AWS dan Azure.', 'Dasar cloud, manajemen data', '1 hari (6 jam)', 'Laptop dan akun AWS/Azure gratis', 'Sertifikat dan akses percobaan cloud', 450000.00, 'Semarang', '2025-01-10 09:00:00', '2025-01-10 15:00:00', 'active', '2024-11-15 09:02:38', '2024-11-15 09:11:19');

-- --------------------------------------------------------

--
-- Table structure for table `workshop_schedules`
--

CREATE TABLE `workshop_schedules` (
  `schedule_id` int(11) NOT NULL,
  `workshop_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workshop_schedules`
--

INSERT INTO `workshop_schedules` (`schedule_id`, `workshop_id`, `date`, `start_time`, `end_time`, `location`) VALUES
(1, 1, '2024-12-01', '09:00:00', '15:00:00', 'Jakarta'),
(2, 2, '2024-12-05', '09:00:00', '16:00:00', 'Bandung');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`registration_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `workshops`
--
ALTER TABLE `workshops`
  ADD PRIMARY KEY (`workshop_id`);

--
-- Indexes for table `workshop_schedules`
--
ALTER TABLE `workshop_schedules`
  ADD PRIMARY KEY (`schedule_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `workshops`
--
ALTER TABLE `workshops`
  MODIFY `workshop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `workshop_schedules`
--
ALTER TABLE `workshop_schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
