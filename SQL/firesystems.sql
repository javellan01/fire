-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Servidor: mysql09-farm51.kinghost.net
-- Tempo de Geração: Set 05, 2018 as 01:30 PM
-- Versão do Servidor: 5.6.36
-- Versão do PHP: 5.2.17



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `u658453311_fire`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividade`
--

DROP TABLE IF EXISTS `atividade`;
CREATE TABLE IF NOT EXISTS `atividade` (
  `id_atividade` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tx_descricao` varchar(255) DEFAULT NULL,
  `tx_tipo` varchar(63) DEFAULT NULL,
  `nb_qtd` int(11) DEFAULT NULL,
  `nb_valor` double(8,2) DEFAULT NULL,
  `dt_atividate` date DEFAULT NULL,
  `nb_dias` int(11) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL DEFAULT '0',
  `id_pedido` int(11) NOT NULL,
  `cs_finalizada` tinyint(1) NOT NULL DEFAULT '0',
  `cs_medida` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_atividade`)
) ;

--
-- Extraindo dados da tabela `atividade`
--

INSERT INTO `atividade` (`id_atividade`, `tx_descricao`, `tx_tipo`, `nb_qtd`, `nb_valor`, `dt_atividate`, `nb_dias`, `id_categoria`, `id_pedido`, `cs_finalizada`, `cs_medida`) VALUES
(1, 'ELABORACAO PROJETO ', 'vb', 1, 30000.00, NULL, NULL, 1, 1, 1, 0),
(2, 'TUBO Ø4"', 'pç', 100, 30000.00, NULL, NULL, 3, 1, 1, 0),
(3, 'TUBO Ø6"', 'pç', 20, 8520.00, NULL, NULL, 3, 1, 1, 0),
(4, 'PINTURA TUBOS Ø6"', 'pç', 150, 10000.00, NULL, NULL, 4, 3, 0, 0),
(5, 'PINTURA TUBO Ø3"', 'pç', 120, 8900.00, NULL, NULL, 4, 3, 0, 0),
(6, 'PINTURA TUBO Ø2"', 'pç', 105, 7500.00, NULL, NULL, 4, 3, 0, 0),
(7, 'PINTURA TUBO Ø1.1/4"', 'pç', 98, 9800.00, NULL, NULL, 4, 3, 0, 0),
(8, 'INICIO DOS PROJETOS ', 'vc', 100, 45000.00, NULL, NULL, 1, 4, 1, 0),
(9, 'PARTE 2 DOS PROJETOS ', '%', 100, 98000.00, NULL, NULL, 1, 4, 1, 0),
(10, 'ELABORAÇÃO EXECUTIVO ', 'vb', 100, 80000.00, NULL, NULL, 1, 2, 0, 0),
(11, 'ELABORAÇÃO AVCB ', 'vb', 100, 16000.00, NULL, NULL, 1, 2, 0, 0),
(12, 'APROVAÇÃO AVCB ', 'vb', 100, 10000.00, NULL, NULL, 1, 2, 0, 0),
(13, 'CANTEIRO ', 'VB', 100, 12000.00, NULL, NULL, 2, 2, 1, 0),
(14, 'PIPE-SHOP ', 'VB', 100, 9000.00, NULL, NULL, 2, 2, 0, 0),
(15, 'PINTURA TUBO Ø4"', 'm', 225, 8000.00, NULL, NULL, 3, 2, 0, 0),
(16, 'PINTURA TUBO Ø2.1/2"', 'm', 150, 5600.00, NULL, NULL, 3, 2, 0, 0),
(17, 'PINTURA TUBO Ø1"', 'm', 100, 6400.00, NULL, NULL, 3, 2, 0, 0),
(18, 'PROJETO BASICO ', 'vb', 100, 25000.00, NULL, NULL, 1, 5, 0, 0),
(19, 'PROJETO EXECUTIVO ', 'vc', 100, 50000.00, NULL, NULL, 1, 5, 0, 0),
(20, 'PIPESHOP ', 'vb', 100, 25000.00, NULL, NULL, 2, 5, 0, 0),
(21, 'PINTURA TUBO Ø8"', 'm', 100, 20000.00, NULL, NULL, 4, 3, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividade_executada`
--

DROP TABLE IF EXISTS `atividade_executada`;
CREATE TABLE IF NOT EXISTS `atividade_executada` (
  `id_usuario` int(11) NOT NULL,
  `id_atividade` int(11) NOT NULL,
  `nb_qtd` int(11) NOT NULL,
  `dt_data` date NOT NULL,
  UNIQUE KEY `UC_Atv_Executada` (`id_atividade`,`dt_data`)
) ;

--
-- Extraindo dados da tabela `atividade_executada`
--

INSERT INTO `atividade_executada` (`id_usuario`, `id_atividade`, `nb_qtd`, `dt_data`) VALUES
(1, 0, 10, '2018-07-02'),
(1, 1, 1, '2018-06-29'),
(1, 2, 20, '2018-06-29'),
(1, 3, 10, '2018-06-29'),
(12, 4, 16, '2018-06-29'),
(1, 4, 15, '2018-07-02'),
(1, 4, 8, '2018-07-04'),
(12, 5, 15, '2018-06-28'),
(12, 5, 16, '2018-06-29'),
(1, 5, 4, '2018-07-04'),
(1, 6, 4, '2018-07-04'),
(1, 7, 5, '2018-07-02'),
(1, 7, 5, '2018-07-04'),
(1, 8, 20, '2018-07-02'),
(1, 8, 15, '2018-07-03'),
(1, 9, 50, '2018-07-02'),
(1, 10, 16, '2018-07-04'),
(1, 10, 25, '2018-07-05'),
(1, 10, 22, '2018-07-10'),
(1, 11, 8, '2018-07-04'),
(1, 11, 75, '2018-07-05'),
(1, 12, 20, '2018-07-04'),
(1, 13, 75, '0000-00-00'),
(1, 13, 25, '2018-07-04'),
(1, 14, 50, '0000-00-00'),
(1, 14, 15, '2018-07-04'),
(1, 15, 50, '0000-00-00'),
(1, 15, 30, '2018-07-04'),
(1, 16, 20, '0000-00-00'),
(1, 16, 16, '2018-07-04'),
(1, 17, 20, '0000-00-00'),
(1, 17, 20, '2018-07-02'),
(1, 17, 20, '2018-07-04'),
(1, 18, 75, '2018-07-06'),
(1, 20, 50, '2018-07-06'),
(12, 21, 50, '2018-07-08');

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividade_medida`
--

DROP TABLE IF EXISTS `atividade_medida`;
CREATE TABLE IF NOT EXISTS `atividade_medida` (
  `id_atividade` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `nb_valor` double(12,2) NOT NULL,
  `nb_ordem` int(11) NOT NULL,
  UNIQUE KEY `UC_Ativ_Medida` (`id_pedido`,`nb_ordem`,`id_atividade`)
) ;

--
-- Extraindo dados da tabela `atividade_medida`
--

INSERT INTO `atividade_medida` (`id_atividade`, `id_pedido`, `nb_valor`, `nb_ordem`) VALUES
(1, 1, 30000.00, 1),
(2, 1, 30000.00, 1),
(3, 1, 8520.00, 1),
(10, 2, 12800.00, 1),
(11, 2, 1280.00, 1),
(12, 2, 2000.00, 1),
(13, 2, 3000.00, 1),
(14, 2, 1350.00, 1),
(15, 2, 1066.67, 1),
(16, 2, 597.33, 1),
(17, 2, 2560.00, 1),
(10, 2, 20000.00, 2),
(11, 2, 12000.00, 2),
(13, 2, 9000.00, 3),
(14, 2, 4500.00, 3),
(15, 2, 1777.77, 3),
(16, 2, 746.67, 3),
(17, 2, 1280.00, 3),
(4, 3, 2066.67, 1),
(5, 3, 6378.33, 1),
(7, 3, 500.00, 1),
(4, 3, 533.33, 2),
(6, 3, 285.71, 2),
(7, 3, 500.00, 2),
(21, 3, 10000.00, 2),
(8, 4, 15750.00, 1),
(9, 4, 49000.00, 1),
(18, 5, 2500.00, 1),
(20, 5, 12500.00, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id_categoria` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tx_nome` varchar(63) DEFAULT NULL,
  PRIMARY KEY (`id_categoria`),
  UNIQUE KEY `id_categoria` (`id_categoria`)
)   ;

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

-- --------------------------------------------------------

--
-- Estrutura da tabela `cat_pedido`
--

DROP TABLE IF EXISTS `cat_pedido`;
CREATE TABLE IF NOT EXISTS `cat_pedido` (
  `id_pedido` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `nb_provis` double(10,2) DEFAULT NULL
) ;

--
-- Extraindo dados da tabela `cat_pedido`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `id_cliente` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tx_nome` varchar(255) DEFAULT NULL,
  `tx_cnpj` varchar(18) NOT NULL DEFAULT '00000000000000',
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `tx_cnpj` (`tx_cnpj`)
)  ;

--
-- Extraindo dados da tabela `cliente`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecimento`
--

DROP TABLE IF EXISTS `fornecimento`;
CREATE TABLE IF NOT EXISTS `fornecimento` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tx_descricao` varchar(255) DEFAULT NULL,
  `tx_tipo` varchar(31) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
)   AUTO_INCREMENT=38 ;

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

-- --------------------------------------------------------

--
-- Estrutura da tabela `medicao`
--

DROP TABLE IF EXISTS `medicao`;
CREATE TABLE IF NOT EXISTS `medicao` (
  `id_medicao` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) NOT NULL,
  `nb_ordem` int(11) NOT NULL,
  `tx_nota` varchar(63) DEFAULT NULL,
  `dt_data` date DEFAULT NULL,
  `cs_finalizada` tinyint(1) NOT NULL DEFAULT '0',
  `dt_vencimento` date DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_medicao`),
  UNIQUE KEY `id_medicao` (`id_medicao`),
  UNIQUE KEY `UC_Medicao` (`id_pedido`,`nb_ordem`)
)   ;

--
-- Extraindo dados da tabela `medicao`
--

INSERT INTO `medicao` (`id_medicao`, `id_pedido`, `nb_ordem`, `tx_nota`, `dt_data`, `cs_finalizada`, `dt_vencimento`, `id_usuario`, `created_at`, `updated_at`) VALUES
(3, 1, 1, NULL, '2018-07-04', 0, NULL, 1, '2018-07-04 13:53:19', '2018-07-04 13:53:19'),
(9, 3, 1, NULL, '2018-07-04', 0, NULL, 1, '2018-07-04 15:18:16', '2018-07-04 15:18:16'),
(14, 2, 1, NULL, '2018-07-05', 0, NULL, 1, '2018-07-05 09:41:54', '2018-07-05 09:41:54'),
(15, 2, 2, NULL, '2018-07-08', 0, NULL, 1, '2018-07-05 09:43:07', '2018-07-05 09:43:07'),
(16, 5, 1, NULL, '2018-07-07', 0, NULL, 1, '2018-07-06 18:36:36', '2018-07-06 18:36:36'),
(17, 2, 3, NULL, '0000-00-00', 0, NULL, 1, '2018-07-07 08:36:25', '2018-07-07 08:36:25'),
(18, 3, 2, NULL, '2018-07-08', 0, NULL, 12, '2018-07-07 23:24:41', '2018-07-07 23:24:41'),
(19, 4, 1, NULL, '0000-00-00', 0, NULL, 1, '2018-09-03 19:23:26', '2018-09-03 19:23:26');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido`
--

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE IF NOT EXISTS `pedido` (
  `id_pedido` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tx_codigo` varchar(63) DEFAULT NULL,
  `tx_descricao` varchar(511) DEFAULT NULL,
  `cs_estado` tinyint(1) NOT NULL DEFAULT '0',
  `id_cliente` int(11) NOT NULL,
  `nb_valor` double(10,2) DEFAULT NULL,
  `nb_retencao` int(11) DEFAULT NULL,
  `dt_idata` date DEFAULT NULL,
  `tx_local` varchar(63) DEFAULT NULL,
  `dt_tdata` date DEFAULT NULL,
  `id_usu_resp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pedido`),
  UNIQUE KEY `UC_Unique` (`id_cliente`,`tx_codigo`)
)   ;

--
-- Extraindo dados da tabela `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `tx_codigo`, `tx_descricao`, `cs_estado`, `id_cliente`, `nb_valor`, `nb_retencao`, `dt_idata`, `tx_local`, `dt_tdata`, `id_usu_resp`) VALUES
(1, 'OC12345', '', 0, 47, 100000.00, 5, '2018-06-29', 'Nova Fabrica Barbeador C4', '2018-07-29', 1),
(2, 'OC1009', '', 0, 47, 200000.00, 5, '2018-06-29', 'C3', '2018-06-29', 1),
(3, 'OC1454', '', 0, 47, 150000.00, 5, '2018-06-29', 'PARQUE DE GAS', '2018-09-08', 12),
(4, 'CONTRATO001', '', 0, 48, 500000.00, 5, '2018-07-02', 'VALINHOS', '2018-10-02', 1),
(5, 'PN25368', '', 0, 49, 100000.00, 5, '2018-07-06', 'PREDIO CENTRAL', '2018-11-06', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nb_category_user` int(11) DEFAULT NULL,
  `tx_name` varchar(255) DEFAULT NULL,
  `tx_email` varchar(150) DEFAULT NULL,
  `tx_password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `tx_cpf` varchar(14) DEFAULT NULL,
  `tx_telefone` varchar(31) DEFAULT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `tx_cpf_2` (`tx_cpf`),
  KEY `tx_cpf` (`tx_cpf`)
)    ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nb_category_user`, `tx_name`, `tx_email`, `tx_password`, `remember_token`, `tx_cpf`, `tx_telefone`, `updated_at`) VALUES
(1, 0, 'MARCIO KUNZENDORFF', 'marcio@firesystems', 'e10adc3949ba59abbe56e057f20f883e', NULL, '218.635.218-44', '(92) 99282-3975', '2018-07-04 14:52:51'),
(2, 0, 'JOAO AVELLAN', '', 'e10adc3949ba59abbe56e057f20f883e', NULL, '110.252.787-47', '923455677', '2018-07-04 14:52:51'),
(3, 1, 'EVERTON', '', 'e10adc3949ba59abbe56e057f20f883e', NULL, '352.927.058-02', '', '2018-07-06 19:44:07');

-- --------------------------------------------------------

--
-- Estrutura stand-in para visualizar `v_categoria_sums`
--
DROP VIEW IF EXISTS `v_categoria_sums`;
CREATE TABLE IF NOT EXISTS `v_categoria_sums` (
`id_atividade` bigint(20) unsigned
,`id_pedido` int(11)
,`id_categoria` int(11)
,`nb_valor` double(8,2)
,`valor_sum` double(19,2)
,`nb_qtd` int(11)
,`qtd_sum` decimal(32,0)
,`v_unit` double(12,6)
,`progresso` double(23,6)
);
-- --------------------------------------------------------

--
-- Estrutura stand-in para visualizar `v_sum_atividade_exec`
--
DROP VIEW IF EXISTS `v_sum_atividade_exec`;
CREATE TABLE IF NOT EXISTS `v_sum_atividade_exec` (
`qtd_sum` decimal(32,0)
,`id_atividade` bigint(20) unsigned
,`nb_qtd` int(11)
);
-- --------------------------------------------------------

--
-- Estrutura stand-in para visualizar `v_sum_atividade_medd`
--
DROP VIEW IF EXISTS `v_sum_atividade_medd`;
CREATE TABLE IF NOT EXISTS `v_sum_atividade_medd` (
`valor_sum` double(19,2)
,`id_atividade` bigint(20) unsigned
,`id_pedido` int(11)
,`nb_valor` double(8,2)
);
-- --------------------------------------------------------

--
-- Estrutura stand-in para visualizar `v_sum_pedido_total`
--
DROP VIEW IF EXISTS `v_sum_pedido_total`;
CREATE TABLE IF NOT EXISTS `v_sum_pedido_total` (
`medido_total` double(19,2)
,`total_atividade` double(19,2)
,`id_pedido` bigint(20) unsigned
,`nb_valor` double(10,2)
);
-- --------------------------------------------------------

--
-- Estrutura para visualizar `v_categoria_sums`
--
DROP TABLE IF EXISTS `v_categoria_sums`;

CREATE ALGORITHM=UNDEFINED DEFINER=`firesystems`@`%` SQL SECURITY DEFINER VIEW `v_categoria_sums` AS select `a`.`id_atividade` AS `id_atividade`,`a`.`id_pedido` AS `id_pedido`,`a`.`id_categoria` AS `id_categoria`,`v2`.`nb_valor` AS `nb_valor`,ifnull(`v2`.`valor_sum`,0) AS `valor_sum`,`v1`.`nb_qtd` AS `nb_qtd`,ifnull(`v1`.`qtd_sum`,0) AS `qtd_sum`,(`v2`.`nb_valor` / `v1`.`nb_qtd`) AS `v_unit`,((`v2`.`nb_valor` / `v1`.`nb_qtd`) * ifnull(`v1`.`qtd_sum`,0)) AS `progresso` from ((`atividade` `a` left join `v_sum_atividade_exec` `v1` on((`a`.`id_atividade` = `v1`.`id_atividade`))) left join `v_sum_atividade_medd` `v2` on((`a`.`id_atividade` = `v2`.`id_atividade`)));

-- --------------------------------------------------------

--
-- Estrutura para visualizar `v_sum_atividade_exec`
--
DROP TABLE IF EXISTS `v_sum_atividade_exec`;

CREATE ALGORITHM=UNDEFINED DEFINER=`firesystems`@`%` SQL SECURITY DEFINER VIEW `v_sum_atividade_exec` AS select sum(`a1`.`nb_qtd`) AS `qtd_sum`,`a0`.`id_atividade` AS `id_atividade`,`a0`.`nb_qtd` AS `nb_qtd` from (`atividade` `a0` left join `atividade_executada` `a1` on((`a0`.`id_atividade` = `a1`.`id_atividade`))) group by `a0`.`id_atividade`;

-- --------------------------------------------------------

--
-- Estrutura para visualizar `v_sum_atividade_medd`
--
DROP TABLE IF EXISTS `v_sum_atividade_medd`;

CREATE ALGORITHM=UNDEFINED DEFINER=`firesystems`@`%` SQL SECURITY DEFINER VIEW `v_sum_atividade_medd` AS select sum(`a1`.`nb_valor`) AS `valor_sum`,`a0`.`id_atividade` AS `id_atividade`,`a0`.`id_pedido` AS `id_pedido`,`a0`.`nb_valor` AS `nb_valor` from (`atividade` `a0` left join `atividade_medida` `a1` on((`a0`.`id_atividade` = `a1`.`id_atividade`))) group by `a0`.`id_atividade`;

-- --------------------------------------------------------

--
-- Estrutura para visualizar `v_sum_pedido_total`
--
DROP TABLE IF EXISTS `v_sum_pedido_total`;

CREATE ALGORITHM=UNDEFINED DEFINER=`firesystems`@`%` SQL SECURITY DEFINER VIEW `v_sum_pedido_total` AS select sum(`p1`.`valor_sum`) AS `medido_total`,sum(`p1`.`nb_valor`) AS `total_atividade`,`p0`.`id_pedido` AS `id_pedido`,`p0`.`nb_valor` AS `nb_valor` from (`pedido` `p0` left join `v_sum_atividade_medd` `p1` on((`p1`.`id_pedido` = `p0`.`id_pedido`))) group by `p0`.`id_pedido`;
