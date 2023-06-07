-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2023 at 04:55 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aulog_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `charging_log`
--

CREATE TABLE `charging_log` (
  `log_id` int(11) NOT NULL,
  `student_number` varchar(12) NOT NULL,
  `tag_number` int(11) NOT NULL,
  `time_in` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `time_out` timestamp NOT NULL DEFAULT current_timestamp(),
  `state` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `constants`
--

CREATE TABLE `constants` (
  `constant_id` varchar(20) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `constants`
--

INSERT INTO `constants` (`constant_id`, `value`) VALUES
('charging_time', 1200),
('next_available_id', 1),
('number_of_tags', 25);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_number` varchar(12) NOT NULL,
  `rfid_tag` varchar(30) DEFAULT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `college` text DEFAULT NULL,
  `email` text NOT NULL,
  `charge_consumed` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `charging_log`
--
ALTER TABLE `charging_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `student_number` (`student_number`);

--
-- Indexes for table `constants`
--
ALTER TABLE `constants`
  ADD PRIMARY KEY (`constant_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_number`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `charging_log`
--
ALTER TABLE `charging_log`
  ADD CONSTRAINT `Foreign Key` FOREIGN KEY (`student_number`) REFERENCES `student` (`student_number`) ON DELETE CASCADE ON UPDATE CASCADE;

-- --------------------------------------------------------

--
-- Trigger structure for updating charge_consumed
--

DELIMITER //
CREATE TRIGGER update_charge_consumed
AFTER INSERT ON charging_log
FOR EACH ROW
BEGIN
    UPDATE student
    SET charge_consumed = charge_consumed + TIME_TO_SEC(TIMEDIFF(NEW.time_out, NEW.time_in)) / 60
    WHERE student_number = NEW.student_number;
END //

CREATE TRIGGER update_charge_consumed_update
AFTER UPDATE ON charging_log
FOR EACH ROW
BEGIN
    UPDATE student
    SET charge_consumed = charge_consumed + TIME_TO_SEC(TIMEDIFF(NEW.time_out, NEW.time_in)) / 60
    WHERE student_number = NEW.student_number;
END //
DELIMITER ;



COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
