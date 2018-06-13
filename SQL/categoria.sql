-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Servidor: mysql09-farm51.kinghost.net
-- Tempo de Geração: Jun 09, 2018 as 05:47 PM
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
-- Estrutura da tabela `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `id_categoria` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tx_nome` varchar(63) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_categoria`),
  UNIQUE KEY `id_categoria` (`id_categoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `tx_nome`) VALUES
(1, 'Engenharia'),
(2, 'Mobilização'),
(3, 'Preparação'),
(4, 'Pré-Fabricação'),
(5, 'Montagem'),
(6, 'Faturamento Direto'),
(7, 'Comissionamento'),
(8, 'Entrega Técnica');
