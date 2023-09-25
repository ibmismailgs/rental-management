-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 25, 2023 at 10:18 AM
-- Server version: 5.7.33
-- PHP Version: 8.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rental_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active | 0 = Inactive',
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `bank_name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'AB Bank Limited', 1, 1, NULL, '2023-01-25 04:18:31', '2023-01-25 04:18:31', NULL),
(2, 'Agrani Bank Limited', 1, 1, NULL, '2023-01-25 04:18:31', '2023-01-25 04:18:31', NULL),
(3, 'Al-Arafah Islami Bank Limited', 1, 1, NULL, '2023-01-25 04:18:31', '2023-01-25 04:18:31', NULL),
(4, 'Bangladesh Commerce Bank Limited', 1, 1, NULL, '2023-01-25 04:18:31', '2023-01-25 04:18:31', NULL),
(5, 'Bangladesh Development Bank Limited', 1, 1, NULL, '2023-01-25 04:18:31', '2023-01-25 04:18:31', NULL),
(6, 'Bangladesh Krishi Bank', 1, 1, NULL, '2023-01-25 04:18:31', '2023-01-25 04:18:31', NULL),
(7, 'Bank Al-Falah Limited', 1, 1, NULL, '2023-01-25 04:18:31', '2023-01-25 04:18:31', NULL),
(8, 'Bank Asia Limited', 1, 1, NULL, '2023-01-25 04:18:31', '2023-01-25 04:18:31', NULL),
(9, 'BASIC Bank Limited', 1, 1, NULL, '2023-01-25 04:18:31', '2023-01-25 04:18:31', NULL),
(10, 'BRAC Bank Limited', 1, 1, NULL, '2023-01-25 04:18:31', '2023-01-25 04:18:31', NULL),
(11, 'Commercial Bank of Ceylon Limited', 1, 1, NULL, '2023-01-25 04:18:31', '2023-01-25 04:18:31', NULL),
(12, 'Community Bank Bangladesh Limited', 1, 1, NULL, '2023-01-25 04:18:31', '2023-01-25 04:18:31', NULL),
(13, 'Dhaka Bank Limited', 1, 1, NULL, '2023-01-25 04:18:31', '2023-01-25 04:18:31', NULL),
(14, 'Dutch-Bangla Bank Limited', 1, 1, NULL, '2023-01-25 04:18:31', '2023-01-25 04:18:31', NULL),
(15, 'Eastern Bank Limited', 1, 1, NULL, '2023-01-25 04:18:31', '2023-01-25 04:18:31', NULL),
(16, 'EXIM Bank Limited', 1, 1, NULL, '2023-01-25 04:18:31', '2023-01-25 04:18:31', NULL),
(17, 'First Security Islami Bank Limited', 1, 1, NULL, '2023-01-25 04:18:31', '2023-01-25 04:18:31', NULL),
(18, 'Habib Bank Ltd.', 1, 1, NULL, '2023-01-25 04:18:31', '2023-01-25 04:18:31', NULL),
(19, 'ICB Islamic Bank Ltd.', 1, 1, NULL, '2023-01-25 04:18:31', '2023-01-25 04:18:31', NULL),
(20, 'IFIC Bank Limited', 1, 1, NULL, '2023-01-25 04:18:31', '2023-01-25 04:18:31', NULL),
(21, 'Islami Bank Bangladesh Ltd.', 1, 1, NULL, '2023-01-25 04:18:31', '2023-01-25 04:18:31', NULL),
(22, 'Jamuna Bank Ltd.', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(23, 'Janata Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(24, 'Meghna Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(25, 'Mercantile Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(26, 'Midland Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(27, 'Modhumoti Bank Ltd.', 1, NULL, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(28, 'Mutual Trust Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(29, 'National Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(30, 'National Bank of Pakistan', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(31, 'National Credit & Commerce Bank Ltd', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(32, 'NRB Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(33, 'NRB Commercial Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(34, 'NRB Global Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(35, 'One Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(36, 'Padma Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(37, 'Palli Sanchay Bank', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(38, 'Premier Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(39, 'Prime Bank Ltd.', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(40, 'Probashi Kollyan Bank', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(41, 'Pubali Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(42, 'Rajshahi Krishi Unnayan Bank', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(43, 'Rupali Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(44, 'Shahjalal Islami Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(45, 'Shimanto Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(46, 'Social Islami Bank Ltd.', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(47, 'Sonali Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(48, 'South Bangla Agriculture & Commerce Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(49, 'Southeast Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(50, 'Standard Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(51, 'Standard Chartered Bank', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(52, 'The City Bank Ltd.', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(53, 'Trust Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(54, 'Union Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(55, 'United Commercial Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL),
(56, 'Uttara Bank Limited', 1, 1, NULL, '2023-01-25 04:18:32', '2023-01-25 04:18:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_id` int(10) UNSIGNED NOT NULL,
  `owner_info_id` int(10) UNSIGNED NOT NULL,
  `account_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active | 0 = Inactive',
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deeds`
--

CREATE TABLE `deeds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tenant_photo` text COLLATE utf8mb4_unicode_ci,
  `owner_info_id` int(10) UNSIGNED NOT NULL,
  `flat_info_id` int(10) UNSIGNED NOT NULL,
  `tenant_info_id` int(10) UNSIGNED NOT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thana` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holding` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `road` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `father_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthdate` date NOT NULL,
  `merital_status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1 = Married | 2 = Unmarried',
  `religion` tinyint(4) NOT NULL COMMENT '1 = Islam | 2 = Hindu | 3 = Buddhist | 4 = Christian | 5 = Others',
  `profession` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `professional_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `qualification` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tenant_nid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tenant_mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passport` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `relation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_name` json DEFAULT NULL,
  `member_age` json DEFAULT NULL,
  `member_profession` json DEFAULT NULL,
  `member_mobile` json DEFAULT NULL,
  `made_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `made_nid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `made_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `made_address` text COLLATE utf8mb4_unicode_ci,
  `driver_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_nid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_address` text COLLATE utf8mb4_unicode_ci,
  `previous_owner_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `previous_owner_nid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `previous_owner_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `previous_owner_address` text COLLATE utf8mb4_unicode_ci,
  `leave_reason` text COLLATE utf8mb4_unicode_ci,
  `present_owner_nid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issue_date` date NOT NULL,
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deeds`
--

INSERT INTO `deeds` (`id`, `tenant_photo`, `owner_info_id`, `flat_info_id`, `tenant_info_id`, `district`, `thana`, `holding`, `road`, `post_code`, `father_name`, `birthdate`, `merital_status`, `religion`, `profession`, `professional_address`, `qualification`, `tenant_nid`, `tenant_mobile`, `passport`, `emergency_name`, `relation`, `emergency_mobile`, `emergency_address`, `member_name`, `member_age`, `member_profession`, `member_mobile`, `made_name`, `made_nid`, `made_mobile`, `made_address`, `driver_name`, `driver_nid`, `driver_mobile`, `driver_address`, `previous_owner_name`, `previous_owner_nid`, `previous_owner_mobile`, `previous_owner_address`, `leave_reason`, `present_owner_nid`, `issue_date`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1674473185flat.jpg', 1, 1, 1, 'Consectetur rem dele', 'Sed dolorem quod qui', 'Quae iure ea dolor c', 'Aute blanditiis in e', 'Reprehenderit odit', 'Alea Powell', '1987-03-18', 1, 1, 'Culpa aut ut sed vo', 'Culpa enim quo quia', 'Voluptatibus ut dolo', '123456789', '', 'Blanditiis itaque ne', 'Wynne Allen', 'Ut exercitation veni', 'Tenetur aliquid ipsu', 'Quis porro incididun', '[\"Hope Ferrell\"]', '[\"Officiis quis sunt\"]', '[\"Eum reprehenderit v\"]', '[\"Ipsum eiusmod repre\"]', 'Bree Rollins', '47', 'Eius eiusmod commodi', 'Eligendi nostrud fug', 'Kaitlin Hebert', '46', 'Quia at vitae omnis', 'Eligendi assumenda l', 'Emery Olson', '76', 'Blanditiis adipisci', 'Tempora fugiat est i', 'Ad officia minus sin', 'ismail@gmail.com', '1999-09-04', 1, NULL, '2023-01-23 05:26:25', '2023-01-23 05:26:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active | 0 = Inactive',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_categories`
--

INSERT INTO `expense_categories` (`id`, `category_name`, `status`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Gas Bill', 1, NULL, 1, NULL, NULL, NULL, NULL),
(2, 'Water Bill', 1, NULL, 1, NULL, NULL, NULL, NULL),
(3, 'Electricity Bill', 1, NULL, 1, NULL, NULL, NULL, NULL),
(4, 'Service Charge', 1, NULL, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flat_infos`
--

CREATE TABLE `flat_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_info_id` int(10) UNSIGNED NOT NULL,
  `flat_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flat_size` double NOT NULL,
  `bedroom` tinyint(4) NOT NULL,
  `daining_space` tinyint(4) DEFAULT NULL,
  `bathroom` tinyint(4) NOT NULL,
  `master_bedroom` tinyint(4) NOT NULL,
  `guest_bedroom` tinyint(4) NOT NULL,
  `balcony` tinyint(4) NOT NULL,
  `flat_photo` text COLLATE utf8mb4_unicode_ci,
  `rent_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1 = Rented | 0 = Not Rented',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = On | 0 = Off',
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `favicon` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `map` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `installments`
--

CREATE TABLE `installments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rent_info_id` int(10) UNSIGNED NOT NULL,
  `rental_month` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `transaction_purpose` tinyint(4) DEFAULT NULL COMMENT '1 = Rent Collect | 2 = Due Collect',
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1409, '2023_01_17_091406_create_deeds_table', 1),
(1410, '2014_10_12_000000_create_users_table', 2),
(1411, '2014_10_12_100000_create_password_resets_table', 2),
(1412, '2016_06_01_000001_create_oauth_auth_codes_table', 2),
(1413, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
(1414, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
(1415, '2016_06_01_000004_create_oauth_clients_table', 2),
(1416, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2),
(1417, '2019_08_19_000000_create_failed_jobs_table', 2),
(1418, '2020_03_09_135529_create_permission_tables', 2),
(1419, '2022_12_01_090241_create_owner_infos_table', 2),
(1420, '2022_12_01_090255_create_flat_infos_table', 2),
(1421, '2022_12_01_090314_create_tenant_infos_table', 2),
(1422, '2022_12_07_035834_create_rent_infos_table', 2),
(1423, '2022_12_12_095719_create_mobile_bankings_table', 2),
(1424, '2022_12_12_095731_create_mobile_banking_accounts_table', 2),
(1425, '2022_12_12_151252_create_banks_table', 2),
(1426, '2022_12_12_151309_create_bank_accounts_table', 2),
(1427, '2022_12_13_074943_create_transactions_table', 2),
(1428, '2022_12_14_050001_create_installments_table', 2),
(1429, '2022_12_17_035323_create_expense_categories_table', 2),
(1430, '2023_01_15_113330_create_general_settings_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `mobile_bankings`
--

CREATE TABLE `mobile_bankings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active | 0 = Inactive',
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mobile_bankings`
--

INSERT INTO `mobile_bankings` (`id`, `name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Bkash', 1, 1, NULL, NULL, NULL, NULL),
(2, 'Nagad', 1, 1, NULL, NULL, NULL, NULL),
(3, 'Rocket', 1, 1, NULL, NULL, NULL, NULL),
(4, 'MCash', 1, 1, NULL, NULL, NULL, NULL),
(5, 'SureCash', 1, 1, NULL, NULL, NULL, NULL),
(6, 'Upay', 1, 1, NULL, NULL, NULL, NULL),
(7, 'T-Cash', 1, 1, NULL, NULL, NULL, NULL),
(8, 'Ok Wallet', 1, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mobile_banking_accounts`
--

CREATE TABLE `mobile_banking_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mobile_banking_id` int(10) UNSIGNED NOT NULL,
  `owner_info_id` int(10) UNSIGNED NOT NULL,
  `mobile_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Active | 0 = Inactive',
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 4);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owner_infos`
--

CREATE TABLE `owner_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `owner_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` tinyint(4) NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `owner_photo` text COLLATE utf8mb4_unicode_ci,
  `card_name` json DEFAULT NULL,
  `card_no` json DEFAULT NULL,
  `card_photo` json DEFAULT NULL,
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'manage_roles', 'web', NULL, NULL, NULL),
(2, 'manage_permission', 'web', NULL, NULL, NULL),
(3, 'manage_user', 'web', NULL, NULL, NULL),
(4, 'manage_owner', 'web', NULL, NULL, NULL),
(5, 'manage_flat', 'web', NULL, NULL, NULL),
(6, 'manage_tenant', 'web', NULL, NULL, NULL),
(7, 'manage_rent', 'web', NULL, NULL, NULL),
(8, 'manage_rent_collect', 'web', NULL, NULL, NULL),
(9, 'manage_due_collect', 'web', NULL, NULL, NULL),
(10, 'manage_mobile_banking', 'web', NULL, NULL, NULL),
(11, 'manage_mobile_banking_account', 'web', NULL, NULL, NULL),
(12, 'manage_bank', 'web', NULL, NULL, NULL),
(13, 'manage_bank_account', 'web', NULL, NULL, NULL),
(14, 'manage_expense_category', 'web', NULL, NULL, NULL),
(15, 'manage_expense', 'web', NULL, NULL, NULL),
(16, 'manage_revenue', 'web', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rent_infos`
--

CREATE TABLE `rent_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_info_id` int(10) UNSIGNED NOT NULL,
  `flat_info_id` int(10) UNSIGNED NOT NULL,
  `tenant_info_id` int(10) UNSIGNED NOT NULL,
  `rent_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flat_rent` double NOT NULL,
  `gas_bill` double NOT NULL,
  `water_bill` double NOT NULL,
  `service_charge` double NOT NULL,
  `total_rent` double NOT NULL,
  `tenant_photo` text COLLATE utf8mb4_unicode_ci,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thana` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holding` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `road` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `father_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthdate` date NOT NULL,
  `merital_status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1 = Married | 2 = Unmarried',
  `religion` tinyint(4) NOT NULL COMMENT '1 = Islam | 2 = Hindu | 3 = Buddhist | 4 = Christian | 5 = Others',
  `profession` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `professional_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `qualification` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tenant_nid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tenant_mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passport` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `relation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_name` json DEFAULT NULL,
  `member_age` json DEFAULT NULL,
  `member_profession` json DEFAULT NULL,
  `member_mobile` json DEFAULT NULL,
  `made_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `made_nid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `made_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `made_address` text COLLATE utf8mb4_unicode_ci,
  `driver_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_nid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_address` text COLLATE utf8mb4_unicode_ci,
  `previous_owner_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `previous_owner_nid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `previous_owner_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `previous_owner_address` text COLLATE utf8mb4_unicode_ci,
  `leave_reason` text COLLATE utf8mb4_unicode_ci,
  `present_owner_nid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issue_date` date NOT NULL,
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super Admin', 'web', NULL, NULL, NULL),
(2, 'Owner', 'web', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tenant_infos`
--

CREATE TABLE `tenant_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_info_id` int(10) UNSIGNED NOT NULL,
  `tenant_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `family_member` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` tinyint(4) NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `tenant_photo` text COLLATE utf8mb4_unicode_ci,
  `card_name` json DEFAULT NULL,
  `card_no` json DEFAULT NULL,
  `card_photo` json DEFAULT NULL,
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_info_id` int(10) UNSIGNED DEFAULT NULL,
  `flat_info_id` int(10) UNSIGNED DEFAULT NULL,
  `tenant_info_id` int(10) UNSIGNED DEFAULT NULL,
  `rent_info_id` int(10) UNSIGNED DEFAULT NULL,
  `account_id` int(10) UNSIGNED DEFAULT NULL,
  `mobile_banking_id` int(10) UNSIGNED DEFAULT NULL,
  `expense_category_id` json DEFAULT NULL,
  `rental_month` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_purpose` tinyint(4) DEFAULT NULL COMMENT '1 = Rent Collect | 2 = Due Collect | 3 = Expense',
  `payment_method` tinyint(4) DEFAULT NULL COMMENT '1 = Cash, 2 = Bank Account | 3 = Mobile Banking',
  `amount` json NOT NULL,
  `date` date DEFAULT NULL,
  `mobile_transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `type`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super Admin', 'admin@test.com', 1, NULL, '$2y$10$64EW2rOLncX4.tFlHTpz8uo.u4GuKZvHCO5UFPU63ykd3GIxjKQ1S', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_accounts_bank_id_index` (`bank_id`),
  ADD KEY `bank_accounts_owner_info_id_index` (`owner_info_id`);

--
-- Indexes for table `deeds`
--
ALTER TABLE `deeds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deeds_owner_info_id_index` (`owner_info_id`),
  ADD KEY `deeds_flat_info_id_index` (`flat_info_id`),
  ADD KEY `deeds_tenant_info_id_index` (`tenant_info_id`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flat_infos`
--
ALTER TABLE `flat_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flat_infos_owner_info_id_index` (`owner_info_id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `installments`
--
ALTER TABLE `installments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `installments_rent_info_id_index` (`rent_info_id`),
  ADD KEY `installments_rental_month_index` (`rental_month`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mobile_bankings`
--
ALTER TABLE `mobile_bankings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mobile_banking_accounts`
--
ALTER TABLE `mobile_banking_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mobile_banking_accounts_mobile_banking_id_index` (`mobile_banking_id`),
  ADD KEY `mobile_banking_accounts_owner_info_id_index` (`owner_info_id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owner_infos`
--
ALTER TABLE `owner_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_infos_user_id_index` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rent_infos`
--
ALTER TABLE `rent_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rent_infos_owner_info_id_index` (`owner_info_id`),
  ADD KEY `rent_infos_flat_info_id_index` (`flat_info_id`),
  ADD KEY `rent_infos_tenant_info_id_index` (`tenant_info_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `tenant_infos`
--
ALTER TABLE `tenant_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_infos_owner_info_id_index` (`owner_info_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_owner_info_id_index` (`owner_info_id`),
  ADD KEY `transactions_flat_info_id_index` (`flat_info_id`),
  ADD KEY `transactions_tenant_info_id_index` (`tenant_info_id`),
  ADD KEY `transactions_rent_info_id_index` (`rent_info_id`),
  ADD KEY `transactions_account_id_index` (`account_id`),
  ADD KEY `transactions_mobile_banking_id_index` (`mobile_banking_id`),
  ADD KEY `transactions_rental_month_index` (`rental_month`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deeds`
--
ALTER TABLE `deeds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flat_infos`
--
ALTER TABLE `flat_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `installments`
--
ALTER TABLE `installments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1431;

--
-- AUTO_INCREMENT for table `mobile_bankings`
--
ALTER TABLE `mobile_bankings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mobile_banking_accounts`
--
ALTER TABLE `mobile_banking_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owner_infos`
--
ALTER TABLE `owner_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `rent_infos`
--
ALTER TABLE `rent_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tenant_infos`
--
ALTER TABLE `tenant_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
