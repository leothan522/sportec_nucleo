-- --------------------------------------------------------
-- Host:                         92.205.26.108
-- Versión del servidor:         11.4.5-MariaDB-ubu2404 - mariadb.org binary distribution
-- SO del servidor:              debian-linux-gnu
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para morrosroot_sportec_nucleo
CREATE DATABASE IF NOT EXISTS `morrosroot_sportec_nucleo` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci */;
USE `morrosroot_sportec_nucleo`;

-- Volcando estructura para tabla morrosroot_sportec_nucleo.color
CREATE TABLE IF NOT EXISTS `color` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `color` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla morrosroot_sportec_nucleo.color: ~6 rows (aproximadamente)
INSERT INTO `color` (`id`, `color`, `created_at`, `updated_at`) VALUES
	(0, 'Sin definir', '2025-05-20 22:14:32', '2025-05-20 22:14:32'),
	(1, 'Blanco', '2025-05-20 22:14:32', '2025-05-20 22:14:32'),
	(2, 'Rojo', '2025-05-20 22:14:32', '2025-05-20 22:14:32'),
	(3, 'Azul Rey', '2025-05-20 22:14:32', '2025-05-20 22:14:32'),
	(4, 'Verde', '2025-05-20 22:14:32', '2025-05-20 22:14:32'),
	(5, 'Negro', '2025-05-20 22:14:32', '2025-05-20 22:14:32');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
