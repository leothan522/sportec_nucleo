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

-- Volcando datos para la tabla morrosroot_sportec_nucleo.users: ~32 rows (aproximadamente)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `id_entidad`, `id_nivel`, `activo`, `visitas`, `descripcion`, `telefono`, `created_at`, `updated_at`) VALUES
	(0, 'Comité Organizador', 'carloswcastillo@gmail.com', NULL, 'Fede%483', NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, 1, 0, 'Comité Organizador', '04129625446', '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(1, 'CLUB SOCIAL ITALO VENEZOLANO ACARIGUA', 'civ1@gmail.com', NULL, 'Acari257%', NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, 1, 0, 'Acarigua', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(2, 'CENTRO ITALO VENEZOLANO DE ORIENTE EN BARCELONA', 'civ2@gmail.com', NULL, 'Barce%241', NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 0, 'Barcelona', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(3, 'CLUB ITALO VENEZOLANO DE BARINAS', 'civ3@gmail.com', NULL, 'Barin%537', NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, 1, 0, 'Barinas', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(4, 'ASOCIACION FRATERNA ITALO VENEZOLANO DEL ESTADO LARA (AFIVEL)', 'civ4@gmail.com', NULL, 'Barqu%992', NULL, NULL, NULL, NULL, NULL, NULL, 4, 2, 1, 0, 'Barquisimeto', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(5, 'CLUB ITALO DE CABIMAS', 'civ5@gmail.com', NULL, 'Cabim345%', NULL, NULL, NULL, NULL, NULL, NULL, 5, 2, 1, 0, 'Cabimas', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(6, 'CENTRO ITALO VENEZOLANO AGUSTIN CODAZZI CAGUA', 'civ6@gmail.com', NULL, 'Cagua%345', NULL, NULL, NULL, NULL, NULL, NULL, 6, 2, 1, 0, 'Cagua', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(7, 'CLUB SOCIAL ITALIANO DE CALABOZO', 'civ7@gmail.com', NULL, '%327Calab', NULL, NULL, NULL, NULL, NULL, NULL, 7, 2, 1, 0, 'Calabozo', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(8, 'CASA D\'ITALIA CIUDAD BOLIVAR', 'civ8@gmail.com', NULL, 'Boliv5%43', NULL, NULL, NULL, NULL, NULL, NULL, 8, 2, 1, 0, 'Ciudad Bolívar', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(9, 'CENTRO ITALIANO VENEZOLANO DE CARACAS', 'civ9@gmail.com', NULL, 'Carac%967', NULL, NULL, NULL, NULL, NULL, NULL, 9, 2, 1, 0, 'Caracas', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(10, 'CENTRO ITALO VENEZOLANO DE CORO', 'civ29@gmail.com', NULL, 'Corox%395', NULL, NULL, NULL, NULL, NULL, NULL, 10, 2, 1, 0, 'Coro', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(11, 'CENTRO ITALO VENEZOLANO DE CARUPANO', 'civ30@gmail.com', NULL, 'Carup236%', NULL, NULL, NULL, NULL, NULL, NULL, 11, 2, 1, 0, 'Carúpano', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(12, 'CENTRO ITALO VENEZOLANO EL TIGRE', 'civ28@gmail.com', NULL, 'Tigre43%2', NULL, NULL, NULL, NULL, NULL, NULL, 12, 2, 1, 0, 'El Tigre', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(13, 'CENTRO SOCIAL ITALO VENEZOLANO DE GUANARE', 'civ27@gmail.com', NULL, 'Gua983%na', NULL, NULL, NULL, NULL, NULL, NULL, 13, 2, 1, 0, 'Guanare', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(14, 'CASA D\'ITALIA DE LOS TEQUES', 'civ25@gmail.com', NULL, 'Teque6%38', NULL, NULL, NULL, NULL, NULL, NULL, 14, 2, 1, 0, 'Los Teques', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(15, 'CASA D\'ITALIA DE MARACAIBO', 'civ26@gmail.com', NULL, 'Mar349%bo', NULL, NULL, NULL, NULL, NULL, NULL, 15, 2, 1, 0, 'Maracaibo', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(16, 'CASA DE ITALIA DE MARACAY', 'civ24@gmail.com', NULL, '%Mar234ay', NULL, NULL, NULL, NULL, NULL, NULL, 16, 2, 1, 0, 'Maracay', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(17, 'CENTRO SOCIAL ITALO VENEZOLANO DE MÉRIDA', 'civ22@gmail.com', NULL, 'Mer658%id', NULL, NULL, NULL, NULL, NULL, NULL, 17, 2, 1, 0, 'Mérida', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(18, 'CENTRO ITALO VENEZOLANO DE MARGARITA', 'civ23@gmail.com', NULL, 'Marga519%', NULL, NULL, NULL, NULL, NULL, NULL, 18, 2, 1, 0, 'Margarita', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(19, 'CENTRO ITALO VENEZOLANO DE CIUDAD GUAYANA EN PUERTO ORDAZ', 'civ10@gmail.com', NULL, 'Ord473%az', NULL, NULL, NULL, NULL, NULL, NULL, 19, 2, 1, 0, 'Puerto Ordaz', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(20, 'CENTRO SOCIAL ITALO VENEZOLANO DE PUERTO CABELLO', 'civ11@gmail.com', NULL, '%297Cabel', NULL, NULL, NULL, NULL, NULL, NULL, 20, 2, 1, 0, 'Puerto Cabello', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(21, 'CENTRO ITALO VENEZOLANO DEL TACHIRA', 'civ12@gmail.com', NULL, 'Tachi%915', NULL, NULL, NULL, NULL, NULL, NULL, 21, 2, 1, 0, 'Táchira', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(22, 'CASA D\'ITALIA DE PARAGUANA EN PUNTO FIJO', 'civ13@gmail.com', NULL, 'Punto318%', NULL, NULL, NULL, NULL, NULL, NULL, 22, 2, 1, 0, 'Punto Fijo', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(23, 'CLUB CAMPESTRE ITALO VENEZOLANO DE SAN FERNANDO DE APURE', 'civ14@gmail.com', NULL, 'Apu392%re', NULL, NULL, NULL, NULL, NULL, NULL, 23, 2, 1, 0, 'San Fernando', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(24, 'CENTRO ITALO VENEZOLANO SAN JUAN DE LOS MORROS', 'civ15@gmail.com', NULL, 'Sanju%920', NULL, NULL, NULL, NULL, NULL, NULL, 24, 2, 1, 0, 'San Juan de los Morros', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(25, 'CENTRO SOCIAL ITALO VENEZOLANO DE SAN FELIPE', 'civ16@gmail.com', NULL, 'Fel%040ip', NULL, NULL, NULL, NULL, NULL, NULL, 25, 2, 1, 0, 'San Felipe', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(26, 'CENTRO SOCAL ITALO VENEZOLANO DE VALENCIA', 'civ21@gmail.com', NULL, 'Valen825%', NULL, NULL, NULL, NULL, NULL, NULL, 26, 2, 1, 0, 'Valencia', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(27, 'CENTRO ITALO VENEZOLANO DE VALLE DE LA PASCUA', 'civ20@gmail.com', NULL, '%419Valle', NULL, NULL, NULL, NULL, NULL, NULL, 27, 2, 1, 0, 'Valle de la Pascua', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(28, 'CLUB DEPORTIVO ITALVEN VALERA', 'civ18@gmail.com', NULL, '%273Valer', NULL, NULL, NULL, NULL, NULL, NULL, 28, 2, 1, 0, 'Valera', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(29, 'CENTRO ITALO VENEZOLANO CIUDAD OJEDA', 'civ19@gmail.com', NULL, 'Ojeda%872', NULL, NULL, NULL, NULL, NULL, NULL, 29, 2, 1, 0, 'Ciudad Ojeda', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(30, 'CLUB ITALO VENEZOLANO UPATA', 'civ17@gmail.com', NULL, 'Upata%710', NULL, NULL, NULL, NULL, NULL, NULL, 30, 2, 1, 0, 'Upata', NULL, '2025-05-18 17:23:17', '2025-05-18 17:23:17'),
	(31, 'Yonathan Castillo', 'leothan522@gmail.com', '2025-05-18 23:05:17', '$2y$12$ljbEkVQpl7CE0ez3vUCDg.lspX9FGl2LtWtt3ZQEyRa/wH53LS3o.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-18 23:04:28', '2025-05-18 23:04:28');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
