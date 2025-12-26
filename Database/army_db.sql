-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2025 at 11:03 AM
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
-- Database: `army_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`, `name`, `created_at`) VALUES
(7, 'admin@test.com', '$2y$10$PG6JvtPb4It3q4Bvp/mD7ujHr0Ago8aV5U3KoiNqctY/1tp07Qrwq', 'admin', '2025-12-26 09:59:37');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `location` varchar(150) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `item_name`, `category`, `quantity`, `location`, `photo`, `created_at`) VALUES
(7, 'Ashok Leyland Stallion Truck', 'Weapon', 545, 'Jodhpur Air Base', '../inventory/1760363702_ashok_layland_stallion_truck.jpg', '2025-10-13 13:55:02'),
(8, 'BTR-80  Armored Personnel Carrier', 'Vehicle', 45, 'COD Jabalpur', '../inventory/1760363748_btr-80_apc.jpg', '2025-10-13 13:55:48'),
(9, 'Army Medical Kit', 'Medical', 545, 'Field Hospital - Tent 3', '../inventory/1760363825_firstaidbox.jpg', '2025-10-13 13:57:05'),
(10, 'stethoscope', 'Medical', 5656, 'COD Delhi', '../inventory/1760363967_stethoscope.jpg', '2025-10-13 13:59:27'),
(11, 'Military Boots', 'Uniform', 5345, 'COD Jabalpur', '../inventory/1760364036_military_bootsjpg.jpg', '2025-10-13 14:00:36'),
(12, 'Combat Jacket', 'Uniform', 545, 'Supply Depot Pune', '../inventory/1760364090_combat_jacket.jpg', '2025-10-13 14:01:30'),
(13, 'Grenade', 'Weapon', 534, 'COD Delhi', '../inventory/1760364126_grenade.jpg', '2025-10-13 14:02:06'),
(14, 'Camouflage Pants', 'Uniform', 546, 'COD Jabalpur', '../inventory/1760364207_camouflage_pants.jpg', '2025-10-13 14:03:27'),
(15, 'Surgical Gloves', 'Medical', 45, 'Ahmedabad Cantonment', '../inventory/1760364262_surgical gloves.jpg', '2025-10-13 14:04:22'),
(16, 'T-90 Tank', 'Vehicle', 456, 'COD Agra', '../inventory/1760364313_T-90_tank.jpg', '2025-10-13 14:05:13'),
(17, 'Ak-47', 'Weapon', 456, 'COD Jabalpur', '../inventory/1760364360_ak-47.jpg', '2025-10-13 14:06:00'),
(20, 'Army Jeep', 'Vehicle', 6550, 'COD Delhi', '../inventory/1763640898_jeep.jpg', '2025-11-20 12:14:58');

-- --------------------------------------------------------

--
-- Table structure for table `leave_applications`
--

CREATE TABLE `leave_applications` (
  `id` int(11) NOT NULL,
  `soldier_id` int(11) NOT NULL,
  `leave_type` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text NOT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `applied_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `reviewed_by_admin` int(11) DEFAULT NULL,
  `reviewed_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `missions`
--

CREATE TABLE `missions` (
  `mission_id` int(11) NOT NULL,
  `mission_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(150) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('Planned','Active','Completed','Cancelled') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `missions`
--

INSERT INTO `missions` (`mission_id`, `mission_name`, `description`, `location`, `start_date`, `end_date`, `status`, `created_at`) VALUES
(13, 'Operation Eagle Eye', 'Recon mission in easter sector', 'Border Post 2', '2025-12-02', '2026-06-03', 'Active', '2025-10-25 07:18:07'),
(14, 'Operation Slient Night', 'Night surveillance patrol', 'Training Camp', '2026-05-05', '2027-03-02', 'Planned', '2025-10-25 07:19:18'),
(15, 'Operation Iron Shield', 'Defensive operation traning', 'Training Camp', '2026-02-06', '2026-03-07', 'Planned', '2025-10-25 07:20:19'),
(16, 'Operation Desert Storm', 'Desert region security patrol', 'Base Alpha', '2025-10-25', '2025-11-23', 'Completed', '2025-10-25 07:21:27'),
(17, 'Operation skyfall', 'Air reconnaissance', 'Base Bravo', '2025-12-12', '2026-02-01', 'Active', '2025-10-25 07:22:21'),
(18, 'Operation Red dawn', 'Rapid response drill', 'Headquarters', '2026-05-05', '2026-06-01', 'Planned', '2025-10-25 07:23:17'),
(19, 'Operation Night Watch', 'Border night surveillance', 'Border Post 2', '2026-02-23', '2026-05-05', 'Planned', '2025-10-25 07:24:17'),
(20, 'Operation Silver Arrow', 'Targeted strike training', 'Base Bravo', '2026-05-05', '2026-10-10', 'Planned', '2025-10-25 07:25:43'),
(21, 'abc', 'sd', 'Border Post 1', '2025-11-21', '2025-11-28', 'Completed', '2025-11-20 11:37:55');

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `rank` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `postings`
--

CREATE TABLE `postings` (
  `id` int(11) NOT NULL,
  `soldier_id` int(11) NOT NULL,
  `unit` varchar(100) DEFAULT NULL,
  `location` varchar(150) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` enum('Assign','Active','Completed') DEFAULT 'Assign',
  `assigned_on` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `soldiers`
--

CREATE TABLE `soldiers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dob` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `blood_group` varchar(5) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `rank` varchar(50) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `date_of_joining` date DEFAULT current_timestamp(),
  `profile_photo` varchar(255) DEFAULT 'images/profile.jpg',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Active','Deactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `soldiers_missions`
--

CREATE TABLE `soldiers_missions` (
  `id` int(11) NOT NULL,
  `soldier_id` int(11) NOT NULL,
  `mission_id` int(11) NOT NULL,
  `posting_id` int(11) DEFAULT NULL,
  `role` varchar(100) NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `soldier_medals`
--

CREATE TABLE `soldier_medals` (
  `id` int(11) NOT NULL,
  `soldier_id` int(11) NOT NULL,
  `medal_type` varchar(100) NOT NULL,
  `medal_name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `awarded_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_applications`
--
ALTER TABLE `leave_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviewed_by_admin` (`reviewed_by_admin`),
  ADD KEY `leave_applications_fk_sid` (`soldier_id`);

--
-- Indexes for table `missions`
--
ALTER TABLE `missions`
  ADD PRIMARY KEY (`mission_id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_notices` (`admin_id`);

--
-- Indexes for table `postings`
--
ALTER TABLE `postings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `soldier_id` (`soldier_id`);

--
-- Indexes for table `soldiers`
--
ALTER TABLE `soldiers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `soldiers_missions`
--
ALTER TABLE `soldiers_missions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_soldier` (`soldier_id`),
  ADD KEY `fk_mission` (`mission_id`),
  ADD KEY `fk_posting` (`posting_id`);

--
-- Indexes for table `soldier_medals`
--
ALTER TABLE `soldier_medals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_soldier_medals` (`soldier_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `leave_applications`
--
ALTER TABLE `leave_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `missions`
--
ALTER TABLE `missions`
  MODIFY `mission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `postings`
--
ALTER TABLE `postings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `soldiers`
--
ALTER TABLE `soldiers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `soldiers_missions`
--
ALTER TABLE `soldiers_missions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `soldier_medals`
--
ALTER TABLE `soldier_medals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `leave_applications`
--
ALTER TABLE `leave_applications`
  ADD CONSTRAINT `leave_applications_fk_sid` FOREIGN KEY (`soldier_id`) REFERENCES `soldiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leave_applications_ibfk_2` FOREIGN KEY (`reviewed_by_admin`) REFERENCES `admins` (`id`);

--
-- Constraints for table `notices`
--
ALTER TABLE `notices`
  ADD CONSTRAINT `fk_admin_notices` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `postings`
--
ALTER TABLE `postings`
  ADD CONSTRAINT `postings_ibfk_1` FOREIGN KEY (`soldier_id`) REFERENCES `soldiers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `soldiers_missions`
--
ALTER TABLE `soldiers_missions`
  ADD CONSTRAINT `fk_mission` FOREIGN KEY (`mission_id`) REFERENCES `missions` (`mission_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_posting` FOREIGN KEY (`posting_id`) REFERENCES `postings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_soldier` FOREIGN KEY (`soldier_id`) REFERENCES `soldiers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `soldier_medals`
--
ALTER TABLE `soldier_medals`
  ADD CONSTRAINT `fk_soldier_medals` FOREIGN KEY (`soldier_id`) REFERENCES `soldiers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
