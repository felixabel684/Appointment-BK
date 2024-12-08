-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 08, 2024 at 08:49 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appointment_bk`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment_schedules`
--

CREATE TABLE `appointment_schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `appointmentDay` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appointmentStart` time NOT NULL,
  `appointmentEnd` time NOT NULL,
  `appointmentStatus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ACTIVE',
  `doctors_id` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointment_schedules`
--

INSERT INTO `appointment_schedules` (`id`, `appointmentDay`, `appointmentStart`, `appointmentEnd`, `appointmentStatus`, `doctors_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Senin', '14:00:00', '15:00:00', 'INACTIVE', 1, NULL, '2024-11-26 23:01:49', '2024-12-06 07:49:50'),
(2, 'Selasa', '16:30:00', '17:45:00', 'INACTIVE', 1, NULL, '2024-11-27 02:31:24', '2024-12-06 07:29:21'),
(3, 'Sabtu', '17:00:00', '19:01:00', 'INACTIVE', 1, NULL, '2024-11-27 02:53:06', '2024-12-06 07:27:42'),
(4, 'Selasa', '18:00:00', '21:00:00', 'INACTIVE', 1, NULL, '2024-11-27 03:01:01', '2024-12-06 07:27:32'),
(5, 'Senin', '17:42:00', '19:42:00', 'INACTIVE', 1, NULL, '2024-11-27 03:42:23', '2024-12-06 07:32:05'),
(6, 'Rabu', '17:42:00', '19:42:00', 'INACTIVE', 1, NULL, '2024-11-27 03:42:41', '2024-12-06 07:45:23'),
(7, 'Rabu', '18:51:00', '19:51:00', 'INACTIVE', 1, NULL, '2024-11-27 03:51:27', '2024-12-06 07:32:05'),
(8, 'Rabu', '17:51:00', '18:51:00', 'INACTIVE', 1, NULL, '2024-11-27 03:51:59', '2024-11-27 03:54:02'),
(9, 'Rabu', '17:54:00', '18:54:00', 'INACTIVE', 1, NULL, '2024-11-27 03:54:09', '2024-12-02 11:28:18'),
(10, 'Minggu', '16:31:00', '18:32:00', 'INACTIVE', 1, NULL, '2024-12-06 07:32:29', '2024-12-06 07:45:15'),
(11, 'Senin', '15:05:00', '16:49:00', 'INACTIVE', 1, NULL, '2024-12-06 07:52:03', '2024-12-06 07:52:33'),
(12, 'Minggu', '14:56:00', '15:56:00', 'ACTIVE', 1, NULL, '2024-12-06 07:56:10', '2024-12-06 07:56:10'),
(13, 'Senin', '14:00:00', '15:00:00', 'INACTIVE', 2, NULL, '2024-12-07 15:55:02', '2024-12-07 15:55:52'),
(14, 'Selasa', '16:00:00', '17:00:00', 'ACTIVE', 2, NULL, '2024-12-07 15:55:52', '2024-12-07 15:55:52');

-- --------------------------------------------------------

--
-- Table structure for table `clinics`
--

CREATE TABLE `clinics` (
  `id` bigint UNSIGNED NOT NULL,
  `clinicName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clinics`
--

INSERT INTO `clinics` (`id`, `clinicName`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Poli Umum', 'Penyakit Umum', NULL, '2024-11-26 04:24:37', '2024-11-26 04:24:37'),
(2, 'Poli Gigi', 'Penyakit Gigi', NULL, '2024-12-02 14:06:41', '2024-12-02 14:06:41'),
(3, 'Poli Syaraf', 'Penyakit Syaraf', NULL, '2024-12-02 14:07:01', '2024-12-02 14:07:01');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint UNSIGNED NOT NULL,
  `doctorName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `clinics_id` bigint UNSIGNED DEFAULT NULL,
  `users_id` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `doctorName`, `address`, `phone`, `clinics_id`, `users_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'dr. David', 'Imam Bonjol Street 5-11 Nakula I Street', '088787665554', 1, 3, NULL, '2024-11-26 09:17:16', '2024-11-26 09:17:16'),
(2, 'dr. Luna', 'Sidoarjo', '088787665554', 2, 4, NULL, '2024-12-02 14:07:39', '2024-12-02 14:07:39'),
(3, 'dr. Sasa', 'Bumi', '088787665554', 2, 5, NULL, '2024-12-02 14:08:17', '2024-12-02 14:08:23'),
(4, 'Dr. Lia', 'Konoha', '088787665554', 3, 6, NULL, '2024-12-02 14:10:09', '2024-12-02 14:10:09');

-- --------------------------------------------------------

--
-- Table structure for table `examinations`
--

CREATE TABLE `examinations` (
  `id` bigint UNSIGNED NOT NULL,
  `examinationDate` datetime NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `list_clinics_id` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `examinations`
--

INSERT INTO `examinations` (`id`, `examinationDate`, `note`, `price`, `list_clinics_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '2024-12-01 19:32:00', 'istirahat ya', 165000, 1, NULL, '2024-12-01 12:35:04', '2024-12-01 16:11:51'),
(2, '2024-12-01 21:06:00', 'gg', 165000, NULL, '2024-12-02 03:12:37', '2024-12-01 14:07:03', '2024-12-01 14:07:03'),
(3, '2024-12-01 21:13:00', 'kk', 165000, NULL, '2024-12-02 03:12:46', '2024-12-01 14:13:44', '2024-12-01 14:13:44'),
(4, '2024-12-01 21:14:00', 'ff', 165000, NULL, '2024-12-02 03:12:50', '2024-12-01 14:14:31', '2024-12-01 14:14:31'),
(5, '2024-12-02 14:41:00', 'istirahat ya', 175000, 10, NULL, '2024-12-02 07:41:40', '2024-12-07 16:02:15'),
(6, '2024-12-07 20:42:00', 'dijaga', 160000, 13, NULL, '2024-12-07 13:42:12', '2024-12-07 13:42:12'),
(7, '2024-12-07 23:55:00', 'oke', 165000, 14, NULL, '2024-12-07 16:56:08', '2024-12-07 16:56:08');

-- --------------------------------------------------------

--
-- Table structure for table `examination_details`
--

CREATE TABLE `examination_details` (
  `id` bigint UNSIGNED NOT NULL,
  `examinations_id` bigint UNSIGNED DEFAULT NULL,
  `medicines_id` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `examination_details`
--

INSERT INTO `examination_details` (`id`, `examinations_id`, `medicines_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, '2024-12-01 12:35:04', '2024-12-01 12:35:04'),
(2, 2, 1, NULL, '2024-12-01 14:07:03', '2024-12-01 14:07:03'),
(3, 3, 1, NULL, '2024-12-01 14:13:44', '2024-12-01 14:13:44'),
(4, 4, 1, NULL, '2024-12-01 14:14:31', '2024-12-01 14:14:31'),
(5, 5, 2, NULL, '2024-12-02 07:41:40', '2024-12-02 07:41:40'),
(6, 5, 1, NULL, '2024-12-02 07:41:40', '2024-12-02 07:41:40'),
(7, 6, 2, NULL, '2024-12-07 13:42:12', '2024-12-07 13:42:12'),
(8, 7, 1, NULL, '2024-12-07 16:56:08', '2024-12-07 16:56:08');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `list_clinics`
--

CREATE TABLE `list_clinics` (
  `id` bigint UNSIGNED NOT NULL,
  `complaint` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queueNumber` int NOT NULL,
  `patients_id` bigint UNSIGNED DEFAULT NULL,
  `appointment_schedules_id` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `list_clinics`
--

INSERT INTO `list_clinics` (`id`, `complaint`, `queueNumber`, `patients_id`, `appointment_schedules_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'batuk', 1, 1, 9, NULL, '2024-11-28 09:06:09', '2024-11-28 09:06:09'),
(2, 'Sakit perut', 1, 1, 9, '2024-12-02 06:24:31', '2024-12-02 03:55:23', '2024-12-02 03:55:23'),
(3, 'Sakit kepala', 1, 1, 9, '2024-12-02 04:24:37', '2024-12-02 04:24:02', '2024-12-02 04:24:02'),
(4, 'Sakit kaki', 1, 2, 9, '2024-12-02 06:24:10', '2024-12-02 04:43:37', '2024-12-02 04:43:37'),
(5, 'Sakit tangan', 1, 3, 9, '2024-12-07 08:42:39', '2024-12-02 04:52:03', '2024-12-02 04:52:03'),
(6, 'Sakit tangan', 1, 3, 9, '2024-12-02 06:21:50', '2024-12-02 05:32:38', '2024-12-02 05:32:38'),
(7, 'ok', 1, 3, 9, '2024-12-02 06:21:55', '2024-12-02 05:59:36', '2024-12-02 05:59:36'),
(8, 'ok', 1, 3, 9, '2024-12-02 06:23:52', '2024-12-02 06:02:51', '2024-12-02 06:02:51'),
(9, 'er', 1, 3, 9, '2024-12-02 06:23:57', '2024-12-02 06:06:34', '2024-12-02 06:06:34'),
(10, 'ok', 2, 3, 9, NULL, '2024-12-02 06:12:23', '2024-12-02 06:12:23'),
(11, 'ok', 1, 3, 9, '2024-12-02 06:24:05', '2024-12-02 06:21:11', '2024-12-02 06:21:11'),
(12, 'ok', 3, 3, 9, '2024-12-02 06:24:24', '2024-12-02 06:21:37', '2024-12-02 06:21:37'),
(13, 'Sakit hati', 3, 2, 9, NULL, '2024-12-02 07:35:22', '2024-12-02 07:35:22'),
(14, 'karang', 1, 1, 14, NULL, '2024-12-07 16:55:14', '2024-12-07 16:55:14');

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` bigint UNSIGNED NOT NULL,
  `medicineName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `packaging` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `medicineName`, `packaging`, `price`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Paramex', 'Tablet', 15000, NULL, '2024-11-26 09:41:22', '2024-11-26 09:41:36'),
(2, 'Diatab', 'Tablet', 10000, NULL, '2024-12-02 07:39:38', '2024-12-02 07:39:38'),
(3, 'Paratusin', 'Tablet', 25000, NULL, '2024-12-02 14:06:18', '2024-12-02 14:06:18');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_11_25_054809_create_medicines_table', 1),
(6, '2024_11_25_055059_create_clinics_table', 1),
(7, '2024_11_25_055153_create_doctors_table', 1),
(8, '2024_11_25_055419_create_patients_table', 1),
(9, '2024_11_25_062041_create_appointment_schedules_table', 1),
(10, '2024_11_25_062555_create_list_clinics_table', 1),
(11, '2024_11_25_063427_create_examinations_table', 1),
(12, '2024_11_25_064810_create_examination_details_table', 1),
(13, '2024_11_25_091627_create_users_table', 2),
(14, '2024_11_25_140552_add_users_id_to_doctors_table', 3),
(15, '2024_11_25_142331_add_status_to_appointment_schedules_table', 4),
(16, '2014_10_12_100000_create_password_resets_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint UNSIGNED NOT NULL,
  `nik` bigint NOT NULL,
  `patientName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rmNumber` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `nik`, `patientName`, `address`, `phone`, `rmNumber`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1234567887654321, 'Alexandro', 'Imam Bonjol Street 6-12 Nakula I Street', '088787665554', '202411-001', NULL, '2024-11-26 09:47:21', '2024-11-26 09:47:21'),
(2, 1234567812345678, 'Michael', 'Konoha', '08163202855', '202412-001', NULL, '2024-12-02 04:27:28', '2024-12-02 04:27:28'),
(3, 1122334455667788, 'Luna', 'Kazekage', '081632028553', '202412-002', NULL, '2024-12-02 04:50:44', '2024-12-02 04:50:44');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'DOCTOR',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `roles`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$gnxZ1hvj0oI2HWKhzd/ImO0RSW1AL8j8cWEzLe2.kKDlWz.Lt/2Ie', 'ADMIN', NULL, '2024-11-25 22:21:38', '2024-11-25 22:21:38'),
(2, 'admin2', '$2y$10$fOFyTDahbMgN6zPOvqCE2.sQCcYfK1EICKhpPNfmQMCQcVKsBp2h6', 'ADMIN', NULL, '2024-11-26 04:12:57', '2024-11-26 04:12:57'),
(3, 'david', '$2a$12$pPhTWdo35PjvUWcgw5YWkubNeAN7mgUuMCI.owo1jRMngwmQxo8qC', 'DOCTOR', NULL, '2024-11-26 09:17:16', '2024-11-27 21:20:45'),
(4, 'luna', '$2y$10$Vr5BWyPhWgPf9nw15AW/m.QRxkImUs.SZ27IJ5oF7xXbR1AISARF.', 'DOCTOR', NULL, '2024-12-02 14:07:39', '2024-12-02 14:07:39'),
(5, 'sasa', '$2y$10$cx8q/oDL0gYq5RkC4dlSAOUFKHgcpSLi5tsnAvMqDNHPzGN8Hj3Cq', 'DOCTOR', NULL, '2024-12-02 14:08:17', '2024-12-02 14:08:17'),
(6, 'lia', '$2y$10$q9C3KMK5bAF1Ds6XZl1e6.sWti0h0BCWigEg7rWhdT86bnA0Bi9.W', 'DOCTOR', NULL, '2024-12-02 14:10:09', '2024-12-02 14:10:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment_schedules`
--
ALTER TABLE `appointment_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_schedules_doctors_id_foreign` (`doctors_id`);

--
-- Indexes for table `clinics`
--
ALTER TABLE `clinics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctors_clinics_id_foreign` (`clinics_id`),
  ADD KEY `doctors_users_id_foreign` (`users_id`);

--
-- Indexes for table `examinations`
--
ALTER TABLE `examinations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `examinations_list_clinics_id_foreign` (`list_clinics_id`);

--
-- Indexes for table `examination_details`
--
ALTER TABLE `examination_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `examination_details_examinations_id_foreign` (`examinations_id`),
  ADD KEY `examination_details_medicines_id_foreign` (`medicines_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `list_clinics`
--
ALTER TABLE `list_clinics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `list_clinics_patients_id_foreign` (`patients_id`),
  ADD KEY `list_clinics_appointment_schedules_id_foreign` (`appointment_schedules_id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patients_nik_unique` (`nik`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment_schedules`
--
ALTER TABLE `appointment_schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `clinics`
--
ALTER TABLE `clinics`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `examinations`
--
ALTER TABLE `examinations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `examination_details`
--
ALTER TABLE `examination_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `list_clinics`
--
ALTER TABLE `list_clinics`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment_schedules`
--
ALTER TABLE `appointment_schedules`
  ADD CONSTRAINT `appointment_schedules_doctors_id_foreign` FOREIGN KEY (`doctors_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_clinics_id_foreign` FOREIGN KEY (`clinics_id`) REFERENCES `clinics` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctors_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `examinations`
--
ALTER TABLE `examinations`
  ADD CONSTRAINT `examinations_list_clinics_id_foreign` FOREIGN KEY (`list_clinics_id`) REFERENCES `list_clinics` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `examination_details`
--
ALTER TABLE `examination_details`
  ADD CONSTRAINT `examination_details_examinations_id_foreign` FOREIGN KEY (`examinations_id`) REFERENCES `examinations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `examination_details_medicines_id_foreign` FOREIGN KEY (`medicines_id`) REFERENCES `medicines` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `list_clinics`
--
ALTER TABLE `list_clinics`
  ADD CONSTRAINT `list_clinics_appointment_schedules_id_foreign` FOREIGN KEY (`appointment_schedules_id`) REFERENCES `appointment_schedules` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `list_clinics_patients_id_foreign` FOREIGN KEY (`patients_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
