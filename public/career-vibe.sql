-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 19, 2024 at 07:02 PM
-- Server version: 8.0.35-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `career-vibe`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `userType` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ADMIN',
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image_url` text COLLATE utf8mb4_unicode_ci,
  `profile_image_public_id` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `userType`, `name`, `email`, `password`, `profile_image_url`, `profile_image_public_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'ADMIN', 'Admin 1', 'admin1@admin.com', '$2y$12$yPVDNVbU6DKpLlGFDiijBOxfmO.4PxQbnCpriXE9amJmTPMRi3eeK', NULL, NULL, '4goMj97T01c6Ldvo7hlHnAwr69bZX5tdoNWEc67Q0MdnHZhJETtnQymZ9XqC', '2024-01-19 07:10:07', '2024-01-19 07:10:33');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint UNSIGNED NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `userType` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'COMPANY',
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image_url` text COLLATE utf8mb4_unicode_ci,
  `profile_image_public_id` text COLLATE utf8mb4_unicode_ci,
  `website` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `job`
--

CREATE TABLE `job` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `sub_profile_id` bigint UNSIGNED NOT NULL,
  `vacancy` tinyint DEFAULT NULL,
  `min_salary` mediumint DEFAULT NULL,
  `max_salary` mediumint DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `responsibility` text COLLATE utf8mb4_unicode_ci,
  `benifits_perks` text COLLATE utf8mb4_unicode_ci,
  `other_benifits` text COLLATE utf8mb4_unicode_ci,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_type` enum('REMOTE','WFO','HYBRID') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_type` enum('FULL_TIME','PART_TIME','INTERNSHIP','CONTRACT') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience_level` enum('FRESHER','EXPERIENCED') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience_type` enum('ANY','1-2','2-3','3-5','5-8','8-10','10+') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_locations`
--

CREATE TABLE `job_locations` (
  `id` bigint UNSIGNED NOT NULL,
  `jobs_id` bigint UNSIGNED NOT NULL,
  `locations_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_qualifications`
--

CREATE TABLE `job_qualifications` (
  `id` bigint UNSIGNED NOT NULL,
  `jobs_id` bigint UNSIGNED NOT NULL,
  `qualifications_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint UNSIGNED NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `city`, `state`, `country`, `pincode`, `created_at`, `updated_at`) VALUES
(1, 'Rajkot', 'Gujarat', 'India', NULL, '2024-01-19 07:16:11', '2024-01-19 07:16:11'),
(2, 'Ahmedabad', 'Gujarat', 'India', NULL, '2024-01-19 07:16:16', '2024-01-19 07:16:16'),
(3, 'Mumbai', 'Maharashtra', 'India', NULL, '2024-01-19 07:16:23', '2024-01-19 07:16:30'),
(4, 'Jaipur', 'Maharashtra', 'India', NULL, '2024-01-19 07:16:37', '2024-01-19 07:16:37'),
(5, 'Vadodara', 'Gujarat', NULL, NULL, '2024-01-19 07:35:21', '2024-01-19 07:35:21'),
(6, 'Surat', 'Gujarat', NULL, NULL, '2024-01-19 07:35:26', '2024-01-19 07:35:26');

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
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2024_01_10_073228_create_users_table', 1),
(5, '2024_01_10_073245_create_profile_categories_table', 1),
(6, '2024_01_10_073247_create_sub_profiles_table', 1),
(7, '2024_01_10_073248_create_companies_table', 1),
(8, '2024_01_10_073249_create_jobs_table', 1),
(9, '2024_01_10_073434_create_qualifications_table', 1),
(10, '2024_01_10_073439_create_job_qualifications_table', 1),
(11, '2024_01_10_073450_create_locations_table', 1),
(12, '2024_01_10_073451_create_job_locations_table', 1),
(13, '2024_01_10_073914_create_admins_table', 1),
(14, '2024_01_17_124422_create_job_table', 1);

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
-- Table structure for table `profile_categories`
--

CREATE TABLE `profile_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profile_categories`
--

INSERT INTO `profile_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Photography', '2024-01-19 07:20:30', '2024-01-19 07:20:30'),
(2, 'Music', '2024-01-19 07:20:48', '2024-01-19 07:20:48'),
(3, 'Public Relations', '2024-01-19 07:20:57', '2024-01-19 07:20:57'),
(4, 'Journalism', '2024-01-19 07:21:05', '2024-01-19 07:21:05'),
(5, 'Graphic Design', '2024-01-19 07:21:14', '2024-01-19 07:21:14'),
(6, 'Animation', '2024-01-19 07:25:55', '2024-01-19 07:25:55'),
(7, 'Game Design', '2024-01-19 07:26:42', '2024-01-19 07:26:42'),
(8, 'Fashion Design', '2024-01-19 07:27:31', '2024-01-19 07:27:31'),
(9, 'Software Engineering', '2024-01-19 07:28:44', '2024-01-19 07:28:44'),
(10, 'Banking', '2024-01-19 07:29:57', '2024-01-19 07:29:57'),
(11, 'Information Technology', '2024-01-19 07:33:34', '2024-01-19 07:33:34');

-- --------------------------------------------------------

--
-- Table structure for table `qualifications`
--

CREATE TABLE `qualifications` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qualifications`
--

INSERT INTO `qualifications` (`id`, `name`, `created_at`, `updated_at`) VALUES
(9, 'Diploma In Photography', '2024-01-19 07:37:55', '2024-01-19 07:37:55'),
(13, 'Bachelor of Arts', '2024-01-19 07:39:05', '2024-01-19 07:39:40'),
(14, 'B.A.(Hons) Communication Design - Photography', '2024-01-19 07:40:26', '2024-01-19 07:40:42'),
(15, 'Professional Certificate in Wedding Photography', '2024-01-19 07:41:46', '2024-01-19 07:41:46'),
(16, 'Bachelor of Fine Arts in Photography', '2024-01-19 07:42:13', '2024-01-19 07:42:13'),
(17, 'Bachelor of Music', '2024-01-19 07:43:27', '2024-01-19 07:43:27'),
(18, 'Diploma in Journalism', '2024-01-19 07:44:10', '2024-01-19 07:44:10'),
(19, 'BA Journalism', '2024-01-19 07:45:50', '2024-01-19 07:45:50'),
(20, 'MA Journalism', '2024-01-19 07:46:10', '2024-01-19 07:46:10');

-- --------------------------------------------------------

--
-- Table structure for table `sub_profiles`
--

CREATE TABLE `sub_profiles` (
  `id` bigint UNSIGNED NOT NULL,
  `profile_category_id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_profiles`
--

INSERT INTO `sub_profiles` (`id`, `profile_category_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 5, 'Creative Director', '2024-01-19 07:21:26', '2024-01-19 07:21:26'),
(2, 5, 'Web Designer', '2024-01-19 07:21:40', '2024-01-19 07:21:40'),
(3, 5, 'Visual Designer', '2024-01-19 07:21:49', '2024-01-19 07:21:49'),
(4, 5, 'Brand Identity Designer', '2024-01-19 07:22:01', '2024-01-19 07:22:01'),
(5, 2, 'Musician', '2024-01-19 07:22:08', '2024-01-19 07:22:08'),
(6, 2, 'Composer', '2024-01-19 07:22:17', '2024-01-19 07:22:17'),
(7, 2, 'Music Producer', '2024-01-19 07:22:27', '2024-01-19 07:22:27'),
(8, 2, 'Sound Engineer', '2024-01-19 07:22:37', '2024-01-19 07:22:37'),
(9, 2, 'Music Therapist', '2024-01-19 07:22:44', '2024-01-19 07:22:44'),
(10, 4, 'Journalist', '2024-01-19 07:22:57', '2024-01-19 07:22:57'),
(11, 4, 'News Anchor', '2024-01-19 07:23:05', '2024-01-19 07:23:05'),
(12, 4, 'Editor', '2024-01-19 07:23:13', '2024-01-19 07:23:13'),
(13, 4, 'Copy Editor', '2024-01-19 07:23:23', '2024-01-19 07:23:23'),
(14, 4, 'Photojournalist', '2024-01-19 07:23:30', '2024-01-19 07:23:30'),
(15, 1, 'Photographer', '2024-01-19 07:24:39', '2024-01-19 07:24:39'),
(16, 1, 'Photo Editor', '2024-01-19 07:24:46', '2024-01-19 07:24:46'),
(17, 1, 'Product Photographer', '2024-01-19 07:25:33', '2024-01-19 07:25:33'),
(18, 1, 'Wedding Photographer', '2024-01-19 07:25:43', '2024-01-19 07:25:43'),
(19, 6, '3D Modeler', '2024-01-19 07:26:06', '2024-01-19 07:26:06'),
(20, 6, 'Motion Graphics Designer', '2024-01-19 07:26:15', '2024-01-19 07:26:15'),
(21, 6, 'Storyboard Artist', '2024-01-19 07:26:24', '2024-01-19 07:26:24'),
(22, 6, 'Character Designer', '2024-01-19 07:26:31', '2024-01-19 07:26:31'),
(23, 7, 'Game Designer', '2024-01-19 07:26:51', '2024-01-19 07:26:51'),
(24, 7, 'Game Programmer', '2024-01-19 07:26:58', '2024-01-19 07:26:58'),
(25, 7, 'Game Artist', '2024-01-19 07:27:06', '2024-01-19 07:27:06'),
(26, 7, 'Game Tester', '2024-01-19 07:27:13', '2024-01-19 07:27:13'),
(27, 7, 'Game Writer', '2024-01-19 07:27:22', '2024-01-19 07:27:22'),
(28, 8, 'Fashion Designer', '2024-01-19 07:27:46', '2024-01-19 07:27:46'),
(29, 8, 'Fashion Illustrator', '2024-01-19 07:27:54', '2024-01-19 07:27:54'),
(30, 8, 'Textile Designer', '2024-01-19 07:28:01', '2024-01-19 07:28:01'),
(31, 8, 'Fashion Buyer', '2024-01-19 07:28:07', '2024-01-19 07:28:07'),
(32, 8, 'Fashion Merchandiser', '2024-01-19 07:28:14', '2024-01-19 07:28:14'),
(33, 9, 'Software Developer', '2024-01-19 07:28:58', '2024-01-19 07:28:58'),
(34, 9, 'Software Architect', '2024-01-19 07:29:07', '2024-01-19 07:29:07'),
(35, 9, 'Database Engineer', '2024-01-19 07:29:15', '2024-01-19 07:29:15'),
(36, 9, 'Data Scientist', '2024-01-19 07:29:23', '2024-01-19 07:29:23'),
(37, 9, 'DevOps Engineer', '2024-01-19 07:29:37', '2024-01-19 07:29:37'),
(38, 10, 'Bank Teller', '2024-01-19 07:32:21', '2024-01-19 07:32:21'),
(39, 10, 'Loan Officer', '2024-01-19 07:32:35', '2024-01-19 07:32:35'),
(40, 10, 'Branch Manager', '2024-01-19 07:32:44', '2024-01-19 07:32:44'),
(41, 10, 'Investment Banker', '2024-01-19 07:32:52', '2024-01-19 07:32:52'),
(42, 10, 'Credit Manager', '2024-01-19 07:33:00', '2024-01-19 07:33:00'),
(43, 11, 'Front-End Developer', '2024-01-19 07:33:43', '2024-01-19 07:33:43'),
(44, 11, 'Back-End Developer', '2024-01-19 07:33:53', '2024-01-19 07:33:53'),
(45, 11, 'Full-Stack Developer', '2024-01-19 07:34:11', '2024-01-19 07:34:11'),
(46, 11, 'Mobile Developer', '2024-01-19 07:34:20', '2024-01-19 07:34:20'),
(47, 11, 'Game Developer', '2024-01-19 07:34:27', '2024-01-19 07:34:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userType` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USER',
  `profile_image_url` text COLLATE utf8mb4_unicode_ci,
  `profile_image_public_id` text COLLATE utf8mb4_unicode_ci,
  `resume_pdf_url` text COLLATE utf8mb4_unicode_ci,
  `resume_pdf_public_id` text COLLATE utf8mb4_unicode_ci,
  `contact` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('MALE','FEMALE','OTHER') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `headline` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `education` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `interest` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hobby` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` text COLLATE utf8mb4_unicode_ci,
  `experience` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD KEY `admins_name_email_id_index` (`name`,`email`,`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_email_unique` (`email`),
  ADD KEY `companies_name_email_id_index` (`name`,`email`,`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `job`
--
ALTER TABLE `job`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_queue_index` (`queue`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_keywords_id_index` (`keywords`,`id`),
  ADD KEY `jobs_company_id_foreign` (`company_id`),
  ADD KEY `jobs_sub_profile_id_foreign` (`sub_profile_id`);

--
-- Indexes for table `job_locations`
--
ALTER TABLE `job_locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `job_locations_jobs_id_locations_id_unique` (`jobs_id`,`locations_id`),
  ADD KEY `job_locations_locations_id_foreign` (`locations_id`),
  ADD KEY `job_locations_jobs_id_locations_id_index` (`jobs_id`,`locations_id`);

--
-- Indexes for table `job_qualifications`
--
ALTER TABLE `job_qualifications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `job_qualifications_jobs_id_qualifications_id_unique` (`jobs_id`,`qualifications_id`),
  ADD KEY `job_qualifications_qualifications_id_foreign` (`qualifications_id`),
  ADD KEY `job_qualifications_jobs_id_qualifications_id_index` (`jobs_id`,`qualifications_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `locations_city_index` (`city`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `profile_categories`
--
ALTER TABLE `profile_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profile_categories_name_id_index` (`name`,`id`);

--
-- Indexes for table `qualifications`
--
ALTER TABLE `qualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qualifications_name_id_index` (`name`,`id`);

--
-- Indexes for table `sub_profiles`
--
ALTER TABLE `sub_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_profiles_name_id_index` (`name`,`id`),
  ADD KEY `sub_profiles_profile_category_id_index` (`profile_category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_name_email_id_index` (`name`,`email`,`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job`
--
ALTER TABLE `job`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_locations`
--
ALTER TABLE `job_locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `job_qualifications`
--
ALTER TABLE `job_qualifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profile_categories`
--
ALTER TABLE `profile_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `qualifications`
--
ALTER TABLE `qualifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sub_profiles`
--
ALTER TABLE `sub_profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jobs_sub_profile_id_foreign` FOREIGN KEY (`sub_profile_id`) REFERENCES `sub_profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_locations`
--
ALTER TABLE `job_locations`
  ADD CONSTRAINT `job_locations_jobs_id_foreign` FOREIGN KEY (`jobs_id`) REFERENCES `jobs` (`id`),
  ADD CONSTRAINT `job_locations_locations_id_foreign` FOREIGN KEY (`locations_id`) REFERENCES `locations` (`id`);

--
-- Constraints for table `job_qualifications`
--
ALTER TABLE `job_qualifications`
  ADD CONSTRAINT `job_qualifications_jobs_id_foreign` FOREIGN KEY (`jobs_id`) REFERENCES `jobs` (`id`),
  ADD CONSTRAINT `job_qualifications_qualifications_id_foreign` FOREIGN KEY (`qualifications_id`) REFERENCES `qualifications` (`id`);

--
-- Constraints for table `sub_profiles`
--
ALTER TABLE `sub_profiles`
  ADD CONSTRAINT `sub_profiles_profile_category_id_foreign` FOREIGN KEY (`profile_category_id`) REFERENCES `profile_categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
