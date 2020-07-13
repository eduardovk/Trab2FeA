-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.11-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              10.3.0.5771
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para trab2fea
CREATE DATABASE IF NOT EXISTS `trab2fea` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `trab2fea`;

-- Copiando estrutura para tabela trab2fea.categorias_ingressos
CREATE TABLE IF NOT EXISTS `categorias_ingressos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_evento` int(11) NOT NULL,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `qtd` int(11) NOT NULL,
  `ativo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela trab2fea.categorias_ingressos: ~8 rows (aproximadamente)
/*!40000 ALTER TABLE `categorias_ingressos` DISABLE KEYS */;
INSERT INTO `categorias_ingressos` (`id`, `id_evento`, `titulo`, `valor`, `qtd`, `ativo`) VALUES
	(1, 1, 'Ingresso Inteira', 100.00, 100, 1),
	(2, 1, 'Ingresso Meia', 50.00, 60, 1),
	(3, 1, 'Ingresso Associados', 40.00, 30, 1),
	(4, 2, 'Entrada Público', 25.00, 20, 1),
	(5, 2, 'Entrada Alunos SENAC', 10.00, 50, 1),
	(6, 8, 'Ingresso Inteira', 150.00, 100, 1),
	(7, 8, 'Ingresso Meia', 75.00, 100, 1),
	(8, 8, 'Ingresso Alunos SENAC', 55.00, 100, 1);
/*!40000 ALTER TABLE `categorias_ingressos` ENABLE KEYS */;

-- Copiando estrutura para tabela trab2fea.eventos
CREATE TABLE IF NOT EXISTS `eventos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data_hora` datetime NOT NULL,
  `local` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_amiga` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `ativo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela trab2fea.eventos: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `eventos` DISABLE KEYS */;
INSERT INTO `eventos` (`id`, `titulo`, `descricao`, `data_hora`, `local`, `imagem`, `url_amiga`, `id_usuario`, `ativo`) VALUES
	(1, 'Palestra sobre Frameworks e APIs', 'Esta palestra irá abordar diversos tipos de Frameworks, tanto back-end como front-end. VueJS, Bootstrap, Slim Framework, Code Igniter e muito mais.', '2020-07-20 18:00:00', 'Auditório SENAC', '1.jpg', 'palestra-sobre-frameworks-e-apis', 1, 1),
	(2, 'Workshop - Desenvolvimento Web em 2020', 'Neste workshop serão abordadas as tecnologias mais promissoras de 2020 para o desenvolvimento web.', '2020-08-01 09:30:00', 'Sala 101 - Faculdade SENAC POA', '2.jpg', 'workshop-desenvolvimento-web-em-2020', 1, 1),
	(8, 'PHP Conference RS 2020', 'Em sua 15ª Edição a PHP Conference Brasil será um evento 100% online e ao vivo, via Google Meet.', '2020-10-12 11:00:00', 'Online (Website PHP Conference)', '3.jpg', 'php-conference-rs-2020', 1, 1);
/*!40000 ALTER TABLE `eventos` ENABLE KEYS */;

-- Copiando estrutura para tabela trab2fea.inscricoes
CREATE TABLE IF NOT EXISTS `inscricoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_ingresso` int(11) NOT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pago` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela trab2fea.inscricoes: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `inscricoes` DISABLE KEYS */;
/*!40000 ALTER TABLE `inscricoes` ENABLE KEYS */;

-- Copiando estrutura para tabela trab2fea.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fb_ID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cpf` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `senha` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela trab2fea.usuarios: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
