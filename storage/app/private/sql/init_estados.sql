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

-- Volcando datos para la tabla morrosroot_sportec_nucleo.estados: ~31 rows (aproximadamente)
INSERT INTO `estados` (`id`, `codigoe`, `nombre`, `short_nombre`, `capital`, `ruta_bandera`, `ruta_escudo`, `activo`, `created_at`, `updated_at`) VALUES
	(0, 'VEN', 'JUNTA DIRECTIVA FEDECIV', '', '-', '', '', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(1, 'ACA', 'CLUB SOCIAL ITALO VENEZOLANO ACARIGUA', '', '', '.PaisesBEN.gif', '.PaisesBEN.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(2, 'BRC', 'CENTRO ITALO VENEZOLANO DE ORIENTE EN BARCELONA', '', '', '.PaisesAFG.gif', '.PaisesAFG.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(3, 'BRN', 'CLUB ITALO VENEZOLANO DE BARINAS', '', '', '.PaisesAHO.gif', '.PaisesAHO.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(4, 'BTO', 'ASOCIACION FRATERNA ITALO VENEZOLANO DEL ESTADO LARA (AFIVEL)', '', '', '.PaisesAIA.gif', '.PaisesAIA.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(5, 'CAB', 'CLUB ITALO DE CABIMAS', '', '', '.PaisesALB.gif', '.PaisesALB.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(6, 'CAG', 'CENTRO ITALO VENEZOLANO AGUSTIN CODAZZI CAGUA', '', '', '.PaisesALB.gif', '.PaisesALB.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(7, 'CAL', 'CLUB SOCIAL ITALIANO DE CALABOZO', '', '', '.PaisesALB.gif', '.PaisesALB.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(8, 'CBO', 'CASA D\'ITALIA CIUDAD BOLIVAR', '', '', '.PaisesALB.gif', '.PaisesALB.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(9, 'CCS', 'CENTRO ITALIANO VENEZOLANO DE CARACAS', '', '', '.PaisesALB.gif', '.PaisesALB.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(10, 'COR', 'CENTRO ITALO VENEZOLANO DE CORO', '', '', '.PaisesALB.gif', '.PaisesALB.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(11, 'CRP', 'CENTRO ITALO VENEZOLANO DE CARUPANO', '', '', '.PaisesALB.gif', '.PaisesALB.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(12, 'ETG', 'CENTRO ITALO VENEZOLANO EL TIGRE', '', '', '.PaisesALB.gif', '.PaisesALB.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(13, 'GRE', 'CENTRO SOCIAL ITALO VENEZOLANO DE GUANARE', '', '', '.PaisesANT.gif', '.PaisesANT.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(14, 'LTQ', 'CASA D\'ITALIA DE LOS TEQUES', '', '', '.PaisesARG.gif', '.PaisesARG.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(15, 'MBO', 'CASA D\'ITALIA DE MARACAIBO', '', '', '.PaisesARM.gif', '.PaisesARM.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(16, 'MCY', 'CASA DE ITALIA DE MARACAY', '', '', '.PaisesARU.gif', '.PaisesARU.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(17, 'MER', 'CENTRO SOCIAL ITALO VENEZOLANO DE MÉRIDA', '', '', '.PaisesASA.gif', '.PaisesASA.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(18, 'POR', 'CENTRO ITALO VENEZOLANO DE MARGARITA', '', '', '.PaisesASA.gif', '.PaisesASA.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(19, 'PTO', 'CENTRO ITALO VENEZOLANO DE CIUDAD GUAYANA EN PUERTO ORDAZ', '', '', '.PaisesAUS.gif', '.PaisesAUS.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(20, 'PTC', 'CENTRO SOCIAL ITALO VENEZOLANO DE PUERTO CABELLO', '', '', '.PaisesATF.gif', '.PaisesATF.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(21, 'SCR', 'CENTRO ITALO VENEZOLANO DEL TACHIRA', '', '', '.PaisesAUT.gif', '.PaisesAUT.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(22, 'BEN', 'CASA D\'ITALIA DE PARAGUANA EN PUNTO FIJO', '', '', '.PaisesBEN.gif', '.PaisesBEN.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(23, 'SFN', 'CLUB CAMPESTRE ITALO VENEZOLANO DE SAN FERNANDO DE APURE', '', '', '.PaisesBAH.gif', '.PaisesBAH.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(24, 'SJM', 'CENTRO ITALO VENEZOLANO SAN JUAN DE LOS MORROS', '', '', '.PaisesBEL.gif', '.PaisesBEL.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(25, 'SFL', 'CENTRO DEPORTIVO CULTURAL ITALO VENEZOLANO DE SAN FELIPE', '', '', '.PaisesAZE.gif', '.PaisesAZE.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(26, 'VAL', 'CENTRO SOCAL ITALO VENEZOLANO DE VALENCIA', '', '', '.PaisesBEL.gif', '.PaisesBEL.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(27, 'VLP', 'CENTRO ITALO VENEZOLANO DE VALLE DE LA PASCUA', '', '', '.PaisesBDI.gif', '.PaisesBDI.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(28, 'VLR', 'CLUB DEPORTIVO ITALVEN VALERA', '', '', '.PaisesBAR.gif', '.PaisesBAR.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(29, 'COJ', 'CENTRO ITALO VENEZOLANO CIUDAD OJEDA', '', '', '.PaisesALB.gif', '.PaisesALB.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44'),
	(30, 'UPA', 'CLUB ITALO VENEZOLANO UPATA', '', '', '.PaisesBEL.gif', '.PaisesBEL.gif', 1, '2025-05-18 16:25:44', '2025-05-18 16:25:44');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
