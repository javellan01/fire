-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Servidor: mysql09-farm51.kinghost.net
-- Tempo de Geração: Jun 09, 2018 as 05:36 PM
-- Versão do Servidor: 5.6.36
-- Versão do PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `firesystems`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido`
--

CREATE TABLE IF NOT EXISTS `pedido` (
  `id_pedido` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tx_codigo` varchar(63) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tx_descricao` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cs_estado` tinyint(1) NOT NULL DEFAULT '0',
  `id_cliente` int(11) NOT NULL,
  `nb_valor` double(10,2) DEFAULT NULL,
  `nb_retencao` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pedido`),
  UNIQUE KEY `UC_Unique` (`id_cliente`,`tx_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=88 ;

--
-- Extraindo dados da tabela `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `tx_codigo`, `tx_descricao`, `cs_estado`, `id_cliente`, `nb_valor`, `nb_retencao`) VALUES
(1, 'PD9611S', NULL, 0, 1, 100000.00, 5),
(2, 'PN5675', NULL, 0, 2, 100000.00, 10),
(3, 'P-189T', NULL, 0, 3, 100000.00, 5),
(4, 'OC4375', NULL, 0, 4, 100000.00, 5),
(5, 'ONEN28', NULL, 0, 5, 100000.00, 5),
(6, 'NCV9684', NULL, 0, 6, 100000.00, 5),
(7, 'VKE9874', NULL, 1, 7, 100000.00, 5),
(8, 'VKG9234', NULL, 1, 8, 100000.00, 5);