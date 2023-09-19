-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour forum-v2
CREATE DATABASE IF NOT EXISTS `forum-v2` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `forum-v2`;

-- Listage de la structure de table forum-v2. category
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(50) NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum-v2.category : ~4 rows (environ)
INSERT INTO `category` (`id_category`, `categoryName`) VALUES
	(1, 'Actualités Dofust'),
	(2, 'Stratégies de jeu'),
	(3, 'Guildes et Recrutement'),
	(4, 'Événements en jeu'),
	(5, 'Art et Créations');

-- Listage de la structure de table forum-v2. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int NOT NULL AUTO_INCREMENT,
  `text` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `datePost` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `topic_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id_post`),
  KEY `topic_id` (`topic_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `topic_id` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`) ON DELETE CASCADE,
  CONSTRAINT `user.id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum-v2.post : ~13 rows (environ)
INSERT INTO `post` (`id_post`, `text`, `datePost`, `topic_id`, `user_id`) VALUES
	(1, 'La nouvelle mise à jour 2.0 de Dofus est enfin sortie !', '2023-08-31 16:14:10', 1, 1),
	(2, 'Je suis bloqué dans le donjon X, quelqu\'un peut m\'aider ?', '2023-08-30 16:14:28', 2, 2),
	(3, 'Je recherche une guilde sympathique pour jouer en équipe !', '2023-08-31 15:14:47', 3, 3);
-- Listage de la structure de table forum-v2. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `topicName` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `topicDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`id_topic`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`) ON DELETE CASCADE,
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum-v2.topic : ~13 rows (environ)
INSERT INTO `topic` (`id_topic`, `topicName`, `topicDate`, `locked`, `user_id`, `category_id`) VALUES
	(1, 'Nouvelle mise à jour 2.0 !', '2023-08-31 11:25:26', 0, 1, 1),
	(2, 'Besoin d\'aide pour un donjon', '2023-08-15 13:47:13', 0, 2, 2),
	(3, 'Recherche de guilde', '2023-08-10 13:56:49', 0, 3, 1);

-- Listage de la structure de table forum-v2. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `registrationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pseudo` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `role` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ban` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum-v2.user : ~8 rows (environ)
INSERT INTO `user` (`id_user`, `registrationDate`, `pseudo`, `password`, `role`, `email`, `ban`) VALUES
	(1, '2023-08-20 11:26:40', 'Joueur1', '123456789', 'joueur', 'joueur1@example.com',0),
	(2, '2023-08-14 13:47:36', 'Joueur2', '123456789', 'joueur', 'joueur2@example.com',0),
	(3, '2023-08-10 13:57:24', 'Administrateur1', '123456789', '["ROLE_ADMIN"]', 'admin1@example.com',0),
	(6, '2023-09-12 14:24:08', 'ytkyk', '$2y$10$uYB7VyLg9Twxw74TrB7d/e011AbGtSwX2tkRMU/fJtwDc85S8qQZq', NULL, 'rayanraihani9@gmail.com',0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;