-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2018. Jún 03. 20:59
-- Kiszolgáló verziója: 10.1.32-MariaDB
-- PHP verzió: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `fogadas`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok`
--

CREATE TABLE `felhasznalok` (
  `id` int(100) NOT NULL,
  `username` text COLLATE utf8_hungarian_ci NOT NULL,
  `password` text COLLATE utf8_hungarian_ci NOT NULL,
  `rendesnev` text COLLATE utf8_hungarian_ci NOT NULL,
  `vegsogyoztes` int(255) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `felhasznalok`
--

INSERT INTO `felhasznalok` (`id`, `username`, `password`, `rendesnev`, `vegsogyoztes`, `admin`) VALUES
(1, 'ati', 'asd123', 'Jakab Attila', 0, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `meccs`
--

CREATE TABLE `meccs` (
  `id` int(11) NOT NULL,
  `hazainev` text CHARACTER SET utf8 NOT NULL,
  `vendegnev` text COLLATE utf8_hungarian_ci NOT NULL,
  `hazaipont` int(255) NOT NULL,
  `vendegpont` int(255) NOT NULL,
  `szakasz` text COLLATE utf8_hungarian_ci NOT NULL,
  `datum` text COLLATE utf8_hungarian_ci NOT NULL,
  `datumszam` int(255) NOT NULL,
  `lezart` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `ranglista`
--

CREATE TABLE `ranglista` (
  `id` int(255) NOT NULL,
  `felhnev` text COLLATE utf8_hungarian_ci NOT NULL,
  `felhrendes` text COLLATE utf8_hungarian_ci NOT NULL,
  `pont` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `ranglista`
--

INSERT INTO `ranglista` (`id`, `felhnev`, `felhrendes`, `pont`) VALUES
(2, 'ati', 'Jakab Attila', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tippek`
--

CREATE TABLE `tippek` (
  `id` int(255) NOT NULL,
  `meccsid` int(255) NOT NULL,
  `userid` int(255) NOT NULL,
  `username` text COLLATE utf8_hungarian_ci NOT NULL,
  `hazai` int(255) NOT NULL,
  `vendeg` int(255) NOT NULL,
  `datum` text COLLATE utf8_hungarian_ci NOT NULL,
  `datumszam` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `meccs`
--
ALTER TABLE `meccs`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `ranglista`
--
ALTER TABLE `ranglista`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `tippek`
--
ALTER TABLE `tippek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meccs` (`meccsid`),
  ADD KEY `felhmeccs` (`userid`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT a táblához `meccs`
--
ALTER TABLE `meccs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `ranglista`
--
ALTER TABLE `ranglista`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT a táblához `tippek`
--
ALTER TABLE `tippek`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
