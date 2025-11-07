-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Nov 07, 2025 alle 11:55
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grammatica_registrazione`
--
CREATE DATABASE IF NOT EXISTS `grammatica_registrazione` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `grammatica_registrazione`;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `email_verified` tinyint(1) NOT NULL DEFAULT 0,
  `verification_token` varchar(255) DEFAULT NULL,
  `verification_expires` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `username`, `password`, `nome`, `cognome`, `email`, `email_verified`, `verification_token`, `verification_expires`, `created_at`, `updated_at`) VALUES
(1, 'acosta', '$2y$12$Ujg0apbAs0pDfd1z6Blq6OVzooHkkfFYMtqTN3.DUrQc0XnGOuYvG', 'Alberto', 'Costa', 'acosta@itsrossi.vi.it', 0, '1234', '2025-11-07 10:44:08', '2025-11-07 10:44:14', '2025-11-07 10:44:14'),
(2, 'rweferer', '$2y$10$oneLOIo6EY4GXPLD3XbE7OyE88LCz2bnMthdqozagm3WNq99UYoKy', 'holsa', 'TeresiA', 'abcia2website@gmail.com', 0, '325340cecc78a1f651bd1c7423cff4cb7b7aa9a58340c039cf5856761fbdd323', '2025-11-08 11:42:29', '2025-11-07 11:42:29', '2025-11-07 11:42:29'),
(3, 'werferf', '$2y$10$7lhN5tN0uHLyOV3/48V93.YeV9R.ALIk8Y7HcC9fObvmbSBaJIfyG', 'holsa', 'TeresiA', '10934204@itisrossi.vi.it', 0, '0bbe8cc6ef82f56040b67839df35c2432807b95c4dc6f3f63e3d3b931b3d3222', '2025-11-08 11:43:45', '2025-11-07 11:43:45', '2025-11-07 11:43:45');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_unique` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
