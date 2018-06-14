-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Servidor: mysql09-farm51.kinghost.net
-- Tempo de Geração: Jun 09, 2018 as 06:54 PM
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
-- Estrutura da tabela `atividade_executada`
--

CREATE TABLE IF NOT EXISTS `atividade_executada` (
  `id_usuario` int(11) NOT NULL,
  `id_atividade` int(11) NOT NULL,
  `nb_qtd` int(11) DEFAULT NULL,
  `dt_data` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `atividade_executada`
--

INSERT INTO `atividade_executada` (`id_usuario`, `id_atividade`, `nb_qtd`, `dt_data`) VALUES
(4, 108, 39, '2008-03-17'),
(3, 177, 21, '2018-09-20'),
(4, 225, 10, '2010-02-19'),
(3, 200, 1, '2009-03-24'),
(3, 291, 46, '2010-03-23'),
(1, 8, 1, '2012-07-21'),
(3, 273, 19, '2012-05-13'),
(2, 47, 37, '2012-01-25'),
(4, 18, 5, '2016-02-18'),
(3, 275, 50, '2010-01-09'),
(1, 262, 35, '2018-09-14'),
(1, 159, 42, '2018-06-17'),
(2, 61, 20, '2011-07-12'),
(2, 91, 30, '2009-02-26'),
(2, 228, 39, '2014-03-10'),
(2, 40, 17, '2010-04-28'),
(2, 146, 27, '2009-11-20'),
(2, 223, 14, '2018-05-19'),
(4, 173, 45, '2014-03-03'),
(2, 184, 47, '2016-12-22'),
(2, 232, 41, '2012-12-17'),
(4, 50, 50, '2015-02-20'),
(2, 64, 31, '2010-10-09'),
(1, 223, 16, '2009-01-17'),
(4, 218, 29, '2010-06-22'),
(2, 158, 46, '2017-12-31'),
(4, 16, 45, '2011-07-14'),
(1, 253, 11, '2017-06-07'),
(2, 214, 11, '2009-02-14'),
(1, 112, 50, '2008-06-29'),
(1, 134, 19, '2013-03-24'),
(3, 30, 28, '2015-10-09'),
(2, 195, 42, '2012-04-01'),
(3, 188, 47, '2012-03-23'),
(2, 137, 8, '2015-04-23'),
(2, 229, 31, '2016-02-16'),
(1, 170, 6, '2010-11-17'),
(1, 96, 34, '2011-02-23'),
(4, 141, 16, '2013-11-14'),
(3, 1, 3, '2012-08-07'),
(3, 205, 26, '2009-08-30'),
(2, 177, 14, '2010-09-06'),
(4, 128, 44, '2017-07-02'),
(4, 20, 21, '2015-01-17'),
(1, 240, 42, '2018-09-08'),
(1, 142, 45, '2011-03-21'),
(3, 56, 12, '2014-09-12'),
(1, 172, 35, '2010-08-21'),
(3, 86, 32, '2017-01-24'),
(4, 78, 23, '2010-08-18'),
(2, 230, 31, '2014-02-01'),
(1, 59, 4, '2014-11-07'),
(3, 133, 16, '2016-12-29'),
(2, 82, 39, '2014-08-14'),
(1, 88, 38, '2012-01-04'),
(1, 25, 4, '2009-07-26'),
(4, 7, 27, '2018-09-29'),
(1, 43, 23, '2014-11-09'),
(2, 79, 1, '2015-12-04'),
(3, 118, 9, '2016-09-01'),
(3, 163, 29, '2011-04-13'),
(1, 112, 48, '2017-10-07'),
(1, 227, 6, '2008-09-20'),
(3, 209, 3, '2013-08-26'),
(4, 188, 34, '2016-02-10'),
(4, 25, 10, '2008-01-23'),
(4, 170, 33, '2017-06-27'),
(2, 17, 10, '2017-06-07'),
(1, 212, 12, '2009-03-11'),
(1, 172, 39, '2017-11-30'),
(4, 167, 44, '2012-06-23'),
(1, 240, 13, '2014-09-27'),
(4, 69, 43, '2016-01-16'),
(1, 150, 11, '2008-09-15'),
(3, 253, 28, '2011-12-23'),
(3, 212, 48, '2015-10-02'),
(3, 62, 49, '2016-09-01'),
(4, 33, 43, '2013-02-12'),
(3, 87, 19, '2018-09-19'),
(3, 242, 4, '2013-04-03'),
(4, 285, 15, '2010-10-29'),
(3, 192, 21, '2010-12-03'),
(3, 121, 35, '2014-10-26'),
(1, 200, 17, '2014-08-30'),
(1, 270, 33, '2017-05-27'),
(2, 167, 4, '2017-08-01'),
(3, 76, 3, '2012-06-08'),
(2, 169, 25, '2017-10-31'),
(4, 120, 37, '2011-11-20'),
(3, 195, 35, '2011-02-13'),
(3, 6, 33, '2013-05-07'),
(3, 207, 18, '2014-12-13'),
(1, 96, 38, '2018-03-12'),
(1, 200, 46, '2012-09-04'),
(1, 208, 46, '2010-06-26'),
(1, 103, 45, '2014-04-01'),
(3, 118, 50, '2018-07-27'),
(1, 44, 10, '2015-04-16'),
(4, 240, 23, '2010-01-06'),
(3, 102, 42, '2016-05-07'),
(1, 294, 10, '2011-09-08'),
(3, 189, 5, '2009-11-12'),
(3, 124, 43, '2011-10-29'),
(4, 298, 45, '2017-05-31'),
(3, 252, 4, '2010-01-06'),
(2, 17, 14, '2010-11-25'),
(4, 219, 10, '2012-12-18'),
(2, 83, 6, '2014-10-11'),
(1, 201, 38, '2008-04-27'),
(3, 93, 50, '2010-11-30'),
(3, 147, 43, '2014-12-28'),
(3, 170, 15, '2018-12-08'),
(4, 293, 33, '2012-07-13'),
(3, 76, 25, '2015-06-18'),
(4, 1, 9, '2013-03-04'),
(4, 41, 2, '2010-04-28'),
(2, 175, 50, '2014-09-07'),
(1, 42, 10, '2011-06-08'),
(3, 283, 25, '2008-06-12'),
(2, 5, 19, '2008-10-06'),
(3, 241, 28, '2018-05-22'),
(1, 138, 8, '2017-10-12'),
(4, 211, 6, '2012-01-31'),
(4, 89, 24, '2013-10-13'),
(4, 117, 1, '2011-08-16'),
(2, 228, 38, '2018-09-14'),
(4, 204, 40, '2010-06-20'),
(4, 159, 30, '2010-11-02'),
(2, 203, 44, '2012-06-08'),
(3, 79, 8, '2010-07-27'),
(2, 295, 38, '2017-05-30'),
(2, 23, 36, '2014-12-28'),
(1, 70, 32, '2013-07-16'),
(4, 104, 44, '2018-12-26'),
(2, 181, 34, '2016-08-28'),
(1, 123, 28, '2015-03-18'),
(4, 49, 38, '2017-10-15'),
(4, 242, 4, '2011-07-01'),
(3, 244, 41, '2017-10-04'),
(3, 242, 27, '2012-08-05'),
(1, 264, 12, '2014-08-17'),
(4, 190, 42, '2013-11-14'),
(3, 283, 16, '2012-12-30'),
(2, 84, 50, '2009-08-30'),
(2, 121, 30, '2009-05-01'),
(1, 100, 37, '2011-11-20'),
(2, 224, 45, '0000-00-00'),
(3, 178, 8, '2013-07-21'),
(1, 79, 6, '2016-02-29'),
(1, 6, 7, '2015-10-13'),
(1, 289, 41, '2009-12-01'),
(1, 108, 27, '2016-02-26'),
(4, 259, 3, '2010-11-19'),
(1, 117, 34, '2008-06-21'),
(3, 251, 25, '2017-07-11'),
(3, 42, 3, '2009-06-17'),
(4, 10, 44, '2013-11-04'),
(3, 140, 10, '2015-04-26'),
(3, 251, 45, '2008-07-22'),
(4, 263, 16, '2012-05-08'),
(1, 277, 36, '2008-07-26'),
(4, 271, 31, '2014-08-15'),
(1, 286, 12, '2016-04-03'),
(4, 236, 31, '2014-09-25'),
(2, 128, 25, '2010-04-23'),
(1, 13, 44, '2017-12-21'),
(2, 150, 36, '2011-03-22'),
(2, 250, 9, '2015-02-28'),
(2, 38, 47, '2011-04-06'),
(3, 11, 33, '2013-09-20'),
(4, 297, 35, '2016-03-17'),
(4, 160, 47, '2016-10-22'),
(3, 280, 36, '2014-06-08'),
(4, 286, 26, '2015-06-22'),
(4, 275, 9, '2014-11-28'),
(4, 151, 40, '2018-10-04'),
(1, 192, 25, '2012-01-09'),
(4, 61, 23, '2015-12-25'),
(2, 31, 25, '2015-02-24'),
(1, 12, 28, '2017-08-26'),
(4, 38, 15, '2016-12-04'),
(3, 3, 22, '2012-10-14'),
(2, 267, 27, '2018-11-05'),
(2, 253, 50, '2013-12-07'),
(1, 130, 42, '2010-02-17'),
(4, 299, 20, '2017-11-25'),
(3, 31, 4, '2012-03-09'),
(2, 114, 35, '2009-10-10'),
(4, 14, 26, '0000-00-00'),
(2, 115, 3, '2013-02-21'),
(1, 122, 1, '2010-11-29'),
(4, 67, 39, '2018-08-08'),
(1, 42, 15, '2011-07-13'),
(1, 148, 45, '2013-06-18'),
(3, 68, 14, '2016-06-26'),
(1, 116, 7, '2015-10-29'),
(2, 81, 16, '2009-05-02'),
(4, 223, 26, '2012-07-28'),
(4, 251, 8, '2014-02-06'),
(2, 36, 27, '2015-10-22'),
(3, 227, 19, '2013-05-07'),
(1, 141, 7, '2014-03-11'),
(3, 248, 15, '2011-04-09'),
(3, 287, 45, '2013-09-26'),
(1, 110, 48, '2012-06-20'),
(3, 98, 13, '2018-04-18'),
(1, 199, 49, '2015-01-07'),
(1, 180, 38, '2012-08-12'),
(4, 84, 33, '2013-12-24'),
(1, 180, 18, '2013-10-24'),
(1, 227, 29, '2008-11-19'),
(2, 204, 25, '2013-05-17'),
(4, 135, 39, '2014-02-04'),
(4, 32, 12, '2014-07-26'),
(1, 213, 49, '2017-02-26'),
(3, 117, 4, '2017-02-13'),
(2, 189, 9, '2017-07-26'),
(1, 84, 29, '2008-07-16'),
(1, 97, 14, '2010-10-11'),
(2, 297, 27, '2009-11-17'),
(4, 22, 31, '2008-12-30'),
(4, 300, 20, '2018-07-18'),
(3, 299, 33, '2010-02-12'),
(4, 224, 16, '2008-04-19'),
(1, 169, 19, '2008-02-02'),
(3, 19, 3, '2017-05-23'),
(1, 296, 40, '2014-10-08'),
(1, 296, 16, '2009-10-04'),
(1, 197, 32, '2018-04-27'),
(4, 126, 14, '2017-08-16'),
(4, 22, 44, '2012-02-28'),
(4, 219, 32, '2015-12-24'),
(1, 236, 23, '2014-04-01'),
(3, 299, 3, '2018-12-01'),
(1, 89, 31, '2015-02-23'),
(3, 278, 21, '0000-00-00'),
(1, 212, 32, '2017-10-04'),
(2, 299, 26, '2009-05-04'),
(1, 9, 2, '2015-07-27'),
(4, 55, 12, '2011-10-17'),
(4, 140, 44, '2013-08-21'),
(1, 224, 19, '2011-03-09'),
(3, 148, 30, '2011-08-28'),
(1, 2, 13, '0000-00-00'),
(3, 148, 36, '2010-06-07'),
(3, 252, 1, '2012-09-21'),
(2, 249, 3, '2009-10-12'),
(3, 144, 27, '2017-01-03'),
(2, 220, 42, '2017-03-30'),
(3, 16, 42, '2009-03-31'),
(2, 112, 32, '2012-08-17'),
(3, 222, 23, '2017-09-05'),
(4, 156, 18, '2017-05-23'),
(4, 75, 14, '2014-03-19'),
(2, 39, 10, '2008-01-14'),
(4, 178, 18, '2017-10-14'),
(1, 158, 35, '2017-03-08'),
(3, 85, 39, '2014-05-14'),
(4, 73, 18, '2018-10-20'),
(3, 143, 41, '2010-09-03'),
(3, 29, 36, '2013-12-01'),
(1, 202, 36, '2014-06-23'),
(2, 213, 1, '2018-05-14'),
(3, 83, 8, '2017-08-02'),
(3, 283, 23, '0000-00-00'),
(1, 169, 22, '2016-12-11'),
(4, 86, 9, '2015-08-19'),
(4, 41, 44, '2015-01-08'),
(4, 126, 35, '2014-10-07'),
(3, 7, 21, '2011-04-06'),
(4, 8, 43, '2016-04-20'),
(4, 75, 42, '2009-04-17'),
(4, 141, 47, '2017-12-01'),
(1, 237, 40, '2010-02-19'),
(1, 169, 14, '2014-10-03'),
(2, 239, 34, '2009-04-19'),
(1, 87, 28, '2013-05-13'),
(2, 55, 44, '2018-03-28'),
(2, 69, 28, '2017-03-19'),
(4, 236, 15, '2018-07-23'),
(3, 56, 8, '2016-09-02'),
(4, 50, 45, '2018-01-18'),
(1, 260, 28, '2012-11-25'),
(3, 68, 25, '2013-06-23'),
(2, 167, 31, '2016-12-23'),
(1, 137, 42, '2012-06-17'),
(3, 193, 48, '2014-06-12'),
(3, 232, 4, '2013-01-24'),
(1, 173, 41, '2014-12-16'),
(3, 164, 11, '2017-07-29'),
(3, 29, 18, '2012-01-23'),
(4, 283, 48, '2015-11-06'),
(4, 206, 23, '2012-12-19'),
(1, 42, 45, '2014-01-26'),
(4, 153, 9, '2017-12-23'),
(3, 242, 10, '2015-11-25'),
(1, 19, 23, '2008-07-27'),
(1, 65, 14, '2017-01-22'),
(1, 180, 46, '2008-07-23'),
(1, 181, 12, '2015-10-13'),
(3, 116, 14, '2008-09-13'),
(4, 73, 1, '2016-02-18'),
(1, 261, 32, '2017-03-02'),
(2, 71, 49, '2010-01-15'),
(1, 46, 26, '2009-03-19'),
(1, 235, 44, '2009-10-25'),
(3, 188, 1, '2008-12-08'),
(1, 168, 3, '2010-11-01'),
(1, 82, 20, '2018-02-23'),
(3, 157, 14, '2016-12-04'),
(4, 232, 8, '2014-06-22'),
(3, 76, 33, '2017-04-19'),
(3, 127, 2, '2009-02-15'),
(1, 79, 29, '2010-11-15'),
(1, 1, 50, '2014-06-22'),
(3, 174, 32, '2012-06-20'),
(1, 216, 24, '2011-06-26'),
(4, 136, 9, '2016-11-26'),
(3, 16, 24, '2011-06-25'),
(4, 215, 20, '2015-09-08'),
(3, 90, 20, '2013-05-18'),
(3, 51, 22, '2018-11-07'),
(2, 270, 36, '2017-12-13'),
(4, 64, 40, '2010-08-15'),
(2, 18, 7, '2008-11-07'),
(3, 105, 27, '2015-01-13'),
(1, 257, 1, '2013-10-18'),
(2, 301, 40, '2015-12-07'),
(3, 198, 32, '2018-12-27'),
(2, 85, 16, '2012-07-11'),
(4, 278, 16, '2014-12-11'),
(2, 44, 9, '2012-01-10'),
(1, 261, 23, '2015-04-12'),
(1, 133, 14, '2008-06-11'),
(4, 154, 39, '2012-11-10'),
(1, 112, 38, '2018-04-06'),
(1, 117, 7, '2011-06-13'),
(4, 137, 33, '2009-01-13'),
(2, 66, 41, '2013-04-18'),
(1, 99, 26, '2014-03-26'),
(1, 128, 45, '2014-04-06'),
(2, 294, 19, '2010-08-01'),
(3, 236, 47, '2008-11-06'),
(3, 95, 9, '2017-10-23'),
(2, 78, 16, '2014-12-17'),
(3, 178, 35, '2011-05-13'),
(4, 221, 49, '2012-05-24'),
(3, 282, 37, '2017-11-28'),
(2, 213, 2, '2008-12-07'),
(1, 67, 6, '2018-11-13'),
(1, 267, 46, '2018-12-18'),
(1, 206, 10, '2015-07-01'),
(3, 300, 43, '2014-11-13'),
(1, 291, 50, '2014-12-05'),
(4, 189, 33, '2013-07-02'),
(2, 300, 28, '2011-07-30'),
(2, 65, 44, '2013-11-27'),
(3, 292, 9, '2015-02-10'),
(3, 100, 45, '2016-11-18'),
(2, 271, 38, '2013-08-23'),
(1, 72, 31, '2017-09-21'),
(1, 68, 40, '2016-05-17'),
(2, 113, 13, '2008-04-25'),
(3, 146, 5, '2017-07-13'),
(2, 141, 7, '2010-10-01'),
(3, 237, 46, '2013-04-26'),
(4, 96, 39, '2009-12-11'),
(3, 197, 9, '2010-12-24'),
(2, 150, 9, '2015-07-15'),
(3, 26, 1, '2014-05-10'),
(3, 173, 18, '2013-05-09'),
(1, 267, 12, '2011-03-21'),
(3, 14, 24, '2016-12-25'),
(2, 246, 14, '2016-09-24'),
(1, 294, 45, '2013-01-30'),
(2, 103, 7, '2008-05-08'),
(1, 279, 24, '2010-06-15'),
(1, 4, 21, '2014-02-28'),
(4, 135, 45, '2009-04-04'),
(2, 273, 17, '2009-08-10'),
(4, 24, 7, '2015-01-14'),
(3, 3, 2, '2015-11-22'),
(3, 113, 49, '2010-04-04'),
(1, 285, 50, '2011-07-15'),
(2, 99, 2, '2009-04-23'),
(1, 77, 24, '2009-08-11'),
(1, 65, 8, '0000-00-00'),
(3, 5, 50, '2011-08-02'),
(2, 46, 49, '2010-11-22'),
(4, 66, 15, '2013-01-11'),
(3, 187, 49, '2014-07-26'),
(2, 249, 32, '2008-07-19'),
(4, 271, 18, '2013-09-28'),
(2, 212, 34, '2013-12-22'),
(1, 84, 36, '2016-10-25'),
(1, 199, 23, '2008-02-16'),
(2, 40, 13, '2015-03-04'),
(2, 77, 43, '2017-05-14'),
(4, 264, 49, '2014-06-22'),
(3, 295, 41, '2016-02-20'),
(2, 171, 23, '2017-10-29'),
(3, 259, 33, '2011-01-18'),
(4, 172, 27, '2011-02-02'),
(2, 37, 6, '2008-03-06'),
(4, 274, 3, '2018-01-12'),
(1, 30, 46, '2013-05-26'),
(2, 287, 38, '2010-06-11'),
(3, 43, 5, '2014-08-16'),
(2, 229, 43, '2015-03-02'),
(2, 38, 28, '2015-11-06'),
(1, 63, 44, '2008-04-01'),
(3, 243, 28, '2015-10-28'),
(1, 17, 2, '2017-04-09'),
(2, 12, 42, '2016-10-10'),
(2, 51, 37, '2016-11-28'),
(2, 239, 5, '2013-06-15'),
(3, 225, 40, '2009-09-15'),
(2, 249, 46, '2017-04-20'),
(1, 273, 25, '2014-03-09'),
(1, 122, 6, '2010-06-01'),
(3, 274, 17, '2016-05-27'),
(2, 119, 45, '2011-03-11'),
(2, 215, 3, '2018-06-25'),
(1, 150, 18, '2014-06-26'),
(3, 51, 3, '2014-03-24'),
(3, 44, 39, '2015-08-30'),
(2, 21, 12, '2013-09-29'),
(1, 59, 4, '2018-03-08'),
(2, 185, 4, '2016-11-04'),
(3, 296, 16, '2010-01-01'),
(2, 201, 17, '2013-03-14'),
(3, 77, 24, '2012-08-12'),
(4, 245, 48, '2009-02-24'),
(1, 75, 10, '2009-10-04'),
(4, 177, 42, '2010-10-16'),
(1, 84, 43, '2017-12-12'),
(3, 110, 26, '2012-07-03'),
(4, 280, 15, '2017-01-07'),
(4, 10, 17, '2011-10-24'),
(4, 37, 10, '2014-12-05'),
(4, 57, 32, '2011-10-18'),
(3, 134, 28, '2011-12-12'),
(2, 222, 45, '2011-08-30'),
(3, 219, 37, '2008-04-03'),
(4, 256, 3, '2016-11-13'),
(1, 157, 5, '2018-07-31'),
(2, 167, 14, '2012-07-08'),
(3, 237, 31, '2009-08-28'),
(2, 227, 24, '2015-09-29'),
(1, 41, 39, '2017-05-13'),
(2, 15, 19, '2008-09-14'),
(4, 50, 20, '2010-05-27'),
(4, 70, 10, '2009-08-11'),
(1, 40, 2, '2015-05-17'),
(3, 206, 31, '2009-05-24'),
(2, 80, 4, '2018-05-27'),
(1, 230, 19, '2013-02-15'),
(1, 207, 41, '2017-01-17'),
(4, 17, 34, '2015-04-21'),
(1, 286, 6, '2017-10-26'),
(3, 176, 44, '2018-06-16'),
(2, 192, 28, '2008-04-27'),
(4, 132, 23, '2016-04-21'),
(3, 221, 46, '2018-12-04'),
(3, 64, 14, '2016-10-15'),
(4, 88, 42, '2015-06-19'),
(4, 54, 17, '2014-08-09'),
(3, 80, 37, '2016-03-21'),
(4, 184, 23, '2010-09-22'),
(3, 239, 20, '2011-11-04'),
(4, 18, 46, '2017-01-30'),
(3, 283, 36, '2017-04-16'),
(2, 120, 22, '2015-02-05'),
(3, 253, 19, '2011-12-04'),
(3, 136, 15, '2015-02-15'),
(4, 245, 45, '2010-07-02'),
(2, 132, 48, '2017-01-01'),
(3, 255, 39, '2011-11-05'),
(1, 281, 25, '2011-08-17'),
(2, 255, 8, '2009-09-28'),
(3, 124, 17, '2010-10-26'),
(3, 18, 8, '2012-03-15'),
(3, 289, 25, '2010-05-24'),
(2, 125, 45, '2018-06-27'),
(3, 101, 44, '2012-12-30'),
(1, 6, 7, '2010-02-16'),
(3, 110, 48, '2014-12-06'),
(2, 86, 36, '2018-08-08'),
(2, 46, 26, '2008-12-18'),
(1, 105, 11, '2008-12-23'),
(1, 120, 8, '2013-05-13'),
(1, 51, 24, '2016-11-28'),
(3, 217, 34, '2018-09-06'),
(2, 155, 27, '2009-02-01'),
(2, 97, 5, '2012-08-02'),
(2, 121, 29, '2018-10-17'),
(1, 252, 42, '2014-04-21'),
(2, 85, 4, '2010-06-18'),
(4, 105, 31, '0000-00-00'),
(4, 280, 41, '2010-12-16'),
(1, 256, 29, '2011-03-25'),
(4, 83, 26, '2013-12-30'),
(3, 81, 23, '2016-05-30'),
(4, 106, 10, '2014-11-08'),
(4, 133, 13, '2018-09-01'),
(4, 276, 46, '2013-09-28'),
(1, 72, 26, '2014-05-29'),
(3, 233, 17, '2012-10-07'),
(3, 139, 27, '2008-12-06'),
(2, 251, 15, '2017-11-03'),
(4, 161, 7, '2017-05-06'),
(3, 21, 35, '2011-08-08'),
(3, 181, 11, '2008-03-30'),
(2, 125, 24, '2014-12-22'),
(2, 72, 25, '2016-09-10'),
(2, 171, 45, '2018-10-01'),
(3, 40, 3, '2012-01-16'),
(3, 187, 43, '2012-09-21'),
(4, 154, 26, '2016-11-19'),
(4, 269, 35, '2011-12-19'),
(4, 59, 12, '2015-02-02'),
(4, 134, 2, '2009-11-27'),
(2, 61, 15, '2012-09-24'),
(3, 51, 36, '2009-11-25'),
(4, 158, 37, '2010-06-04'),
(3, 69, 22, '2018-03-07'),
(4, 192, 27, '2011-03-31'),
(2, 17, 12, '2009-06-08'),
(4, 47, 47, '2013-09-03'),
(2, 195, 8, '2013-10-11'),
(1, 78, 11, '2016-06-06'),
(2, 152, 27, '2012-11-23'),
(4, 40, 29, '2013-05-13'),
(1, 212, 15, '2010-02-06'),
(2, 169, 26, '2011-12-16'),
(3, 182, 36, '2011-06-02'),
(3, 138, 9, '2015-05-20'),
(1, 36, 47, '2009-01-31'),
(2, 16, 12, '2013-10-20'),
(2, 296, 39, '2008-07-06'),
(4, 288, 49, '2012-02-05'),
(4, 175, 46, '2011-10-16'),
(4, 120, 27, '2008-07-19'),
(2, 223, 5, '2012-07-26'),
(2, 213, 38, '2013-06-25'),
(3, 144, 20, '2018-03-24'),
(3, 8, 15, '2016-02-11'),
(4, 289, 19, '2018-11-18'),
(3, 240, 40, '2011-05-02'),
(4, 134, 46, '2008-04-06'),
(1, 39, 32, '2014-02-09'),
(3, 45, 46, '2008-08-07'),
(4, 76, 23, '2015-01-07'),
(2, 60, 40, '2016-04-20'),
(2, 31, 33, '2008-02-25'),
(4, 34, 30, '2015-06-18'),
(1, 174, 6, '2013-01-24'),
(4, 62, 3, '2009-04-27'),
(3, 209, 30, '2018-06-03'),
(1, 22, 15, '2008-07-09'),
(4, 242, 39, '2012-04-19'),
(2, 55, 13, '2014-04-17'),
(4, 152, 9, '2012-01-01'),
(3, 75, 17, '2016-08-03'),
(1, 265, 11, '2013-07-21'),
(1, 213, 18, '2012-03-04'),
(3, 179, 7, '2014-11-23'),
(4, 105, 33, '2016-09-03'),
(2, 80, 45, '2010-02-04'),
(1, 117, 38, '2018-01-23'),
(3, 144, 19, '2015-10-01'),
(2, 240, 7, '2013-07-23'),
(4, 202, 6, '2017-02-18'),
(3, 169, 14, '2015-02-22'),
(1, 259, 21, '2014-10-20'),
(3, 208, 46, '2016-05-03'),
(1, 269, 42, '2009-04-08'),
(4, 82, 41, '2018-08-20'),
(4, 188, 50, '2008-04-30'),
(1, 67, 42, '2015-07-03'),
(2, 197, 15, '2012-02-15'),
(1, 67, 32, '2017-09-23'),
(4, 235, 33, '2009-08-04'),
(3, 172, 44, '2010-02-13'),
(3, 72, 29, '2011-05-19'),
(2, 146, 49, '2014-08-30'),
(4, 69, 4, '2012-10-22'),
(1, 225, 7, '2012-07-29'),
(1, 119, 28, '2012-01-24'),
(1, 49, 22, '2015-01-26'),
(2, 181, 26, '2017-07-25'),
(3, 113, 39, '2014-10-27'),
(1, 78, 4, '2008-08-08'),
(2, 265, 27, '2016-11-01'),
(3, 268, 32, '2015-12-29'),
(1, 161, 32, '2017-12-29'),
(3, 276, 31, '0000-00-00'),
(3, 107, 17, '2016-08-21'),
(3, 255, 47, '2013-08-02'),
(4, 105, 8, '2016-03-11'),
(1, 272, 10, '2008-06-24'),
(4, 101, 41, '2018-08-21'),
(3, 141, 14, '2013-03-09'),
(4, 182, 37, '2013-09-21'),
(1, 124, 35, '2013-07-18'),
(1, 79, 3, '2014-12-16'),
(3, 128, 46, '2015-11-05'),
(2, 82, 30, '2017-08-31'),
(3, 40, 19, '2011-03-14'),
(1, 43, 1, '2013-02-10'),
(1, 170, 21, '2014-06-15'),
(1, 286, 33, '2018-04-16'),
(1, 193, 13, '2017-03-06'),
(1, 270, 21, '2016-12-10'),
(4, 298, 15, '2012-11-23'),
(3, 189, 26, '2012-11-13'),
(4, 192, 39, '2014-04-08'),
(4, 102, 32, '2008-06-10'),
(4, 125, 31, '2012-02-21'),
(4, 280, 44, '2017-12-30'),
(4, 72, 6, '2014-04-27'),
(1, 80, 47, '2017-04-14'),
(4, 8, 13, '2013-10-09'),
(4, 63, 19, '2018-10-02'),
(2, 181, 43, '2010-03-03'),
(4, 215, 22, '2015-02-14'),
(3, 272, 44, '2008-10-13'),
(3, 267, 45, '2014-04-14'),
(2, 240, 2, '2008-08-06'),
(1, 62, 46, '2009-04-13'),
(1, 246, 45, '2011-04-08'),
(3, 168, 45, '2015-04-03'),
(1, 216, 3, '2011-09-30'),
(2, 271, 35, '2016-01-28'),
(4, 71, 8, '2017-10-08'),
(3, 277, 38, '2012-04-02'),
(1, 159, 8, '2017-05-10'),
(3, 15, 41, '2017-08-14'),
(3, 110, 33, '2014-08-30'),
(4, 53, 38, '2016-02-23'),
(1, 135, 45, '2008-12-17'),
(1, 29, 38, '2011-12-19'),
(4, 200, 47, '2011-04-30'),
(2, 190, 45, '2012-08-22'),
(4, 112, 45, '2011-04-09'),
(1, 216, 42, '2016-11-02'),
(4, 102, 44, '2018-10-02'),
(1, 14, 22, '2008-09-10'),
(2, 46, 36, '2008-03-17'),
(2, 154, 32, '2013-06-22'),
(3, 19, 14, '2011-06-04'),
(3, 232, 23, '2015-08-13'),
(3, 224, 5, '2009-04-20'),
(2, 291, 28, '2012-10-16'),
(1, 106, 8, '2014-08-27'),
(3, 273, 44, '2015-03-17'),
(2, 13, 5, '2011-11-07'),
(2, 144, 40, '2011-11-27'),
(4, 3, 24, '2013-12-04'),
(2, 152, 42, '2017-10-29'),
(2, 146, 33, '2014-06-08'),
(1, 176, 14, '2015-11-25'),
(4, 167, 1, '2013-04-09'),
(3, 271, 43, '0000-00-00'),
(1, 78, 10, '2011-07-26'),
(3, 283, 3, '2018-12-03'),
(2, 236, 10, '2016-07-11'),
(3, 270, 21, '2008-07-12'),
(4, 240, 4, '2008-04-17'),
(2, 177, 45, '2011-01-14'),
(2, 293, 20, '2010-04-07'),
(2, 255, 12, '2010-07-14'),
(1, 15, 29, '2008-04-15'),
(2, 18, 25, '2008-08-18'),
(1, 211, 48, '2013-03-20'),
(2, 88, 42, '2011-01-08'),
(2, 193, 19, '2013-10-06'),
(1, 118, 2, '2011-12-09'),
(2, 186, 32, '2008-03-08'),
(4, 102, 40, '2016-03-31'),
(3, 133, 11, '2017-11-07'),
(1, 157, 18, '2011-01-19'),
(2, 57, 8, '2015-04-27'),
(4, 53, 49, '2013-10-29'),
(2, 275, 32, '2011-11-07'),
(2, 295, 48, '2012-01-19'),
(3, 205, 26, '2008-08-03'),
(1, 47, 2, '2010-10-13'),
(4, 175, 44, '2014-05-21'),
(4, 229, 46, '2017-08-15'),
(3, 214, 15, '2018-10-16'),
(3, 130, 34, '2011-01-07'),
(1, 74, 25, '2012-11-23'),
(4, 7, 13, '2010-12-19'),
(3, 232, 14, '2017-08-29'),
(1, 147, 14, '2013-09-02'),
(3, 205, 35, '2013-12-22'),
(1, 148, 42, '2009-09-24'),
(4, 203, 27, '2009-07-14'),
(2, 281, 17, '2008-09-11'),
(2, 223, 7, '2016-01-18'),
(3, 43, 11, '2008-12-06'),
(2, 141, 3, '2009-06-13'),
(4, 264, 38, '2013-03-18'),
(2, 287, 46, '2015-03-04'),
(1, 60, 33, '2016-02-04'),
(4, 301, 32, '2011-11-12'),
(1, 142, 43, '2009-06-29'),
(4, 99, 35, '2009-10-03'),
(1, 110, 10, '2016-12-31'),
(3, 140, 17, '2016-04-04'),
(3, 107, 29, '2009-07-04'),
(1, 173, 14, '2014-02-25'),
(1, 209, 45, '2016-06-12'),
(4, 247, 2, '2010-12-04'),
(2, 44, 43, '2014-07-21'),
(3, 153, 44, '2018-03-21'),
(2, 114, 44, '2016-09-20'),
(3, 232, 31, '2018-03-14'),
(3, 134, 50, '2008-04-12'),
(1, 60, 38, '2011-01-16'),
(2, 189, 4, '2017-05-31'),
(1, 109, 7, '2015-08-03'),
(1, 87, 40, '2017-09-06'),
(4, 125, 19, '2009-10-09'),
(4, 208, 33, '2008-05-09'),
(2, 265, 4, '2008-03-24'),
(2, 108, 7, '2016-01-04'),
(3, 299, 2, '2009-08-24'),
(3, 132, 45, '2012-05-25'),
(3, 27, 22, '2011-11-26'),
(4, 81, 37, '2018-01-19'),
(3, 127, 13, '2010-12-17'),
(2, 170, 33, '2013-03-17'),
(1, 46, 38, '2016-08-25'),
(4, 164, 2, '2018-12-08'),
(3, 40, 27, '2011-12-25'),
(2, 176, 15, '2018-05-29'),
(1, 172, 39, '2013-07-04'),
(3, 123, 49, '2011-05-12'),
(2, 244, 42, '2009-09-14'),
(1, 23, 31, '2018-04-11'),
(4, 169, 32, '2017-05-24'),
(2, 74, 1, '2014-03-07'),
(1, 234, 3, '2015-10-31'),
(4, 138, 31, '2014-10-19'),
(4, 39, 44, '2012-07-09'),
(1, 125, 4, '2009-12-05'),
(3, 247, 49, '2008-10-06'),
(4, 11, 17, '2011-03-06'),
(1, 134, 12, '2012-10-27'),
(1, 135, 22, '2008-10-04'),
(2, 72, 3, '2013-08-10'),
(4, 252, 20, '2014-02-21'),
(1, 195, 14, '2008-09-16'),
(4, 57, 37, '2018-08-05'),
(1, 47, 49, '2011-01-11'),
(2, 164, 28, '2009-12-05'),
(1, 272, 36, '2016-11-17'),
(4, 95, 3, '2016-02-27'),
(4, 163, 11, '2011-11-14'),
(4, 55, 11, '2008-06-19'),
(3, 209, 43, '2016-04-21'),
(2, 96, 37, '2014-11-02'),
(1, 20, 14, '2013-03-06'),
(3, 177, 50, '2012-08-11'),
(2, 202, 18, '2009-05-25'),
(4, 121, 34, '2017-02-12'),
(4, 201, 24, '2015-09-14'),
(1, 144, 30, '2008-07-08'),
(3, 108, 48, '2013-01-22'),
(3, 79, 36, '2009-06-06'),
(2, 101, 25, '2009-01-04'),
(1, 6, 15, '2018-12-19'),
(4, 187, 3, '2008-10-30'),
(3, 7, 27, '2012-12-16'),
(2, 97, 30, '2009-06-01'),
(2, 123, 50, '2018-01-25'),
(4, 261, 4, '2012-08-31'),
(2, 42, 34, '2012-08-25'),
(4, 37, 17, '2011-11-12'),
(1, 180, 14, '2009-07-07'),
(4, 255, 45, '0000-00-00'),
(3, 225, 29, '2013-09-20'),
(4, 165, 33, '2013-11-09'),
(4, 198, 38, '2015-03-29'),
(4, 23, 43, '2009-06-08'),
(1, 237, 3, '2017-02-16'),
(4, 256, 2, '2010-06-22'),
(4, 199, 44, '2009-12-27'),
(1, 14, 34, '0000-00-00'),
(1, 114, 20, '2012-11-21'),
(4, 107, 11, '2015-11-17'),
(4, 222, 34, '2008-05-21'),
(1, 249, 28, '2014-03-30'),
(4, 185, 14, '2009-01-28'),
(1, 81, 31, '2014-12-13'),
(3, 222, 26, '2013-06-06'),
(4, 211, 42, '2016-04-03'),
(1, 38, 20, '2012-10-18'),
(1, 240, 30, '2011-05-02');