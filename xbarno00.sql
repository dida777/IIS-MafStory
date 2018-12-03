-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: 127.0.0.1
-- Čas generovania: Po 03.Dec 2018, 17:25
-- Verzia serveru: 10.1.37-MariaDB
-- Verzia PHP: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `xbarno00`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `aliancia`
--

CREATE TABLE `aliancia` (
  `id_aliancie` int(11) NOT NULL,
  `nazov_aliancie` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `datum_vzniku` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Sťahujem dáta pre tabuľku `aliancia`
--

INSERT INTO `aliancia` (`id_aliancie`, `nazov_aliancie`, `datum_vzniku`) VALUES
(0, 'admin', '0000-00-00'),
(1, 'Milovnici kolacikov', '2018-12-05'),
(4, 'Smrteľné sesterstvo', '2018-12-14');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `clen`
--

CREATE TABLE `clen` (
  `rodne_cislo` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `familia` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `hodnost` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `pokrvna_vazba` varchar(3) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Sťahujem dáta pre tabuľku `clen`
--

INSERT INTO `clen` (`rodne_cislo`, `familia`, `hodnost`, `pokrvna_vazba`) VALUES
('0001010009', 'Morello Cartel', 'kapsar', 'ne'),
('0051010014', 'Monique Cartel', 'snajper', 'ano'),
('0862060012', 'Salieri Cartel', 'sofer/ridic', 'ne'),
('205328002', 'Reynosa Cartel', 'sofer/ridic', 'ano'),
('5403298769', 'Monique Cartel', 'zelenac', 'ano'),
('6804014976', 'Morello Cartel', 'zelenac', 'ano'),
('8412163407', 'Dianne Cartel', 'snajper', 'ne'),
('8854308782', 'Reynosa Cartel', 'uklizec', 'ne'),
('9054018094', 'Dianne Cartel', 'snajper', 'ano'),
('9306284130', 'Dianne Cartel', 'vymahac', 'ano'),
('9602157896', 'Monique Cartel', 'vymahac', 'ne'),
('9707028463', 'Salieri Cartel', 'uklizec', 'ano'),
('9901015678', 'Monique Cartel', 'sofer', 'ano'),
('admin', 'admin', 'admin', '---');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `don`
--

CREATE TABLE `don` (
  `rodne_cislo` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `nazov_familie` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `gps_uzemie` varchar(28) COLLATE utf8_czech_ci NOT NULL,
  `aliancia` int(11) DEFAULT NULL,
  `zvolal_zraz` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Sťahujem dáta pre tabuľku `don`
--

INSERT INTO `don` (`rodne_cislo`, `nazov_familie`, `gps_uzemie`, `aliancia`, `zvolal_zraz`) VALUES
('450808538', 'Morello Cartel', 'N 49°12.16327, E 16°37.24875', NULL, NULL),
('6905317254', 'Salieri Cartel', 'N 49°13.59087, E 16°35.78202', NULL, NULL),
('8660138509', 'Reynosa Cartel', 'N 26°3.88785, W 98°17.80297', 4, 2),
('9754034862', 'Monique Cartel', 'N 36°0.84342, E 14°19.46250', 4, 8),
('9854032958', 'Dianne Cartel', 'N 48°34.63458, E 19°7.55460', 4, NULL),
('admin', 'admin', 'admin', 0, 0);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `osoba`
--

CREATE TABLE `osoba` (
  `rodne_cislo` varchar(10) COLLATE utf8_czech_ci NOT NULL,
  `heslo` varchar(25) COLLATE utf8_czech_ci NOT NULL,
  `meno` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `priezvisko` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `vek` int(11) NOT NULL,
  `typ` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Sťahujem dáta pre tabuľku `osoba`
--

INSERT INTO `osoba` (`rodne_cislo`, `heslo`, `meno`, `priezvisko`, `vek`, `typ`) VALUES
('0001010009', '1234', 'Donald', 'DiNozzo', 18, 0),
('0051010014', '1234', 'Ziva', 'David', 18, 0),
('0862060012', '1234', 'Franta', 'Skocdopol', 10, 0),
('205328002', '1234', 'Milada', 'Novinskaja', 98, 0),
('450808538', '1234', 'Sergio', 'Morello', 73, 1),
('5403298769', '1234', 'Donald', 'Trump', 64, 0),
('6804014976', '1234', 'Vlastislav', 'Mamlasky', 50, 0),
('6905317254', '1234', 'Ennio', 'Salieri', 49, 1),
('8412163407', '1234', 'Theo', 'James', 33, 0),
('8660138509', '1234', 'Paloma', 'Reynosa', 38, 1),
('8854308782', '1234', 'Katherine', 'Alekminskaya', 30, 0),
('9054018094', '1234', 'Yevgeniya', 'Novakova', 28, 0),
('9306284130', '1234', 'Alois', 'Stula', 25, 0),
('9602157896', '1234', 'Rudolf', 'Kučera', 22, 0),
('9707028463', '1234', 'Chuck', 'Norris', 21, 0),
('9754034862', '1234', 'Monika', 'Monique', 20, 1),
('9854032958', '1234', 'Diana', 'Dianne', 19, 1),
('9901015678', '1234', 'Aladin', 'Horvath', 20, 0),
('admin', 'admin', 'admin', 'admin', 0, 2);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `uloha`
--

CREATE TABLE `uloha` (
  `specificke_meno` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `popis_cinnosti` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `vykonavatel` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `zadavatel_don` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `zadavatel_aliancia` int(11) DEFAULT NULL,
  `gps_miesta` varchar(28) COLLATE utf8_czech_ci NOT NULL,
  `cas_zaciatku` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `cas_konca` timestamp NULL DEFAULT NULL,
  `uspesnost` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `komentar` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Sťahujem dáta pre tabuľku `uloha`
--

INSERT INTO `uloha` (`specificke_meno`, `popis_cinnosti`, `vykonavatel`, `zadavatel_don`, `zadavatel_aliancia`, `gps_miesta`, `cas_zaciatku`, `cas_konca`, `uspesnost`, `komentar`) VALUES
('admin', 'admin', 'admin', 'admin', 0, 'admin', '2018-12-01 23:00:00', '2018-12-01 23:00:00', 'admin', 'admin'),
('bumbac zalezitost', 'ciel: Brabry Forbon', '9707028463', '9754034862', NULL, 'N 36°0.84342, E 14°19.46250', '2018-11-30 15:55:16', '2018-11-29 22:00:00', 'ano', 'sadfd'),
('na fasirky', 'rozmlatit', '0051010014', '9754034862', NULL, 'N 40°46.37197, W 73°58.51303', NULL, NULL, '', ''),
('ocista', 'podraz, potreba zbavit sa', '0051010014', '9854032958', NULL, 'N 26°3.88785, W 98°17.80297', '2018-11-30 15:50:11', '2018-11-29 23:59:00', 'ano', 'hihihi'),
('vyber vypalneho', 'Maly Denny meska s platbou', '9306284130', '8660138509', NULL, 'N 29°58.56720, W 90°7.16213', '1999-06-16 22:00:00', '1999-06-16 22:00:00', 'ano', 'dhdtjdjt'),
('zachranna sluzba', 'vazenie Bohunice, 2 ludia', '8854308782', '9854032958', NULL, 'N 49°10.46560, E 16°34.78125', '1985-05-16 22:00:00', '1985-05-16 22:00:00', 'ano', NULL),
('zdvorilostna navsteva', 'Krivonohy Larry si chce pokecat', '6804014976', NULL, 1, 'N 29°58.56720, W 90°7.16213', '2018-11-30 15:54:58', '2018-12-01 22:00:00', 'ne', 'sdfff');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `uzemie`
--

CREATE TABLE `uzemie` (
  `gps` varchar(28) COLLATE utf8_czech_ci NOT NULL,
  `hodnota` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Sťahujem dáta pre tabuľku `uzemie`
--

INSERT INTO `uzemie` (`gps`, `hodnota`) VALUES
('admin', 0),
('N 26°3.88785, W 98°17.80297', 50),
('N 29°58.56720, W 90°7.16213', 10),
('N 36°0.84342, E 14°19.46250', 100),
('N 40°46.37197, W 73°58.51303', 80),
('N 48°34.63458, E 19°7.55460', 100),
('N 49°10.46560, E 16°34.78125', 20),
('N 49°12.16327, E 16°37.24875', 50),
('N 49°13.59087, E 16°35.78202', 100);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `zraz_donov`
--

CREATE TABLE `zraz_donov` (
  `id_zrazu` int(11) NOT NULL,
  `datum_cas` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usporiadatel` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `gps_miesta` varchar(28) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Sťahujem dáta pre tabuľku `zraz_donov`
--

INSERT INTO `zraz_donov` (`id_zrazu`, `datum_cas`, `usporiadatel`, `gps_miesta`) VALUES
(0, '2018-12-03 14:00:54', 'admin', 'admin'),
(2, '2018-12-21 10:22:00', '8660138509', 'N 48°34.63458, E 19°7.55460'),
(8, '2018-12-13 23:59:00', '9754034862', 'N 29°58.56720, W 90°7.16213');

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `aliancia`
--
ALTER TABLE `aliancia`
  ADD PRIMARY KEY (`id_aliancie`);

--
-- Indexy pre tabuľku `clen`
--
ALTER TABLE `clen`
  ADD PRIMARY KEY (`rodne_cislo`);

--
-- Indexy pre tabuľku `don`
--
ALTER TABLE `don`
  ADD PRIMARY KEY (`rodne_cislo`),
  ADD UNIQUE KEY `nazov_familie` (`nazov_familie`),
  ADD KEY `gps_uzemie` (`gps_uzemie`,`aliancia`),
  ADD KEY `aliancia` (`aliancia`),
  ADD KEY `zvolal_zraz` (`zvolal_zraz`);

--
-- Indexy pre tabuľku `osoba`
--
ALTER TABLE `osoba`
  ADD PRIMARY KEY (`rodne_cislo`);

--
-- Indexy pre tabuľku `uloha`
--
ALTER TABLE `uloha`
  ADD PRIMARY KEY (`specificke_meno`),
  ADD KEY `vykonavatel` (`vykonavatel`,`zadavatel_don`,`zadavatel_aliancia`,`gps_miesta`),
  ADD KEY `gps_miesta` (`gps_miesta`),
  ADD KEY `zadavatel_don` (`zadavatel_don`),
  ADD KEY `zadavatel_aliancia` (`zadavatel_aliancia`);

--
-- Indexy pre tabuľku `uzemie`
--
ALTER TABLE `uzemie`
  ADD PRIMARY KEY (`gps`),
  ADD UNIQUE KEY `gps` (`gps`);

--
-- Indexy pre tabuľku `zraz_donov`
--
ALTER TABLE `zraz_donov`
  ADD PRIMARY KEY (`id_zrazu`),
  ADD KEY `usporiadatel` (`usporiadatel`,`gps_miesta`),
  ADD KEY `gps_miesta` (`gps_miesta`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `aliancia`
--
ALTER TABLE `aliancia`
  MODIFY `id_aliancie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pre tabuľku `zraz_donov`
--
ALTER TABLE `zraz_donov`
  MODIFY `id_zrazu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Obmedzenie pre exportované tabuľky
--

--
-- Obmedzenie pre tabuľku `clen`
--
ALTER TABLE `clen`
  ADD CONSTRAINT `clen_ibfk_1` FOREIGN KEY (`rodne_cislo`) REFERENCES `osoba` (`rodne_cislo`);

--
-- Obmedzenie pre tabuľku `don`
--
ALTER TABLE `don`
  ADD CONSTRAINT `don_ibfk_1` FOREIGN KEY (`rodne_cislo`) REFERENCES `osoba` (`rodne_cislo`),
  ADD CONSTRAINT `don_ibfk_2` FOREIGN KEY (`gps_uzemie`) REFERENCES `uzemie` (`gps`),
  ADD CONSTRAINT `don_ibfk_3` FOREIGN KEY (`aliancia`) REFERENCES `aliancia` (`id_aliancie`),
  ADD CONSTRAINT `don_ibfk_4` FOREIGN KEY (`zvolal_zraz`) REFERENCES `zraz_donov` (`id_zrazu`);

--
-- Obmedzenie pre tabuľku `uloha`
--
ALTER TABLE `uloha`
  ADD CONSTRAINT `uloha_ibfk_1` FOREIGN KEY (`gps_miesta`) REFERENCES `uzemie` (`gps`),
  ADD CONSTRAINT `uloha_ibfk_2` FOREIGN KEY (`vykonavatel`) REFERENCES `clen` (`rodne_cislo`),
  ADD CONSTRAINT `uloha_ibfk_3` FOREIGN KEY (`zadavatel_don`) REFERENCES `don` (`rodne_cislo`),
  ADD CONSTRAINT `uloha_ibfk_4` FOREIGN KEY (`zadavatel_aliancia`) REFERENCES `aliancia` (`id_aliancie`);

--
-- Obmedzenie pre tabuľku `zraz_donov`
--
ALTER TABLE `zraz_donov`
  ADD CONSTRAINT `zraz_donov_ibfk_1` FOREIGN KEY (`gps_miesta`) REFERENCES `uzemie` (`gps`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
