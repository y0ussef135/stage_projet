-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 01 août 2025 à 00:34
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `stage_projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `agence`
--

CREATE TABLE `agence` (
  `id` int(11) NOT NULL,
  `nom_agence` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `agence`
--

INSERT INTO `agence` (`id`, `nom_agence`) VALUES
(4, 'AGENCE ARIANA'),
(27, 'AGENCE ARIANA 2'),
(23, 'AGENCE BEJA'),
(7, 'AGENCE BEN AROUS'),
(19, 'AGENCE BIZERTE'),
(17, 'AGENCE GABES'),
(5, 'AGENCE GAFSA'),
(22, 'AGENCE JENDOUBA'),
(10, 'AGENCE KAIROUAN'),
(3, 'AGENCE KASSERINE'),
(14, 'AGENCE KEBILI'),
(20, 'AGENCE LE KEF'),
(16, 'AGENCE MAHDIA'),
(8, 'AGENCE MANOUBA'),
(13, 'AGENCE MEDENINE'),
(15, 'AGENCE MONASTIR'),
(21, 'AGENCE NABEUL'),
(9, 'AGENCE SFAX'),
(26, 'Agence Sfax 2'),
(24, 'AGENCE SIDI BOUZID'),
(18, 'AGENCE SILIANA'),
(12, 'AGENCE SOUSSE'),
(11, 'AGENCE TATAOUINE'),
(6, 'AGENCE TOZEUR'),
(28, 'AGENCE TUNIS 2'),
(1, 'AGENCE TUNIS Bardo'),
(2, 'AGENCE ZAGHOUAN'),
(25, 'Succursale Med V');

-- --------------------------------------------------------

--
-- Structure de la table `client_demande`
--

CREATE TABLE `client_demande` (
  `id` int(11) NOT NULL,
  `civilite` varchar(10) DEFAULT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `nom_epoux` varchar(100) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `lieu_naissance` varchar(100) DEFAULT NULL,
  `nationalite` varchar(50) DEFAULT NULL,
  `etat_civil` varchar(50) DEFAULT NULL,
  `genre` varchar(20) DEFAULT NULL,
  `nbre_enfants` int(11) DEFAULT NULL,
  `type_pid` varchar(20) DEFAULT NULL,
  `numero_pid` varchar(50) DEFAULT NULL,
  `date_delivrance` date DEFAULT NULL,
  `lieu_delivrance` varchar(100) DEFAULT NULL,
  `profession` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `objet_credit` varchar(255) DEFAULT NULL,
  `montant_demande` decimal(12,2) DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `periodicite` varchar(50) DEFAULT NULL,
  `agence` varchar(100) DEFAULT NULL,
  `objet_projet` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `gouvernorat` varchar(100) DEFAULT NULL,
  `delegation` varchar(100) DEFAULT NULL,
  `localite` varchar(100) DEFAULT NULL,
  `code_postal` varchar(10) DEFAULT NULL,
  `nbre_emplois_creer` int(11) DEFAULT NULL,
  `nbre_emplois_existants` int(11) DEFAULT NULL,
  `installe` varchar(10) DEFAULT NULL,
  `files` varchar(100) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `etat` enum('en attente','acceptée','refusée') NOT NULL DEFAULT 'en attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client_demande`
--

INSERT INTO `client_demande` (`id`, `civilite`, `nom`, `prenom`, `nom_epoux`, `date_naissance`, `lieu_naissance`, `nationalite`, `etat_civil`, `genre`, `nbre_enfants`, `type_pid`, `numero_pid`, `date_delivrance`, `lieu_delivrance`, `profession`, `telephone`, `email`, `objet_credit`, `montant_demande`, `duree`, `periodicite`, `agence`, `objet_projet`, `adresse`, `gouvernorat`, `delegation`, `localite`, `code_postal`, `nbre_emplois_creer`, `nbre_emplois_existants`, `installe`, `files`, `date_creation`, `etat`) VALUES
(1, 'M', 'raboudi', 'bilel', 'sami', '1999-02-10', 'tunis', 'tunisien', 'Célibataire', 'Homme', 0, 'CIN', '12345678', '2016-05-10', 'tunis', 'medecin', '22222222', 'bilelrbd@gmail.com', 'agriculture', 100000.00, 12, '0', 'bardo', 'fle7a', 'bizerte', 'bardo', 'yauuauay', '10 rue el houma', '2020', 5, 10, 'Oui', '', '2025-07-18 15:55:29', 'en attente');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `date_creation` datetime DEFAULT current_timestamp(),
  `nb_cnx` int(11) NOT NULL DEFAULT 0,
  `Etat` enum('vérrouillé','actif') NOT NULL DEFAULT 'actif',
  `role` enum('admin','client') NOT NULL DEFAULT 'client',
  `confirmation_code` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `email`, `password`, `date_creation`, `nb_cnx`, `Etat`, `role`, `confirmation_code`) VALUES
(1, 'jemai', 'youssef', 'youssef@gmail.com', '$2y$10$8pfRjh1kmBHeWombAl/ATe1sksqT0w/kAtbzARVTagr8ECqKgWyQ6', '2025-07-10 10:28:12', 0, 'actif', 'admin', NULL),
(2, 'raboudi', 'bilel', 'bilelrbd@gmail.com', '$2y$10$Fx5MCQKJhDLsMLCAU80NVeFd4FiwHVRXXUBaMVqzrbra0.C3Y9Gp2', '2025-07-18 16:51:39', 0, 'actif', 'client', NULL),
(3, 'rabeh', 'abdlkhalek', 'rabehabd@gmail.com', '$2y$10$.n3ksdUVUQDwBZ.Ej3wjx.7yruadJjQVVTq5lB6XVGlZsdTuvrVb2', '2025-07-24 10:45:09', 0, 'actif', 'client', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `agence`
--
ALTER TABLE `agence`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom_agence` (`nom_agence`);

--
-- Index pour la table `client_demande`
--
ALTER TABLE `client_demande`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `agence`
--
ALTER TABLE `agence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `client_demande`
--
ALTER TABLE `client_demande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
