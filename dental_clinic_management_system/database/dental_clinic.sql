-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2024 at 01:29 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dental_clinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `appointment_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `service_id` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `appointment_date`, `created_at`, `service_id`, `status`) VALUES
(4, 4, '2024-10-17 17:22:00', '2024-10-13 17:22:06', 3, 'Done'),
(5, 5, '2024-10-31 17:24:00', '2024-10-13 17:24:38', 6, 'Pending'),
(6, 6, '2024-10-31 17:24:00', '2024-10-13 17:26:02', 6, 'Pending'),
(7, 7, '2024-10-25 17:26:00', '2024-10-13 17:26:18', 6, 'Pending'),
(8, 8, '2024-10-16 13:30:00', '2024-10-13 17:30:29', 3, 'Pending'),
(9, 9, '2024-10-16 14:00:00', '2024-10-13 23:11:54', 7, 'Pending'),
(10, 10, '2024-10-17 09:48:00', '2024-10-14 16:49:00', 1, 'Done'),
(11, 11, '2024-10-28 09:00:00', '2024-10-14 18:32:07', 2, 'Done'),
(12, 12, '2024-11-18 08:30:00', '2024-10-14 19:29:43', 7, 'Follow Up'),
(13, 13, '2024-10-14 08:00:00', '2024-10-14 19:45:43', 5, 'Pending'),
(14, 14, '2024-10-14 00:00:00', '2024-10-14 19:50:53', 4, 'Postponed'),
(15, 15, '2024-10-25 14:00:00', '2024-10-14 19:52:11', 2, 'Follow Up'),
(16, 16, '2024-10-14 00:00:00', '2024-10-14 19:52:30', 4, 'Postponed'),
(17, 17, '2024-10-14 00:00:00', '2024-10-14 19:52:51', 4, 'Postponed'),
(18, 18, '2024-11-21 08:00:00', '2024-10-14 19:53:32', 2, 'Done'),
(19, 19, '2024-11-21 08:00:00', '2024-10-14 19:57:52', 2, 'Pending'),
(20, 20, '2024-10-17 13:00:00', '2024-10-15 11:17:59', 3, 'Pending'),
(21, 21, '2024-10-23 14:05:00', '2024-10-18 00:05:44', 2, 'Pending'),
(22, 22, '2024-10-23 12:00:00', '2024-10-18 00:06:27', 1, 'Pending'),
(23, 23, '2024-10-23 16:00:00', '2024-10-18 00:06:48', 5, 'Pending'),
(24, 24, '2024-10-31 09:00:00', '2024-10-18 09:55:53', 1, 'Pending'),
(25, 25, '2024-10-21 14:00:00', '2024-10-18 13:54:18', 2, 'Pending'),
(26, 26, '2024-10-21 14:00:00', '2024-10-18 13:54:47', 1, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `concerns` text NOT NULL,
  `created_at` datetime NOT NULL,
  `concern_type` enum('reschedule','cancel','inquiry','other') NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `first_name`, `last_name`, `email`, `phone`, `created_at`) VALUES
(1, 'Ma. Sachilette', 'Leyesa', 'saaach25@gmail.com', '09301952078', '2024-10-13 15:41:48'),
(2, 'Sachi', 'Leyesa', 'sach@gmail.com', '09301952078', '2024-10-13 16:43:59'),
(3, 'lans', 'lorence', 'sakdnwk4@gmal.com', '12d45', '2024-10-13 16:59:22'),
(4, 'Lans Lorence ', 'Hernandez', 'lanslorence@gmail.com', '09639447150', '2024-10-13 17:22:06'),
(5, 'dsadas', 'jttfgh', 'fhfg@gmail.com', '345678', '2024-10-13 17:24:38'),
(6, 'dsadas', 'jttfgh', 'fhfg@gmail.com', '345678', '2024-10-13 17:26:02'),
(7, 'dsadasdbsahdashg', 'hgdsaghfgashfjgj', 'dsladkas@gmail.com', '3124', '2024-10-13 17:26:18'),
(8, 'Sachilette', 'Maria', 'sach@gmail.com', '09354651542', '2024-10-13 17:30:29'),
(9, 'Lorence', 'Hernandez', 'lans@gmail.com', '09127649805', '2024-10-13 23:11:54'),
(10, 'LAaaans', 'Hernandez', 'lans@gmail.com', '09127649805', '2024-10-14 16:49:00'),
(11, 'LAaaans', 'Hernandez', 'lans@gmail.com', '09127649805', '2024-10-14 18:32:07'),
(12, 'MA. SACHILETTE', 'LEYESA', 'maria@gmail.com', '09301648307', '2024-10-14 19:29:43'),
(13, 'Yessah', 'Vibas', 'ysa@gmail.com', '095462317651', '2024-10-14 19:45:43'),
(14, 'qfws', 'fcds', 'fvdfdx@gmail.com', '0216214864', '2024-10-14 19:50:53'),
(15, 'Calvin Kiev', 'Leyesa', 'calvin@gmail.com', '095489147412', '2024-10-14 19:52:11'),
(16, 'wfdsczdc', 'dsva', 'maria@gmail.com', '0948765124', '2024-10-14 19:52:30'),
(17, 'YOU', 'YES', 'maria@gmail.com', '0948765124', '2024-10-14 19:52:51'),
(18, 'wertyy', 'sfacsa', 'asd@gmail.com', '09462178541', '2024-10-14 19:53:32'),
(19, 'wertyy', 'sfacsa', 'asd@gmail.com', '09462178541', '2024-10-14 19:57:52'),
(20, 'Marilou', 'Leyesa', 'malou@gmail.com', '09309146122', '2024-10-15 11:17:59'),
(21, 'Maria', 'Leyesa', 'vhey@gmail.com', '345765432', '2024-10-18 00:05:44'),
(22, 'swse', 'ececr', 'ew@gmail.com', '2654132', '2024-10-18 00:06:27'),
(23, 'swse', 'ececr', 'ew@gmail.com', '2654132', '2024-10-18 00:06:48'),
(24, 'Shandy', 'Vibas', 'shandy@gmail.com', '0988725462', '2024-10-18 09:55:53'),
(25, 'Sachilette', 'Leyesa', 'sach@gmail.com', '09301952078', '2024-10-18 13:54:18'),
(26, 'ma. sachilette', 'leyesa', 'saaach25@gmail.com', '09301952078', '2024-10-18 13:54:47');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`) VALUES
(1, 'Dental Checkup'),
(2, 'Teeth Cleaning'),
(3, 'Filling'),
(4, 'Root Canal Treatment'),
(5, 'Teeth Whitening'),
(6, 'Orthodontics'),
(7, 'Extraction');

-- --------------------------------------------------------

--
-- Table structure for table `symptoms`
--

CREATE TABLE `symptoms` (
  `symptom_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `symptom` enum('toothache','bleeding_gums','bad_breath','sensitive_teeth','swollen_gums','jaw_pain') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `token_expiration` datetime DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`, `token_expiration`, `verified`) VALUES
(1, 'maria', '$2y$10$YEVECdjd5AqGAHxOAgtECuHsMFVtntnlG27N4wtIrJylih6E8.q7C', 'maria@gmail.com', '2024-10-14 19:28:08', NULL, 1),
(2, 'lans', '$2y$10$QDQfvd59gitA7kMqQp/Me.1a3vkQnSFYNDMOdGAKmk/qLKSfnO/oO', 'lans@gmail.com', '2024-10-14 23:51:56', NULL, 1),
(3, 'sachi', '$2y$10$O98U8RLtLm5u4T3amzdFyO6FkS8MxvRRFqXuyJiJnsAeloMjx3f46', 'sach@gmail.com', '2024-10-14 23:56:45', NULL, 1),
(4, 'yessah', '$2y$10$6oxWxnbqPuyEf7LZ3FzvhOzZe1z1rhY/V/5bDJWrPbs5QO5sntSjq', 'ysa@gmail.com', '2024-10-14 23:59:49', NULL, 1),
(5, 'yessah', '$2y$10$O5AySaWffPX9LYuz.3l3kOlcaRrPX5e6gowsLq34LjMLBZPvC8x/m', 'ysa@gmail.com', '2024-10-15 00:01:10', NULL, 1),
(6, 'Sachi', '$2y$10$7EoxoW68YsIiiWqOmbKkxOVB7lAWMAZk8HwXYjcJ2QSgs825LCVES', 'sach@gmail.com', '2024-10-15 09:07:42', NULL, 1),
(7, 'Calvin', '$2y$10$pVQ/3UUXN/ICjkbArWk3JOvh0kBpnNnqWiiC2vRcNePmTHq24stu2', 'calvin@gmail.com', '2024-10-15 09:12:58', NULL, 1),
(8, 'Calvin', '$2y$10$xELDMw33mv0djDdkwvTKSu2HFicbLnxcloFmNS5zvk8NNJoW5Ikh6', 'ckiev@gmail.com', '2024-10-15 09:25:34', NULL, 1),
(9, 'Calvin', '$2y$10$Aak7c2P/DwcUZ1tN4jES8uV70YYX/0tv9J7r5D64vj6mYMOZQc1hi', 'ckiev@gmail.com', '2024-10-15 09:42:23', NULL, 1),
(10, 'Mark', '$2y$10$CjapmxSks5AsrlHmMX0dou4z01SJ0XFw47gq6lpTKfl1pDfTp4WNu', 'mark@gmail.com', '2024-10-15 09:43:34', NULL, 1),
(11, 'Malou', '$2y$10$ZiubSTGR1NnV9NQcCLWlSe7nGWVBAxPNITQ5PqSWyANvCiB1BO4LW', 'malou@gmail.com', '2024-10-15 11:17:03', NULL, 1),
(12, 'Lans', '$2y$10$hPUa54/oLZgLki06FX8j2.mbzb64rHBi9fEn7QMEgzOLqBQzRC6wu', 'lorence@gmail.com', '2024-10-15 12:04:51', NULL, 1),
(13, 'Deiwen', '$2y$10$prMSKC1LFgqXApaijoPmk.RsIVGaoYy7MBpwNDCWYjkPEo/0Kny.m', 'kiev@gmail.com', '2024-10-15 12:22:46', NULL, 1),
(14, 'den', '$2y$10$njuYLKoZEPbAo7J.1ybrBuuaw27YFUtDem7sg84kdvNakeyhNSGTq', 'den@gmail.com', '2024-10-15 16:20:41', '2024-10-15 11:20:41', 1),
(15, 'Kebin', '$2y$10$E16EdIOo/Aq.eVMvV8sNJOprOCsf0E8Oq0xyWt8tU4aiQ.B76jEze', 'kebin@gamil.com', '2024-10-15 16:32:14', '2024-10-15 11:32:14', 1),
(16, 'Chat', '$2y$10$OO2U5YjJCSJJEs9bgNJmjOyrCAKYkE3KjrnNfg.eJccJIbVtjpYm2', 'chat@gmail.com', '2024-10-15 20:03:33', '2024-10-15 15:03:33', 1),
(17, 'aging', '$2y$10$vOFrnZmSuKOUQNCog/f/HeexyWozgzhcQJ5QV9KU6mhMzbzEAfyxC', 'aging@gmail.com', '2024-10-15 20:04:47', '2024-10-15 15:04:47', 1),
(18, 'aging', '$2y$10$XlprIr1./kP9m0tGDCnnRuv7juD6lM2CKNRUQo4qfGIHlDPYksLBS', 'aging@gmail.com', '2024-10-15 20:08:12', '2024-10-15 15:08:12', 1),
(19, 'martin', '$2y$10$xnfFf6N1FpI.MbaIcTB09O5j7zYjI8auQrxwiYXIN16H8G3ZRPnF.', 'martin@gmail.com', '2024-10-15 20:12:45', '2024-10-15 15:12:45', 1),
(20, 'test', '$2y$10$yZW2eNO0Xd9AHW8QXFCdgupwohrX73Do/84kGA1yBMdFQiKD4WSPS', 'test@gmail.com', '2024-10-15 20:16:51', '2024-10-15 15:16:51', 1),
(21, 'vhey', '$2y$10$5ocHJEZwkqbQODMEvnRFJOiQm8s0fGfAB1yxLhopL.v8FQUKGouYa', 'vhey@gmail.com', '2024-10-17 23:54:48', '2024-10-17 18:54:48', 1),
(22, 'SACHI', '$2y$10$h6RyoZvssiD05m3dnln6C.AFPvZ7hnn9tLtaA4fZ1U5AV50uYPsZa', 'sach@gmail.com', '2024-10-18 09:38:46', '2024-10-18 03:39:46', 1),
(23, 'Shandy', '$2y$10$Srh3bAjbs7L5uyKKwG832ufPJ35MinX0AvGo9TchodEsI0XANUVQm', 'shandy@gmail.com', '2024-10-18 09:40:41', '2024-10-18 04:40:41', 1),
(24, 'nics', '$2y$10$AB3vzosMXdiHsDUta/23R.3uVYdrYtQGZNUbMTMEGtRqjosJx6512', 'nics@gmail.com', '2024-10-18 11:47:09', '2024-10-18 06:47:09', 1),
(25, 'hana', '$2y$10$g0Ybt.ype3RpmYN1kevhP.AAeEuHAqNx3K7LrFJdIg8wA1eGd6wnO', 'hana@gmail.com', '2024-10-18 12:31:09', '2024-10-18 07:31:09', 1),
(26, 'yeah', '$2y$10$VNHXMJUedbf6DkxQxTIK4ONMgm9pHflkPXmpUH5/Sk5NQSbq8ZTKi', 'yeah@gmail.com', '2024-10-18 12:32:06', '2024-10-18 07:32:06', 1),
(27, 'sach', '$2y$10$5LfFQxJVdEpgw4dyAvX7muO0Sc6NdHHKUcZpCWM/X55ca1N5s1Nne', 'sach@gmail.com', '2024-10-18 13:51:21', '2024-10-18 08:51:21', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `symptoms`
--
ALTER TABLE `symptoms`
  ADD PRIMARY KEY (`symptom_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `symptoms`
--
ALTER TABLE `symptoms`
  MODIFY `symptom_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `symptoms`
--
ALTER TABLE `symptoms`
  ADD CONSTRAINT `symptoms_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
