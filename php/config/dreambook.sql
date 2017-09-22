-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Set 22, 2017 alle 10:39
-- Versione del server: 10.1.21-MariaDB
-- Versione PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dreambook`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `commento`
--

CREATE TABLE `commento` (
  `ID` int(11) NOT NULL,
  `Utente` varchar(16) NOT NULL,
  `Post` int(11) NOT NULL,
  `Messaggio` text NOT NULL,
  `Data` date NOT NULL,
  `Ora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `commento`
--

INSERT INTO `commento` (`ID`, `Utente`, `Post`, `Messaggio`, `Data`, `Ora`) VALUES
(13, 'heka', 26, 'Fantastica esperienza!', '2017-09-21', '21:14:52'),
(14, 'heka', 28, 'Semplicemente senza fiato :O', '2017-09-21', '21:15:34'),
(15, 'xenia', 28, 'Sono rimasta folgorata da questo racconto!', '2017-09-21', '21:26:09'),
(16, 'xenia', 25, 'Fai sogni sempre felici, ti invidio un po\'', '2017-09-21', '21:27:26');

-- --------------------------------------------------------

--
-- Struttura della tabella `post`
--

CREATE TABLE `post` (
  `ID` int(11) NOT NULL,
  `Titolo` varchar(50) NOT NULL,
  `Messaggio` text NOT NULL,
  `Utente` varchar(16) NOT NULL,
  `Pubblico` tinyint(1) NOT NULL,
  `DataC` date NOT NULL,
  `OraC` time NOT NULL,
  `DataM` date DEFAULT NULL,
  `OraM` time DEFAULT NULL,
  `Luogo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `post`
--

INSERT INTO `post` (`ID`, `Titolo`, `Messaggio`, `Utente`, `Pubblico`, `DataC`, `OraC`, `DataM`, `OraM`, `Luogo`) VALUES
(25, 'Una bella serata!', 'In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.', 'mika', 1, '2017-09-21', '18:25:21', '2017-09-21', '18:34:03', 'Torino'),
(26, 'La lepre!', 'Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus.', 'heka', 1, '2017-09-21', '18:50:56', '2017-09-21', '21:12:40', 'Santena'),
(27, 'Una bella serata intorno al mare!', 'Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.', 'xenia', 1, '2017-09-21', '20:13:13', '2017-09-21', '20:14:44', 'Alba'),
(28, 'Un pirata!', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.', 'xenia', 1, '2017-09-21', '21:11:54', NULL, NULL, 'Oceano Atlantico'),
(29, 'Camminavo sull\'acqua...', 'Li Europan lingues es membres del sam familie. Lor separat existentie es un myth. Por scientie, musica, sport etc, litot Europa usa li sam vocabular. Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Omnicos directe al desirabilite de un nov lingua franca: On refusa continuar payar custosi traductores.', 'heka', 1, '2017-09-21', '21:13:51', NULL, NULL, 'Pavia'),
(30, 'Un cobra per strada!', 'One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections. The bedding was hardly able to cover it and seemed ready to slide off any moment.', 'akidos', 1, '2017-09-21', '21:17:52', NULL, NULL, 'Canale'),
(31, 'Cavalcando locuste...', 'Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? ', 'akidos', 1, '2017-09-21', '21:19:11', NULL, NULL, 'Roma'),
(32, 'Spazio infinito!', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.', 'akidos', 0, '2017-09-21', '21:20:15', NULL, NULL, ''),
(33, 'Lottare contro un orso!', 'The languages only differ in their grammar, their pronunciation and their most common words. Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words.', 'mika', 1, '2017-09-21', '21:22:04', NULL, NULL, 'Torino'),
(34, 'Una gallina solitaria...', 'Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum.', 'mika', 0, '2017-09-21', '21:22:44', NULL, NULL, 'Canale');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `Email` varchar(70) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  `Descrizione` text,
  `Nome` varchar(30) DEFAULT NULL,
  `Cognome` varchar(30) DEFAULT NULL,
  `Username` varchar(16) NOT NULL,
  `DataI` date NOT NULL,
  `Residenza` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`Email`, `Password`, `Descrizione`, `Nome`, `Cognome`, `Username`, `DataI`, `Residenza`) VALUES
(NULL, '$2y$10$Pk4fpK0zzC4DLVq0791lSesoP6Pc4.ApAHULyVxfGMlBlbvIvmF3i', NULL, NULL, NULL, 'akidos', '2017-09-21', NULL),
(NULL, '$2y$10$C1gyby9CHY3hBluukK7YX./H2ytclOhVr/j2HR1A4hTL6RTEKKmTG', NULL, NULL, NULL, 'giulia', '2017-09-22', NULL),
(NULL, '$2y$10$bZxPxxwfGIX1hycXwwaKRe82mFBxomMXlsdZCikxnF5OhdB8nF/.e', NULL, NULL, NULL, 'heka', '2017-09-21', NULL),
('', '$2y$10$YkmTkeXKwe3z/ECygPLrUO9jHpNPFyKsl4.ZsdlPEAOTgSg6KHpQW', 'The bedding was hardly able to cover it and seemed ready to slide off any moment. His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked. &quot;What\'s happened to me?&quot;', '', '', 'mika', '2017-09-21', ''),
(NULL, '$2y$10$FhJrYGhZaKyP4MvZ/DvFYu3WbAXH7m9wESsUwKfIUNO6BOTKW2wfS', NULL, NULL, NULL, 'piero', '2017-09-22', NULL),
('xenia@live.com', '$2y$10$fym0w49zMgCxXMiQR7uj6eSzCJRjynL8WWwbd3SptmXOkaAUAohT6', '', '', '', 'xenia', '2017-09-21', '');

-- --------------------------------------------------------

--
-- Struttura della tabella `voti`
--

CREATE TABLE `voti` (
  `Utente` varchar(16) NOT NULL,
  `Post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `voti`
--

INSERT INTO `voti` (`Utente`, `Post`) VALUES
('akidos', 25),
('heka', 25),
('heka', 26),
('heka', 27),
('heka', 29),
('mika', 25),
('mika', 28),
('mika', 29),
('mika', 31),
('piero', 27),
('xenia', 25),
('xenia', 29),
('xenia', 31);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `commento`
--
ALTER TABLE `commento`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `commento_ibfk_1` (`Utente`),
  ADD KEY `commento_ibfk_2` (`Post`);

--
-- Indici per le tabelle `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `post_ibfk_1` (`Utente`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`Username`);

--
-- Indici per le tabelle `voti`
--
ALTER TABLE `voti`
  ADD PRIMARY KEY (`Utente`,`Post`),
  ADD KEY `voti_ibfk_2` (`Post`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `commento`
--
ALTER TABLE `commento`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT per la tabella `post`
--
ALTER TABLE `post`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `commento`
--
ALTER TABLE `commento`
  ADD CONSTRAINT `commento_ibfk_1` FOREIGN KEY (`Utente`) REFERENCES `utente` (`Username`) ON DELETE CASCADE,
  ADD CONSTRAINT `commento_ibfk_2` FOREIGN KEY (`Post`) REFERENCES `post` (`ID`) ON DELETE CASCADE;

--
-- Limiti per la tabella `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`Utente`) REFERENCES `utente` (`Username`) ON DELETE CASCADE;

--
-- Limiti per la tabella `voti`
--
ALTER TABLE `voti`
  ADD CONSTRAINT `voti_ibfk_1` FOREIGN KEY (`Utente`) REFERENCES `utente` (`Username`) ON DELETE CASCADE,
  ADD CONSTRAINT `voti_ibfk_2` FOREIGN KEY (`Post`) REFERENCES `post` (`ID`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
