-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25-Set-2025 às 01:46
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cadastro-tech`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadastro_tech`
--

CREATE TABLE `cadastro_tech` (
  `idusuarios` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `email` varchar(110) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `data_nasc` date NOT NULL,
  `endereco` varchar(45) NOT NULL,
  `sexo` varchar(15) NOT NULL,
  `cep` varchar(15) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `login` varchar(45) NOT NULL,
  `nome_mae` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `cadastro_tech`
--

INSERT INTO `cadastro_tech` (`idusuarios`, `nome`, `cpf`, `email`, `telefone`, `data_nasc`, `endereco`, `sexo`, `cep`, `senha`, `login`, `nome_mae`) VALUES
(31, 'admin', '170.385.747-01', 'admin@admin.com', '(21) 99802-7990', '2025-09-19', 'Rua Alto Parnaiba, Campo Grande, Rio de Janei', 'Masculino', '23015210', 'admin', 'admin', 'admin'),
(32, 'lojapc', '170.385.747-01', 'lojapc@gmail.com', '(21) 99802-7990', '2025-09-10', 'Rua Alto Parnaiba, Campo Grande, Rio de Janei', 'Masculino', '23015210', '1234', 'lojapc', 'monique');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cadastro_tech`
--
ALTER TABLE `cadastro_tech`
  ADD PRIMARY KEY (`idusuarios`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cadastro_tech`
--
ALTER TABLE `cadastro_tech`
  MODIFY `idusuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
