-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Servidor: mysql09-farm51.kinghost.net
-- Tempo de Geração: Jun 09, 2018 as 05:48 PM
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
-- Estrutura da tabela `atividade`
--

CREATE TABLE IF NOT EXISTS `atividade` (
  `id_atividade` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tx_descricao` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tx_tipo` varchar(63) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nb_qtd` int(11) DEFAULT NULL,
  `nb_valor` double(8,2) DEFAULT NULL,
  `dt_atividate` date DEFAULT NULL,
  `nb_dias` int(11) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL DEFAULT '0',
  `id_pedido` int(11) NOT NULL,
  `cs_finalizada` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_atividade`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=347 ;

--
-- Extraindo dados da tabela `atividade`
--

INSERT INTO `atividade` (`id_atividade`, `tx_descricao`, `tx_tipo`, `id_categoria`, `nb_qtd`, `nb_valor`, `dt_atividate`, `nb_dias`, `id_pedido`, `cs_finalizada`) VALUES
(1, 'REVISÃO DO PROJETO EXECUTIVO', 'VB', 1, 100, 10000, 01-10-2018, 20, 1, 0),
(2, 'ELABORAÇÃO DO PROJETO DE FABRICAÇÃO', 'VB', 1, 100, 10000, 01-10-2018, 20, 1, 0),
(3, 'ISOMETRIA DO SISTEMA', 'VB', 1, 100, 10000, 01-10-2018, 20, 1, 0),
(4, 'INTEGRAÇÃO', 'VB', 2, 100, 10000, 01-10-2018, 20, 2, 0),
(5, 'MOBILIZAÇÃO', 'VB', 2, 100, 10000, 01-10-2018, 20, 2, 0),
(6, 'CONTAINER DEPÓSITO/ESCRITÓRIO', 'VB', 2, 100, 10000, 01-10-2018, 20, 2, 0),
(7, 'ANDAIMES', 'VB', 2, 100, 10000, 01-10-2018, 20, 2, 0),
(8, 'FRETES', 'VB', 2, 100, 10000, 01-10-2018, 20, 2, 0),
(9, 'PIPESHOP - ELÉTRICA', 'VB', 3, 100, 10000, 01-10-2018, 20, 2, 0),
(10, 'PIPESHOP - HIDRAULICA', 'VB', 3, 100, 10000, 01-10-2018, 20, 3, 0),
(11, 'PIPESHOP - FERRAMENTARIA', 'VB', 3, 100, 10000, 01-10-2018, 20, 3, 0),
(12, 'PREPARAÇÃO DOS SUPORTES', 'VB', 3, 100, 10000, 01-10-2018, 20, 3, 0),
(13, 'PREPARAÇÃO E PINTURA', 'VB', 3, 100, 10000, 01-10-2018, 20, 3, 0),
(14, 'PREPARAÇÃO DOS SUPORTES', 'VB', 3, 100, 10000, 01-10-2018, 20, 4, 0),
(15, 'PRÉ FABRICAÇÃO - SPOOL Ø1', 'PÇ', 4, 100, 10000, 01-10-2018, 20, 4, 0),
(16, 'FABRICAÇÃO DOS SUPORTES', 'PÇ', 4, 100, 10000, 01-10-2018, 20, 4, 0),
(17, 'INSTALAÇÃO DOS SUPORTES', 'PÇ', 5, 100, 10000, 01-10-2018, 20, 4, 0),
(18, 'INSTALAÇÃO DOS RAMAIS (SPOOL)', 'PÇ', 5, 100, 10000, 01-10-2018, 20, 4, 0),
(19, 'INSTALAÇÃO DAS DESCIDAS', 'PÇ', 5, 100, 10000, 01-10-2018, 20, 5, 0),
(20, 'INSTALAÇÃO TUBULÇÃO', 'PÇ', 5, 100, 10000, 01-10-2018, 20, 5, 0),
(21, 'INSTALAÇÃO DOS HIDRANTES', 'PÇ', 5, 100, 10000, 01-10-2018, 20, 5, 0),
(22, 'INSTALAÇÃO DA INFRA SECA', 'PÇ', 5, 100, 10000, 01-10-2018, 20, 1, 0),
(23, 'PASSAGEM DE FIOS & CABOS', 'PÇ', 5, 100, 10000, 01-10-2018, 20, 2, 0),
(24, 'INSTALAÇÃO DOS SUPORTES', 'PÇ', 5, 100, 10000, 01-10-2018, 20, 3, 0),
(25, 'INSTALAÇÃO SPOOL', 'PÇ', 5, 100, 10000, 01-10-2018, 20, 4, 0),
(26, 'INSTALAÇÃO DOS SPOOL (1.1/2 à 2")', 'PÇ', 5, 100, 10000, 01-10-2018, 20, 5, 0),
(27, 'MANIFOLD 10" COM 02 SAÍDAS (8" e 4")', 'PÇ', 5, 100, 10000, 01-10-2018, 20, 6, 0),
(28, 'CONEXÃO DE DRENO', 'CJ', 5, 100, 10000, 01-10-2018, 20, 7, 0),
(29, 'CONEXÃO DE TESTE', 'PÇ', 5, 100, 10000, 01-10-2018, 20, 8, 0),
(30, 'INSTALAÇÃO DOS SPRINKLERS', 'PÇ', 5, 100, 10000, 01-10-2018, 20, 7, 0),
(31, 'INSTALAÇÃO - FSP-851', 'PÇ', 5, 100, 10000, 01-10-2018, 20, 1, 0),
(32, 'INSTALAÇÃO - FST-851R', 'PÇ', 5, 100, 10000, 01-10-2018, 20, 2, 0),
(33, 'INSTALAÇÃO - P2R-PG', 'PÇ', 5, 100, 10000, 01-10-2018, 20, 3, 0),
(34, 'INSTALAÇÃO - FCM-1', 'PÇ', 5, 100, 10000, 01-10-2018, 20, 4, 0),
(35, 'INSTALAÇÃO - FMM-1', 'PÇ', 5, 100, 10000, 01-10-2018, 20, 5, 0),
(36, 'INSTALAÇÃO - FCPS-24S8', 'PÇ', 5, 100, 10000, 01-10-2018, 20, 6, 0),
(37, 'ALARME - PROGRAMAÇÃO E START-UP', 'VB', 7, 100, 10000, 01-10-2018, 20, 1, 0),
(38, 'ALARME - PROGRAMAÇÃO E START-UP', 'VB', 7, 100, 10000, 01-10-2018, 20, 2, 0),
(39, 'ALARME - PROGRAMAÇÃO E START-UP', 'VB', 7, 100, 10000, 01-10-2018, 20, 3, 0),
(40, 'ALARME - PROGRAMAÇÃO E START-UP', 'VB', 7, 100, 10000, 01-10-2018, 20, 4, 0);