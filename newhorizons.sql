-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2022 at 10:58 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newhorizons`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `ID` int(5) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Mobile` int(9) NOT NULL,
  `Status` int(1) NOT NULL,
  `Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`ID`, `Username`, `Password`, `Mobile`, `Status`, `Email`) VALUES
(1, 'Khalid', 'f7ear8l/CJ4Rw', 775111207, 1, 'princeofimagination@gmail.com'),
(5, 'Ahmed', '99gG/vFoVdcSw', 772323972, 0, 'ahmedalshahethi04@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `ID` int(3) NOT NULL,
  `CourseName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`ID`, `CourseName`) VALUES
(1, 'Level Course'),
(2, 'Writing Course'),
(3, 'Listing Course');

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `ID` int(11) NOT NULL,
  `Student_ID` int(5) NOT NULL,
  `CourseType` int(3) NOT NULL,
  `CourseLevel` varchar(5) NOT NULL,
  `Mark` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`ID`, `Student_ID`, `CourseType`, `CourseLevel`, `Mark`) VALUES
(5, 5, 2, '5', 95);

-- --------------------------------------------------------

--
-- Table structure for table `student_inf`
--

CREATE TABLE `student_inf` (
  `Id` int(5) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Phone` int(15) NOT NULL,
  `Birthdate` date NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `CourseType` int(3) NOT NULL,
  `Level` int(5) NOT NULL,
  `Time` time NOT NULL,
  `img` varchar(255) NOT NULL,
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student_inf`
--

INSERT INTO `student_inf` (`Id`, `Name`, `Email`, `Phone`, `Birthdate`, `Username`, `Password`, `CourseType`, `Level`, `Time`, `img`, `Status`) VALUES
(2, 'Khalid', 'Khalid@gmail.com', 775111207, '2000-04-03', 'prince', 'ad/Q1kEzYgbjU', 2, 0, '08:30:00', 'WhatsApp Image 2022-06-17 at 7.53.57 PM.jpeg', 0),
(5, 'Fadi Alariqi', 'Fadi@gmail.com', 735111207, '2000-02-02', 'fadi', 'f9R5TP7kt6Fko', 3, 0, '04:30:00', 'pexels-rodnae-productions-7713511.jpg', 1),
(6, 'bnm', 'ahmedalshahe000thi04@gmail.com', 771142480, '2022-05-31', 'ahmeddd', '20CKlb72gRt4E', 1, 0, '08:30:00', 'تصميم بدون عنوان.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `ID` int(5) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Mobile` int(9) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Salary` decimal(10,0) NOT NULL,
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`ID`, `Username`, `Password`, `Mobile`, `Name`, `Email`, `Salary`, `Status`) VALUES
(2, 'kream', 'f7ear8l/CJ4Rw', 771122480, 'kream Alnozily', 'kream@gmail.com', '60000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `teachs`
--

CREATE TABLE `teachs` (
  `ID` int(5) NOT NULL,
  `teacher` int(5) NOT NULL,
  `course` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Mobile` (`Mobile`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CourseMarkeKey` (`CourseType`),
  ADD KEY `StudentMarkeKey` (`Student_ID`);

--
-- Indexes for table `student_inf`
--
ALTER TABLE `student_inf`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Phone` (`Phone`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD KEY `CourseTypeKey` (`CourseType`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Mobile` (`Mobile`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `teachs`
--
ALTER TABLE `teachs`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `teacher_teach` (`teacher`),
  ADD KEY `teacher_course` (`course`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_inf`
--
ALTER TABLE `student_inf`
  MODIFY `Id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teachs`
--
ALTER TABLE `teachs`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `marks`
--
ALTER TABLE `marks`
  ADD CONSTRAINT `CourseMarkeKey` FOREIGN KEY (`CourseType`) REFERENCES `courses` (`ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `StudentMarkeKey` FOREIGN KEY (`Student_ID`) REFERENCES `student_inf` (`Id`) ON UPDATE CASCADE;

--
-- Constraints for table `student_inf`
--
ALTER TABLE `student_inf`
  ADD CONSTRAINT `CourseTypeKey` FOREIGN KEY (`CourseType`) REFERENCES `courses` (`ID`) ON UPDATE CASCADE;

--
-- Constraints for table `teachs`
--
ALTER TABLE `teachs`
  ADD CONSTRAINT `teacher_course` FOREIGN KEY (`course`) REFERENCES `courses` (`ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `teacher_teach` FOREIGN KEY (`teacher`) REFERENCES `teachers` (`ID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
