-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 17. Mai 2021 um 21:03
-- Server-Version: 10.4.18-MariaDB
-- PHP-Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `noblesse_cosmetics_clients`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `clients`
--

CREATE TABLE `clients` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `prenom` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `date_naissance` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `num_tel` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `Email` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Daten für Tabelle `clients`
--

INSERT INTO `clients` (`id`, `nom`, `prenom`, `date_naissance`, `num_tel`, `Email`) VALUES
(147, 'Gojo', 'Satoru', '0000-00-00', 'ajouter un numero de tel Ã  ce client', 'ajouter un Email Ã  ce client');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `images`
--

CREATE TABLE `images` (
  `id_client` int(11) NOT NULL,
  `id_rdv` int(11) NOT NULL,
  `id_img` int(11) DEFAULT NULL,
  `img_avant` text COLLATE utf8_bin NOT NULL,
  `img_apres` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Daten für Tabelle `images`
--

INSERT INTO `images` (`id_client`, `id_rdv`, `id_img`, `img_avant`, `img_apres`) VALUES
(1, 2, 1, 'imgs_Empty.png', 'imgs_gogeta1.jpg'),
(1, 3, 1, 'imgs_Empty.png', 'imgs_gogeta1.jpg'),
(1, 3, 2, 'imgs_gogeta2.jpg', 'imgs_Empty.png'),
(1, 3, 3, 'imgs_gogeta1.jpg', 'imgs_broly.jpg'),
(1, 3, 4, 'imgs_gogeta2.jpg', 'imgs_Empty.png'),
(1, 4, 1, 'imgs_Empty.png', 'imgs_Empty.png'),
(1, 5, 1, 'imgs_Empty.png', 'imgs_Empty.png'),
(1, 6, 1, 'imgs_Empty.png', 'imgs_Empty.png');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rendezvous`
--

CREATE TABLE `rendezvous` (
  `id_client` int(11) NOT NULL,
  `id_rdv` int(11) NOT NULL,
  `date_rdv` date DEFAULT NULL,
  `nom_procedure` text COLLATE utf8_bin DEFAULT NULL,
  `infos_rdv` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Daten für Tabelle `rendezvous`
--

INSERT INTO `rendezvous` (`id_client`, `id_rdv`, `date_rdv`, `nom_procedure`, `infos_rdv`) VALUES
(1, 3, '2021-05-14', 'microneeding + dragon king', 'my text is pretty great'),
(2, 1, '2020-05-02', 'aucune idee', 'je sais pas...'),
(155, 1, '9999-01-01', 'inserer un nom Ã  cette procedure', 'remplacer ce texte par des infos pour le rendezvous');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `clients`
--
ALTER TABLE `clients`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
