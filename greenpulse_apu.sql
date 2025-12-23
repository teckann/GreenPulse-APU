-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2025 at 10:58 PM
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
('A001', 'U001', 'New Feature Released', '2025-12-23 22:04:14');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `event_id` varchar(8) NOT NULL,
  `user_id` varchar(8) NOT NULL,
  `event_register_date` date NOT NULL,
  `attendance_status` varchar(50) NOT NULL DEFAULT 'Absent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`event_id`, `user_id`, `event_register_date`, `attendance_status`) VALUES
('E001', 'U004', '2025-12-24', 'Absent');

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
('B001', 'Level 1', 'src/badgeImages/badge1.png', 3000);

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
('S001', NULL, 'Marcus Tan', 'marcus0101@gmail.com', '0123456789', 'Account Registration', 'Enquiries related to account registration and sign-up issues.', '2025-12-23 22:08:42', 'Pending');

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
  `available_spot` int(11) NOT NULL,
  `points_given` int(11) NOT NULL,
  `posted_date` date NOT NULL,
  `event_status` varchar(50) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `user_id`, `event_title`, `event_poster`, `event_description`, `event_datetime`, `duration`, `location`, `capacity`, `available_spot`, `points_given`, `posted_date`, `event_status`) VALUES
('E001', 'U002', 'Go Green Workshop', 'src/eventPosters/poster1.png', 'An interactive workshop focused on sustainability and environmentally friendly practices.', '2025-12-30 13:30:00', '2h 30m', 'Auditorium 4 @ Level 3 | APU Campus', 120, 120, 450, '2025-12-23', 'Active');

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
  `item_status` varchar(50) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `user_id`, `item_name`, `item_image`, `item_description`, `item_redeem_points`, `item_stock`, `category`, `item_status`) VALUES
('I001', 'U003', 'GreenPulse T-Shirt', 'src/itemImages/item1.png', 'A GreenPulse branded T-shirt supporting green initiatives and environmental awareness. Available in sizes M, L, XL, and XXL for a comfortable fit.', 6000, 50, 'merchandise', 'Active');

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

-- --------------------------------------------------------

--
-- Table structure for table `merchandise_purchase_history`
--

CREATE TABLE `merchandise_purchase_history` (
  `merchandise_purchase_id` varchar(8) NOT NULL,
  `item_id` varchar(8) NOT NULL,
  `user_id` varchar(8) NOT NULL,
  `merchandise_purchase_date` date NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `milestone`
--

CREATE TABLE `milestone` (
  `user_id` varchar(8) NOT NULL,
  `badge_id` varchar(8) NOT NULL,
  `issue_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `module_id` varchar(8) NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `module_description` varchar(255) NOT NULL,
  `module_meterial` varchar(255) NOT NULL,
  `module_video` varchar(255) NOT NULL,
  `module_status` varchar(50) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`module_id`, `module_name`, `module_description`, `module_meterial`, `module_video`, `module_status`) VALUES
('M001', 'Malaysia’S Green Technology', 'Explore Malaysia’s efforts in green technology, including sustainable energy solutions, eco-friendly innovations, and initiatives promoting environmental awareness.', 'src/moduleMaterials/Green-Technology-2022-2023.pdf', 'src/moduleMaterials/Green-Technology-2022-2023.mp4', 'Active');

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
  `finsih_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `quiz_given_point` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`quiz_id`, `module_id`, `quiz_question`, `option1`, `option2`, `option3`, `option4`, `answer`, `quiz_given_point`) VALUES
('Q001', 'M001', 'Due to its tropical climate, which renewable energy source is Malaysia primarily focusing on to reduce carbon emissions?', 'Geothermal Energy', 'Solar Energy', 'Wind Energy', 'Nuclear Energy', 'Solar Energy', 150),
('Q002', 'M001', 'What is the long-term environmental goal that Malaysia has committed to achieving by the year 2050?', '100% Plastic Free', 'Zero Waste to Landfill', 'Net Zero Carbon Emissions', 'Total ban on fossil fuels', 'Net Zero Carbon Emissions', 150),
('Q003', 'M001', 'Which of the following is a key green technology innovation currently being promoted in Malaysia\'s transportation sector?', 'Electric Vehicles (EVs)', 'Steam-powered Locomotives', 'Diesel Hybrid Engines', 'Hydrogen Airships', 'Electric Vehicles (EVs)', 150);

-- --------------------------------------------------------

--
-- Table structure for table `tree_adoption_history`
--

CREATE TABLE `tree_adoption_history` (
  `tree_adoption_id` varchar(8) NOT NULL,
  `item_id` varchar(8) NOT NULL,
  `user_id` varchar(8) NOT NULL,
  `given_name` varchar(100) NOT NULL,
  `tree_adoption_date` date NOT NULL,
  `fertilization_datetime` datetime NOT NULL,
  `tree_adoption_status` varchar(50) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(8) NOT NULL,
  `name` varchar(100) NOT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
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
  `green_points` int(11) DEFAULT 0,
  `total_earned` int(11) DEFAULT 0,
  `avatar` varchar(255) DEFAULT NULL,
  `role` varchar(50) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `account_status` varchar(50) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `nationality`, `gender`, `date_of_birth`, `contact_number`, `education_email`, `course_name`, `registration_date`, `password`, `safety_question_1`, `answer_1`, `safety_question_2`, `answer_2`, `green_points`, `total_earned`, `avatar`, `role`, `last_login`, `account_status`) VALUES
('U001', 'Gan Teck Ann', 'Malaysia', 'M', '2006-08-05', '01110911824', 'TP083567@mail.apu.edu.my', 'Diploma in ICT (Software Engineering)', '2025-12-23', 'teckann123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, 'Active'),
('U002', 'Goh Yang Ee', 'Malaysia', 'M', '2006-07-24', '0125508144', 'TP084231@mail.apu.edu.my', 'Diploma in ICT (Software Engineering)', '2025-12-23', 'yangee123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'committee', NULL, 'Active'),
('U003', 'Cynthia Tan Xin Ru', 'Malaysia', 'F', '2006-01-21', '01155034966', 'TP084369@mail.apu.edu.my', 'Diploma in ICT (Software Engineering)', '2025-12-23', 'cynthia123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'committee', NULL, 'Active'),
('U004', 'Lim Jin Ming', 'Malaysia', 'M', '2006-06-09', '0129692700', 'TP0834242@mail.apu.edu.my', 'Diploma in ICT (Software Engineering)', '2025-12-23', 'jimmy123', NULL, NULL, NULL, NULL, 0, 0, NULL, 'volunteer', NULL, 'Active');

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
  ADD PRIMARY KEY (`module_id`);

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
