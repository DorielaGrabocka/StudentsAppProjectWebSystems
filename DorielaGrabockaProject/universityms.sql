-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2020 at 04:11 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `universityms`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `ID` int(5) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Instructor` varchar(255) NOT NULL,
  `Credits` int(2) NOT NULL,
  `Day` varchar(255) NOT NULL,
  `Time` varchar(255) NOT NULL,
  `Class` varchar(255) NOT NULL,
  `Department` varchar(255) NOT NULL,
  `Faculty` varchar(255) NOT NULL,
  `Eligibility` varchar(5) NOT NULL DEFAULT '-' COMMENT 'Who can take this course?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`ID`, `Title`, `Instructor`, `Credits`, `Day`, `Time`, `Class`, `Department`, `Faculty`, `Eligibility`) VALUES
(1, 'Abnormal Psycology', 'Tony Adams', 3, 'Thursday', '13:00-16:00', 'CoLAB', 'Psychology', 'Law & Social Sciences', '-'),
(2, 'Advanced Accounting', 'Judy Wiliams', 4, 'Wednesday', '13:00-16:00', 'LAB 2', 'Finance', 'Economy & Business', '-'),
(4, 'Advanced Business English', 'Michele Herbert', 3, 'Tuesday', '13:00-16:00', '3F', 'Finance', 'Economy & Business', 'All'),
(5, 'Advanced Finance', 'Eda Stewart', 3, 'Friday', '10:00-13:00', '3F', 'Finance', 'Economy & Business', '-'),
(6, 'Algorithms & Complexity', 'Edi Heisenhouer', 3, 'Monday', '17:00-20:00', 'COLAB', 'Computer Science', 'Informatics', '-'),
(7, 'Business Information Systems', 'Maria Curies', 3, 'Tuesday', '13:00-16:00', '3E', 'Computer Science', 'Informatics', '-'),
(8, 'Business Policy', 'Ariana Smith', 4, 'Friday', '09:00:13:00', '1F', 'Business Administration', 'Economy & Business', '-'),
(9, 'Calculus', 'Mira Tenant', 4, 'Wednesday', '09:00-13:00', 'LAB 1', 'Computer Science', 'Informatics', '-'),
(10, 'Calculus 2', 'Cathleen Robinson', 4, 'Monday', '09:30-13:30', '3E', 'Computer Science', 'Informatics', '-'),
(11, 'Cognitive Psycology', 'Eni Barbarosa', 4, 'Tuesday', '13:00-13:00', '4', 'Psychology', 'Social Sciences', '-'),
(12, 'Composition 2', 'Ovin Lancaster', 3, 'Wednesday', '13:00-16:00', 'Theatre', 'Economy', 'Informatics', 'All'),
(13, 'Composition 2', 'Clarie Hoppkins', 3, 'Monday', '13:00-16:00', '1E', 'Economy', 'IT', 'All'),
(14, 'Computer Applications', 'Heiden Stallone', 3, 'Monday', '13:00-16:00', 'LAB 2', 'Computer Science', 'Informatics', 'All'),
(15, 'Computer Operations and Security', 'Elian Roader', 4, 'Tuesday', '13:30-17:30', 'LAB 3', 'Computer Science', 'Informatics', '-'),
(16, 'Data Structures', 'Olgerta Heminguey', 3, 'Tuesday', '09:00-12:00', 'LAB 3', 'Computer Science', 'Informatics', '-'),
(17, 'Eastern Empires', 'Adam Ehrlich', 3, 'Monday', '13:00-16:00', '3E', 'Psychology', 'Law & Social Sciences', 'All'),
(18, 'Ecometrics', 'Jaiden Milwakee', 4, 'Monday', '13:00-16:00', '1F', 'Finance', 'Economy & Business', '-'),
(19, 'College Algebra & Trigonometry', 'Dwein White', 3, 'Thursday ', '12:00-15:00', '1F', 'Mathematics', 'Mathematics', 'All'),
(20, 'Discrete Mathematics(Mathematics Only)', 'Dwein White', 4, 'Friday', '15:00-19:00', '3G', 'Mathematics', 'Informatics', '-');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Surname` varchar(255) NOT NULL,
  `Birthday` date NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Major` varchar(255) NOT NULL,
  `Minor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`ID`, `Name`, `Surname`, `Birthday`, `Email`, `Major`, `Minor`) VALUES
(1000, 'Doriela', 'Grabocka', '1999-03-11', 'dorielag18@gmail.com', 'Computer Science', '-'),
(1001, 'Ann', 'Tomson', '1990-01-10', 'anntomson@gmail.com', 'Psychology', '-'),
(1003, 'Helen', 'Herbert', '1996-01-07', 'hherbert@yahoo.com', 'Computer Science', '-'),
(1004, 'Mark', 'Smith', '1998-06-20', 'msmith@yahoo.com', 'Psychology', '-'),
(1005, 'Steven', 'Holland', '1999-12-25', 'sholland@hotmail.com', 'Mathematics', 'Computer Science'),
(1006, 'Oliver', 'Khan', '1996-05-01', 'oliverkhan@gmail.com', 'Computer Science', 'Mathematics'),
(1007, 'Ann', 'Williamson', '1994-04-08', 'annawill@gmail.com', 'Business Administration', 'Marketing'),
(1008, 'William', 'Tennison', '1999-11-05', 'willten@gmail.com', 'Finance', 'Business Administration');

-- --------------------------------------------------------

--
-- Table structure for table `studentcourse`
--

CREATE TABLE `studentcourse` (
  `StudentID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `studentcourse`
--

INSERT INTO `studentcourse` (`StudentID`, `CourseID`) VALUES
(1000, 6),
(1000, 10),
(1000, 16),
(1000, 17),
(1001, 1),
(1001, 11),
(1001, 17),
(1001, 19),
(1003, 6),
(1003, 7),
(1003, 10),
(1003, 12),
(1004, 13),
(1004, 14),
(1004, 17),
(1004, 19),
(1005, 14),
(1005, 17),
(1005, 19),
(1005, 20),
(1006, 17),
(1006, 19),
(1006, 20),
(1007, 8),
(1007, 17),
(1008, 2),
(1008, 4),
(1008, 5),
(1008, 18);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(4) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Surname` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `Name`, `Surname`, `Email`, `Username`, `Password`) VALUES
(1000, 'Ann', 'Smith', 'annsmith@unyt.edu.al', 'annsmith', '21232F297A57A5A743894A0E4A801FC3'),
(1001, 'Robert', 'Gutenberg', 'robertgutenberg@unyt.edu.al', 'robertgutenberg', '21232F297A57A5A743894A0E4A801FC3'),
(1002, 'John', 'Doe', 'johndoe@unyt.edu.al', 'johndoe', '21232f297a57a5a743894a0e4a801fc3'),
(1005, 'Doriela', 'Grabocka', 'dorig@unyt.edu.al', 'dg', '2f7e54fe9de9db73067f562bc22d6eae'),
(1006, 'Viki', 'Grabocka', 'vikig@unyt.edu.al', 'vikig', 'f9c6c8f750a09ab5096618df3ad3a9c6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `studentcourse`
--
ALTER TABLE `studentcourse`
  ADD PRIMARY KEY (`StudentID`,`CourseID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1019;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1011;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
