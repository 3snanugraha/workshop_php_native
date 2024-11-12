-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 12, 2024 at 09:07 PM
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
(1, 1, 1, 5, 'Workshop yang sangat bermanfaat dan menarik.', '2024-12-01 09:00:00'),
(2, 7, 2, 4, 'Materi workshop cukup bagus, tetapi bisa lebih interaktif.', '2024-12-05 10:00:00');

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
  `payment_method` enum('credit_card','bank_transfer','e-wallet') NOT NULL,
  `payment_status` enum('successful','failed') NOT NULL DEFAULT 'failed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `registration_id`, `amount`, `payment_date`, `payment_method`, `payment_status`) VALUES
(1, 1, 100000.00, '2024-11-11 15:12:00', 'bank_transfer', 'failed'),
(2, 2, 200000.00, '2024-11-11 15:35:00', 'bank_transfer', 'failed');

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
(1, 1, 1, '2024-11-11 15:10:00', 'registered', 'paid', '2024-11-11 08:10:00', '2024-11-11 08:10:00'),
(2, 7, 2, '2024-11-11 15:30:00', 'registered', 'pending', '2024-11-11 08:30:00', '2024-11-11 21:45:32');

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
(18, 'mitratiga', '$2y$10$JXANhM21J9./i5G7yxXZE.cRTwA.fNHODjAxKaby94Niyj2kleEeK', 'Mitra', 'Tiga', 'mitra3@gmail.com', '62895339046899', 'mitra', '2024-11-12 19:01:17', '2024-11-12 19:01:17');

-- --------------------------------------------------------

--
-- Table structure for table `workshops`
--

CREATE TABLE `workshops` (
  `workshop_id` int(11) NOT NULL,
  `mitra_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
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

INSERT INTO `workshops` (`workshop_id`, `mitra_id`, `title`, `description`, `price`, `location`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 8, 'Digital Marketing', 'Workshop ini membahas tentang pengembangan pribadi.', 100000.00, 'Jakarta', '2024-12-01 09:00:00', '2024-12-01 15:00:00', 'active', '2024-11-11 09:30:00', '2024-11-11 21:47:51'),
(2, 9, 'Affiliate', 'Workshop tentang digital marketing dan strategi online.', 200000.00, 'Bandung', '2024-12-05 09:00:00', '2024-12-05 16:00:00', 'active', '2024-11-11 10:00:00', '2024-11-11 21:47:58');

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
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `workshops`
--
ALTER TABLE `workshops`
  MODIFY `workshop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `workshop_schedules`
--
ALTER TABLE `workshop_schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
