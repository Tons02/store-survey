-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 07, 2023 at 08:57 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store_survey`
--

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int UNSIGNED NOT NULL,
  `sync_id` int UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `sync_id`, `code`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 6, '230', 'Fresh Optionssssssss', 1, '2023-12-05 18:40:38', '2023-12-05 18:40:38'),
(2, 5, '31', 'Fresh Options', 1, '2023-12-05 18:40:38', '2023-12-05 18:43:14'),
(3, 4, '23', 'E-Pig Farms', 1, '2023-12-05 18:40:38', '2023-12-05 18:43:14'),
(4, 3, '22', 'Red Dragon Farm', 1, '2023-12-05 18:40:38', '2023-12-05 18:43:14'),
(5, 2, '21', 'Lodestar Feedmill and Veterinary Medicines', 1, '2023-12-05 18:40:38', '2023-12-05 18:43:14'),
(6, 1, '10', 'RDF Corporate Services', 1, '2023-12-05 18:40:38', '2023-12-05 18:43:14');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint UNSIGNED NOT NULL,
  `sync_id` int UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_sync_id` int UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `sync_id`, `code`, `name`, `company_sync_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 77, '7009', 'Business Development Management', 5, 0, '2023-12-05 18:40:49', '2023-12-05 18:40:49'),
(2, 33, '0810', 'General Accounting Servicessadasdsdasdsd', 1, 1, '2023-12-05 18:40:49', '2023-12-05 18:40:49'),
(3, 111, '2107', 'Feedmill QAQC', 2, 1, '2023-12-05 18:40:49', '2023-12-05 18:40:49'),
(4, 39, '2104', 'Feedmill RD', 5, 1, '2023-12-05 18:40:49', '2023-12-05 18:40:49'),
(5, 3923, '21043', 'Feedmill RD', 5, 1, '2023-12-05 18:40:49', '2023-12-05 18:40:49');

-- --------------------------------------------------------

--
-- Table structure for table `department_location`
--

CREATE TABLE `department_location` (
  `id` int UNSIGNED NOT NULL,
  `location_id` int UNSIGNED NOT NULL,
  `department_id` int UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `department_location`
--

INSERT INTO `department_location` (`id`, `location_id`, `department_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 83, 39, 1, NULL, NULL),
(2, 83, 111, 1, NULL, NULL),
(3, 177, 111, 0, NULL, NULL),
(4, 74, 39, 0, NULL, NULL),
(5, 33, 33, 1, NULL, NULL),
(6, 130, 77, 0, NULL, NULL),
(7, 129, 111, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int UNSIGNED NOT NULL,
  `sync_id` int UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `sync_id`, `code`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 83, '1244', 'FOX144 - San Miguel Uno', 1, '2023-12-05 18:41:02', '2023-12-05 18:41:02'),
(2, 177, '6069', 'FO69 - Panay', 0, '2023-12-05 18:41:02', '2023-12-05 18:41:02'),
(3, 74, '1226', 'FOX126 - Caritan Norte', 0, '2023-12-05 18:41:02', '2023-12-05 18:41:02'),
(4, 33, '1160', 'FOX60 - Molino (Salawag)', 1, '2023-12-05 18:41:02', '2023-12-05 18:41:02'),
(5, 130, '4105', 'Hydroponics - Magalang', 0, '2023-12-05 18:41:02', '2023-12-05 18:41:02'),
(6, 129, '4103', 'Hydroponics - Ayson', 0, '2023-12-05 18:41:02', '2023-12-05 18:41:02');

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
(1, '2023_11_13_024450_create_role_management_table', 1),
(2, '2023_11_22_052752_create_companies_table', 2),
(3, '2023_11_23_024425_create_department_table', 3),
(4, '2023_11_23_081159_create_locations_table', 4),
(5, '2023_11_24_024736_create_department_location_table', 5),
(6, '2014_10_12_000000_create_users_table', 6),
(7, '2019_12_14_000001_create_personal_access_tokens_table', 6),
(12, '2023_12_06_024728_create_store_engagement_forms_table', 7);

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

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 3, 'myapptoken', '3cf375a85ac73e889113df58d8e4eb7523dd2d01f225c954c919f87a96d98bb5', '[\"*\"]', '2023-12-06 01:06:45', NULL, '2023-12-05 19:06:02', '2023-12-06 01:06:45'),
(2, 'App\\Models\\User', 3, 'myapptoken', '17f204c5e5db14145ad858ce47a1082dba492dbf0ee534925603751cc4f49c5e', '[\"*\"]', '2023-12-07 00:51:56', NULL, '2023-12-06 21:04:05', '2023-12-07 00:51:56');

-- --------------------------------------------------------

--
-- Table structure for table `role_management`
--

CREATE TABLE `role_management` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_permission` json NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_management`
--

INSERT INTO `role_management` (`id`, `name`, `access_permission`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', '\"admin, Manager\"', 1, '2023-12-05 18:44:19', '2023-12-05 18:44:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `store_engagement_forms`
--

CREATE TABLE `store_engagement_forms` (
  `id` int UNSIGNED NOT NULL,
  `visit_number` bigint NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `leader` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `objectives` json NOT NULL,
  `strategies` json NOT NULL,
  `activities` json NOT NULL,
  `findings` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` json NOT NULL,
  `e_signature` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_update` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_engagement_forms`
--

INSERT INTO `store_engagement_forms` (`id`, `visit_number`, `name`, `contact`, `store_name`, `leader`, `date`, `objectives`, `strategies`, `activities`, `findings`, `notes`, `e_signature`, `is_update`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(19, 1, 'Antonios', '0987654321', 'Fresh Option', 'Boss Vince', '06-12-2023', '\"admin, Manager\"', '\"Magdagdag ng mga foods, add employee\"', '\"[{\'agreed\':\'agreed\',\'timing\':\'timing\',\'responsible\':\'responsible\',\'status\':\'\',\'rate\':\'\'}, {\'agreed\':\'agreed\',\'timing\':\'timing\',\'responsible\':\'responsible\',\'status\':\'\',\'rate\':\'\'}]\"', 'Effective naman, Pwde na', '\"Tapusin Agad to, Di naging effective\"', 'C:\\laragon\\www\\store-survey\\public\\signature\\sampleimage_1701926879.png', 0, 1, '2023-12-06 21:27:59', '2023-12-06 21:27:59', NULL),
(20, 1, 'Antonios', '0987654321', 'Fresh Option', 'Boss Vince', '06-12-2023', '\"admin, Manager\"', '\"Magdagdag ng mga foods, add employee\"', '\"[{\'agreed\':\'agreed\',\'timing\':\'timing\',\'responsible\':\'responsible\',\'status\':\'status\',\'rate\':\'rate\'}, {\'agreed\':\'agreed\',\'timing\':\'timing\',\'responsible\':\'responsible\',\'status\':\'status\',\'rate\':\'rate\'}]\"', 'Effective naman, Pwde na, Nice Move', '\"Tapusin Agad to, Di naging effective, Nice nice\"', 'C:\\laragon\\www\\store-survey\\public\\signature\\sampleimage_1701937286.png', 1, 1, '2023-12-06 21:28:01', '2023-12-07 00:21:26', NULL),
(21, 2, 'Antonios', '0987654321', 'Fresh Option', 'Boss Vince', '06-12-2023', '\"admin, Manager\"', '\"Magdagdag ng mga foods, add employee\"', '\"[{\'agreed\':\'agreed\',\'timing\':\'timing\',\'responsible\':\'responsible\',\'status\':\'\',\'rate\':\'\'}, {\'agreed\':\'agreed\',\'timing\':\'timing\',\'responsible\':\'responsible\',\'status\':\'\',\'rate\':\'\'}]\"', 'Effective naman, Pwde na', '\"Tapusin Agad to, Di naging effective\"', 'C:\\laragon\\www\\store-survey\\public\\signature\\sampleimage_1701927849.png', 0, 1, '2023-12-06 21:44:09', '2023-12-06 21:44:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `id_prefix` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_id` int UNSIGNED NOT NULL,
  `department_id` int UNSIGNED NOT NULL,
  `company_id` int UNSIGNED NOT NULL,
  `role_id` int UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `id_prefix`, `id_no`, `first_name`, `middle_name`, `last_name`, `sex`, `username`, `password`, `location_id`, `department_id`, `company_id`, `role_id`, `is_active`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, '1', '1', 'Antonio', 'De Ala', 'Montilla', 'male', 'tons', '$2y$12$sPIa0zP05JpMx4FhkzjPVO1DZD6U.RBWU.OyvaRdCiY9J6e7Uv9mu', 83, 77, 5, 1, 1, NULL, '2023-12-05 18:44:26', '2023-12-05 18:44:26', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_sync_id_unique` (`sync_id`),
  ADD KEY `companies_code_index` (`code`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_sync_id_unique` (`sync_id`),
  ADD KEY `departments_code_index` (`code`),
  ADD KEY `departments_company_sync_id_index` (`company_sync_id`);

--
-- Indexes for table `department_location`
--
ALTER TABLE `department_location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_location_location_id_foreign` (`location_id`),
  ADD KEY `department_location_department_id_foreign` (`department_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `locations_sync_id_unique` (`sync_id`),
  ADD KEY `locations_code_index` (`code`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `role_management`
--
ALTER TABLE `role_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_engagement_forms`
--
ALTER TABLE `store_engagement_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_location_id_foreign` (`location_id`),
  ADD KEY `users_department_id_foreign` (`department_id`),
  ADD KEY `users_company_id_foreign` (`company_id`),
  ADD KEY `users_role_id_index` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `department_location`
--
ALTER TABLE `department_location`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role_management`
--
ALTER TABLE `role_management`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `store_engagement_forms`
--
ALTER TABLE `store_engagement_forms`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_company_sync_id_foreign` FOREIGN KEY (`company_sync_id`) REFERENCES `companies` (`sync_id`) ON DELETE CASCADE;

--
-- Constraints for table `department_location`
--
ALTER TABLE `department_location`
  ADD CONSTRAINT `department_location_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`sync_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `department_location_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`sync_id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`sync_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`sync_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`sync_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `role_management` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
