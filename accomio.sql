-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2025 at 07:31 AM
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
-- Database: `accomio`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `bookings_id` int(11) NOT NULL,
  `customers_id` int(11) NOT NULL,
  `hotels_id` int(11) NOT NULL,
  `rooms_id` int(11) NOT NULL,
  `adults` int(11) NOT NULL,
  `kids` int(11) NOT NULL,
  `name` text NOT NULL,
  `surname` text NOT NULL,
  `email` text NOT NULL,
  `telephone` text NOT NULL,
  `address` text NOT NULL,
  `nationality` text NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `price` int(11) NOT NULL,
  `payment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`bookings_id`, `customers_id`, `hotels_id`, `rooms_id`, `adults`, `kids`, `name`, `surname`, `email`, `telephone`, `address`, `nationality`, `date_from`, `date_to`, `price`, `payment`) VALUES
(8, 29, 6, 32, 2, 1, 'Ján', 'Ivičič', 'janivicic9@gmail.com', '+421918700919', 'Bradáčova 2', 'Slovak', '2025-05-13', '2025-05-15', 450, 'In hotel'),
(15, 29, 6, 32, 2, 1, 'Ján', 'Ivičič', 'janivicic9@gmail.com', '+421918700919', 'Bradáčova 2', 'Slovak', '2025-06-20', '2025-06-22', 450, 'In hotel'),
(17, 29, 6, 32, 2, 1, 'Ján', 'Ivičič', 'janivicic9@gmail.com', '+421918700919', 'Bradáčova 2, Bratislava, Slovakia', 'Slovak', '2025-07-29', '2025-08-05', 1575, 'In hotel'),
(18, 29, 6, 32, 1, 0, 'Ján', 'Ivičič', 'janivicic9@gmail.com', '+421918700919', 'Bradáčova 2, Bratislava, Slovakia', 'Slovak', '2025-07-18', '2025-07-20', 180, 'In hotel'),
(19, 29, 6, 32, 1, 0, 'Ján', 'Ivičič', 'janivicic9@gmail.com', '+421918700919', 'Bradáčova 2, Bratislava, Slovakia', 'Slovak', '2025-07-18', '2025-07-20', 180, 'In hotel');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `read` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `message`, `date`, `read`) VALUES
(2, 'Ján', 'janivicic9@gmail.com', 'Ahoj, ako sa máš, vedúci?', '2025-06-10 15:12:17', 1),
(3, 'Maťko', 'matko@matko.eu', 'Zdravím, viem sa ubytovať niekde aj zadarmo? Ďakujem.', '2025-06-10 15:11:49', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customers_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `surname` text NOT NULL,
  `email` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `telephone` text NOT NULL,
  `nationality` text NOT NULL,
  `address` text NOT NULL,
  `code` text NOT NULL,
  `log` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customers_id`, `name`, `surname`, `email`, `password`, `telephone`, `nationality`, `address`, `code`, `log`) VALUES
(12, 'Frodo', 'Bublík', 'frodo@bublik.com', '$2y$10$/mLpj5O3WM.k9Wz.1i6bQORGaeE05g4xdp7gotWQfh7h1fxBULLka', '+4219000123456', 'Czech', 'Vreckany 1, Hobitov, Czech republic', '0', '0'),
(13, 'Frodo', 'Bublík', 'frodo@bublik.com', '$2y$10$SRaQVT.huPPaT4WJlESTJeDsVyY/ygGR8HxyPFHN0DA5lIAFabIeK', '+4219000123456', 'Czech', 'Vreckany 1, Hobitov, Czech republic', '0', '0'),
(16, 'Ján Ivičič', '2', 'ahoj@aa.aa', '$2y$10$Hkwq9/0GlzQLZMxZJZ34pOwERyzMyJApfXvuX6wLG1xYxRIyohJcy', '+4210918700919', 'Slovak', 'Gercenova 10, Bratislava, Slovakia', '0', '0'),
(21, 'Ján', 'Ivičič', 'nadtatrou@sablyska.sk', '$2y$10$HfsCphjsvNiy857k6.8ta.QXiQ5vTaMT0rXJuonr7Vw788rsywTG6', '+4200918700919', 'admin', 'Gercenova 10, Bratislava, Slovakia', '0', '0'),
(26, 'Ján', 'Ivičič', 'asa@s.a', '$2y$10$krMmZNCP5Qy.QUZ2m5NMWeQehs51jfS7C6dQVq3ApOd8L6WV3SpPO', '+420918700919', '', 'Gercenova 10, Bratislava, Slovakia', '0', '0'),
(27, 'Ján', 'Ivičič', 'asa@s.ad', '$2y$10$Zo1hIPvwwywOzHc6WzfhXeNysLx7oCyoj.DBJLWvh9bPO9cnsPN5e', '+420918700919', 'Czech', 'Gercenova 10, Bratislava, Slovakia', 'bf99f2a80a5815a42c344ecfd44545b7', ''),
(29, 'Ján', 'Ivičič', 'janivicic9@gmail.com', '$2y$10$hY9VlS/.9ysSoIA93ear4.vygA4ebkiS3QJGkRGVZkKF0aaaBqjlO', '+421918700919', 'Slovak', 'Gercenova 10, Bratislava, Slovakia', '3c3e44abd1487d5229eb84c35daf1f5c', '$2y$10$A2Zf0HtIib8Wr7jmdz2nQOu5fft7XRVdOIC9t0S4LPeLF5NjTewBi'),
(30, 'Ján', 'Ivičič', 'nejaky@mail.com', '$2y$10$mHvIBiXEv6r3HUK2TBhBdegEiHfuxceKOTwlK8MU6BmbaS3TNBrwK', '+420918700919', 'Czech', 'Gercenova 10, Bratislava, Slovakia', '673493e69d6bbfd772733ad2d4389019', ''),
(31, 'Admin', 'Accomio', 'admin@accomio', '$2y$10$A.tOVhEwlICoq.iEjDRt1.7c/VHa8hHnt9Q7TIxBUfLaS092LDFLe', '+4210', 'admin', 'a, a, Slovakia', '2a9b044015537275c0c56a3f35317363', '$2y$10$/B.sykSD6vUhcZehW2mw/eHsfwJuPpl61zbb4QkXPaW/uYY3.9GqK'),
(32, 'Hostinský  Maslík', '6', 'hostinsky.maslik@stredozem.com', '$2y$10$9nCPqI4Ypjbd86btGKm6VeM/.q7QhGH2UHI..gi35.VolBPGxTKki', '+421999999999', 'partner', 'Svažiny 1, Svažiny, Slovakia', '4cb6ae69bf468aca911f997c54a97518', '$2y$10$mXhpV/maOG/yiTctVwhSvee1t7o9w41gINII2f7PHwBlnNmQptZgW'),
(33, 'Anton', 'Aladin', 'aabbs@shn.eu', '$2y$10$nI4e01czmzLB371iapm1yepKaHVMCEz4FU5muzCiCwc9AHDkoHSee', '+421918700919', 'Czech', 'Gercenova 10, Bratislava, Slovakia', '278b009af688822a087f955299362ae4', '');

-- --------------------------------------------------------

--
-- Table structure for table `hotels_info`
--

CREATE TABLE `hotels_info` (
  `hotels_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `location` text NOT NULL,
  `country` text NOT NULL,
  `map` text NOT NULL,
  `url` text NOT NULL,
  `kids_price` float NOT NULL,
  `description` text NOT NULL,
  `facility` text NOT NULL,
  `contact` text NOT NULL,
  `price` int(11) NOT NULL,
  `rating` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Dumping data for table `hotels_info`
--

INSERT INTO `hotels_info` (`hotels_id`, `name`, `location`, `country`, `map`, `url`, `kids_price`, `description`, `facility`, `contact`, `price`, `rating`) VALUES
(1, 'Hotel Melania', 'Trogir', 'Chorvátsko', '', 'hotel-melania', 0.5, '', '', '', 140, 0),
(2, 'Hotel Vienna', 'Viedeň', 'Rakúsko', '', 'hotel-vienna', 0.5, '', '', '', 150, 0),
(3, 'Penzión Zjazdovka', 'Mýto pod Ďumbierom', 'Slovensko', '', 'penzion-zjazdovka', 0.5, '', '', '', 80, 0),
(4, 'Hotel De Luxe', 'Londýn', 'Veľká Británia', '', 'hotel-de-luxe', 0.5, '', '', '', 190, 4),
(5, 'Chata Púpava', 'Bystrá', 'Slovensko', '', 'chata-pupava', 0.5, '', '', '', 70, 0),
(6, 'Hostinec U skákavého poníka', 'Svažiny', 'Stredozem', '            <iframe class=\"hotelimg\" src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1872.6918677266315!2d175.681823707841!3d-37.872461622920184!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6d6dab6237e84a77%3A0x24ff7cd6a8f521a6!2sHobbiton%E2%84%A2%20Movie%20Set%20Tours!5e0!3m2!1ssk!2ssk!4v1744888520937!5m2!1ssk!2ssk\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'hostinec-u-skakaveho-ponika', 0.5, 'Zastavte sa na ceste pri krígli dobrého piva! Nezáleží, či ste hobit, trpaslík, elf alebo ohyzd!\nUbytujte sa v najslávnejšom hostinci malebného mesta Svažiny! Hostinský Maslík vás rád privíta pod svojou strechou.', '<div class=\"facility\"><img class=\"facilityimg\" src=\"styles/icons/wifi.svg\"><br>Wi-Fi</div><div class=\"facility\"><img class=\"facilityimg\" src=\"styles/icons/parking.svg\"><br>Parkovisko pre kone</div><div class=\"facility\"><img class=\"facilityimg\" src=\"styles/icons/restaurant.svg\"><br>Reštaurácia</div><div class=\"facility\"><img class=\"facilityimg\" src=\"styles/icons/bar.svg\"><br>Non-stop bar</div>', 'hostinsky.maslik@stredozem.com', 90, 4.4);

-- --------------------------------------------------------

--
-- Table structure for table `hotels_reviews`
--

CREATE TABLE `hotels_reviews` (
  `reviews_id` int(11) NOT NULL,
  `bookings_id` int(11) NOT NULL,
  `hotels_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` text NOT NULL,
  `date` date NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Dumping data for table `hotels_reviews`
--

INSERT INTO `hotels_reviews` (`reviews_id`, `bookings_id`, `hotels_id`, `rating`, `review`, `date`, `name`) VALUES
(1, 0, 6, 5, 'Pekný hostinec. Hostinský niekedy zabúda, ale je to veľmi dobrý človek.', '2025-04-03', 'Gandalf'),
(2, 0, 6, 4, 'Jeden z mála hostincov so špeciálnymi izbami pre hobitov. Veľmi oceňujem!', '2025-04-15', 'Frodo'),
(3, 0, 6, 4, '', '2025-04-19', 'Aragorn'),
(12, 8, 6, 4, 'Veľmi pekný hotel. Rád sa tu opäť zastavím, keď pôjdem týmto malebným krajom Svažín.', '2025-06-22', 'Anonymný hosť');

--
-- Triggers `hotels_reviews`
--
DELIMITER $$
CREATE TRIGGER `rating` AFTER INSERT ON `hotels_reviews` FOR EACH ROW BEGIN
  UPDATE hotels_info
  SET rating = (
    SELECT ROUND(AVG(rating), 1)
    FROM hotels_reviews
    WHERE hotels_id = NEW.hotels_id
  )
  WHERE hotels_id = NEW.hotels_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `hotels_rooms`
--

CREATE TABLE `hotels_rooms` (
  `rooms_id` int(11) NOT NULL,
  `hotels_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `room_name` text NOT NULL,
  `room_capacity` int(11) NOT NULL,
  `room_price` int(11) NOT NULL,
  `room_info` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Dumping data for table `hotels_rooms`
--

INSERT INTO `hotels_rooms` (`rooms_id`, `hotels_id`, `room_id`, `room_name`, `room_capacity`, `room_price`, `room_info`) VALUES
(1, 1, 1, 'Štvorlôžková izba', 4, 140, 'Izba s výhľadom na more. Samostatná kúpeľňa, chladnička a televízor samozrejmosťou. Recepcia dostupná 24/7.'),
(2, 1, 2, 'Štvorlôžková izba', 4, 140, 'Izba s výhľadom na more. Samostatná kúpeľňa, chladnička a televízor samozrejmosťou. Recepcia dostupná 24/7.'),
(3, 1, 3, 'Štvorlôžková izba', 4, 140, 'Izba s výhľadom na more. Samostatná kúpeľňa, chladnička a televízor samozrejmosťou. Recepcia dostupná 24/7.'),
(4, 1, 4, 'Štvorlôžková izba', 4, 140, 'Izba s výhľadom na more. Samostatná kúpeľňa, chladnička a televízor samozrejmosťou. Recepcia dostupná 24/7.'),
(5, 1, 5, 'Štvorlôžková izba', 4, 140, 'Izba s výhľadom na more. Samostatná kúpeľňa, chladnička a televízor samozrejmosťou. Recepcia dostupná 24/7.'),
(6, 1, 6, 'Dvojlôžková izba', 2, 140, 'Izba s výhľadom na more. Samostatná kúpeľňa, chladnička a televízor samozrejmosťou. Recepcia dostupná 24/7.'),
(7, 1, 7, 'Dvojlôžková izba', 2, 140, 'Izba s výhľadom na more. Samostatná kúpeľňa, chladnička a televízor samozrejmosťou. Recepcia dostupná 24/7.'),
(8, 1, 8, 'Dvojlôžková izba', 2, 140, 'Izba s výhľadom na more. Samostatná kúpeľňa, chladnička a televízor samozrejmosťou. Recepcia dostupná 24/7.'),
(9, 1, 9, 'Dvojlôžková izba', 2, 140, 'Izba s výhľadom na more. Samostatná kúpeľňa, chladnička a televízor samozrejmosťou. Recepcia dostupná 24/7.'),
(10, 1, 10, 'Dvojlôžková izba', 2, 140, 'Izba s výhľadom na more. Samostatná kúpeľňa, chladnička a televízor samozrejmosťou. Recepcia dostupná 24/7.'),
(11, 2, 1, 'Dvojlôžková izba', 2, 150, 'Nádherná izba, ktorá vás zaručene prenesie do obdobia princov a princezien.'),
(12, 2, 2, 'Dvojlôžková izba', 2, 150, 'Nádherná izba, ktorá vás zaručene prenesie do obdobia princov a princezien.'),
(13, 2, 3, 'Dvojlôžková izba', 2, 150, 'Nádherná izba, ktorá vás zaručene prenesie do obdobia princov a princezien.'),
(14, 2, 4, 'Dvojlôžková izba', 2, 150, 'Nádherná izba, ktorá vás zaručene prenesie do obdobia princov a princezien.'),
(15, 2, 5, 'Dvojlôžková izba', 2, 150, 'Nádherná izba, ktorá vás zaručene prenesie do obdobia princov a princezien.'),
(16, 2, 6, 'Dvojlôžková izba', 2, 150, 'Nádherná izba, ktorá vás zaručene prenesie do obdobia princov a princezien.'),
(17, 2, 7, 'Dvojlôžková izba', 2, 150, 'Nádherná izba, ktorá vás zaručene prenesie do obdobia princov a princezien.'),
(18, 2, 8, 'Päťlôžková izba', 5, 150, 'Nádherná izba, ktorá vás zaručene prenesie do obdobia princov a princezien.'),
(19, 2, 9, 'Päťlôžková izba', 5, 150, 'Nádherná izba, ktorá vás zaručene prenesie do obdobia princov a princezien.'),
(20, 2, 10, 'Päťlôžková izba', 5, 150, 'Nádherná izba, ktorá vás zaručene prenesie do obdobia princov a princezien.'),
(21, 3, 1, 'Päťlôžková izba', 5, 80, 'Izba v malebnom prostredí Mýta pod Ďumbierom. 100 metrov od svahu. Pre naších hostí ponúkame aj lyžiareň.'),
(22, 3, 2, 'Päťlôžková izba', 5, 80, 'Izba v malebnom prostredí Mýta pod Ďumbierom. 100 metrov od svahu. Pre naších hostí ponúkame aj lyžiareň.'),
(23, 3, 3, 'Päťlôžková izba', 5, 80, 'Izba v malebnom prostredí Mýta pod Ďumbierom. 100 metrov od svahu. Pre naších hostí ponúkame aj lyžiareň.'),
(24, 3, 4, 'Päťlôžková izba', 5, 80, 'Izba v malebnom prostredí Mýta pod Ďumbierom. 100 metrov od svahu. Pre naších hostí ponúkame aj lyžiareň.'),
(25, 3, 5, 'Trojlôžková izba', 3, 80, 'Izba v malebnom prostredí Mýta pod Ďumbierom. 100 metrov od svahu. Pre naších hostí ponúkame aj lyžiareň.'),
(26, 4, 1, 'Dvojlôžková izba', 2, 190, 'Najluxusnejšia izba v celom Londýne. Hotelová služba non-stop k Vašim službám.'),
(27, 4, 2, 'Dvojlôžková izba', 2, 190, 'Najluxusnejšia izba v celom Londýne. Hotelová služba non-stop k Vašim službám.'),
(28, 4, 3, 'Dvojlôžková izba', 2, 190, 'Najluxusnejšia izba v celom Londýne. Hotelová služba non-stop k Vašim službám.'),
(29, 4, 4, 'Trojlôžková izba', 2, 190, 'Najluxusnejšia izba v celom Londýne. Hotelová služba non-stop k Vašim službám.'),
(30, 4, 5, 'Trojlôžková izba', 2, 190, 'Najluxusnejšia izba v celom Londýne. Hotelová služba non-stop k Vašim službám.'),
(31, 5, 1, 'Celý objekt', 15, 70, 'Chata situovaná v tichej lokalite pod lesom. Prenajíma sa len ako celý objekt.'),
(32, 6, 1, 'Normálna izba', 3, 90, 'Izba vhodná pre všetkých pútnikov, ktorí potrebujú niekde skloniť hlavu.'),
(33, 6, 2, 'Normálna izba', 3, 90, 'Izba vhodná pre všetkých pútnikov, ktorí potrebujú niekde skloniť hlavu.'),
(34, 6, 3, 'Normálna izba', 3, 90, 'Izba vhodná pre všetkých pútnikov, ktorí potrebujú niekde skloniť hlavu.'),
(35, 6, 4, 'Normálna izba', 3, 90, 'Izba vhodná pre všetkých pútnikov, ktorí potrebujú niekde skloniť hlavu.'),
(36, 6, 5, 'Hobitia izba', 3, 90, 'Izba vhodná pre všetkých hobitov, ktorí putujú týmto krajom a potrebujú niekde skloniť hlavu.'),
(37, 6, 6, 'Hobitia izba', 3, 90, 'Izba vhodná pre všetkých hobitov, ktorí putujú týmto krajom a potrebujú niekde skloniť hlavu.');

--
-- Triggers `hotels_rooms`
--
DELIMITER $$
CREATE TRIGGER `price` AFTER UPDATE ON `hotels_rooms` FOR EACH ROW BEGIN
  UPDATE hotels_info
  SET price = (
    SELECT MIN(room_price)
    FROM hotels_rooms
    WHERE hotels_id = NEW.hotels_id
  )
  WHERE hotels_id = NEW.hotels_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` int(11) NOT NULL,
  `original` text NOT NULL,
  `lang` text NOT NULL,
  `new` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `original`, `lang`, `new`) VALUES
(1, 'accomio | Hotely, penzióny a omnoho viac', 'en', 'accomio | Hotels, guesthouses and much more'),
(2, 'accomio | Hotely, penzióny a omnoho viac', 'de', 'accomio | Hotels, Pensionen und vieles mehr'),
(3, 'Vyhľadávanie', 'en', 'Search'),
(4, 'Vyhľadávanie', 'de', 'Suchen'),
(5, 'Jazyk', 'en', 'Language'),
(6, 'Jazyk', 'de', 'Sprache'),
(7, 'Zákaznícka podpora', 'en', 'Support'),
(8, 'Zákaznícka podpora', 'de', 'Hilfe'),
(9, 'Používateľ', 'en', 'User'),
(10, 'Používateľ', 'de', 'Benutzer'),
(11, 'Prihláste sa/Registrujte sa', 'en', 'Login/Register'),
(13, 'Môj účet', 'en', 'My account'),
(14, 'Môj účet', 'de', 'Mein Konto'),
(15, 'Odhlásiť sa', 'en', 'Log out'),
(16, 'Odhlásiť sa', 'de', 'Ausloggen'),
(17, 'Kam to dnes bude?', 'en', 'Where are you traveling today?'),
(18, 'Kam to dnes bude?', 'de', 'Wohin reisen Sie heute?'),
(19, 'Kam cestujete?', 'en', 'Where are you traveling to?'),
(20, 'Kam cestujete?', 'de', 'Wohin reisen Sie?'),
(21, 'Príchod', 'en', 'Check-in'),
(22, 'Príchod', 'de', 'Check-in'),
(23, 'Odchod', 'de', 'Check-out'),
(24, 'Odchod', 'en', 'Check-out'),
(25, 'Počet dospelých', 'en', 'Adults'),
(26, 'Počet dospelých', 'de', 'Erwachsene'),
(27, 'Počet detí', 'en', 'Children'),
(28, 'Počet detí', 'de', 'Kinder'),
(29, 'Zoradiť', 'en', 'Sort'),
(30, 'Zoradiť', 'de', 'Sortieren'),
(31, 'Najnižšia cena', 'en', 'Lowest price'),
(32, 'Najnižšia cena', 'de', 'Niedrigster Preis'),
(33, 'Najvyššia cena', 'en', 'Highest price'),
(34, 'Najvyššia cena', 'de', 'Höchster Preis'),
(35, 'Najlepšie hodnotenie', 'en', 'Best rating'),
(36, 'Najlepšie hodnotenie', 'de', 'Beste Bewertung'),
(37, 'Všetky práva vyhradené.', 'en', 'All rights reserved.'),
(38, 'Všetky práva vyhradené.', 'de', 'Alle Rechte vorbehalten.'),
(39, 'Pre zákazníkov', 'en', 'For customers'),
(40, 'Pre zákazníkov', 'de', 'Für Kunden'),
(41, 'Všeobecné podmienky', 'en', 'Terms and conditions'),
(42, 'Všeobecné podmienky', 'de', 'Allgemeine Geschäftsbedingungen'),
(43, 'Ochrana súkromia', 'en', 'Privacy'),
(44, 'Ochrana súkromia', 'de', 'Datenschutz'),
(45, 'O nás', 'en', 'About us'),
(46, 'O nás', 'de', 'Über uns'),
(47, 'Kontakt', 'en', 'Contact'),
(48, 'Kontakt', 'de', 'Kontakt'),
(49, 'Pre partnerov', 'en', 'For partners'),
(50, 'Pre partnerov', 'de', 'Für Partner'),
(51, 'Vyhľadať', 'en', 'Search'),
(52, 'Vyhľadať', 'de', 'Suchen'),
(53, 'Platforma, na ktorej nájdete ubytovanie, ktoré hľadáte.', 'en', 'A platform where you can find the accommodation you are looking for.'),
(54, 'Platforma, na ktorej nájdete ubytovanie, ktoré hľadáte.', 'de', 'Eine Plattform, auf der Sie die Unterkunft finden können, die Sie suchen.'),
(55, 'Túto platformu vytvoril Ján Ivičič ako projekt v programe DofE (medzinárodné ocenenie Duke of Edinburgh) v rokoch 2024 až 2025. Pri jej tvorbe prvýkrát v živote použil programovací jazyk PHP a prvýkrát pracoval s MySQL databázami. Snažil sa ju vytvoriť tak, aby bola čo najvyužitelnejšia v praxi. Niektoré veci by bolo treba ešte vylepšiť, ale aj tak je to podľa neho dobrý základ pre jeho ďalšie projekty. Autorova veľká vďaka patrí Mgr. Jánovi Pašuthovi, ktorý bol jeho mentorom v tejto DofE výzve.<br><br>Autor je veľkým fanúšikom Pána Prsteňov (The Lord of The Rings), čo sa prejavilo aj pri vymýšlaní tejto stránky. Nájdete tu preto napríklad možnosť rezervovať si izbu v <a href=\"hostinec-u-skakaveho-ponika\">Hostinci u skákavého poníka</a> v Svažinách, známeho z tohto príbehu.<br><br><i>Všetky hotely a informácie na tejto stránke sú fiktívne. Všetky obrázky sú použité len na účely prezentácie a nie sú jeho autorským dielom.</i>', 'en', 'This platform was created by Ján Ivičič as a project in the DofE program (the international Duke of Edinburgh award) in 2024-2025. When creating it, he used the PHP programming language for the first time in his life and worked with MySQL databases for the first time. He tried to create it so that it would be as usable in practice as possible. Some things could still be improved, but according to him, it is still a good basis for his other projects. The author\'s great thanks go to Mgr. Ján Pašuth, who was his mentor in this DofE challenge.<br><br>The author is a big fan of The Lord of The Rings, which was also reflected in the creation of this site. For example, you will find the opportunity to book a room at the <a href=\"hostinec-u-skakaveho-ponika\">The Prancing Pony Inn</a> in Bree, known from this story.<br><br><i>All hotels and information on this site are fictitious. All images are used for presentation purposes only and are not his copyrighted work.</i>'),
(56, 'Túto platformu vytvoril Ján Ivičič ako projekt v programe DofE (medzinárodné ocenenie Duke of Edinburgh) v rokoch 2024 až 2025. Pri jej tvorbe prvýkrát v živote použil programovací jazyk PHP a prvýkrát pracoval s MySQL databázami. Snažil sa ju vytvoriť tak, aby bola čo najvyužitelnejšia v praxi. Niektoré veci by bolo treba ešte vylepšiť, ale aj tak je to podľa neho dobrý základ pre jeho ďalšie projekty. Autorova veľká vďaka patrí Mgr. Jánovi Pašuthovi, ktorý bol jeho mentorom v tejto DofE výzve.<br><br>Autor je veľkým fanúšikom Pána Prsteňov (The Lord of The Rings), čo sa prejavilo aj pri vymýšlaní tejto stránky. Nájdete tu preto napríklad možnosť rezervovať si izbu v <a href=\"hostinec-u-skakaveho-ponika\">Hostinci u skákavého poníka</a> v Svažinách, známeho z tohto príbehu.<br><br><i>Všetky hotely a informácie na tejto stránke sú fiktívne. Všetky obrázky sú použité len na účely prezentácie a nie sú jeho autorským dielom.</i>', 'de', 'Diese Plattform wurde von Ján Ivičič als Projekt im Rahmen des DofE-Programms (dem internationalen Duke of Edinburgh Award) in den Jahren 2024–2025 erstellt. Dabei verwendete er zum ersten Mal die Programmiersprache PHP und arbeitete erstmals mit MySQL-Datenbanken. Er bemühte sich, die Plattform so praxistauglich wie möglich zu gestalten. Zwar gibt es noch Verbesserungspotenzial, doch bietet sie seiner Meinung nach eine gute Grundlage für seine weiteren Projekte. Der Autor dankt Mgr. Ján Pašuth, der ihn bei dieser DofE-Challenge betreute.<br><br>Der Autor ist ein großer Fan von „Der Herr der Ringe“, was sich auch in der Erstellung dieser Website widerspiegelte. So finden Sie beispielsweise die Möglichkeit, ein Zimmer im aus dieser Geschichte bekannten <a href=\"hostinec-u-skakaveho-ponika\">Gasthaus „Zum Tänzelnden Pony“</a> in Bree zu buchen.<br><br><i>Alle Hotels und Informationen auf dieser Site sind fiktiv. Alle Bilder dienen ausschließlich Präsentationszwecken und sind nicht sein urheberrechtlich geschütztes Werk.</i>'),
(57, 'Správa bola úspešne odoslaná!', 'en', 'The message was sent successfully!'),
(58, 'Správa bola úspešne odoslaná!', 'de', 'Die Nachricht wurde erfolgreich gesendet!'),
(59, 'Pri odosielaní správy došlo k chybe. Skúste to prosím neskôr.', 'en', 'There was an error sending the message. Please try again later.'),
(60, 'Pri odosielaní správy došlo k chybe. Skúste to prosím neskôr.', 'de', 'Beim Senden der Nachricht ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.'),
(61, 'V prípade otázok, návrhov alebo sťažností nás neváhajte kontaktovať.', 'en', 'If you have any questions, suggestions or complaints, please do not hesitate to contact us.'),
(62, 'V prípade otázok, návrhov alebo sťažností nás neváhajte kontaktovať.', 'de', 'Bei Fragen, Anregungen oder Beschwerden können Sie sich jederzeit an uns wenden.'),
(63, 'Vaše meno', 'en', 'Your name'),
(64, 'Vaše meno', 'de', 'Ihr Name'),
(65, 'Váš email', 'en', 'Your email'),
(66, 'Váš email', 'de', 'Ihre E-Mail-Adresse'),
(67, 'Vaša správa', 'en', 'Your message'),
(68, 'Vaša správa', 'de', 'Ihre Nachricht'),
(69, 'Odoslať', 'en', 'Send'),
(70, 'Odoslať', 'de', 'Senden'),
(71, 'Máte otázky, ktoré tu nie sú zodpovedané? Potrebujete inú pomoc? Neváhajte nás <a style=\"color:white\" href=\"contact\">kontaktovať</a>.', 'en', 'Do you have questions that are not answered here? Do you need other help? Feel free to <a style=\"color:white\" href=\"contact\">contact us</a>.'),
(72, 'Máte otázky, ktoré tu nie sú zodpovedané? Potrebujete inú pomoc? Neváhajte nás <a style=\"color:white\" href=\"contact\">kontaktovať</a>.', 'de', 'Haben Sie Fragen, die hier nicht beantwortet werden? Benötigen Sie weitere Hilfe? <a style=\"color:white\" href=\"contact\">Kontaktieren Sie uns</a> gerne.'),
(73, 'Najčastejšie problémy', 'en', 'Most common problems'),
(74, 'Najčastejšie problémy', 'de', 'Häufigste Probleme'),
(75, 'Neviem sa prihlásiť do svojho účtu accomio.', 'en', 'I can\'t log in to my accomio account.'),
(77, 'Ak ste zabudli heslo, <a style=\"color:white\" href=\"contact\">kontaktujte nás</a> a radi Vám s tým pomôžeme. Ak sa do svojho účtu neviete prihlásiť kvôli niečomu inému, odporúčame Vám vyskúšať to za pár minút/hodín. Môže sa jednať o krátkodobý technický výpadok nášho webu. Ak problém pretrváva, tiež nás prosím <a style=\"color:white\" href=\"contact\">kontaktujte</a>.', 'en', 'If you have forgotten your password, <a style=\"color:white\" href=\"contact\">contact us</a> and we will be happy to help you. If you are unable to log in to your account for some other reason, we recommend that you try again in a few minutes/hours. This may be a short-term technical outage on our website. If the problem persists, please also <a style=\"color:white\" href=\"contact\">contact us</a>.'),
(78, 'Ak ste zabudli heslo, <a style=\"color:white\" href=\"contact\">kontaktujte nás</a> a radi Vám s tým pomôžeme. Ak sa do svojho účtu neviete prihlásiť kvôli niečomu inému, odporúčame Vám vyskúšať to za pár minút/hodín. Môže sa jednať o krátkodobý technický výpadok nášho webu. Ak problém pretrváva, tiež nás prosím <a style=\"color:white\" href=\"contact\">kontaktujte</a>.', 'de', 'Wenn Sie Ihr Passwort vergessen haben, <a style=\"color:white\" href=\"contact\">kontaktieren Sie uns</a>. Wir helfen Ihnen gerne weiter. Sollten Sie sich aus anderen Gründen nicht in Ihr Konto einloggen können, empfehlen wir Ihnen, es in einigen Minuten/Stunden erneut zu versuchen. Möglicherweise liegt eine kurzfristige technische Störung unserer Website vor. Sollte das Problem weiterhin bestehen, <a style=\"color:white\" href=\"contact\">kontaktieren Sie uns</a> bitte.'),
(79, 'Neviem sa prihlásiť do svojho účtu accomio.', 'de', 'Ich kann mich nicht bei meinem accomio-Konto anmelden.'),
(80, 'Neviem vytvoriť rezerváciu cez portál accomio.', 'en', 'I can\'t make a reservation through the accomio portal.'),
(81, 'Neviem vytvoriť rezerváciu cez portál accomio.', 'de', 'Ich kann über das accomio-Portal keine Reservierung vornehmen.'),
(82, 'Ak Vám nejde vytvoriť rezervácia cez náš portál, odporúčame Vám vyskúšať to za pár minút/hodín. Môže sa jednať o krátkodobý technický výpadok nášho webu. Tiež môžete skúsiť odhlásiť sa/prihlásiť sa a vyskúšať rezerváciu vytvoriť tak. Ak problém pretrváva, prosím <a style=\"color:white\" href=\"contact\">kontaktujte nás</a> a radi Vám s tým pomôžeme.', 'en', 'If you are unable to make a reservation through our portal, we recommend that you try again in a few minutes/hours. This may be a temporary technical outage on our website. You can also try logging out/logging in and trying to make a reservation that way. If the problem persists, please <a style=\"color:white\" href=\"contact\">contact us</a> and we will be happy to help you.'),
(84, 'Ak Vám nejde vytvoriť rezervácia cez náš portál, odporúčame Vám vyskúšať to za pár minút/hodín. Môže sa jednať o krátkodobý technický výpadok nášho webu. Tiež môžete skúsiť odhlásiť sa/prihlásiť sa a vyskúšať rezerváciu vytvoriť tak. Ak problém pretrváva, prosím <a style=\"color:white\" href=\"contact\">kontaktujte nás</a> a radi Vám s tým pomôžeme.', 'de', 'Sollten Sie über unser Portal keine Reservierung vornehmen können, empfehlen wir Ihnen, es in einigen Minuten/Stunden erneut zu versuchen. Möglicherweise liegt ein vorübergehender technischer Ausfall unserer Website vor. Sie können sich auch abmelden und anschließend erneut anmelden und versuchen, auf diesem Weg eine Reservierung vorzunehmen. Sollte das Problem weiterhin bestehen, <a style=\"color:white\" href=\"contact\">kontaktieren Sie uns bitte</a>. Wir helfen Ihnen gerne weiter.'),
(85, 'Potrebujem vystornovať rezerváciu vytvorenú cez portál accomio.', 'en', 'I need to cancel a reservation made through the accomio portal.'),
(86, 'Potrebujem vystornovať rezerváciu vytvorenú cez portál accomio.', 'de', 'Ich muss eine über das accomio-Portal vorgenommene Reservierung stornieren.'),
(87, 'Vystornovať rezerváciu nie je možné online. Musíte kontaktovať konkrétny hotel, v ktorom bola vytvorená. Kontakt je uvedený na ich stránke na našom portáli. Nezabudnite, že Vám bude učtovaný storno poplatok.', 'en', 'It is not possible to cancel a reservation online. You must contact the specific hotel where it was made. The contact information is listed on their page on our portal. Please note that you will be charged a cancellation fee.'),
(88, 'Vystornovať rezerváciu nie je možné online. Musíte kontaktovať konkrétny hotel, v ktorom bola vytvorená. Kontakt je uvedený na ich stránke na našom portáli. Nezabudnite, že Vám bude učtovaný storno poplatok.', 'de', 'Eine Online-Stornierung ist nicht möglich. Sie müssen sich direkt an das Hotel wenden, bei dem die Reservierung vorgenommen wurde. Die Kontaktdaten finden Sie auf der jeweiligen Seite unseres Portals. Bitte beachten Sie, dass Ihnen eine Stornierungsgebühr berechnet wird.'),
(89, 'Rezervácie', 'en', 'Reservations'),
(90, 'Rezervácie', 'de', 'Reservierungen'),
(91, 'Ako vytvorím rezerváciu cez portál accomio?', 'en', 'How to make a reservation through the accomio portal?'),
(92, 'Ako vytvorím rezerváciu cez portál accomio?', 'de', 'Wie kann ich über das accomio-Portal eine Reservierung vornehmen?'),
(93, 'Rezerváciu cez náš portál je možné vytvoriť kliknutím na \"Rezervovať\" na stránke niektorého z hotelov. Nasledujúcimi krokmi budú výber dátumu a počtu osôb (ak ste tak neurobili už predtým), rekapitulácia rezervácie, zadanie osobných údajov (ak nie ste prihlásený, vtedy sa načítajú automaticky), rekapitulácia osobných údajov a nakoniec záväzné potvrdenie rezervácie. Rezervácia bola úspešná, ak sa vám zobrazí text \"Vaša rezervácia bola zaslaná.\".', 'de', 'Eine Reservierung über unser Portal erfolgt durch Klicken auf „Buchen“ auf der Hotelseite. Anschließend wählen Sie Datum und Personenzahl aus (falls noch nicht geschehen), überprüfen die Reservierung, geben Ihre persönlichen Daten ein (falls Sie nicht eingeloggt sind, werden diese automatisch geladen), überprüfen Ihre persönlichen Daten und bestätigen Ihre Reservierung verbindlich. Die Reservierung war erfolgreich, wenn Sie den Text „Ihre Reservierung wurde gesendet“ sehen.'),
(94, 'Kde nájdem zoznam svojich rezervácií?', 'en', 'Where can I find a list of my reservations?'),
(95, 'Kde nájdem zoznam svojich rezervácií?', 'de', 'Wo finde ich eine Liste meiner Reservierungen?'),
(96, 'Vaše rezrvácie nájdete na stránke <a style=\"color:white\" href=\"contact\">Môj účet</a> v záložke \"História rezervácií\". Nájdete tam však len rezervácie, ktoré ste robili prihlásený do svojho účtu accomio.', 'en', 'You can find your reservations on the <a style=\"color:white\" href=\"contact\">My Account</a> page under the \"Booking History\" tab. However, you will only find reservations that you made while logged into your accomio account.'),
(97, 'Vaše rezrvácie nájdete na stránke <a style=\"color:white\" href=\"contact\">Môj účet</a> v záložke \"História rezervácií\". Nájdete tam však len rezervácie, ktoré ste robili prihlásený do svojho účtu accomio.', 'de', 'Sie finden Ihre Reservierungen auf der Seite <a style=\"color:white\" href=\"contact\">Mein Konto</a> unter dem Reiter „Buchungsverlauf“. Dort finden Sie jedoch nur Reservierungen, die Sie vorgenommen haben, während Sie in Ihrem accomio-Konto angemeldet waren.'),
(98, 'Účet accomio', 'en', 'Accomio account'),
(99, 'Účet accomio', 'de', 'Accomio-Konto'),
(100, 'Ako si vytvorím účet accomio?', 'en', 'How do I create an accomio account?'),
(101, 'Ako si vytvorím účet accomio?', 'de', 'Wie erstelle ich ein accomio-Konto?'),
(102, 'Účet accomio si vytvoríte cez stránku <a style=\"color:white\" href=\"login\">Prihlásiť sa</a>. Najprv zadáte email a ak ešte nie ste zaregistrovaný, budete presmerovaný registračný formulár. Ak už účet máte, bude Vám umožnené prihlásiť sa.', 'en', 'You can create an accomio account via the <a style=\"color:white\" href=\"login\">Login</a> page. First, you enter your email and if you are not already registered, you will be redirected to the registration form. If you already have an account, you will be allowed to log in.'),
(103, 'Účet accomio si vytvoríte cez stránku <a style=\"color:white\" href=\"login\">Prihlásiť sa</a>. Najprv zadáte email a ak ešte nie ste zaregistrovaný, budete presmerovaný registračný formulár. Ak už účet máte, bude Vám umožnené prihlásiť sa.', 'de', 'Sie können ein accomio-Konto über die Anmeldeseite erstellen. Geben Sie zunächst Ihre E-Mail-Adresse ein. Falls Sie noch nicht registriert sind, werden Sie zum Registrierungsformular weitergeleitet. Wenn Sie bereits ein Konto haben, können Sie sich anmelden.'),
(104, 'Ako si zmením heslo do svojho účtu accomio?', 'en', 'How do I change the password for my accomio account?'),
(105, 'Ako si zmením heslo do svojho účtu accomio?', 'de', 'Wie ändere ich das Passwort für mein accomio-Konto?'),
(106, 'Vaše heslo si môžete zmeniť na stránke <a style=\"color:white\" href=\"user\">Môj účet</a> v záložke \"Zmena hesla\". Ak ste ho však zabudli a neviete sa prihlásiť, prosím <a style=\"color:white\" href=\"contact\">kontaktujte nás</a> a radi Vám s tým pomôžeme.', 'en', 'You can change your password on the <a style=\"color:white\" href=\"user\">My Account</a> page under the \"Change Password\" tab. However, if you have forgotten it and are unable to log in, please <a style=\"color:white\" href=\"contact\">contact us</a> and we will be happy to help you.'),
(107, 'Vaše heslo si môžete zmeniť na stránke <a style=\"color:white\" href=\"user\">Môj účet</a> v záložke \"Zmena hesla\". Ak ste ho však zabudli a neviete sa prihlásiť, prosím <a style=\"color:white\" href=\"contact\">kontaktujte nás</a> a radi Vám s tým pomôžeme.', 'de', 'Sie können Ihr Passwort auf der Seite <a style=\"color:white\" href=\"user\">Mein Konto</a> unter dem Reiter „Passwort ändern“ ändern. Sollten Sie es vergessen haben und sich nicht anmelden können, <a style=\"color:white\" href=\"contact\">kontaktieren Sie uns bitte</a>. Wir helfen Ihnen gerne weiter.'),
(108, 'Ako si zmením svoje osobné údaje v účte accomio?', 'en', 'How do I change my personal information in my accomio account?'),
(109, 'Ako si zmením svoje osobné údaje v účte accomio?', 'de', 'Wie ändere ich meine persönlichen Daten in meinem accomio-Konto?'),
(110, 'Vaše osobné údaje si môžete zmeniť na stránke <a style=\"color:white\" href=\"user\">Môj účet</a> v záložke \"Osobné údaje\".', 'en', 'You can change your personal information on the <a style=\"color:white\" href=\"user\">My Account</a> page in the \"Personal Information\" tab.'),
(111, 'Vaše osobné údaje si môžete zmeniť na stránke <a style=\"color:white\" href=\"user\">Môj účet</a> v záložke \"Osobné údaje\".', 'de', 'Sie können Ihre persönlichen Daten auf der Seite <a style=\"color:white\" href=\"user\">Mein Konto</a> im Reiter „Persönliche Daten“ ändern.'),
(112, 'Problémy s ubytovaním', 'en', 'Problems with accommodation'),
(113, 'Problémy s ubytovaním', 'de', 'Probleme mit der Unterkunft'),
(114, 'Čo mám robiť, ak ubytovacie zariadenie neexistuje alebo ma odmietlo ubytovať?', 'en', 'What should I do if the accommodation does not exist or has refused to accommodate me?'),
(115, 'Čo mám robiť, ak ubytovacie zariadenie neexistuje alebo ma odmietlo ubytovať?', 'de', 'Was soll ich tun, wenn die Unterkunftseinrichtung nicht existiert oder meine Aufnahme verweigert hat?'),
(116, 'Ak ubytovacie zariadenie neexistuje alebo Vás odmietlo ubytovať, ihneď nás kontaktujte telefonicky na +421 999 999 999 a pomôžeme Vám situáciu vyriešiť. (Telefonický kontakt je možné použiť len v uvedených situáciach. Iné záležitosti riešte výhradne cez náš <a style=\"color:white\" href=\"contact\">kontaktný formulár</a>.)', 'en', 'If the accommodation facility does not exist or has refused to accommodate you, contact us immediately by phone at +421 999 999 999 and we will help you resolve the situation. (Telephone contact can only be used in the above situations. For other matters, please use our <a style=\"color:white\" href=\"contact\">contact form</a>.)'),
(117, 'Ak ubytovacie zariadenie neexistuje alebo Vás odmietlo ubytovať, ihneď nás kontaktujte telefonicky na +421 999 999 999 a pomôžeme Vám situáciu vyriešiť. (Telefonický kontakt je možné použiť len v uvedených situáciach. Iné záležitosti riešte výhradne cez náš <a style=\"color:white\" href=\"contact\">kontaktný formulár</a>.)', 'de', 'Sollte die Unterkunftseinrichtung nicht existieren oder Ihre Aufnahme verweigert haben, kontaktieren Sie uns bitte umgehend telefonisch unter +421 999 999 999. Wir helfen Ihnen gerne bei der Lösung des Problems. (Telefonischer Kontakt ist nur in den oben genannten Fällen möglich. Für andere Anliegen nutzen Sie bitte unser <a style=\"color:white\" href=\"contact\">Kontaktformular</a>.)'),
(118, 'Na ubytovaní mi hrozí bezprostredné nebezpečenstvo.', 'en', 'I am in imminent danger at my accommodation.'),
(119, 'Na ubytovaní mi hrozí bezprostredné nebezpečenstvo.', 'de', 'Ich befinde mich in meiner Unterkunft in unmittelbarer Gefahr.'),
(120, 'Ak Vám na ubytovai hrozí bezprostredné nebezpečenstvo, riaďťe sa v prvom rade pokynmi personálu hotela a záchranných zložiek. V prípade, že v takejto krízovej situácii potrebujete našu asistenciu, kontaktujte nás telefonicky na +421 999 999 999 a pomôžeme Vám situáciu vyriešiť. Nezabudnite, že najprv kontaktujte záchranné zložky a nám volajte, až keď budete mimo bezprostredného nebezpečenstva. (Telefonický kontakt je možné použiť len v uvedených situáciach. Iné záležitosti riešte výhradne cez náš <a style=\"color:white\" href=\"contact\">kontaktný formulár</a>.)', 'en', 'If you are in immediate danger at your accommodation, first of all follow the instructions of the hotel staff and rescue services. If you need our assistance in such a crisis situation, contact us by phone at +421 999 999 999 and we will help you resolve the situation. Remember to contact the rescue services first and call us only when you are out of immediate danger. (Telephone contact can only be used in the above situations. Please resolve other matters exclusively via our <a style=\"color:white\" href=\"contact\">contact form</a>.)'),
(121, 'Ak Vám na ubytovai hrozí bezprostredné nebezpečenstvo, riaďťe sa v prvom rade pokynmi personálu hotela a záchranných zložiek. V prípade, že v takejto krízovej situácii potrebujete našu asistenciu, kontaktujte nás telefonicky na +421 999 999 999 a pomôžeme Vám situáciu vyriešiť. Nezabudnite, že najprv kontaktujte záchranné zložky a nám volajte, až keď budete mimo bezprostredného nebezpečenstva. (Telefonický kontakt je možné použiť len v uvedených situáciach. Iné záležitosti riešte výhradne cez náš <a style=\"color:white\" href=\"contact\">kontaktný formulár</a>.)', 'de', 'Wenn Sie in Ihrer Unterkunft in unmittelbarer Gefahr sind, befolgen Sie bitte zunächst die Anweisungen des Hotelpersonals und der Rettungsdienste. Sollten Sie in einer solchen Krisensituation unsere Hilfe benötigen, kontaktieren Sie uns telefonisch unter +421 999 999 999. Wir helfen Ihnen gerne bei der Lösung der Situation. Denken Sie daran, zuerst die Rettungsdienste zu kontaktieren und rufen Sie uns erst an, wenn Sie außer unmittelbarer Gefahr sind. (Telefonkontakt ist nur in den oben genannten Situationen möglich. Bitte klären Sie sonstige Anliegen ausschließlich über unser <a style=\"color:white\" href=\"contact\">Kontaktformular</a>.)'),
(122, 'Po ceste ste sa asi stratili...', 'en', 'You probably got lost along the way...'),
(123, 'Po ceste ste sa asi stratili...', 'de', 'Wahrscheinlich haben Sie sich unterwegs verlaufen ...'),
(124, 'Stránka, ktorú hľadáte, neexistuje. Skúste skontrolovať URL adresu.', 'en', 'The page you are looking for does not exist. Try checking the URL.'),
(125, 'Stránka, ktorú hľadáte, neexistuje. Skúste skontrolovať URL adresu.', 'de', 'Die gesuchte Seite existiert nicht. Überprüfen Sie die URL.'),
(126, 'Zadajte svoj email', 'en', 'Your email'),
(127, 'Zadajte svoj email', 'de', 'Ihre E-Mail-Adresse'),
(128, 'Zadajte svoje meno', 'en', 'Your first name'),
(129, 'Zadajte svoje meno', 'de', 'Ihr Vorname'),
(130, 'Zadajte svoje priezvisko', 'en', 'Your last name'),
(131, 'Zadajte svoje priezvisko', 'de', 'Ihr Nachname'),
(132, 'Zadajte svoje telefónne číslo', 'en', 'Your phone number'),
(133, 'Zadajte svoje telefónne číslo', 'de', 'Ihre Telefonnummer'),
(134, 'Zadajte svoju adresu', 'en', 'Your address'),
(135, 'Zadajte svoju adresu', 'de', 'Ihre Adresse'),
(136, 'Zadajte svoje mesto', 'en', 'Your city'),
(137, 'Zadajte svoje mesto', 'de', 'Ihre Stadt'),
(138, 'Vyberte svoj štát', 'en', 'Your country'),
(139, 'Vyberte svoj štát', 'de', 'Ihr Land'),
(140, 'Vyberte svoju národnosť', 'en', 'Your nationality'),
(141, 'Vyberte svoju národnosť', 'de', 'Ihre Nationalität'),
(142, 'Zadajte svoje heslo', 'en', 'Your password'),
(143, 'Zadajte svoje heslo', 'de', 'Ihr Passwort'),
(144, 'Zaregistrovať sa', 'en', 'Sign up'),
(145, 'Zaregistrovať sa', 'de', 'Registrieren'),
(146, 'Prihlásiť sa', 'en', 'Log in'),
(147, 'Prihlásiť sa', 'de', 'Einloggen'),
(148, 'Pokračovať', 'en', 'Next'),
(149, 'Pokračovať', 'de', 'Weiter'),
(150, 'Prihláste sa alebo si vytvorte nový účet', 'en', 'Log in or create a new account'),
(151, 'Prihláste sa alebo si vytvorte nový účet', 'de', 'Einloggen oder ein neues Konto erstellen'),
(152, 'Prihláste sa', 'de', 'Einloggen'),
(153, 'Prihláste sa', 'en', 'Log in'),
(154, 'Vytvorte si nový účet', 'en', 'Create a new account'),
(155, 'Vytvorte si nový účet', 'de', 'Neues Konto erstellen'),
(156, 'Prihlásenie bolo neúspečné. Skúste to znova.', 'en', 'Login failed. Please try again.'),
(157, 'Prihlásenie bolo neúspečné. Skúste to znova.', 'de', 'Anmeldung fehlgeschlagen. Bitte versuchen Sie es erneut.'),
(159, 'Nesprávne heslo. Skúste to znova.', 'en', 'Incorrect password. Please try again.'),
(160, 'Nesprávne heslo. Skúste to znova.', 'de', 'Falsches Passwort. Bitte versuchen Sie es erneut.'),
(161, 'Email je už registroavný. Prosím prihláste sa.', 'en', 'Email is already registered. Please log in.'),
(162, 'Email je už registroavný. Prosím prihláste sa.', 'de', 'E-Mail ist bereits registriert. Bitte loggen Sie sich ein.'),
(163, 'Úspešne ste sa zaregistrovali. Prosím prihláste sa.', 'en', 'You have successfully registered. Please log in.'),
(164, 'Úspešne ste sa zaregistrovali. Prosím prihláste sa.', 'de', 'Ihre Anmeldung war erfolgreich. Bitte melden Sie sich an.'),
(165, 'Registrácia bola neúspešná. Skúste to znova.', 'en', 'Registration failed. Please try again.'),
(166, 'Registrácia bola neúspešná. Skúste to znova.', 'de', 'Registrierung fehlgeschlagen. Bitte versuchen Sie es erneut.'),
(167, 'Príhlasenie sa', 'en', 'Login'),
(168, 'Príhlasenie sa', 'de', 'Login'),
(169, 'Pre partnerov', 'en', 'For partners'),
(170, 'Pre partnerov', 'de', 'Für Partner'),
(171, 'Recenzie', 'en', 'Reviews'),
(172, 'Recenzie', 'de', 'Bewertungen'),
(173, 'Meno', 'en', 'Name'),
(174, 'Meno', 'de', 'Name'),
(175, 'Kontakt', 'en', 'Contact'),
(176, 'Kontakt', 'de', 'Kontakt'),
(177, 'dospelí + deti', 'en', 'adults + children'),
(178, 'dospelí + deti', 'de', 'Erwachsene + Kinder'),
(179, 'Počet osôb', 'en', 'Number of people'),
(180, 'Počet osôb', 'de', 'Anzahl der Personen'),
(181, 'Cena', 'en', 'Price'),
(182, 'Cena', 'de', 'Preis'),
(183, 'POBYT PRÁVE PREBIEHA', 'en', 'STAY IS IN PROGRESS'),
(185, 'POBYT PRÁVE PREBIEHA', 'de', 'AUFENTHALT LÄUFT JETZT'),
(186, 'Nezabudnite, že je Vašou povinnosťou informvať zákazníka a vrátiť mu všetky zaplatené poplatky.', 'en', 'Remember that it is your duty to inform the customer and refund all fees paid.'),
(187, 'Nezabudnite, že je Vašou povinnosťou informvať zákazníka a vrátiť mu všetky zaplatené poplatky.', 'de', 'Denken Sie daran, dass es Ihre Pflicht ist, den Kunden zu informieren und alle gezahlten Gebühren zurückzuerstatten.'),
(188, 'STORNO REZERVÁCIE', 'en', 'CANCELLATION OF RESERVATION'),
(189, 'STORNO REZERVÁCIE', 'de', 'STORNIERUNG DER RESERVIERUNG'),
(191, 'POTVRDIŤ', 'en', 'CONFIRM'),
(192, 'POTVRDIŤ', 'de', 'BESTÄTIGEN'),
(193, 'Priemerné hodnotenie Vášho hotela:', 'en', 'Average rating of your hotel:'),
(194, 'Priemerné hodnotenie Vášho hotela:', 'de', 'Durchschnittliche Bewertung Ihres Hotels:'),
(195, 'Anonymný hosť', 'en', 'Anonymous guest'),
(196, 'Anonymný hosť', 'de', 'Anonymer Gast'),
(197, 'Dátum', 'en', 'Date'),
(198, 'Dátum', 'de', 'Datum'),
(199, 'Hviezdičky', 'en', 'Stars'),
(200, 'Hviezdičky', 'de', 'Sterne'),
(201, 'Hodnotenie', 'en', 'Review'),
(202, 'Hodnotenie', 'de', 'Auswertung'),
(203, 'Komunikácia', 'en', 'Communication'),
(204, 'Komunikácia', 'de', 'Kommunikation'),
(205, 'Použivatelia', 'en', 'Users'),
(206, 'Použivatelia', 'de', 'Benutzer'),
(207, 'Odpovedajte na:', 'en', 'Reply to:'),
(208, 'Odpovedajte na:', 'de', 'Antworten an:'),
(209, 'OZNAČIŤ AKO PREČÍTANÉ', 'en', 'MARK AS READ'),
(210, 'OZNAČIŤ AKO PREČÍTANÉ', 'de', 'ALS GELESEN MARKIEREN'),
(211, 'Správy od zákazníkov', 'en', 'Customer messages'),
(212, 'Správy od zákazníkov', 'de', 'Kundennachrichten'),
(213, 'Email', 'en', 'Email'),
(214, 'Email', 'de', 'E-Mail-Adresse'),
(215, 'Zabudli ste heslo?', 'en', 'Forgot your password?'),
(216, 'Zabudli ste heslo?', 'en', 'Forgot your password?'),
(217, 'Zabudli ste heslo?', 'de', 'Passwort vergessen?'),
(218, 'Zabudli ste heslo? Kontaktujte nás a radi vám pomôžeme.', 'en', 'Forgot your password? Contact us and we will help you.'),
(219, 'Zabudli ste heslo? Kontaktujte nás a radi vám pomôžeme.', 'de', 'Passwort vergessen? Kontaktieren Sie uns und wir helfen Ihnen gerne weiter.'),
(220, 'Tento používateľ je administrátor.', 'en', 'This user is an administrator.'),
(221, 'Tento používateľ je administrátor.', 'de', 'Dieser Benutzer ist ein Administrator.'),
(222, 'Tento používateľ je partner z hotela', 'en', 'This user is a partner from the hotel'),
(223, 'Tento používateľ je partner z hotela', 'de', 'Dieser Benutzer ist ein Partner aus dem Hotel'),
(224, 'Tento používateľ je bežný používateľ.', 'en', 'This user is a normal user.'),
(225, 'Tento používateľ je bežný používateľ.', 'de', 'Dieser Benutzer ist ein normaler Benutzer.'),
(226, 'Telefón', 'en', 'Telephone'),
(227, 'Telefón', 'de', 'Telefonnummer'),
(228, 'Adresa', 'en', 'Address'),
(229, 'Adresa', 'de', 'Adresse'),
(230, 'Národnosť', 'en', 'Nationality'),
(231, 'Národnosť', 'en', 'Nationality'),
(232, 'Národnosť', 'de', 'Nationalität'),
(233, 'ZMENIŤ POUŽÍVATEĽOVI HESLO', 'en', 'CHANGE USER\'S PASSWORD'),
(234, 'ZMENIŤ POUŽÍVATEĽOVI HESLO', 'de', 'BENUTZERPASSWORT ÄNDERN'),
(235, 'ZMENIŤ NA BEŽNÉHO POUŽÍVATEĽA', 'en', 'CHANGE TO NORMAL USER'),
(236, 'ZMENIŤ NA BEŽNÉHO POUŽÍVATEĽA', 'de', 'WECHSEL ZUM STANDARDBENUTZER'),
(237, 'ZMENIŤ NA PARTNERA', 'en', 'CHANGE TO PARTNER'),
(238, 'ZMENIŤ NA PARTNERA', 'de', 'WECHSEL ZUM PARTNER'),
(239, 'ZMENIŤ NA ADMINISTRÁTORA', 'en', 'CHANGE TO ADMINISTRATOR'),
(240, 'ZMENIŤ NA ADMINISTRÁTORA', 'de', 'WECHSEL ZUM ADMINISTRATOR'),
(241, 'ZMAZAŤ POUŽÍVATEĽA', 'en', 'DELETE USER'),
(242, 'ZMAZAŤ POUŽÍVATEĽA', 'de', 'BENUTZER LÖSCHEN'),
(243, 'Som si istý, že chcem danú akciu vykonať.', 'en', 'I am sure I want to perform this action.'),
(244, 'Som si istý, že chcem danú akciu vykonať.', 'de', 'Ich bin sicher, dass ich diese Aktion ausführen möchte.'),
(245, 'Hľadaný email nie je v databáze.', 'en', 'The email address you are looking for is not in the database.'),
(246, 'Hľadaný email nie je v databáze.', 'de', 'Die gesuchte E-Mail-Adresse befindet sich nicht in der Datenbank.'),
(247, 'Používateľovo heslo bolo zmenené. Nezabudnite informovať používateľa o novom hesle. Nové heslo:', 'en', 'The user\'s password has been changed. Remember to inform the user of the new password. New password:'),
(248, 'Používateľovo heslo bolo zmenené. Nezabudnite informovať používateľa o novom hesle. Nové heslo:', 'de', 'Das Benutzerpasswort wurde geändert. Denken Sie daran, den Benutzer über das neue Passwort zu informieren. Neues Passwort:'),
(249, 'Používateľ bol zmenený na bežného používateľa.', 'en', 'The user has been changed to a normal user.'),
(250, 'Používateľ bol zmenený na bežného používateľa.', 'de', 'Der Benutzer wurde in einen normalen Benutzer geändert.'),
(251, 'ID hotela', 'en', 'Hotel ID'),
(252, 'ID hotela', 'de', 'Hotel-ID'),
(253, 'Používateľ bol zmenený na administrátora.', 'en', 'The user has been changed to administrator.'),
(254, 'Používateľ bol zmenený na administrátora.', 'de', 'Der Benutzer wurde zum Administrator geändert.'),
(255, 'Používateľ bol úspešne odstránený.', 'en', 'The user was successfully deleted.'),
(256, 'Používateľ bol úspešne odstránený.', 'de', 'Der Benutzer wurde erfolgreich gelöscht.'),
(257, 'Používateľ bol zmenený na partnera.', 'en', 'The user has been changed to a partner.'),
(258, 'Používateľ bol zmenený na partnera.', 'de', 'Der Benutzer wurde in einen Partner geändert.'),
(259, '<div class=\"text\">\r\n            <div class=\"text-heading\">Ochrana súkromia</div>\r\n            <div class=\"text-title\">1. IDENTIFIKAČNÉ ÚDAJE PREVÁZDKOVATEĽA INFORMAČNÉHO SYSTÉMU</div>\r\n            <div>Prevádzkovateľom portálu accomio je Bilbo Bublík so sídlom Vreckany 1, Hobitov, Grófstvo, Stredozem. Kontaktovať ho môžete poštou alebo emailom na <a href=\"mailto:bilbo@bublik.com\">bilbo@bublik.com</a>.</div>\r\n            <div class=\"text-title\">2. ÚČEL A ROZSAH SPRACOVANIA OSOBNÝCH ÚDAJOV</div>\r\n            <div>Osobné údaje sú spracovávané v súlade s platnými právnymi predpismi. Prevádzkovateľ spracováva osobné údaje návštevníkov a zákaznikov portálu za účelom poskytovania služieb, komunikácie a zlepšovania používateľskej skúsenosti. K osobným údajom majú prístup aj naši partneri - poskytovalia ubytovacích služieb -, ale len k tým, ktoré sú súčasťou rezervácie.</div>\r\n            <div class=\"text-title\">3. PRÁVA DOTKNUTÝCH OSÔB</div>\r\n            <div>Dotknuté osoby majú právo na prístup k svojim osobným údajom, ich opravu, vymazanie alebo obmedzenie spracovania. Taktiež majú právo na prenositeľnosť údajov a právo namietať proti spracovaniu. V prípade otázok alebo žiadostí týkajúcich sa ochrany osobných údajov nás môžete kontaktovať cez kontakty uvedené na našej stránke.</div>\r\n            <div class=\"text-title\">4. BEZPEČNOSŤ OSOBNÝCH ÚDAJOV</div>\r\n            <div>Prevádzkovateľ prijíma primerané technické a organizačné opatrenia na ochranu osobných údajov pred neoprávneným prístupom, zmenou, zverejnením alebo zničením. Všetky osobné údaje sú spracovávané v súlade s platnými právnymi predpismi o ochrane osobných údajov.</div>\r\n            <div class=\"text-title\">5. ZÁVEREČNÉ USTANOVENIA</div>\r\n            <div>Prevádzkovateľ si vyhradzuje právo na zmenu týchto podmienok ochrany osobných údajov. O všetkých zmenách budú návštevníci a zákazníci informovaní prostredníctvom portálu. Pokračovaním v používaní portálu po zmene týchto podmienok súhlasíte s novými podmienkami.</div>\r\n        </div>', 'en', '<div class=\"text\">\r\n<div class=\"text-heading\">Privacy</div>\r\n<div class=\"text-title\">1. IDENTIFICATION DATA OF THE INFORMATION SYSTEM OPERATOR</div>\r\n<div>The operator of the accomio portal is Bilbo Baggins with his registered office at Bag End 1, The Shire, Middle-earth. You can contact him by post or email at <a href=\"mailto:bilbo@bublik.com\">bilbo@bublik.com</a>.</div>\r\n<div class=\"text-title\">2. PURPOSE AND SCOPE OF PROCESSING PERSONAL DATA</div>\r\n<div>Personal data is processed in accordance with applicable legal regulations. The operator processes the personal data of visitors and customers of the portal for the purpose of providing services, communication and improving the user experience. Our partners - accommodation service providers - also have access to personal data, but only to those that are part of the reservation.</div>\r\n<div class=\"text-title\">3. RIGHTS OF DATA SUBJECTS</div>\r\n<div>Data subjects have the right to access their personal data, rectify, erase or restrict processing. They also have the right to data portability and the right to object to processing. In case of questions or requests regarding the protection of personal data, you can contact us via the contacts listed on our website.</div>\r\n<div class=\"text-title\">4. SECURITY OF PERSONAL DATA</div>\r\n<div>The operator takes appropriate technical and organizational measures to protect personal data against unauthorized access, alteration, disclosure or destruction. All personal data is processed in accordance with applicable personal data protection laws.</div>\r\n<div class=\"text-title\">5. FINAL PROVISIONS</div>\r\n<div>The operator reserves the right to change these terms of personal data protection. Visitors and customers will be informed of all changes via the portal. By continuing to use the portal after these terms have been changed, you agree to the new terms.</div>\r\n</div>'),
(261, '<div class=\"text\">\r\n            <div class=\"text-heading\">Ochrana súkromia</div>\r\n            <div class=\"text-title\">1. IDENTIFIKAČNÉ ÚDAJE PREVÁZDKOVATEĽA INFORMAČNÉHO SYSTÉMU</div>\r\n            <div>Prevádzkovateľom portálu accomio je Bilbo Bublík so sídlom Vreckany 1, Hobitov, Grófstvo, Stredozem. Kontaktovať ho môžete poštou alebo emailom na <a href=\"mailto:bilbo@bublik.com\">bilbo@bublik.com</a>.</div>\r\n            <div class=\"text-title\">2. ÚČEL A ROZSAH SPRACOVANIA OSOBNÝCH ÚDAJOV</div>\r\n            <div>Osobné údaje sú spracovávané v súlade s platnými právnymi predpismi. Prevádzkovateľ spracováva osobné údaje návštevníkov a zákaznikov portálu za účelom poskytovania služieb, komunikácie a zlepšovania používateľskej skúsenosti. K osobným údajom majú prístup aj naši partneri - poskytovalia ubytovacích služieb -, ale len k tým, ktoré sú súčasťou rezervácie.</div>\r\n            <div class=\"text-title\">3. PRÁVA DOTKNUTÝCH OSÔB</div>\r\n            <div>Dotknuté osoby majú právo na prístup k svojim osobným údajom, ich opravu, vymazanie alebo obmedzenie spracovania. Taktiež majú právo na prenositeľnosť údajov a právo namietať proti spracovaniu. V prípade otázok alebo žiadostí týkajúcich sa ochrany osobných údajov nás môžete kontaktovať cez kontakty uvedené na našej stránke.</div>\r\n            <div class=\"text-title\">4. BEZPEČNOSŤ OSOBNÝCH ÚDAJOV</div>\r\n            <div>Prevádzkovateľ prijíma primerané technické a organizačné opatrenia na ochranu osobných údajov pred neoprávneným prístupom, zmenou, zverejnením alebo zničením. Všetky osobné údaje sú spracovávané v súlade s platnými právnymi predpismi o ochrane osobných údajov.</div>\r\n            <div class=\"text-title\">5. ZÁVEREČNÉ USTANOVENIA</div>\r\n            <div>Prevádzkovateľ si vyhradzuje právo na zmenu týchto podmienok ochrany osobných údajov. O všetkých zmenách budú návštevníci a zákazníci informovaní prostredníctvom portálu. Pokračovaním v používaní portálu po zmene týchto podmienok súhlasíte s novými podmienkami.</div>\r\n        </div>', 'de', '<div class=\"text\">\r\n<div class=\"text-heading\">Datenschutz</div>\r\n<div class=\"text-title\">1. IDENTIFIKATIONSDATEN DES INFORMATIONSSYSTEMBETREIBERS</div>\r\n<div>Betreiber des accomio-Portals ist Bilbo Beutlin mit Sitz in Beutelsend 1, Auenland, Mittelerde. Sie erreichen ihn per Post oder E-Mail unter <a href=\"mailto:bilbo@bublik.com\">bilbo@bublik.com</a>.</div>\r\n<div class=\"text-title\">2. ZWECK UND UMFANG DER VERARBEITUNG PERSONENBEZOGENER DATEN</div>\r\n<div>Personenbezogene Daten werden gemäß den geltenden gesetzlichen Bestimmungen verarbeitet. Der Betreiber verarbeitet die personenbezogenen Daten von Besuchern und Kunden des Portals zum Zwecke der Bereitstellung von Dienstleistungen, der Kommunikation und der Verbesserung des Nutzererlebnisses. Unsere Partner – Beherbergungsbetriebe – haben ebenfalls Zugriff auf personenbezogene Daten, jedoch nur auf diejenigen, die Teil der Reservierung sind.</div>\r\n<div class=\"text-title\">3. RECHTE DER BETROFFENEN PERSONEN</div>\r\n<div>Betroffene Personen haben das Recht auf Auskunft über ihre personenbezogenen Daten sowie auf Berichtigung, Löschung und Einschränkung der Verarbeitung. Sie haben außerdem das Recht auf Datenübertragbarkeit und das Recht, der Verarbeitung zu widersprechen. Bei Fragen oder Anliegen zum Schutz personenbezogener Daten können Sie uns über die auf unserer Website angegebenen Kontaktdaten erreichen.</div>\r\n<div class=\"text-title\">4. SICHERHEIT PERSONENBEZOGENER DATEN</div>\r\n<div>Der Betreiber ergreift geeignete technische und organisatorische Maßnahmen, um personenbezogene Daten vor unbefugtem Zugriff, Veränderung, Weitergabe oder Vernichtung zu schützen. Alle personenbezogenen Daten werden gemäß den geltenden Datenschutzgesetzen verarbeitet.</div>\r\n<div class=\"text-title\">5. SCHLUSSBESTIMMUNGEN</div>\r\n<div>Der Betreiber behält sich das Recht vor, diese Datenschutzbestimmungen zu ändern. Besucher und Kunden werden über das Portal über alle Änderungen informiert. Indem Sie das Portal nach der Änderung dieser Bedingungen weiterhin nutzen, erklären Sie sich mit den neuen Bedingungen einverstanden.</div>\r\n</div>'),
(262, '<div class=\"text\">\r\n            <div class=\"text-heading\">Všeobecné podmienky</div>\r\n            <div class=\"text-title\">1. PREVÁDZKOVATEĽ</div>\r\n            <div>Prevádzkovateľom portálu accomio je Bilbo Bublík so sídlom v Grófstve, Stredozem. Kontaktovať je ho možné emailom na <a href=\"mailto:bilbo@bublik.com\">bilbo@bublik.com</a> alebo poštou na adrese Vreckany 1, Hobitov, Grófstvo, Stredozem. Prevádzkovateľ nie je poskytovateľom ubytovacích služieb v ponúkaných hoteloch. Portál accomio ponúka len možnosť vyhľadávania a rezervácie ubytovania v hoteloch, penziónoch a iných ubytovacích zariadeniach. Prevádzkovateľ nezodpovedá za kvalitu služieb poskytovaných jednotlivými ubytovacími zariadeniami.</div>\r\n            <div class=\"text-title\">2. POSKYTOVATELIA UBYTOVACÍCH SLUŽIEB</div>\r\n            <div>Poskytovatelia ubytovacích služieb sú jednotlivé hotely ako partneri portálu accomio, ktorý využívajú ako rezervačný nástroj. Sú zodpovední za kvalitu poskytovaných služieb. V prípade sťažností sú hostia oprávnení kontaktovať ich cez kontakty uvedené na tomto portáli. V prípade vážnych sťažností alebo nezrovnalostí, kontaktujte prosím aj náš portál cez kontakty uvedené na našej stránke, aby sme mohli podniknúť náležité opatrenia.</div>\r\n            <div class=\"text-title\">3. HOSŤ</div>\r\n            <div>Hosťom sa rozumie každá osoba, ktorá si rezervuje ubytovanie prostredníctvom portálu accomio. Hosť je povinný poskytnúť pravdivé a úplné informácie pri rezervácii ubytovania. V prípade, že hosť poskytne nepravdivé alebo neúplné informácie, prevádzkovateľ si vyhradzuje právo zrušiť rezerváciu.</div>\r\n            <div class=\"text-title\">4. REZERVÁCIA UBYTOVANIA</div>\r\n            <div>Rezervácia ubytovania sa uskutočňuje prostredníctvom portálu accomio. Hosť si vyberie požadované ubytovacie zariadenie, termín a počet osôb. Po potvrdení rezervácie hosť obdrží potvrdenie rezervácie na zadaný email. Rezervácia je záväzná pre obe strany. V prípade storna tejto objednávky sa postupuje podľa týchto Podmienok.</div>\r\n            <div class=\"text-title\">5. POVINNOSTI HOSŤA</div>\r\n            <div>Hosť je povinný dodržiavať všetky pokyny a pravidlá ubytovacieho zariadenia, v ktorom je ubytovaný. Hosť je zodpovedný za škody spôsobené na majetku ubytovacieho zariadenia počas jeho pobytu. V prípade poškodenia majetku ubytovacieho zariadenia, hosť súhlasí s úhradou vzniknutej škody.</div>\r\n            <div class=\"text-title\">6. STORNO REZERVÁCIE ZO STRANY HOSŤA</div>\r\n            <div>Hosť má právo kedykoľvek zrušiť rezerváciu ubytovania. V prípade storna rezervácie v lehote viac ako 90 dní pred plánovaným začiatkom pobytu, storno poplatok je vo výške 20 percent z plánovanej ceny ubytovania. V prípade storna v lehote menej ako 90 a viac ako 30 dní pred plánovaným začiatkom pobytu, storno poplatok je vo výške 50 percent z plánovanej ceny ubytovania. V prípade storna v lehote menej ako 30 dní pred plánovaným začiatkom pobytu, storno poplatok je vo výške 100 percent z plánovanej ceny ubytovania.</div>\r\n            <div class=\"text-title\">7. STORNO REZERVÁCIE ZO STRANY POSKYTIVATEĽA</div>\r\n            <div>Poskytovateľ ubytovacích služieb si vyhradzuje právo zrušiť rezerváciu v prípade, že hosť poruší podmienky ubytovania alebo ak sa vyskytnú nepredvídateľné okolnosti, ktoré znemožňujú poskytnutie ubytovania. V takom prípade poskytovateľ ubytovacích služieb informuje hosťa o zrušení rezervácie a vráti mu všetky zaplatené poplatky. V prípade stažností týkajúcich sa tohto bodu Podmienok, kontaktujte nás cez kontakty uvedené na našej stránke.</div>\r\n            <div class=\"text-title\">8. ZÁVEREČNÉ USTANOVENIA</div>\r\n            <div>Tieto Všeobecné podmienky sú platné od 14. júla 1789. Prevádzkovateľ si vyhradzuje právo na zmenu týchto Podmienok. O zmene Podmienok bude hosť informovaný prostredníctvom emailu alebo na stránke portálu accomio. Hosť je povinný oboznámiť sa s aktuálnymi Podmienkami pred každou rezerváciou ubytovania. Podmienky platia v každej jurisdikcii na svete.</div>\r\n        </div>', 'en', '<div class=\"text\">\r\n<div class=\"text-heading\">Terms and Conditions</div>\r\n<div class=\"text-title\">1. OPERATOR</div>\r\n<div>The operator of the accomio portal is Bilbo Baggins, based in The Shire, Middle-earth. He can be contacted by email at <a href=\"mailto:bilbo@bublik.com\">bilbo@bublik.com</a> or by post at Vreckany 1, Hobitov, Grófstvo, Stredozem. The operator is not a provider of accommodation services in the hotels offered. The accomio portal only offers the possibility of searching for and booking accommodation in hotels, guesthouses and other accommodation facilities. The operator is not responsible for the quality of services provided by individual accommodation facilities.</div>\r\n<div class=\"text-title\">2. ACCOMMODATION PROVIDERS</div>\r\n<div>Accommodation providers are individual hotels as partners of the accomio portal, which they use as a booking tool. They are responsible for the quality of the services provided. In case of complaints, guests are entitled to contact them via the contacts listed on this portal. In case of serious complaints or irregularities, please also contact our portal via the contacts listed on our website so that we can take appropriate measures.</div>\r\n<div class=\"text-title\">3. GUEST</div>\r\n<div>A guest is understood to be any person who books accommodation via the accomio portal. The guest is obliged to provide true and complete information when booking accommodation. In the event that the guest provides false or incomplete information, the operator reserves the right to cancel the reservation.</div>\r\n<div class=\"text-title\">4. ACCOMMODATION RESERVATION</div>\r\n<div>Accommodation reservations are made via the accomio portal. The guest selects the desired accommodation facility, date and number of people. After confirming the reservation, the guest will receive a confirmation of the reservation to the email address provided. The reservation is binding for both parties. In the event of cancellation of this order, these Terms and Conditions shall apply.</div>\r\n<div class=\"text-title\">5. GUEST OBLIGATIONS</div>\r\n<div>The guest is obliged to comply with all instructions and rules of the accommodation facility in which he is accommodated. The guest is responsible for any damage caused to the property of the accommodation facility during his stay. In the event of damage to the property of the accommodation facility, the guest agrees to pay for the resulting damage.</div>\r\n<div class=\"text-title\">6. CANCELLATION OF THE RESERVATION BY THE GUEST</div>\r\n<div>The guest has the right to cancel the accommodation reservation at any time. In the event of cancellation of the reservation more than 90 days before the planned start of the stay, the cancellation fee is 20 percent of the planned accommodation price. In case of cancellation less than 90 and more than 30 days before the planned start of the stay, the cancellation fee is 50 percent of the planned accommodation price. In case of cancellation less than 30 days before the planned start of the stay, the cancellation fee is 100 percent of the planned accommodation price.</div>\r\n<div class=\"text-title\">7. CANCELLATION OF THE RESERVATION BY THE PROVIDER</div>\r\n<div>The accommodation service provider reserves the right to cancel the reservation if the guest violates the terms of accommodation or if unforeseen circumstances occur that make it impossible to provide accommodation. In such a case, the accommodation service provider will inform the guest about the cancellation of the reservation and refund all fees paid. In case of complaints regarding this point of the Conditions, please contact us via the contacts listed on our website.</div>\r\n<div class=\"text-title\">8. FINAL PROVISIONS</div>\r\n<div>These General Terms and Conditions are valid from July 14, 1789. The Operator reserves the right to change these Terms and Conditions. The guest will be informed about the change of the Terms and Conditions via email or on the accomio portal page. The guest is obliged to familiarize himself with the current Terms and Conditions before each accommodation reservation. The Terms and Conditions apply in every jurisdiction in the world.</div>\r\n</div>');
INSERT INTO `translations` (`id`, `original`, `lang`, `new`) VALUES
(263, '<div class=\"text\">\r\n            <div class=\"text-heading\">Všeobecné podmienky</div>\r\n            <div class=\"text-title\">1. PREVÁDZKOVATEĽ</div>\r\n            <div>Prevádzkovateľom portálu accomio je Bilbo Bublík so sídlom v Grófstve, Stredozem. Kontaktovať je ho možné emailom na <a href=\"mailto:bilbo@bublik.com\">bilbo@bublik.com</a> alebo poštou na adrese Vreckany 1, Hobitov, Grófstvo, Stredozem. Prevádzkovateľ nie je poskytovateľom ubytovacích služieb v ponúkaných hoteloch. Portál accomio ponúka len možnosť vyhľadávania a rezervácie ubytovania v hoteloch, penziónoch a iných ubytovacích zariadeniach. Prevádzkovateľ nezodpovedá za kvalitu služieb poskytovaných jednotlivými ubytovacími zariadeniami.</div>\r\n            <div class=\"text-title\">2. POSKYTOVATELIA UBYTOVACÍCH SLUŽIEB</div>\r\n            <div>Poskytovatelia ubytovacích služieb sú jednotlivé hotely ako partneri portálu accomio, ktorý využívajú ako rezervačný nástroj. Sú zodpovední za kvalitu poskytovaných služieb. V prípade sťažností sú hostia oprávnení kontaktovať ich cez kontakty uvedené na tomto portáli. V prípade vážnych sťažností alebo nezrovnalostí, kontaktujte prosím aj náš portál cez kontakty uvedené na našej stránke, aby sme mohli podniknúť náležité opatrenia.</div>\r\n            <div class=\"text-title\">3. HOSŤ</div>\r\n            <div>Hosťom sa rozumie každá osoba, ktorá si rezervuje ubytovanie prostredníctvom portálu accomio. Hosť je povinný poskytnúť pravdivé a úplné informácie pri rezervácii ubytovania. V prípade, že hosť poskytne nepravdivé alebo neúplné informácie, prevádzkovateľ si vyhradzuje právo zrušiť rezerváciu.</div>\r\n            <div class=\"text-title\">4. REZERVÁCIA UBYTOVANIA</div>\r\n            <div>Rezervácia ubytovania sa uskutočňuje prostredníctvom portálu accomio. Hosť si vyberie požadované ubytovacie zariadenie, termín a počet osôb. Po potvrdení rezervácie hosť obdrží potvrdenie rezervácie na zadaný email. Rezervácia je záväzná pre obe strany. V prípade storna tejto objednávky sa postupuje podľa týchto Podmienok.</div>\r\n            <div class=\"text-title\">5. POVINNOSTI HOSŤA</div>\r\n            <div>Hosť je povinný dodržiavať všetky pokyny a pravidlá ubytovacieho zariadenia, v ktorom je ubytovaný. Hosť je zodpovedný za škody spôsobené na majetku ubytovacieho zariadenia počas jeho pobytu. V prípade poškodenia majetku ubytovacieho zariadenia, hosť súhlasí s úhradou vzniknutej škody.</div>\r\n            <div class=\"text-title\">6. STORNO REZERVÁCIE ZO STRANY HOSŤA</div>\r\n            <div>Hosť má právo kedykoľvek zrušiť rezerváciu ubytovania. V prípade storna rezervácie v lehote viac ako 90 dní pred plánovaným začiatkom pobytu, storno poplatok je vo výške 20 percent z plánovanej ceny ubytovania. V prípade storna v lehote menej ako 90 a viac ako 30 dní pred plánovaným začiatkom pobytu, storno poplatok je vo výške 50 percent z plánovanej ceny ubytovania. V prípade storna v lehote menej ako 30 dní pred plánovaným začiatkom pobytu, storno poplatok je vo výške 100 percent z plánovanej ceny ubytovania.</div>\r\n            <div class=\"text-title\">7. STORNO REZERVÁCIE ZO STRANY POSKYTIVATEĽA</div>\r\n            <div>Poskytovateľ ubytovacích služieb si vyhradzuje právo zrušiť rezerváciu v prípade, že hosť poruší podmienky ubytovania alebo ak sa vyskytnú nepredvídateľné okolnosti, ktoré znemožňujú poskytnutie ubytovania. V takom prípade poskytovateľ ubytovacích služieb informuje hosťa o zrušení rezervácie a vráti mu všetky zaplatené poplatky. V prípade stažností týkajúcich sa tohto bodu Podmienok, kontaktujte nás cez kontakty uvedené na našej stránke.</div>\r\n            <div class=\"text-title\">8. ZÁVEREČNÉ USTANOVENIA</div>\r\n            <div>Tieto Všeobecné podmienky sú platné od 14. júla 1789. Prevádzkovateľ si vyhradzuje právo na zmenu týchto Podmienok. O zmene Podmienok bude hosť informovaný prostredníctvom emailu alebo na stránke portálu accomio. Hosť je povinný oboznámiť sa s aktuálnymi Podmienkami pred každou rezerváciou ubytovania. Podmienky platia v každej jurisdikcii na svete.</div>\r\n        </div>', 'de', '<div class=\"text\">\n<div class=\"text-heading\">Allgemeine Geschäftsbedingungen</div>\n<div class=\"text-title\">1. BETREIBER</div>\n<div>Betreiber des accomio-Portals ist Bilbo Beutlin mit Sitz in Auenland, Mittelerde. Er ist per E-Mail unter <a href=\"mailto:bilbo@bublik.com\">bilbo@bublik.com</a> oder per Post unter Beutelsend 1, Auenland, Mittelerde erreichbar. Der Betreiber bietet keine Beherbergungsleistungen in den angebotenen Hotels an. Das accomio-Portal bietet lediglich die Möglichkeit zur Suche und Buchung von Unterkünften in Hotels, Pensionen und anderen Beherbergungsbetrieben. Der Betreiber übernimmt keine Verantwortung für die Qualität der von den einzelnen Beherbergungsbetrieben erbrachten Leistungen.</div>\n<div class=\"text-title\">2. UNTERKÜNFTE</div>\n<div>Unterkünfte sind einzelne Hotels als Partner des accomio-Portals, das sie als Buchungstool nutzen. Sie sind für die Qualität der erbrachten Leistungen verantwortlich. Bei Beschwerden können sich Gäste über die auf diesem Portal angegebenen Kontaktdaten an sie wenden. Bei schwerwiegenden Beschwerden oder Unregelmäßigkeiten wenden Sie sich bitte ebenfalls über die auf unserer Website angegebenen Kontaktdaten an unser Portal, damit wir entsprechende Maßnahmen ergreifen können.</div>\n<div class=\"text-title\">3. GAST</div>\n<div>Als Gast gilt jede Person, die eine Unterkunft über das accomio-Portal bucht. Der Gast ist verpflichtet, bei der Buchung wahrheitsgemäße und vollständige Angaben zu machen. Bei falschen oder unvollständigen Angaben behält sich der Betreiber das Recht vor, die Buchung zu stornieren.</div>\n<div class=\"text-title\">4. UNTERKUNFT RESERVIERUNG</div>\n<div>Die Buchung einer Unterkunft erfolgt über das accomio-Portal. Der Gast wählt die gewünschte Unterkunft, das Datum und die Personenzahl aus. Nach der Bestätigung der Reservierung erhält der Gast eine Reservierungsbestätigung an die angegebene E-Mail-Adresse. Die Reservierung ist für beide Parteien verbindlich. Im Falle einer Stornierung dieser Bestellung gelten diese Allgemeinen Geschäftsbedingungen.</div>\n<div class=\"text-title\">5. PFLICHTEN DES GASTES</div>\n<div>Der Gast ist verpflichtet, alle Anweisungen und Regeln des Beherbergungsbetriebs, in dem er untergebracht ist, einzuhalten. Der Gast haftet für Schäden, die während seines Aufenthalts am Eigentum des Beherbergungsbetriebs entstehen. Im Falle einer Beschädigung des Eigentums des Beherbergungsbetriebs verpflichtet sich der Gast, den daraus resultierenden Schaden zu ersetzen.</div>\n<div class=\"text-title\">6. STORNIERUNG DER RESERVIERUNG DURCH DEN GAST</div>\n<div>Der Gast hat das Recht, die Reservierung jederzeit zu stornieren. Bei einer Stornierung der Reservierung mehr als 90 Tage vor dem geplanten Aufenthaltsbeginn beträgt die Stornogebühr 20 Prozent des geplanten Übernachtungspreises. Bei einer Stornierung weniger als 90 und mehr als 30 Tage vor dem geplanten Aufenthaltsbeginn beträgt die Stornierungsgebühr 50 Prozent des geplanten Übernachtungspreises. Bei einer Stornierung weniger als 30 Tage vor dem geplanten Aufenthaltsbeginn beträgt die Stornierungsgebühr 100 Prozent des geplanten Übernachtungspreises.</div>\n<div class=\"text-title\">7. STORNIERUNG DER RESERVIERUNG DURCH DEN ANBIETER</div>\n<div>Der Beherbergungsbetrieb behält sich das Recht vor, die Reservierung zu stornieren, wenn der Gast gegen die Unterkunftsbedingungen verstößt oder unvorhergesehene Umstände eintreten, die die Bereitstellung der Unterkunft unmöglich machen. In diesem Fall informiert der Beherbergungsbetrieb den Gast über die Stornierung der Reservierung und erstattet alle gezahlten Gebühren zurück. Bei Beschwerden bezüglich dieses Punktes der Bedingungen kontaktieren Sie uns bitte über die auf unserer Website angegebenen Kontaktdaten.</div>\n<div class=\"text-title\">8. SCHLUSSBESTIMMUNGEN</div>\n<div>Diese Allgemeinen Geschäftsbedingungen gelten ab dem 14. Juli 1789. Der Betreiber behält sich das Recht vor, diese Allgemeinen Geschäftsbedingungen zu ändern. Der Gast wird über Änderungen der Allgemeinen Geschäftsbedingungen per E-Mail oder auf der accomio-Portalseite informiert. Der Gast ist verpflichtet, sich vor jeder Buchung mit den aktuellen Allgemeinen Geschäftsbedingungen vertraut zu machen. Die Allgemeinen Geschäftsbedingungen gelten weltweit.</div>\n</div>'),
(264, 'Niečo sa pokazilo.', 'en', 'Something went wrong.'),
(265, 'Niečo sa pokazilo.', 'de', 'Etwas ist schief gelaufen.'),
(266, 'Recenziu k tejto rezervácii ste už pridali.', 'en', 'You have already added a review to this reservation.'),
(267, 'Recenziu k tejto rezervácii ste už pridali.', 'de', 'Sie haben dieser Reservierung bereits eine Bewertung hinzugefügt..'),
(268, 'Vaša recenzia bola úspešne odoslaná!', 'en', 'Your review has been successfully submitted!'),
(269, 'Vaša recenzia bola úspešne odoslaná!', 'de', 'Ihre Bewertung wurde erfolgreich abgegeben!'),
(270, 'Pri odosielaní recenzie došlo k chybe. Skúste to prosím neskôr.', 'en', 'There was an error submitting your review. Please try again later.'),
(271, 'Pri odosielaní recenzie došlo k chybe. Skúste to prosím neskôr.', 'de', 'Beim Senden Ihrer Bewertung ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.'),
(272, 'Pridať recenziu', 'en', 'Add a review'),
(273, 'Pridať recenziu', 'de', 'Bewertung hinzufügen'),
(274, 'Ako hodnotíte \"', 'en', 'How do you rate \"'),
(275, 'Ako hodnotíte \"', 'de', 'Wie bewerten Sie \"'),
(276, 'Vaše hodnotenie (nepovinné)', 'en', 'Your review (optional)'),
(277, 'Vaše hodnotenie (nepovinné)', 'de', 'Ihre Bewertung (optional)'),
(278, 'Zobraziť pri recenzii moje meno', 'en', 'Show my name in the review'),
(279, 'Zobraziť pri recenzii moje meno', 'de', 'Meinen Namen in der Bewertung anzeigen'),
(280, 'Hostinec U skákavého poníka', 'en', 'The Prancing Pony Inn'),
(281, 'Hostinec U skákavého poníka', 'de', 'Gasthaus „Zum Tänzelnden Pony“'),
(282, 'Svažiny', 'en', 'Bree'),
(283, 'Svažiny', 'de', 'Bree'),
(284, 'Stredozem', 'en', 'Middle-earth'),
(285, 'Stredozem', 'de', 'Mittelerde'),
(286, 'Zastavte sa na ceste pri krígli dobrého piva! Nezáleží, či ste hobit, trpaslík, elf alebo ohyzd!\nUbytujte sa v najslávnejšom hostinci malebného mesta Svažiny! Hostinský Maslík vás rád privíta pod svojou strechou.', 'en', 'Stop on the way for a mug of good beer! It doesn\'t matter if you are a hobbit, dwarf, elf or an orc! Stay in the most famous inn in the picturesque town of Bree! Barliman Butterbur will be happy to welcome you under his roof.'),
(287, 'Zastavte sa na ceste pri krígli dobrého piva! Nezáleží, či ste hobit, trpaslík, elf alebo ohyzd!\nUbytujte sa v najslávnejšom hostinci malebného mesta Svažiny! Hostinský Maslík vás rád privíta pod svojou strechou.', 'de', 'Machen Sie unterwegs Halt und gönnen Sie sich ein gutes Bier! Egal, ob Sie ein Hobbit, ein Zwerg, ein Elf oder ein Ghul sind! Übernachten Sie im berühmtesten Gasthaus des malerischen Städtchens Bree! Gerstenmann Butterblume heißt Sie herzlich willkommen.'),
(288, '<div class=\"facility\"><img class=\"facilityimg\" src=\"styles/icons/wifi.svg\"><br>Wi-Fi</div><div class=\"facility\"><img class=\"facilityimg\" src=\"styles/icons/parking.svg\"><br>Parkovisko pre kone</div><div class=\"facility\"><img class=\"facilityimg\" src=\"styles/icons/restaurant.svg\"><br>Reštaurácia</div><div class=\"facility\"><img class=\"facilityimg\" src=\"styles/icons/bar.svg\"><br>Non-stop bar</div>', 'en', '<div class=\"facility\"><img class=\"facilityimg\" src=\"styles/icons/wifi.svg\"><br>Wi-Fi</div><div class=\"facility\"><img class=\"facilityimg\" src=\"styles/icons/parking.svg\"><br>Parking for horses</div><div class=\"facility\"><img class=\"facilityimg\" src=\"styles/icons/restaurant.svg\"><br>Restaurant</div><div class=\"facility\"><img class=\"facilityimg\" src=\"styles/icons/bar.svg\"><br>Non-stop bar</div>'),
(289, '<div class=\"facility\"><img class=\"facilityimg\" src=\"styles/icons/wifi.svg\"><br>Wi-Fi</div><div class=\"facility\"><img class=\"facilityimg\" src=\"styles/icons/parking.svg\"><br>Parkovisko pre kone</div><div class=\"facility\"><img class=\"facilityimg\" src=\"styles/icons/restaurant.svg\"><br>Reštaurácia</div><div class=\"facility\"><img class=\"facilityimg\" src=\"styles/icons/bar.svg\"><br>Non-stop bar</div>', 'de', '<div class=\"facility\"><img class=\"facilityimg\" src=\"styles/icons/wifi.svg\"><br>WLAN</div><div class=\"facility\"><img class=\"facilityimg\" src=\"styles/icons/parking.svg\"><br>Parkplatz für Pferde</div><div class=\"facility\"><img class=\"facilityimg\" src=\"styles/icons/restaurant.svg\"><br>Restaurant</div><div class=\"facility\"><img class=\"facilityimg\" src=\"styles/icons/bar.svg\"><br>Nonstop-Bar</div>'),
(290, 'Rezervovať', 'en', 'Reserve'),
(291, 'Rezervovať', 'de', 'Reservieren'),
(292, 'Kontaktovať', 'en', 'Contact'),
(293, 'Kontaktovať', 'de', 'Kontakt'),
(294, 'Zdielať', 'en', 'Share'),
(295, 'Zdielať', 'de', 'Teilen'),
(296, 'Cena:', 'en', 'Price:'),
(297, 'Cena:', 'de', 'Preis:'),
(298, 'Cena za počet nocí: ', 'en', 'Price per number of nights: '),
(299, 'Cena za počet nocí: ', 'de', 'Preis pro Anzahl Nächte: '),
(300, ' a počet osôb: ', 'en', ' and number of people: '),
(301, ' a počet osôb: ', 'en', ' und Anzahl der Personen: '),
(302, 'Cena za počet nocí: 1 a počet osôb: 1 + 0', 'en', 'Price for number of nights: 1 and number of persons: 1 + 0'),
(303, 'Cena za počet nocí: 1 a počet osôb: 1 + 0', 'de', 'Preis für Anzahl Nächte: 1 und Anzahl Personen: 1 + 0'),
(304, 'Počet recenzií:', 'en', 'Number of reviews:'),
(305, 'Počet recenzií:', 'de', 'Anzahl der Bewertungen:'),
(306, 'Česká republika', 'en', 'Czech Republic'),
(307, 'Česká republika', 'de', 'Tschechische Republik'),
(308, 'Czech republic', 'de', 'Tschechische Republik'),
(309, 'Czech republic', 'sk', 'Česká republika'),
(310, 'Česká', 'en', 'Czech'),
(311, 'Česká', 'de', 'Tschechisch'),
(312, 'Czech', 'de', 'Tschechisch'),
(313, 'Czech', 'sk', 'Česká'),
(314, 'Slovenská republika', 'en', 'Slovakia'),
(315, 'Slovenská republika', 'de', 'Slowakei'),
(316, 'Slovakia', 'de', 'Slowakei'),
(317, 'Slovakia', 'sk', 'Slovensko'),
(318, 'Vaše meno:', 'de', 'Ihr Vorname:'),
(319, 'Vaše priezvisko:', 'en', 'Your last name:'),
(320, 'Vaše priezvisko:', 'de', 'Ihr Nachname:'),
(321, 'Vaše telefónne číslo:', 'en', 'Your phone number:'),
(322, 'Vaše telefónne číslo:', 'de', 'Ihre Telefonnummer:'),
(323, 'Vaša adresa:', 'en', 'Your address:'),
(324, 'Vaša adresa:', 'de', 'Ihre Adresse:'),
(325, 'Vaše mesto:', 'en', 'Your city:'),
(326, 'Vaše mesto:', 'de', 'Ihre Stadt:'),
(327, 'Váš štát:', 'en', 'Your country:'),
(328, 'Váš štát:', 'de', 'Ihr Land:'),
(329, 'Vaša národnosť:', 'en', 'Your nationality:'),
(330, 'Vaša národnosť:', 'de', 'Ihre Nationalität:'),
(333, 'Váš email:', 'en', 'Your email:'),
(334, 'Váš email:', 'de', 'Ihre E-Mail-Adresse:'),
(335, 'Vaše meno:', 'en', 'Your first name:'),
(336, 'Potvrdiť a pokračovať', 'en', 'Confirm and continue'),
(337, 'Potvrdiť a pokračovať', 'de', 'Bestätigen und fortfahren'),
(338, 'Slovenská', 'en', 'Slovak'),
(339, 'Slovenská', 'de', 'Slowakisch'),
(340, 'Slovak', 'de', 'Slowakisch'),
(341, 'Slovak', 'sk', 'Slovenská'),
(342, 'Rekapitulácia Vašej rezervácie:', 'en', 'Summary of your reservation:'),
(343, 'Rekapitulácia Vašej rezervácie:', 'de', 'Zusammenfassung Ihrer Reservierung:'),
(344, 'Hotel:', 'en', 'Hotel:'),
(345, 'Hotel:', 'de', 'Hotel:'),
(346, 'Dátum:', 'en', 'Date:'),
(347, 'Dátum:', 'de', 'Datum:'),
(348, 'Počet osôb:', 'en', 'Number of people:'),
(349, 'Počet osôb:', 'de', 'Anzahl der Personen:'),
(350, 'Typ izby:', 'en', 'Room type:'),
(351, 'Typ izby:', 'de', 'Zimmertyp:'),
(352, 'Normálna izba', 'en', 'Normal room'),
(353, 'Normálna izba', 'de', 'Normales Zimmer'),
(354, 'Hobitia izba', 'en', 'Hobbit room'),
(355, 'Hobitia izba', 'de', 'Hobbit-Zimmer'),
(356, 'Celý objekt', 'en', 'The whole object'),
(357, 'Celý objekt', 'de', 'Gesamtes Gebäude'),
(358, 'Jednolôžková izba', 'en', 'Single room'),
(359, 'Jednolôžková izba', 'de', 'Einzelzimmer'),
(360, 'Dvojlôžková izba', 'en', 'Double room'),
(361, 'Dvojlôžková izba', 'de', 'Doppelzimmer'),
(362, 'Trojlôžková izba', 'en', 'Triple room'),
(363, 'Trojlôžková izba', 'de', 'Dreibettzimmer'),
(364, 'Štvorlôžková izba', 'en', 'Quadruple room'),
(365, 'Štvorlôžková izba', 'de', 'Vierbettzimmer'),
(366, 'Päťlôžková izba', 'en', 'Quintuple room'),
(367, 'Päťlôžková izba', 'de', 'Fünfbettzimmer'),
(368, 'Celková cena:', 'en', 'Total price:'),
(369, 'Celková cena:', 'de', 'Gesamtpreis:'),
(370, 'V prípade, ak chcete niečo vo Vašej rezervácií zmeniť, vráťte sa do vyhľadávania a vytvorte rezerváciu nanovo.', 'en', 'If you want to change something in your reservation, return to the search and create a new reservation.'),
(371, 'V prípade, ak chcete niečo vo Vašej rezervácií zmeniť, vráťte sa do vyhľadávania a vytvorte rezerváciu nanovo.', 'de', 'Wenn Sie etwas an Ihrer Reservierung ändern möchten, kehren Sie zur Suche zurück und erstellen Sie eine neue Reservierung.'),
(372, 'Rekapitulácia Vašich údajov:', 'en', 'Summary of your personal data:'),
(373, 'Rekapitulácia Vašich údajov:', 'de', 'Zusammenfassung Ihrer personenbezogenen Daten:'),
(374, 'Zmeniť údaje', 'en', 'Change data'),
(375, 'Zmeniť údaje', 'de', 'Daten ändern'),
(376, 'Momentálne žiaľ poskytujeme len možnosť platby priamo v hoteli. Platba cez internet nie je možná.', 'en', 'Unfortunately, we currently only offer the option of paying directly at the hotel. Payment via the internet is not possible.'),
(377, 'Momentálne žiaľ poskytujeme len možnosť platby priamo v hoteli. Platba cez internet nie je možná.', 'de', 'Leider bieten wir derzeit nur die Möglichkeit der Zahlung direkt im Hotel an. Eine Zahlung über das Internet ist nicht möglich.'),
(378, 'Vyberte spôsob platby:', 'en', 'Choose a payment method:'),
(379, 'Vyberte spôsob platby:', 'de', 'Wählen Sie eine Zahlungsmethode:'),
(380, 'Platba v hoteli', 'en', 'Payment at the hotel'),
(381, 'Platba v hoteli', 'de', 'Zahlung im Hotel'),
(382, 'Zadaním rezervácie sa zaväzujem zaplatiť požadovanú sumu alebo storno poplatok ubytovateľovi.', 'en', 'By making a reservation, I agree to pay the required amount or cancellation fee to the accommodation provider.'),
(383, 'Zadaním rezervácie sa zaväzujem zaplatiť požadovanú sumu alebo storno poplatok ubytovateľovi.', 'de', 'Mit der Buchung verpflichte ich mich, den geforderten Betrag bzw. die Stornogebühr an den Beherbergungsbetrieb zu zahlen.'),
(384, 'Súhlasím s ', 'en', 'I agree to the '),
(385, 'Súhlasím s ', 'de', 'Ich stimme den '),
(386, 'Všeobecnými podmienkami', 'en', 'Terms and Conditions'),
(387, 'Všeobecnými podmienkami', 'de', 'Allgemeinen Geschäftsbedingungen zu'),
(388, 'Súhlasím so spracovaním mojich osobných údajov podľa ', 'de', 'Ich stimme der Verarbeitung meiner personenbezogenen Daten gemäß der '),
(389, 'Súhlasím so spracovaním mojich osobných údajov podľa ', 'en', 'I agree to the processing of my personal data in accordance with the '),
(390, 'Zásad spracovania osobných údajov', 'en', 'Privacy Policy'),
(391, 'Zásad spracovania osobných údajov', 'de', 'Datenschutzrichtlinie zu'),
(392, 'Záväzne zarezervovať', 'de', 'Verbindlich reservieren'),
(393, 'Záväzne zarezervovať', 'en', 'Confirm reservation'),
(394, 'Vaša rezervácia bola zaslaná.', 'en', 'Your reservation has been sent.'),
(395, 'Vaša rezervácia bola zaslaná.', 'de', 'Ihre Reservierung wurde gesendet.'),
(396, 'Číslo rezervácie:', 'en', 'Reservation number:'),
(397, 'Číslo rezervácie:', 'de', 'Reservierungsnummer:'),
(398, 'Skúste vytvoriť rezerváciu ešte raz.', 'en', 'Please try to create a reservation again.'),
(399, 'Skúste vytvoriť rezerváciu ešte raz.', 'de', 'Versuchen Sie erneut, die Reservierung zu erstellen.'),
(400, 'Nemáme údaje potrebné na vytvorenie rezervácie.', 'en', 'We do not have the information required to create a reservation.'),
(401, 'Nemáme údaje potrebné na vytvorenie rezervácie.', 'de', 'Wir verfügen nicht über die erforderlichen Informationen, um eine Reservierung vorzunehmen.'),
(402, 'Vráťte sa prosím do vyhľadávania a zadajte údaje ešte raz.', 'en', 'Please return to the search and enter the data again.'),
(403, 'Vráťte sa prosím do vyhľadávania a zadajte údaje ešte raz.', 'de', 'Bitte kehren Sie zur Suche zurück und geben Sie die Daten erneut ein.'),
(404, 'Rezervácia', 'en', 'Reservation'),
(405, 'Rezervácia', 'de', 'Reservierung'),
(406, 'V tomto hoteli sa v zvolenom termíne nenašla žiadna voľná izba.', 'en', 'There are no available rooms at this hotel on the selected dates.'),
(407, 'V tomto hoteli sa v zvolenom termíne nenašla žiadna voľná izba.', 'de', 'Für den ausgewählten Zeitraum sind in diesem Hotel keine Zimmer verfügbar.'),
(408, 'Našla sa pre Vás voľná izba!', 'en', 'A free room has been found for you!'),
(410, 'Našla sa pre Vás voľná izba!', 'de', 'Es wurde ein freies Zimmer für Sie gefunden!'),
(411, 'Zarezervujte si ju!', 'en', 'Reserve it!'),
(412, 'Zarezervujte si ju!', 'de', 'Reservieren Sie jetzt!'),
(413, 'Nič sa nenašlo.', 'en', 'Nothing was found.'),
(414, 'Nič sa nenašlo.', 'de', 'Es wurde nichts gefunden.'),
(415, 'Úpravy osobných údajov a hesla na tejto stránke sú dostupné len pre bežných používateľov. Ak ste administrátor alebo partner, prosím kontaktujte Vášho administrátora, ktorý Vám pomôže.', 'en', 'Editing your personal information and password on this page is only available to regular users. If you are an administrator or partner, please contact your administrator who will assist you.'),
(416, 'Úpravy osobných údajov a hesla na tejto stránke sú dostupné len pre bežných používateľov. Ak ste administrátor alebo partner, prosím kontaktujte Vášho administrátora, ktorý Vám pomôže.', 'de', 'Das Bearbeiten Ihrer persönlichen Daten und Ihres Passworts auf dieser Seite ist nur normalen Benutzern möglich. Wenn Sie Administrator oder Partner sind, wenden Sie sich bitte an Ihren Administrator, der Ihnen gerne weiterhilft.'),
(417, 'PRIDAŤ RECENZIU', 'en', 'ADD A REVIEW'),
(418, 'PRIDAŤ RECENZIU', 'de', 'EINE BEWERTUNG HINZUFÜGEN'),
(419, 'PRAJEME PRÍJEMNÝ POBYT :)', 'en', 'WE WISH YOU A PLEASANT STAY :)'),
(420, 'PRAJEME PRÍJEMNÝ POBYT :)', 'de', 'WIR WÜNSCHEN IHNEN EINEN ANGENEHMEN AUFENTHALT :)'),
(421, 'Rezerváciu nie je možné vystornovať online. Kontaktujte hotel, v ktorom je rezervácia vytvorená. Pamätajte však, že budete musieť zaplatiť storno poplatok.', 'en', 'It is not possible to cancel the reservation online. Please contact the hotel where the reservation is made. However, please note that you will be charged a cancellation fee.'),
(422, 'Rezerváciu nie je možné vystornovať online. Kontaktujte hotel, v ktorom je rezervácia vytvorená. Pamätajte však, že budete musieť zaplatiť storno poplatok.', 'de', 'Eine Online-Stornierung der Reservierung ist nicht möglich. Bitte kontaktieren Sie das Hotel, bei dem die Reservierung vorgenommen wurde. Bitte beachten Sie jedoch, dass Ihnen eine Stornierungsgebühr berechnet wird.'),
(423, 'Názov hotela', 'en', 'Hotel name'),
(424, 'Názov hotela', 'de', 'Hotelname'),
(425, 'Zadajte aktuálne heslo', 'en', 'Enter your current password'),
(426, 'Zadajte aktuálne heslo', 'de', 'Geben Sie Ihr aktuelles Passwort ein'),
(427, 'Zadajte nové heslo', 'en', 'Enter a new password'),
(428, 'Zadajte nové heslo', 'de', 'Geben Sie ein neues Passwort ein'),
(429, 'Zadajte nové heslo ešte raz', 'en', 'Enter the new password again'),
(430, 'Zadajte nové heslo ešte raz', 'de', 'Geben Sie das neue Passwort erneut ein'),
(431, 'Zmeniť heslo', 'en', 'Change password'),
(432, 'Zmeniť heslo', 'de', 'Passwort ändern'),
(433, 'Vaše údaje boli úspešne zmenené.', 'en', 'Your details have been successfully changed.'),
(434, 'Vaše údaje boli úspešne zmenené.', 'de', 'Ihre Daten wurden erfolgreich geändert.'),
(435, 'Aktualizovať', 'en', 'Update'),
(436, 'Aktualizovať', 'de', 'Aktualisieren'),
(437, 'Heslo bolo zmenené úspešne.', 'en', 'The password was changed successfully.'),
(438, 'Heslo bolo zmenené úspešne.', 'de', 'Das Passwort wurde erfolgreich geändert.'),
(439, 'Zmena hesla bola neúspešna. Skúste znova.', 'en', 'Password change failed. Please try again.'),
(440, 'Zmena hesla bola neúspešna. Skúste znova.', 'de', 'Die Passwortänderung ist fehlgeschlagen. Bitte versuchen Sie es erneut.'),
(441, 'Aktálne heslo nie je správne.', 'en', 'The current password is incorrect.'),
(442, 'Aktálne heslo nie je správne.', 'de', 'Das aktuelle Passwort ist falsch.'),
(443, 'Heslá sa nezhodujú.', 'en', 'The passwords do not match.'),
(444, 'Heslá sa nezhodujú.', 'de', 'Die Passwörter stimmen nicht überein.'),
(445, 'Osobné údaje', 'en', 'Personal data'),
(446, 'Osobné údaje', 'de', 'Personenbezogene Daten'),
(447, 'Zmena hesla', 'en', 'Change password'),
(448, 'Zmena hesla', 'de', 'Passwort ändern'),
(449, 'História rezervácií', 'en', 'History of reservations'),
(450, 'História rezervácií', 'de', 'Reservierungsverlauf'),
(451, 'Slovensko', 'en', 'Slovakia'),
(452, 'Slovensko', 'de', 'Slowakei'),
(453, 'Rakúsko', 'en', 'Austria'),
(454, 'Rakúsko', 'de', 'Österreich'),
(455, 'Chorvátsko', 'en', 'Croatia'),
(456, 'Chorvátsko', 'de', 'Kroatien'),
(457, 'Veľká Británia', 'en', 'Great Britain'),
(458, 'Veľká Británia', 'de', 'Großbritannien');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`bookings_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customers_id`);

--
-- Indexes for table `hotels_info`
--
ALTER TABLE `hotels_info`
  ADD PRIMARY KEY (`hotels_id`);

--
-- Indexes for table `hotels_reviews`
--
ALTER TABLE `hotels_reviews`
  ADD PRIMARY KEY (`reviews_id`);

--
-- Indexes for table `hotels_rooms`
--
ALTER TABLE `hotels_rooms`
  ADD PRIMARY KEY (`rooms_id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `bookings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customers_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `hotels_info`
--
ALTER TABLE `hotels_info`
  MODIFY `hotels_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hotels_reviews`
--
ALTER TABLE `hotels_reviews`
  MODIFY `reviews_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `hotels_rooms`
--
ALTER TABLE `hotels_rooms`
  MODIFY `rooms_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=459;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
