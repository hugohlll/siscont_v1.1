-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 05-Nov-2025 às 10:47
-- Versão do servidor: 8.0.43
-- versão do PHP: 8.1.2-1ubuntu2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_CRUD`
--

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `AZEREDO-COMISSOES`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `AZEREDO-COMISSOES` (
`anocont` year
,`idcom` int
,`idfuncao` int
,`inicio` date
,`nomeempresa` varchar(45)
,`nomefuncao` varchar(45)
,`nomegr` varchar(20)
,`nomepg` varchar(4)
,`numerocont` int
,`omcont` enum('GAPGL','GAPGL-PAGL','GAPRJ')
,`status` enum('vigente','finalizada','revogada')
,`termino` date
,`tipocom` enum('FISCALIZAÇÃO','RECEBIMENTO','FISCALIZAÇÃO OBRAS/SV ENGENHARIA','RECEBIMENTO EM DEFINITIVO')
,`tipocont` enum('receita','despesa')
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `AZEREDO-COMISSOES-3`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `AZEREDO-COMISSOES-3` (
`anocont` year
,`idcom` int
,`idfuncao` int
,`inicio` date
,`nomeempresa` varchar(45)
,`nomefuncao` varchar(45)
,`nomegr` varchar(20)
,`nomepg` varchar(4)
,`numerocont` int
,`omcont` enum('GAPGL','GAPGL-PAGL','GAPRJ')
,`status` enum('vigente','finalizada','revogada')
,`termino` date
,`tipocom` enum('FISCALIZAÇÃO','RECEBIMENTO','FISCALIZAÇÃO OBRAS/SV ENGENHARIA','RECEBIMENTO EM DEFINITIVO')
,`tipocont` enum('receita','despesa')
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `AZEREDO_BENS-RENDAS`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `AZEREDO_BENS-RENDAS` (
`contrato` varchar(27)
,`funcao` varchar(45)
,`inicio` date
,`militar` varchar(25)
,`termino` date
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `AZEREDO_BENS-RENDAS_FINAL`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `AZEREDO_BENS-RENDAS_FINAL` (
`assuncao` date
,`contrato` varchar(27)
,`funcao` varchar(45)
,`militar` varchar(25)
,`termino` date
);

-- --------------------------------------------------------

--
-- Estrutura da tabela `comissoes`
--

CREATE TABLE `comissoes` (
  `idcom` int NOT NULL,
  `tipocom` enum('FISCALIZAÇÃO','RECEBIMENTO','FISCALIZAÇÃO OBRAS/SV ENGENHARIA','RECEBIMENTO EM DEFINITIVO') CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `contratos_idcont` int NOT NULL,
  `vigencia_ini` date NOT NULL,
  `vigencia_fim` date NOT NULL,
  `portaria_num` int NOT NULL,
  `portaria_data` date NOT NULL,
  `bol_num` int NOT NULL,
  `bol_data` date NOT NULL,
  `obs` varchar(400) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` enum('vigente','finalizada','revogada') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `comissoes`
--

INSERT INTO `comissoes` (`idcom`, `tipocom`, `contratos_idcont`, `vigencia_ini`, `vigencia_fim`, `portaria_num`, `portaria_data`, `bol_num`, `bol_data`, `obs`, `status`) VALUES
(1, 'FISCALIZAÇÃO', 17, '2021-03-18', '2022-03-17', 49, '2021-05-17', 92, '2021-05-20', '', 'finalizada'),
(2, 'FISCALIZAÇÃO', 7, '2021-03-18', '2022-03-17', 36, '2021-03-18', 70, '2021-04-19', '', 'finalizada'),
(3, 'FISCALIZAÇÃO', 5, '2021-03-01', '2022-02-28', 32, '2021-03-11', 48, '2021-03-15', 'revogada pela Portaria 148/ACI, de 12 de novembro de 2021', 'revogada'),
(4, 'FISCALIZAÇÃO', 26, '2020-09-01', '2021-09-01', 67, '2020-01-09', 160, '2020-09-08', '', 'finalizada'),
(5, 'FISCALIZAÇÃO', 15, '2021-03-18', '2022-03-17', 41, '2021-03-18', 70, '2021-04-19', 'Revogada pela Portaria nº 14/ACI, de 8 de fevereiro de 2022.', 'revogada'),
(6, 'FISCALIZAÇÃO', 18, '2020-12-17', '2021-12-16', 116, '2020-12-17', 232, '2020-12-22', '', 'finalizada'),
(7, 'FISCALIZAÇÃO', 16, '2021-07-12', '2022-07-11', 95, '2021-07-05', 130, '2021-07-16', '', 'finalizada'),
(8, 'FISCALIZAÇÃO', 20, '2021-07-12', '2022-07-11', 93, '2021-07-05', 130, '2021-07-16', 'revogada pela portaria nº 4/ACI, de 13/01/2022. Asp Tissei no lugar da Ten Raiany.', 'revogada'),
(9, 'FISCALIZAÇÃO', 22, '2021-07-12', '2022-07-11', 96, '2021-07-05', 130, '2021-07-16', '', 'finalizada'),
(10, 'FISCALIZAÇÃO', 24, '2021-07-12', '2022-07-11', 97, '2021-07-05', 130, '2021-07-16', '', 'finalizada'),
(11, 'FISCALIZAÇÃO', 14, '2021-03-08', '2022-03-07', 29, '2021-03-02', 42, '2021-03-05', '', 'finalizada'),
(12, 'FISCALIZAÇÃO', 19, '2021-07-04', '2022-07-03', 99, '2021-07-01', 130, '2021-07-16', '', 'finalizada'),
(13, 'FISCALIZAÇÃO', 11, '2021-07-04', '2022-07-03', 98, '2021-07-01', 130, '2021-07-16', '', 'finalizada'),
(14, 'FISCALIZAÇÃO', 23, '2020-09-02', '2021-09-02', 75, '2020-09-17', 171, '2020-09-23', '', 'finalizada'),
(15, 'FISCALIZAÇÃO', 9, '2021-02-24', '2022-02-23', 26, '2021-02-24', 42, '2021-03-05', '', 'finalizada'),
(16, 'FISCALIZAÇÃO', 21, '2021-02-24', '2022-02-23', 42, '2021-04-13', 70, '2021-04-19', '', 'finalizada'),
(17, 'FISCALIZAÇÃO', 4, '2021-02-24', '2022-02-23', 27, '2021-02-24', 42, '2021-03-05', '', 'finalizada'),
(18, 'FISCALIZAÇÃO', 10, '2021-02-24', '2022-02-23', 43, '2021-04-13', 70, '2021-04-19', '', 'finalizada'),
(19, 'FISCALIZAÇÃO', 25, '2021-07-02', '2022-07-01', 89, '2021-06-30', 130, '2021-07-16', '', 'finalizada'),
(20, 'FISCALIZAÇÃO', 8, '2021-06-02', '2022-06-01', 81, '2021-06-01', 113, '2021-06-22', '', 'finalizada'),
(21, 'FISCALIZAÇÃO', 6, '2021-07-12', '2022-07-11', 94, '2021-07-05', 130, '2021-07-16', '', 'finalizada'),
(22, 'FISCALIZAÇÃO', 27, '2021-02-01', '2021-07-31', 12, '2021-01-12', 26, '2021-02-09', '', 'finalizada'),
(23, 'FISCALIZAÇÃO', 12, '2021-05-03', '2022-05-02', 82, '2021-05-03', 113, '2021-06-22', 'contrato encerrado', 'finalizada'),
(24, 'FISCALIZAÇÃO', 13, '2021-05-03', '2022-05-02', 73, '2021-05-03', 111, '2021-06-18', 'contrato encerrado', 'finalizada'),
(28, 'RECEBIMENTO', 18, '2021-07-12', '2022-07-12', 100, '2021-07-07', 130, '2021-07-16', '', 'finalizada'),
(29, 'RECEBIMENTO', 16, '2020-12-17', '2021-12-16', 116, '2020-12-17', 232, '2020-12-22', '', 'finalizada'),
(91, 'RECEBIMENTO', 14, '2021-07-12', '2022-07-11', 102, '2021-07-07', 130, '2021-07-16', '', 'finalizada'),
(92, 'RECEBIMENTO', 22, '2021-07-11', '2022-07-12', 106, '2021-07-09', 135, '2021-07-26', '', 'finalizada'),
(93, 'RECEBIMENTO', 19, '2021-01-04', '2022-01-04', 10, '2021-01-04', 13, '2021-01-21', '', 'finalizada'),
(94, 'RECEBIMENTO', 11, '2021-01-04', '2022-01-04', 8, '2021-01-04', 13, '2021-01-21', '', 'finalizada'),
(95, 'RECEBIMENTO', 24, '2021-07-12', '2022-07-11', 103, '2021-07-07', 130, '2021-07-16', '', 'finalizada'),
(97, 'RECEBIMENTO', 20, '2021-05-29', '2022-05-28', 54, '2021-05-28', 102, '2021-06-07', '', 'finalizada'),
(99, 'RECEBIMENTO', 9, '2021-07-14', '2022-07-13', 105, '2021-06-12', 135, '2021-07-26', '', 'finalizada'),
(100, 'RECEBIMENTO', 21, '2021-06-10', '2022-06-09', 86, '2021-06-10', 118, '2021-06-29', '', 'finalizada'),
(101, 'RECEBIMENTO', 4, '2021-07-14', '2022-07-13', 108, '2021-07-12', 137, '2021-07-28', '', 'finalizada'),
(102, 'RECEBIMENTO', 10, '2021-06-10', '2022-06-09', 118, '2021-06-29', 118, '2021-06-29', '', 'finalizada'),
(103, 'RECEBIMENTO', 8, '2021-06-02', '2022-06-01', 80, '2021-06-01', 113, '2021-06-22', 'revogada pela portaria nº 3/ACI, de 13/01/2022. Asp Tissei no lugar da Ten Raiany.', 'revogada'),
(104, 'RECEBIMENTO', 6, '2021-05-20', '2022-05-19', 51, '2020-05-21', 92, '2021-05-20', '', 'finalizada'),
(105, 'RECEBIMENTO', 27, '2021-02-01', '2021-07-21', 1, '2021-01-21', 26, '2021-02-09', 'obras e sv de engenharia – recebimento definitivo', 'finalizada'),
(106, 'RECEBIMENTO', 12, '2021-05-03', '2022-05-02', 83, '2021-05-03', 113, '2021-06-22', 'Recebimento definitivo', 'revogada'),
(107, 'RECEBIMENTO', 13, '2021-05-03', '2022-05-02', 76, '2021-05-03', 111, '2021-06-18', 'Recebimento definitivo', 'revogada'),
(108, 'RECEBIMENTO EM DEFINITIVO', 29, '2020-02-22', '2020-09-26', 12, '2020-02-20', 232, '2020-12-22', 'Recebimento em definitivo - obras/sv de engenharia', 'finalizada'),
(109, 'FISCALIZAÇÃO', 26, '2021-09-02', '2022-09-01', 115, '2021-08-31', 163, '2021-09-03', '', 'finalizada'),
(110, 'RECEBIMENTO', 12, '2021-08-21', '2022-05-02', 119, '2021-08-20', 165, '2021-09-09', 'prazo contrato estendido ate 29/05/22. Nova comissao a ser feita de 03/05/22 a 29/05/22', 'finalizada'),
(111, 'RECEBIMENTO', 13, '2021-08-20', '2022-05-02', 118, '2021-08-20', 165, '2021-09-09', 'contrato encerrado', 'finalizada'),
(112, 'FISCALIZAÇÃO', 30, '2021-09-22', '2022-04-22', 139, '2021-09-22', 191, '2021-10-19', '', 'finalizada'),
(113, 'RECEBIMENTO', 30, '2021-09-22', '2022-04-22', 133, '2021-09-21', 191, '2021-10-19', '', 'finalizada'),
(114, 'FISCALIZAÇÃO', 27, '2021-07-31', '2021-12-31', 140, '2021-07-31', 211, '2021-11-22', 'BCA 207, DE 12/11/2021; BI 208, DE 17/11/2021; BI 211, DE 22/11/2021 ', 'finalizada'),
(115, 'FISCALIZAÇÃO', 5, '2021-11-19', '2022-02-28', 148, '2021-11-12', 208, '2021-11-17', '', 'finalizada'),
(116, 'FISCALIZAÇÃO', 31, '2021-11-30', '2022-11-29', 158, '2021-11-30', 222, '2021-12-30', 'Revogada pela Portaria nº 2/ACI, de 13/01/2022. Asp Tissei entrando no lugar da Ten Raiany.', 'revogada'),
(117, 'RECEBIMENTO', 31, '2021-11-30', '2022-11-29', 157, '2021-11-30', 222, '2021-12-07', '', 'finalizada'),
(118, 'RECEBIMENTO', 11, '2022-01-05', '2023-01-04', 167, '2021-12-22', 236, '2021-12-28', 'Contrato encerrado em 03/07/2022.', 'finalizada'),
(119, 'RECEBIMENTO', 19, '2022-01-05', '2023-01-04', 166, '2021-12-22', 236, '2021-12-28', 'Contrato encerrado em 03/07/2022.', 'finalizada'),
(120, 'FISCALIZAÇÃO', 31, '2022-01-24', '2022-11-29', 2, '2022-01-13', 14, '2022-01-21', 'Revoga a portaria nº 158/ACI, de 30/11/2021.\r\nSubstiuicao AP Isabella no lugar do 2T Venite, Portaria 62/ACI, de 24/06/2022, Boletim 118, de 28/06/2022.', 'finalizada'),
(121, 'RECEBIMENTO', 8, '2022-01-24', '2022-06-01', 3, '2022-01-13', 14, '2022-01-21', 'revoga a portaria nº 80/ACI, de 1º de junho de 2021.', 'finalizada'),
(122, 'FISCALIZAÇÃO', 20, '2022-01-24', '2022-07-11', 4, '2022-01-13', 14, '2022-01-21', 'revoga a portaria nº 93/ACI, de 05/07/2021. Ten Emanuelle Rodrigues como 2º suplente a partir de 1º de junho de 2022, conforme Portaria 84/ACI, de 30/05/2022.', 'finalizada'),
(123, 'FISCALIZAÇÃO', 32, '2021-12-06', '2022-12-05', 161, '2021-12-06', 232, '2021-12-21', 'revogada pela Portaria n 38/ACI, de 21 de março de 2022.', 'revogada'),
(124, 'RECEBIMENTO', 32, '2021-12-06', '2022-12-05', 160, '2021-12-06', 232, '2021-12-21', 'Revogada pela Portaria 89/ACI, de 31/08/2022.', 'revogada'),
(125, 'FISCALIZAÇÃO', 15, '2022-02-23', '2023-02-22', 14, '2022-02-08', 33, '2022-02-17', 'Revoga a Portaria nº 41/ACI, de 18 de março de 2021.\r\nContrato encerrado em dezembro de 2022. Houve autorizacao excepcional ate 03/01/2023. Novo contrato a partir de 04/01/2023', 'finalizada'),
(126, 'FISCALIZAÇÃO', 32, '2021-12-06', '2022-12-05', 38, '2022-03-21', 56, '2022-03-24', 'revoga a portaria n 161/ACI, de 06/12/2021. Revogada pela portaria 90/ACI, de 28/09/2022.', 'revogada'),
(127, 'FISCALIZAÇÃO', 9, '2022-02-24', '2023-02-23', 8, '2022-02-08', 33, '2022-02-17', 'Substituição 1T Martins no lugar do TC Rezende, a contar de 1º de setembro de 2022. Portaria 80/ACI, de 24/08/2022, publicada no Boletim nº 157, de 26/08/2022', 'finalizada'),
(128, 'FISCALIZAÇÃO', 4, '2022-02-24', '2023-02-23', 10, '2022-02-08', 33, '2022-02-17', '', 'finalizada'),
(129, 'FISCALIZAÇÃO', 21, '2022-02-24', '2023-02-23', 12, '2022-02-08', 33, '2022-02-17', 'Substituição 1T Martins no lugar do 1T Galdino, a contar de 1º de setembro de 2022. Portaria 82/ACI, de 24/08/2022, publicada no Boletim nº 157, de 26/08/2022', 'finalizada'),
(130, 'FISCALIZAÇÃO', 10, '2022-02-24', '2023-02-23', 13, '2022-02-08', 33, '2022-02-17', '', 'finalizada'),
(133, 'FISCALIZAÇÃO', 12, '2022-05-03', '2022-05-29', 52, '2022-04-29', 89, '2022-05-16', '', 'finalizada'),
(135, 'RECEBIMENTO', 12, '2022-05-03', '2022-05-29', 54, '2022-04-29', 89, '2022-05-16', '', 'finalizada'),
(136, 'RECEBIMENTO', 20, '2022-05-29', '2022-07-11', 51, '2022-05-10', 89, '2022-05-16', 'Revogada pela Portaria nº 83/ACI, de 30/05/2022.', 'revogada'),
(137, 'FISCALIZAÇÃO', 8, '2022-06-02', '2023-06-01', 56, '2022-05-30', 104, '2022-06-06', 'Haverá renovação, porem a mesma ainda não foi lancada no SILOMS.', 'finalizada'),
(138, 'RECEBIMENTO', 21, '2022-06-10', '2022-09-10', 58, '2022-06-03', 106, '2022-08-06', '', 'finalizada'),
(139, 'RECEBIMENTO', 10, '2022-06-10', '2023-06-09', 57, '2022-06-03', 106, '2022-06-08', 'contrato encerrado em 25/10/2022', 'finalizada'),
(140, 'FISCALIZAÇÃO', 17, '2022-03-18', '2023-03-17', 9, '2022-02-08', 33, '2022-02-17', 'Revogada pela Portaria 72/ACI, de 01/08/2022, a contar de 25/07/2022.', 'revogada'),
(141, 'FISCALIZAÇÃO', 7, '2022-03-03', '2023-03-02', 11, '2022-02-08', 33, '2022-02-17', '', 'finalizada'),
(142, 'RECEBIMENTO', 8, '2022-06-02', '2023-06-01', 59, '2022-05-30', 106, '2022-06-08', '', 'finalizada'),
(143, 'RECEBIMENTO', 4, '2022-07-14', '2023-07-13', 63, '2022-07-04', 131, '2022-07-15', 'Contrato encerrado em 25/10/2022', 'finalizada'),
(144, 'RECEBIMENTO', 9, '2022-07-14', '2023-07-13', 64, '2022-07-04', 131, '2022-07-15', '', 'finalizada'),
(145, 'RECEBIMENTO', 14, '2022-07-12', '2023-07-11', 65, '2022-07-04', 131, '2022-07-15', '', 'finalizada'),
(146, 'RECEBIMENTO', 24, '2022-07-12', '2023-07-11', 66, '2022-07-04', 131, '2022-07-15', '', 'finalizada'),
(147, 'FISCALIZAÇÃO', 24, '2022-07-12', '2023-07-11', 67, '2022-07-11', 131, '2022-07-15', '', 'finalizada'),
(148, 'RECEBIMENTO', 22, '2022-07-13', '2023-07-12', 68, '2022-07-04', 131, '2022-07-15', 'data inicial errada na portaria. Corrigindo de 11/07 para 13/07', 'finalizada'),
(149, 'FISCALIZAÇÃO', 22, '2022-07-12', '2023-07-11', 69, '2022-07-04', 131, '2022-07-15', 'Revogada pela Portaria 7/ACI, de 9 janeiro de 2023. A contar de 11/01/23', 'revogada'),
(150, 'FISCALIZAÇÃO', 17, '2022-07-25', '2023-07-01', 72, '2022-07-18', 139, '2022-08-01', '', 'finalizada'),
(151, 'FISCALIZAÇÃO', 19, '2022-07-04', '2023-07-03', 73, '2022-07-01', 139, '2022-08-01', 'Contrato encerrado em 03/07/2022.', 'finalizada'),
(152, 'FISCALIZAÇÃO', 11, '2022-07-04', '2023-07-03', 74, '2022-07-01', 139, '2022-08-01', 'Contrato encerrado em 03/07/2022.', 'finalizada'),
(153, 'FISCALIZAÇÃO', 26, '2022-09-02', '2023-09-01', 81, '2022-08-24', 139, '2022-08-01', '', 'finalizada'),
(154, 'RECEBIMENTO', 20, '2022-06-01', '2022-07-11', 83, '2022-05-30', 162, '2022-09-02', 'Revoga a Portaria nº 51/ACI, de 10 de maio de 2022', 'finalizada'),
(155, 'RECEBIMENTO', 21, '2022-09-11', '2023-09-10', 86, '2022-09-09', 172, '2022-09-20', '', 'finalizada'),
(156, 'RECEBIMENTO', 32, '2022-09-01', '2022-12-05', 89, '2022-08-31', 181, '2022-10-04', 'Revoga a Portaria 160/ACI, de 06/12/2021.', 'finalizada'),
(157, 'FISCALIZAÇÃO', 32, '2022-09-01', '2022-12-05', 90, '2022-09-28', 181, '2022-10-04', 'Revoga a Portaria 38/ACI, de 21/03/2022.', 'finalizada'),
(158, 'RECEBIMENTO', 31, '2022-11-30', '2023-11-29', 99, '2022-11-18', 211, '2022-11-24', '', 'finalizada'),
(159, 'FISCALIZAÇÃO', 31, '2022-11-30', '2023-11-29', 100, '2022-11-17', 211, '2022-11-24', '', 'finalizada'),
(162, 'RECEBIMENTO', 32, '2022-12-06', '2023-12-05', 219, '2022-12-05', 219, '2022-12-08', '', 'finalizada'),
(163, 'FISCALIZAÇÃO', 32, '2022-12-06', '2023-12-05', 102, '2022-12-05', 219, '2022-12-08', 'Revogada pela Portaria 73/ACI, de 1 de novembro de 2023.', 'revogada'),
(164, 'FISCALIZAÇÃO', 33, '2023-01-04', '2024-01-03', 8, '2023-01-04', 11, '2023-01-17', '', 'finalizada'),
(165, 'FISCALIZAÇÃO', 34, '2023-01-12', '2024-01-11', 14, '2023-01-12', 25, '2023-02-07', '', 'finalizada'),
(166, 'FISCALIZAÇÃO', 35, '2023-01-04', '2024-01-04', 10, '2023-01-04', 11, '2023-01-17', '', 'finalizada'),
(167, 'FISCALIZAÇÃO', 22, '2023-01-11', '2024-01-10', 7, '2023-01-09', 11, '2023-01-17', 'Revoga a Portaria 69/ACI, de 4 de julho de 2022', 'finalizada'),
(168, 'FISCALIZAÇÃO', 8, '2023-06-02', '2024-06-01', 42, '2023-05-24', 100, '2023-06-02', '', 'finalizada'),
(169, 'RECEBIMENTO', 8, '2023-06-02', '2024-06-01', 45, '2023-05-24', 100, '2023-06-02', '', 'finalizada'),
(170, 'FISCALIZAÇÃO', 17, '2023-07-02', '2024-07-03', 51, '2023-06-28', 119, '2023-07-03', '', 'finalizada'),
(171, 'RECEBIMENTO', 22, '2023-07-11', '2024-07-12', 53, '2023-06-28', 119, '2023-07-03', '', 'finalizada'),
(172, 'RECEBIMENTO', 24, '2023-07-12', '2024-05-16', 54, '2023-06-28', 119, '2023-07-03', 'Revogada pela Portaria nº 60/ACI, de 13/05/24 e posteriormente pela Portaria nº 69/ACI, de 16/05/24.', 'revogada'),
(173, 'FISCALIZAÇÃO', 24, '2023-07-12', '2024-07-11', 55, '2023-06-28', 119, '2023-07-03', '', 'finalizada'),
(174, 'RECEBIMENTO', 9, '2023-07-14', '2024-07-13', 52, '2023-06-28', 119, '2023-07-03', '', 'finalizada'),
(175, 'FISCALIZAÇÃO', 9, '2023-02-24', '2024-02-23', 20, '2023-02-23', 41, '2023-03-06', '', 'finalizada'),
(176, 'FISCALIZAÇÃO', 21, '2023-02-24', '2024-02-23', 19, '2023-02-23', 41, '2023-03-06', '', 'finalizada'),
(177, 'FISCALIZAÇÃO', 26, '2023-09-02', '2024-09-01', 63, '2023-09-05', 164, '2023-09-06', 'Houve troca do suplente conforme Portaria nº 28/ACI, de 12 de março de 2024. 3S Sheylane no lugar da 3S Fernanda. Comissao finalizada para preservar histórico. Nova comissão ID 191.', 'finalizada'),
(178, 'RECEBIMENTO', 21, '2023-09-11', '2024-09-10', 64, '2023-09-11', 168, '2023-09-14', '', 'finalizada'),
(179, 'FISCALIZAÇÃO', 36, '2023-08-01', '2024-08-01', 59, '2023-07-18', 131, '2023-07-19', '', 'finalizada'),
(180, 'RECEBIMENTO', 36, '2023-08-01', '2024-08-01', 60, '2023-07-19', 133, '2023-07-24', '', 'finalizada'),
(181, 'FISCALIZAÇÃO', 32, '2023-11-01', '2024-10-31', 73, '2023-11-01', 208, '2023-11-17', 'Revoga a Portaria 102/ACI, de 05/12/2022.', 'finalizada'),
(182, 'FISCALIZAÇÃO', 31, '2023-11-30', '2024-11-29', 80, '2023-11-24', 218, '2023-12-04', 'Atualização em 1º de maio de 2024:\r\n- 3S Thamires no lugar do 1S Rigaud, conf. Portaria 45/ACI de 22/04/24, publ. no Bol Int nº 77, de 25/04/24.\r\n- Inclusão do AP Trajano na função de Fiscal Substituto, conf. Portaria 46/ACI, de 22/04/24, publ. no Bol Int nº 77, de 25/04/24. \r\n- entra 3S Jennifer sai 2S Bruno funcao de membro, conf. 111/ACI, DE 17/09/2024 e BOL 170, DE 17/09/2024. ', 'finalizada'),
(183, 'RECEBIMENTO', 31, '2023-11-30', '2024-11-29', 79, '2023-11-24', 218, '2023-12-04', '2S Rogélio dispensado a contar de 05/07/2024, conf Bol Int 197, de 05/11/2024.', 'finalizada'),
(184, 'RECEBIMENTO', 32, '2023-12-06', '2024-12-05', 84, '2023-12-05', 229, '2023-12-19', '', 'finalizada'),
(185, 'FISCALIZAÇÃO', 22, '2024-01-11', '2024-12-31', 1, '2024-01-12', 10, '2024-01-15', 'Vigência alterada para finalizar antes do CT 100/GAPGL/2024, que começa em 01/01/2025.', 'finalizada'),
(186, 'FISCALIZAÇÃO', 35, '2024-01-04', '2025-01-03', 2, '2024-01-04', 14, '2024-01-19', '', 'finalizada'),
(187, 'FISCALIZAÇÃO', 34, '2024-01-12', '2025-01-11', 4, '2024-01-11', 23, '2024-02-01', '', 'finalizada'),
(188, 'FISCALIZAÇÃO', 33, '2024-01-04', '2025-01-03', 5, '2024-01-23', 23, '2024-02-01', '', 'finalizada'),
(189, 'FISCALIZAÇÃO', 9, '2024-02-24', '2025-02-23', 10, '2024-02-19', 37, '2024-02-23', '', 'finalizada'),
(190, 'FISCALIZAÇÃO', 21, '2024-02-24', '2025-02-23', 9, '2024-02-19', 37, '2024-02-23', '', 'finalizada'),
(191, 'FISCALIZAÇÃO', 26, '2023-09-02', '2024-09-01', 63, '2023-09-05', 164, '2023-09-06', 'Substituição de suplente pela Portaria nº 28/ACI, de 12/03/2024. A contar de 1º de abril de 2024.', 'finalizada'),
(192, 'RECEBIMENTO', 24, '2024-05-17', '2025-02-19', 69, '2024-05-16', 96, '2024-05-23', 'Revoga a Portaria nº 60/ACI, de 13/05/2024. Revogada pela Portaria nº 10/ACI, de 17/02/2025.', 'revogada'),
(193, 'FISCALIZAÇÃO', 8, '2024-06-02', '2025-06-01', 79, '2024-06-19', 115, '2024-06-21', '', 'finalizada'),
(194, 'FISCALIZAÇÃO', 24, '2024-07-12', '2025-07-11', 93, '2024-07-08', 138, '2024-07-08', '', 'finalizada'),
(195, 'RECEBIMENTO', 22, '2024-07-11', '2024-12-31', 92, '2024-07-08', 138, '2024-07-25', 'Vigência alterada para finalizar antes do CT 100/GAPGL/2024, que começa em 01/01/2025.', 'finalizada'),
(196, 'FISCALIZAÇÃO', 26, '2024-09-02', '2025-09-01', 107, '2024-09-09', 165, '2024-09-09', '', 'finalizada'),
(197, 'FISCALIZAÇÃO', 39, '2024-07-16', '2025-07-15', 89, '2024-07-15', 133, '2024-07-17', 'Revogada pela Port. nº 31/ACI, de 16 de abril de 2025, a contar de 07 de abril de 2025.', 'revogada'),
(198, 'RECEBIMENTO', 39, '2024-07-16', '2025-07-15', 88, '2024-07-15', 133, '2024-07-17', '', 'finalizada'),
(199, 'FISCALIZAÇÃO', 40, '2024-05-02', '2025-05-01', 54, '2024-05-02', 83, '2024-05-06', '', 'finalizada'),
(200, 'RECEBIMENTO', 40, '2024-05-02', '2025-05-01', 53, '2024-05-02', 83, '2024-05-06', '', 'finalizada'),
(201, 'FISCALIZAÇÃO', 41, '2024-05-02', '2025-05-01', 52, '2024-05-02', 83, '2024-05-06', '', 'finalizada'),
(202, 'RECEBIMENTO', 41, '2024-05-02', '2025-05-02', 51, '2024-05-02', 83, '2024-05-06', '', 'finalizada'),
(203, 'FISCALIZAÇÃO', 43, '2024-08-13', '2025-08-12', 105, '2024-08-20', 154, '2024-08-20', '', 'finalizada'),
(204, 'FISCALIZAÇÃO', 44, '2024-09-26', '2025-09-25', 118, '2024-09-26', 175, '2024-09-26', '', 'finalizada'),
(205, 'RECEBIMENTO', 44, '2024-09-26', '2025-09-25', 117, '2024-09-26', 175, '2024-09-26', 'Revogada pela Port 74/ACI, de 14 de agosto de 2025.', 'revogada'),
(206, 'FISCALIZAÇÃO', 45, '2024-08-01', '2025-08-01', 98, '2024-01-08', 149, '2024-08-12', '', 'finalizada'),
(207, 'RECEBIMENTO', 45, '2024-08-01', '2025-08-01', 99, '2024-08-01', 149, '2024-08-12', '', 'finalizada'),
(208, 'FISCALIZAÇÃO', 46, '2024-09-19', '2025-09-18', 123, '2024-10-15', 187, '2024-10-17', 'Contrato sob demanda.Substituição do Cap QOINT CAIO ANTONIO ALMEIDA DA SILVA PEREIRA Nr ord 6482058 por AP QOCON CIV THAYANNE FERREIRA DOS SANTOS CORDEIRO Nr ord 7493924, como Fiscal, a contar de 02/05/2025, conf Port 37/ACI,de 08/05/2025.', 'finalizada'),
(209, 'FISCALIZAÇÃO', 47, '2024-09-19', '2025-09-18', 125, '2024-09-18', 187, '2024-10-17', 'Substituição do Cap QOINT CAIO ANTONIO ALMEIDA DA SILVA PEREIRA Nr ord 6482058 por AP QOCON CIV THAYANNE FERREIRA DOS SANTOS CORDEIRO Nr ord 7493924, como Fiscal, a contar de 02/05/2025, conf Port 38/ACI,de 08/05/2025.', 'finalizada'),
(210, 'RECEBIMENTO', 47, '2024-09-19', '2025-09-18', 124, '2024-09-18', 187, '2024-10-17', '', 'finalizada'),
(211, 'FISCALIZAÇÃO', 32, '2024-10-01', '2025-04-13', 131, '2024-10-31', 197, '2024-11-05', 'Revogada pela Port. 30/ACI, de  11/04/2025.', 'revogada'),
(212, 'RECEBIMENTO', 31, '2024-11-30', '2024-12-31', 142, '2024-11-29', 212, '2024-12-05', 'Vigência alterada para finalizar antes do CT 100/GAPGL/2024, que começa em 01/01/2025.', 'finalizada'),
(213, 'FISCALIZAÇÃO', 31, '2024-11-30', '2024-12-31', 141, '2024-11-29', 212, '2024-12-05', 'Vigência alterada para finalizar antes do CT 100/GAPGL/2024, que começa em 01/01/2025.', 'finalizada'),
(214, 'RECEBIMENTO', 32, '2024-12-06', '2025-12-05', 139, '2024-12-03', 212, '2024-12-05', '', 'vigente'),
(215, 'RECEBIMENTO', 49, '2025-01-01', '2025-12-19', 143, '2024-12-20', 225, '2024-12-26', 'Vigência inicial difere do que consta na portaria para adequação ao início da vigência contratual.', 'vigente'),
(216, 'FISCALIZAÇÃO', 49, '2025-01-01', '2025-12-19', 144, '2024-12-20', 225, '2024-12-26', 'Vigência inicial difere do que consta na portaria. Data foi alterada para adequação à vigência contratual.', 'vigente'),
(217, 'RECEBIMENTO', 48, '2025-01-01', '2025-12-19', 145, '2024-12-20', 225, '2024-12-26', 'Vigência inicial difere do que consta na portaria. Data foi alterada para adequação à vigência contratual.', 'vigente'),
(218, 'FISCALIZAÇÃO', 48, '2025-01-01', '2025-12-19', 146, '2024-12-20', 225, '2024-12-26', 'Vigência inicial difere do que consta na portaria. Data foi alterada para adequação à vigência contratual.', 'vigente'),
(219, 'FISCALIZAÇÃO', 32, '2025-04-14', '2026-01-31', 30, '2025-04-11', 70, '2025-04-15', 'Revoga a Port. 131/ACI, de 31/10/2024.', 'vigente'),
(220, 'RECEBIMENTO', 24, '2025-02-20', '2026-02-19', 10, '2025-02-17', 34, '2025-02-19', 'Revoga a Port. 69/ACI, de 16 de maio de 2024.', 'vigente'),
(221, 'FISCALIZAÇÃO', 38, '2025-01-02', '2026-01-01', 7, '2025-01-02', 32, '2025-02-17', 'Substituição 2T Ygor Costa no lugar do 2T Cândido, a contar de 30/04/2025, Conforme Port. 33/ACI, de 29 de abril de 2025.', 'finalizada'),
(222, 'RECEBIMENTO', 38, '2025-01-02', '2026-01-01', 8, '2025-01-02', 32, '2025-02-17', '', 'vigente'),
(223, 'FISCALIZAÇÃO', 39, '2025-04-07', '2026-04-06', 31, '2025-04-16', 72, '2025-04-17', 'Revoga a Port. nº 89/ACI, de 15 de julho de 2024.', 'vigente'),
(224, 'FISCALIZAÇÃO', 33, '2025-01-04', '2026-01-03', 149, '2024-12-23', 225, '2024-12-26', 'Troca de suplente a contar de 13/10/2025. 1S Pazini no lugar da 2S Andressa, conf. Portaria nº 91/ACI, de 8/10/2025 e Bol Int nº 189, de 15/10/2025.', 'revogada'),
(225, 'FISCALIZAÇÃO', 34, '2025-01-12', '2026-01-11', 147, '2024-12-23', 225, '2024-12-16', '', 'vigente'),
(226, 'FISCALIZAÇÃO', 50, '2025-05-02', '2026-05-01', 41, '2025-05-09', 84, '2025-05-13', '', 'vigente'),
(227, 'RECEBIMENTO', 50, '2025-05-02', '2026-05-01', 42, '2025-05-09', 84, '2025-05-13', '', 'vigente'),
(228, 'FISCALIZAÇÃO', 38, '2025-04-03', '2026-01-02', 7, '2025-02-01', 32, '2025-02-07', 'Substituição de Fiscal: 2T Ygor Costa no lugar do 2T Cândido, a contar de 30/04/2025, conf Port. 33/ACI, de 29/04/2025. Publicado Bol Int 78, de 05/05/2025.', 'vigente'),
(229, 'RECEBIMENTO', 45, '2025-08-02', '2026-08-01', 70, '2025-07-31', 137, '2025-08-01', '', 'vigente'),
(230, 'FISCALIZAÇÃO', 45, '2025-08-02', '2026-08-01', 69, '2025-07-31', 137, '2025-08-01', '', 'vigente'),
(231, 'RECEBIMENTO', 39, '2025-07-16', '2026-07-15', 71, '2025-07-15', 137, '2025-08-01', '', 'vigente'),
(232, 'RECEBIMENTO', 44, '2025-08-18', '2026-08-17', 74, '2025-08-14', 148, '2025-08-18', 'Revoga a Port 117/ACI, de 26 de setembro de 2024.', 'vigente'),
(233, 'FISCALIZAÇÃO', 43, '2025-08-13', '2026-08-12', 76, '2025-08-13', 155, '2025-08-27', '', 'vigente'),
(234, 'FISCALIZAÇÃO', 44, '2025-09-26', '2026-09-25', 87, '2025-09-17', 177, '2025-09-29', '', 'vigente'),
(235, 'FISCALIZAÇÃO', 51, '2025-07-25', '2026-07-24', 49, '2025-06-10', 104, '2025-06-16', '', 'vigente'),
(236, 'FISCALIZAÇÃO', 33, '2025-10-13', '2026-01-03', 91, '2025-10-08', 189, '2025-10-15', 'Não há.', 'vigente');

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `COMISSOES_INTEGRANTES`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `COMISSOES_INTEGRANTES` (
`anocont` year
,`idcom` int
,`idfuncao` int
,`inicio` date
,`nomeempresa` varchar(45)
,`nomefuncao` varchar(45)
,`nomegr` varchar(20)
,`nomepg` varchar(4)
,`numerocont` int
,`omcont` enum('GAPGL','GAPGL-PAGL','GAPRJ')
,`status` enum('vigente','finalizada','revogada')
,`termino` date
,`tipocom` enum('FISCALIZAÇÃO','RECEBIMENTO','FISCALIZAÇÃO OBRAS/SV ENGENHARIA','RECEBIMENTO EM DEFINITIVO')
,`tipocont` enum('receita','despesa')
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `COM_INTEG_AGRUP`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `COM_INTEG_AGRUP` (
`COMISSAO` varchar(111)
,`idcom` int
,`INTEGRANTE` varchar(73)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `COM_INTEG_AGRUP_1`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `COM_INTEG_AGRUP_1` (
`contrato` varchar(27)
,`empresa` varchar(45)
,`funcao` varchar(45)
,`id` int
,`idfuncao` int
,`militar` varchar(25)
,`tipo` enum('FISCALIZAÇÃO','RECEBIMENTO','FISCALIZAÇÃO OBRAS/SV ENGENHARIA','RECEBIMENTO EM DEFINITIVO')
,`tipocont` enum('receita','despesa')
);

-- --------------------------------------------------------

--
-- Estrutura da tabela `contratos`
--

CREATE TABLE `contratos` (
  `idcont` int NOT NULL,
  `idempresa` int NOT NULL,
  `numerocont` int NOT NULL,
  `omcont` enum('GAPGL','GAPGL-PAGL','GAPRJ') DEFAULT NULL,
  `anocont` year DEFAULT NULL,
  `tipocont` enum('receita','despesa') DEFAULT NULL,
  `vltotal` decimal(10,2) DEFAULT NULL,
  `objeto` varchar(200) DEFAULT NULL,
  `NUP` varchar(25) DEFAULT NULL,
  `vigencia_ini` date NOT NULL,
  `vigencia_fim` date NOT NULL,
  `obs` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contratos`
--

INSERT INTO `contratos` (`idcont`, `idempresa`, `numerocont`, `omcont`, `anocont`, `tipocont`, `vltotal`, `objeto`, `NUP`, `vigencia_ini`, `vigencia_fim`, `obs`) VALUES
(4, 9, 37, 'GAPGL-PAGL', 2019, 'despesa', '2030544.00', 'Limpeza e conservação em áreas administrativas externas - Vila SO/SGT', '67107.010989/2018-80', '2019-07-16', '2022-07-16', ''),
(5, 24, 80, 'GAPRJ', 2016, 'receita', '533833.44', 'Cessão onerosa de uso de área ao lado da PAGL, visando instalação de uma escola.', '67248.001767/2016-08', '2017-02-01', '2022-07-08', ''),
(6, 18, 74, 'GAPGL-PAGL', 2020, 'despesa', '580580.00', 'ADESÃO AO PREGÃO 054/GAP-BR/2019 - SERVIÇO DE CONFECÇÃO DE MOBILIÁRIO', '67107.006085/2020-74', '2020-11-19', '2021-11-19', ''),
(7, 22, 96, 'GAPRJ', 2016, 'receita', '438192.00', 'Cessão de uso onerosa da área situada na Rua Sargento José Sena Brasil, nº 2B, junto à Vila Residencial Fechada dos SO/SGT, visando à instalação de um CENTRO EDUCACIONAL', '67248.001767/2016-08', '2017-02-01', '2022-02-01', ''),
(8, 19, 16, 'GAPGL-PAGL', 2020, 'despesa', '51156.64', 'Contratação de serviços de telefonia fixa', '67107.021239/2019-14', '2020-06-01', '2022-06-01', ''),
(9, 9, 35, 'GAPGL-PAGL', 2019, 'despesa', '5454694.80', 'Contratação de serviços de limpeza e conservação de áreas internas e externas da PAGL, Vila dos Oficiais e COGAL', '67107.010989/2018-80', '2019-07-16', '2022-07-16', ''),
(10, 9, 38, 'GAPGL-PAGL', 2019, 'despesa', '1221555.56', 'Contratação de serviços de manutenção de áreas verdes para atender a demanda da Vila do SO/SGT do Galeão', '67107.010450/2018-21', '2019-07-16', '2022-07-16', ''),
(11, 10, 33, 'GAPGL-PAGL', 2019, 'despesa', '1280286.00', 'Serviços de recolhimento, de resíduos para a Vila Residencial dos SO/SGT', '67107.005495/2018-83', '2019-07-03', '2022-01-03', ''),
(12, 27, 9, 'GAPGL-PAGL', 2021, 'despesa', '1796293.28', 'Serviço comum de engenharia para reparo e conservação das instalações dos prédios residenciais multifamiliares existentes na Vila Militar dos SO/SGT do Galeão', '67107.010417/2018-09', '2021-05-03', '2021-11-29', ''),
(13, 27, 10, 'GAPGL-PAGL', 2021, 'despesa', '183364.00', 'Serviço comum de engenharia para reparo e conservação dos passeios de concreto existentes na Vila Militar dos Oficiais, Suboficiais e Sargentos situada na Av. sete', '67107.010417/2018-09', '2021-05-03', '2021-09-30', ''),
(14, 12, 18, 'GAPGL', 2017, 'despesa', NULL, 'FORNECIMENTO DE ÁGUA E ESGOTO PARA O EXERCÍCIO DE 2017', '67107.000732/2017-39', '2017-11-16', '2021-11-16', ''),
(15, 21, 76, 'GAPRJ', 2016, 'receita', '124480.33', 'CESSÃO DE USO A TÍTULO ONEROSO DE BEM IMÓVEL DA UNIÃO. (PAGL)', '67248.000756/2016-01', '2016-12-01', '2021-12-01', ''),
(16, 16, 4, 'GAPGL-PAGL', 2018, 'despesa', '81031.90', 'SERVIÇO DE LOCAÇÃO DE MÁQUINA COPIADO PARA O GAP GL E UNIDADES APOIADAS.', '67107.001813/2017-56', '2018-06-05', '2021-12-05', ''),
(17, 23, 18, 'GAPGL-PAGL', 2018, 'receita', '3059717.74', 'ARRENDAMENTO DE BEM IMÓVEL DA UNIÃO.', '67246.007825/2017-08', '2018-07-01', '2023-07-01', ''),
(18, 15, 21, 'GAPGL-PAGL', 2018, 'despesa', '25254.79', 'SERVIÇO DE LOCAÇÃO DE MÁQUINA COPIADO PARA O GAP GL E UNIDADES APOIADAS.', '67107.001813/2017-56', '2018-07-03', '2021-10-03', ''),
(19, 10, 34, 'GAPGL-PAGL', 2019, 'despesa', '911439.00', 'COLETA, TRANSPORTE E DESTINAÇÃO FINAL DE RESÍDUOS.', '67107.005495/2018-83', '2019-07-03', '2022-07-03', ''),
(20, 13, 34, 'GAPGL', 2017, 'despesa', '2403.82', 'FORNECIMENTO DE GAS NATURAL PARA O GAP GL E UNIDADES APOIADAS NO EXERCICIO DE 2017.', '67107.000733/2017-83', '2017-11-16', '2021-11-16', ''),
(21, 9, 36, 'GAPGL-PAGL', 2019, 'despesa', '1658694.40', 'SERVIÇO DE LIMPEZA E CONSERVAÇÃO DE ÁREAS VERDES', '67107.010450/2018-21', '2019-07-16', '2022-07-16', ''),
(22, 11, 38, 'GAPGL', 2017, 'despesa', '3600000.00', 'FORNECIMENTO DE ENERGIA ELETRICA PARA O GAP GL E UNIDADES APOIADAS NO EXERCICIO DE 2017.', '67107.000729/2017-15', '2017-11-16', '2021-11-16', ''),
(23, 20, 44, 'GAPGL-PAGL', 2019, 'receita', '40352.64', 'ARRENDAMENTO DE ÁREA LOCALIZADA NO COGAL (CENTRO SOCIAL DE OFICIAIS DA GUARNIÇÃO DO GALEÃO) NA VILA DE OFICIAIS DO GALEÃO, SITUADA NA PRAÇA DO AVIÃO, VISANDO INSTALAÇÃO DE CANTINA E LANCHONETE.', '67246.010516/2014-64', '2019-09-01', '2021-09-01', ''),
(24, 14, 18, 'GAPGL-PAGL', 2020, 'despesa', '28781.02', 'CONTRATAÇÃO DE TELEFONIA MOVEL', '67107.021241/2019-93', '2020-09-05', '2022-09-05', ''),
(25, 25, 34, 'GAPGL-PAGL', 2020, 'receita', '11760.00', 'INSTALAÇÃO DE LANCHONETE', '67107.025319/2019-49', '2020-10-03', '2021-10-03', ''),
(26, 26, 58, 'GAPGL-PAGL', 2020, 'receita', '34200.00', 'CESSÃO DE USO PARA INSTALAÇÃO DE ACADEMIA PARA PAGL', '67107.026012/2019-65', '2020-09-01', '2021-09-01', ''),
(27, 17, 84, 'GAPGL-PAGL', 2020, 'despesa', '409258.48', 'CONTRATAÇÃO DE EMPRESA DE ENGENHARIA PARA REALIZAÇÃO DE RECUPERAÇÃO DE PILARES DE SUSTENTAÇÃO', '67107.024481/2019-40', '2021-02-01', '2021-09-14', ''),
(29, 31, 60, 'GAPGL', 2020, 'despesa', NULL, NULL, NULL, '0000-00-00', '0000-00-00', ''),
(30, 32, 26, 'GAPGL-PAGL', 2021, 'despesa', '1727794.28', 'Contratação de serviços comuns de engenharia', '67107.006999/2020-35', '2021-09-22', '2022-04-22', ''),
(31, 34, 42, 'GAPGL', 2021, 'despesa', NULL, 'FORNECIMENTO DE ÁGUA E TRATAMENTO DE ESGOTO PARA O GAP-GL E UNIDADES APOIADAS', '67107.009351/2021-00', '2021-11-29', '2022-11-29', ''),
(32, 35, 27, 'GAPGL-PAGL', 2021, 'despesa', '74088.00', 'Prestação de serviços de outsourcing de impressão (impressão corporativa).', '67107.000130/2021-68', '2021-12-06', '2024-12-06', ''),
(33, 22, 4, 'GAPGL-PAGL', 2023, 'receita', '126579.72', 'Cessão onerosa de área para instalação de uma instituição de ensino', '67107.007410/2022-88', '2023-01-04', '2024-01-04', ''),
(34, 36, 7, 'GAPGL-PAGL', 2023, 'receita', '168215.84', 'Cessão onerosa de área para instalação de uma instituição de ensino.', '67107.003831/2022-30', '2023-01-12', '2024-01-12', ''),
(35, 21, 61, 'GAPGL-PAGL', 2022, 'receita', '34788.00', 'Cessao de uso de area para instalacao de um posto de atendimento para financiamentos.', '67107.008872/2022-12', '2023-01-04', '2024-01-04', ''),
(36, 37, 25, 'GAPGL-PAGL', 2023, 'despesa', '384000.00', 'Serviço de confecção, montagem e instalação de móveis sob medida, em atendimento às necessidades dos imóveis gerenciados pela Prefeitura de Aeronáutica do Galeão (PAGL)', '67107.004575/2022-06', '2023-08-01', '2024-08-01', ''),
(37, 37, 19, 'GAPGL-PAGL', 2023, 'despesa', '400000.00', 'Serviço de confecção, montagem e instalação de móveis sob medida.', '67107.004575/2022-06', '2024-08-01', '2025-08-01', ''),
(38, 38, 59, 'GAPGL-PAGL', 2024, 'despesa', '3996.00', 'Serviço de locação de softwares do módulo Orçafascio.', '67107.000789/2024-67', '2024-08-01', '2025-07-31', ''),
(39, 9, 49, 'GAPGL-PAGL', 2024, 'despesa', '422673.60', 'SERVIÇO DE LIMPEZA DAS ÁREAS INTERNAS E EXTERNAS PARA A PAGL.', '67107.005600/2024-22', '2024-07-16', '2025-07-15', ''),
(40, 39, 19, 'GAPGL-PAGL', 2024, 'despesa', NULL, 'Serviço de Revitalização das Fachadas dos Blocos Residenciais da Vila dos Graduados - Pintura', '67107.006883/2023-49', '2024-05-02', '2025-05-01', ''),
(41, 40, 20, 'GAPGL-PAGL', 2024, 'despesa', '141443.40', 'SERVIÇOS DE ENGENHARIA', '67107.006883/2023-49', '2024-05-02', '2025-05-02', ''),
(43, 23, 63, 'GAPGL-PAGL', 2024, 'receita', '690000.00', 'CESSÃO DE USO ONEROSA PARA FUNCIONAMENTO DE UM POSTO DE COMBUSTÍVEL NA PAGL.', '67107.005159/2023-06', '2024-08-13', '2025-08-12', ''),
(44, 10, 73, 'GAPGL-PAGL', 2024, 'despesa', '186325.90', 'SERVIÇO DE RECOLHIMENTO DE RESÍDUOS', '67107.000964/2024-16', '2024-09-26', '2025-09-25', ''),
(45, 37, 58, 'GAPGL-PAGL', 2024, 'despesa', '400000.00', 'Confecção, montagem e instalação de móveis sob medida para a PAGL.', '67107.004575/2022-06', '2024-08-01', '2025-08-01', ''),
(46, 42, 23, 'GAPGL', 2023, 'despesa', NULL, 'SERVIÇO DE MANUTENÇÃO DE EQUIPAMENTOS DE REFRIGERAÇÃO.', '67107.007149/2022-16', '2023-09-18', '2025-09-18', 'Contrato sob demanda.'),
(47, 43, 30, 'GAPGL', 2023, 'despesa', NULL, 'Serviços de manutenção de equipamentos de refrigeração.', '67107.007149/2022-16', '2024-09-18', '2025-09-18', 'Contrato sob demanda.'),
(48, 34, 110, 'GAPGL', 2024, 'despesa', NULL, 'Fornecimento de agua e tratamento de esgoto.', '67107.008755/2024-11', '2025-01-01', '2026-01-01', 'Contrato sob gestão do GAP-GL. Fiscalização setorial.'),
(49, 11, 100, 'GAPGL', 2024, 'despesa', NULL, 'Fornecimento de energia elétrica para o GAP-GL e unidades apoiadas.', '67107.007789/2024-98', '2025-01-01', '2026-01-01', 'Contrato sob gestão do GAP-GL. Fiscalização setorial.'),
(50, 44, 68, 'GAPGL-PAGL', 2024, 'despesa', '327551.20', 'SERVIÇO ESPECIALIZADO DE PODA DE ÁRVORE PARA A PAGL.', '67107.007187/2024-31', '2024-01-10', '2025-01-10', ''),
(51, 45, 50, 'GAPGL-PAGL', 2025, 'receita', '59393.88', NULL, '67107.004975/2025-56', '2025-07-25', '2026-07-24', 'Não há');

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `CONTRATOS_LANCADOS_VW`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `CONTRATOS_LANCADOS_VW` (
`anocont` year
,`idcont` int
,`nomeempresa` varchar(45)
,`numerocont` int
,`omcont` enum('GAPGL','GAPGL-PAGL','GAPRJ')
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `CONT_AGRUP`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `CONT_AGRUP` (
`CONTRATO` varchar(75)
,`idcom` int
,`tipocom` enum('FISCALIZAÇÃO','RECEBIMENTO','FISCALIZAÇÃO OBRAS/SV ENGENHARIA','RECEBIMENTO EM DEFINITIVO')
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `CONT_AGRUP1`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `CONT_AGRUP1` (
`CONTRATO` varchar(75)
,`idcom` int
,`tipocom` enum('FISCALIZAÇÃO','RECEBIMENTO','FISCALIZAÇÃO OBRAS/SV ENGENHARIA','RECEBIMENTO EM DEFINITIVO')
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `CONT_AGRUP2`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `CONT_AGRUP2` (
`CONTRATO` varchar(73)
,`idcom` int
,`tipocom` enum('FISCALIZAÇÃO','RECEBIMENTO','FISCALIZAÇÃO OBRAS/SV ENGENHARIA','RECEBIMENTO EM DEFINITIVO')
);

-- --------------------------------------------------------

--
-- Estrutura da tabela `empresas`
--

CREATE TABLE `empresas` (
  `idempresa` int NOT NULL,
  `CNPJ` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `nomeempresa` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `empresas`
--

INSERT INTO `empresas` (`idempresa`, `CNPJ`, `nomeempresa`) VALUES
(9, '05.703.030/0001-88', 'CARDEAL'),
(10, NULL, 'LANDTEC'),
(11, NULL, 'LIGHT'),
(12, NULL, 'CEDAE'),
(13, NULL, 'NATURGY'),
(14, NULL, 'TELEFÔNICA BRASIL'),
(15, NULL, 'SIMPRESS'),
(16, NULL, 'CS & CS'),
(17, NULL, 'CABB ENGENHARIA'),
(18, '09.813.581/0001-55', 'FORMA OFFICE'),
(19, '40.432.544/0001-47', 'CLARO'),
(20, NULL, 'ENI RIEGER'),
(21, '00.643.742/0001-35', 'FHE'),
(22, '02.816.675/0001-39', 'GULLIVER'),
(23, NULL, 'POSTO CANÁRIAS'),
(24, '26.714.977/0001-64', 'GALEÃO COLÉGIO E CURSO'),
(25, NULL, 'QUATRO AMIGOS'),
(26, NULL, 'ACADEMIA DA VILA'),
(27, '10.284.045/0001-99', 'NF COMERCIO E SERVICOS'),
(29, NULL, 'NAO SE APLICA'),
(31, NULL, 'BURTONTEC CONSTRUÇÕES EIRELI'),
(32, '04.953.896/0001-84', 'METSOM CONSTRUÇÕES LTDA'),
(34, '10.287.202/0001-10', 'AGUAS DO RIO'),
(35, '02.478.800/0001-48', 'CHADA'),
(36, '43.435.769/0001-45', 'COLEGIO E CURSO OBEDE DOM LTDA'),
(37, '21.366.381/0001-05', 'ESTILO DESIGN SERVICOS LTDA'),
(38, '23.484.444/0001-45', '3F LTDA'),
(39, NULL, 'FEMAR CONSTRUCOES LTDA'),
(40, NULL, 'MEGA ENGENHARIA'),
(42, NULL, 'PATAGONIA COM E SERV TECNICOS LTDA ME'),
(43, '03.282.047/0001-83', 'TOTAL LINE COMERCIO E SERVICOS LTDA'),
(44, NULL, 'FCA ENGENHARIA E CONSTRUÇÃO'),
(45, '53.618.748/0001-19', 'A. SILVA MACIEL RESTAURANTE E LANCHONETE LTDA');

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `FISCAIS E PRESIDENTES`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `FISCAIS E PRESIDENTES` (
`comissão - tipo` enum('FISCALIZAÇÃO','RECEBIMENTO','FISCALIZAÇÃO OBRAS/SV ENGENHARIA','RECEBIMENTO EM DEFINITIVO')
,`contrato` varchar(27)
,`contrato - tipo` enum('receita','despesa')
,`empresa` varchar(45)
,`funcao` varchar(45)
,`militar` varchar(25)
);

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcoes`
--

CREATE TABLE `funcoes` (
  `idfuncao` int NOT NULL,
  `nomefuncao` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `funcoes`
--

INSERT INTO `funcoes` (`idfuncao`, `nomefuncao`) VALUES
(17, 'Fiscal'),
(18, '1º Suplente - Fiscal'),
(19, '2º Suplente - Fiscal'),
(20, 'Presidente'),
(21, '1º Suplente - Presidente'),
(22, '2º Suplente - Presidente'),
(23, 'Membro'),
(24, 'Membro Suplente'),
(25, 'Membro Técnico'),
(26, 'Membro Administrativo');

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `ID_CONTRATOS`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `ID_CONTRATOS` (
`anocont` year
,`idcont` int
,`nomeempresa` varchar(45)
,`numerocont` int
,`omcont` enum('GAPGL','GAPGL-PAGL','GAPRJ')
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `INFO_COMISSAO`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `INFO_COMISSAO` (
`anocont` year
,`idcom` int
,`nomeempresa` varchar(45)
,`numerocont` int
,`status` enum('vigente','finalizada','revogada')
,`tipocom` enum('FISCALIZAÇÃO','RECEBIMENTO','FISCALIZAÇÃO OBRAS/SV ENGENHARIA','RECEBIMENTO EM DEFINITIVO')
,`tipocont` enum('receita','despesa')
,`vigencia_fim` date
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `INTEG_FUNC_AGRUP`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `INTEG_FUNC_AGRUP` (
);

-- --------------------------------------------------------

--
-- Estrutura da tabela `militares`
--

CREATE TABLE `militares` (
  `idmilitar` int NOT NULL,
  `idpg` int NOT NULL,
  `nomemil` varchar(45) DEFAULT NULL,
  `nomegr` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `militares`
--

INSERT INTO `militares` (`idmilitar`, `idpg`, `nomemil`, `nomegr`) VALUES
(8, 40, 'VINÍCIUS SILVA CARDOSO', 'CARDOSO'),
(9, 40, 'LEANDRO GALDINO DA SILVA', 'GALDINO'),
(10, 40, 'REJANE RIBEIRO DO ESPÍRITO SANTO CANTELLE', 'REJANE'),
(11, 45, 'KILSSA KARLA FALCK SOBRAL AUGUSTO', 'KILSSA'),
(12, 46, 'SHEYLANE PINHEIRO DA SILVA', 'SHEYLANE'),
(13, 45, 'AIRTON DA CRUZ MARTINS', 'AIRTON'),
(14, 41, 'EDUARDO VENITE LIMA', 'VENITE'),
(15, 45, 'THAIS DA SILVA TEIXEIRA', 'THAIS'),
(16, 45, 'HUMBERTO ROGELIO DOS SANTOS NUNES', 'ROGELIO'),
(17, 45, 'LEONARDO GOMES DA SILVA', 'GOMES'),
(18, 40, 'MAISA SOARES SILVA THYS', 'MAISA'),
(19, 46, 'MARCIO MIRANDA DA SILVEIRA', 'MARCIO MIRANDA'),
(20, 45, 'THAIANE MENEZES DE SOUZA', 'THAIANE'),
(21, 41, 'RAIANY RODRIGUES SIQUEIRA', 'RAIANY'),
(22, 43, 'FERNANDO LIBORIO DOS REIS', 'LIBORIO'),
(23, 45, 'ANDERSON DE SENA ABDIAS', 'ABDIAS'),
(24, 41, 'EMANUELLE CAVALCANTE DA SILVA RODRIGUES', 'EMANUELLE RODRIGUES'),
(25, 45, 'PAULA CRISTINA ROCHA SANTOS VIEIRA', 'PAULA'),
(26, 45, 'RODRIGO AZEREDO SARAIVA', 'AZEREDO'),
(27, 45, 'BRUNO DA SILVA SANTOS', 'BRUNO SILVA'),
(28, 37, 'JOSE ALFREDO REZENDE SILVA', 'REZENDE'),
(29, 43, 'ALEXANDER BASTOS DE PINA', 'PINA'),
(30, 40, 'ADRIANO LARANJEIRA PANICHI', 'PANICHI'),
(31, 46, 'CINTIA LUIZ GEREMIAS', 'CINTIA GEREMIAS'),
(32, 46, 'MARCELO SILVA DA COSTA', 'COSTA'),
(33, 46, 'BRUNA GIBSON DE LUCA', 'DE LUCA'),
(34, 39, 'LOURIVAL VIEIRA RANSATTO', 'RANSATTO'),
(35, 41, 'CHRISTIANO TAVARES DA SILVA PINTO', 'CHRISTIANO'),
(36, 43, 'JULIO FONSECA DA COSTA', 'JULIO'),
(37, 45, 'WILLIAN CHAVES MENEZES', 'MENEZES'),
(38, 46, 'TATIANE FREIRE GOULART COELHO', 'TATIANE'),
(39, 46, 'MARCELO DA COSTA DRUMOND', 'DRUMOND'),
(40, 44, 'CAMILA PAZINI PASSOS', 'PAZINI'),
(41, 44, 'CLAUDIA REGINA SILVA DE MENEZES', 'CLAUDIA'),
(42, 44, 'KARLA CRISTINA DOS SANTOS', 'KARLA CRISTINA'),
(43, 44, 'LUIZ JULIO RIGAUD NETO', 'RIGAUD'),
(44, 45, 'CHARLES GOMEZ DA SILVA', 'CHARLES'),
(45, 43, 'DOUGLAS MACIEL DE LIMA', 'MACIEL'),
(46, 46, 'PEDRO PAULO DANTAS E SILVA', 'DANTAS'),
(47, 43, 'CASSIO AUGUSTO PINHEIRO DE OLIVEIRA', 'CASSIO'),
(48, 41, 'MAURICIO CHAMPION BALLALAI', 'BALLALAI'),
(55, 46, 'FERNANDA DOS SANTOS GOMES', 'FERNANDA'),
(56, 42, 'PAULA LETICIA TISSEI', 'TISSEI'),
(59, 46, 'JULIA FERNANDA JACQUES DE MENDONÇA', 'JULIA MENDONÇA'),
(60, 41, 'ISABELLA DA SILVA VICENTE', 'ISABELLA VICENTE'),
(61, 45, 'CALVIN SEMIAO DOMINGUES', 'CALVIN'),
(62, 40, 'LUIS FELIPE MARTINS DIAS', 'MARTINS'),
(63, 46, 'JONATHAS DOS ANJOS ALMEIDA', 'J. ALMEIDA'),
(64, 41, 'CARLOS BARROS CANDIDO', 'CANDIDO'),
(65, 46, 'DOUGLAS ONORIO MARTINS', 'ONORIO'),
(66, 45, 'ANDRESSA RODRIGUES DINIZ', 'ANDRESSA'),
(67, 46, 'THAMIRES DOS SANTOS XAVIER', 'THAMIRES'),
(68, 46, 'MATHEUS DE FRANÇA', 'MATHEUS FRANÇA'),
(69, 46, 'VICTOR HUGO PEREIRA VILETE', 'VILETE'),
(70, 41, 'JERRY GLEY AUGUSTO TRAJANO', 'TRAJANO'),
(71, 46, 'JENNIFER CRUZ DE SOUZA', 'JENNIFER'),
(72, 39, 'CAIO ANTONIO A. DA SILVA PEREIRA', 'CAIO'),
(73, 46, 'LUCIANO MIRANDA DA SILVA', 'MIRANDA'),
(74, 43, 'FABIO ALEXANDRE MAC DOWELL', 'MAC DOWELL'),
(75, 43, 'ROBERTO RODRIGUES DE ALBUQUERQUE', 'ALBUQUERQUE'),
(76, 40, 'GUSTAVO CEZAR DE OLIVEIRA', 'GUSTAVO CEZAR'),
(77, 44, 'ISABELLE BARRETO DE PAULA', 'ISABELLE'),
(78, 42, 'THAYANNE FERREIRA DOS SANTOS CORDEIRO', 'T. CORDEIRO'),
(79, 41, 'YGOR MALCHER DOS SANTOS COSTA', 'YGOR COSTA'),
(80, 41, 'PAMELLA CAVALCANTE LOPES MACHADO', 'PAMELLA');

-- --------------------------------------------------------

--
-- Estrutura da tabela `militares_has_comissoes`
--

CREATE TABLE `militares_has_comissoes` (
  `idcom` int NOT NULL,
  `idmilitar` int NOT NULL,
  `idfuncao` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `militares_has_comissoes`
--

INSERT INTO `militares_has_comissoes` (`idcom`, `idmilitar`, `idfuncao`) VALUES
(1, 36, 17),
(2, 41, 17),
(3, 42, 17),
(4, 43, 17),
(5, 40, 17),
(6, 8, 17),
(7, 10, 17),
(8, 21, 17),
(9, 10, 17),
(10, 18, 17),
(11, 14, 17),
(12, 9, 17),
(13, 9, 17),
(14, 22, 17),
(15, 28, 17),
(16, 9, 17),
(17, 28, 17),
(18, 9, 17),
(19, 45, 17),
(20, 18, 17),
(21, 21, 17),
(22, 8, 17),
(23, 28, 17),
(24, 28, 17),
(109, 43, 17),
(112, 28, 17),
(114, 8, 17),
(115, 13, 17),
(116, 14, 17),
(120, 60, 17),
(122, 8, 17),
(123, 10, 17),
(125, 40, 17),
(126, 10, 17),
(127, 62, 17),
(128, 28, 17),
(129, 62, 17),
(130, 9, 17),
(133, 28, 17),
(137, 18, 17),
(140, 36, 17),
(141, 61, 17),
(147, 18, 17),
(149, 10, 17),
(150, 26, 17),
(151, 9, 17),
(152, 9, 17),
(153, 44, 17),
(157, 10, 17),
(159, 60, 17),
(163, 10, 17),
(164, 61, 17),
(165, 13, 17),
(166, 37, 17),
(167, 64, 17),
(168, 18, 17),
(170, 26, 17),
(173, 18, 17),
(176, 62, 17),
(177, 44, 17),
(179, 60, 17),
(181, 36, 17),
(182, 62, 17),
(185, 70, 17),
(186, 37, 17),
(187, 13, 17),
(188, 61, 17),
(189, 62, 17),
(190, 62, 17),
(191, 44, 17),
(193, 18, 17),
(194, 18, 17),
(196, 44, 17),
(197, 72, 17),
(198, 70, 17),
(199, 64, 17),
(201, 64, 17),
(203, 27, 17),
(204, 72, 17),
(206, 64, 17),
(208, 78, 17),
(209, 78, 17),
(211, 36, 17),
(213, 62, 17),
(216, 70, 17),
(218, 62, 17),
(219, 36, 17),
(221, 64, 17),
(223, 76, 17),
(224, 77, 17),
(225, 13, 17),
(226, 70, 17),
(228, 79, 17),
(230, 64, 17),
(233, 27, 17),
(234, 70, 17),
(235, 74, 17),
(236, 77, 17),
(1, 38, 18),
(2, 11, 18),
(3, 13, 18),
(4, 37, 18),
(5, 25, 18),
(7, 35, 18),
(8, 8, 18),
(9, 24, 18),
(10, 24, 18),
(11, 21, 18),
(12, 18, 18),
(13, 18, 18),
(14, 33, 18),
(15, 18, 18),
(16, 18, 18),
(17, 18, 18),
(18, 18, 18),
(19, 19, 18),
(20, 9, 18),
(21, 10, 18),
(109, 37, 18),
(115, 42, 18),
(116, 21, 18),
(120, 9, 18),
(122, 56, 18),
(123, 8, 18),
(125, 59, 18),
(126, 8, 18),
(127, 18, 18),
(128, 18, 18),
(129, 18, 18),
(130, 18, 18),
(137, 60, 18),
(140, 38, 18),
(141, 11, 18),
(147, 24, 18),
(149, 24, 18),
(150, 38, 18),
(151, 18, 18),
(152, 18, 18),
(153, 55, 18),
(157, 9, 18),
(159, 9, 18),
(163, 9, 18),
(164, 11, 18),
(165, 42, 18),
(166, 63, 18),
(167, 10, 18),
(168, 60, 18),
(170, 59, 18),
(173, 62, 18),
(176, 18, 18),
(177, 55, 18),
(179, 64, 18),
(181, 45, 18),
(182, 70, 18),
(185, 64, 18),
(186, 63, 18),
(187, 38, 18),
(188, 11, 18),
(189, 18, 18),
(190, 18, 18),
(191, 12, 18),
(193, 70, 18),
(194, 62, 18),
(196, 12, 18),
(197, 18, 18),
(198, 64, 18),
(203, 73, 18),
(204, 70, 18),
(208, 64, 18),
(209, 64, 18),
(211, 45, 18),
(213, 70, 18),
(216, 64, 18),
(218, 70, 18),
(219, 74, 18),
(223, 70, 18),
(224, 66, 18),
(225, 67, 18),
(226, 18, 18),
(233, 73, 18),
(234, 80, 18),
(235, 68, 18),
(236, 40, 18),
(6, 10, 19),
(11, 9, 19),
(15, 8, 19),
(16, 21, 19),
(17, 8, 19),
(18, 21, 19),
(116, 9, 19),
(120, 56, 19),
(122, 24, 19),
(127, 8, 19),
(128, 8, 19),
(129, 24, 19),
(130, 24, 19),
(159, 62, 19),
(176, 64, 19),
(189, 70, 19),
(190, 70, 19),
(197, 70, 19),
(28, 21, 20),
(29, 24, 20),
(91, 24, 20),
(92, 18, 20),
(93, 10, 20),
(94, 10, 20),
(95, 8, 20),
(97, 24, 20),
(99, 9, 20),
(100, 10, 20),
(101, 9, 20),
(102, 10, 20),
(103, 21, 20),
(104, 28, 20),
(105, 18, 20),
(106, 30, 20),
(107, 30, 20),
(108, 18, 20),
(110, 30, 20),
(111, 30, 20),
(113, 30, 20),
(117, 24, 20),
(118, 10, 20),
(119, 10, 20),
(121, 24, 20),
(124, 24, 20),
(134, 30, 20),
(135, 30, 20),
(136, 24, 20),
(138, 10, 20),
(139, 10, 20),
(142, 24, 20),
(143, 9, 20),
(144, 9, 20),
(145, 24, 20),
(146, 10, 20),
(148, 18, 20),
(154, 10, 20),
(155, 10, 20),
(156, 24, 20),
(158, 24, 20),
(162, 62, 20),
(169, 64, 20),
(171, 18, 20),
(172, 10, 20),
(174, 60, 20),
(175, 62, 20),
(178, 64, 20),
(180, 62, 20),
(183, 18, 20),
(184, 62, 20),
(192, 70, 20),
(195, 18, 20),
(200, 72, 20),
(202, 72, 20),
(205, 64, 20),
(207, 62, 20),
(210, 70, 20),
(212, 18, 20),
(214, 62, 20),
(215, 18, 20),
(217, 18, 20),
(220, 70, 20),
(222, 75, 20),
(227, 79, 20),
(229, 62, 20),
(231, 70, 20),
(232, 64, 20),
(28, 24, 21),
(29, 21, 21),
(91, 8, 21),
(92, 14, 21),
(93, 8, 21),
(94, 8, 21),
(95, 9, 21),
(97, 10, 21),
(99, 14, 21),
(100, 14, 21),
(101, 14, 21),
(102, 14, 21),
(103, 24, 21),
(104, 8, 21),
(117, 8, 21),
(118, 8, 21),
(119, 8, 21),
(121, 56, 21),
(124, 14, 21),
(136, 10, 21),
(138, 14, 21),
(139, 14, 21),
(142, 10, 21),
(143, 60, 21),
(144, 60, 21),
(145, 60, 21),
(146, 60, 21),
(148, 60, 21),
(154, 18, 21),
(155, 60, 21),
(156, 62, 21),
(158, 18, 21),
(162, 18, 21),
(169, 10, 21),
(172, 60, 21),
(174, 10, 21),
(175, 18, 21),
(178, 60, 21),
(180, 18, 21),
(183, 64, 21),
(184, 18, 21),
(192, 64, 21),
(195, 62, 21),
(200, 70, 21),
(202, 70, 21),
(205, 62, 21),
(207, 18, 21),
(210, 45, 21),
(212, 64, 21),
(214, 18, 21),
(215, 62, 21),
(217, 64, 21),
(220, 64, 21),
(222, 36, 21),
(227, 64, 21),
(229, 18, 21),
(231, 64, 21),
(232, 62, 21),
(28, 14, 22),
(29, 14, 22),
(91, 10, 22),
(92, 9, 22),
(93, 35, 22),
(94, 35, 22),
(95, 10, 22),
(97, 18, 22),
(99, 10, 22),
(100, 8, 22),
(101, 10, 22),
(102, 8, 22),
(104, 24, 22),
(117, 10, 22),
(118, 24, 22),
(119, 24, 22),
(136, 18, 22),
(138, 8, 22),
(139, 8, 22),
(143, 10, 22),
(144, 10, 22),
(145, 10, 22),
(146, 9, 22),
(148, 9, 22),
(155, 9, 22),
(158, 10, 22),
(172, 64, 22),
(175, 64, 22),
(178, 10, 22),
(6, 44, 23),
(6, 46, 23),
(7, 44, 23),
(7, 46, 23),
(8, 23, 23),
(8, 27, 23),
(9, 33, 23),
(9, 39, 23),
(10, 16, 23),
(10, 23, 23),
(11, 19, 23),
(12, 27, 23),
(12, 37, 23),
(13, 27, 23),
(13, 37, 23),
(15, 11, 23),
(15, 33, 23),
(16, 11, 23),
(16, 33, 23),
(17, 11, 23),
(17, 33, 23),
(18, 11, 23),
(18, 33, 23),
(20, 26, 23),
(20, 27, 23),
(21, 26, 23),
(21, 37, 23),
(23, 12, 23),
(23, 16, 23),
(24, 12, 23),
(24, 16, 23),
(28, 19, 23),
(28, 41, 23),
(29, 19, 23),
(29, 41, 23),
(91, 12, 23),
(91, 15, 23),
(91, 16, 23),
(91, 33, 23),
(91, 39, 23),
(92, 16, 23),
(92, 19, 23),
(93, 12, 23),
(93, 20, 23),
(94, 12, 23),
(94, 20, 23),
(95, 11, 23),
(95, 12, 23),
(97, 11, 23),
(97, 17, 23),
(99, 15, 23),
(99, 16, 23),
(100, 12, 23),
(100, 15, 23),
(101, 15, 23),
(101, 16, 23),
(102, 12, 23),
(102, 15, 23),
(103, 15, 23),
(103, 23, 23),
(104, 15, 23),
(104, 23, 23),
(106, 31, 23),
(106, 32, 23),
(107, 31, 23),
(107, 32, 23),
(110, 29, 23),
(110, 31, 23),
(110, 33, 23),
(111, 29, 23),
(111, 31, 23),
(111, 33, 23),
(112, 12, 23),
(112, 16, 23),
(113, 29, 23),
(113, 31, 23),
(114, 13, 23),
(114, 23, 23),
(116, 19, 23),
(116, 55, 23),
(117, 12, 23),
(117, 16, 23),
(117, 33, 23),
(117, 39, 23),
(118, 12, 23),
(118, 16, 23),
(119, 12, 23),
(119, 16, 23),
(120, 19, 23),
(120, 55, 23),
(121, 12, 23),
(121, 33, 23),
(122, 15, 23),
(122, 27, 23),
(123, 27, 23),
(123, 44, 23),
(124, 17, 23),
(124, 19, 23),
(126, 27, 23),
(126, 39, 23),
(127, 33, 23),
(127, 39, 23),
(128, 33, 23),
(128, 39, 23),
(129, 33, 23),
(129, 39, 23),
(130, 33, 23),
(130, 39, 23),
(133, 12, 23),
(133, 16, 23),
(134, 29, 23),
(134, 31, 23),
(135, 29, 23),
(135, 31, 23),
(136, 11, 23),
(136, 17, 23),
(137, 26, 23),
(137, 27, 23),
(138, 12, 23),
(138, 15, 23),
(139, 12, 23),
(139, 15, 23),
(139, 17, 23),
(142, 12, 23),
(142, 33, 23),
(143, 16, 23),
(143, 17, 23),
(143, 59, 23),
(144, 16, 23),
(144, 17, 23),
(144, 59, 23),
(145, 12, 23),
(145, 16, 23),
(145, 33, 23),
(145, 59, 23),
(146, 11, 23),
(146, 12, 23),
(146, 16, 23),
(147, 20, 23),
(147, 44, 23),
(148, 16, 23),
(148, 33, 23),
(148, 59, 23),
(149, 19, 23),
(149, 20, 23),
(151, 27, 23),
(151, 37, 23),
(152, 27, 23),
(152, 37, 23),
(154, 11, 23),
(154, 17, 23),
(155, 12, 23),
(155, 15, 23),
(156, 17, 23),
(156, 37, 23),
(156, 63, 23),
(157, 27, 23),
(157, 39, 23),
(158, 12, 23),
(158, 16, 23),
(158, 33, 23),
(158, 39, 23),
(158, 63, 23),
(159, 37, 23),
(159, 55, 23),
(162, 17, 23),
(162, 37, 23),
(162, 63, 23),
(163, 27, 23),
(163, 39, 23),
(167, 46, 23),
(167, 65, 23),
(168, 66, 23),
(169, 12, 23),
(169, 33, 23),
(169, 67, 23),
(171, 16, 23),
(171, 33, 23),
(171, 59, 23),
(172, 11, 23),
(172, 12, 23),
(172, 16, 23),
(173, 20, 23),
(174, 16, 23),
(174, 17, 23),
(174, 59, 23),
(175, 33, 23),
(175, 39, 23),
(176, 33, 23),
(176, 39, 23),
(178, 12, 23),
(178, 59, 23),
(178, 68, 23),
(179, 33, 23),
(179, 38, 23),
(179, 68, 23),
(180, 59, 23),
(180, 63, 23),
(180, 67, 23),
(181, 27, 23),
(181, 39, 23),
(182, 67, 23),
(182, 71, 23),
(183, 12, 23),
(183, 63, 23),
(183, 68, 23),
(183, 69, 23),
(184, 17, 23),
(184, 63, 23),
(184, 68, 23),
(185, 46, 23),
(185, 68, 23),
(189, 42, 23),
(189, 66, 23),
(190, 42, 23),
(190, 66, 23),
(192, 11, 23),
(192, 12, 23),
(192, 16, 23),
(193, 20, 23),
(193, 66, 23),
(194, 20, 23),
(194, 43, 23),
(195, 33, 23),
(195, 42, 23),
(195, 59, 23),
(197, 42, 23),
(197, 66, 23),
(198, 17, 23),
(198, 59, 23),
(198, 63, 23),
(199, 12, 23),
(199, 33, 23),
(200, 68, 23),
(200, 69, 23),
(201, 12, 23),
(201, 33, 23),
(202, 68, 23),
(202, 69, 23),
(204, 40, 23),
(204, 45, 23),
(205, 23, 23),
(205, 38, 23),
(205, 46, 23),
(206, 33, 23),
(206, 38, 23),
(206, 68, 23),
(207, 59, 23),
(207, 63, 23),
(207, 67, 23),
(208, 42, 23),
(208, 66, 23),
(209, 42, 23),
(209, 66, 23),
(210, 38, 23),
(210, 59, 23),
(210, 67, 23),
(211, 23, 23),
(211, 73, 23),
(212, 12, 23),
(212, 63, 23),
(212, 66, 23),
(212, 68, 23),
(212, 69, 23),
(213, 67, 23),
(213, 71, 23),
(213, 73, 23),
(214, 63, 23),
(214, 68, 23),
(214, 71, 23),
(215, 33, 23),
(215, 42, 23),
(215, 59, 23),
(216, 46, 23),
(216, 68, 23),
(217, 12, 23),
(217, 63, 23),
(217, 66, 23),
(217, 68, 23),
(217, 69, 23),
(218, 67, 23),
(218, 71, 23),
(218, 73, 23),
(219, 23, 23),
(219, 73, 23),
(220, 15, 23),
(220, 40, 23),
(220, 45, 23),
(221, 33, 23),
(221, 38, 23),
(221, 68, 23),
(222, 20, 23),
(222, 59, 23),
(222, 63, 23),
(223, 42, 23),
(223, 45, 23),
(226, 42, 23),
(226, 66, 23),
(227, 17, 23),
(227, 59, 23),
(227, 63, 23),
(228, 33, 23),
(228, 38, 23),
(228, 68, 23),
(229, 59, 23),
(229, 63, 23),
(229, 67, 23),
(230, 33, 23),
(230, 68, 23),
(230, 73, 23),
(231, 17, 23),
(231, 59, 23),
(231, 63, 23),
(232, 42, 23),
(232, 43, 23),
(232, 59, 23),
(234, 11, 23),
(234, 40, 23),
(11, 25, 24),
(15, 39, 24),
(16, 39, 24),
(17, 39, 24),
(18, 39, 24),
(23, 29, 24),
(24, 29, 24),
(28, 17, 24),
(29, 17, 24),
(92, 20, 24),
(93, 16, 24),
(94, 16, 24),
(95, 13, 24),
(97, 16, 24),
(99, 17, 24),
(100, 17, 24),
(101, 17, 24),
(102, 17, 24),
(103, 25, 24),
(104, 25, 24),
(106, 33, 24),
(107, 33, 24),
(113, 33, 24),
(117, 15, 24),
(118, 20, 24),
(119, 20, 24),
(121, 15, 24),
(124, 42, 24),
(133, 29, 24),
(134, 33, 24),
(135, 33, 24),
(136, 16, 24),
(138, 17, 24),
(142, 15, 24),
(154, 16, 24),
(155, 17, 24),
(168, 27, 24),
(22, 13, 25),
(108, 48, 25),
(22, 23, 26),
(105, 10, 26),
(108, 10, 26),
(171, 60, 61);

-- --------------------------------------------------------

--
-- Estrutura da tabela `posto_grad`
--

CREATE TABLE `posto_grad` (
  `idpg` int NOT NULL,
  `nomepg` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `posto_grad`
--

INSERT INTO `posto_grad` (`idpg`, `nomepg`) VALUES
(36, 'Cel'),
(37, 'TCel'),
(38, 'Maj'),
(39, 'Cap'),
(40, '1T'),
(41, '2T'),
(42, 'Asp'),
(43, 'SO'),
(44, '1S'),
(45, '2S'),
(46, '3S'),
(47, 'Cb');

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `PRE_INFO_COM`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `PRE_INFO_COM` (
`idcom` int
,`idcont` int
,`idempresa` int
,`numerocont` int
,`status` enum('vigente','finalizada','revogada')
,`tipocom` enum('FISCALIZAÇÃO','RECEBIMENTO','FISCALIZAÇÃO OBRAS/SV ENGENHARIA','RECEBIMENTO EM DEFINITIVO')
,`tipocont` enum('receita','despesa')
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `PRE_VIEW_COM`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `PRE_VIEW_COM` (
`contratos_idcont` int
,`idcom` int
,`idfuncao` int
,`idmilitar` int
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `PRE_VIEW_COM_1`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `PRE_VIEW_COM_1` (
`anocont` year
,`idcom` int
,`idempresa` int
,`idfuncao` int
,`idpg` int
,`nomefuncao` varchar(45)
,`nomegr` varchar(20)
,`numerocont` int
,`omcont` enum('GAPGL','GAPGL-PAGL','GAPRJ')
,`status` enum('vigente','finalizada','revogada')
,`tipocom` enum('FISCALIZAÇÃO','RECEBIMENTO','FISCALIZAÇÃO OBRAS/SV ENGENHARIA','RECEBIMENTO EM DEFINITIVO')
,`tipocont` enum('receita','despesa')
);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha_hash` varchar(255) NOT NULL,
  `nome` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `login`, `senha_hash`, `nome`) VALUES
(1, 'admin', '$2y$10$i4EIhUoZcuCsdWaMOFh0h.kRdjLHxZLK8PKGp6O8ETlWxBMymdATK', 'Administrador'),
(2, 'nelsonnsm', '$2y$10$oX894Kv6uLwsD97S1YSn4uduwfVosezVsOpoBA4XaV5MXBZJIymle', 'NELSON SILVA DE MENEZES'),
(3, 'claudiacrsm', '$2y$10$U5RfRSDAPSvn7YSIl3nfue4NxbumeArr2WIHvJrbVPC5ip77u1ToO', 'CLAUDIA REGINA SILVA DE MENEZES');

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `VW_MEMBROS_COMISSOES_DETALHES`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `VW_MEMBROS_COMISSOES_DETALHES` (
`contrato` varchar(75)
,`fim_comissao` date
,`funcao` varchar(45)
,`idcom` int
,`idcont` int
,`idmilitar` int
,`inicio_comissao` date
,`nome_militar` varchar(45)
,`nomegr` varchar(20)
,`status_comissao` enum('vigente','finalizada','revogada')
);

-- --------------------------------------------------------

--
-- Estrutura para vista `AZEREDO-COMISSOES`
--
DROP TABLE IF EXISTS `AZEREDO-COMISSOES`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `AZEREDO-COMISSOES`  AS SELECT `pvc`.`idcom` AS `idcom`, `pvc`.`tipocom` AS `tipocom`, `pvc`.`status` AS `status`, `pvc`.`tipocont` AS `tipocont`, `pvc`.`numerocont` AS `numerocont`, `pvc`.`omcont` AS `omcont`, `pvc`.`anocont` AS `anocont`, `e`.`nomeempresa` AS `nomeempresa`, `pg`.`nomepg` AS `nomepg`, `pvc`.`nomegr` AS `nomegr`, `pvc`.`idfuncao` AS `idfuncao`, `f`.`nomefuncao` AS `nomefuncao`, `comi`.`vigencia_ini` AS `inicio`, `comi`.`vigencia_fim` AS `termino` FROM ((((`PRE_VIEW_COM_1` `pvc` join `empresas` `e` on((`pvc`.`idempresa` = `e`.`idempresa`))) join `posto_grad` `pg` on((`pvc`.`idpg` = `pg`.`idpg`))) join `funcoes` `f` on((`pvc`.`idfuncao` = `f`.`idfuncao`))) join `comissoes` `comi` on((`pvc`.`idcom` = `comi`.`idcom`))) ORDER BY `pvc`.`idpg` ASC ;

-- --------------------------------------------------------

--
-- Estrutura para vista `AZEREDO-COMISSOES-3`
--
DROP TABLE IF EXISTS `AZEREDO-COMISSOES-3`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `AZEREDO-COMISSOES-3`  AS SELECT `AZEREDO-COMISSOES`.`idcom` AS `idcom`, `AZEREDO-COMISSOES`.`tipocom` AS `tipocom`, `AZEREDO-COMISSOES`.`status` AS `status`, `AZEREDO-COMISSOES`.`tipocont` AS `tipocont`, `AZEREDO-COMISSOES`.`numerocont` AS `numerocont`, `AZEREDO-COMISSOES`.`omcont` AS `omcont`, `AZEREDO-COMISSOES`.`anocont` AS `anocont`, `AZEREDO-COMISSOES`.`nomeempresa` AS `nomeempresa`, `AZEREDO-COMISSOES`.`nomepg` AS `nomepg`, `AZEREDO-COMISSOES`.`nomegr` AS `nomegr`, `AZEREDO-COMISSOES`.`idfuncao` AS `idfuncao`, `AZEREDO-COMISSOES`.`nomefuncao` AS `nomefuncao`, `AZEREDO-COMISSOES`.`inicio` AS `inicio`, `AZEREDO-COMISSOES`.`termino` AS `termino` FROM `AZEREDO-COMISSOES` WHERE ((`AZEREDO-COMISSOES`.`nomepg` in ('SO','1S','2S','3S','CB')) AND (`AZEREDO-COMISSOES`.`inicio` >= '2021-01-01')) ;

-- --------------------------------------------------------

--
-- Estrutura para vista `AZEREDO_BENS-RENDAS`
--
DROP TABLE IF EXISTS `AZEREDO_BENS-RENDAS`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `AZEREDO_BENS-RENDAS`  AS SELECT DISTINCT concat(`AZEREDO-COMISSOES`.`numerocont`,'/',`AZEREDO-COMISSOES`.`omcont`,'/',`AZEREDO-COMISSOES`.`anocont`) AS `contrato`, concat(`AZEREDO-COMISSOES`.`nomepg`,' ',`AZEREDO-COMISSOES`.`nomegr`) AS `militar`, `AZEREDO-COMISSOES`.`nomefuncao` AS `funcao`, `AZEREDO-COMISSOES`.`inicio` AS `inicio`, `AZEREDO-COMISSOES`.`termino` AS `termino` FROM `AZEREDO-COMISSOES` WHERE ((`AZEREDO-COMISSOES`.`nomepg` in ('SO','1S','2S','3S','CB')) AND (`AZEREDO-COMISSOES`.`termino` >= '2023-01-01') AND (`AZEREDO-COMISSOES`.`termino` <= '2023-12-31')) GROUP BY `AZEREDO-COMISSOES`.`nomepg`, `AZEREDO-COMISSOES`.`nomegr` ;

-- --------------------------------------------------------

--
-- Estrutura para vista `AZEREDO_BENS-RENDAS_FINAL`
--
DROP TABLE IF EXISTS `AZEREDO_BENS-RENDAS_FINAL`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `AZEREDO_BENS-RENDAS_FINAL`  AS SELECT DISTINCT concat(`AZEREDO-COMISSOES`.`numerocont`,'/',`AZEREDO-COMISSOES`.`omcont`,'/',`AZEREDO-COMISSOES`.`anocont`) AS `contrato`, concat(`AZEREDO-COMISSOES`.`nomepg`,' ',`AZEREDO-COMISSOES`.`nomegr`) AS `militar`, `AZEREDO-COMISSOES`.`nomefuncao` AS `funcao`, `AZEREDO-COMISSOES`.`inicio` AS `assuncao`, `AZEREDO-COMISSOES`.`termino` AS `termino` FROM `AZEREDO-COMISSOES` WHERE (((`AZEREDO-COMISSOES`.`nomepg` in ('1T','2T','AP','SO','1S','2S','3S','CB')) AND (`AZEREDO-COMISSOES`.`inicio` >= '2024-01-01') AND (`AZEREDO-COMISSOES`.`inicio` <= '2024-12-31')) OR ((`AZEREDO-COMISSOES`.`nomepg` in ('1T','2T','AP','SO','1S','2S','3S','CB')) AND (`AZEREDO-COMISSOES`.`termino` >= '2024-01-01') AND (`AZEREDO-COMISSOES`.`termino` <= '2024-12-31'))) GROUP BY `AZEREDO-COMISSOES`.`nomepg`, `AZEREDO-COMISSOES`.`nomegr` ;

-- --------------------------------------------------------

--
-- Estrutura para vista `COMISSOES_INTEGRANTES`
--
DROP TABLE IF EXISTS `COMISSOES_INTEGRANTES`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `COMISSOES_INTEGRANTES`  AS SELECT `pvc`.`idcom` AS `idcom`, `pvc`.`tipocom` AS `tipocom`, `pvc`.`status` AS `status`, `pvc`.`tipocont` AS `tipocont`, `pvc`.`numerocont` AS `numerocont`, `pvc`.`omcont` AS `omcont`, `pvc`.`anocont` AS `anocont`, `e`.`nomeempresa` AS `nomeempresa`, `pg`.`nomepg` AS `nomepg`, `pvc`.`nomegr` AS `nomegr`, `pvc`.`idfuncao` AS `idfuncao`, `f`.`nomefuncao` AS `nomefuncao`, `comi`.`vigencia_ini` AS `inicio`, `comi`.`vigencia_fim` AS `termino` FROM ((((`PRE_VIEW_COM_1` `pvc` join `empresas` `e` on((`pvc`.`idempresa` = `e`.`idempresa`))) join `posto_grad` `pg` on((`pvc`.`idpg` = `pg`.`idpg`))) join `funcoes` `f` on((`pvc`.`idfuncao` = `f`.`idfuncao`))) join `comissoes` `comi` on((`pvc`.`idcom` = `comi`.`idcom`))) ORDER BY `pvc`.`idcom` ASC, `pvc`.`idfuncao` ASC ;

-- --------------------------------------------------------

--
-- Estrutura para vista `COM_INTEG_AGRUP`
--
DROP TABLE IF EXISTS `COM_INTEG_AGRUP`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `COM_INTEG_AGRUP`  AS SELECT `COMISSOES_INTEGRANTES`.`idcom` AS `idcom`, concat(`COMISSOES_INTEGRANTES`.`tipocom`,' CT ',`COMISSOES_INTEGRANTES`.`numerocont`,'/',convert(`COMISSOES_INTEGRANTES`.`omcont` using utf8mb3),'/',`COMISSOES_INTEGRANTES`.`anocont`,' - ',convert(`COMISSOES_INTEGRANTES`.`nomeempresa` using utf8mb3)) AS `COMISSAO`, concat(`COMISSOES_INTEGRANTES`.`nomepg`,' ',`COMISSOES_INTEGRANTES`.`nomegr`,' - ',`COMISSOES_INTEGRANTES`.`nomefuncao`) AS `INTEGRANTE` FROM `COMISSOES_INTEGRANTES` ORDER BY `COMISSOES_INTEGRANTES`.`tipocom` ASC, `COMISSOES_INTEGRANTES`.`anocont` ASC, `COMISSOES_INTEGRANTES`.`numerocont` ASC, `COMISSOES_INTEGRANTES`.`idfuncao` ASC ;

-- --------------------------------------------------------

--
-- Estrutura para vista `COM_INTEG_AGRUP_1`
--
DROP TABLE IF EXISTS `COM_INTEG_AGRUP_1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `COM_INTEG_AGRUP_1`  AS SELECT `COMISSOES_INTEGRANTES`.`idcom` AS `id`, `COMISSOES_INTEGRANTES`.`tipocom` AS `tipo`, `COMISSOES_INTEGRANTES`.`tipocont` AS `tipocont`, `COMISSOES_INTEGRANTES`.`nomeempresa` AS `empresa`, concat(`COMISSOES_INTEGRANTES`.`numerocont`,'/',`COMISSOES_INTEGRANTES`.`omcont`,'/',`COMISSOES_INTEGRANTES`.`anocont`) AS `contrato`, concat(`COMISSOES_INTEGRANTES`.`nomepg`,' ',`COMISSOES_INTEGRANTES`.`nomegr`) AS `militar`, `COMISSOES_INTEGRANTES`.`idfuncao` AS `idfuncao`, `COMISSOES_INTEGRANTES`.`nomefuncao` AS `funcao` FROM `COMISSOES_INTEGRANTES` ;

-- --------------------------------------------------------

--
-- Estrutura para vista `CONTRATOS_LANCADOS_VW`
--
DROP TABLE IF EXISTS `CONTRATOS_LANCADOS_VW`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `CONTRATOS_LANCADOS_VW`  AS SELECT `contratos`.`idcont` AS `idcont`, `contratos`.`numerocont` AS `numerocont`, `contratos`.`omcont` AS `omcont`, `contratos`.`anocont` AS `anocont`, `empresas`.`nomeempresa` AS `nomeempresa` FROM (`contratos` join `empresas`) WHERE (`contratos`.`idempresa` = `empresas`.`idempresa`) ORDER BY `empresas`.`nomeempresa` ASC ;

-- --------------------------------------------------------

--
-- Estrutura para vista `CONT_AGRUP`
--
DROP TABLE IF EXISTS `CONT_AGRUP`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `CONT_AGRUP`  AS SELECT DISTINCT `COMISSOES_INTEGRANTES`.`idcom` AS `idcom`, `COMISSOES_INTEGRANTES`.`tipocom` AS `tipocom`, concat(`COMISSOES_INTEGRANTES`.`numerocont`,'/',`COMISSOES_INTEGRANTES`.`omcont`,'/',`COMISSOES_INTEGRANTES`.`anocont`,' - ',`COMISSOES_INTEGRANTES`.`nomeempresa`) AS `CONTRATO` FROM `COMISSOES_INTEGRANTES` ORDER BY `COMISSOES_INTEGRANTES`.`tipocont` ASC, `COMISSOES_INTEGRANTES`.`anocont` ASC, `COMISSOES_INTEGRANTES`.`numerocont` ASC ;

-- --------------------------------------------------------

--
-- Estrutura para vista `CONT_AGRUP1`
--
DROP TABLE IF EXISTS `CONT_AGRUP1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `CONT_AGRUP1`  AS SELECT DISTINCT `COMISSOES_INTEGRANTES`.`idcom` AS `idcom`, `COMISSOES_INTEGRANTES`.`tipocom` AS `tipocom`, concat(`COMISSOES_INTEGRANTES`.`numerocont`,'/',`COMISSOES_INTEGRANTES`.`omcont`,'/',`COMISSOES_INTEGRANTES`.`anocont`,' ','-',' ',`COMISSOES_INTEGRANTES`.`nomeempresa`) AS `CONTRATO` FROM `COMISSOES_INTEGRANTES` ORDER BY `COMISSOES_INTEGRANTES`.`tipocont` ASC, `COMISSOES_INTEGRANTES`.`anocont` ASC, `COMISSOES_INTEGRANTES`.`numerocont` ASC ;

-- --------------------------------------------------------

--
-- Estrutura para vista `CONT_AGRUP2`
--
DROP TABLE IF EXISTS `CONT_AGRUP2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `CONT_AGRUP2`  AS SELECT DISTINCT `COMISSOES_INTEGRANTES`.`idcom` AS `idcom`, `COMISSOES_INTEGRANTES`.`tipocom` AS `tipocom`, concat(`COMISSOES_INTEGRANTES`.`numerocont`,'/',`COMISSOES_INTEGRANTES`.`omcont`,'/',`COMISSOES_INTEGRANTES`.`anocont`,'-',`COMISSOES_INTEGRANTES`.`nomeempresa`) AS `CONTRATO` FROM `COMISSOES_INTEGRANTES` ORDER BY `COMISSOES_INTEGRANTES`.`tipocont` ASC, `COMISSOES_INTEGRANTES`.`anocont` ASC, `COMISSOES_INTEGRANTES`.`numerocont` ASC ;

-- --------------------------------------------------------

--
-- Estrutura para vista `FISCAIS E PRESIDENTES`
--
DROP TABLE IF EXISTS `FISCAIS E PRESIDENTES`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `FISCAIS E PRESIDENTES`  AS SELECT `COMISSOES_INTEGRANTES`.`tipocom` AS `comissão - tipo`, `COMISSOES_INTEGRANTES`.`tipocont` AS `contrato - tipo`, concat(`COMISSOES_INTEGRANTES`.`numerocont`,'/',`COMISSOES_INTEGRANTES`.`omcont`,'/',`COMISSOES_INTEGRANTES`.`anocont`) AS `contrato`, `COMISSOES_INTEGRANTES`.`nomeempresa` AS `empresa`, concat(`COMISSOES_INTEGRANTES`.`nomepg`,' ',`COMISSOES_INTEGRANTES`.`nomegr`) AS `militar`, `COMISSOES_INTEGRANTES`.`nomefuncao` AS `funcao` FROM `COMISSOES_INTEGRANTES` WHERE ((`COMISSOES_INTEGRANTES`.`status` = 'vigente') AND (`COMISSOES_INTEGRANTES`.`idfuncao` in (17,18,19,20,21,22))) ORDER BY `COMISSOES_INTEGRANTES`.`anocont` ASC, `COMISSOES_INTEGRANTES`.`numerocont` ASC ;

-- --------------------------------------------------------

--
-- Estrutura para vista `ID_CONTRATOS`
--
DROP TABLE IF EXISTS `ID_CONTRATOS`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ID_CONTRATOS`  AS SELECT `contratos`.`idcont` AS `idcont`, `contratos`.`numerocont` AS `numerocont`, `contratos`.`omcont` AS `omcont`, `contratos`.`anocont` AS `anocont`, `empresas`.`nomeempresa` AS `nomeempresa` FROM (`contratos` join `empresas`) WHERE (`contratos`.`idempresa` = `empresas`.`idempresa`) ORDER BY `empresas`.`nomeempresa` ASC ;

-- --------------------------------------------------------

--
-- Estrutura para vista `INFO_COMISSAO`
--
DROP TABLE IF EXISTS `INFO_COMISSAO`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `INFO_COMISSAO`  AS SELECT `pic`.`idcom` AS `idcom`, `pic`.`tipocom` AS `tipocom`, `pic`.`status` AS `status`, `pic`.`tipocont` AS `tipocont`, `pic`.`numerocont` AS `numerocont`, `ct`.`anocont` AS `anocont`, `e`.`nomeempresa` AS `nomeempresa`, `c`.`vigencia_fim` AS `vigencia_fim` FROM (((`PRE_INFO_COM` `pic` join `contratos` `ct` on((`pic`.`idcont` = `ct`.`idcont`))) join `empresas` `e` on((`pic`.`idempresa` = `e`.`idempresa`))) join `comissoes` `c` on((`pic`.`idcom` = `c`.`idcom`))) ;

-- --------------------------------------------------------

--
-- Estrutura para vista `INTEG_FUNC_AGRUP`
--
DROP TABLE IF EXISTS `INTEG_FUNC_AGRUP`;
-- Erro ao ler a estrutura para a tabela db_CRUD.INTEG_FUNC_AGRUP: #1109 - Tabela &#039;db_CRUD&#039; desconhecida em &#039;field list&#039;

-- --------------------------------------------------------

--
-- Estrutura para vista `PRE_INFO_COM`
--
DROP TABLE IF EXISTS `PRE_INFO_COM`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `PRE_INFO_COM`  AS SELECT `c`.`idcom` AS `idcom`, `c`.`status` AS `status`, `ct`.`idcont` AS `idcont`, `ct`.`idempresa` AS `idempresa`, `c`.`tipocom` AS `tipocom`, `ct`.`tipocont` AS `tipocont`, `ct`.`numerocont` AS `numerocont` FROM (`comissoes` `c` join `contratos` `ct` on((`c`.`contratos_idcont` = `ct`.`idcont`))) ;

-- --------------------------------------------------------

--
-- Estrutura para vista `PRE_VIEW_COM`
--
DROP TABLE IF EXISTS `PRE_VIEW_COM`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `PRE_VIEW_COM`  AS SELECT `mhc`.`idcom` AS `idcom`, `mhc`.`idmilitar` AS `idmilitar`, `mhc`.`idfuncao` AS `idfuncao`, `comissoes`.`contratos_idcont` AS `contratos_idcont` FROM (`militares_has_comissoes` `mhc` join `comissoes`) WHERE (`mhc`.`idcom` = `comissoes`.`idcom`) ;

-- --------------------------------------------------------

--
-- Estrutura para vista `PRE_VIEW_COM_1`
--
DROP TABLE IF EXISTS `PRE_VIEW_COM_1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `PRE_VIEW_COM_1`  AS SELECT `pvc`.`idcom` AS `idcom`, `c`.`tipocom` AS `tipocom`, `c`.`status` AS `status`, `ct`.`tipocont` AS `tipocont`, `ct`.`numerocont` AS `numerocont`, `ct`.`omcont` AS `omcont`, `ct`.`anocont` AS `anocont`, `ct`.`idempresa` AS `idempresa`, `m`.`idpg` AS `idpg`, `m`.`nomegr` AS `nomegr`, `f`.`idfuncao` AS `idfuncao`, `f`.`nomefuncao` AS `nomefuncao` FROM ((((`PRE_VIEW_COM` `pvc` join `comissoes` `c` on((`pvc`.`idcom` = `c`.`idcom`))) join `contratos` `ct` on((`pvc`.`contratos_idcont` = `ct`.`idcont`))) join `militares` `m` on((`pvc`.`idmilitar` = `m`.`idmilitar`))) join `funcoes` `f` on((`pvc`.`idfuncao` = `f`.`idfuncao`))) ;

-- --------------------------------------------------------

--
-- Estrutura para vista `VW_MEMBROS_COMISSOES_DETALHES`
--
DROP TABLE IF EXISTS `VW_MEMBROS_COMISSOES_DETALHES`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `VW_MEMBROS_COMISSOES_DETALHES`  AS SELECT `m`.`nomemil` AS `nome_militar`, `m`.`nomegr` AS `nomegr`, `f`.`nomefuncao` AS `funcao`, concat(`ct`.`numerocont`,'/',`ct`.`omcont`,'/',`ct`.`anocont`,' - ',`e`.`nomeempresa`) AS `contrato`, `c`.`vigencia_ini` AS `inicio_comissao`, `c`.`vigencia_fim` AS `fim_comissao`, `c`.`status` AS `status_comissao`, `c`.`idcom` AS `idcom`, `m`.`idmilitar` AS `idmilitar`, `ct`.`idcont` AS `idcont` FROM (((((`militares_has_comissoes` `mhc` join `militares` `m` on((`mhc`.`idmilitar` = `m`.`idmilitar`))) join `funcoes` `f` on((`mhc`.`idfuncao` = `f`.`idfuncao`))) join `comissoes` `c` on((`mhc`.`idcom` = `c`.`idcom`))) join `contratos` `ct` on((`c`.`contratos_idcont` = `ct`.`idcont`))) join `empresas` `e` on((`ct`.`idempresa` = `e`.`idempresa`))) ;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `comissoes`
--
ALTER TABLE `comissoes`
  ADD PRIMARY KEY (`idcom`),
  ADD KEY `fk_comissoes_contratos1_idx` (`contratos_idcont`);

--
-- Índices para tabela `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`idcont`),
  ADD KEY `fk_contratos_empresas_idx` (`idempresa`);

--
-- Índices para tabela `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`idempresa`),
  ADD UNIQUE KEY `CNPJ_UNIQUE` (`CNPJ`);

--
-- Índices para tabela `funcoes`
--
ALTER TABLE `funcoes`
  ADD PRIMARY KEY (`idfuncao`);

--
-- Índices para tabela `militares`
--
ALTER TABLE `militares`
  ADD PRIMARY KEY (`idmilitar`),
  ADD KEY `fk_militares_posto_grad1_idx` (`idpg`);

--
-- Índices para tabela `militares_has_comissoes`
--
ALTER TABLE `militares_has_comissoes`
  ADD PRIMARY KEY (`idcom`,`idmilitar`),
  ADD KEY `fk_militares_has_comissoes_funcoes1_idx` (`idfuncao`),
  ADD KEY `fk_militares_has_comissoes_comissoes1_idx` (`idcom`),
  ADD KEY `fk_militares_has_comissoes_militares1_idx` (`idmilitar`);

--
-- Índices para tabela `posto_grad`
--
ALTER TABLE `posto_grad`
  ADD PRIMARY KEY (`idpg`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login_UNICO` (`login`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `comissoes`
--
ALTER TABLE `comissoes`
  MODIFY `idcom` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=238;

--
-- AUTO_INCREMENT de tabela `contratos`
--
ALTER TABLE `contratos`
  MODIFY `idcont` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de tabela `empresas`
--
ALTER TABLE `empresas`
  MODIFY `idempresa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de tabela `funcoes`
--
ALTER TABLE `funcoes`
  MODIFY `idfuncao` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `militares`
--
ALTER TABLE `militares`
  MODIFY `idmilitar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT de tabela `posto_grad`
--
ALTER TABLE `posto_grad`
  MODIFY `idpg` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `comissoes`
--
ALTER TABLE `comissoes`
  ADD CONSTRAINT `fk_comissoes_contratos1` FOREIGN KEY (`contratos_idcont`) REFERENCES `contratos` (`idcont`);

--
-- Limitadores para a tabela `contratos`
--
ALTER TABLE `contratos`
  ADD CONSTRAINT `fk_contratos_empresas` FOREIGN KEY (`idempresa`) REFERENCES `empresas` (`idempresa`);

--
-- Limitadores para a tabela `militares`
--
ALTER TABLE `militares`
  ADD CONSTRAINT `fk_militares_posto_grad1` FOREIGN KEY (`idpg`) REFERENCES `posto_grad` (`idpg`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
