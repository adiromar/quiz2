-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2019 at 08:06 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bix_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(150) NOT NULL,
  `slug` varchar(250) NOT NULL,
  `featured` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `slug`, `featured`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'general knowledge', 'general-knowledge', 1, 1, '2019-04-01 09:52:04', '2019-04-01 02:24:22'),
(10, 'science', 'science', 1, 1, '2019-04-02 05:03:57', '2019-04-01 04:23:46'),
(12, 'Computer Science', 'computer-science', NULL, 2, '2019-04-01 22:58:58', '2019-04-01 22:58:58');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `post_name` varchar(150) NOT NULL,
  `category_name` varchar(150) NOT NULL,
  `option_a` varchar(250) NOT NULL,
  `option_b` varchar(250) NOT NULL,
  `option_c` varchar(250) NOT NULL,
  `option_d` varchar(250) NOT NULL,
  `correct_option` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `category_id`, `post_name`, `category_name`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'For which of the following disciplines is Nobel Prize awarded?', 'general knowledge', 'Physics and Chemistry', 'Physiology or Medicine', 'Literature, Peace and Economics', 'All of the above', 'option_d', 1, '2019-04-01 02:24:22', '2019-04-01 02:24:22'),
(2, 1, ' \nHitler party which came into power in 1933 is known as', 'general knowledge', 'Labour Party', 'Nazi Party', 'Ku-Klux-Klan', 'Democratic Party', 'option_b', 1, '2019-04-01 02:24:22', '2019-04-01 02:24:22'),
(3, 1, 'Epsom (England) is the place associated withsome question', 'general knowledge', 'Horse racing', 'Polo', 'Shooting', 'Snooker', 'option_a', 1, '2019-04-01 02:24:22', '2019-04-01 02:24:22'),
(4, 1, 'Exposure to sunlight helps a person improve his health because', 'general knowledge', 'the infrared light kills bacteria in the body', 'resistance power increases', 'the pigment cells in the skin get stimulated and produce a healthy tan', 'the ultraviolet rays convert skin oil into Vitamin D', 'option_d', 1, '2019-04-01 02:24:22', '2019-04-01 02:24:22'),
(5, 1, 'Each year World Red Cross and Red Crescent Day is celebrated on', 'general knowledge', '8-May', '18-May', '8-Jun', '18-Jun', 'option_a', 1, '2019-04-01 02:24:22', '2019-04-01 02:24:22'),
(6, 1, ' \nFriction can be reduced by changing from', 'general knowledge', 'sliding to rolling', 'rolling to sliding', 'potential energy to kinetic energy', 'dynamic to static', 'option_a', 1, '2019-04-01 02:24:22', '2019-04-01 02:24:22'),
(7, 1, 'Fire temple is the place of worship of which of the following religion?', 'general knowledge', 'Taoism', 'Judaism', 'Zoroastrianism (Parsi Religion)', 'Shintoism', 'option_c', 1, '2019-04-01 02:24:22', '2019-04-01 02:24:22'),
(8, 10, 'For galvanizing iron which of the following metals is used?', 'science', 'Aluminium', 'Copper', 'Lead', 'Zinc', 'option_d', 2, '2019-04-01 22:30:26', '2019-04-01 22:30:26'),
(10, 11, 'dasd sad sad as dasd as da', 'mathematics', '234', '342', '43', '324', 'option_a', 2, '2019-04-01 22:57:59', '2019-04-01 22:57:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `roles`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'eddie', 'vikramadityabhatta@gmail.com', '$2y$10$Jy6OzQXYU8zhEyIQOavM9ery4Mb5.NRfeM1aLlLleEq4bZ6lJw61K', 'SuperAdmin', 'PQIRv175mcWGguKTtO38CzwsjfH7h7JJpudNBXbPt6MccUp6ccWr53R5ccnu', '2019-03-19 04:37:49', '2019-03-19 04:37:49'),
(2, 'bhatta', 'bhattaraiaditya99@gmail.com', '$2y$10$nHS4K83hu57x9d9nOqB41OKF7ulTilDlVN8p/xNkXc6medAvtmcbO', NULL, 'GeksRKAdQZk8gEpYKoJ9feiHr7fAH0ywqHYbmT5VhSvPEJJe8STiEu55QuWY', '2019-03-30 23:17:20', '2019-03-30 23:17:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
