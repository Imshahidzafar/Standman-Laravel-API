-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 10, 2023 at 05:51 AM
-- Server version: 10.11.5-MariaDB-1:10.11.5+maria~ubu2204
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_standman_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_list`
--

CREATE TABLE `chat_list` (
  `chat_list_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `date_request` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `chat_list`
--

INSERT INTO `chat_list` (`chat_list_id`, `sender_id`, `receiver_id`, `date_request`, `created_at`) VALUES
(1, 2, 1, '2023-08-23', '2023-08-23 12:40:49');

-- --------------------------------------------------------

--
-- Table structure for table `chat_list_live`
--

CREATE TABLE `chat_list_live` (
  `chat_list_live_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `date_request` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `chat_list_live`
--

INSERT INTO `chat_list_live` (`chat_list_live_id`, `sender_id`, `receiver_id`, `date_request`, `created_at`) VALUES
(1, 6, 1, '2023-08-26', '2023-08-26 11:02:31'),
(2, 3, 1, '2023-08-26', '2023-08-26 18:50:17'),
(3, 1, 1, '2023-08-31', '2023-08-31 11:51:00');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `chat_message_id` int(11) NOT NULL,
  `sender_type` enum('Employee','Customer') NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `message_type` enum('text','attachment','location') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `send_date` datetime NOT NULL,
  `send_time` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `read_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` enum('Read','Unread') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`chat_message_id`, `sender_type`, `sender_id`, `receiver_id`, `message`, `message_type`, `send_date`, `send_time`, `read_date`, `created_at`, `status`) VALUES
(1, 'Employee', 2, 1, '\"hi there\"', 'text', '2023-08-23 00:00:00', '12:41:02', NULL, '2023-08-23 12:41:02', 'Read'),
(2, 'Employee', 2, 1, '\"how are you\"', 'text', '2023-08-23 00:00:00', '12:41:17', NULL, '2023-08-23 12:41:17', 'Read'),
(3, 'Customer', 1, 2, '\"I\'m fine\"', 'text', '2023-08-23 00:00:00', '12:43:27', NULL, '2023-08-23 12:43:27', 'Read'),
(4, 'Customer', 1, 2, '\"and the rest\"', 'text', '2023-08-23 00:00:00', '12:43:40', NULL, '2023-08-23 12:43:40', 'Read'),
(5, 'Employee', 2, 1, '\"Good\"', 'text', '2023-08-23 00:00:00', '12:46:26', NULL, '2023-08-23 12:46:26', 'Read'),
(6, 'Customer', 1, 2, '\"hello\"', 'text', '2023-08-23 00:00:00', '15:40:13', NULL, '2023-08-23 15:40:13', 'Read'),
(7, 'Employee', 2, 1, '\"hi\"', 'text', '2023-08-23 00:00:00', '15:40:19', NULL, '2023-08-23 15:40:19', 'Read'),
(8, 'Customer', 1, 2, '\"hello\"', 'text', '2023-08-23 00:00:00', '15:40:29', NULL, '2023-08-23 15:40:29', 'Read'),
(9, 'Employee', 2, 1, '\"you\"', 'text', '2023-08-23 00:00:00', '15:40:36', NULL, '2023-08-23 15:40:36', 'Read'),
(10, 'Customer', 1, 2, '\"hello\"', 'text', '2023-09-04 00:00:00', '11:16:28', NULL, '2023-09-04 11:16:28', 'Unread');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages_live`
--

CREATE TABLE `chat_messages_live` (
  `chat_messages_live_id` int(11) NOT NULL,
  `sender_type` enum('Users','Admin') NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `message_type` enum('text','attachment','location') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `send_date` datetime NOT NULL,
  `send_time` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `read_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` enum('Read','Unread') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `chat_messages_live`
--

INSERT INTO `chat_messages_live` (`chat_messages_live_id`, `sender_type`, `sender_id`, `receiver_id`, `message`, `message_type`, `send_date`, `send_time`, `read_date`, `created_at`, `status`) VALUES
(1, 'Users', 6, 1, '\"Hi\"', 'text', '2023-08-26 00:00:00', '11:02:35', NULL, '2023-08-26 11:02:35', 'Unread'),
(2, 'Admin', 1, 6, '\"Hello\"', 'text', '2023-08-26 00:00:00', '11:02:48', NULL, '2023-08-26 11:02:48', 'Read'),
(3, 'Users', 6, 1, '\"Test\"', 'text', '2023-08-26 00:00:00', '11:02:55', NULL, '2023-08-26 11:02:55', 'Unread'),
(4, 'Admin', 1, 6, '\"Test 2\"', 'text', '2023-08-26 00:00:00', '11:03:09', NULL, '2023-08-26 11:03:09', 'Read'),
(5, 'Users', 5, 1, '\"Hi\"', 'text', '2023-08-26 00:00:00', '19:14:45', NULL, '2023-08-26 19:14:45', 'Unread'),
(6, 'Users', 5, 1, '\"1111\"', 'text', '2023-08-26 00:00:00', '19:15:22', NULL, '2023-08-26 19:15:22', 'Unread');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `jobs_id` int(11) NOT NULL,
  `users_customers_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `image` text NOT NULL,
  `location` text NOT NULL,
  `longitude` text NOT NULL,
  `lattitude` text NOT NULL,
  `start_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `service_charges` decimal(15,2) NOT NULL,
  `tax` decimal(15,2) NOT NULL,
  `total_price` decimal(15,2) NOT NULL,
  `payment_gateways_name` text NOT NULL,
  `extra_time_price` decimal(15,2) DEFAULT NULL,
  `extra_time_tax` decimal(15,2) DEFAULT NULL,
  `extra_time_service_charges` decimal(15,2) DEFAULT NULL,
  `extra_time` time DEFAULT NULL,
  `payment_status` enum('Paid','Unpaid') NOT NULL,
  `hired_users_customers_id` int(11) DEFAULT NULL,
  `date_start_job` datetime DEFAULT NULL,
  `date_end_job` datetime DEFAULT NULL,
  `status` enum('Ongoing','Accepted','Rejected','Cancelled','Completed','Deleted','Pending') NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `rating` decimal(15,1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`jobs_id`, `users_customers_id`, `name`, `image`, `location`, `longitude`, `lattitude`, `start_date`, `start_time`, `end_time`, `description`, `price`, `service_charges`, `tax`, `total_price`, `payment_gateways_name`, `extra_time_price`, `extra_time_tax`, `extra_time_service_charges`, `extra_time`, `payment_status`, `hired_users_customers_id`, `date_start_job`, `date_end_job`, `status`, `date_added`, `date_modified`, `rating`) VALUES
(1, 1, 'Wait in line', 'uploads/jobs_images/1692775949.jpeg', 'Buliding No 4, Shalimar Colony, Multan,', '71.4854088', '30.2398357', '2023-08-23', '11:10:00', '12:10:00', NULL, 21.00, 2.10, 3.00, 26.10, 'GPay', NULL, NULL, NULL, NULL, 'Paid', NULL, NULL, NULL, 'Accepted', '2023-08-23 12:32:29', '2023-08-23 12:34:00', NULL),
(2, 1, 'Wait in line', 'uploads/jobs_images/job.jpg', 'Buliding No 4, Shalimar Colony, Multan,', '71.485412', '30.239838', '2023-08-23', '15:00:00', '17:00:00', NULL, 42.00, 4.20, 6.01, 52.21, 'GPay', NULL, NULL, NULL, NULL, 'Paid', NULL, NULL, NULL, 'Completed', '2023-08-23 14:54:32', '2023-08-23 14:55:42', NULL),
(3, 1, 'Wait in line', 'uploads/jobs_images/1692787026.jpeg', 'Buliding No 4, Shalimar Colony, Multan,', '71.4854044', '30.23984', '2023-08-23', '15:40:00', '17:36:00', NULL, 40.60, 4.06, 5.81, 50.47, 'GPay', NULL, NULL, NULL, NULL, 'Paid', NULL, NULL, NULL, 'Completed', '2023-08-23 15:37:06', '2023-08-23 15:37:59', NULL),
(4, 1, 'test job', 'uploads/jobs_images/job.jpg', 'Shalimar colony multan', '71.4854054', '30.2398618', '2023-08-23', '04:20:00', '06:35:00', 'Hello this is description', 21.00, 2.10, 3.00, 26.10, 'GPay', NULL, NULL, NULL, NULL, 'Paid', NULL, NULL, NULL, 'Accepted', '2023-08-23 16:15:03', '2023-08-23 16:15:37', NULL),
(5, 1, 'Wait in line', 'uploads/jobs_images/job.jpg', 'Buliding No 4, Shalimar Colony, Multan,', '71.4854276', '30.2398335', '2023-08-23', '16:23:00', '18:17:00', NULL, 39.90, 3.99, 5.71, 49.60, 'GPay', NULL, NULL, NULL, NULL, 'Paid', NULL, NULL, NULL, 'Completed', '2023-08-23 16:17:40', '2023-08-23 16:18:46', NULL),
(6, 3, 'Wait in line', 'uploads/jobs_images/job.jpg', 'Katsuya Yonge Street, North York, ON, Canada', '-79.4082565', '43.782753', '2023-08-23', '10:00:00', '12:10:00', NULL, 45.50, 4.55, 6.51, 56.56, 'GPay', NULL, NULL, NULL, NULL, 'Paid', NULL, NULL, NULL, 'Pending', '2023-08-23 18:59:59', '2023-08-23 18:59:59', NULL),
(7, 3, 'Wait in line', 'uploads/jobs_images/job.jpg', 'Katsuya Yonge Street, North York, ON, Canada', '-79.4082565', '43.782753', '2023-08-23', '10:00:00', '12:10:00', NULL, 45.50, 4.55, 6.51, 56.56, 'GPay', NULL, NULL, NULL, NULL, 'Paid', NULL, NULL, NULL, 'Pending', '2023-08-23 19:01:30', '2023-08-23 19:01:30', NULL),
(8, 3, 'Wait in line', 'uploads/jobs_images/job.jpg', 'Katsuya Yonge Street, North York, ON, Canada', '-79.4082565', '43.782753', '2023-08-23', '10:00:00', '12:10:00', NULL, 45.50, 4.55, 6.51, 56.56, 'GPay', NULL, NULL, NULL, NULL, 'Paid', NULL, NULL, NULL, 'Pending', '2023-08-23 19:01:37', '2023-08-23 19:01:37', NULL),
(9, 3, 'Wait in line', 'uploads/jobs_images/job.jpg', '112 Pemberton Ave, North York, Toronto, M2M 1Y5', '-79.4082184', '43.7826548', '2023-08-24', '12:05:00', '13:05:00', NULL, 21.00, 2.10, 3.00, 26.10, 'GPay', NULL, NULL, NULL, NULL, 'Paid', NULL, NULL, NULL, 'Ongoing', '2023-08-23 19:02:27', '2023-08-23 19:07:12', NULL),
(10, 3, 'Wait in line', 'uploads/jobs_images/job.jpg', '112 Pemberton Ave, North York, Toronto, M2M 1Y5', '-79.4082184', '43.7826548', '2023-08-24', '12:05:00', '13:05:00', NULL, 21.00, 2.10, 3.00, 26.10, 'GPay', NULL, NULL, NULL, NULL, 'Paid', NULL, NULL, NULL, 'Ongoing', '2023-08-23 19:02:39', '2023-08-23 20:05:20', NULL),
(11, 3, 'Wait in line', 'uploads/jobs_images/job.jpg', '112 Pemberton Ave, North York, Toronto, M2M 1Y5', '-79.4082291', '43.7826932', '2023-08-23', '11:05:00', '12:05:00', NULL, 21.00, 2.10, 3.00, 26.10, 'GPay', NULL, NULL, NULL, NULL, 'Paid', NULL, NULL, NULL, 'Pending', '2023-08-23 19:06:03', '2023-08-23 19:06:03', NULL),
(12, 6, 'Wait in line', 'uploads/jobs_images/job.jpg', '11 Pemberton Ave North York, Toronto, North York, ON M2M 4L9, Canada', '-79.4082381', '43.7826873', '2023-08-26', '01:47:00', '01:53:00', NULL, 21.00, 2.10, 3.00, 26.10, 'GPay', NULL, NULL, NULL, NULL, 'Paid', NULL, NULL, NULL, 'Pending', '2023-08-26 10:46:08', '2023-08-26 10:46:08', NULL),
(13, 6, 'Wait in line', 'uploads/jobs_images/job.jpg', '4968 Yonge Street North York, ON, Canada', '-79.4082271', '43.7826874', '2023-08-26', '01:50:00', '01:55:00', NULL, 21.00, 2.10, 3.00, 26.10, 'GPay', NULL, NULL, NULL, NULL, 'Paid', NULL, NULL, NULL, 'Pending', '2023-08-26 10:49:03', '2023-08-26 10:49:03', NULL),
(14, 6, 'Wait in line', 'uploads/jobs_images/job.jpg', '112 Pemberton Ave, North York, Toronto, M2M 1Y5', '-79.4082317', '43.782689', '2023-08-26', '02:05:00', '02:10:00', NULL, 21.00, 2.10, 3.00, 26.10, 'GPay', NULL, NULL, NULL, NULL, 'Paid', NULL, NULL, NULL, 'Pending', '2023-08-26 11:04:30', '2023-08-26 11:04:30', NULL),
(15, 3, 'katsuya', 'uploads/jobs_images/job.jpg', 'Katsuya Yonge Street, North York, ON, Canada', '-79.4185625', '43.7899562', '2023-08-27', '10:00:00', '11:00:00', NULL, 21.00, 2.10, 3.00, 26.10, 'GPay', NULL, NULL, NULL, NULL, 'Paid', NULL, NULL, NULL, 'Accepted', '2023-08-26 19:15:51', '2023-08-26 19:42:43', NULL),
(16, 6, 'Wait in line', 'uploads/jobs_images/job.jpg', '112 Pemberton Ave, North York, Toronto, M2M 1Y5', '-79.4081657', '43.7826869', '2023-08-26', '11:31:00', '12:32:00', NULL, 21.35, 2.14, 3.06, 26.55, 'GPay', NULL, NULL, NULL, NULL, 'Paid', NULL, NULL, NULL, 'Pending', '2023-08-26 19:32:19', '2023-08-26 19:32:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs_ratings`
--

CREATE TABLE `jobs_ratings` (
  `jobs_ratings_id` int(11) NOT NULL,
  `users_customers_id` int(11) NOT NULL,
  `employee_users_customers_id` int(11) NOT NULL,
  `jobs_id` int(11) NOT NULL,
  `rating` decimal(15,1) NOT NULL,
  `comment` text DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Active','Inactive','Deleted') NOT NULL DEFAULT 'Active'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `jobs_ratings`
--

INSERT INTO `jobs_ratings` (`jobs_ratings_id`, `users_customers_id`, `employee_users_customers_id`, `jobs_id`, `rating`, `comment`, `date_added`, `status`) VALUES
(1, 1, 2, 1, 2.5, 'rating', '2023-08-23 05:29:21', 'Active'),
(2, 1, 2, 2, 5.0, 'hellothere', '2023-08-23 06:16:47', 'Active'),
(3, 1, 2, 3, 1.0, 'hey', '2023-08-23 06:42:14', 'Active'),
(4, 1, 2, 5, 0.5, 'jdvd dvenr rbee', '2023-08-23 07:35:18', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `jobs_requests`
--

CREATE TABLE `jobs_requests` (
  `jobs_requests_id` int(11) NOT NULL,
  `users_customers_id` int(11) NOT NULL,
  `jobs_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `status` enum('Accepted','Rejected','Cancelled','Completed') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `jobs_requests`
--

INSERT INTO `jobs_requests` (`jobs_requests_id`, `users_customers_id`, `jobs_id`, `date_added`, `status`) VALUES
(1, 2, 1, '2023-08-23 12:34:00', 'Completed'),
(2, 2, 2, '2023-08-23 14:55:42', 'Completed'),
(3, 2, 3, '2023-08-23 15:37:59', 'Completed'),
(4, 2, 4, '2023-08-23 16:15:37', 'Accepted'),
(5, 2, 5, '2023-08-23 16:18:46', 'Completed'),
(6, 5, 10, '2023-08-23 19:02:57', 'Accepted'),
(7, 5, 9, '2023-08-23 19:04:29', 'Accepted'),
(8, 5, 15, '2023-08-26 19:16:03', 'Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notifications_id` int(11) NOT NULL,
  `bookings_id` int(11) NOT NULL,
  `senders_id` int(11) NOT NULL,
  `receivers_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` enum('Read','Unread') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notifications_id`, `bookings_id`, `senders_id`, `receivers_id`, `message`, `date_added`, `date_modified`, `status`) VALUES
(1, 0, 1, 2, 'A job is created.', '2023-08-23 12:32:29', '2023-08-23 12:32:29', 'Unread'),
(2, 0, 2, 1, 'Job is Accepted.', '2023-08-23 12:34:00', '2023-08-23 12:34:00', 'Unread'),
(3, 0, 2, 1, 'A new message has been recieved.', '2023-08-23 12:41:02', '2023-08-23 12:41:02', 'Read'),
(4, 0, 2, 1, 'A new message has been recieved.', '2023-08-23 12:41:17', '2023-08-23 12:41:17', 'Read'),
(5, 0, 1, 2, 'A new message has been recieved.', '2023-08-23 12:43:27', '2023-08-23 12:43:27', 'Read'),
(6, 0, 1, 2, 'A new message has been recieved.', '2023-08-23 12:43:40', '2023-08-23 12:43:40', 'Read'),
(7, 0, 2, 1, 'A new message has been recieved.', '2023-08-23 12:46:26', '2023-08-23 12:46:26', 'Read'),
(8, 0, 1, 2, 'A job is created.', '2023-08-23 14:54:32', '2023-08-23 14:54:32', 'Unread'),
(9, 0, 2, 1, 'Job is Accepted.', '2023-08-23 14:55:42', '2023-08-23 14:55:42', 'Unread'),
(10, 0, 1, 2, 'A job is created.', '2023-08-23 15:37:06', '2023-08-23 15:37:06', 'Unread'),
(11, 0, 2, 1, 'Job is Accepted.', '2023-08-23 15:37:59', '2023-08-23 15:37:59', 'Unread'),
(12, 0, 1, 2, 'A new message has been recieved.', '2023-08-23 15:40:13', '2023-08-23 15:40:13', 'Read'),
(13, 0, 2, 1, 'A new message has been recieved.', '2023-08-23 15:40:19', '2023-08-23 15:40:19', 'Read'),
(14, 0, 1, 2, 'A new message has been recieved.', '2023-08-23 15:40:29', '2023-08-23 15:40:29', 'Read'),
(15, 0, 2, 1, 'A new message has been recieved.', '2023-08-23 15:40:36', '2023-08-23 15:40:36', 'Read'),
(16, 0, 1, 2, 'A job is created.', '2023-08-23 16:15:03', '2023-08-23 16:15:03', 'Unread'),
(17, 0, 2, 1, 'Job is Accepted.', '2023-08-23 16:15:37', '2023-08-23 16:15:37', 'Unread'),
(18, 0, 1, 2, 'A job is created.', '2023-08-23 16:17:40', '2023-08-23 16:17:40', 'Unread'),
(19, 0, 2, 1, 'Job is Accepted.', '2023-08-23 16:18:46', '2023-08-23 16:18:46', 'Unread'),
(20, 0, 3, 2, 'A job is created.', '2023-08-23 18:59:59', '2023-08-23 18:59:59', 'Unread'),
(21, 0, 3, 5, 'A job is created.', '2023-08-23 18:59:59', '2023-08-23 18:59:59', 'Unread'),
(22, 0, 3, 2, 'A job is created.', '2023-08-23 19:01:30', '2023-08-23 19:01:30', 'Unread'),
(23, 0, 3, 5, 'A job is created.', '2023-08-23 19:01:30', '2023-08-23 19:01:30', 'Unread'),
(24, 0, 3, 2, 'A job is created.', '2023-08-23 19:01:37', '2023-08-23 19:01:37', 'Unread'),
(25, 0, 3, 5, 'A job is created.', '2023-08-23 19:01:37', '2023-08-23 19:01:37', 'Unread'),
(26, 0, 3, 2, 'A job is created.', '2023-08-23 19:02:27', '2023-08-23 19:02:27', 'Unread'),
(27, 0, 3, 5, 'A job is created.', '2023-08-23 19:02:27', '2023-08-23 19:02:27', 'Unread'),
(28, 0, 3, 2, 'A job is created.', '2023-08-23 19:02:39', '2023-08-23 19:02:39', 'Unread'),
(29, 0, 3, 5, 'A job is created.', '2023-08-23 19:02:39', '2023-08-23 19:02:39', 'Unread'),
(30, 0, 5, 3, 'Job is Accepted.', '2023-08-23 19:02:57', '2023-08-23 19:02:57', 'Unread'),
(31, 0, 5, 3, 'Job is Accepted.', '2023-08-23 19:03:52', '2023-08-23 19:03:52', 'Unread'),
(32, 0, 5, 3, 'Job is Accepted.', '2023-08-23 19:04:27', '2023-08-23 19:04:27', 'Unread'),
(33, 0, 5, 3, 'Job is Accepted.', '2023-08-23 19:04:29', '2023-08-23 19:04:29', 'Unread'),
(34, 0, 5, 3, 'Job is Rejected.', '2023-08-23 19:04:51', '2023-08-23 19:04:51', 'Unread'),
(35, 0, 5, 3, 'Job is Accepted.', '2023-08-23 19:05:04', '2023-08-23 19:05:04', 'Unread'),
(36, 0, 3, 2, 'A job is created.', '2023-08-23 19:06:03', '2023-08-23 19:06:03', 'Unread'),
(37, 0, 3, 5, 'A job is created.', '2023-08-23 19:06:03', '2023-08-23 19:06:03', 'Unread'),
(38, 0, 5, 3, 'Job is Accepted.', '2023-08-23 19:07:04', '2023-08-23 19:07:04', 'Unread'),
(39, 0, 5, 3, 'Job is Accepted.', '2023-08-23 19:07:05', '2023-08-23 19:07:05', 'Unread'),
(40, 0, 5, 3, 'Job is Accepted.', '2023-08-23 19:07:12', '2023-08-23 19:07:12', 'Unread'),
(41, 0, 5, 3, 'Job is Accepted.', '2023-08-23 19:07:21', '2023-08-23 19:07:21', 'Unread'),
(42, 0, 5, 3, 'Job is Accepted.', '2023-08-23 20:05:20', '2023-08-23 20:05:20', 'Unread'),
(43, 0, 6, 2, 'A job is created.', '2023-08-26 10:46:08', '2023-08-26 10:46:08', 'Unread'),
(44, 0, 6, 5, 'A job is created.', '2023-08-26 10:46:08', '2023-08-26 10:46:08', 'Unread'),
(45, 0, 6, 2, 'A job is created.', '2023-08-26 10:49:03', '2023-08-26 10:49:03', 'Unread'),
(46, 0, 6, 5, 'A job is created.', '2023-08-26 10:49:03', '2023-08-26 10:49:03', 'Unread'),
(47, 0, 6, 1, 'sent a message.', '2023-08-26 11:02:35', '2023-08-26 11:02:35', 'Unread'),
(48, 0, 1, 6, 'sent a message.', '2023-08-26 11:02:48', '2023-08-26 11:02:48', 'Unread'),
(49, 0, 6, 1, 'sent a message.', '2023-08-26 11:02:55', '2023-08-26 11:02:55', 'Unread'),
(50, 0, 1, 6, 'sent a message.', '2023-08-26 11:03:09', '2023-08-26 11:03:09', 'Unread'),
(51, 0, 6, 2, 'A job is created.', '2023-08-26 11:04:30', '2023-08-26 11:04:30', 'Unread'),
(52, 0, 6, 5, 'A job is created.', '2023-08-26 11:04:30', '2023-08-26 11:04:30', 'Unread'),
(53, 0, 5, 1, 'sent a message.', '2023-08-26 19:14:45', '2023-08-26 19:14:45', 'Unread'),
(54, 0, 5, 1, 'sent a message.', '2023-08-26 19:15:22', '2023-08-26 19:15:22', 'Unread'),
(55, 0, 3, 2, 'A job is created.', '2023-08-26 19:15:51', '2023-08-26 19:15:51', 'Unread'),
(56, 0, 3, 5, 'A job is created.', '2023-08-26 19:15:51', '2023-08-26 19:15:51', 'Unread'),
(57, 0, 5, 3, 'Job is Accepted.', '2023-08-26 19:16:03', '2023-08-26 19:16:03', 'Unread'),
(58, 0, 5, 3, 'Job is Accepted.', '2023-08-26 19:16:43', '2023-08-26 19:16:43', 'Unread'),
(59, 0, 5, 3, 'Job is Accepted.', '2023-08-26 19:17:13', '2023-08-26 19:17:13', 'Unread'),
(60, 0, 5, 3, 'Job is Accepted.', '2023-08-26 19:25:13', '2023-08-26 19:25:13', 'Unread'),
(61, 0, 5, 3, 'Job is Accepted.', '2023-08-26 19:25:15', '2023-08-26 19:25:15', 'Unread'),
(62, 0, 6, 2, 'A job is created.', '2023-08-26 19:32:19', '2023-08-26 19:32:19', 'Unread'),
(63, 0, 6, 5, 'A job is created.', '2023-08-26 19:32:19', '2023-08-26 19:32:19', 'Unread'),
(64, 0, 5, 3, 'Job is Accepted.', '2023-08-26 19:38:37', '2023-08-26 19:38:37', 'Unread'),
(65, 0, 5, 3, 'Job is Accepted.', '2023-08-26 19:42:43', '2023-08-26 19:42:43', 'Unread'),
(66, 0, 1, 2, 'A new message has been recieved.', '2023-09-04 11:16:28', '2023-09-04 11:16:28', 'Read');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `system_settings_id` int(11) NOT NULL,
  `type` text NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`system_settings_id`, `type`, `description`) VALUES
(1, 'system_name', 'Stand Man'),
(2, 'email', 'support@standman.com'),
(3, 'phone', '1234567890'),
(4, 'language', 'english'),
(5, 'address', 'ABCD'),
(6, 'system_image', 'logo.png'),
(7, 'smtp_host', 'localhost'),
(8, 'smtp_port', '21'),
(9, 'smtp_username', 'no-reply@standman.com'),
(10, 'smtp_password', 'admin'),
(11, 'geo_api_key', 'AIzaSyC4HqZf-zANxtQqW0riYOrRKdrXvzMqCqM'),
(12, 'system_currency', '$'),
(13, 'onesignal_appId', '60c86bbb-36cd-406a-b336-2a88bbd68402'),
(14, 'one_signal_server_key', 'AAAATnqWTbw:APA91bE_DZqQwnLOgZwu6RTI8wrqKy0lZey11jzQT-lTtAn0Wa3PFQGfHf5U6GGVJjeOaWBz9KdoNGDNI0EE9M4OiwkppBSwpGjELEfBwowJFt1kwfiwRxaXskMaqt2ob9poF7cFItXL'),
(15, 'one_signal_sender_id', '337064119740'),
(16, 'social_login', 'Yes'),
(17, 'invite_text', 'Invite \r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing.\r\n\r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing.'),
(18, 'terms_text', 'Terms \r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing.\r\n\r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing.'),
(19, 'about_text', '1'),
(23, 'job_radius', '10'),
(24, 'tax', '13'),
(25, 'withdraw_charges', '0'),
(26, 'per_hour_rate', '21'),
(20, 'privacy_text', 'Privacy \r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing.\r\n\r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing.'),
(21, 'service_charges', '10');

-- --------------------------------------------------------

--
-- Table structure for table `users_customers`
--

CREATE TABLE `users_customers` (
  `users_customers_id` int(11) NOT NULL,
  `one_signal_id` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `users_customers_type` enum('Employee','Customer') NOT NULL,
  `first_name` text DEFAULT NULL,
  `last_name` text DEFAULT NULL,
  `phone` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `profile_pic` text DEFAULT NULL,
  `proof_document` text DEFAULT NULL,
  `valid_document` text DEFAULT NULL,
  `messages` enum('Yes','No') DEFAULT 'Yes',
  `notifications` enum('Yes','No') NOT NULL,
  `account_type` enum('SignupWithApp','SignupWithSocial','Both') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `social_acc_type` enum('Google','Facebook','None') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `google_access_token` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `verify_code` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `country_code` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `verified_badge` enum('Yes','No') NOT NULL DEFAULT 'No',
  `date_expiry` date DEFAULT NULL,
  `wallet_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `job_radius` int(100) NOT NULL DEFAULT 10,
  `rating` decimal(15,1) NOT NULL DEFAULT 0.0,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Active','Inactive','Deleted') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users_customers`
--

INSERT INTO `users_customers` (`users_customers_id`, `one_signal_id`, `users_customers_type`, `first_name`, `last_name`, `phone`, `email`, `password`, `profile_pic`, `proof_document`, `valid_document`, `messages`, `notifications`, `account_type`, `social_acc_type`, `google_access_token`, `verify_code`, `country_code`, `verified_badge`, `date_expiry`, `wallet_amount`, `job_radius`, `rating`, `date_added`, `status`) VALUES
(1, 'd6a1298e-34d1-4ad5-a780-12a51ca6c8de', 'Customer', 'Customer', 'Side', '1234567890', 'hammadraza5388@gmail.com', 'ebc2d1b00ba2d4687ec8d8dbf0e0c3ab', 'uploads/users_customers/1692775185.jpeg', NULL, NULL, 'No', 'Yes', 'SignupWithApp', 'None', '', '', 'PK', 'No', NULL, 0.00, 10, 0.0, '2023-08-23 16:19:45', 'Deleted'),
(3, '18a71415-81d7-4f5a-be70-f8b4f404ae55', 'Customer', 'Baiaz', 'Arzybekov', '4374600882', 'zalkarmgimo93@mail.ru', 'cad54b7ff4dee4464952159731aa54a1', 'uploads/users_customers/1692797236.jpeg', NULL, NULL, 'Yes', 'Yes', 'SignupWithApp', 'None', '', '3789', 'US', 'No', NULL, 0.00, 10, 0.0, '2023-08-23 22:27:16', 'Active'),
(2, 'd6a1298e-34d1-4ad5-a780-12a51ca6c8de', 'Employee', 'StandMan', 'Side', '1234567890', 'hammadsiddiqui5388@gmail.com', 'ebc2d1b00ba2d4687ec8d8dbf0e0c3ab', 'uploads/users_customers/1692775413.jpeg', 'uploads/users_documents/1692775413.jpeg', 'uploads/users_documents/1692775413.jpeg', 'Yes', 'Yes', 'SignupWithApp', 'None', '', '', 'IN', 'No', NULL, 143.50, 50, 2.3, '2023-08-23 16:23:33', 'Active'),
(5, '0e9d3afe-e26a-4d0c-9edf-2f39fb9b1fc8', 'Employee', 'Test', 'StandMan', '9991112233', 'mest9114@gmail.com', '83805e19b984daaf186f0ca17e8e80d0', 'uploads/users_customers/1692798592.jpeg', 'uploads/users_documents/1692798592.jpeg', 'uploads/users_documents/1692798592.jpeg', 'Yes', 'Yes', 'SignupWithApp', 'None', '', '3673', 'US', 'No', NULL, 0.00, 15, 0.0, '2023-08-23 22:49:52', 'Active'),
(6, '0e9d3afe-e26a-4d0c-9edf-2f39fb9b1fc8', 'Customer', 'Test', 'Customer', '9991112233', 'vexayav284@trazeco.com', '83805e19b984daaf186f0ca17e8e80d0', 'uploads/users_customers/1693028594.jpeg', NULL, NULL, 'Yes', 'Yes', 'SignupWithApp', 'None', '', '5089', 'US', 'No', NULL, 0.00, 10, 0.0, '2023-08-26 14:43:14', 'Active'),
(7, 'a8254730-cd15-4327-94a4-2fd5ad5bbefb', 'Customer', 'first', 'last', '1234567890', 'one@spamOK.com', 'ebc2d1b00ba2d4687ec8d8dbf0e0c3ab', 'uploads/users_customers/1693548869.jpeg', NULL, NULL, 'Yes', 'Yes', 'SignupWithApp', 'None', '', '1044', 'US', 'No', NULL, 0.00, 10, 0.0, '2023-09-01 15:14:29', 'Pending'),
(8, 'a8254730-cd15-4327-94a4-2fd5ad5bbefb', 'Employee', 'first', 'last', '1234567890', 'two@spamOK.com', 'ebc2d1b00ba2d4687ec8d8dbf0e0c3ab', 'uploads/users_customers/1693549001.jpeg', 'uploads/users_documents/1693549001.jpeg', 'uploads/users_documents/1693549001.jpeg', 'Yes', 'Yes', 'SignupWithApp', 'None', '', '7725', 'US', 'No', NULL, 0.00, 10, 0.0, '2023-09-01 15:16:41', 'Pending'),
(9, 'e8d9d110-bd7e-4690-8f5e-4e64cde5ac94', 'Customer', 'first', 'last', '1234567890', 'abc@gmail.com', 'ebc2d1b00ba2d4687ec8d8dbf0e0c3ab', 'uploads/users_customers/1693806156.jpeg', NULL, NULL, 'Yes', 'Yes', 'SignupWithApp', 'None', '', '8913', 'US', 'No', NULL, 0.00, 10, 0.0, '2023-09-04 14:42:36', 'Pending'),
(10, 'e8d9d110-bd7e-4690-8f5e-4e64cde5ac94', 'Employee', 'first', 'last', '1234567890', 'abcd@gmail.com', 'ebc2d1b00ba2d4687ec8d8dbf0e0c3ab', 'uploads/users_customers/1693806340.jpeg', 'uploads/users_documents/1693806340.jpeg', 'uploads/users_documents/1693806340.jpeg', 'Yes', 'Yes', 'SignupWithApp', 'None', '', '3748', 'US', 'No', NULL, 0.00, 10, 0.0, '2023-09-04 14:45:40', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `users_customers_delete`
--

CREATE TABLE `users_customers_delete` (
  `users_customers_delete_id` int(11) NOT NULL,
  `email` text NOT NULL,
  `delete_reason` text NOT NULL,
  `comments` text NOT NULL,
  `date_added` datetime NOT NULL,
  `status` enum('Pending','Approved','Declined') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users_customers_delete`
--

INSERT INTO `users_customers_delete` (`users_customers_delete_id`, `email`, `delete_reason`, `comments`, `date_added`, `status`) VALUES
(1, 'mest9114@gmail.com', 'test delete', 'Hello', '2023-08-26 11:05:44', 'Pending'),
(2, 'hammadraza5388@gmail.com', 'test delete', 'Hello', '2023-09-01 11:51:47', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `users_system`
--

CREATE TABLE `users_system` (
  `users_system_id` int(11) NOT NULL,
  `users_system_roles_id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `email` varchar(111) NOT NULL,
  `password` varchar(111) NOT NULL,
  `mobile` varchar(44) NOT NULL,
  `city` text NOT NULL,
  `address` text NOT NULL,
  `user_image` varchar(111) DEFAULT NULL,
  `is_deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `users_system`
--

INSERT INTO `users_system` (`users_system_id`, `users_system_roles_id`, `first_name`, `email`, `password`, `mobile`, `city`, `address`, `user_image`, `is_deleted`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(1, 1, 'Super Admin', 'admin@standman.com', 'admin', '+6013008637767', 'KLCC', 'Malaysia', 'uploads/users_system/user-677d9d74c67929023eedb8469a34003b.jpeg', 'No', NULL, NULL, NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `users_system_roles`
--

CREATE TABLE `users_system_roles` (
  `users_system_roles_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `status` enum('Inactive','Active') NOT NULL,
  `dashboard` enum('Yes','No') NOT NULL,
  `users_customers` enum('Yes','No') NOT NULL,
  `support` enum('Yes','No') NOT NULL,
  `users_system` enum('Yes','No') NOT NULL,
  `users_system_roles` enum('Yes','No') NOT NULL,
  `account_settings` enum('Yes','No') NOT NULL,
  `system_settings` enum('Yes','No') NOT NULL,
  `delete_account_req` enum('Yes','No') NOT NULL,
  `jobs` enum('Yes','No') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `users_system_roles`
--

INSERT INTO `users_system_roles` (`users_system_roles_id`, `name`, `status`, `dashboard`, `users_customers`, `support`, `users_system`, `users_system_roles`, `account_settings`, `system_settings`, `delete_account_req`, `jobs`) VALUES
(1, 'Super Admin', 'Active', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_txns`
--

CREATE TABLE `wallet_txns` (
  `wallet_txns_id` int(11) NOT NULL,
  `users_customers_id` int(11) DEFAULT NULL,
  `employee_users_customers_id` int(11) DEFAULT NULL,
  `jobs_id` int(11) NOT NULL,
  `transaction_id` text DEFAULT NULL,
  `txn_type` enum('In','Out') NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `tax` decimal(15,2) NOT NULL,
  `service_charges` decimal(15,2) NOT NULL,
  `standman_amount` decimal(15,2) NOT NULL,
  `date_time` datetime NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `status` enum('Pending','Accepted','Rejected','Deleted') NOT NULL,
  `narration` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `wallet_txns`
--

INSERT INTO `wallet_txns` (`wallet_txns_id`, `users_customers_id`, `employee_users_customers_id`, `jobs_id`, `transaction_id`, `txn_type`, `total_amount`, `tax`, `service_charges`, `standman_amount`, `date_time`, `date_added`, `date_modified`, `status`, `narration`) VALUES
(1, 1, 2, 1, NULL, 'In', 26.10, 3.00, 2.10, 21.00, '2023-08-23 14:45:22', '2023-08-23 14:45:22', NULL, 'Pending', 'Job Completed'),
(2, 1, NULL, 2, '36605', 'In', 52.21, 6.01, 4.20, 42.00, '2023-08-23 14:54:34', '2023-08-23 14:54:34', NULL, 'Pending', 'Job Created'),
(3, 1, 2, 2, NULL, 'In', 52.21, 6.01, 4.20, 42.00, '2023-08-23 15:16:26', '2023-08-23 15:16:26', NULL, 'Pending', 'Job Completed'),
(4, 1, NULL, 3, '81237', 'In', 50.47, 5.81, 4.06, 40.60, '2023-08-23 15:37:08', '2023-08-23 15:37:08', NULL, 'Pending', 'Job Created'),
(5, 1, 2, 3, NULL, 'In', 50.47, 5.81, 4.06, 40.60, '2023-08-23 15:42:03', '2023-08-23 15:42:03', NULL, 'Pending', 'Job Completed'),
(6, 1, NULL, 5, '00720', 'In', 49.60, 5.71, 3.99, 39.90, '2023-08-23 16:17:42', '2023-08-23 16:17:42', NULL, 'Pending', 'Job Created'),
(7, 1, 2, 5, NULL, 'In', 49.60, 5.71, 3.99, 39.90, '2023-08-23 16:35:07', '2023-08-23 16:35:07', NULL, 'Pending', 'Job Completed'),
(8, 3, NULL, 6, '49327', 'In', 56.56, 6.51, 4.55, 45.50, '2023-08-23 19:00:01', '2023-08-23 19:00:01', NULL, 'Pending', 'Job Created'),
(9, 3, NULL, 7, '49327', 'In', 56.56, 6.51, 4.55, 45.50, '2023-08-23 19:01:31', '2023-08-23 19:01:31', NULL, 'Pending', 'Job Created'),
(10, 3, NULL, 8, '49327', 'In', 56.56, 6.51, 4.55, 45.50, '2023-08-23 19:01:39', '2023-08-23 19:01:39', NULL, 'Pending', 'Job Created'),
(11, 3, NULL, 9, '51653', 'In', 26.10, 3.00, 2.10, 21.00, '2023-08-23 19:02:29', '2023-08-23 19:02:29', NULL, 'Pending', 'Job Created'),
(12, 3, NULL, 10, '51653', 'In', 26.10, 3.00, 2.10, 21.00, '2023-08-23 19:02:40', '2023-08-23 19:02:40', NULL, 'Pending', 'Job Created'),
(13, 3, NULL, 11, '06213', 'In', 26.10, 3.00, 2.10, 21.00, '2023-08-23 19:06:04', '2023-08-23 19:06:04', NULL, 'Pending', 'Job Created'),
(14, 6, NULL, 12, '76853', 'In', 26.10, 3.00, 2.10, 21.00, '2023-08-26 10:46:09', '2023-08-26 10:46:09', NULL, 'Pending', 'Job Created'),
(15, 6, NULL, 13, '19622', 'In', 26.10, 3.00, 2.10, 21.00, '2023-08-26 10:49:04', '2023-08-26 10:49:04', NULL, 'Pending', 'Job Created'),
(16, 6, NULL, 14, '91259', 'In', 26.10, 3.00, 2.10, 21.00, '2023-08-26 11:04:31', '2023-08-26 11:04:31', NULL, 'Pending', 'Job Created'),
(17, 3, NULL, 15, '71445', 'In', 26.10, 3.00, 2.10, 21.00, '2023-08-26 19:15:53', '2023-08-26 19:15:53', NULL, 'Pending', 'Job Created'),
(18, 6, NULL, 16, '20235', 'In', 26.55, 3.06, 2.14, 21.35, '2023-08-26 19:32:20', '2023-08-26 19:32:20', NULL, 'Pending', 'Job Created');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_list`
--
ALTER TABLE `chat_list`
  ADD PRIMARY KEY (`chat_list_id`);

--
-- Indexes for table `chat_list_live`
--
ALTER TABLE `chat_list_live`
  ADD PRIMARY KEY (`chat_list_live_id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`chat_message_id`);

--
-- Indexes for table `chat_messages_live`
--
ALTER TABLE `chat_messages_live`
  ADD PRIMARY KEY (`chat_messages_live_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`jobs_id`);

--
-- Indexes for table `jobs_ratings`
--
ALTER TABLE `jobs_ratings`
  ADD PRIMARY KEY (`jobs_ratings_id`);

--
-- Indexes for table `jobs_requests`
--
ALTER TABLE `jobs_requests`
  ADD PRIMARY KEY (`jobs_requests_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notifications_id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`system_settings_id`);

--
-- Indexes for table `users_customers`
--
ALTER TABLE `users_customers`
  ADD PRIMARY KEY (`users_customers_id`);

--
-- Indexes for table `users_customers_delete`
--
ALTER TABLE `users_customers_delete`
  ADD PRIMARY KEY (`users_customers_delete_id`);

--
-- Indexes for table `users_system`
--
ALTER TABLE `users_system`
  ADD PRIMARY KEY (`users_system_id`);

--
-- Indexes for table `users_system_roles`
--
ALTER TABLE `users_system_roles`
  ADD PRIMARY KEY (`users_system_roles_id`);

--
-- Indexes for table `wallet_txns`
--
ALTER TABLE `wallet_txns`
  ADD PRIMARY KEY (`wallet_txns_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_list`
--
ALTER TABLE `chat_list`
  MODIFY `chat_list_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chat_list_live`
--
ALTER TABLE `chat_list_live`
  MODIFY `chat_list_live_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `chat_messages_live`
--
ALTER TABLE `chat_messages_live`
  MODIFY `chat_messages_live_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `jobs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `jobs_ratings`
--
ALTER TABLE `jobs_ratings`
  MODIFY `jobs_ratings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs_requests`
--
ALTER TABLE `jobs_requests`
  MODIFY `jobs_requests_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notifications_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `system_settings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users_customers`
--
ALTER TABLE `users_customers`
  MODIFY `users_customers_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users_customers_delete`
--
ALTER TABLE `users_customers_delete`
  MODIFY `users_customers_delete_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_system`
--
ALTER TABLE `users_system`
  MODIFY `users_system_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_system_roles`
--
ALTER TABLE `users_system_roles`
  MODIFY `users_system_roles_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wallet_txns`
--
ALTER TABLE `wallet_txns`
  MODIFY `wallet_txns_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
