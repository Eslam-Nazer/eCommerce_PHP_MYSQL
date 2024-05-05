-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2024 at 11:53 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_ads`) VALUES
(3, 'mobiles', 'This is a new category for mobiles', 2, 0, 0, 1),
(7, 'PlayStation4', 'PlayStation4 games & devices', 7, 0, 0, 0),
(8, 'Hand made', 'Hand made items', 4, 0, 0, 0),
(9, 'Computers', 'Computers items', 5, 0, 0, 0),
(10, 'Cell Phone', 'Cell Phone items', 6, 0, 0, 0),
(11, 'Clothing', 'Clothing And Fashion items', 8, 0, 0, 0),
(12, 'Tools', 'Home tools items', 9, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_date` date NOT NULL,
  `status` tinyint(4) NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `comment_date`, `status`, `item_id`, `user_id`) VALUES
(1, 'thanks alot so much', '2024-04-14', 1, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Image`, `Status`, `Rating`, `Cat_ID`, `Member_ID`, `Approve`) VALUES
(1, 'GTA 5', 'Amazing play in PS4', '90$', '2024-04-05', 'USA', '', '4', 0, 7, 5, 0),
(4, 'test', 'test', '123$', '2024-04-07', 'Eg', '', '2', 0, 3, 3, 0),
(5, 'Asus rog 2700', 'labtop Asus Gaming', '2000$', '2024-04-23', 'UK', '', '1', 0, 9, 5, 0),
(6, 'samsung A12', 'Amazing samsung mobile', '50$', '2024-04-23', 'China', '', '2', 0, 3, 6, 0),
(7, 'T-shirt', 'Black T-shirt Made of cotton', '20$', '2024-04-23', 'Uas', '', '1', 0, 11, 4, 0),
(8, 'IPhone X', 'Apple Mobile made in 2015 it have 4g ram 64 Gb memory, color balck, 2 camera', '100$', '2024-04-26', 'China', '', '1', 0, 3, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL COMMENT 'User Name For Login',
  `Password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `FullName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0 COMMENT 'Identify Users Group',
  `TrustStatus` int(11) NOT NULL DEFAULT 0,
  `RegStatus` int(11) NOT NULL DEFAULT 0,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`) VALUES
(1, 'Eslam', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'eslam@info.net', 'Eslam Nazer', 1, 0, 1, '2024-03-01'),
(2, 'Gehad', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'gehad@gmail.com', 'Gehad Ahmed', 1, 0, 1, '2024-03-08'),
(3, 'Mohammed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mohammed@gmail.com', 'Mohammed Ahmed', 0, 0, 0, '2024-03-13'),
(4, 'Ahmed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ahmed@gmail.com', 'Ahmed Mohammed', 0, 0, 0, '2024-03-06'),
(5, 'Mahmoud', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mahmoud@gmail.com', 'Mahmoud Shrif', 0, 0, 0, '2024-03-11'),
(6, 'Sherif', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'shrif.aa@gmail.com', 'Shrif Ahmed', 0, 0, 1, '2024-03-17'),
(9, 'Apps', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'app@app.test', 'Application', 0, 0, 0, '2024-04-28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `items_comment` (`item_id`),
  ADD KEY `user_comment` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `Member_ID` (`Member_ID`),
  ADD KEY `Cat_ID` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `UserID` (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_comment` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
