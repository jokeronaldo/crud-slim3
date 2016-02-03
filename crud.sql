-- --------------------------------------------------------
-- Servidor:                     localhost
-- Versão do servidor:           5.6.17 - MySQL Community Server (GPL)
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura do banco de dados para crud
CREATE DATABASE IF NOT EXISTS `crud` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `crud`;


-- Copiando estrutura para tabela crud.clubes
CREATE TABLE IF NOT EXISTS `clubes` (
  `clb_id` int(11) NOT NULL AUTO_INCREMENT,
  `clb_nome` varchar(40) DEFAULT NULL,
  `clb_created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `clb_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`clb_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COMMENT='Tabela de clubes';

-- Copiando dados para a tabela crud.clubes: ~8 rows (aproximadamente)
DELETE FROM `clubes`;
/*!40000 ALTER TABLE `clubes` DISABLE KEYS */;
INSERT INTO `clubes` (`clb_id`, `clb_nome`, `clb_created_at`, `clb_updated_at`) VALUES
	(1, 'XV de Novembro', '2016-02-02 10:01:55', NULL),
	(2, 'Marcílio Dias', '2016-02-02 16:28:58', '2016-02-02 16:28:58'),
	(3, 'Vasco', '2016-02-02 16:53:50', '2016-02-02 16:53:50'),
	(4, 'Botafogo', '2016-02-02 16:54:30', '2016-02-02 16:54:30'),
	(5, 'Flamengo', '2016-02-02 17:12:45', '2016-02-02 18:24:31'),
	(6, 'Avaí', '2016-02-02 17:12:48', '2016-02-02 18:40:27'),
	(7, 'Fluminense', '2016-02-02 17:12:49', '2016-02-02 18:40:37'),
	(9, 'Grêmio', '2016-02-02 18:29:35', '2016-02-02 18:29:35');
/*!40000 ALTER TABLE `clubes` ENABLE KEYS */;


-- Copiando estrutura para tabela crud.planos
CREATE TABLE IF NOT EXISTS `planos` (
  `pln_id` int(11) NOT NULL AUTO_INCREMENT,
  `pln_nome` varchar(40) NOT NULL,
  `pln_created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `pln_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`pln_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Tabela de planos';

-- Copiando dados para a tabela crud.planos: ~2 rows (aproximadamente)
DELETE FROM `planos`;
/*!40000 ALTER TABLE `planos` DISABLE KEYS */;
INSERT INTO `planos` (`pln_id`, `pln_nome`, `pln_created_at`, `pln_updated_at`) VALUES
	(1, 'Master', '2016-02-02 10:02:06', NULL),
	(2, 'Premium', '2016-02-02 10:02:12', NULL);
/*!40000 ALTER TABLE `planos` ENABLE KEYS */;


-- Copiando estrutura para tabela crud.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `usu_id` int(11) NOT NULL AUTO_INCREMENT,
  `usu_nome` varchar(20) NOT NULL,
  `usu_sobrenome` varchar(20) NOT NULL,
  `usu_cpf` varchar(11) NOT NULL,
  `usu_telefone` varchar(20) DEFAULT NULL,
  `usu_email` varchar(50) NOT NULL,
  `usu_nascimento` date DEFAULT NULL,
  `usu_endereco` varchar(255) DEFAULT NULL,
  `usu_clube` int(11) NOT NULL COMMENT 'clb_id',
  `usu_plano` int(11) NOT NULL,
  `usu_titular` int(11) DEFAULT NULL COMMENT 'usu_id FK',
  `usu_created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `usu_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`usu_id`),
  UNIQUE KEY `usu_email` (`usu_email`),
  UNIQUE KEY `usu_cpf` (`usu_cpf`),
  KEY `FK_usuarios_usuarios` (`usu_titular`),
  KEY `FK_usuarios_clubes` (`usu_clube`),
  KEY `FK_usuarios_planos` (`usu_plano`),
  CONSTRAINT `FK_usuarios_planos` FOREIGN KEY (`usu_plano`) REFERENCES `planos` (`pln_id`),
  CONSTRAINT `FK_usuarios_clubes` FOREIGN KEY (`usu_clube`) REFERENCES `clubes` (`clb_id`),
  CONSTRAINT `FK_usuarios_usuarios` FOREIGN KEY (`usu_titular`) REFERENCES `usuarios` (`usu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='Tabela de usuários';

-- Copiando dados para a tabela crud.usuarios: ~2 rows (aproximadamente)
DELETE FROM `usuarios`;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`usu_id`, `usu_nome`, `usu_sobrenome`, `usu_cpf`, `usu_telefone`, `usu_email`, `usu_nascimento`, `usu_endereco`, `usu_clube`, `usu_plano`, `usu_titular`, `usu_created_at`, `usu_updated_at`) VALUES
	(4, 'Ronaldo', 'Moreira Junior', '05401293992', '4799833271', 'elj0k3r@gmail.com', '1984-03-31', 'Rua Bernardino João Vitorino, 52, Centro, Itajaí', 1, 1, NULL, '2016-02-02 10:03:07', NULL),
	(5, 'João', 'Silva', '05501393985', '4733445566', 'joao@silva.com', '0000-00-00', 'Rua Próspera, 30, Centro', 1, 2, 4, '2016-02-02 13:05:44', NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
