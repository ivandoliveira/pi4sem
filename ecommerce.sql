-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/11/2025 às 03:31
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ecommerce`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `aplicacao`
--

CREATE TABLE `aplicacao` (
  `idAplicacao` tinyint(4) NOT NULL,
  `DescAplicacao` varchar(50) NOT NULL,
  `TipoAplicacao` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aplicacao`
--

INSERT INTO `aplicacao` (`idAplicacao`, `DescAplicacao`, `TipoAplicacao`) VALUES
(1, 'Mobile App', 'M'),
(2, 'Web', 'W');

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `nomeCategoria` varchar(50) NOT NULL,
  `descCategoria` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `nomeCategoria`, `descCategoria`) VALUES
(1, 'Cerâmica', 'Itens de argila cozida e esmaltada.'),
(2, 'Joias', 'Acessórios como colares, anéis e brincos.'),
(3, 'Têxtil', 'Produtos feitos com tecidos e fibras.'),
(4, 'Madeira', 'Objetos de decoração e utensílios entalhados.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL,
  `nomeCompletoCliente` varchar(100) NOT NULL,
  `emailCliente` varchar(100) NOT NULL,
  `senhaCliente` varchar(64) NOT NULL,
  `CPFCliente` char(14) NOT NULL,
  `celularCliente` varchar(20) DEFAULT NULL,
  `telComercialCliente` varchar(20) DEFAULT NULL,
  `telResidencialCliente` varchar(20) DEFAULT NULL,
  `dtNascCliente` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`idCliente`, `nomeCompletoCliente`, `emailCliente`, `senhaCliente`, `CPFCliente`, `celularCliente`, `telComercialCliente`, `telResidencialCliente`, `dtNascCliente`) VALUES
(1, 'Maria Cliente', 'maria@cliente.com', '$2y$10$7Vc5oFujG8qqPQbULk9jMOaa0ahdSMUIf/uTE2dplcvjSrCIYLEvC', '123.456.789-00', '(11) 98765-4321', '', '', '1990-05-15'),
(2, 'Carolina ', 'carolina2@gmail.com', '$2y$10$nArA3bD21x0.Yw9gMB3hA.QKupZSJOIHaE9FfsTneK7oWgZpD.5F6', '378.543.828-22', '11985622554', '', '', '1998-11-15'),
(3, 'Joao', 'joaa@gmail.com', '$2y$10$q2hlT2QylUIFSsZEM9PL3OxgPTOFHhYNMYEzRCpk27cmq9CJCGVbe', '357.483.828-65', '11985632541', '', '', '2025-11-15'),
(4, 'Jose', 'jose@gmail.com', '$2y$10$KMHUBLkE1N1pgWNrp8XpBevh19yPSofv0bnZgp4zMO2.DVGR2evLu', '654.483.828-26', '1185693247', '', '', '2025-11-15'),
(5, 'Pedro', 'pedro@hotmail.com', '$2y$10$RW/swBhwjNkFF505GQ7JZeRUjTTfuBbRpcwctUY3rd2GJekeslhIi', '356.483.828-26', '1185742369', '', '', '2025-11-15'),

-- --------------------------------------------------------

--
-- Estrutura para tabela `endereco`
--

CREATE TABLE `endereco` (
  `idEndereco` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `nomeEndereco` varchar(50) NOT NULL,
  `logradouroEndereco` varchar(100) NOT NULL,
  `numeroEndereco` varchar(10) NOT NULL,
  `CEPEndereco` char(9) NOT NULL,
  `complementoEndereco` varchar(10) DEFAULT NULL,
  `cidadeEndereco` varchar(50) NOT NULL,
  `paisEndereco` varchar(50) DEFAULT NULL,
  `UFEndereco` char(2) DEFAULT NULL,
  `imagem` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `endereco`
--

INSERT INTO `endereco` (`idEndereco`, `idCliente`, `nomeEndereco`, `logradouroEndereco`, `numeroEndereco`, `CEPEndereco`, `complementoEndereco`, `cidadeEndereco`, `paisEndereco`, `UFEndereco`, `imagem`) VALUES
(1, 1, 'Casa Principal', 'Rua das Flores', '123 B', '01000-000', 'Apto 101', 'São Paulo', 'Brasil', 'SP', NULL),
(2, 2, 'Casa Principal', 'Avenida Senhor Prado', '4092', '04847-005', 'Bloco 25 ', 'SAO PAULO', 'Brasil', 'SP', NULL),


-- --------------------------------------------------------

--
-- Estrutura para tabela `estoque`
--

CREATE TABLE `estoque` (
  `idProduto` int(11) NOT NULL,
  `qtdProdutoDisponivel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `itempedido`
--

CREATE TABLE `itempedido` (
  `idProduto` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `qtdProduto` smallint(6) NOT NULL,
  `precoVendaItem` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itempedido`
--

INSERT INTO `itempedido` (`idProduto`, `idPedido`, `qtdProduto`, `precoVendaItem`) VALUES
(1, 1, 1, 99.90),



-- --------------------------------------------------------

--
-- Estrutura para tabela `pedido`
--

CREATE TABLE `pedido` (
  `idPedido` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `idStatus` tinyint(4) NOT NULL,
  `dataPedido` datetime NOT NULL,
  `idTipoPagto` tinyint(4) NOT NULL,
  `idEndereco` int(11) DEFAULT NULL,
  `idAplicacao` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedido`
--

INSERT INTO `pedido` (`idPedido`, `idCliente`, `idStatus`, `dataPedido`, `idTipoPagto`, `idEndereco`, `idAplicacao`) VALUES
(1, 1, 1, '2025-11-12 01:46:13', 2, 1, 2),


-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `idProduto` int(11) NOT NULL,
  `nomeProduto` varchar(70) NOT NULL,
  `descProduto` varchar(500) DEFAULT NULL,
  `precProduto` decimal(10,2) NOT NULL,
  `descontoPromocao` decimal(18,2) DEFAULT NULL,
  `idCategoria` int(11) NOT NULL,
  `ativoProduto` char(1) NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `qtdMinEstoque` int(11) DEFAULT NULL,
  `imagem` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`idProduto`, `nomeProduto`, `descProduto`, `precProduto`, `descontoPromocao`, `idCategoria`, `ativoProduto`, `idUsuario`, `qtdMinEstoque`, `imagem`) VALUES
(1, 'Vaso de Cerâmica Artesanal', NULL, 99.90, 0.00, 1, 'S', 1, 0, 'https://images.unsplash.com/photo-1572982758354-c097406beae5?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=987'),
(3, 'Anel de Pedra Natural', NULL, 49.90, 0.00, 2, 'S', 2, 0, 'https://images.unsplash.com/photo-1612314317004-d650718f188a?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=871'),
(4, 'Tapete Vermelho Oriental', NULL, 59.90, 0.00, 3, 'S', 3, 0, 'https://images.unsplash.com/photo-1727024418120-77e4e204d09f?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=699'),
(6, 'Tigelas de Cerâmica', NULL, 89.90, 0.00, 1, 'S', 1, 0, 'https://images.unsplash.com/photo-1610701596007-11502861dcfa?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=870'),
(7, 'Brincos de Malaquita', NULL, 89.90, 0.00, 2, 'S', 2, 0, 'https://images.unsplash.com/photo-1758974504487-74d46fa07242?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=870');

-- --------------------------------------------------------

--
-- Estrutura para tabela `statuspedido`
--

CREATE TABLE `statuspedido` (
  `idStatus` tinyint(4) NOT NULL,
  `descStatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `statuspedido`
--

INSERT INTO `statuspedido` (`idStatus`, `descStatus`) VALUES
(1, 'Pedido Recebido'),
(2, 'Pagamento Confirmado'),
(3, 'Em Preparação'),
(4, 'Enviado'),
(5, 'Entregue');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipopagamento`
--

CREATE TABLE `tipopagamento` (
  `idTipoPagto` tinyint(4) NOT NULL,
  `descTipoPagto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tipopagamento`
--

INSERT INTO `tipopagamento` (`idTipoPagto`, `descTipoPagto`) VALUES
(1, 'Débito'),
(2, 'Crédito');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `loginUsuario` varchar(100) NOT NULL,
  `senhaUsuario` varchar(64) DEFAULT NULL,
  `nomeUsuario` varchar(50) DEFAULT NULL,
  `tipoPerfil` char(1) DEFAULT NULL,
  `usuarioAtivo` tinyint(1) DEFAULT NULL,
  `imagem` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `loginUsuario`, `senhaUsuario`, `nomeUsuario`, `tipoPerfil`, `usuarioAtivo`, `imagem`) VALUES
(1, 'joao_artesao', '$2y$10$sMyO8WL2cQaKP2fuZtzJ3.5qb8caTVqyQbsHZVbyMGTvjXxyWDeP6', 'João Artesão Silva', 'V', 1, 'https://images.unsplash.com/photo-1761410403735-108d974d9a76?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=870'),
(2, 'pedro_artesao', '$2y$10$/1u6S/EGuzpvl8THuj4aeeqoFVj6K8k6rMS5BPJehurMBEKEJArW.', 'Pedro Santos', 'V', 1, 'https://images.unsplash.com/photo-1516652695352-6118f7cc1a07?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=872'),
(3, 'maria_artesao', '$2y$10$y.XgYEYFs/pXuezWqlFpjeinKbSRer8Spu2zvyjqV35v5tFsPkMF.', 'Maria Silva', 'V', 1, 'https://images.unsplash.com/photo-1719154717733-d37860cdee24?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=687.jpg'),
(5, 'edu_artesao', '$2y$10$IGcAQgCDDQyHYsbZxKPkrukmVTZS7oUPVu.MulttzemvKr9dNbpHC', 'Eduardo Costa', 'C', 1, NULL),
(6, 'edu_artesao', '$2y$10$c0H3n6bNXj8WAQAGKTNPPOvUTP02FW4LfsM/jZqY5J.qgzOGce4ce', 'Eduardo Costa', 'C', 1, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `aplicacao`
--
ALTER TABLE `aplicacao`
  ADD PRIMARY KEY (`idAplicacao`);

--
-- Índices de tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idCliente`);

--
-- Índices de tabela `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`idEndereco`),
  ADD KEY `idCliente` (`idCliente`);

--
-- Índices de tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`idProduto`);

--
-- Índices de tabela `itempedido`
--
ALTER TABLE `itempedido`
  ADD PRIMARY KEY (`idProduto`,`idPedido`),
  ADD KEY `idPedido` (`idPedido`);

--
-- Índices de tabela `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idStatus` (`idStatus`),
  ADD KEY `idTipoPagto` (`idTipoPagto`),
  ADD KEY `idEndereco` (`idEndereco`),
  ADD KEY `idAplicacao` (`idAplicacao`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`idProduto`),
  ADD KEY `idCategoria` (`idCategoria`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Índices de tabela `statuspedido`
--
ALTER TABLE `statuspedido`
  ADD PRIMARY KEY (`idStatus`);

--
-- Índices de tabela `tipopagamento`
--
ALTER TABLE `tipopagamento`
  ADD PRIMARY KEY (`idTipoPagto`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `endereco`
--
ALTER TABLE `endereco`
  MODIFY `idEndereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `pedido`
--
ALTER TABLE `pedido`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `idProduto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `endereco`
--
ALTER TABLE `endereco`
  ADD CONSTRAINT `endereco_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`);

--
-- Restrições para tabelas `estoque`
--
ALTER TABLE `estoque`
  ADD CONSTRAINT `estoque_ibfk_1` FOREIGN KEY (`idProduto`) REFERENCES `produto` (`idProduto`);

--
-- Restrições para tabelas `itempedido`
--
ALTER TABLE `itempedido`
  ADD CONSTRAINT `itempedido_ibfk_1` FOREIGN KEY (`idProduto`) REFERENCES `produto` (`idProduto`),
  ADD CONSTRAINT `itempedido_ibfk_2` FOREIGN KEY (`idPedido`) REFERENCES `pedido` (`idPedido`);

--
-- Restrições para tabelas `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`),
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`idStatus`) REFERENCES `statuspedido` (`idStatus`),
  ADD CONSTRAINT `pedido_ibfk_3` FOREIGN KEY (`idTipoPagto`) REFERENCES `tipopagamento` (`idTipoPagto`),
  ADD CONSTRAINT `pedido_ibfk_4` FOREIGN KEY (`idEndereco`) REFERENCES `endereco` (`idEndereco`),
  ADD CONSTRAINT `pedido_ibfk_5` FOREIGN KEY (`idAplicacao`) REFERENCES `aplicacao` (`idAplicacao`);

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`),
  ADD CONSTRAINT `produto_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
