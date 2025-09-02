-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 31 août 2025 à 00:37
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
-- Base de données : `touche_pas_au_klaxon`
--

--
-- Déchargement des données de la table `agences`
--

INSERT INTO `agences` (`id_agence`, `nom_agence`) VALUES
(1, 'Paris'),
(2, 'Lyon'),
(3, 'Marseille'),
(4, 'Toulouse'),
(5, 'Nice'),
(6, 'Nantes'),
(7, 'Strasbourg'),
(8, 'Montpellier'),
(9, 'Bordeaux'),
(10, 'Lille'),
(11, 'Rennes'),
(12, 'Reims');

--
-- Déchargement des données de la table `trajets`
--

INSERT INTO `trajets` (`id_trajet`, `id_auteur`, `id_agence_depart`, `id_agence_arrivee`, `date_depart`, `date_arrivee`, `places_disponibles`, `places_totales`) VALUES
(1, 10, 2, 3, '2025-07-28 03:44:00', '2025-07-28 07:44:00', 3, 5),
(6, 1, 4, 7, '2025-08-28 20:40:00', '2025-08-29 05:40:00', 0, 4),
(8, 20, 1, 2, '2025-08-30 04:33:00', '2025-08-30 16:33:00', 3, 4),
(9, 20, 1, 2, '2025-09-02 01:35:00', '2025-09-02 06:32:00', 4, 5),
(11, 20, 7, 8, '2025-09-24 23:46:00', '2025-09-25 07:46:00', 4, 4);

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `prenom_user`, `telephone_user`, `nom_user`, `email_user`, `password`, `role`) VALUES
(1, 'Alexandre', '0612345678', 'Martin', 'alexandre.martin@email.fr', '12345', 'user'),
(2, 'Sophie', '0698765432', 'Dubois', 'sophie.dubois@email.fr', '12345', 'user'),
(3, 'Julien', '0622446688', 'Bernard', 'julien.bernard@email.fr', '12345', 'user'),
(4, 'Camille', '0611223344', 'Moreau', 'camille.moreau@email.fr', '12345', 'user'),
(5, 'Lucie', '0777889900', 'Lefèvre', 'lucie.lefevre@email.fr', '12345', 'user'),
(6, 'Thomas', '0655443322', 'Leroy', 'thomas.leroy@email.fr', '12345', 'user'),
(7, 'Chloé', '0633221199', 'Roux', 'chloe.roux@email.fr', '12345', 'user'),
(8, 'Maxime', '0766778899', 'Petit', 'maxime.petit@email.fr', '12345', 'user'),
(9, 'Laura', '0688776655', 'Garnier', 'laura.garnier@email.fr', '12345', 'user'),
(10, 'Antoine', '0744556677', 'Dupuis', 'antoine.dupuis@email.fr', '12345', 'user'),
(11, 'Emma', '0699887766', 'Lefebvre', 'emma.lefebvre@email.fr', '12345', 'user'),
(12, 'Louis', '0655667788', 'Fontaine', 'louis.fontaine@email.fr', '12345', 'user'),
(13, 'Clara', '0788990011', 'Chevalier', 'clara.chevalier@email.fr', '12345', 'user'),
(14, 'Nicolas', '0644332211', 'Robin', 'nicolas.robin@email.fr', '12345', 'user'),
(15, 'Marine', '0677889922', 'Gauthier', 'marine.gauthier@email.fr', '12345', 'user'),
(16, 'Pierre', '0722334455', 'Fournier', 'pierre.fournier', '12345', 'user'),
(17, 'Sarah', '0688665544', 'Girard', 'sarah.girard@email.fr', '12345', 'user'),
(18, 'Hugo', '0611223366', 'Lambert', 'hugo.lambert@email.fr', '12345', 'user'),
(19, 'Julie', '0733445566', 'Masson', 'julie.masson@email.fr', '12345', 'user'),
(20, 'Arthur', '0666554433', 'Henry', 'arthur.henry@email.fr', '123456', 'admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
