-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 05 Décembre 2018 à 21:47
-- Version du serveur :  5.6.37
-- Version de PHP :  7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `internships`
--

-- --------------------------------------------------------

--
-- Structure de la table `coordinators`
--

CREATE TABLE IF NOT EXISTS `coordinators` (
  `id` int(8) NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `province` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` int(10) NOT NULL,
  `user_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `employers`
--

CREATE TABLE IF NOT EXISTS `employers` (
  `id` int(8) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `province` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `id_user` int(8) NOT NULL,
  `uuid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `employers`
--

INSERT INTO `employers` (`id`, `name`, `contact_email`, `adress`, `city`, `province`, `postal_code`, `active`, `id_user`, `uuid`) VALUES
(1, 'Nathan', 'lmao@gmail.com', '600 lmao', 'TerreLmao', 'LMAo', 'J3H 2H8', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `internship_offers`
--

CREATE TABLE IF NOT EXISTS `internship_offers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_posted` datetime NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `id_employer` int(8) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `internship_offers`
--

INSERT INTO `internship_offers` (`id`, `name`, `date_posted`, `description`, `active`, `id_employer`) VALUES
(2, 'YEET', '2018-11-07 00:00:00', 'ceci est un meme review CLAP CLAP', 1, 1),
(3, 'for the memes', '2018-11-07 20:58:20', 'LMAO T SERIES SUCKS', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `admission_number` int(8) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL,
  `user_id` int(8) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `students`
--

INSERT INTO `students` (`admission_number`, `name`, `active`, `user_id`, `email`) VALUES
(1463693, 'Nathan Test 123', 1, 3, ''),
(69696969, 'Tekashi 69', 1, 4, ''),
(201463693, 'Nathan Cyr', 0, 1, '');

-- --------------------------------------------------------

--
-- Structure de la table `students_internships`
--

CREATE TABLE IF NOT EXISTS `students_internships` (
  `student_id` int(8) NOT NULL,
  `internship_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(8) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` int(8) NOT NULL COMMENT '''0'' for admin, ''1'' for student, ''2'' for employer'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `user_type`) VALUES
(1, 'test@test.com', '098f6bcd4621d373cade4e832627b4f6', 0),
(2, '201463693', '9a8896ebf2e4a99e4b1c0174504c898a', 1),
(3, '1463693', '16d7a4fca7442dda3ad93c9a726597e4', 1),
(4, '69696969', 'cffb9c1f93b6337e59444dbafbd62369', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user_types`
--

CREATE TABLE IF NOT EXISTS `user_types` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `user_types`
--

INSERT INTO `user_types` (`id`, `type`) VALUES
(0, 'coordinator'),
(1, 'student'),
(2, 'employer');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `coordinators`
--
ALTER TABLE `coordinators`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `employers`
--
ALTER TABLE `employers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `internship_offers`
--
ALTER TABLE `internship_offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_employer` (`id_employer`);

--
-- Index pour la table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`admission_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `user_type` (`user_type`);

--
-- Index pour la table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `coordinators`
--
ALTER TABLE `coordinators`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `employers`
--
ALTER TABLE `employers`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `internship_offers`
--
ALTER TABLE `internship_offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `coordinators`
--
ALTER TABLE `coordinators`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `employers`
--
ALTER TABLE `employers`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `internship_offers`
--
ALTER TABLE `internship_offers`
  ADD CONSTRAINT `fk_id_employer` FOREIGN KEY (`id_employer`) REFERENCES `employers` (`id`);

--
-- Contraintes pour la table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_id_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_types` FOREIGN KEY (`user_type`) REFERENCES `user_types` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
