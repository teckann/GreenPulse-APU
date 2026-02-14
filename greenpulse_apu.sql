-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2026 at 03:34 AM
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
-- Database: `greenpulse_apu`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `announcement_id` varchar(8) NOT NULL,
  `user_id` varchar(8) NOT NULL,
  `announcement_details` varchar(255) NOT NULL,
  `announcement_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announcement_id`, `user_id`, `announcement_details`, `announcement_datetime`) VALUES
('A001', 'U001', 'New Feature Released', '2025-12-23 22:04:14'),
('A002', 'U001', 'Start collecting points and level up from Rising Talent to Master Legend!', '2026-02-02 01:28:53');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `event_id` varchar(8) NOT NULL,
  `user_id` varchar(8) NOT NULL,
  `event_register_datetime` datetime NOT NULL,
  `attendance_status` varchar(50) NOT NULL DEFAULT 'Absent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`event_id`, `user_id`, `event_register_datetime`, `attendance_status`) VALUES
('E001', 'U005', '2026-01-10 12:38:03', 'Present'),
('E001', 'U006', '2026-01-30 17:38:03', 'Present'),
('E001', 'U007', '2026-01-12 09:21:35', 'Absent'),
('E001', 'U009', '2026-01-12 14:39:42', 'Present'),
('E001', 'U010', '2026-01-14 17:39:42', 'Present'),
('E001', 'U014', '2026-01-16 21:29:42', 'Present'),
('E001', 'U017', '2026-01-17 14:19:42', 'Absent'),
('E002', 'U004', '2026-01-25 13:47:22', 'Absent'),
('E002', 'U006', '2026-01-25 13:22:42', 'Absent'),
('E002', 'U007', '2026-01-25 17:49:39', 'Absent'),
('E002', 'U008', '2026-01-26 09:19:22', 'Absent'),
('E002', 'U009', '2026-01-26 09:49:39', 'Absent'),
('E002', 'U012', '2026-01-27 06:13:44', 'Absent'),
('E002', 'U015', '2026-01-27 10:30:59', 'Absent'),
('E002', 'U017', '2026-01-28 17:50:59', 'Absent'),
('E002', 'U018', '2026-01-28 20:46:19', 'Absent'),
('E003', 'U005', '2026-01-30 17:52:45', 'Absent'),
('E004', 'U004', '2025-12-10 09:23:18', 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `badges`
--

CREATE TABLE `badges` (
  `badge_id` varchar(8) NOT NULL,
  `badge_name` varchar(50) NOT NULL,
  `badge_image` varchar(255) NOT NULL,
  `points_required` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `badges`
--

INSERT INTO `badges` (`badge_id`, `badge_name`, `badge_image`, `points_required`) VALUES
('B001', 'Rising Star', 'src/badgeImages/U001_badge_1768930255.png', 500),
('B002', 'Top Contributor', 'src/badgeImages/02_topContributor_badge.png', 1500),
('B003', 'Pro Achiever', 'src/badgeImages/03_proAchiever_badge.png', 3000),
('B004', 'Elite Performer', 'src/badgeImages/04_elitePerformer_badge.png', 5000),
('B005', 'Master Legend', 'src/badgeImages/U001_badge_1769787375.png', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `contact_submission`
--

CREATE TABLE `contact_submission` (
  `submission_id` varchar(8) NOT NULL,
  `user_id` varchar(8) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  `contact_number` varchar(12) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `content` varchar(255) NOT NULL,
  `submission_datetime` datetime NOT NULL,
  `submission_status` varchar(50) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_submission`
--

INSERT INTO `contact_submission` (`submission_id`, `user_id`, `full_name`, `email_address`, `contact_number`, `subject`, `content`, `submission_datetime`, `submission_status`) VALUES
('S001', NULL, 'Marcus Tan', 'marcus0101@gmail.com', '0123456789', 'Account Registration', 'Is it only APU students who can register an account?', '2025-12-23 22:08:42', 'Complete'),
('S002', 'U004', 'Lim Jin Ming', 'TP083424@mail.apu.edu.my', '0129692700', 'Green Points & Rewards', 'Why did I register for an event but not receive the corresponding Green Points?', '2026-01-19 23:25:08', 'Complete'),
('S003', NULL, 'Jeremiah Lim', 'jeremiah1101@gmail.com', '0123516782', 'Join the Committee', 'Im a second year diploma student at APU. I would like to join the committee. How do I apply?', '2026-01-27 00:06:52', 'Complete'),
('S004', NULL, 'Grace Tan', 'grace.tan@ecotech.com.my', '0123678912', 'Partnership & Collaboration', 'Our team is planning a community green awareness event and would like to invite your organization to collaborate as a partner. We hope to discuss possible sponsorship or joint program involvement.', '2026-01-30 21:17:25', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` varchar(8) NOT NULL,
  `user_id` varchar(8) NOT NULL,
  `event_title` varchar(100) NOT NULL,
  `event_poster` varchar(255) NOT NULL,
  `event_description` varchar(255) NOT NULL,
  `event_datetime` datetime NOT NULL,
  `duration` varchar(50) NOT NULL,
  `location` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL,
  `points_given` int(11) NOT NULL,
  `posted_date` date NOT NULL,
  `event_status` varchar(50) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `user_id`, `event_title`, `event_poster`, `event_description`, `event_datetime`, `duration`, `location`, `capacity`, `points_given`, `posted_date`, `event_status`) VALUES
('E001', 'U003', 'Green Innovation Talk', 'src/eventPosters/Green Innovation Talk.png', 'An informative talk exploring green technologies and innovative solutions that support environmental sustainability.', '2026-02-20 14:00:00', '2h 30m', 'S-08-02 | APU Campus', 50, 350, '2025-12-09', 'Active'),
('E002', 'U003', 'Go Green 3.0', 'src/eventPosters/Go Green 3.0.png', 'An annual green initiative promoting environmental awareness and its role in encouraging sustainable and eco-friendly practices.', '2026-02-09 17:00:00', '3h 45m', 'Auditorium 1 @ Level 7 | APU Campus', 75, 500, '2026-01-25', 'Active'),
('E003', 'U003', 'Sustainable Living Workshop', 'src/eventPosters/Sustainable Living Workshop.png', 'An interactive workshop focused on practical sustainable living habits and environmentally friendly daily practices.', '2026-02-10 12:30:00', '2h 30m', 'E-08-03 | APU Campus', 45, 480, '2026-01-28', 'Active'),
('E004', 'U002', 'Climate Action Session', 'src/eventPosters/Climate Action Session.png', 'An engaging session aimed at raising awareness of climate change and encouraging responsible environmental actions.', '2026-02-07 13:00:00', '1h 30m', 'Auditorium 5 @ Level 3 | APU Campus', 40, 550, '2026-02-04', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` varchar(8) NOT NULL,
  `event_id` varchar(8) NOT NULL,
  `user_id` varchar(8) NOT NULL,
  `feedback_details` varchar(255) NOT NULL,
  `submit_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `event_id`, `user_id`, `feedback_details`, `submit_datetime`) VALUES
('F001', 'E001', 'U004', 'The event was very well organized and informative. The speakers explained the topics clearly and the activities were engaging. I learned a lot and would be happy to join similar events again.', '2026-01-20 12:32:11'),
('F002', 'E001', 'U005', 'Overall a great experience. The schedule was smooth and the facilitators were helpful and friendly. It would be even better if there were more interactive sessions.', '2026-01-21 18:30:20'),
('F003', 'E001', 'U006', 'I really enjoyed the event and the practical demonstrations. The content was useful and relevant. The venue setup and time management were also well handled.', '2026-01-21 18:32:06'),
('F004', 'E001', 'U009', 'The event was good and educational. The sharing sessions were interesting, but I think adding more hands-on activities would make it more impactful.', '2026-01-21 20:12:06'),
('F005', 'E001', 'U014', 'Very meaningful event with clear objectives and good coordination. I gained new knowledge and appreciated the effort from the organizing team. Looking forward to future events.', '2026-01-22 18:32:06');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` varchar(8) NOT NULL,
  `user_id` varchar(8) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_image` varchar(255) NOT NULL,
  `item_description` varchar(255) NOT NULL,
  `item_redeem_points` int(11) NOT NULL,
  `item_stock` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `posted_date` date NOT NULL,
  `item_status` varchar(50) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `user_id`, `item_name`, `item_image`, `item_description`, `item_redeem_points`, `item_stock`, `category`, `posted_date`, `item_status`) VALUES
('I001', 'U003', 'GreenPulse T-Shirt', 'src/itemImages/t-shirt.png', 'A GreenPulse branded T-shirt supporting green initiatives and environmental awareness. Available in sizes M, L, XL, and XXL for a comfortable fit.', 6000, 49, 'merchandise', '2026-01-01', 'Active'),
('I002', 'U002', 'GreenPulse Canvas Bag', 'src/itemImages/canvasBag.png', 'Reusable GreenPulse canvas bag created to encourage eco-friendly practices and reduce single-use plastic.', 4500, 60, 'merchandise', '2026-01-21', 'Active'),
('I003', 'U002', 'GreenPulse Keychain', 'src/itemImages/keychain.png', 'Official GreenPulse merchandise designed to promote sustainability and environmental awareness in everyday use.', 600, 120, 'merchandise', '2026-01-21', 'Active'),
('I004', 'U002', 'GreenPulse Card Holder', 'src/itemImages/cardHolder.png', 'Practical GreenPulse card holder designed for daily convenience while representing the GreenPulse platform.', 1000, 180, 'merchandise', '2026-01-21', 'Inactive'),
('I005', 'U002', 'Frangipani Tree', 'src/itemImages/frangipaniTree.png', 'A popular ornamental tree in Malaysia, admired for its fragrant flowers and elegant appearance, commonly planted in parks and gardens.', 2500, 26, 'tree', '2026-01-21', 'Active'),
('I006', 'U003', 'Yellow Flame Tree', 'src/itemImages/yellowFlameTree.png', 'A beautiful flowering tree widely used in Malaysian landscapes, known for its bright yellow blooms and strong visual impact.', 2300, 15, 'tree', '2026-01-22', 'Active'),
('I007', 'U003', 'Rain Tree', 'src/itemImages/rainTree.png', 'A large and visually impressive shade tree with a wide canopy, commonly used in parks and open areas for its scenic appeal.', 2750, 10, 'tree', '2026-01-22', 'Active'),
('I008', 'U002', 'Royal Palm', 'src/itemImages/royalPalm.png', 'A tall and elegant palm tree frequently used in Malaysian landscaping, creating a clean and prestigious visual effect.', 1790, 27, 'tree', '2026-01-22', 'Active'),
('I009', 'U002', 'Bougainvillea Tree', 'src/itemImages/bougainvilleaTree.png', 'A vibrant ornamental plant commonly found in Malaysia, valued for its colorful flowers and decorative landscaping use.', 3000, 6, 'tree', '2026-01-22', 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `log_id` varchar(8) NOT NULL,
  `user_id` varchar(8) NOT NULL,
  `log_event` varchar(255) NOT NULL,
  `log_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`log_id`, `user_id`, `log_event`, `log_datetime`) VALUES
('L001', 'U001', 'Successful Login', '2026-01-19 09:42:46'),
('L002', 'U001', 'Change Module Status (M004)', '2026-01-19 09:45:50'),
('L003', 'U001', 'Update Profile Information (U001)', '2026-01-19 09:47:12'),
('L004', 'U002', 'Successful Login', '2026-01-19 09:48:19'),
('L005', 'U001', 'Successful Logout', '2026-01-19 09:48:50'),
('L006', 'U002', 'Delete Item (I004)', '2026-01-19 09:50:44'),
('L007', 'U002', 'Successful Logout', '2026-01-19 09:56:12'),
('L008', 'U004', 'Successful Login', '2026-01-26 18:44:17'),
('L009', 'U004', 'Update Password (U004)', '2026-01-26 18:46:17'),
('L010', 'U004', 'Successful Logout', '2026-01-26 18:49:45'),
('L011', 'U006', 'Successful Login', '2026-01-30 18:52:54'),
('L012', 'U008', 'Successful Login', '2026-01-30 18:56:12'),
('L013', 'U008', 'Successful Logout', '2026-01-30 19:05:01'),
('L014', 'U001', 'Successful Login', '2026-01-30 19:05:08'),
('L015', 'U001', 'Complete Contact Submission (S002)', '2026-01-30 19:07:21'),
('L016', 'U001', 'Complete Contact Submission (S003)', '2026-01-30 19:07:24'),
('L017', 'U001', 'Successful Logout', '2026-01-30 19:18:12'),
('L018', 'U001', 'Successful Login', '2026-01-30 19:18:28'),
('L019', 'U001', 'Change User Status (U006)', '2026-01-30 19:21:58'),
('L020', 'U001', 'Change User Status (U007)', '2026-01-30 19:22:01'),
('L021', 'U001', 'Change Event Status (E004)', '2026-01-30 19:23:41'),
('L022', 'U001', 'Successful Logout', '2026-01-30 19:37:01'),
('L023', 'U001', 'Successful Login', '2026-01-30 19:52:53'),
('L024', 'U001', 'Successful Logout', '2026-01-30 20:02:37'),
('L025', 'U001', 'Successful Login', '2026-01-30 21:19:19'),
('L026', 'U001', 'Change User Status (U007)', '2026-01-30 22:15:11'),
('L027', 'U001', 'Change User Status (U002)', '2026-01-30 22:17:43'),
('L028', 'U001', 'Change User Status (U002)', '2026-01-30 22:17:52'),
('L029', 'U001', 'Change User Status (U005)', '2026-01-30 22:18:06'),
('L030', 'U001', 'Change User Status (U006)', '2026-01-30 22:18:09'),
('L031', 'U001', 'Change User Status (U005)', '2026-01-30 22:18:54'),
('L032', 'U001', 'Change User Status (U006)', '2026-01-30 22:19:37'),
('L033', 'U001', 'Change User Status (U006)', '2026-01-30 22:19:42'),
('L034', 'U001', 'Change User Status (U006)', '2026-01-30 22:19:49'),
('L035', 'U001', 'Change User Status (U006)', '2026-01-30 22:19:53'),
('L036', 'U001', 'Change User Status (U006)', '2026-01-30 22:19:59'),
('L037', 'U001', 'Change User Status (U007)', '2026-01-30 22:20:03'),
('L038', 'U001', 'Add New User (U020)', '2026-01-30 22:20:38'),
('L039', 'U001', 'Add New User (U020)', '2026-01-30 22:33:47'),
('L040', 'U001', 'Change Event Status (E001)', '2026-01-30 22:43:46'),
('L041', 'U001', 'Change Event Status (E001)', '2026-01-30 22:43:52'),
('L042', 'U001', 'Change Event Status (E004)', '2026-01-30 22:43:58'),
('L043', 'U001', 'Change Event Status (E004)', '2026-01-30 22:44:22'),
('L044', 'U001', 'Change Event Status (E002)', '2026-01-30 22:45:09'),
('L045', 'U001', 'Change Event Status (E002)', '2026-01-30 22:45:12'),
('L046', 'U001', 'Change Event Status (E004)', '2026-01-30 22:47:05'),
('L047', 'U001', 'Change Event Status (E004)', '2026-01-30 22:47:12'),
('L048', 'U001', 'Change Event Status (E004)', '2026-01-30 22:47:15'),
('L049', 'U001', 'Change Event Status (E004)', '2026-01-30 22:47:45'),
('L050', 'U001', 'Change Event Status (E004)', '2026-01-30 22:48:36'),
('L051', 'U001', 'Complete Contact Submission (S004)', '2026-01-30 23:35:47'),
('L052', 'U001', 'Add New Announcement (A002)', '2026-01-30 23:36:04'),
('L053', 'U001', 'Update Badge Information (B005)', '2026-01-30 23:38:00'),
('L054', 'U001', 'Update Badge Information (B005)', '2026-01-30 23:38:07'),
('L055', 'U001', 'Update Badge Information (B005)', '2026-01-31 00:09:29'),
('L056', 'U001', 'Update Badge Information (B005)', '2026-01-31 00:09:37'),
('L057', 'U001', 'Update Badge Information (B005)', '2026-01-31 00:10:01'),
('L058', 'U001', 'Update Profile Information (U001)', '2026-01-31 00:11:33'),
('L059', 'U001', 'Update Profile Information (U001)', '2026-01-31 00:14:15'),
('L060', 'U001', 'Successful Logout', '2026-01-31 00:31:09'),
('L061', 'U004', 'Successful Login', '2026-01-31 00:31:18'),
('L062', 'U004', 'Successful Logout', '2026-01-31 00:31:50'),
('L063', 'U001', 'Successful Login', '2026-01-31 00:31:57'),
('L064', 'U001', 'Update Profile Information (U001)', '2026-01-31 00:42:47'),
('L065', 'U001', 'Update Password (U001)', '2026-01-31 00:56:45'),
('L066', 'U001', 'Update Security Question (U001)', '2026-01-31 00:56:57'),
('L067', 'U001', 'Successful Logout', '2026-01-31 01:00:21'),
('L068', 'U001', 'Successful Login', '2026-01-31 01:08:12'),
('L069', 'U001', 'Successful Logout', '2026-01-31 01:54:36'),
('L070', 'U002', 'Successful Login', '2026-01-31 02:33:34'),
('L071', 'U002', 'Successful Logout', '2026-01-31 03:21:14'),
('L072', 'U001', 'Successful Login', '2026-01-31 03:21:23'),
('L073', 'U001', 'Successful Logout', '2026-01-31 04:49:18'),
('L074', 'U004', 'Successful Login', '2026-01-31 04:49:38'),
('L075', 'U004', 'Successful Logout', '2026-01-31 05:11:28'),
('L076', 'U001', 'Successful Login', '2026-01-31 05:11:40'),
('L077', 'U001', 'Successful Logout', '2026-01-31 05:48:38'),
('L078', 'U004', 'Successful Login', '2026-01-31 05:48:44'),
('L079', 'U004', 'Successful Login', '2026-01-31 21:38:27'),
('L080', 'U004', 'Successful Logout', '2026-02-01 00:02:22'),
('L081', 'U001', 'Successful Login', '2026-02-01 00:02:29'),
('L082', 'U001', 'Add New Announcement (A002)', '2026-02-02 01:28:53'),
('L083', 'U001', 'Update Badge Information (B005)', '2026-02-02 01:29:16'),
('L084', 'U001', 'Successful Logout', '2026-02-02 01:31:37'),
('L085', 'U001', 'Successful Login', '2026-02-02 01:31:44'),
('L086', 'U001', 'Update Profile Information (U001)', '2026-02-02 01:31:51'),
('L087', 'U001', 'Successful Logout', '2026-02-02 01:32:03'),
('L088', 'U004', 'Successful Login', '2026-02-02 01:32:12'),
('L089', 'U004', 'Successful Logout', '2026-02-02 01:34:21'),
('L090', 'U002', 'Successful Login', '2026-02-04 16:58:41'),
('L091', 'U002', 'Update Event Information: E004', '2026-02-04 17:01:03'),
('L092', 'U002', 'Successful Logout', '2026-02-04 17:09:54'),
('L093', 'U004', 'Successful Login', '2026-02-04 17:10:01'),
('L094', 'U004', 'Successful Logout', '2026-02-08 18:48:46'),
('L095', 'U001', 'Successful Login', '2026-02-08 18:48:54'),
('L096', 'U001', 'Update Security Question (U001)', '2026-02-08 18:56:29'),
('L097', 'U001', 'Update Security Question (U001)', '2026-02-08 18:56:58'),
('L098', 'U001', 'Successful Login', '2026-02-09 02:12:25'),
('L099', 'U001', 'Successful Logout', '2026-02-09 12:52:34'),
('L100', 'U004', 'Successful Login', '2026-02-09 12:53:20'),
('L101', 'U004', 'Successful Logout', '2026-02-13 14:17:18'),
('L102', 'U001', 'Successful Login', '2026-02-13 23:59:15'),
('L103', 'U001', 'Successful Logout', '2026-02-13 23:59:32'),
('L104', 'U002', 'Successful Login', '2026-02-13 23:59:38'),
('L105', 'U002', 'Successful Logout', '2026-02-14 00:41:25'),
('L106', 'U001', 'Successful Login', '2026-02-14 00:41:32'),
('L107', 'U002', 'Successful Login', '2026-02-15 03:17:22'),
('L108', 'U002', 'Fertilize Tree (TA002)', '2026-02-15 03:17:32'),
('L109', 'U002', 'Fertilize Tree (TA002)', '2026-02-15 03:17:39'),
('L110', 'U002', 'Successful Logout', '2026-02-15 03:19:02'),
('L111', 'U001', 'Successful Login', '2026-02-15 03:23:34'),
('L112', 'U001', 'Successful Logout', '2026-02-15 03:28:33'),
('L113', 'U003', 'Successful Login', '2026-02-15 03:28:43'),
('L114', 'U003', 'Successful Logout', '2026-02-15 03:28:59'),
('L115', 'U004', 'Successful Login', '2026-02-15 03:29:06'),
('L116', 'U004', 'Successful Logout', '2026-02-15 03:29:10'),
('L117', 'U001', 'Successful Login', '2026-02-15 03:31:05');

-- --------------------------------------------------------

--
-- Table structure for table `merchandise_purchase_history`
--

CREATE TABLE `merchandise_purchase_history` (
  `merchandise_purchase_id` varchar(8) NOT NULL,
  `item_id` varchar(8) NOT NULL,
  `user_id` varchar(8) NOT NULL,
  `merchandise_purchase_datetime` datetime NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `merchandise_purchase_history`
--

INSERT INTO `merchandise_purchase_history` (`merchandise_purchase_id`, `item_id`, `user_id`, `merchandise_purchase_datetime`, `amount`) VALUES
('MP001', 'I001', 'U004', '2026-01-01 11:23:47', 1),
('MP002', 'I002', 'U004', '2026-01-30 18:09:05', 1),
('MP003', 'I003', 'U005', '2026-01-30 18:16:26', 1),
('MP004', 'I001', 'U006', '2026-01-30 18:54:48', 1),
('MP005', 'I001', 'U008', '2026-01-30 18:56:19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `milestone`
--

CREATE TABLE `milestone` (
  `user_id` varchar(8) NOT NULL,
  `badge_id` varchar(8) NOT NULL,
  `issue_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `milestone`
--

INSERT INTO `milestone` (`user_id`, `badge_id`, `issue_date`) VALUES
('U004', 'B001', '2026-02-02'),
('U004', 'B002', '2026-02-02'),
('U004', 'B003', '2026-02-02'),
('U004', 'B004', '2026-02-02'),
('U004', 'B005', '2026-02-02');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `module_id` varchar(8) NOT NULL,
  `user_id` varchar(8) NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `module_description` varchar(255) NOT NULL,
  `module_cover` varchar(255) NOT NULL,
  `module_material` varchar(255) NOT NULL,
  `module_video` varchar(255) NOT NULL,
  `module_status` varchar(50) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`module_id`, `user_id`, `module_name`, `module_description`, `module_cover`, `module_material`, `module_video`, `module_status`) VALUES
('M001', 'U003', 'Malaysia’s Green Technology', 'Explore Malaysia’s efforts in green technology, including sustainable energy solutions, eco-friendly innovations, and initiatives promoting environmental awareness.', 'src/moduleMaterials/Malaysia’s Green Technology.png', 'src/moduleMaterials/Malaysia’s Green Technology.pdf', 'src/moduleMaterials/Malaysia’s Green Technology.mp4', 'Active'),
('M002', 'U002', 'Renewable Energy & Sustainability', 'Discover the role of renewable energy in building a sustainable future, including solar, wind, and hydro power initiatives that reduce carbon emissions and promote environmental responsibility.', 'src/moduleMaterials/Renewable Energy & Sustainability.png', 'src/moduleMaterials/Renewable Energy & Sustainability.pdf', 'src/moduleMaterials/Renewable Energy & Sustainability.mp4', 'Active'),
('M003', 'U003', 'Climate Change Awareness', 'Learn about climate change, its impacts on the environment and society, and the importance of individual and collective actions in mitigating global warming.', 'src/moduleMaterials/Climate Change Awareness.png', 'src/moduleMaterials/Climate Change Awareness.pdf', 'src/moduleMaterials/Climate Change Awareness.mp4', 'Active'),
('M004', 'U003', 'Waste Management & Recycling', 'Explore effective waste management practices, recycling methods, and circular economy approaches that help minimize waste and protect natural resources.', 'src/moduleMaterials/Waste Management & Recycling.png', 'src/moduleMaterials/Waste Management & Recycling.pdf', 'src/moduleMaterials/Waste Management & Recycling.mp4', 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `module_history`
--

CREATE TABLE `module_history` (
  `module_id` varchar(8) NOT NULL,
  `user_id` varchar(8) NOT NULL,
  `highest_score` varchar(50) NOT NULL,
  `awarded_points` int(11) NOT NULL,
  `total_attempt` int(11) NOT NULL,
  `finish_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_history`
--

INSERT INTO `module_history` (`module_id`, `user_id`, `highest_score`, `awarded_points`, `total_attempt`, `finish_datetime`) VALUES
('M001', 'U004', '3', 500, 2, '2026-01-30 01:37:17'),
('M001', 'U005', '2', 300, 1, '2026-01-30 17:32:04'),
('M001', 'U008', '2', 150, 3, '2026-01-30 17:56:26'),
('M001', 'U009', '3', 500, 1, '2026-01-30 17:57:38');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quiz_id` varchar(8) NOT NULL,
  `module_id` varchar(8) NOT NULL,
  `quiz_question` varchar(255) NOT NULL,
  `option1` varchar(255) NOT NULL,
  `option2` varchar(255) NOT NULL,
  `option3` varchar(255) NOT NULL,
  `option4` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `quiz_given_point` int(11) NOT NULL,
  `quiz_status` varchar(50) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`quiz_id`, `module_id`, `quiz_question`, `option1`, `option2`, `option3`, `option4`, `answer`, `quiz_given_point`, `quiz_status`) VALUES
('Q001', 'M001', 'Due to its tropical climate, which renewable energy source is Malaysia primarily focusing on to reduce carbon emissions?', 'Geothermal Energy', 'Solar Energy', 'Wind Energy', 'Nuclear Energy', 'option 2', 150, 'Active'),
('Q002', 'M001', 'What is the long-term environmental goal that Malaysia has committed to achieving by the year 2050?', '100% Plastic Free', 'Zero Waste to Landfill', 'Net Zero Carbon Emissions', 'Total ban on fossil fuels', 'option 3', 150, 'Active'),
('Q003', 'M001', 'Which of the following is a key green technology innovation currently being promoted in Malaysia\'s transportation sector?', 'Electric Vehicles (EVs)', 'Steam-powered Locomotives', 'Diesel Hybrid Engines', 'Hydrogen Airships', 'option 1', 200, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tree_adoption_history`
--

CREATE TABLE `tree_adoption_history` (
  `tree_adoption_id` varchar(8) NOT NULL,
  `item_id` varchar(8) NOT NULL,
  `user_id` varchar(8) NOT NULL,
  `given_name` varchar(100) NOT NULL,
  `tree_adoption_datetime` datetime NOT NULL,
  `fertilization_datetime` datetime DEFAULT NULL,
  `tree_adoption_status` varchar(50) NOT NULL DEFAULT 'Planted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tree_adoption_history`
--

INSERT INTO `tree_adoption_history` (`tree_adoption_id`, `item_id`, `user_id`, `given_name`, `tree_adoption_datetime`, `fertilization_datetime`, `tree_adoption_status`) VALUES
('TA001', 'I005', 'U004', 'GreenSpark', '2026-01-30 18:11:58', NULL, 'Planted'),
('TA002', 'I006', 'U004', 'LeafNova', '2026-01-30 18:14:38', '2026-02-15 03:17:39', 'Germinating'),
('TA003', 'I005', 'U008', 'EverGrow', '2026-01-30 18:56:28', NULL, 'Diseased');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(8) NOT NULL,
  `name` varchar(100) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `gender` char(1) NOT NULL,
  `date_of_birth` date NOT NULL,
  `contact_number` varchar(12) NOT NULL,
  `education_email` varchar(50) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `registration_date` date NOT NULL,
  `password` varchar(255) NOT NULL,
  `safety_question_1` varchar(150) DEFAULT NULL,
  `answer_1` varchar(150) DEFAULT NULL,
  `safety_question_2` varchar(150) DEFAULT NULL,
  `answer_2` varchar(150) DEFAULT NULL,
  `green_points` int(11) DEFAULT NULL,
  `total_earned` int(11) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` varchar(50) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `account_status` varchar(50) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `nationality`, `gender`, `date_of_birth`, `contact_number`, `education_email`, `course_name`, `registration_date`, `password`, `safety_question_1`, `answer_1`, `safety_question_2`, `answer_2`, `green_points`, `total_earned`, `avatar`, `role`, `last_login`, `account_status`) VALUES
('U001', 'Gan Teck Ann', 'Malaysian', 'M', '2006-08-05', '01110911824', 'TP083567@mail.apu.edu.my', 'Diploma in ICT (Software Engineering)', '2025-12-23', '$2y$10$7XDMxS8G/ng2sVKWUUqvRej6p8vjgxc/X/hXYn2d2BU/kOBBg636C', 'What is your secondary school name?', 'SDBL', 'What is your favorite color?', 'Blue', NULL, NULL, 'src/avatars/U001_avatar_1769792900.jpg', 'admin', '2026-02-15 03:31:04', 'Active'),
('U002', 'Goh Yang Ee', 'Malaysian', 'M', '2006-07-24', '0125508144', 'TP084231@mail.apu.edu.my', 'Diploma in ICT (Software Engineering)', '2025-12-23', '$2y$10$/FqDThXUlgrkHbNEmlF4cuiwcndPCgObsnDj7k/9u7JMRoYPHtWBe', NULL, NULL, NULL, NULL, NULL, NULL, 'src/avatars/U002_avatars_1769806685.jpg', 'committee', '2026-02-15 03:17:22', 'Active'),
('U003', 'Cynthia Tan Xin Ru', 'Malaysian', 'F', '2006-01-21', '01155034966', 'TP084369@mail.apu.edu.my', 'Diploma in ICT (Software Engineering)', '2025-12-23', '$2y$10$pOUI7Dv/WdOlaO/fca0MHOPafP3I.a55FhuVKme4X8SZzB7l/tyaC', NULL, NULL, NULL, NULL, NULL, NULL, 'src/avatars/U003_avatar_1770542412.jpg', 'committee', '2026-02-15 03:28:43', 'Active'),
('U004', 'Lim Jin Ming', 'Malaysian', 'M', '2006-06-09', '0129692700', 'TP083424@mail.apu.edu.my', 'Diploma in ICT (Software Engineering)', '2025-12-23', '$2y$10$hrkNchWg.uYwsRLpPlVTveGyMV0fFr1cSTgYC7MY0ec.3rxEIKdyS', NULL, NULL, NULL, NULL, 1300, 12000, 'src/avatars/U004_avatar_1769805185.jpg', 'volunteer', '2026-02-15 03:29:06', 'Active'),
('U005', 'Lim Wei Jian', 'Malaysian', 'M', '2006-11-01', '0129091231', 'TP083342@mail.apu.edu.my', 'Diploma in Business Administration', '2026-01-28', '$2y$10$/rnii.EwZIEccovpFP3y5OTlEL5eOL6Z/LqyAf1V9FTlgPVEhC.AK', NULL, NULL, NULL, NULL, 4700, 5300, 'src/avatars/default.png', 'volunteer', '2026-01-30 18:16:15', 'Active'),
('U006', 'Aisyah Binti Ahmad', 'Malaysian', 'F', '2002-05-22', '0134567890', 'TP084567@mail.apu.edu.my', 'Diploma in ICT (Data Informatics)', '2026-01-28', '$2y$10$TsWRtI44N2kFs.zxEFWdXOi6FxTK1OcVwPekKUniv9X33wm/1lvoq', NULL, NULL, NULL, NULL, 2000, 8000, 'src/avatars/default.png', 'volunteer', '2026-01-30 18:52:54', 'Inactive'),
('U007', 'Rajesh Verma', 'Indian', 'M', '2007-07-23', '0125678901', 'TP089123@mail.apu.edu.my', 'Diploma in Accounting', '2026-01-28', '$2y$10$m2XnVnfxqTG8GnaTTLdBKuQTT1jkncaVNEj2.KGSbW4S.5yXntt.W', NULL, NULL, NULL, NULL, 0, 0, 'src/avatars/default.png', 'volunteer', NULL, 'Active'),
('U008', 'Ethan Wong', 'Singaporean', 'M', '2004-02-13', '0117890123', 'TP087233@mail.apu.edu.my', 'Diploma in ICT (Interactive Technology)', '2026-01-28', '$2y$10$ta3ZDktt.oeeaWl9QcUMZe2wXGfDz8yFhMUMWtP4AZEo/VdLy0Rxe', NULL, NULL, NULL, NULL, 650, 9150, 'src/avatars/default.png', 'volunteer', '2026-01-30 18:56:12', 'Active'),
('U009', 'Sophie Williams', 'British', 'F', '2004-12-08', '0156789012', 'TP083778@mail.apu.edu.my', 'Diploma in Design & Media', '2026-01-28', '$2y$10$Tw.vgCsEogRDJSX2F2RGiOuGkQ7bLJ6DJ5zG2SFt0cbhXw29IRHPu', NULL, NULL, NULL, NULL, 450, 450, 'src/avatars/default.png', 'volunteer', '2026-01-30 17:57:30', 'Active'),
('U010', 'Hannah Miller', 'American', 'F', '2003-10-14', '0197890123', 'TP086112@mail.apu.edu.my', 'Diploma in Events Management', '2026-01-28', '$2y$10$otzyrw1M7W3F7Fd4VwGvnea64Fx7YHEbo3RJdKE7Q6RNA5U0mWDs2', NULL, NULL, NULL, NULL, 0, 0, 'src/avatars/default.png', 'volunteer', NULL, 'Active'),
('U011', 'Kim Soo Min', 'South Korean', 'M', '2002-01-19', '0176789456', 'TP083617@mail.apu.edu.my', 'Diploma in ICT (Interactive Technology)', '2026-01-28', '$2y$10$6jw1XHsD5seB/6bw5bzoKuBNeyTmG0gpaWVwCGcNs.UfPux/rl8gO', NULL, NULL, NULL, NULL, 0, 0, 'src/avatars/default.png', 'volunteer', NULL, 'Active'),
('U012', 'Tran Quang Huy', 'Vietnamese', 'M', '2001-07-19', '0142343890', 'TP087021@mail.apu.edu.my', 'Diploma in Mechatronic Engineering', '2026-01-28', '$2y$10$0Y.o1lYAH6iyf4DB6ubRwe7b73jFcPvzgnVcN86P.w8TzE14/woC6', NULL, NULL, NULL, NULL, 0, 0, 'src/avatars/default.png', 'volunteer', NULL, 'Active'),
('U013', 'Aiko Nakamura', 'Japanese', 'F', '2003-12-20', '0128901678', 'TP087819@mail.apu.edu.my', 'Diploma in ICT', '2026-01-28', '$2y$10$A/zzuk4ESkN5Y3ljBUBU1eTj3VVXnxTEGbasUOR28liymZxp0L2Da', NULL, NULL, NULL, NULL, 0, 0, 'src/avatars/default.png', 'volunteer', NULL, 'Active'),
('U014', 'Hiroshi Tanaka', 'Japanese', 'M', '2006-04-17', '0187890567', 'TP083718@mail.apu.edu.my', 'Diploma in Hotel Management', '2026-01-28', '$2y$10$6pWh1CQPhcdT/.MEbeEyMuuDXml3CUU/0qhmA.sVDb6GvRYlhLJgS', NULL, NULL, NULL, NULL, 0, 0, 'src/avatars/default.png', 'volunteer', NULL, 'Active'),
('U015', 'Zhang Yifan', 'Chinese', 'M', '2006-03-18', '0123456123', 'TP081314@mail.apu.edu.my', 'Diploma in Design & Media', '2026-01-28', '$2y$10$g7aArTTg1aCty.4kPK7NtuTG.5Mna1B0beUcfnLFs3RQjlInpLt.6', NULL, NULL, NULL, NULL, 0, 0, 'src/avatars/default.png', 'volunteer', NULL, 'Active'),
('U016', 'Marco Rossi', 'Italian', 'M', '2003-08-12', '0134564789', 'TP081569@mail.apu.edu.my', 'Diploma in Events Management', '2026-01-28', '$2y$10$zQgVIiqhAluCLAVUCl2Ooe.DxBR9DNx1ZUv4U2vtiN620jNy.8qmy', NULL, NULL, NULL, NULL, 0, 0, 'src/avatars/default.png', 'volunteer', NULL, 'Active'),
('U017', 'Lucas Pereira', 'Brazilian', 'M', '2003-05-14', '0156786901', 'TP086132@mail.apu.edu.my', 'Diploma in International Studies', '2026-01-28', '$2y$10$JOLKw4ZDtw0J6cN1366KA.z5yZw3QPyJqJQAS7Cr.3YgDBKSom3tu', NULL, NULL, NULL, NULL, 0, 0, 'src/avatars/default.png', 'volunteer', NULL, 'Active'),
('U018', 'Nour El Din', 'Egyptian', 'F', '2002-12-08', '0178901456', 'TP081627@mail.apu.edu.my', 'Diploma in Business Information Technology', '2026-01-28', '$2y$10$XXgkWrBUryZ4GQKqNAb3yOjIJd2CiCur58wV2COALTSEQTY2ySi.6', NULL, NULL, NULL, NULL, 0, 0, 'src/avatars/default.png', 'volunteer', NULL, 'Active'),
('U019', 'Ayesha Khan', 'Pakistani', 'F', '2003-01-13', '0136789234', 'TP082416@mail.apu.edu.my', 'Diploma in Business Administration', '2026-01-28', '$2y$10$vYQto1fV3UhnuP83t/T2OOXnBWOPHUGMjgz9yqbsl5dLBViVjg.Oq', NULL, NULL, NULL, NULL, 0, 0, 'src/avatars/default.png', 'volunteer', NULL, 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`announcement_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`event_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`badge_id`);

--
-- Indexes for table `contact_submission`
--
ALTER TABLE `contact_submission`
  ADD PRIMARY KEY (`submission_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `merchandise_purchase_history`
--
ALTER TABLE `merchandise_purchase_history`
  ADD PRIMARY KEY (`merchandise_purchase_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `milestone`
--
ALTER TABLE `milestone`
  ADD PRIMARY KEY (`user_id`,`badge_id`),
  ADD KEY `badge_id` (`badge_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`module_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `module_history`
--
ALTER TABLE `module_history`
  ADD PRIMARY KEY (`module_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `tree_adoption_history`
--
ALTER TABLE `tree_adoption_history`
  ADD PRIMARY KEY (`tree_adoption_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcement`
--
ALTER TABLE `announcement`
  ADD CONSTRAINT `announcement_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `contact_submission`
--
ALTER TABLE `contact_submission`
  ADD CONSTRAINT `contact_submission_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `merchandise_purchase_history`
--
ALTER TABLE `merchandise_purchase_history`
  ADD CONSTRAINT `merchandise_purchase_history_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`),
  ADD CONSTRAINT `merchandise_purchase_history_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `milestone`
--
ALTER TABLE `milestone`
  ADD CONSTRAINT `milestone_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `milestone_ibfk_2` FOREIGN KEY (`badge_id`) REFERENCES `badges` (`badge_id`);

--
-- Constraints for table `modules`
--
ALTER TABLE `modules`
  ADD CONSTRAINT `modules_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `module_history`
--
ALTER TABLE `module_history`
  ADD CONSTRAINT `module_history_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`),
  ADD CONSTRAINT `module_history_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`);

--
-- Constraints for table `tree_adoption_history`
--
ALTER TABLE `tree_adoption_history`
  ADD CONSTRAINT `tree_adoption_history_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`),
  ADD CONSTRAINT `tree_adoption_history_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
