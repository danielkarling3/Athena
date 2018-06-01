-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 01-Jun-2018 às 03:08
-- Versão do servidor: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aproveitamento`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `ADM`
--

CREATE TABLE `ADM` (
  `id` int(11) NOT NULL,
  `user` varchar(20) NOT NULL,
  `senha` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `ADM`
--

INSERT INTO `ADM` (`id`, `user`, `senha`) VALUES
(0, 'admin', 'athena123'),

-- --------------------------------------------------------

--
-- Estrutura da tabela `aproveitamento`
--

CREATE TABLE `aproveitamento` (
  `ID` int(11) NOT NULL,
  `NOME_PESSOA` varchar(255) DEFAULT NULL,
  `MATR_ALUNO` varchar(255) DEFAULT NULL,
  `NUM_VERSAO` int(11) DEFAULT NULL,
  `NOME_CURSO` varchar(255) DEFAULT NULL,
  `COD_CURSO` varchar(10) DEFAULT NULL,
  `ID_VERSAO_CURSO` int(11) DEFAULT NULL,
  `ANO` int(11) DEFAULT NULL,
  `COD_ATIV_CURRIC` varchar(10) DEFAULT NULL,
  `NOME_ATIV_CURRIC` varchar(100) DEFAULT NULL,
  `MEDIA_FINAL` double DEFAULT NULL,
  `DESCR_SITUACAO` varchar(10) DEFAULT NULL,
  `PERIODO` varchar(15) DEFAULT NULL,
  `ID_CURSO_ALUNO` int(11) DEFAULT NULL,
  `SITUACAO_ITEM` int(11) DEFAULT NULL,
  `CH_TEORICA` int(11) DEFAULT NULL,
  `CH_PRATICA` int(11) DEFAULT NULL,
  `TOTAL_CARGA_HORARIA` int(11) DEFAULT NULL,
  `ANO_INGRESSO` int(11) DEFAULT NULL,
  `FORMA_EVASAO` varchar(100) DEFAULT NULL,
  `ANO_EVASAO` int(11) DEFAULT NULL,
  `SEXO` varchar(1) DEFAULT NULL,
  `id_curso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Estrutura da tabela `compartilhado`
--

CREATE TABLE `compartilhado` (
  `id` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `id_compartilhado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Estrutura da tabela `curso`
--

CREATE TABLE `curso` (
  `id` int(11) NOT NULL,
  `codigo` varchar(15) NOT NULL,
  `nome` text NOT NULL,
  `semanas` int(11) NOT NULL,
  `cargaHoraria` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_periodo` int(11) NOT NULL,
  `visivel` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplina`
--

CREATE TABLE `disciplina` (
  `ID` int(11) NOT NULL,
  `CODIGO` varchar(10) NOT NULL,
  `NOME` varchar(255) DEFAULT NULL,
  `categoria` varchar(56) DEFAULT NULL,
  `curso` text NOT NULL,
  `TOTAL_CARGA_HORARIA` int(11) NOT NULL,
  `requisitoCadastrado` int(11) NOT NULL,
  `requisitada` int(1) NOT NULL DEFAULT '0',
  `ativa` int(11) NOT NULL,
  `id_curso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Estrutura da tabela `disc_horario`
--

CREATE TABLE `disc_horario` (
  `id_disciplina` int(11) NOT NULL,
  `id_horario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Estrutura da tabela `horario`
--

CREATE TABLE `horario` (
  `id_horario` int(11) NOT NULL,
  `hora_inicio` time NOT NULL,
  `dia` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `horario`
--

INSERT INTO `horario` (`id_horario`, `hora_inicio`, `dia`) VALUES
(1, '19:00:00', 'Segunda'),
(2, '21:00:00', 'Segunda'),
(3, '19:00:00', 'Terça'),
(4, '21:00:00', 'Terça'),
(5, '19:00:00', 'Quarta'),
(6, '21:00:00', 'Quarta'),
(7, '19:00:00', 'Quinta'),
(8, '21:00:00', 'Quinta'),
(9, '19:00:00', 'Sexta'),
(10, '21:00:00', 'Sexta'),
(11, '19:00:00', 'Sábado'),
(12, '21:00:00', 'Sábado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `periodo`
--

CREATE TABLE `periodo` (
  `id` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `periodo`
--

INSERT INTO `periodo` (`id`, `nome`) VALUES
(1, 'matutino'),
(2, 'vespertino'),
(3, 'noturno'),
(4, 'integral');

-- --------------------------------------------------------

--
-- Estrutura da tabela `requisito`
--

CREATE TABLE `requisito` (
  `id_disciplina` int(11) NOT NULL,
  `id_requisito` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `senha` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Indexes for dumped tables
--

--
-- Indexes for table `ADM`
--
ALTER TABLE `ADM`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aproveitamento`
--
ALTER TABLE `aproveitamento`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `aproveitamento_id_curso` (`id_curso`);

--
-- Indexes for table `compartilhado`
--
ALTER TABLE `compartilhado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_curso` (`id_curso`),
  ADD KEY `fk_usuario` (`id_compartilhado`);

--
-- Indexes for table `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `fk_curso_has_usuario` (`id_usuario`),
  ADD KEY `fk_periodo` (`id_periodo`);

--
-- Indexes for table `disciplina`
--
ALTER TABLE `disciplina`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_curso` (`id_curso`);

--
-- Indexes for table `disc_horario`
--
ALTER TABLE `disc_horario`
  ADD PRIMARY KEY (`id_disciplina`,`id_horario`),
  ADD KEY `chave_estrangeira2` (`id_horario`);

--
-- Indexes for table `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id_horario`);

--
-- Indexes for table `periodo`
--
ALTER TABLE `periodo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requisito`
--
ALTER TABLE `requisito`
  ADD PRIMARY KEY (`id_disciplina`,`id_requisito`),
  ADD KEY `fk_requisito` (`id_requisito`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aproveitamento`
--
ALTER TABLE `aproveitamento`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8777;
--
-- AUTO_INCREMENT for table `compartilhado`
--
ALTER TABLE `compartilhado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `curso`
--
ALTER TABLE `curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1019;
--
-- AUTO_INCREMENT for table `disciplina`
--
ALTER TABLE `disciplina`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=329;
--
-- AUTO_INCREMENT for table `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `periodo`
--
ALTER TABLE `periodo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `aproveitamento`
--
ALTER TABLE `aproveitamento`
  ADD CONSTRAINT `aproveitamento_id_curso` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id`);

--
-- Limitadores para a tabela `compartilhado`
--
ALTER TABLE `compartilhado`
  ADD CONSTRAINT `fk_curso` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id`),
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`id_compartilhado`) REFERENCES `usuario` (`id`);

--
-- Limitadores para a tabela `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `fk_curso_has_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_periodo` FOREIGN KEY (`id_periodo`) REFERENCES `periodo` (`id`);

--
-- Limitadores para a tabela `disciplina`
--
ALTER TABLE `disciplina`
  ADD CONSTRAINT `id_curso` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id`);

--
-- Limitadores para a tabela `disc_horario`
--
ALTER TABLE `disc_horario`
  ADD CONSTRAINT `chave_estrangeira1` FOREIGN KEY (`id_disciplina`) REFERENCES `disciplina` (`ID`),
  ADD CONSTRAINT `chave_estrangeira2` FOREIGN KEY (`id_horario`) REFERENCES `horario` (`id_horario`);

--
-- Limitadores para a tabela `requisito`
--
ALTER TABLE `requisito`
  ADD CONSTRAINT `fk_disc` FOREIGN KEY (`id_disciplina`) REFERENCES `disciplina` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
