-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2021. Ápr 10. 18:26
-- Kiszolgáló verziója: 10.4.18-MariaDB
-- PHP verzió: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `devstar`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_text` varchar(255) DEFAULT NULL,
  `comment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `picture1` varchar(255) DEFAULT NULL,
  `picture2` varchar(255) DEFAULT NULL,
  `picture3` varchar(255) DEFAULT NULL,
  `picture4` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp(),
  `available` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `content`
--

INSERT INTO `content` (`id`, `type_id`, `name`, `icon`, `picture1`, `picture2`, `picture3`, `picture4`, `description`, `content`, `last_update`, `available`) VALUES
(1, 1, 'Flappy3World', NULL, 'pictures/content_image/f3w_cover.png', NULL, NULL, NULL, 'A new platformer game inspired by Flappy bird - made in 2013, now in a 3D environment with multiple characters and abilities to choose from. Coming soon!', NULL, '2021-03-17 18:08:13', 1),
(2, 2, 'Flappy3Word', 'pictures/content_image/f3w_logo.png', 'pictures/content_image/f3w1.png', 'pictures/content_image/f3w2.png', 'pictures/content_image/f3w3.png', 'pictures/content_image/f3w4.png', 'A new platformer game inspired by the original Flappy bird - made in 2013, now in a 3D environment with multiple characters to choose from. The goal is the reach the life-giving water at the end of each level without touching the dangerous pipes!', 'contents/Flappy3World_Installer.zip', '2021-03-18 17:21:52', 1),
(3, 1, 'Battlestar Galactica Online', NULL, 'pictures/content_image/Cylon.png', NULL, NULL, NULL, 'An MMORPG created after the famous sci-fi series Battlestar Galactica (2004-2009). The original game was cancelled in early 2019 but it is time for a reboot! Coming soon!', NULL, '2021-03-17 18:08:29', 1),
(4, 1, 'Sandbox', NULL, 'pictures/content_image/sandbox_conver.png', NULL, NULL, NULL, 'A sandbox for testing out various new features in a 3D environment for upcoming future games. Coming soon!', NULL, '2021-03-18 15:22:21', 1),
(5, 3, 'Day and night cycle with fog', 'pictures/content_image/script.png', NULL, NULL, NULL, NULL, 'A new script for constantly changing day and night cycles with dynamic fog behaviors. Implemented in v0.3 of the upcoming Sandbox.', 'contents/DayNightChange.zip', '2021-03-18 16:14:13', 1),
(6, 3, 'Mouse look', 'pictures/content_image/script.png', NULL, NULL, NULL, NULL, 'A new script for looking around with your mouse. Available in both in 1st and 3rd person view. Implemented in v0.1 of the upcoming Sandbox.', 'contents/MouseLook.zip', '2021-03-18 16:14:06', 1),
(7, 3, 'First person movement', 'pictures/content_image/script.png', NULL, NULL, NULL, NULL, 'A new script for moving, jumping, ducking and sliding with your first person player. Implemented in v0.1 of the upcoming Sandbox.', 'contents/FirstPersonMovement.zip', '2021-03-18 16:13:54', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `content_type`
--

CREATE TABLE `content_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `background_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `content_type`
--

INSERT INTO `content_type` (`id`, `name`, `icon`, `background_image`) VALUES
(1, 'News', 'pictures/required/news.png', 'pictures/required/news_background.jpg'),
(2, 'Games', 'pictures/required/games.png', 'pictures/required/games_background.jpg'),
(3, 'Assets', 'pictures/required/asset.png', 'pictures/required/assets_background.jpg');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `statistics`
--

CREATE TABLE `statistics` (
  `id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `download_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `level` tinyint(5) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_id` (`content_id`),
  ADD KEY `user_id` (`user_id`);

--
-- A tábla indexei `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_ibfk_1` (`type_id`);

--
-- A tábla indexei `content_type`
--
ALTER TABLE `content_type`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `statistics`
--
ALTER TABLE `statistics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `statistics_ibfk_2` (`content_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT a táblához `content_type`
--
ALTER TABLE `content_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `statistics`
--
ALTER TABLE `statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `content`
--
ALTER TABLE `content`
  ADD CONSTRAINT `content_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `content_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `statistics`
--
ALTER TABLE `statistics`
  ADD CONSTRAINT `statistics_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `statistics_ibfk_2` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
