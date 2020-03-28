-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2020 at 03:12 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cr11_lisa_petadoption`
--

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `animalID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `species` varchar(200) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `adoptableDate` date DEFAULT NULL,
  `animalImg` varchar(500) DEFAULT NULL,
  `type` enum('small','large','senior') DEFAULT 'small',
  `website` varchar(200) DEFAULT NULL,
  `fk_locationID` int(11) DEFAULT NULL,
  `adoptedByUserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`animalID`, `name`, `species`, `birthdate`, `adoptableDate`, `animalImg`, `type`, `website`, `fk_locationID`, `adoptedByUserID`) VALUES
(1, 'Guizmo', 'cat', '2010-10-31', '2020-03-27', 'https://cdn.pixabay.com/photo/2017/11/09/21/41/cat-2934720_960_720.jpg', 'senior', NULL, 1, NULL),
(2, 'Bouchon', 'cat', '2019-10-31', '2020-03-27', 'https://cdn.pixabay.com/photo/2017/11/14/13/06/kitty-2948404_960_720.jpg', 'small', 'https://www.kitty-cats.blog/', 3, NULL),
(3, 'Hamtaro', 'hamster', '2020-01-31', '2020-03-27', 'https://cdn.pixabay.com/photo/2015/03/26/09/41/hamster-690108_960_720.jpg', 'small', 'https://www.pinterest.com/transparentspec/hamtaro/', 2, NULL),
(4, 'Pikpik', 'hedgehog', '2020-03-01', '2020-03-27', 'https://cdn.pixabay.com/photo/2014/10/01/10/44/hedgehog-468228_960_720.jpg', 'small', 'https://www.highlandtitles.fr/2019/10/guide-du-herisson/', 1, NULL),
(5, 'Belle', 'dog', '2017-10-31', '2020-03-27', 'https://cdn.pixabay.com/photo/2017/07/25/04/14/great-pyrenees-2536899_960_720.jpg', 'large', NULL, 2, NULL),
(6, 'Bernard', 'dog', '2018-10-31', '2020-03-27', 'https://cdn.pixabay.com/photo/2016/08/02/20/42/domestic-dog-1564978_960_720.jpg', 'large', NULL, 3, NULL),
(7, 'Zeus', 'horse', '2010-10-31', '2020-03-27', 'https://cdn.pixabay.com/photo/2017/12/10/15/16/white-horse-3010129_960_720.jpg', 'senior', NULL, 4, NULL),
(8, 'Blacki', 'horse', '2020-01-31', '2020-03-27', 'https://cdn.pixabay.com/photo/2018/04/01/13/57/animal-3281017_960_720.jpg', 'large', NULL, 4, NULL),
(9, 'Wooly', 'sheep', '2010-10-31', '2020-03-27', 'https://cdn.pixabay.com/photo/2019/12/04/23/34/sheep-4673941_960_720.jpg', 'senior', NULL, 4, NULL),
(10, 'Billy', 'sheep', '2020-01-31', '2020-03-27', 'https://cdn.pixabay.com/photo/2019/01/03/11/53/lamb-3910805_960_720.jpg', 'large', NULL, 4, NULL),
(11, 'Gustave', 'dog', '2010-10-31', '2020-03-27', 'https://cdn.pixabay.com/photo/2015/06/08/15/02/pug-801826_960_720.jpg', 'senior', NULL, 2, NULL),
(12, 'Moustik', 'cat', '2019-10-31', '2020-03-27', 'https://cdn.pixabay.com/photo/2019/05/24/06/48/cat-4225674_960_720.jpg', 'small', 'https://www.scaryforkids.com/hello-kitty/', 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hobbies`
--

CREATE TABLE `hobbies` (
  `hobbyID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `fk_animalID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hobbies`
--

INSERT INTO `hobbies` (`hobbyID`, `name`, `fk_animalID`) VALUES
(1, 'sleeping', 1),
(2, 'eating', 1),
(3, 'playing', 12),
(4, 'snoring', 11),
(5, 'cuddling', 4),
(6, 'being outside', 9),
(7, 'sleeping', 6),
(8, 'eating', 7),
(9, 'playing', 2),
(10, 'snoring', 5),
(11, 'cuddling', 3),
(12, 'being outside', 10),
(13, 'being outside', 8);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `locationID` int(11) NOT NULL,
  `address` varchar(200) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(50) NOT NULL,
  `coordX` varchar(50) DEFAULT NULL,
  `coordY` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`locationID`, `address`, `zip`, `city`, `country`, `coordX`, `coordY`) VALUES
(1, 'Mautner-Markhof-Gasse 28', '1110', 'Vienna', 'Austria', '48.177737', '16.420788'),
(2, '2 rue avenue des chats perdus', '75000', 'Paris', 'France', '48.5112', '2.2055'),
(3, '5 Sir Dog Street', 'WC2R', 'London', 'UK', '51.3030', '-0.732'),
(4, '1 sheep way', 'F12 P6C9', 'Clonbur', 'Ireland', '53.3242', '-9.2151');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `userPass` varchar(256) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `userImg` varchar(50) DEFAULT NULL,
  `userStatus` enum('user','admin','superadmin') DEFAULT 'user',
  `fk_locationID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `firstName`, `lastName`, `email`, `userPass`, `birthdate`, `userImg`, `userStatus`, `fk_locationID`) VALUES
(1, 'lisa', 'sce', 'lisa@hmail.com', '8D969EEF6ECAD3C29A3A629280E686CF0C3F5D5A86AFF3CA12020C923ADC6C92', '1986-11-05', 'https://cdn.pixabay.com/photo/2016/01/21/08/38/chi', 'user', 1),
(2, 'admin', 'admin', 'admin@mail.com', '8D969EEF6ECAD3C29A3A629280E686CF0C3F5D5A86AFF3CA12020C923ADC6C92', '1986-11-05', 'https://cdn.pixabay.com/photo/2016/01/21/08/38/wom', 'admin', 2),
(3, 'super', 'super', 'super@mail.com', '8D969EEF6ECAD3C29A3A629280E686CF0C3F5D5A86AFF3CA12020C923ADC6C92', '1986-11-05', 'https://cdn.pixabay.com/photo/2016/01/21/08/38/wom', 'superadmin', 3),
(4, 'nihad', 'abou', 'nihad@mail.com', '8D969EEF6ECAD3C29A3A629280E686CF0C3F5D5A86AFF3CA12020C923ADC6C92', '1986-11-05', 'https://cdn.pixabay.com/photo/2016/01/21/08/38/man', 'user', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`animalID`),
  ADD KEY `fk_locationID` (`fk_locationID`),
  ADD KEY `adoptedByUserID` (`adoptedByUserID`);

--
-- Indexes for table `hobbies`
--
ALTER TABLE `hobbies`
  ADD PRIMARY KEY (`hobbyID`),
  ADD KEY `fk_animalID` (`fk_animalID`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`locationID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_locationID` (`fk_locationID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `animalID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `hobbies`
--
ALTER TABLE `hobbies`
  MODIFY `hobbyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `locationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `animals`
--
ALTER TABLE `animals`
  ADD CONSTRAINT `animals_ibfk_1` FOREIGN KEY (`fk_locationID`) REFERENCES `locations` (`locationID`),
  ADD CONSTRAINT `animals_ibfk_2` FOREIGN KEY (`adoptedByUserID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `hobbies`
--
ALTER TABLE `hobbies`
  ADD CONSTRAINT `hobbies_ibfk_1` FOREIGN KEY (`fk_animalID`) REFERENCES `animals` (`animalID`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`fk_locationID`) REFERENCES `locations` (`locationID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
