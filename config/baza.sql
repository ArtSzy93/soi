-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 18 Paź 2023, 16:29
-- Wersja serwera: 10.4.24-MariaDB
-- Wersja PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `inz`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `advertisements`
--

CREATE TABLE `advertisements` (
  `id` int(11) NOT NULL,
  `kto` varchar(100) CHARACTER SET utf8 NOT NULL,
  `title` varchar(200) CHARACTER SET utf8 NOT NULL,
  `text` varchar(1000) CHARACTER SET utf8 NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `changelog`
--

CREATE TABLE `changelog` (
  `id` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `message` varchar(900) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `monster`
--

CREATE TABLE `monster` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `strenght` int(11) NOT NULL DEFAULT 0,
  `resilience` int(11) NOT NULL DEFAULT 0,
  `intelligence` int(11) NOT NULL DEFAULT 0,
  `health` int(11) NOT NULL DEFAULT 0,
  `min_dmg` int(11) NOT NULL DEFAULT 0,
  `max_dmg` int(11) NOT NULL DEFAULT 10,
  `description` varchar(800) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `private_messages`
--

CREATE TABLE `private_messages` (
  `id` int(11) NOT NULL,
  `sender` int(100) NOT NULL,
  `recipient` int(100) NOT NULL,
  `tittle` varchar(45) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `private_room`
--

CREATE TABLE `private_room` (
  `id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Wyzwalacze `private_room`
--
DELIMITER $$
CREATE TRIGGER `add_member` AFTER INSERT ON `private_room` FOR EACH ROW BEGIN
    INSERT INTO private_room_member (room_id, user_id)
    VALUES (NEW.id, NEW.owner_id);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `private_room_member`
--

CREATE TABLE `private_room_member` (
  `room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `private_room_messages`
--

CREATE TABLE `private_room_messages` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `sender` varchar(60) NOT NULL,
  `message` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `public_chat_messages`
--

CREATE TABLE `public_chat_messages` (
  `id` int(11) NOT NULL,
  `sender` varchar(40) CHARACTER SET utf8 NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `public_tavern_messages`
--

CREATE TABLE `public_tavern_messages` (
  `id` int(11) NOT NULL,
  `sender` varchar(60) NOT NULL,
  `message` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `rank` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(500) NOT NULL,
  `dataDolaczenia` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `active` tinyint(2) NOT NULL DEFAULT 0,
  `active_code` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Wyzwalacze `users`
--
DELIMITER $$
CREATE TRIGGER `add_user_coin` AFTER INSERT ON `users` FOR EACH ROW INSERT INTO users_coin VALUES (NULL, NEW.id, 0)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `add_user_stats` AFTER INSERT ON `users` FOR EACH ROW INSERT INTO users_stats VALUES (NULL, NEW.id, "", 0, 0, 0, 100, 100, 1, 0, 100, 20, 20)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `usuwanie_powiazanych` AFTER DELETE ON `users` FOR EACH ROW BEGIN
    DELETE FROM users_stats WHERE users_stats.user_id = OLD.id;
    DELETE FROM users_coin WHERE users_coin.user_id = OLD.id;
    DELETE FROM users_weapons WHERE users_weapons.user_id = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users_coin`
--

CREATE TABLE `users_coin` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Z tabeli users',
  `gold` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users_stats`
--

CREATE TABLE `users_stats` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `strength` int(11) DEFAULT 0,
  `resilience` int(11) DEFAULT 0,
  `intelligence` int(11) DEFAULT 0,
  `health` int(11) NOT NULL DEFAULT 100,
  `max_health` int(11) DEFAULT 100,
  `level` int(11) NOT NULL DEFAULT 1,
  `exp` int(11) NOT NULL DEFAULT 0,
  `limit_exp` int(11) NOT NULL DEFAULT 100,
  `energy` int(11) NOT NULL DEFAULT 20,
  `max_energy` int(11) NOT NULL DEFAULT 20
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users_weapons`
--

CREATE TABLE `users_weapons` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `weapon_id` int(11) NOT NULL,
  `pseudoname` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '// Własna nazwa broni',
  `active` tinyint(4) NOT NULL DEFAULT 0 COMMENT '// 0 - Zdjęca \r\n// 1 - Założone'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `weapon`
--

CREATE TABLE `weapon` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '// Nazwa broni',
  `price` int(11) NOT NULL,
  `min_dmg` int(11) NOT NULL DEFAULT 0 COMMENT '// Minimlane obrażenia broni',
  `max_dmg` int(11) NOT NULL DEFAULT 0 COMMENT '// Masymalne obrażenia broni'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Wyzwalacze `weapon`
--
DELIMITER $$
CREATE TRIGGER `usuwanie_powiazanych_broni` BEFORE DELETE ON `weapon` FOR EACH ROW BEGIN
    DELETE FROM users_weapons WHERE users_weapons.weapon_id = OLD.id;
END
$$
DELIMITER ;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `changelog`
--
ALTER TABLE `changelog`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `monster`
--
ALTER TABLE `monster`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `private_messages`
--
ALTER TABLE `private_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender-username` (`sender`);

--
-- Indeksy dla tabeli `private_room`
--
ALTER TABLE `private_room`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner-user` (`owner_id`);

--
-- Indeksy dla tabeli `private_room_member`
--
ALTER TABLE `private_room_member`
  ADD KEY `room-room` (`room_id`),
  ADD KEY `user-user` (`user_id`);

--
-- Indeksy dla tabeli `private_room_messages`
--
ALTER TABLE `private_room_messages`
  ADD KEY `room_room` (`room_id`);

--
-- Indeksy dla tabeli `public_chat_messages`
--
ALTER TABLE `public_chat_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `public_tavern_messages`
--
ALTER TABLE `public_tavern_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users_coin`
--
ALTER TABLE `users_coin`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users_stats`
--
ALTER TABLE `users_stats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_unikalny` (`user_id`);

--
-- Indeksy dla tabeli `users_weapons`
--
ALTER TABLE `users_weapons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user-weapon` (`user_id`),
  ADD KEY `wepaon-wepaon` (`weapon_id`);

--
-- Indeksy dla tabeli `weapon`
--
ALTER TABLE `weapon`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `changelog`
--
ALTER TABLE `changelog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `monster`
--
ALTER TABLE `monster`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `private_messages`
--
ALTER TABLE `private_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `private_room`
--
ALTER TABLE `private_room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `public_chat_messages`
--
ALTER TABLE `public_chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `public_tavern_messages`
--
ALTER TABLE `public_tavern_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `users_coin`
--
ALTER TABLE `users_coin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `users_stats`
--
ALTER TABLE `users_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `users_weapons`
--
ALTER TABLE `users_weapons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `weapon`
--
ALTER TABLE `weapon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `private_messages`
--
ALTER TABLE `private_messages`
  ADD CONSTRAINT `sender-username` FOREIGN KEY (`sender`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `private_room`
--
ALTER TABLE `private_room`
  ADD CONSTRAINT `owner-user` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `private_room_member`
--
ALTER TABLE `private_room_member`
  ADD CONSTRAINT `room-room` FOREIGN KEY (`room_id`) REFERENCES `private_room` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user-user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `private_room_messages`
--
ALTER TABLE `private_room_messages`
  ADD CONSTRAINT `room_room` FOREIGN KEY (`room_id`) REFERENCES `private_room` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `users_weapons`
--
ALTER TABLE `users_weapons`
  ADD CONSTRAINT `user-weapon` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `wepaon-wepaon` FOREIGN KEY (`weapon_id`) REFERENCES `weapon` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
