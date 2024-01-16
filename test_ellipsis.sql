-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2024 at 07:26 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_ellipsis`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reference_no` varchar(500) NOT NULL,
  `invoice_date` date NOT NULL,
  `invoice_amount` decimal(38,2) NOT NULL,
  `invoice_tax` decimal(38,2) NOT NULL,
  `due_amount` decimal(38,2) NOT NULL,
  `address` text NOT NULL,
  `status` int(200) NOT NULL,
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(200) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_name` int(11) NOT NULL,
  `price` decimal(38,2) NOT NULL,
  `quantity` decimal(38,2) NOT NULL,
  `total_cost` decimal(38,2) NOT NULL,
  `order_no` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_payments`
--

CREATE TABLE `order_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `trans_id` varchar(255) NOT NULL,
  `amount` decimal(38,2) NOT NULL,
  `date` date NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('admin@gmail.com', '$2y$10$uylObk2i3.fnDjnvALLYhe6ySDOQNyzsKhdEF2kTBoQCD0jztkT0y', '2021-12-11 15:40:32');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(200) NOT NULL,
  `payment_id` varchar(500) NOT NULL,
  `payer_id` varchar(500) NOT NULL,
  `payer_email` varchar(500) NOT NULL,
  `amount` decimal(38,2) NOT NULL,
  `currency` varchar(200) NOT NULL,
  `payment_status` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methodes`
--

CREATE TABLE `payment_methodes` (
  `id` int(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_methodes`
--

INSERT INTO `payment_methodes` (`id`, `name`, `description`) VALUES
(1, 'Mobile Money', NULL),
(2, 'Cash', NULL),
(3, 'Bank', NULL),
(4, 'Cheque', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `name` int(100) DEFAULT NULL,
  `sys_module_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `slug`, `name`, `sys_module_id`, `created_at`, `updated_at`) VALUES
(1, 'view-dashboard', NULL, 1, '2022-06-25 20:29:13', '2023-07-03 10:42:43'),
(2, 'view-roles', NULL, 2, '2022-06-25 20:29:21', '2023-07-03 10:42:43'),
(3, 'view-permission', NULL, 2, '2022-06-25 20:29:21', '2023-07-03 10:42:43'),
(4, 'view-orders', NULL, 3, '2023-07-03 10:36:20', '2023-07-03 10:42:43'),
(5, 'view-product', NULL, 4, '2024-01-15 11:50:44', '2024-01-15 11:50:44');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(500) NOT NULL,
  `category_id` int(100) DEFAULT NULL,
  `price` decimal(38,2) DEFAULT 0.00,
  `img` varchar(500) DEFAULT NULL,
  `quantity` decimal(38,2) DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `disabled` int(200) DEFAULT 0,
  `added_by` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `price`, `img`, `quantity`, `description`, `disabled`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Black Shirt', 1, '6500.00', '639200723045408_1705325077.png', '0.00', 'black shirt', 0, '1', '2024-01-15 10:06:06', '2024-01-15 19:28:54'),
(2, 'Shorts', 1, '25000.00', 'download_1705326013.jpeg', '0.00', 'black shorts with 2 pockets', 0, '1', '2024-01-15 10:40:13', '2024-01-15 19:34:09');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(200) NOT NULL,
  `name` varchar(500) NOT NULL,
  `description` longtext NOT NULL,
  `added_by` int(200) NOT NULL,
  `disabled` int(200) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `name`, `description`, `added_by`, `disabled`, `created_at`, `updated_at`) VALUES
(1, 'Clothes', 'Clothes', 1, 0, '2024-01-15 10:36:49', '2024-01-15 10:36:49');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `added_by` int(100) DEFAULT NULL,
  `status` int(100) DEFAULT NULL,
  `price` int(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `slug`, `added_by`, `status`, `price`, `created_at`, `updated_at`) VALUES
(1, 'superAdmin', 1, 0, NULL, '2021-12-04 17:17:50', '2021-12-04 17:17:50'),
(2, 'Order', 1, 0, NULL, '2023-07-03 10:37:46', '2023-07-03 10:37:46');

-- --------------------------------------------------------

--
-- Table structure for table `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 1),
(2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `logo` text NOT NULL,
  `favicon` text NOT NULL,
  `counter_bg` text NOT NULL,
  `login_bg` text NOT NULL,
  `footer_copyright` text NOT NULL,
  `footer_address` text NOT NULL,
  `footer_phone` text NOT NULL,
  `footer_working_hour` text NOT NULL,
  `footer_address_icon` text NOT NULL,
  `footer_phone_icon` text NOT NULL,
  `footer_working_hour_icon` text NOT NULL,
  `footer_about` text NOT NULL,
  `top_bar_email` text NOT NULL,
  `top_bar_phone` text NOT NULL,
  `contact_map_iframe` text NOT NULL,
  `total_recent_post` int(11) NOT NULL,
  `total_popular_post` int(11) NOT NULL,
  `total_recent_post_footer` int(11) NOT NULL,
  `total_popular_post_footer` int(11) NOT NULL,
  `total_recent_post_home` int(11) NOT NULL,
  `theme_color_1` text NOT NULL,
  `theme_color_2` text NOT NULL,
  `counter1_text` text NOT NULL,
  `counter1_value` int(11) NOT NULL,
  `counter2_text` text NOT NULL,
  `counter2_value` int(11) NOT NULL,
  `counter3_text` text NOT NULL,
  `counter3_value` int(11) NOT NULL,
  `counter4_text` text NOT NULL,
  `counter4_value` int(11) NOT NULL,
  `counter_status` int(11) NOT NULL,
  `banner_about` text NOT NULL,
  `banner_faq` text NOT NULL,
  `banner_gallery` text NOT NULL,
  `banner_service` text NOT NULL,
  `banner_portfolio` text NOT NULL,
  `banner_testimonial` text NOT NULL,
  `banner_news` text NOT NULL,
  `banner_contact` text NOT NULL,
  `banner_search` text NOT NULL,
  `banner_category` text NOT NULL,
  `banner_terms` text NOT NULL,
  `banner_privacy` text NOT NULL,
  `banner_dynamic_page` text NOT NULL,
  `why_choose_title` text NOT NULL,
  `why_choose_subtitle` text DEFAULT NULL,
  `why_choose_status` int(11) NOT NULL,
  `service_title` text NOT NULL,
  `service_subtitle` text DEFAULT NULL,
  `service_status` int(11) NOT NULL,
  `portfolio_title` text NOT NULL,
  `portfolio_subtitle` text DEFAULT NULL,
  `portfolio_status` int(11) NOT NULL,
  `team_title` text NOT NULL,
  `team_subtitle` text DEFAULT NULL,
  `team_status` int(11) NOT NULL,
  `testimonial_title` text NOT NULL,
  `testimonial_subtitle` text DEFAULT NULL,
  `testimonial_status` int(11) NOT NULL,
  `faq_title` text NOT NULL,
  `faq_subtitle` text DEFAULT NULL,
  `faq_status` int(11) NOT NULL,
  `gallery_title` text NOT NULL,
  `gallery_subtitle` text DEFAULT NULL,
  `gallery_status` int(11) NOT NULL,
  `recent_post_title` text NOT NULL,
  `recent_post_subtitle` text DEFAULT NULL,
  `recent_post_status` int(11) NOT NULL,
  `partner_title` text NOT NULL,
  `partner_subtitle` text DEFAULT NULL,
  `partner_status` int(11) NOT NULL,
  `preloader_photo` text NOT NULL,
  `preloader_status` int(11) NOT NULL,
  `faq_main_photo` text NOT NULL,
  `testimonial_main_photo` text NOT NULL,
  `why_choose_main_photo` text NOT NULL,
  `why_choose_item_bg` text NOT NULL,
  `tawk_live_chat_code` text NOT NULL,
  `tawk_live_chat_status` int(11) NOT NULL,
  `google_recaptcha_site_key` text NOT NULL,
  `google_recaptcha_status` int(11) NOT NULL,
  `layout_direction` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `logo`, `favicon`, `counter_bg`, `login_bg`, `footer_copyright`, `footer_address`, `footer_phone`, `footer_working_hour`, `footer_address_icon`, `footer_phone_icon`, `footer_working_hour_icon`, `footer_about`, `top_bar_email`, `top_bar_phone`, `contact_map_iframe`, `total_recent_post`, `total_popular_post`, `total_recent_post_footer`, `total_popular_post_footer`, `total_recent_post_home`, `theme_color_1`, `theme_color_2`, `counter1_text`, `counter1_value`, `counter2_text`, `counter2_value`, `counter3_text`, `counter3_value`, `counter4_text`, `counter4_value`, `counter_status`, `banner_about`, `banner_faq`, `banner_gallery`, `banner_service`, `banner_portfolio`, `banner_testimonial`, `banner_news`, `banner_contact`, `banner_search`, `banner_category`, `banner_terms`, `banner_privacy`, `banner_dynamic_page`, `why_choose_title`, `why_choose_subtitle`, `why_choose_status`, `service_title`, `service_subtitle`, `service_status`, `portfolio_title`, `portfolio_subtitle`, `portfolio_status`, `team_title`, `team_subtitle`, `team_status`, `testimonial_title`, `testimonial_subtitle`, `testimonial_status`, `faq_title`, `faq_subtitle`, `faq_status`, `gallery_title`, `gallery_subtitle`, `gallery_status`, `recent_post_title`, `recent_post_subtitle`, `recent_post_status`, `partner_title`, `partner_subtitle`, `partner_status`, `preloader_photo`, `preloader_status`, `faq_main_photo`, `testimonial_main_photo`, `why_choose_main_photo`, `why_choose_item_bg`, `tawk_live_chat_code`, `tawk_live_chat_status`, `google_recaptcha_site_key`, `google_recaptcha_status`, `layout_direction`, `created_at`, `updated_at`) VALUES
(1, 'logo.jpeg', 'favicon.jpeg', 'counter_bg.jpg', 'login_bg.jpg', 'Copyright 2022.  SEGAX GROUP LOGISTICS. All Rights Reserved.', 'Dar es salaam, Tanzania.', '+255654074306/+255753682001', 'Monday-Friday (9:00 AM - 5:00 PM)\r\nSaturday and Sunday: Off', 'footer_address_icon.png', 'footer_phone_icon.png', 'footer_working_hour_icon.png', 'Segax Group Logistics', 'express@segaxgroup.co.tz', '+255654074306/+255753682001', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387142.84040262736!2d-74.25819605476612!3d40.70583158628177!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew+York%2C+NY%2C+USA!5e0!3m2!1sen!2sbd!4v1485712851643\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', 4, 4, 3, 4, 6, '0E2EBF', 'CBD8F1', 'Stock', 3000, 'Loyal Customers', 50, 'Distributors', 10, 'Suppliers', 10, 2, 'banner_about.jpg', 'banner_faq.jpg', 'banner_gallery.jpg', 'banner_service.jpg', 'banner_portfolio.jpg', 'banner_testimonial.jpg', 'banner_news.jpg', 'banner_contact.jpg', 'banner_search.jpg', 'banner_category.jpg', 'banner_terms.jpg', 'banner_privacy.jpg', 'banner_dynamic_page.jpg', 'Why choose our logistics service?', NULL, 1, 'OUR SERVICES', NULL, 1, 'TRUSTED BY LEADING BRANDS', 'Being trusted by fastest-growing and most admired brands in Tanzania from various sectors. To say the least 90+ companies. These companies can\'t all be wrong about us. We urge you to test us, we will surprise you!!', 1, 'EXPERIENCED TEAM0', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit Deserunt libero voluptate', 2, 'WHAT OUR CLIENTS SAY', 'This is what our lovely clients say', 2, 'Have Some Questions?', NULL, 2, 'PHOTO GALLERY', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit Deserunt libero voluptate', 2, 'Latest News, Events, Competitions and Jobs', NULL, 2, 'MORE OF OUR PRODUCTS', NULL, 2, 'preloader_photo.gif', 2, 'faq_main_photo.jpg', 'testimonial_main_photo.png', 'why_choose_main_photo.jpg', 'why_choose_item_bg.jpg', '<script type=\"text/javascript\">\r\n    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n    (function(){\r\n        var s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\r\n        s1.async=true;\r\n        s1.src=\'https://embed.tawk.to/5a7c31ded7591465c7077c48/default\';\r\n        s1.charset=\'UTF-8\';\r\n        s1.setAttribute(\'crossorigin\',\'*\');\r\n        s0.parentNode.insertBefore(s1,s0);\r\n    })();\r\n</script>', 1, '6Lcf1V0bAAAAAIN5nY_O2MXq0hUuTiKTt_XOYM-_', 1, 'Left to Right (LTR)', NULL, '2022-10-12 20:49:38');

-- --------------------------------------------------------

--
-- Table structure for table `system_control`
--

CREATE TABLE `system_control` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `picture` varchar(500) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tin` varchar(100) DEFAULT NULL,
  `vat` varchar(100) DEFAULT NULL,
  `added_by` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `system_control`
--

INSERT INTO `system_control` (`id`, `name`, `picture`, `address`, `phone`, `email`, `tin`, `vat`, `added_by`) VALUES
(20, 'TEST ELLIPSIS', '876060323033135.PNG', 'DAR ES SALAAM', '+255713000000', 'info@test.co.tz', '152132432', '-', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sys_modules`
--

CREATE TABLE `sys_modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sys_modules`
--

INSERT INTO `sys_modules` (`id`, `slug`, `created_at`, `updated_at`, `deleted_at`, `name`) VALUES
(1, 'manage-dashboard', '2022-06-25 19:55:43', '2022-06-25 19:55:43', NULL, 'Dashboard'),
(2, 'manage-access-control', '2022-06-25 19:55:44', '2022-06-25 19:55:44', NULL, 'Access Control'),
(3, 'manage-orders', '2024-01-15 11:52:03', '2024-01-15 11:52:03', NULL, 'Manage Orders'),
(4, 'manage-product', '2024-01-15 11:52:03', '2024-01-15 11:52:03', NULL, 'Manage Products');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT 'user.png',
  `role` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'unactive',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `photo`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Tenganamba', 'admin@gmail.com', NULL, '$2y$10$mnh0GE0MQ5CxKMgG.WXOhO9sQBhtuPT0qDrO83Gi79ZPI/CcFSyg2', '123-345-7833', 'user_dfba7504202d4c1a27adb0be7a9be5b7.jpg', 'Admin', 'unactive', 'l8sPpwqpsOCZuuGIeYtxOkWt3qkOMtCpffXwuD6t9Z1V7U0gVGH9BsyLb3ai', '2021-10-01 04:31:30', '2022-03-09 18:45:41'),
(2, 'test', 'info@test.co.tz', NULL, '$2y$10$BY0rB7OGWtrPdxA4vrJCwusouzaAPgxOxoAou7QWHo5sKU/ejTOdy', '0655123456', 'user.png', '', 'active', NULL, '2024-01-15 08:09:09', '2024-01-15 08:09:09');

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE `users_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`user_id`, `role_id`, `updated_at`) VALUES
(1, 1, '2022-05-31 09:38:13'),
(2, 2, '2024-01-15 13:59:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_payments`
--
ALTER TABLE `order_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_methodes`
--
ALTER TABLE `payment_methodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_sys_module_id_foreign` (`sys_module_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `roles_permissions_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_control`
--
ALTER TABLE `system_control`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_modules`
--
ALTER TABLE `sys_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`phone`) USING BTREE;

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `users_roles_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_payments`
--
ALTER TABLE `order_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_methodes`
--
ALTER TABLE `payment_methodes`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=405;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_control`
--
ALTER TABLE `system_control`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `sys_modules`
--
ALTER TABLE `sys_modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
