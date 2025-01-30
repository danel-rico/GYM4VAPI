-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para 4vgymapi
CREATE DATABASE IF NOT EXISTS `4vgymapi` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `4vgymapi`;

-- Volcando estructura para tabla 4vgymapi.activity
CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_type_id` int(11) NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AC74095AC51EFA73` (`activity_type_id`),
  CONSTRAINT `FK_AC74095AC51EFA73` FOREIGN KEY (`activity_type_id`) REFERENCES `activity_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla 4vgymapi.activity: ~3 rows (aproximadamente)
REPLACE INTO `activity` (`id`, `activity_type_id`, `date_start`, `date_end`) VALUES
	(1, 1, '2025-02-10 09:00:00', '2025-02-10 10:30:00'),
	(2, 2, '2025-02-10 13:30:00', '2025-02-10 15:00:00'),
	(3, 3, '2025-02-10 17:30:00', '2025-02-10 19:00:00');

-- Volcando estructura para tabla 4vgymapi.activity_monitor
CREATE TABLE IF NOT EXISTS `activity_monitor` (
  `activity_id` int(11) NOT NULL,
  `monitor_id` int(11) NOT NULL,
  PRIMARY KEY (`activity_id`,`monitor_id`),
  KEY `IDX_E147EF6581C06096` (`activity_id`),
  KEY `IDX_E147EF654CE1C902` (`monitor_id`),
  CONSTRAINT `FK_E147EF654CE1C902` FOREIGN KEY (`monitor_id`) REFERENCES `monitor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_E147EF6581C06096` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla 4vgymapi.activity_monitor: ~3 rows (aproximadamente)
REPLACE INTO `activity_monitor` (`activity_id`, `monitor_id`) VALUES
	(1, 1),
	(2, 2),
	(3, 3);

-- Volcando estructura para tabla 4vgymapi.activity_type
CREATE TABLE IF NOT EXISTS `activity_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `number_monitors` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla 4vgymapi.activity_type: ~3 rows (aproximadamente)
REPLACE INTO `activity_type` (`id`, `name`, `number_monitors`) VALUES
	(1, 'Yoga', 1),
	(2, 'BodyPump', 2),
	(3, 'Pilates', 1);

-- Volcando estructura para tabla 4vgymapi.doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla 4vgymapi.doctrine_migration_versions: ~1 rows (aproximadamente)
REPLACE INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20250129200101', '2025-01-30 07:20:21', 297);

-- Volcando estructura para tabla 4vgymapi.messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla 4vgymapi.messenger_messages: ~0 rows (aproximadamente)

-- Volcando estructura para tabla 4vgymapi.monitor
CREATE TABLE IF NOT EXISTS `monitor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla 4vgymapi.monitor: ~3 rows (aproximadamente)
REPLACE INTO `monitor` (`id`, `name`, `email`, `phone`, `photo`) VALUES
	(1, 'John Doe', 'john@example.com', '123456789', 'http://photo.com/john'),
	(2, 'Jane Doe', 'jane@example.com', '987654321', 'http://photo.com/jane'),
	(3, 'Mike Smith', 'mike@example.com', '555555555', 'http://photo.com/mike');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
