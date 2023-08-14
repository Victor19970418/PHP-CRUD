-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2021-08-30 08:24:37
-- 伺服器版本： 10.4.20-MariaDB
-- PHP 版本： 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫: `login`
--

-- --------------------------------------------------------

--
-- 資料表結構 `file`
--

CREATE TABLE `file` (
  `MessageId` int(50) NOT NULL,
  `FileName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `file`
--

INSERT INTO `file` (`MessageId`, `FileName`) VALUES
(1, 'asset 0.jpeg'),
(1, 'asset 1.jpeg'),
(143, 'asset 0.jpeg'),
(143, 'asset 1.jpeg'),
(143, 'asset 2.jpeg'),
(143, 'asset 3.jpeg'),
(143, 'asset 8.jpeg');

-- --------------------------------------------------------

--
-- 資料表結構 `login`
--

CREATE TABLE `login` (
  `UserId` int(50) NOT NULL,
  `Account` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `AccountTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `login`
--

INSERT INTO `login` (`UserId`, `Account`, `Password`, `AccountTime`) VALUES
(1, 'Victortest', 'pop23009', '2021-08-22 23:04:08');

-- --------------------------------------------------------

--
-- 資料表結構 `messagebox`
--

CREATE TABLE `messagebox` (
  `MessageId` int(50) NOT NULL,
  `UserId` varchar(50) NOT NULL,
  `Content` varchar(200) NOT NULL,
  `Time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `messagebox`
--

INSERT INTO `messagebox` (`MessageId`, `UserId`, `Content`, `Time`) VALUES
(1, '1', '測試', '2021-08-26 16:30:45'),
(138, '2', '123', '2021-08-24 16:51:54'),
(143, '1', '2個檔', '2021-08-30 16:14:17');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`MessageId`,`FileName`);

--
-- 資料表索引 `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`UserId`);

--
-- 資料表索引 `messagebox`
--
ALTER TABLE `messagebox`
  ADD PRIMARY KEY (`MessageId`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `login`
--
ALTER TABLE `login`
  MODIFY `UserId` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `messagebox`
--
ALTER TABLE `messagebox`
  MODIFY `MessageId` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
