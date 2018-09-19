-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 20-Set-2018 às 01:18
-- Versão do servidor: 5.6.24
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `research.net`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `pesquisadores`
--

CREATE TABLE IF NOT EXISTS `pesquisadores` (
  `id_pesquisador` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `idLattes` varchar(16) NOT NULL,
  `Data` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pesquisadores`
--

INSERT INTO `pesquisadores` (`id_pesquisador`, `nome`, `idLattes`, `Data`) VALUES
(66, 'Alessandro de Lima Bicho', '6965119196945931', '13022018'),
(67, 'Andre Prisco Vargas', '0243625998325831', '04112016'),
(68, 'Edimar Manica', '7497320738069454', '20052018'),
(69, 'Eduardo Nunes Borges', '5851601274050374', '16052018'),
(70, 'GraÃ§aliz Pereira Dimuro', '9414212573217453', '31052018'),
(71, 'HÃ©lida Salles Santos', '2096843997457737', '14052018'),
(72, 'Igor Avila Pereira', '7701563839009909', '11042018'),
(73, 'Karina dos Santos Machado', '3528633359332021', '06052018'),
(74, 'Leonardo Ramos Emmendorfer', '1129100746134234', '22022018'),
(75, 'Maria de Fatima Santos Maia', '4428620525281564', '04052018'),
(76, 'Rafael Augusto Penna dos Santos', '2765008024136365', '29052018');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pesquisadoresdarede`
--

CREATE TABLE IF NOT EXISTS `pesquisadoresdarede` (
  `id_rede` int(11) NOT NULL,
  `id_pesquisador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pesquisadoresdarede`
--

INSERT INTO `pesquisadoresdarede` (`id_rede`, `id_pesquisador`) VALUES
(85, 66),
(86, 66),
(87, 66),
(85, 67),
(86, 67),
(87, 67),
(85, 68),
(86, 68),
(87, 68),
(85, 69),
(86, 69),
(87, 69),
(85, 70),
(86, 70),
(87, 70),
(85, 71),
(86, 71),
(87, 71),
(85, 72),
(86, 72),
(87, 72),
(85, 73),
(86, 73),
(87, 73),
(85, 74),
(86, 74),
(87, 74),
(85, 75),
(86, 75),
(87, 75),
(85, 76),
(86, 76),
(87, 76);

-- --------------------------------------------------------

--
-- Estrutura da tabela `redes`
--

CREATE TABLE IF NOT EXISTS `redes` (
  `id_rede` int(11) NOT NULL,
  `Titulo` varchar(50) NOT NULL,
  `numero_pesquisadores` int(150) NOT NULL,
  `data_criacao` date NOT NULL,
  `min_similarity` float NOT NULL,
  `metric` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `redes`
--

INSERT INTO `redes` (`id_rede`, `Titulo`, `numero_pesquisadores`, `data_criacao`, `min_similarity`, `metric`) VALUES
(85, 'Grupo de Pesquisa em Gerenciamento de InformaÃ§Ãµe', 11, '2018-06-12', 0.95, 'levenshtein'),
(86, 'Grupo de Pesquisa em Gerenciamento de InformaÃ§Ãµe', 11, '2018-06-12', 0.8, 'levenshtein'),
(87, 'Grupo de Pesquisa em Gerenciamento de InformaÃ§Ãµe', 11, '2018-06-12', 0.95, 'jaccard');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pesquisadores`
--
ALTER TABLE `pesquisadores`
  ADD PRIMARY KEY (`id_pesquisador`);

--
-- Indexes for table `pesquisadoresdarede`
--
ALTER TABLE `pesquisadoresdarede`
  ADD PRIMARY KEY (`id_rede`,`id_pesquisador`), ADD KEY `id_pesquisador` (`id_pesquisador`);

--
-- Indexes for table `redes`
--
ALTER TABLE `redes`
  ADD PRIMARY KEY (`id_rede`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pesquisadores`
--
ALTER TABLE `pesquisadores`
  MODIFY `id_pesquisador` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `redes`
--
ALTER TABLE `redes`
  MODIFY `id_rede` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=88;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `pesquisadoresdarede`
--
ALTER TABLE `pesquisadoresdarede`
ADD CONSTRAINT `pesquisadoresdarede_ibfk_1` FOREIGN KEY (`id_pesquisador`) REFERENCES `pesquisadores` (`id_pesquisador`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `pesquisadoresdarede_ibfk_2` FOREIGN KEY (`id_rede`) REFERENCES `redes` (`id_rede`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
