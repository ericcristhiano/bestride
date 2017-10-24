-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 30-Maio-2017 às 17:17
-- Versão do servidor: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `br_bestride`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `ride`
--

CREATE TABLE `ride` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `origin` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `available_seats` int(11) NOT NULL,
  `price` int(11) DEFAULT '0',
  `more_information` text,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `ride`
--

INSERT INTO `ride` (`id`, `date`, `origin`, `destination`, `available_seats`, `price`, `more_information`, `user_id`, `created_at`) VALUES
(1, '2017-05-31', 'Tubarão', 'Floripa', 3, 50, 'Motorista bom', 4, '0000-00-00 00:00:00'),
(2, '2017-05-25', 'Floripa', 'Tubarão', 2, 10, 'Good driver', 4, '0000-00-00 00:00:00'),
(3, '2017-05-17', 'Tubarão', 'Floripa', 3, 21, 'adsfasdf', 4, '2017-05-30 10:41:18'),
(4, '2017-05-31', 'SP', 'SC', 1, 15, 'test', 4, '2017-05-30 11:16:41'),
(5, '2017-05-31', 'UAHsdu', 'hudashdu', 1, 12, '12313', 4, '2017-05-30 11:18:06'),
(6, '2017-05-31', 'Tubarão', 'Maceió', 17, 500, 'Logo ali', 18, '2017-05-30 12:14:41'),
(7, '2017-05-04', 'Tubarão', 'Floripa', 1, 10, 'asdad', 18, '2017-05-30 12:15:21');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `birthdate`, `avatar`) VALUES
(4, 'Eric', 'ericcristhiano@gmail.com', '$2y$13$FC0P3uooTjJQpW/vso1bR.aBTckJqZw82Mvk3eHDszYj/aI//mQxm', '2017-05-16', 'uploads/4105c346e345dfa2a713b356de9cec9a.jpg'),
(18, 'Teste', 'teste@gmail.com', '$2y$13$RCn2lx27Kj5FgxWvefJ5EObxBG.k9s.aXLQED.mZ6Lkv3z1g7O4cW', '2017-05-22', 'uploads/b7543c7d1f5b79c823c97b2360598c65.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_ride`
--

CREATE TABLE `user_ride` (
  `user_id` int(11) NOT NULL,
  `ride_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `user_ride`
--

INSERT INTO `user_ride` (`user_id`, `ride_id`, `date`) VALUES
(4, 3, '2017-05-30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ride`
--
ALTER TABLE `ride`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ride_user_idx` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indexes for table `user_ride`
--
ALTER TABLE `user_ride`
  ADD PRIMARY KEY (`user_id`,`ride_id`),
  ADD KEY `fk_user_ride_ride1_idx` (`ride_id`),
  ADD KEY `fk_user_ride_user1_idx` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ride`
--
ALTER TABLE `ride`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `ride`
--
ALTER TABLE `ride`
  ADD CONSTRAINT `fk_ride_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `user_ride`
--
ALTER TABLE `user_ride`
  ADD CONSTRAINT `fk_user_ride_ride1` FOREIGN KEY (`ride_id`) REFERENCES `ride` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_ride_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
