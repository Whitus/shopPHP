-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 06 Maj 2017, 14:33
-- Wersja serwera: 5.7.16-10-log
-- Wersja PHP: 5.6.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `shop`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cms_activation_codes`
--

CREATE TABLE `cms_activation_codes` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `code` text NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cms_admins`
--

CREATE TABLE `cms_admins` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `level` int(11) NOT NULL DEFAULT '1',
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `cms_admins`
--

INSERT INTO `cms_admins` (`id`, `username`, `password`, `level`, `added`) VALUES
(1, 'Test', '7288edd0fc3ffcbe93a0cf06e3568e28521687bc', 1, '2017-05-06 00:27:30');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cms_admins_messages`
--

CREATE TABLE `cms_admins_messages` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `username` text NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `cms_admins_messages`
--

INSERT INTO `cms_admins_messages` (`id`, `text`, `username`, `added`) VALUES
(1, 'Test', 'Test', '2017-05-06 00:37:34');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cms_ads`
--

CREATE TABLE `cms_ads` (
  `id` int(11) NOT NULL,
  `site_url` text NOT NULL,
  `image_url` text NOT NULL,
  `username` text NOT NULL,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `cms_ads`
--

INSERT INTO `cms_ads` (`id`, `site_url`, `image_url`, `username`, `end_time`, `added`) VALUES
(1, 'sadsad', 'sdaads', 'Test', '2017-07-05 00:25:41', '2017-05-06 00:25:41');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cms_news`
--

CREATE TABLE `cms_news` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `author` text NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `cms_news`
--

INSERT INTO `cms_news` (`id`, `title`, `description`, `author`, `added`) VALUES
(1, 'Czym jest Lorem Ipsum?', 'Lorem Ipsum jest tekstem stosowanym jako przykładowy wypełniacz w przemyśle poligraficznym. Został po raz pierwszy użyty w XV w. przez nieznanego drukarza do wypełnienia tekstem próbnej książki. Pięć wieków później zaczął być używany przemyśle elektronicznym, pozostając praktycznie niezmienionym. Spopularyzował się w latach 60. XX w. wraz z publikacją arkuszy Letrasetu, zawierających fragmenty Lorem Ipsum, a ostatnio z zawierającym różne wersje Lorem Ipsum oprogramowaniem przeznaczonym do realizacji druków na komputerach osobistych, jak Aldus PageMaker', 'Admin', '2017-05-06 00:13:13');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cms_opinie`
--

CREATE TABLE `cms_opinie` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `username` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `cms_opinie`
--

INSERT INTO `cms_opinie` (`id`, `description`, `username`, `status`, `added`) VALUES
(1, 'Test', 'Test', 1, '2017-05-06 00:51:21');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cms_orders`
--

CREATE TABLE `cms_orders` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `image_url` text NOT NULL,
  `download_url` text NOT NULL,
  `cost` float NOT NULL DEFAULT '0',
  `amount` int(11) NOT NULL DEFAULT '25',
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cms_orders_users`
--

CREATE TABLE `cms_orders_users` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `username` text NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cms_payments_list`
--

CREATE TABLE `cms_payments_list` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `contents` text NOT NULL,
  `cost` float NOT NULL DEFAULT '0',
  `wallet` float NOT NULL DEFAULT '0',
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `cms_payments_list`
--

INSERT INTO `cms_payments_list` (`id`, `number`, `contents`, `cost`, `wallet`, `added`) VALUES
(1, 4142323, 'MSMS.TEST', 55, 55, '2017-05-06 00:50:49');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cms_promo_codes`
--

CREATE TABLE `cms_promo_codes` (
  `id` int(11) NOT NULL,
  `code` text NOT NULL,
  `wallet` float NOT NULL DEFAULT '0',
  `amount` int(11) NOT NULL DEFAULT '25',
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cms_promo_codes_users`
--

CREATE TABLE `cms_promo_codes_users` (
  `id` int(11) NOT NULL,
  `code` text NOT NULL,
  `username` text NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cms_settings`
--

CREATE TABLE `cms_settings` (
  `id` int(11) NOT NULL,
  `url` text NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `cms_settings`
--

INSERT INTO `cms_settings` (`id`, `url`, `name`) VALUES
(1, 'http://whiteblue.ct8.pl/test/', 'Test');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cms_users`
--

CREATE TABLE `cms_users` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `wallet` float NOT NULL DEFAULT '0.5',
  `active` int(11) NOT NULL DEFAULT '0',
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `cms_users`
--

INSERT INTO `cms_users` (`id`, `username`, `email`, `password`, `first_name`, `last_name`, `wallet`, `active`, `added`) VALUES
(1, 'Test', 'test@whiteblue.ct8.pl', 'daef4953b9783365cad6615223720506cc46c5167cd16ab500fa597aa08ff964eb24fb19687f34d7665f778fcb6c5358fc0a5b81e1662cf90f73a2671c53f991', 'Test', 'Testowe', 55547.9, 1, '2017-05-06 00:20:42');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `cms_activation_codes`
--
ALTER TABLE `cms_activation_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_admins`
--
ALTER TABLE `cms_admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_admins_messages`
--
ALTER TABLE `cms_admins_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_ads`
--
ALTER TABLE `cms_ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_news`
--
ALTER TABLE `cms_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_opinie`
--
ALTER TABLE `cms_opinie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_orders`
--
ALTER TABLE `cms_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_orders_users`
--
ALTER TABLE `cms_orders_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_payments_list`
--
ALTER TABLE `cms_payments_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_promo_codes`
--
ALTER TABLE `cms_promo_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_promo_codes_users`
--
ALTER TABLE `cms_promo_codes_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_settings`
--
ALTER TABLE `cms_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_users`
--
ALTER TABLE `cms_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `cms_activation_codes`
--
ALTER TABLE `cms_activation_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `cms_admins`
--
ALTER TABLE `cms_admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `cms_admins_messages`
--
ALTER TABLE `cms_admins_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `cms_ads`
--
ALTER TABLE `cms_ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `cms_news`
--
ALTER TABLE `cms_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `cms_opinie`
--
ALTER TABLE `cms_opinie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `cms_orders`
--
ALTER TABLE `cms_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `cms_orders_users`
--
ALTER TABLE `cms_orders_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `cms_payments_list`
--
ALTER TABLE `cms_payments_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `cms_promo_codes`
--
ALTER TABLE `cms_promo_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `cms_promo_codes_users`
--
ALTER TABLE `cms_promo_codes_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `cms_settings`
--
ALTER TABLE `cms_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `cms_users`
--
ALTER TABLE `cms_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
