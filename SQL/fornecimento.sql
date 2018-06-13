-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Servidor: mysql09-farm51.kinghost.net
-- Tempo de Geração: Jun 09, 2018 as 05:50 PM
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
-- Estrutura da tabela `fornecimento`
--

CREATE TABLE IF NOT EXISTS `fornecimento` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tx_descricao` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tx_tipo` varchar(31) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=38 ;

--
-- Extraindo dados da tabela `fornecimento`
--

INSERT INTO `fornecimento` (`id`, `tx_descricao`, `tx_tipo`, `id_categoria`) VALUES
(1, 'REVISÃO DO PROJETO EXECUTIVO', 'VB', 1),
(2, 'ELABORAÇÃO DO PROJETO DE FABRICAÇÃO', 'VB', 1),
(3, 'ISOMETRIA DO SISTEMA', 'VB', 1),
(4, 'INTEGRAÇÃO', 'VB', 2),
(5, 'MOBILIZAÇÃO', 'VB', 2),
(6, 'CONTAINER DEPÓSITO/ESCRITÓRIO', 'VB', 2),
(7, 'ANDAIMES', 'VB', 2),
(8, 'FRETES', 'VB', 2),
(9, 'PIPESHOP - ELÉTRICA', 'VB', 3),
(10, 'PIPESHOP - HIDRAULICA', 'VB', 3),
(11, 'PIPESHOP - FERRAMENTARIA', 'VB', 3),
(12, 'PREPARAÇÃO DOS SUPORTES', 'VB', 3),
(13, 'PREPARAÇÃO E PINTURA', 'VB', 3),
(14, 'PREPARAÇÃO DOS SUPORTES', 'VB', 3),
(15, 'PRÉ FABRICAÇÃO - SPOOL Ø1', 'PÇ', 4),
(16, 'FABRICAÇÃO DOS SUPORTES', 'PÇ', 4),
(17, 'INSTALAÇÃO DOS SUPORTES', 'PÇ', 5),
(18, 'INSTALAÇÃO DOS RAMAIS (SPOOL)', 'PÇ', 5),
(19, 'INSTALAÇÃO DAS DESCIDAS', 'PÇ', 5),
(20, 'INSTALAÇÃO TUBULÇÃO', 'PÇ', 5),
(21, 'INSTALAÇÃO DOS HIDRANTES', 'PÇ', 5),
(22, 'INSTALAÇÃO DA INFRA SECA', 'PÇ', 5),
(23, 'PASSAGEM DE FIOS & CABOS', 'PÇ', 5),
(24, 'INSTALAÇÃO DOS SUPORTES', 'PÇ', 5),
(25, 'INSTALAÇÃO SPOOL', 'PÇ', 5),
(26, 'INSTALAÇÃO DOS SPOOL (1.1/2 à 2")', 'PÇ', 5),
(27, 'MANIFOLD 10" COM 02 SAÍDAS (8" e 4")', 'PÇ', 5),
(28, 'CONEXÃO DE DRENO', 'CJ', 5),
(29, 'CONEXÃO DE TESTE', 'PÇ', 5),
(30, 'INSTALAÇÃO DOS SPRINKLERS', 'PÇ', 5),
(31, 'INSTALAÇÃO - FSP-851', 'PÇ', 5),
(32, 'INSTALAÇÃO - FST-851R', 'PÇ', 5),
(33, 'INSTALAÇÃO - P2R-PG', 'PÇ', 5),
(34, 'INSTALAÇÃO - FCM-1', 'PÇ', 5),
(35, 'INSTALAÇÃO - FMM-1', 'PÇ', 5),
(36, 'INSTALAÇÃO - FCPS-24S8', 'PÇ', 5),
(37, 'ALARME - PROGRAMAÇÃO E START-UP', 'VB', 7);
