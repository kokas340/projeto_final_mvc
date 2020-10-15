-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16-Out-2020 às 01:46
-- Versão do servidor: 10.4.14-MariaDB
-- versão do PHP: 7.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto_final_mvc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `associacao`
--

CREATE TABLE `associacao` (
  `idAssoc` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `morada` varchar(255) NOT NULL,
  `telefone` int(9) NOT NULL,
  `numContribuinte` int(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `associacao`
--

INSERT INTO `associacao` (`idAssoc`, `nome`, `morada`, `telefone`, `numContribuinte`) VALUES
(1, 'Quinta Grande', 'Quinta Grande', 123456789, 2147483647),
(2, 'Campanario Assoc', 'Campanario', 876879, 7465879);

-- --------------------------------------------------------

--
-- Estrutura da tabela `eventos`
--

CREATE TABLE `eventos` (
  `idEvento` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `evento` varchar(255) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `idAssoc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `eventos`
--

INSERT INTO `eventos` (`idEvento`, `titulo`, `evento`, `imagem`, `idAssoc`) VALUES
(1, 'Desporto', 'footabll', 'maxresdefaultjpg407285743jpg_698783773.jpg', 1),
(8, 'Basket', 'BETA', '8863jpg_1219111066.jpg', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagem`
--

CREATE TABLE `imagem` (
  `titulo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `inscricoes`
--

CREATE TABLE `inscricoes` (
  `idEvento` int(11) NOT NULL,
  `idSocio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias`
--

CREATE TABLE `noticias` (
  `idNoticia` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `noticia` text NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `idAssoc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `noticias`
--

INSERT INTO `noticias` (`idNoticia`, `titulo`, `noticia`, `imagem`, `idAssoc`) VALUES
(1, 'IM DEAD', 'FUCK YOU', 'callofdutyblackopscoldwar1jpg_60311551.jpeg', 1),
(11, 'COD CW', 'ALPHA', 'callofdutyblackopscoldwar1jpg60311551jpg_126510886.jpg', 2),
(13, 'IPHONE 12', 'SEM CARREGADOR', '24546jpg_899375267.jpg', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `quotas`
--

CREATE TABLE `quotas` (
  `idQuota` int(11) NOT NULL,
  `idSocio` int(11) NOT NULL,
  `dataComeco` date NOT NULL,
  `dataTermino` date NOT NULL,
  `preco` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `quotas`
--

INSERT INTO `quotas` (`idQuota`, `idSocio`, `dataComeco`, `dataTermino`, `preco`) VALUES
(1, 7, '2020-10-10', '2020-10-14', 300),
(2, 0, '2020-10-10', '2020-10-14', 500),
(3, 0, '2020-10-10', '2020-10-14', 500),
(4, 0, '2020-10-10', '2020-10-14', 500),
(5, 0, '2020-10-10', '2020-10-14', 500),
(6, 48, '2020-10-10', '2020-10-14', 500),
(8, 43, '2020-10-10', '2020-10-14', 500),
(12, 46, '2020-10-10', '2020-10-14', 6000),
(16, 46, '2020-10-10', '2020-10-14', 500);

-- --------------------------------------------------------

--
-- Estrutura da tabela `socios`
--

CREATE TABLE `socios` (
  `idSocio` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `socio_permissions` varchar(255) NOT NULL,
  `socio_session_id` varchar(255) NOT NULL,
  `idAssoc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `socios`
--

INSERT INTO `socios` (`idSocio`, `nome`, `email`, `login`, `password`, `socio_permissions`, `socio_session_id`, `idAssoc`) VALUES
(7, 'francisco', 'guilhermejesus216@gmail.com', 'admin', '$2a$08$0kXFCi6Su2VCIUDWSr4Z5.8iyT1K/gq6SECudXO5idceKB.nP2Baa', 'a:5:{i:0;s:5:\"admin\";i:1;s:12:\"gerir-socios\";i:2;s:11:\"gerir-assoc\";i:3;s:13:\"gerir-eventos\";i:4;s:19:\"gerir-assoc-specify\";}', '6776faaa8489c11d2a223a20151e0577', 1),
(43, 'dercio', 'fiwjnrk@gmail.com', 'dercio', '$2a$08$YCAPEmwU6VLs7ipzmObkJuDLV753DgfGV.fMqYI5zhTecvXojtcue', 'a:2:{i:0;s:5:\"admin\";i:1;s:11:\"gerir-assoc\";}', 'd234fb1cf92037a75b47e53279158e16', 1),
(46, 'matt', '@gmail.com', 'matt', '$2a$08$Yj3sUCmsbCAS3XfhJmBJiewNiTueNA.8jOMJQXDNoElRDSRQBEL46', 'a:1:{i:0;s:5:\"admin\";}', '3a6120fc32e224cbb77f11018c084ef1', 2),
(48, 'nidio', 'ijvene', 'nidio', '$2a$08$F.l.JJwLg3LApXH.GzvuzOw56KLlI/opU9AMrVh/H654HIMKa3ZSm', 'a:1:{i:0;s:12:\"gerir-socios\";}', '0a2d9f2552ec995475d504dad56e72ad', 2),
(50, 'nata', 'guilhermejesus216@gmail.com', 'na', '$2a$08$Zi1VqYlc5lu.CBYVOuY/6.Bv1vREjZeLeTfWyyVMo5oekrpn.4Lfq', 'a:1:{i:0;s:12:\"gerir-socios\";}', '1f7eae612381dfc149f5894b93c99b1c', 2),
(54, 'adm', 'vfer', 'adm', '$2a$08$tsEJOJ8RQs.bK2K8IKBQOuCtovP/cAs4lwWKnOXML0.BcRviEsGGe', 'a:5:{i:0;s:5:\"admin\";i:1;s:12:\"gerir-socios\";i:2;s:11:\"gerir-assoc\";i:3;s:13:\"gerir-eventos\";i:4;s:19:\"gerir-assoc-specify\";}', 'daaf3fa3576d04e11287f396237f5a97', 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `associacao`
--
ALTER TABLE `associacao`
  ADD PRIMARY KEY (`idAssoc`);

--
-- Índices para tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`idEvento`);

--
-- Índices para tabela `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`idNoticia`);

--
-- Índices para tabela `quotas`
--
ALTER TABLE `quotas`
  ADD PRIMARY KEY (`idQuota`);

--
-- Índices para tabela `socios`
--
ALTER TABLE `socios`
  ADD PRIMARY KEY (`idSocio`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `associacao`
--
ALTER TABLE `associacao`
  MODIFY `idAssoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `idEvento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `noticias`
--
ALTER TABLE `noticias`
  MODIFY `idNoticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `quotas`
--
ALTER TABLE `quotas`
  MODIFY `idQuota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `socios`
--
ALTER TABLE `socios`
  MODIFY `idSocio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
