-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2024 at 06:09 PM
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
-- Database: `student`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_fields`
--

CREATE TABLE `form_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_title` varchar(255) NOT NULL,
  `form_desc` text NOT NULL,
  `label` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT 0,
  `field_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`field_data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form_fields`
--

INSERT INTO `form_fields` (`id`, `form_title`, `form_desc`, `label`, `type`, `required`, `field_data`, `created_at`, `updated_at`) VALUES
(4, 'ajhn', 'ghjkm', 'ajsd', 'linear_scale', 1, '{\"min_value\":\"1\",\"max_value\":\"10\",\"step\":\"2\",\"left_label\":\"ss\",\"right_label\":\"fa\"}', '2024-03-23 13:37:50', '2024-03-23 13:37:50'),
(5, 'ajhn', 'ghjkm', 'fa', 'linear_scale', 0, '{\"min_value\":\"0\",\"max_value\":\"50\",\"step\":\"1\",\"left_label\":null,\"right_label\":null}', '2024-03-23 13:38:11', '2024-03-23 13:38:11');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_02_04_164032_create_students_table', 1),
(6, '2014_10_12_100000_create_password_resets_table', 2),
(7, '2024_02_16_133258_create_form_fields_table', 2),
(8, '2024_02_16_134540_create_form_fields_table', 3),
(9, '2024_02_17_031226_create_form_fields_table', 4),
(10, '2024_02_17_035816_create_form_fields_table', 5),
(11, '2024_02_18_161632_create_students_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('mailoanish@gmail.com', '$2y$12$deWQBZqswumHmOsjZnV8EOzHtTZ2HDw9Lk4G/Ro0/Fc22m9kVjt8G', '2024-02-27 06:48:26');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`form_data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `form_data`, `created_at`, `updated_at`) VALUES
(2, '{\"_token\":\"Jk783Zt49jyFm3CClvxP9iKbUorlbDoXkzJ1865S\",\"nm,\":\"3\",\"hhg\":[\"d\"]}', '2024-03-23 04:11:37', '2024-03-23 04:11:37'),
(3, '{\"_token\":\"Jk783Zt49jyFm3CClvxP9iKbUorlbDoXkzJ1865S\",\"nm,\":\"sfb\",\"hhg\":[\"h\"],\"Hello\":[\"1\"],\"fd\":\"d\"}', '2024-03-23 04:14:36', '2024-03-23 04:14:36'),
(6, '{\"_token\":\"Jk783Zt49jyFm3CClvxP9iKbUorlbDoXkzJ1865S\"}', '2024-03-23 05:46:47', '2024-03-23 05:46:47'),
(7, '{\"_token\":\"Jk783Zt49jyFm3CClvxP9iKbUorlbDoXkzJ1865S\",\"Mail hal\":{\"ghjk\":\"bnm\",\"hm\":\"nm\"}}', '2024-03-23 05:49:50', '2024-03-23 05:49:50'),
(8, '{\"_token\":\"Jk783Zt49jyFm3CClvxP9iKbUorlbDoXkzJ1865S\",\"Mail hal\":{\"ghjk\":\"bnm\",\"hm\":\"bnm\"}}', '2024-03-23 05:50:33', '2024-03-23 05:50:33'),
(9, '{\"_token\":\"Jk783Zt49jyFm3CClvxP9iKbUorlbDoXkzJ1865S\",\"kj  m,,mkm\":{\"m,\":\"bn\",\"nmj\":\"bn\"}}', '2024-03-23 05:52:37', '2024-03-23 05:52:37'),
(10, '{\"_token\":\"Jk783Zt49jyFm3CClvxP9iKbUorlbDoXkzJ1865S\",\"kj  m,,mkm\":{\"m,\":\"nm\",\"nmj\":\"nm\"},\"chh\":{\"nm\":[\"bnm,\",\"bnm,\"]}}', '2024-03-23 05:54:08', '2024-03-23 05:54:08'),
(11, '{\"_token\":\"Jk783Zt49jyFm3CClvxP9iKbUorlbDoXkzJ1865S\",\"kj  m,,mkm\":{\"m,\":\"bn\",\"nmj\":\"bn\"},\"chh\":{\"nm\":[\"bnm\",\"bnm,\",\"bnm\",\"bnm,\"]},\"Mail hal\":[\"jnm\",\"jm,\",\"m,\",\"nm,\"],\"ghjnk\":\"ml;\"}', '2024-03-23 05:56:58', '2024-03-23 05:56:58'),
(12, '{\"_token\":\"Jk783Zt49jyFm3CClvxP9iKbUorlbDoXkzJ1865S\",\"kj  m,,mkm\":{\"m,\":\"bn\",\"nmj\":\"nm\"},\"chh\":{\"nm\":[\"bnm\",\"bnm,\",\"bnm\",\"bnm,\"]},\"Mail hal\":[\"jnm\",\"jm,\",\"m,\",\"nm,\"],\"ghjnk\":\"ml;\"}', '2024-03-23 06:01:42', '2024-03-23 06:01:42'),
(13, '{\"_token\":\"Jk783Zt49jyFm3CClvxP9iKbUorlbDoXkzJ1865S\",\"ghj\":\"Hello\",\"jasnm\":\"K cha\",\"hdf\":\"sja\",\"slider_ajsd\":\"3\",\"ajsd\":\"20\",\"slider_fa\":\"20\",\"fa\":null}', '2024-03-23 13:38:38', '2024-03-23 13:38:38'),
(14, '{\"_token\":\"Jk783Zt49jyFm3CClvxP9iKbUorlbDoXkzJ1865S\",\"ghj\":\"fgvjkhlj;kl\",\"jasnm\":\"gjhjm\",\"hdf\":\"hbjkml,.\",\"slider_ajsd\":\"3\",\"ajsd\":\"32\",\"slider_fa\":\"32\",\"fa\":null}', '2024-03-23 13:39:38', '2024-03-23 13:39:38'),
(15, '{\"_token\":\"Jk783Zt49jyFm3CClvxP9iKbUorlbDoXkzJ1865S\",\"ghj\":null,\"jasnm\":null,\"hdf\":\"hbjkml,.\",\"ajsd\":\"7\",\"fa\":null}', '2024-03-23 13:43:49', '2024-03-23 13:43:49'),
(16, '{\"_token\":\"Jk783Zt49jyFm3CClvxP9iKbUorlbDoXkzJ1865S\",\"ghj\":\"ghjm\",\"jasnm\":\"vbnm\",\"hdf\":\"ghbnm\",\"ajsd\":\"31\",\"fa\":null}', '2024-03-23 13:44:40', '2024-03-23 13:44:40'),
(17, '{\"_token\":\"Jk783Zt49jyFm3CClvxP9iKbUorlbDoXkzJ1865S\",\"ghj\":\"hjm\",\"jasnm\":\"bnm\",\"hdf\":\"bnm,\",\"ajsd\":\"3\",\"fa\":null}', '2024-03-23 13:45:32', '2024-03-23 13:45:32'),
(18, '{\"_token\":\"Jk783Zt49jyFm3CClvxP9iKbUorlbDoXkzJ1865S\",\"ghj\":null,\"jasnm\":null,\"hdf\":\"bnm\",\"slider_ajsd\":\"3\",\"ajsd\":\"22\",\"slider_fa\":\"22\",\"fa\":null}', '2024-03-23 13:53:38', '2024-03-23 13:53:38'),
(19, '{\"_token\":\"Jk783Zt49jyFm3CClvxP9iKbUorlbDoXkzJ1865S\",\"ghj\":null,\"jasnm\":null,\"hdf\":\"hello\",\"ajsd\":\"6\",\"fa\":null}', '2024-03-23 13:55:19', '2024-03-23 13:55:19'),
(20, '{\"_token\":\"Jk783Zt49jyFm3CClvxP9iKbUorlbDoXkzJ1865S\",\"ghj\":null,\"jasnm\":null,\"hdf\":\"bm,.\",\"slider_ajsd\":\"9\",\"ajsd\":\"6\",\"slider_fa\":\"6\",\"fa\":null}', '2024-03-23 13:59:19', '2024-03-23 13:59:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'anish', 'mailoanish@gmail.com', NULL, '$2y$12$Fou5pI/UTycC4penS4H2bOPkgwtIT8WcS0hJMvwGvOqzrqwyVjNZu', 'WsdNLLwkBRNUDJEKhUqzSwQG71T5zr6I2V5d2QNDx3dYUOvqCdx6wGvJXI7b', '2024-03-17 08:33:31', '2024-03-17 08:33:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `form_fields`
--
ALTER TABLE `form_fields`
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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_fields`
--
ALTER TABLE `form_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
