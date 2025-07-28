-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2025 at 04:59 AM
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
-- Database: `clinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` int(11) NOT NULL,
  `medicine_name` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `dosage` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL,
  `expiry_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `medicine_name`, `type`, `dosage`, `stock`, `expiry_date`, `created_at`) VALUES
(1, 'Paracetamol', 'Tablet', '500mg', 100, '2026-01-01', '2025-07-24 07:52:43'),
(2, 'Amoxicillin', 'Capsule', '250mg', 50, '2025-12-15', '2025-07-24 07:52:43'),
(3, 'Ibuprofen', 'Tablet', '200mg', 75, '2025-11-30', '2025-07-24 07:52:43'),
(4, 'Alaxan', 'Tablet', '150', 20, '2025-02-01', '2025-07-24 07:53:31'),
(5, 'Jayme Whitehead', 'Porro aut pariatur ', 'Id consectetur esse', 1, '2017-08-17', '2025-07-24 07:55:21');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `account_number` varchar(100) DEFAULT NULL,
  `address` text NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `gender` enum('MALE','FEMALE') NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `civil_status` enum('SINGLE','MARRIED','DIVORCED','WIDOWED') NOT NULL,
  `height` decimal(5,2) NOT NULL COMMENT 'Height in centimeters',
  `weight` decimal(5,2) NOT NULL COMMENT 'Weight in kilograms',
  `religion` varchar(100) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `philhealth_id` varchar(50) DEFAULT NULL,
  `critical_info` text DEFAULT NULL,
  `patient_photo` varchar(255) DEFAULT NULL COMMENT 'Path to uploaded photo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `patient_name`, `account_number`, `address`, `contact_number`, `gender`, `email_address`, `date_of_birth`, `civil_status`, `height`, `weight`, `religion`, `occupation`, `philhealth_id`, `critical_info`, `patient_photo`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Minerva Roy', '733', 'Dicta quod deleniti', '543435', 'MALE', 'poqepa@mailinator.com', '1982-10-29', '', 22.00, 6.00, 'Explicabo Officia n', 'Earum architecto dol', 'Dignissimos molestia', 'Tempora aliquid sit', NULL, '2025-07-24 07:12:14', '2025-07-24 07:12:14', 1, NULL),
(2, 'Alexis Vega', '46', 'Harum commodi exerci', '1', 'MALE', 'humezumu@mailinator.com', '2015-10-06', '', 75.00, 37.00, 'Possimus tempore i', 'Accusamus aut sit s', 'Rerum eu velit volup', 'Rerum excepteur dolo', NULL, '2025-07-24 07:13:15', '2025-07-24 07:13:15', 1, NULL),
(3, 'Ann', '968', 'Aliquam a dolor quis', '1', 'MALE', 'cywusufag@mailinator.com', '1987-12-09', '', 24.00, 18.00, 'Omnis dolor deserunt', 'Aut ea consequat Re', 'Veniam officiis ten', 'Quisquam dicta rerum', NULL, '2025-07-24 07:21:57', '2025-07-24 07:21:57', 1, NULL),
(4, 'Ebony Mitchell', '166', 'Dolorem est minima i', '+1 (204) 948-4576', 'FEMALE', 'miloluho@mailinator.com', '2001-07-07', 'MARRIED', 5.00, 50.00, 'Temporibus exercitat', 'Ut dolore quisquam e', 'Eveniet eos rerum', 'Ad ex aut odio paria', NULL, '2025-07-24 07:42:15', '2025-07-24 07:42:15', 1, NULL),
(5, 'Jennie Kim', '578', 'Deleniti dolor aliqu', '+1 (785) 662-7943', 'MALE', 'bisyvirazy@mailinator.com', '2021-03-22', 'MARRIED', 88.00, 65.00, 'Numquam quidem conse', 'Error incidunt temp', 'Et sed ex dolorem re', 'Occaecat ut exercita', NULL, '2025-07-24 07:44:22', '2025-07-24 07:44:22', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient_children`
--

CREATE TABLE `patient_children` (
  `child_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `child_name` varchar(255) DEFAULT NULL,
  `child_contact` varchar(20) DEFAULT NULL,
  `child_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_children`
--

INSERT INTO `patient_children` (`child_id`, `patient_id`, `child_name`, `child_contact`, `child_date`, `created_at`) VALUES
(1, 1, 'Josiah Tate', '423432', '2007-05-02', '2025-07-24 07:12:14'),
(2, 2, 'Colin Guthrie', '+1 (594) 603-8905', '1973-12-23', '2025-07-24 07:13:15'),
(3, 2, 'Erin Skinner', '+1 (729) 629-8939', '2005-11-09', '2025-07-24 07:13:15'),
(4, 2, 'Inga Dunlap', '+1 (263) 143-8079', '1978-10-05', '2025-07-24 07:13:15'),
(5, 3, 'Abigail Acevedo', '+1 (769) 837-8459', '1985-05-16', '2025-07-24 07:21:57'),
(6, 3, 'Aileen Bullock', '+1 (719) 962-3745', '1996-04-02', '2025-07-24 07:21:57'),
(7, 3, 'Maile Obrien', '+1 (216) 394-7911', '1982-02-07', '2025-07-24 07:21:57'),
(8, 4, 'Kaitlin Peck', '+1 (282) 188-6692', '1971-06-15', '2025-07-24 07:42:15'),
(9, 4, 'Paul Chaney', '+1 (732) 307-1875', '1996-07-19', '2025-07-24 07:42:15'),
(10, 4, 'Uma Keith', '+1 (955) 479-5374', '1979-01-12', '2025-07-24 07:42:15'),
(11, 4, 'Kieran Lane', '+1 (169) 908-2121', '2016-06-27', '2025-07-24 07:42:15'),
(12, 5, 'Colby Faulkner', '+1 (511) 264-4595', '2019-11-26', '2025-07-24 07:44:22'),
(13, 5, 'Abdul Mcfarland', '+1 (132) 932-1413', '1970-02-23', '2025-07-24 07:44:22'),
(14, 5, 'Fitzgerald Farrell', '+1 (207) 355-7015', '2001-08-06', '2025-07-24 07:44:22'),
(15, 5, 'Shad Whitney', '+1 (937) 606-2441', '1988-06-05', '2025-07-24 07:44:22'),
(16, 5, 'Hermione Todd', '+1 (753) 552-1327', '1994-06-26', '2025-07-24 07:44:22'),
(17, 5, 'Ursa Montgomery', '+1 (781) 407-6506', '1996-01-10', '2025-07-24 07:44:22'),
(18, 5, 'Autumn Cruz', '+1 (316) 413-3128', '2008-06-16', '2025-07-24 07:44:22');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `age_gender` varchar(50) DEFAULT NULL,
  `diagnosis` text DEFAULT NULL,
  `prescription` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `name`, `date`, `address`, `age_gender`, `diagnosis`, `prescription`) VALUES
(1, 'Julie Ann G Fernandez', '2025-07-22', 'Saway', 'Female', 'N/A', 'N/A');

-- --------------------------------------------------------

--
-- Table structure for table `rx_prescriptions`
--

CREATE TABLE `rx_prescriptions` (
  `id` int(11) NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `address` text NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `medicine` varchar(999) NOT NULL,
  `diagnosis` text NOT NULL,
  `prescription` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rx_prescriptions`
--

INSERT INTO `rx_prescriptions` (`id`, `patient_name`, `date`, `address`, `age`, `gender`, `medicine`, `diagnosis`, `prescription`, `created_at`) VALUES
(1, 'Jennie Kim', '2025-07-25', 'Deleniti dolor aliqu', 0, 'MALE', 'Ibuprofen', 'Eu earum sit eius ma', 'Sint incididunt eos', '2025-07-25 02:26:12'),
(2, 'Minerva Roy', '2025-07-25', 'Dicta quod deleniti', 12, 'MALE', 'Jayme Whitehead', 'Rerum et tempore au', 'Sint voluptas volupt', '2025-07-25 02:26:30'),
(3, 'Ebony Mitchell', '2025-07-25', 'Dolorem est minima i', 45, 'FEMALE', 'Alaxan', 'Eos corrupti lorem', 'Ipsum qui fugit est', '2025-07-25 02:29:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$rBdREg2x/a7v5.N3LPp5ouIgbapou/5Sw2b1SCNmruLLAdr/BE1YG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`),
  ADD KEY `idx_patient_name` (`patient_name`),
  ADD KEY `idx_account_number` (`account_number`),
  ADD KEY `idx_contact_number` (`contact_number`),
  ADD KEY `idx_email` (`email_address`),
  ADD KEY `idx_patients_created_at` (`created_at`);

--
-- Indexes for table `patient_children`
--
ALTER TABLE `patient_children`
  ADD PRIMARY KEY (`child_id`),
  ADD KEY `idx_patient_id` (`patient_id`),
  ADD KEY `idx_children_date` (`child_date`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rx_prescriptions`
--
ALTER TABLE `rx_prescriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `patient_children`
--
ALTER TABLE `patient_children`
  MODIFY `child_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rx_prescriptions`
--
ALTER TABLE `rx_prescriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `patient_children`
--
ALTER TABLE `patient_children`
  ADD CONSTRAINT `patient_children_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
