-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2026 at 02:39 PM
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
-- Database: `systemm`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `message`, `image`, `created_at`) VALUES
(22, 'System Maintenance Notice', 'The PWD Record Management System will be offline for a security update on Friday, May 24, 2026, from 8:00 AM to 12:00 PM PST. This is a crucial update to enhance the protection of user data privacy. We apologize for any inconvenience.', '1772773327_Gemini_Generated_Image_lqygqplqygqplqyg.png', '2026-03-06 05:02:07'),
(23, 'Annual PWD Livelihood Seminar', 'We are excited to announce our upcoming seminar: \"Developing Skills for the Future.\" This event is open to all registered PWDs in Iloilo City. It will be held at the City Hall Auditorium on June 15, 2026, starting at 9:00 AM. Refreshments will be provided. Please bring your PWD ID.', '1772773452_Gemini_Generated_Image_nk1gtvnk1gtvnk1g.png', '2026-03-06 05:04:12'),
(33, 'General Meeting', 'We will have a Meeting about our organization and election of officers. March 13, 2026 at E. B. Magalona Covered Court', '1773189190_images (8).jpg', '2026-03-11 00:33:10'),
(34, 'Christmas Party 2025', 'Good Day Everyone!! We will be having our year end party on Dec 20, 202t at Motorpool!!', '1773190434_vector-christmas-party-poster-design-template-christmas-related-ornaments-H97YR7.jpg', '2026-03-11 00:53:54'),
(35, 'yer end party', 'we will have a year end party tomorrow', '1773215501_images (9).jpg', '2026-03-11 07:51:41');

-- --------------------------------------------------------

--
-- Table structure for table `barangay`
--

CREATE TABLE `barangay` (
  `id` int(11) NOT NULL,
  `brgy_name` varchar(100) NOT NULL,
  `brgy_captain` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay`
--

INSERT INTO `barangay` (`id`, `brgy_name`, `brgy_captain`, `contact`) VALUES
(10, 'Alacaygan', 'John Doe', '09090909443'),
(15, 'Alicante', 'Angel Lim', '09958351754'),
(34, 'Poblacion', 'Fernando Poe', '09233345543'),
(35, 'Tomongtong', 'Bong Marcos', '09340244444');

-- --------------------------------------------------------

--
-- Table structure for table `disability_type`
--

CREATE TABLE `disability_type` (
  `id` int(11) NOT NULL,
  `disability_name` varchar(150) NOT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disability_type`
--

INSERT INTO `disability_type` (`id`, `disability_name`, `parent_id`) VALUES
(1, 'Deaf or Hard of Hearing', NULL),
(2, 'Intellectual Disability', NULL),
(3, 'Learning Disability', NULL),
(4, 'Mental Disability', NULL),
(5, 'Physical Disability (Orthopedic)', NULL),
(6, 'Psychosocial Disability', NULL),
(7, 'Speech and Language Impairment', NULL),
(8, 'Visual Disability', NULL),
(9, 'Cancer (RA11215)', NULL),
(10, 'Rare Disease (RA10747)', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `distribution_logs`
--

CREATE TABLE `distribution_logs` (
  `id` int(11) NOT NULL,
  `pwd_id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  `date_encoded` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `distribution_logs`
--

INSERT INTO `distribution_logs` (`id`, `pwd_id`, `barangay_id`, `program_name`, `remarks`, `date_encoded`) VALUES
(120, 94, 10, 'Free Medical Consultation and Check-up', 'free checkup', '2026-03-11 00:36:37'),
(121, 90, 10, 'Free Medical Consultation and Check-up', 'free checkup', '2026-03-11 00:36:37'),
(122, 91, 10, 'Free Medical Consultation and Check-up', 'free checkup', '2026-03-11 00:36:37'),
(123, 92, 15, 'Free Medical Consultation and Check-up', 'free checkup', '2026-03-11 00:36:37'),
(124, 93, 34, 'Free Medical Consultation and Check-up', 'free checkup', '2026-03-11 00:36:37'),
(125, 90, 10, ' PWD Inclusive Job Fair', 'Released from Barangay Request: ss', '2026-03-10 17:38:03'),
(126, 90, 10, 'Wheelchair', 'Released from Barangay Request: needy', '2026-03-10 17:38:37'),
(127, 94, 10, 'Scholarship Program', 'okay', '2026-03-11 07:54:16'),
(128, 91, 10, 'Free Medical Consultation and Check-up', 'Released from Barangay Request: need checkup', '2026-03-11 00:55:45');

-- --------------------------------------------------------

--
-- Table structure for table `myusers`
--

CREATE TABLE `myusers` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('super_admin','barangay_admin','doctor','pwd') NOT NULL DEFAULT 'barangay_admin',
  `barangay_id` int(11) DEFAULT NULL,
  `related_pwd_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `myusers`
--

INSERT INTO `myusers` (`user_id`, `full_name`, `email`, `password`, `role`, `barangay_id`, `related_pwd_id`, `created_at`) VALUES
(1, 'Super Admin', 'admin@gmail.com', 'admin123', 'super_admin', NULL, NULL, '2025-09-23 03:06:39'),
(9, 'John Doe', 'alacaygan@gmail.com', '$2y$10$paqgz32B9SNLs6SjDMYJ2.2T.b7/RWT2Hsb.VjyaM9jedzmFPEpvi', 'barangay_admin', 10, NULL, '2025-12-02 13:54:31'),
(14, 'Angel Lim', 'alicante@gmail.com', '$2y$10$iorPdlA6TWrtcWG.wj.N2O/TIguB4ufTvd2628KZJCInKwBovKveq', 'barangay_admin', 15, NULL, '2025-12-02 14:06:31'),
(17, 'John Doe', 'doctor@test.com', 'doctor123', 'doctor', NULL, NULL, '2026-01-26 02:57:09'),
(66, 'Sarah Labati', 'sarah@gmail.com', '$2y$10$hil/BOQdI3MAM9ZVftF56OZFEJ2D1u7fFDBtHUF.4XHyTOTX5K3.e', 'pwd', NULL, 90, '2026-03-10 23:28:30'),
(67, 'Jawe Arloma', 'poblacion@gmail.com', '$2y$10$P7kuBnq3pbx4Ybtu7Nx/e.nq6mklDe2VercaBIqmr3E7gYNtxT0LG', 'barangay_admin', 34, NULL, '2026-03-10 23:32:28'),
(68, 'Johnny Mesias', 'mesias@gmail.com', '$2y$10$EmRE44DzNkGC/DvaU8ERWugLWfL8f7xLAkM6PeMteSJzzUNxZXBF6', 'pwd', NULL, 91, '2026-03-10 23:46:01'),
(69, 'Kim Gonzaga', 'gonzaga@gmail.com', '$2y$10$72Kjj.O2umJb9xKiYeN8j..yYpoe535mokfrpj.1Jj/Dtr2LevwVO', 'pwd', NULL, 92, '2026-03-10 23:50:58'),
(70, 'Julia Aloha', 'aloha@gmail.com', '$2y$10$j0auwmh6Sbnq2.npG/06ruT773IWRRGdbNsGBIu.IRynUtOFX8d06', 'pwd', NULL, 94, '2026-03-11 00:00:24'),
(71, 'Erika Gavin', 'gavin@gmail.com', '$2y$10$WkbFaMURuSXvKqSNGF5uHe8gb8c/QeDJfiFUKd066PhFt5zK.ruwe', 'pwd', NULL, 93, '2026-03-11 00:00:29'),
(72, 'jake dungon', 'mark@mgg.com', '$2y$10$BzWfyFCotgddB49MscbNyOMduxbr6LDdWu7pt/ZoARfxfObDbbYt6', 'pwd', NULL, 98, '2026-03-11 08:01:19');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `event_date` date NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `event_date`, `image`, `created_at`) VALUES
(14, 'Monthly giving of  Allowance', 'Office of Municipal Social Welfare Development Office distributed a cash assistance worth 3,000 to every PWD benefeciary in the Municipality', '2026-03-05', '1772775518_images (1).jpg', '2026-03-06 05:38:38'),
(15, 'Giving of Wheel Chairs', 'The Province of Negros Occidental spearheaded by the Governor distrubuted a wheel chair to all PWDs who needs this devices in collaboration with the Office of the Mayor in EB Magalona', '2026-03-07', '1772775774_images (2).jpg', '2026-03-06 05:42:54'),
(20, 'Giving of Relief Goods', 'MSWDO together with the office of the Mayor distributed a relief goods to all the PWDs accross EB Magalona last March 11, 2026', '2026-03-11', '1773189284_15a2cef9169a749149bcc0a118e863be86add1d0.jpg', '2026-03-11 00:34:44'),
(21, 'Christmas Party', 'Last December 20, 2025, the MSWDO organized a year end party for PWD benefeciaries in the EB Magalona', '2025-12-20', '1773190543_images (9).jpg', '2026-03-11 00:55:43');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `barangay_id` int(11) DEFAULT NULL,
  `pwd_id` int(11) DEFAULT NULL,
  `user_type` enum('barangay','pwd','all') NOT NULL DEFAULT 'all',
  `message` text NOT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `read_by_admin` tinyint(1) DEFAULT 0,
  `read_by_brgy` tinyint(1) DEFAULT 0,
  `read_by_pwd` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `barangay_id`, `pwd_id`, `user_type`, `message`, `status`, `created_at`, `read_by_admin`, `read_by_brgy`, `read_by_pwd`) VALUES
(1, 10, NULL, 'barangay', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(2, 15, NULL, 'barangay', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(3, NULL, 40, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(4, NULL, 41, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(5, NULL, 42, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(6, NULL, 43, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(7, NULL, 44, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(8, NULL, 45, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(9, NULL, 46, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(10, NULL, 47, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(11, NULL, 48, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(12, NULL, 49, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(13, NULL, 54, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(14, NULL, 50, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(15, NULL, 52, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(16, NULL, 56, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(17, NULL, 53, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(18, NULL, 57, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(19, NULL, 55, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(20, NULL, 64, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(21, NULL, 59, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(22, NULL, 63, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(23, NULL, 75, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(24, NULL, 66, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(25, NULL, 82, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(26, NULL, 76, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(27, NULL, 60, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(28, NULL, 67, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(29, NULL, 61, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(30, NULL, 85, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(31, NULL, 86, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(32, NULL, 73, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(33, NULL, 74, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(34, NULL, 87, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(35, NULL, 84, 'pwd', 'MSWDO added new announcement: xxx', 'unread', '2026-03-10 23:27:01', 0, 0, 0),
(36, 10, NULL, 'barangay', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(37, 15, NULL, 'barangay', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(38, NULL, 40, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(39, NULL, 41, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(40, NULL, 42, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(41, NULL, 43, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(42, NULL, 44, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(43, NULL, 45, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(44, NULL, 46, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(45, NULL, 47, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(46, NULL, 48, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(47, NULL, 49, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(48, NULL, 54, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(49, NULL, 50, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(50, NULL, 52, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(51, NULL, 56, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(52, NULL, 53, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(53, NULL, 57, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(54, NULL, 55, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(55, NULL, 64, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(56, NULL, 59, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(57, NULL, 63, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(58, NULL, 75, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(59, NULL, 66, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(60, NULL, 82, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(61, NULL, 76, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(62, NULL, 60, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(63, NULL, 67, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(64, NULL, 61, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(65, NULL, 85, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(66, NULL, 86, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(67, NULL, 73, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(68, NULL, 74, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(69, NULL, 87, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(70, NULL, 84, 'pwd', 'MSWDO added new news: sss', 'unread', '2026-03-10 23:27:23', 0, 0, 0),
(71, 10, NULL, 'all', 'PWD application for Sarah Labati has been moved to Screening.', 'unread', '2026-03-10 23:27:54', 0, 0, 0),
(72, 10, NULL, 'all', 'Medical Assessment completed for Sarah Labati. Record is now Waiting for Approval.', 'unread', '2026-03-10 23:28:16', 0, 0, 0),
(73, 10, NULL, 'all', 'Registration Finalized: Sarah Labati. Login: sarah@gmail.com / Password: labatis2026', 'unread', '2026-03-10 23:28:30', 0, 0, 0),
(74, 10, NULL, 'all', 'New Service Request: Brgy. Alacaygan requested \' PWD Inclusive Job Fair\' for 1 PWDs.', 'unread', '2026-03-10 23:28:44', 1, 0, 0),
(75, 10, NULL, 'all', 'Barangay Application: Johnny Mesias has been submitted.', 'unread', '2026-03-10 23:37:57', 1, 0, 0),
(76, 10, NULL, 'all', 'PWD application for Johnny Mesias has been moved to Screening.', 'unread', '2026-03-10 23:38:24', 0, 0, 0),
(77, 10, NULL, 'all', 'Medical Assessment completed for Johnny Mesias. Record is now Waiting for Approval.', 'unread', '2026-03-10 23:45:39', 0, 0, 0),
(78, 10, NULL, 'all', 'Registration Finalized: Johnny Mesias. Login: mesias@gmail.com / Password: mesiasj2026', 'unread', '2026-03-10 23:46:01', 0, 0, 0),
(79, 15, NULL, 'all', 'New Application: Kim Gonzaga has been added to the system.', 'unread', '2026-03-10 23:49:46', 0, 0, 0),
(80, 15, NULL, 'all', 'PWD application for Kim Gonzaga has been moved to Screening.', 'unread', '2026-03-10 23:49:53', 0, 0, 0),
(81, 15, NULL, 'all', 'Medical Assessment completed for Kim Gonzaga. Record is now Waiting for Approval.', 'unread', '2026-03-10 23:50:36', 0, 0, 0),
(82, 15, NULL, 'all', 'Registration Finalized: Kim Gonzaga. Login: gonzaga@gmail.com / Password: gonzagak2026', 'unread', '2026-03-10 23:50:58', 0, 0, 0),
(83, 34, NULL, 'all', 'New Application: Erika Gavin has been added to the system.', 'unread', '2026-03-10 23:54:04', 0, 0, 0),
(84, 34, NULL, 'all', 'PWD application for Erika Gavin has been moved to Screening.', 'unread', '2026-03-10 23:54:09', 0, 0, 0),
(85, 34, NULL, 'all', 'Medical Assessment completed for Erika Gavin. Record is now Waiting for Approval.', 'unread', '2026-03-10 23:54:25', 0, 0, 0),
(86, 10, NULL, 'all', 'New Application: Julia Aloha has been added to the system.', 'unread', '2026-03-10 23:57:33', 0, 0, 0),
(87, 10, NULL, 'all', 'PWD application for Julia Aloha has been moved to Screening.', 'unread', '2026-03-10 23:57:38', 0, 0, 0),
(88, 10, NULL, 'all', 'Medical Assessment completed for Julia Aloha. Record is now Waiting for Approval.', 'unread', '2026-03-10 23:57:52', 0, 0, 0),
(89, 10, NULL, 'all', 'Registration Finalized: Julia Aloha. Login: aloha@gmail.com / Password: alohaj2026', 'unread', '2026-03-11 00:00:24', 0, 0, 0),
(90, 34, NULL, 'all', 'Registration Finalized: Erika Gavin. Login: gavin@gmail.com / Password: gavine2026', 'unread', '2026-03-11 00:00:29', 0, 0, 0),
(91, 10, NULL, 'all', 'New Application: Arnold Claves has been added to the system.', 'unread', '2026-03-11 00:23:43', 0, 0, 0),
(92, 10, NULL, 'all', 'New Application: Jenny Wendel has been added to the system.', 'unread', '2026-03-11 00:26:31', 0, 0, 0),
(93, 10, NULL, 'all', 'PWD application for Jenny Wendel has been moved to Screening.', 'unread', '2026-03-11 00:26:37', 0, 0, 0),
(94, 10, NULL, 'all', 'New Application: Edward Pagad has been added to the system.', 'unread', '2026-03-11 00:28:45', 0, 0, 0),
(95, 10, NULL, 'all', 'PWD application for Arnold Claves has been moved to Screening.', 'unread', '2026-03-11 00:28:49', 0, 0, 0),
(96, 10, NULL, 'all', 'Medical Assessment completed for Arnold Claves. Record is now Waiting for Approval.', 'unread', '2026-03-11 00:29:18', 1, 0, 0),
(97, 10, NULL, 'barangay', 'MSWDO added new announcement: General Meeting', 'unread', '2026-03-11 00:33:10', 0, 0, 0),
(98, 15, NULL, 'barangay', 'MSWDO added new announcement: General Meeting', 'unread', '2026-03-11 00:33:10', 0, 0, 0),
(99, 34, NULL, 'barangay', 'MSWDO added new announcement: General Meeting', 'unread', '2026-03-11 00:33:10', 0, 0, 0),
(100, NULL, 90, 'pwd', 'MSWDO added new announcement: General Meeting', 'unread', '2026-03-11 00:33:10', 0, 0, 0),
(101, NULL, 91, 'pwd', 'MSWDO added new announcement: General Meeting', 'unread', '2026-03-11 00:33:10', 0, 0, 0),
(102, NULL, 92, 'pwd', 'MSWDO added new announcement: General Meeting', 'unread', '2026-03-11 00:33:10', 0, 0, 0),
(103, NULL, 94, 'pwd', 'MSWDO added new announcement: General Meeting', 'unread', '2026-03-11 00:33:10', 0, 0, 0),
(104, NULL, 93, 'pwd', 'MSWDO added new announcement: General Meeting', 'unread', '2026-03-11 00:33:10', 0, 0, 0),
(105, 10, NULL, 'barangay', 'MSWDO added new news: Giving of Relief Goods', 'unread', '2026-03-11 00:34:44', 0, 0, 0),
(106, 15, NULL, 'barangay', 'MSWDO added new news: Giving of Relief Goods', 'unread', '2026-03-11 00:34:44', 0, 0, 0),
(107, 34, NULL, 'barangay', 'MSWDO added new news: Giving of Relief Goods', 'unread', '2026-03-11 00:34:44', 0, 0, 0),
(108, NULL, 90, 'pwd', 'MSWDO added new news: Giving of Relief Goods', 'unread', '2026-03-11 00:34:44', 0, 0, 0),
(109, NULL, 91, 'pwd', 'MSWDO added new news: Giving of Relief Goods', 'unread', '2026-03-11 00:34:44', 0, 0, 0),
(110, NULL, 92, 'pwd', 'MSWDO added new news: Giving of Relief Goods', 'unread', '2026-03-11 00:34:44', 0, 0, 0),
(111, NULL, 94, 'pwd', 'MSWDO added new news: Giving of Relief Goods', 'unread', '2026-03-11 00:34:44', 0, 0, 0),
(112, NULL, 93, 'pwd', 'MSWDO added new news: Giving of Relief Goods', 'unread', '2026-03-11 00:34:44', 0, 0, 0),
(113, 10, NULL, 'barangay', 'MSWDO added new services: Scholarship Program', 'unread', '2026-03-11 00:36:09', 0, 0, 0),
(114, 15, NULL, 'barangay', 'MSWDO added new services: Scholarship Program', 'unread', '2026-03-11 00:36:09', 0, 0, 0),
(115, 34, NULL, 'barangay', 'MSWDO added new services: Scholarship Program', 'unread', '2026-03-11 00:36:09', 0, 0, 0),
(116, NULL, 90, 'pwd', 'MSWDO added new services: Scholarship Program', 'unread', '2026-03-11 00:36:09', 0, 0, 0),
(117, NULL, 91, 'pwd', 'MSWDO added new services: Scholarship Program', 'unread', '2026-03-11 00:36:09', 0, 0, 0),
(118, NULL, 92, 'pwd', 'MSWDO added new services: Scholarship Program', 'unread', '2026-03-11 00:36:09', 0, 0, 0),
(119, NULL, 94, 'pwd', 'MSWDO added new services: Scholarship Program', 'unread', '2026-03-11 00:36:09', 0, 0, 0),
(120, NULL, 93, 'pwd', 'MSWDO added new services: Scholarship Program', 'unread', '2026-03-11 00:36:09', 0, 0, 0),
(121, 10, NULL, 'barangay', 'Your request for \' PWD Inclusive Job Fair\' has been Approved. Schedule: March 10 at cityhall.', 'unread', '2026-03-11 00:36:55', 1, 0, 0),
(122, 10, NULL, 'all', 'New Service Request: Brgy. Alacaygan requested \'Scholarship Program\' for 1 PWDs.', 'unread', '2026-03-11 00:37:24', 1, 0, 0),
(123, 10, NULL, 'all', 'New Service Request: Brgy. Alacaygan requested \'Free Medical Consultation and Check-up\' for 1 PWDs.', 'unread', '2026-03-11 00:37:41', 1, 0, 0),
(124, 10, NULL, 'all', 'New Service Request: Brgy. Alacaygan requested \'Wheelchair\' for 1 PWDs.', 'unread', '2026-03-11 00:38:20', 1, 0, 0),
(125, 10, NULL, 'barangay', 'Your request for \'Wheelchair\' has been Approved. Schedule: March 12, at ciyhall.', 'unread', '2026-03-11 00:38:34', 1, 0, 0),
(126, 10, NULL, 'barangay', 'MSWDO added new announcement: Christmas Party 2025', 'unread', '2026-03-11 00:53:54', 0, 0, 0),
(127, 15, NULL, 'barangay', 'MSWDO added new announcement: Christmas Party 2025', 'unread', '2026-03-11 00:53:54', 0, 0, 0),
(128, 34, NULL, 'barangay', 'MSWDO added new announcement: Christmas Party 2025', 'unread', '2026-03-11 00:53:54', 0, 0, 0),
(129, NULL, 90, 'pwd', 'MSWDO added new announcement: Christmas Party 2025', 'unread', '2026-03-11 00:53:54', 0, 0, 0),
(130, NULL, 91, 'pwd', 'MSWDO added new announcement: Christmas Party 2025', 'unread', '2026-03-11 00:53:54', 0, 0, 0),
(131, NULL, 92, 'pwd', 'MSWDO added new announcement: Christmas Party 2025', 'unread', '2026-03-11 00:53:54', 0, 0, 0),
(132, NULL, 94, 'pwd', 'MSWDO added new announcement: Christmas Party 2025', 'unread', '2026-03-11 00:53:54', 0, 0, 0),
(133, NULL, 93, 'pwd', 'MSWDO added new announcement: Christmas Party 2025', 'unread', '2026-03-11 00:53:54', 0, 0, 0),
(134, 10, NULL, 'barangay', 'MSWDO added new news: Christmas Party', 'unread', '2026-03-11 00:55:43', 0, 0, 0),
(135, 15, NULL, 'barangay', 'MSWDO added new news: Christmas Party', 'unread', '2026-03-11 00:55:43', 0, 0, 0),
(136, 34, NULL, 'barangay', 'MSWDO added new news: Christmas Party', 'unread', '2026-03-11 00:55:43', 0, 0, 0),
(137, NULL, 90, 'pwd', 'MSWDO added new news: Christmas Party', 'unread', '2026-03-11 00:55:43', 0, 0, 0),
(138, NULL, 91, 'pwd', 'MSWDO added new news: Christmas Party', 'unread', '2026-03-11 00:55:43', 0, 0, 0),
(139, NULL, 92, 'pwd', 'MSWDO added new news: Christmas Party', 'unread', '2026-03-11 00:55:43', 0, 0, 0),
(140, NULL, 94, 'pwd', 'MSWDO added new news: Christmas Party', 'unread', '2026-03-11 00:55:43', 0, 0, 0),
(141, NULL, 93, 'pwd', 'MSWDO added new news: Christmas Party', 'unread', '2026-03-11 00:55:43', 0, 0, 0),
(142, 10, NULL, 'barangay', 'MSWDO added new services: Tulong Hanap Buhay', 'unread', '2026-03-11 00:57:33', 0, 0, 0),
(143, 15, NULL, 'barangay', 'MSWDO added new services: Tulong Hanap Buhay', 'unread', '2026-03-11 00:57:33', 0, 0, 0),
(144, 34, NULL, 'barangay', 'MSWDO added new services: Tulong Hanap Buhay', 'unread', '2026-03-11 00:57:33', 0, 0, 0),
(145, NULL, 90, 'pwd', 'MSWDO added new services: Tulong Hanap Buhay', 'unread', '2026-03-11 00:57:33', 0, 0, 0),
(146, NULL, 91, 'pwd', 'MSWDO added new services: Tulong Hanap Buhay', 'unread', '2026-03-11 00:57:33', 0, 0, 0),
(147, NULL, 92, 'pwd', 'MSWDO added new services: Tulong Hanap Buhay', 'unread', '2026-03-11 00:57:33', 0, 0, 0),
(148, NULL, 94, 'pwd', 'MSWDO added new services: Tulong Hanap Buhay', 'unread', '2026-03-11 00:57:33', 0, 0, 0),
(149, NULL, 93, 'pwd', 'MSWDO added new services: Tulong Hanap Buhay', 'unread', '2026-03-11 00:57:33', 0, 0, 0),
(150, 10, NULL, 'all', 'PWD application for Edward Pagad has been moved to Screening.', 'unread', '2026-03-11 06:07:59', 1, 0, 0),
(151, 10, NULL, 'all', 'Medical Assessment completed for Edward Pagad. Record is now Waiting for Approval.', 'unread', '2026-03-11 06:08:46', 1, 0, 0),
(152, 10, NULL, 'barangay', 'MSWDO added new announcement: yer end party', 'unread', '2026-03-11 07:51:41', 0, 0, 0),
(153, 15, NULL, 'barangay', 'MSWDO added new announcement: yer end party', 'unread', '2026-03-11 07:51:41', 0, 0, 0),
(154, 34, NULL, 'barangay', 'MSWDO added new announcement: yer end party', 'unread', '2026-03-11 07:51:41', 0, 0, 0),
(155, NULL, 90, 'pwd', 'MSWDO added new announcement: yer end party', 'unread', '2026-03-11 07:51:41', 0, 0, 0),
(156, NULL, 91, 'pwd', 'MSWDO added new announcement: yer end party', 'unread', '2026-03-11 07:51:41', 0, 0, 0),
(157, NULL, 92, 'pwd', 'MSWDO added new announcement: yer end party', 'unread', '2026-03-11 07:51:41', 0, 0, 0),
(158, NULL, 94, 'pwd', 'MSWDO added new announcement: yer end party', 'unread', '2026-03-11 07:51:41', 0, 0, 0),
(159, NULL, 93, 'pwd', 'MSWDO added new announcement: yer end party', 'unread', '2026-03-11 07:51:41', 0, 0, 0),
(160, 10, NULL, 'barangay', 'Your request for \'Free Medical Consultation and Check-up\' has been Approved. Schedule: tom 10 am.', 'unread', '2026-03-11 07:55:35', 1, 1, 0),
(161, 10, NULL, 'all', 'New Application: jake dungon has been added to the system.', 'unread', '2026-03-11 07:59:15', 1, 0, 0),
(162, 10, NULL, 'all', 'PWD application for jake dungon has been moved to Screening.', 'unread', '2026-03-11 07:59:35', 1, 0, 0),
(163, 10, NULL, 'all', 'Medical Assessment completed for jake dungon. Record is now Waiting for Approval.', 'unread', '2026-03-11 08:00:25', 1, 0, 0),
(164, 10, NULL, 'all', 'Registration Finalized: jake dungon. Login: mark@mgg.com / Password: dungonj2026', 'unread', '2026-03-11 08:01:19', 1, 0, 0),
(165, 10, NULL, 'all', 'New Service Request: Brgy. Alacaygan requested \'Scholarship Program\' for 1 PWDs.', 'unread', '2026-03-11 08:04:51', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pwd`
--

CREATE TABLE `pwd` (
  `id` int(11) NOT NULL,
  `new_applicant_or_renewal` enum('New','Renewal') DEFAULT NULL,
  `pwd_number` varchar(50) DEFAULT NULL,
  `barangay_id` int(11) NOT NULL,
  `date_applied` date NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `suffix` varchar(20) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `civil_status` enum('Single','Married','Widowed','Separated','Cohabitation') NOT NULL,
  `disability_type` int(11) NOT NULL,
  `disability_cause` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `municipality` varchar(100) DEFAULT 'EB Magalona',
  `province` varchar(100) DEFAULT 'Negros Occidental',
  `region` varchar(100) DEFAULT 'Region VI',
  `contact_number` varchar(20) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `education` enum('None','Kindergarten','Elementary','Junior High School','Senior High School','College','Vocational','Post Graduate') DEFAULT NULL,
  `employment_status` enum('Employed','Unemployed','Self-employed') DEFAULT NULL,
  `occupation` varchar(150) DEFAULT NULL,
  `organization_name` varchar(255) DEFAULT NULL,
  `organization_contact_person` varchar(255) DEFAULT NULL,
  `organization_contact_number` varchar(50) DEFAULT NULL,
  `sss_no` varchar(50) DEFAULT NULL,
  `gsis_no` varchar(50) DEFAULT NULL,
  `pagibig_no` varchar(50) DEFAULT NULL,
  `psn_no` varchar(50) DEFAULT NULL,
  `philhealth_no` varchar(50) DEFAULT NULL,
  `father_lastname` varchar(100) DEFAULT NULL,
  `father_firstname` varchar(100) DEFAULT NULL,
  `father_middlename` varchar(100) DEFAULT NULL,
  `mother_lastname` varchar(100) DEFAULT NULL,
  `mother_firstname` varchar(100) DEFAULT NULL,
  `mother_middlename` varchar(100) DEFAULT NULL,
  `guardian_lastname` varchar(100) DEFAULT NULL,
  `guardian_firstname` varchar(100) DEFAULT NULL,
  `guardian_middlename` varchar(100) DEFAULT NULL,
  `accomplished_by_type` enum('Applicant','Guardian','Representative') DEFAULT 'Applicant',
  `acc_lastname` varchar(100) DEFAULT NULL,
  `acc_firstname` varchar(100) DEFAULT NULL,
  `acc_middlename` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Screening','For Approval','Official') DEFAULT 'Pending',
  `diagnosis` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_at` date DEFAULT NULL,
  `physician_name` varchar(150) DEFAULT NULL,
  `physician_license` varchar(50) DEFAULT NULL,
  `screening_officer` varchar(100) DEFAULT NULL,
  `functional_assessments` text DEFAULT NULL,
  `assistive_devices` text DEFAULT NULL,
  `motor_disability` text DEFAULT NULL,
  `visual_impairment` text DEFAULT NULL,
  `hearing_impairment` text DEFAULT NULL,
  `speech_impairment` text DEFAULT NULL,
  `mental_impairment` text DEFAULT NULL,
  `deformity_details` text DEFAULT NULL,
  `assessment_etiology` varchar(255) DEFAULT NULL,
  `etiology_details` varchar(255) DEFAULT NULL,
  `assistive_devices_other` varchar(255) DEFAULT NULL,
  `physician_ptr` varchar(50) DEFAULT NULL,
  `validated_by_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pwd`
--

INSERT INTO `pwd` (`id`, `new_applicant_or_renewal`, `pwd_number`, `barangay_id`, `date_applied`, `last_name`, `first_name`, `middle_name`, `suffix`, `birth_date`, `gender`, `civil_status`, `disability_type`, `disability_cause`, `address`, `municipality`, `province`, `region`, `contact_number`, `email`, `education`, `employment_status`, `occupation`, `organization_name`, `organization_contact_person`, `organization_contact_number`, `sss_no`, `gsis_no`, `pagibig_no`, `psn_no`, `philhealth_no`, `father_lastname`, `father_firstname`, `father_middlename`, `mother_lastname`, `mother_firstname`, `mother_middlename`, `guardian_lastname`, `guardian_firstname`, `guardian_middlename`, `accomplished_by_type`, `acc_lastname`, `acc_firstname`, `acc_middlename`, `photo`, `profile_picture`, `status`, `diagnosis`, `created_at`, `approved_at`, `physician_name`, `physician_license`, `screening_officer`, `functional_assessments`, `assistive_devices`, `motor_disability`, `visual_impairment`, `hearing_impairment`, `speech_impairment`, `mental_impairment`, `deformity_details`, `assessment_etiology`, `etiology_details`, `assistive_devices_other`, `physician_ptr`, `validated_by_id`) VALUES
(90, 'New', '', 10, '2026-03-11', 'Labati', 'Sarah', 'Mesa', '', '1980-02-25', 'Female', 'Married', 5, 'Injury', 'Hda. Dos', 'EB Magalona', 'Negros Occidental', 'Region VI', '09958357194', 'sarah@gmail.com', 'Senior High School', 'Self-employed', 'housewife', 'N/A', 'N/A', 'N/A', '0938-283', '123-045', '84-3440', '129-204', '93039-1', 'Labati', 'John', 'Macs', 'Mesa', 'Ana', 'Delmo', 'Mesa', 'Ana', 'Delmo', 'Guardian', 'Mesa', 'Ana', 'Delmo', '1773184140_69b0a48ca7f3b.jpg', NULL, 'Official', 'sss', '2026-03-10 23:09:00', NULL, 'albert magante', 'ss', NULL, '024 Polio', 'None', 'Epilepsy', 'None', 'None', 'None', 'None', 'None', 'N/A', '', '', 's', 17),
(91, 'New', '', 10, '2026-03-08', 'Mesias', 'Johnny', 'Mendoza', '', '1970-05-23', 'Male', 'Widowed', 4, 'ADHD', 'hda binanlutan', 'EB Magalona', 'Negros Occidental', 'Region VI', '0382284932244', 'mesias@gmail.com', 'Junior High School', 'Self-employed', 'Farmer', 'N/A', 'N/A', 'N/A', '01284-234', 'N/A', 'N/A', 'N/A', '0839-2922', 'Mesias', 'Argie', 'Magiba', 'Mendoza', 'Annie', 'Colora', 'Mesias', 'Argie', 'Argie', 'Representative', 'Osorio', 'Ronnie', 'Magapo', 'BRGY_1773185877_69b0ab557974b.jpg', NULL, 'Official', 'Approved', '2026-03-10 23:37:57', NULL, 'Noel b. aragon', '1293', NULL, 'None', 'None', 'None', 'None', 'None', 'None', 'Mentally Retarded', 'None', 'N/A', '', '', '0283', 17),
(92, 'Renewal', '28394-29144-1834', 15, '2026-03-01', 'Gonzaga', 'Kim', 'Oro', '', '2003-12-28', 'Male', 'Single', 8, 'Cerebral Palsy (Congenital)', 'hda binanlutan', 'EB Magalona', 'Negros Occidental', 'Region VI', '0292930421', 'gonzaga@gmail.com', 'College', 'Employed', 'Call Center Agent', 'The Group of Agriculture', 'Johnny Poe', '3832834', '028474', '8330', '0227303', '9374', '02844', 'Gonazaga', 'Armando', 'Manto', 'Oro', 'Kyla', 'Desi', 'Gonazaga', 'Armando', 'Manto', 'Applicant', 'Gonzaga', 'Kim', 'Oro', '1773186586_69b0ae1a8633b.jpg', NULL, 'Official', 'need Wheelchair', '2026-03-10 23:49:46', NULL, 'Noel b. aragon', '1293', NULL, 'None', 'Wheelchair', 'None', 'Total visual left', 'None', 'None', 'None', 'None', 'N/A', '', '', '0283', 17),
(93, 'New', '', 34, '2026-03-11', 'Gavin', 'Erika', 'Yap', '', '1978-12-11', 'Female', 'Married', 7, 'Cerebral Palsy (Congenital)', 'Hda. dimagiba', 'EB Magalona', 'Negros Occidental', 'Region VI', '092084533', 'gavin@gmail.com', 'Senior High School', 'Employed', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Gavin', 'Rene', 'Blanco', 'Yap', 'Alma', 'Borado', 'Yap', 'Alma', 'Borado', 'Guardian', 'Yap', 'Alma', 'Borado', '1773186844_69b0af1c489a6.jpg', NULL, 'Official', 'Okay', '2026-03-10 23:54:04', NULL, 'Noel b. aragon', '1293', NULL, 'None', 'None', 'None', 'None', 'None', 'Total speech impairment', 'None', 'None', 'N/A', '', '', '0283', 17),
(94, 'New', '', 10, '2026-03-10', 'Aloha', 'Julia', 'Daniel', '', '1990-03-15', 'Female', 'Married', 4, 'Autism', 'hda tres', 'EB Magalona', 'Negros Occidental', 'Region VI', '099188225444', 'aloha@gmail.com', 'None', 'Employed', 'Housewife', 'N/A', 'N/A', 'N/A', '039822', '038492', '028483', '03822', '02843', 'Aloha', 'Ajay', 'Venyl', 'Daniel', 'Marina', 'Summers', 'Aloha', 'Ajay', 'Venyl', 'Applicant', 'Aloha', 'Julia', 'Daniel', '1773187053_69b0afed4f620.webp', NULL, 'Official', 'okay', '2026-03-10 23:57:33', NULL, 'Noel b. aragon', '1293', NULL, 'None', 'None', 'None', 'None', 'None', 'None', 'Autistic', 'None', 'N/A', '', '', '0283', 17),
(95, 'New', '', 10, '2026-03-11', 'Claves', 'Arnold', 'Opane', '', '1990-12-23', 'Male', 'Separated', 3, 'Cerebral Palsy (Congenital)', 'Hda. Banilad', 'EB Magalona', 'Negros Occidental', 'Region VI', '0924804821', 'claves@gmail.com', 'Elementary', 'Employed', 'Farmer', 'N/A', 'N/A', 'N/A', '64532', 'N/A', 'N/A', 'N/A', '66468643', 'Claves', 'Roland', 'Mendez', 'Opane', 'Maria', 'Pantela', 'Claves', 'Roland', 'Mendez', 'Guardian', 'Claves', 'Roland', 'Mendez', '1773188623_69b0b60f1722d.webp', NULL, 'For Approval', 'okayed', '2026-03-11 00:23:43', NULL, 'Noel b. aragon', '1293', NULL, 'None', 'None', 'None', 'None', 'None', 'None', 'Autistic', 'None', 'N/A', '', '', '0283', 17),
(96, 'New', '', 10, '2026-03-10', 'Wendel', 'Jenny', 'Ocampo', '', '1993-03-07', 'Female', 'Married', 3, 'Autism', 'Hda estaquince', 'EB Magalona', 'Negros Occidental', 'Region VI', '09581920194', 'wendeyl@gmail.com', 'None', 'Employed', 'Housewife', 'N/A', 'N/A', 'N/A', '038282', 'N/A', 'N/A', 'N/A', '028472', 'Wendel', 'Jesriel', 'Ramos', 'Ocampo', 'Serna', 'Tanepo', 'Ocampo', 'Serna', 'Tanepo', 'Applicant', 'Wendel', 'Jenny', 'Ocampo', '1773188791_69b0b6b7c4c35.jpg', NULL, 'Screening', NULL, '2026-03-11 00:26:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(97, 'New', '', 10, '2026-03-10', 'Pagad', 'Edward', 'Burlas', '', '2000-09-18', 'Male', 'Single', 7, 'Cerebral Palsy (Congenital)', 'Hda. Estaquince ', 'EB Magalona', 'Negros Occidental', 'Region VI', '095681043', 'pagad@gmail.com', 'Elementary', 'Employed', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Pagad', 'Rene', 'Taton', 'Burlas', 'Mia', 'Ramores', 'Burlas', 'Mia', 'Ramores', 'Guardian', 'Burlas', 'Mia', 'Ramores', '1773188925_69b0b73dbc609.jpeg', NULL, 'For Approval', 'okay', '2026-03-11 00:28:45', NULL, 'Noel b. aragon', '1293', NULL, '001 Weak, paralyzed left leg', 'None', 'Arthritis', 'None', 'None', 'None', 'None', 'None', 'N/A', '', '', '0283', 17),
(98, 'New', '', 10, '2026-03-11', 'dungon', 'jake', 'ndnd', '', '2003-12-28', 'Male', 'Single', 3, 'Autism', 'fjff', 'EB Magalona', 'Negros Occidental', 'Region VI', '0596', 'mark@mgg.com', 'None', 'Employed', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Applicant', '', '', '', '', NULL, 'Official', 'b', '2026-03-11 07:59:15', NULL, 'Noel b. aragon', '1293', NULL, '016 Underdeveloped right arm', 'None', 'None', 'None', 'None', 'None', 'None', 'Hunchback', 'N/A', '', '', '0283', 17);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `provider` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `schedule` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `category`, `status`, `provider`, `description`, `location`, `contact`, `schedule`, `created_at`) VALUES
(9, 'Free Medical Consultation and Check-up', 'Healthcare', 'Active', 'City Health Office (CHO)', 'Monthly medical missions providing free general check-ups, blood pressure monitoring, and basic medicine for all registered PWDs in the community.', 'City Health Center, Brgy. 2', '(033) 123-4567', 'Every 1st and 3rd Monday of the Month, 8:00 AM – 12:00 PM', '2026-03-06 05:33:59'),
(10, ' PWD Inclusive Job Fair', 'Livelihood', 'Active', 'Province of Negros Occidental', 'Join us for the annual PWD Job Fair! This event features top employers committed to inclusive hiring practices. On-site application assistance, resume reviewing, and interview coaching will be available. Open to all skilled Persons with Disabilities. Please bring your valid PWD ID and multiple copies of your resume. Pre-registration is encouraged.', 'Pavillion', '0444', 'Every Monday, 1 PM', '2026-03-06 05:35:58'),
(18, 'Scholarship Program', 'Education', 'Active', 'NOSP', 'The office of the Governor are providing a scholarship for those PWD who are still schooling', 'Bacolod City', 'Miss Errah', 'Monday-Friday, 8-5 PM', '2026-03-11 00:36:09'),
(19, 'Tulong Hanap Buhay', 'Livelihood', 'Active', 'Department Of Agriculture', 'The office of the Agriculture provides a service exclusively for PWDs in the EB Magalona, They will provide an animals that will help the PWD earn money', 'EB Magalona', 'Sir Jerry', 'Sunday, 8 AM', '2026-03-11 00:57:33');

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

CREATE TABLE `service_requests` (
  `id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `pwd_id` int(11) NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  `status` enum('Pending','Approved','Completed','Cancelled') DEFAULT 'Pending',
  `schedule_date` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_requests`
--

INSERT INTO `service_requests` (`id`, `barangay_id`, `pwd_id`, `service_type`, `remarks`, `status`, `schedule_date`, `created_at`) VALUES
(114, 10, 90, ' PWD Inclusive Job Fair', 'ss', '', 'March 10 at cityhall', '2026-03-10 23:28:44'),
(115, 10, 94, 'Scholarship Program', 'college students', 'Pending', NULL, '2026-03-11 00:37:24'),
(116, 10, 91, 'Free Medical Consultation and Check-up', 'need checkup', '', 'tom 10 am', '2026-03-11 00:37:41'),
(117, 10, 90, 'Wheelchair', 'needy', '', 'March 12, at ciyhall', '2026-03-11 00:38:20'),
(118, 10, 98, 'Scholarship Program', 'jj', 'Pending', NULL, '2026-03-11 08:04:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barangay`
--
ALTER TABLE `barangay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `disability_type`
--
ALTER TABLE `disability_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `distribution_logs`
--
ALTER TABLE `distribution_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `myusers`
--
ALTER TABLE `myusers`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`email`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangay_id` (`barangay_id`),
  ADD KEY `pwd_id` (`pwd_id`);

--
-- Indexes for table `pwd`
--
ALTER TABLE `pwd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangay_id` (`barangay_id`),
  ADD KEY `disability_type` (`disability_type`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pwd_id` (`pwd_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `barangay`
--
ALTER TABLE `barangay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `disability_type`
--
ALTER TABLE `disability_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `distribution_logs`
--
ALTER TABLE `distribution_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `myusers`
--
ALTER TABLE `myusers`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `pwd`
--
ALTER TABLE `pwd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pwd`
--
ALTER TABLE `pwd`
  ADD CONSTRAINT `pwd_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangay` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pwd_ibfk_2` FOREIGN KEY (`disability_type`) REFERENCES `disability_type` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD CONSTRAINT `service_requests_ibfk_1` FOREIGN KEY (`pwd_id`) REFERENCES `pwd` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
