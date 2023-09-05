-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Tempo de geração: 03/09/2023 às 03:22
-- Versão do servidor: 8.0.31
-- Versão do PHP: 8.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `estoque_dti`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `audits`
--

CREATE TABLE `audits` (
  `id` bigint UNSIGNED NOT NULL,
  `usuario_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usuario_id` bigint UNSIGNED DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_id` bigint UNSIGNED NOT NULL,
  `old_values` text COLLATE utf8mb4_unicode_ci,
  `new_values` text COLLATE utf8mb4_unicode_ci,
  `url` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(1023) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `audits`
--

INSERT INTO `audits` (`id`, `usuario_type`, `usuario_id`, `event`, `auditable_type`, `auditable_id`, `old_values`, `new_values`, `url`, `ip_address`, `user_agent`, `tags`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 6, '{\"qntde_estoque\":6}', '{\"qntde_estoque\":\"10\"}', 'http://localhost:8000/produtos/6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', NULL, '2023-07-17 18:59:37', '2023-07-17 18:59:37'),
(2, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Usuario', 4, '{\"status\":\"ATIVO\"}', '{\"status\":\"INATIVO\"}', 'http://localhost:8000/usuarios/4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', NULL, '2023-07-17 19:02:34', '2023-07-17 19:02:34'),
(3, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Usuario', 5, '{\"senha_provisoria\":null}', '{\"senha_provisoria\":\"$2y$10$XpDbDAO.mnks3\\/F7xMaEj.TPiUUBEtWvy.XiRGPPP0RZvU1ML5mom\"}', 'http://localhost:8000/usuarios/5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', NULL, '2023-07-17 19:02:55', '2023-07-17 19:02:55'),
(4, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 59, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"87\",\"divisao_id\":null,\"diretoria_id\":\"17\",\"id\":59}', 'http://localhost:8000/solicitar', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', NULL, '2023-07-17 19:03:41', '2023-07-17 19:03:41'),
(5, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 56, '[]', '{\"produto_id\":\"3\",\"qntde\":\"2\",\"solicitacao_id\":59,\"id\":56}', 'http://localhost:8000/solicitar', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', NULL, '2023-07-17 19:03:41', '2023-07-17 19:03:41'),
(6, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 3, '{\"qntde_solicitada\":0}', '{\"qntde_solicitada\":2}', 'http://localhost:8000/solicitar', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', NULL, '2023-07-17 19:03:41', '2023-07-17 19:03:41'),
(7, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 59, '{\"status\":\"ABERTO\"}', '{\"status\":\"ENCERRADO\"}', 'http://localhost:8000/solicitacoes/59', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', NULL, '2023-07-17 19:04:18', '2023-07-17 19:04:18'),
(8, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Entrega', 30, '[]', '{\"itens_solicitacao_id\":56,\"qntde\":\"2\",\"observacao\":null,\"usuario_id\":1,\"id\":30}', 'http://localhost:8000/solicitacoes/59', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', NULL, '2023-07-17 19:04:18', '2023-07-17 19:04:18'),
(9, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 3, '{\"qntde_estoque\":70,\"qntde_solicitada\":2}', '{\"qntde_estoque\":68,\"qntde_solicitada\":0}', 'http://localhost:8000/solicitacoes/59', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', NULL, '2023-07-17 19:04:18', '2023-07-17 19:04:18'),
(19, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 3, '{\"qntde_estoque\":68}', '{\"qntde_estoque\":70}', 'http://localhost:8000/solicitacoes/59', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', NULL, '2023-07-17 19:23:44', '2023-07-17 19:23:44'),
(20, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Entrega', 30, '{\"id\":30,\"qntde\":2,\"observacao\":null,\"usuario_id\":1,\"itens_solicitacao_id\":56,\"laravel_through_key\":59}', '[]', 'http://localhost:8000/solicitacoes/59', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', NULL, '2023-07-17 19:23:44', '2023-07-17 19:23:44'),
(21, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\ItensSolicitacao', 56, '{\"id\":56,\"qntde\":2,\"produto_id\":3,\"solicitacao_id\":59}', '[]', 'http://localhost:8000/solicitacoes/59', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', NULL, '2023-07-17 19:23:44', '2023-07-17 19:23:44'),
(22, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Solicitacao', 59, '{\"id\":59,\"status\":\"ENCERRADO\",\"observacao\":null,\"usuario_id\":87,\"divisao_id\":null,\"diretoria_id\":17}', '[]', 'http://localhost:8000/solicitacoes/59', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', NULL, '2023-07-17 19:23:44', '2023-07-17 19:23:44'),
(23, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Suprimento', 11, '{\"em_uso\":\"SIM\"}', '{\"em_uso\":\"NAO\"}', 'http://localhost:8000/produtos/1/suprimentos', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-03 20:24:38', '2023-08-03 20:24:38'),
(24, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 3, '{\"qntde_estoque\":70}', '{\"qntde_estoque\":\"0\"}', 'http://localhost:8000/produtos/3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-03 20:24:48', '2023-08-03 20:24:48'),
(25, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 60, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"1\",\"divisao_id\":\"15\",\"diretoria_id\":\"9\",\"id\":60}', 'http://localhost:8000/solicitar', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-03 20:25:08', '2023-08-03 20:25:08'),
(26, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 57, '[]', '{\"produto_id\":\"3\",\"qntde\":\"2\",\"solicitacao_id\":60,\"id\":57}', 'http://localhost:8000/solicitar', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-03 20:25:08', '2023-08-03 20:25:08'),
(27, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 3, '{\"qntde_solicitada\":0}', '{\"qntde_solicitada\":2}', 'http://localhost:8000/solicitar', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-03 20:25:09', '2023-08-03 20:25:09'),
(28, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 60, '{\"status\":\"ABERTO\"}', '{\"status\":\"AGUARDANDO\"}', 'http://localhost:8000/solicitar', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-03 20:25:09', '2023-08-03 20:25:09'),
(29, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 5, '{\"qntde_estoque\":15}', '{\"qntde_estoque\":\"0\"}', 'http://localhost:8000/produtos/5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-03 20:25:43', '2023-08-03 20:25:43'),
(30, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 61, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"1\",\"divisao_id\":\"15\",\"diretoria_id\":\"9\",\"id\":61}', 'http://localhost:8000/solicitar', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-03 20:26:06', '2023-08-03 20:26:06'),
(31, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 58, '[]', '{\"produto_id\":\"3\",\"qntde\":\"2\",\"solicitacao_id\":61,\"id\":58}', 'http://localhost:8000/solicitar', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-03 20:26:06', '2023-08-03 20:26:06'),
(32, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 3, '{\"qntde_solicitada\":2}', '{\"qntde_solicitada\":4}', 'http://localhost:8000/solicitar', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-03 20:26:06', '2023-08-03 20:26:06'),
(33, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 61, '{\"status\":\"ABERTO\"}', '{\"status\":\"AGUARDANDO\"}', 'http://localhost:8000/solicitar', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-03 20:26:06', '2023-08-03 20:26:06'),
(34, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 60, '{\"status\":\"AGUARDANDO\"}', '{\"status\":\"LIBERADO\"}', 'http://localhost:8000/produtos/3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-03 20:44:43', '2023-08-03 20:44:43'),
(35, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 61, '{\"status\":\"AGUARDANDO\"}', '{\"status\":\"LIBERADO\"}', 'http://localhost:8000/produtos/3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-03 20:44:50', '2023-08-03 20:44:50'),
(36, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 3, '{\"qntde_estoque\":0}', '{\"qntde_estoque\":\"4\"}', 'http://localhost:8000/produtos/3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-03 20:44:52', '2023-08-03 20:44:52'),
(37, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 61, '{\"status\":\"LIBERADO\"}', '{\"status\":\"ENCERRADO\"}', 'http://localhost:8000/solicitacoes/61', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-03 20:45:52', '2023-08-03 20:45:52'),
(38, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Entrega', 31, '[]', '{\"itens_solicitacao_id\":58,\"qntde\":\"2\",\"observacao\":null,\"usuario_id\":1,\"id\":31}', 'http://localhost:8000/solicitacoes/61', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-03 20:45:52', '2023-08-03 20:45:52'),
(39, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 3, '{\"qntde_estoque\":4,\"qntde_solicitada\":4}', '{\"qntde_estoque\":2,\"qntde_solicitada\":2}', 'http://localhost:8000/solicitacoes/61', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-03 20:45:52', '2023-08-03 20:45:52'),
(40, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Produto', 9, '[]', '{\"tipo_produto\":\"OUTROS\",\"modelo_produto\":\"Monitor LG\",\"qntde_estoque\":\"60\",\"status\":\"ATIVO\",\"descricao\":\"Excelente qualidade\",\"id\":9}', 'http://localhost:8080/produtos', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-22 23:35:11', '2023-08-22 23:35:11'),
(41, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Produto', 9, '{\"id\":9,\"tipo_produto\":\"OUTROS\",\"modelo_produto\":\"Monitor LG\",\"status\":\"ATIVO\",\"descricao\":\"Excelente qualidade\",\"qntde_estoque\":60,\"qntde_solicitada\":null}', '[]', 'http://localhost:8080/produtos/9', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-22 23:38:09', '2023-08-22 23:38:09'),
(42, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Produto', 8, '{\"id\":8,\"tipo_produto\":\"CILINDRO\",\"modelo_produto\":\"C3442 Milenium\",\"status\":\"ATIVO\",\"descricao\":null,\"qntde_estoque\":29,\"qntde_solicitada\":null}', '[]', 'http://localhost:8080/produtos/8', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-22 23:41:40', '2023-08-22 23:41:40'),
(43, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Produto', 10, '[]', '{\"tipo_produto\":\"CILINDRO\",\"modelo_produto\":\"C3442 Milenium\",\"qntde_estoque\":\"29\",\"status\":\"ATIVO\",\"descricao\":null,\"id\":10}', 'http://localhost:8080/produtos', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-22 23:55:00', '2023-08-22 23:55:00'),
(44, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Suprimento', 14, '[]', '{\"produto_id\":\"1\",\"suprimento_id\":10,\"em_uso\":\"SIM\",\"tipo_suprimento\":\"CILINDRO\",\"id\":14}', 'http://localhost:8080/produtos/10/impressoras', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-22 23:55:13', '2023-08-22 23:55:13'),
(45, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Suprimento', 14, '{\"em_uso\":\"SIM\"}', '{\"em_uso\":\"NAO\"}', 'http://localhost:8080/produtos/10/impressoras', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-22 23:56:44', '2023-08-22 23:56:44'),
(46, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Orgao', 16, '[]', '{\"nome\":\"Teste\",\"status\":\"ATIVO\",\"id\":16}', 'http://localhost:8080/orgaos', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 00:16:31', '2023-08-23 00:16:31'),
(47, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Orgao', 16, '{\"id\":16,\"nome\":\"Teste\",\"status\":\"ATIVO\"}', '[]', 'http://localhost:8080/orgaos/16', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 00:16:47', '2023-08-23 00:16:47'),
(48, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Diretoria', 27, '[]', '{\"nome\":\"Novo bagui\",\"orgao_id\":\"13\",\"email\":null,\"status\":\"ATIVO\",\"id\":27}', 'http://localhost:8080/diretorias', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 00:28:15', '2023-08-23 00:28:15'),
(49, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Diretoria', 27, '{\"id\":27,\"nome\":\"Novo bagui\",\"status\":\"ATIVO\",\"orgao_id\":13,\"email\":null}', '[]', 'http://localhost:8080/diretorias/27', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 00:28:30', '2023-08-23 00:28:30'),
(50, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Divisao', 27, '[]', '{\"nome\":\"teste\",\"diretoria_id\":\"20\",\"email\":null,\"status\":\"ATIVO\",\"id\":27}', 'http://localhost:8080/divisao', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 00:37:21', '2023-08-23 00:37:21'),
(51, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Divisao', 27, '{\"id\":27,\"nome\":\"teste\",\"status\":\"ATIVO\",\"diretoria_id\":20,\"email\":null}', '[]', 'http://localhost:8080/divisao/27', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 00:37:56', '2023-08-23 00:37:56'),
(52, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Usuario', 9, '{\"nome\":\"Darrion\"}', '{\"nome\":\"Cherri\"}', 'http://localhost:8080/usuarios/9', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 01:00:34', '2023-08-23 01:00:34'),
(53, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Usuario', 101, '[]', '{\"nome\":\"sla\",\"email\":\"sla@gmail\",\"user_interno\":\"SIM\",\"cpf\":\"11111111111\",\"status\":\"ATIVO\",\"diretoria_id\":\"1\",\"divisao_id\":\"1\",\"senha_provisoria\":\"$2y$10$2B1Bo.kzk\\/iu2KSu47obkejkfoj\\/cpZi8K64NdjAhqMhn.55YyKUe\",\"id\":101}', 'http://localhost:8080/usuarios', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 01:07:02', '2023-08-23 01:07:02'),
(54, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Usuario', 101, '{\"email\":\"sla@gmail\"}', '{\"email\":\"sla@gmail.com\"}', 'http://localhost:8080/usuarios/101', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 01:08:18', '2023-08-23 01:08:18'),
(55, NULL, NULL, 'updated', 'App\\Models\\Usuario', 101, '{\"senha\":null,\"senha_provisoria\":\"$2y$10$2B1Bo.kzk\\/iu2KSu47obkejkfoj\\/cpZi8K64NdjAhqMhn.55YyKUe\"}', '{\"senha\":\"$2y$10$J9rI0XSjA2szTEih9m275uTAS7.k45ueeaWSAmWz2fvwPhoYnXwwi\",\"senha_provisoria\":null}', 'http://localhost:8080/alterar-senha/101', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 01:09:10', '2023-08-23 01:09:10'),
(56, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Usuario', 101, '{\"id\":101,\"nome\":\"sla\",\"status\":\"ATIVO\",\"cpf\":11111111111,\"email\":\"sla@gmail.com\",\"senha\":\"$2y$10$J9rI0XSjA2szTEih9m275uTAS7.k45ueeaWSAmWz2fvwPhoYnXwwi\",\"senha_provisoria\":null,\"divisao_id\":1,\"diretoria_id\":1,\"user_interno\":\"SIM\"}', '[]', 'http://localhost:8080/usuarios/101', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 01:11:58', '2023-08-23 01:11:58'),
(57, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 62, '[]', '{\"status\":\"ABERTO\",\"observacao\":\"Funcione toast\",\"usuario_id\":\"1\",\"divisao_id\":\"15\",\"diretoria_id\":\"9\",\"id\":62}', 'http://localhost:8080/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 23:49:40', '2023-08-23 23:49:40'),
(58, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 59, '[]', '{\"produto_id\":\"3\",\"qntde\":\"2\",\"solicitacao_id\":62,\"id\":59}', 'http://localhost:8080/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 23:49:40', '2023-08-23 23:49:40'),
(59, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 3, '{\"qntde_solicitada\":2}', '{\"qntde_solicitada\":4}', 'http://localhost:8080/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 23:49:40', '2023-08-23 23:49:40'),
(60, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 62, '{\"status\":\"ABERTO\"}', '{\"status\":\"AGUARDANDO\"}', 'http://localhost:8080/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 23:49:40', '2023-08-23 23:49:40'),
(61, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 3, '{\"qntde_solicitada\":4}', '{\"qntde_solicitada\":2}', 'http://localhost:8080/solicitacoes/62', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 23:51:27', '2023-08-23 23:51:27'),
(62, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\ItensSolicitacao', 59, '{\"id\":59,\"qntde\":2,\"produto_id\":3,\"solicitacao_id\":62}', '[]', 'http://localhost:8080/solicitacoes/62', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 23:51:27', '2023-08-23 23:51:27'),
(63, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Solicitacao', 62, '{\"id\":62,\"status\":\"AGUARDANDO\",\"observacao\":\"Funcione toast\",\"usuario_id\":1,\"divisao_id\":15,\"diretoria_id\":9}', '[]', 'http://localhost:8080/solicitacoes/62', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 23:51:27', '2023-08-23 23:51:27'),
(64, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 63, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"1\",\"divisao_id\":\"15\",\"diretoria_id\":\"9\",\"id\":63}', 'http://localhost:8080/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 23:52:50', '2023-08-23 23:52:50'),
(65, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 60, '[]', '{\"produto_id\":\"3\",\"qntde\":\"2\",\"solicitacao_id\":63,\"id\":60}', 'http://localhost:8080/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 23:52:50', '2023-08-23 23:52:50'),
(66, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 3, '{\"qntde_solicitada\":2}', '{\"qntde_solicitada\":4}', 'http://localhost:8080/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 23:52:51', '2023-08-23 23:52:51'),
(67, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 63, '{\"status\":\"ABERTO\"}', '{\"status\":\"AGUARDANDO\"}', 'http://localhost:8080/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 23:52:51', '2023-08-23 23:52:51'),
(68, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 63, '{\"status\":\"AGUARDANDO\"}', '{\"status\":\"ABERTO\"}', 'http://localhost:8080/solicitacoes/63', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 23:53:16', '2023-08-23 23:53:16'),
(69, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 63, '{\"status\":\"ABERTO\"}', '{\"status\":\"AGUARDANDO\"}', 'http://localhost:8080/solicitacoes/63', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 23:58:02', '2023-08-23 23:58:02'),
(70, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 3, '{\"qntde_solicitada\":4}', '{\"qntde_solicitada\":2}', 'http://localhost:8080/solicitacoes/63', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 23:58:19', '2023-08-23 23:58:19'),
(71, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\ItensSolicitacao', 60, '{\"id\":60,\"qntde\":2,\"produto_id\":3,\"solicitacao_id\":63}', '[]', 'http://localhost:8080/solicitacoes/63', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 23:58:19', '2023-08-23 23:58:19'),
(72, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Solicitacao', 63, '{\"id\":63,\"status\":\"AGUARDANDO\",\"observacao\":null,\"usuario_id\":1,\"divisao_id\":15,\"diretoria_id\":9}', '[]', 'http://localhost:8080/solicitacoes/63', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-23 23:58:19', '2023-08-23 23:58:19'),
(73, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 1, '{\"qntde_estoque\":26}', '{\"qntde_estoque\":\"0\"}', 'http://localhost:8080/produtos/1', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-24 18:36:22', '2023-08-24 18:36:22'),
(74, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 2, '{\"qntde_estoque\":24}', '{\"qntde_estoque\":\"0\"}', 'http://localhost:8080/produtos/2', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-24 18:36:50', '2023-08-24 18:36:50'),
(75, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Orgao', 17, '[]', '{\"nome\":\"Teste\",\"status\":\"ATIVO\",\"id\":17}', 'http://localhost:8080/orgaos', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-26 03:32:55', '2023-08-26 03:32:55'),
(76, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Orgao', 1, '{\"status\":\"ATIVO\"}', '{\"status\":\"INATIVO\"}', 'http://localhost:8080/orgaos/1', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-26 03:35:27', '2023-08-26 03:35:27'),
(77, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Diretoria', 28, '[]', '{\"nome\":\"Teste\",\"orgao_id\":\"6\",\"email\":null,\"status\":\"INATIVO\",\"id\":28}', 'http://localhost/diretorias', '172.23.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-26 18:01:31', '2023-08-26 18:01:31'),
(78, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Diretoria', 28, '{\"id\":28,\"nome\":\"Teste\",\"status\":\"INATIVO\",\"orgao_id\":6,\"email\":null}', '[]', 'http://localhost/diretorias/28', '172.23.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-26 18:03:09', '2023-08-26 18:03:09'),
(79, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Usuario', 102, '[]', '{\"nome\":\"Teste da Silva\",\"email\":\"emailmassa@hotmail.com\",\"user_interno\":\"NAO\",\"cpf\":\"11111111111\",\"status\":\"ATIVO\",\"diretoria_id\":\"7\",\"divisao_id\":\"11\",\"senha_provisoria\":\"$2y$10$4Epk5x9Hz7GgLOPulmPlneh6whqDKsP7hmwGzocRg5K164qgnCi96\",\"id\":102}', 'http://localhost/usuarios', '172.24.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 00:16:40', '2023-08-27 00:16:40'),
(80, NULL, NULL, 'updated', 'App\\Models\\Usuario', 102, '{\"senha\":null,\"senha_provisoria\":\"$2y$10$4Epk5x9Hz7GgLOPulmPlneh6whqDKsP7hmwGzocRg5K164qgnCi96\"}', '{\"senha\":\"$2y$10$RYkrBTKIE4VQGylJ.5oDB.QFtliFg0AKpP4U2u30BMUsScTUNPUKi\",\"senha_provisoria\":null}', 'http://localhost/alterar-senha/102', '172.24.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 00:17:35', '2023-08-27 00:17:35'),
(81, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Usuario', 102, '{\"id\":102,\"nome\":\"Teste da Silva\",\"status\":\"ATIVO\",\"cpf\":11111111111,\"email\":\"emailmassa@hotmail.com\",\"senha\":\"$2y$10$RYkrBTKIE4VQGylJ.5oDB.QFtliFg0AKpP4U2u30BMUsScTUNPUKi\",\"senha_provisoria\":null,\"divisao_id\":11,\"diretoria_id\":7,\"user_interno\":\"NAO\"}', '[]', 'http://localhost/usuarios/102', '172.24.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 00:19:12', '2023-08-27 00:19:12'),
(82, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Divisao', 28, '[]', '{\"nome\":\"tetste\",\"diretoria_id\":\"25\",\"email\":null,\"status\":\"INATIVO\",\"id\":28}', 'http://localhost/divisao', '172.24.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 00:20:19', '2023-08-27 00:20:19'),
(83, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Divisao', 28, '{\"id\":28,\"nome\":\"tetste\",\"status\":\"INATIVO\",\"diretoria_id\":25,\"email\":null}', '[]', 'http://localhost/divisao/28', '172.24.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 00:20:35', '2023-08-27 00:20:35'),
(84, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Diretoria', 29, '[]', '{\"nome\":\"tuts tuts\",\"orgao_id\":\"13\",\"email\":null,\"status\":\"INATIVO\",\"id\":29}', 'http://localhost/diretorias', '172.24.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 00:21:14', '2023-08-27 00:21:14'),
(85, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Diretoria', 29, '{\"id\":29,\"nome\":\"tuts tuts\",\"status\":\"INATIVO\",\"orgao_id\":13,\"email\":null}', '[]', 'http://localhost/diretorias/29', '172.24.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 00:21:36', '2023-08-27 00:21:36'),
(86, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Orgao', 1, '{\"status\":\"INATIVO\"}', '{\"status\":\"ATIVO\"}', 'http://localhost/orgaos/1', '172.24.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 00:22:09', '2023-08-27 00:22:09'),
(87, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Orgao', 17, '{\"id\":17,\"nome\":\"Teste\",\"status\":\"ATIVO\"}', '[]', 'http://localhost/orgaos/17', '172.24.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 00:24:23', '2023-08-27 00:24:23'),
(88, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Produto', 11, '[]', '{\"tipo_produto\":\"OUTROS\",\"modelo_produto\":\"Tv 92 polegadas\",\"qntde_estoque\":\"64\",\"status\":\"ATIVO\",\"descricao\":null,\"id\":11}', 'http://localhost/produtos', '172.24.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 00:40:52', '2023-08-27 00:40:52'),
(89, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Produto', 11, '{\"id\":11,\"tipo_produto\":\"OUTROS\",\"modelo_produto\":\"Tv 92 polegadas\",\"status\":\"ATIVO\",\"descricao\":null,\"qntde_estoque\":64,\"qntde_solicitada\":null}', '[]', 'http://localhost/produtos/11', '172.24.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 00:41:05', '2023-08-27 00:41:05'),
(90, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Produto', 12, '[]', '{\"tipo_produto\":\"IMPRESSORA\",\"modelo_produto\":\"HP 1102nw\",\"qntde_estoque\":\"0\",\"status\":\"ATIVO\",\"descricao\":null,\"id\":12}', 'http://localhost/produtos', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 12:56:07', '2023-08-27 12:56:07'),
(91, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\LocalImpressora', 51, '[]', '{\"produto_id\":12,\"divisao_id\":\"4\",\"id\":51}', 'http://localhost/produtos/12/locais', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 12:56:28', '2023-08-27 12:56:28'),
(92, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\LocalImpressora', 52, '[]', '{\"produto_id\":12,\"diretoria_id\":\"23\",\"id\":52}', 'http://localhost/produtos/12/locais', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 12:56:28', '2023-08-27 12:56:28'),
(93, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\LocalImpressora', 53, '[]', '{\"produto_id\":12,\"divisao_id\":\"3\",\"id\":53}', 'http://localhost/produtos/12/locais', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 12:56:28', '2023-08-27 12:56:28'),
(94, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 12, '{\"qntde_estoque\":0}', '{\"qntde_estoque\":3}', 'http://localhost/produtos/12/locais', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 12:56:28', '2023-08-27 12:56:28'),
(95, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Produto', 13, '[]', '{\"tipo_produto\":\"TONER\",\"modelo_produto\":\"T2440 Tonali\",\"qntde_estoque\":\"56\",\"status\":\"ATIVO\",\"descricao\":\"Compativel com impressoras: ...\",\"id\":13}', 'http://localhost/produtos', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 12:58:33', '2023-08-27 12:58:33'),
(96, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Suprimento', 15, '[]', '{\"produto_id\":\"2\",\"suprimento_id\":13,\"em_uso\":\"SIM\",\"tipo_suprimento\":\"TONER\",\"id\":15}', 'http://localhost/produtos/13/impressoras', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 12:58:44', '2023-08-27 12:58:44'),
(97, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 13, '{\"qntde_estoque\":56}', '{\"qntde_estoque\":\"80\"}', 'http://localhost/produtos/13', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 12:59:03', '2023-08-27 12:59:03'),
(98, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Produto', 13, '{\"id\":13,\"tipo_produto\":\"TONER\",\"modelo_produto\":\"T2440 Tonali\",\"status\":\"ATIVO\",\"descricao\":\"Compativel com impressoras: ...\",\"qntde_estoque\":80,\"qntde_solicitada\":null}', '[]', 'http://localhost/produtos/13', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 12:59:12', '2023-08-27 12:59:12'),
(99, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Produto', 14, '[]', '{\"tipo_produto\":\"IMPRESSORA\",\"modelo_produto\":\"EPSON m136\",\"qntde_estoque\":\"0\",\"status\":\"ATIVO\",\"descricao\":null,\"id\":14}', 'http://localhost/produtos', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 12:59:52', '2023-08-27 12:59:52'),
(100, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\LocalImpressora', 54, '[]', '{\"produto_id\":14,\"divisao_id\":\"5\",\"id\":54}', 'http://localhost/produtos/14/locais', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 13:00:13', '2023-08-27 13:00:13'),
(101, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\LocalImpressora', 55, '[]', '{\"produto_id\":14,\"divisao_id\":\"3\",\"id\":55}', 'http://localhost/produtos/14/locais', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 13:00:13', '2023-08-27 13:00:13'),
(102, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\LocalImpressora', 56, '[]', '{\"produto_id\":14,\"diretoria_id\":\"1\",\"id\":56}', 'http://localhost/produtos/14/locais', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 13:00:13', '2023-08-27 13:00:13'),
(103, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 14, '{\"qntde_estoque\":0}', '{\"qntde_estoque\":3}', 'http://localhost/produtos/14/locais', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 13:00:13', '2023-08-27 13:00:13'),
(104, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Produto', 15, '[]', '{\"tipo_produto\":\"IMPRESSORA\",\"modelo_produto\":\"EPSON M135\",\"qntde_estoque\":\"0\",\"status\":\"ATIVO\",\"descricao\":null,\"id\":15}', 'http://localhost/produtos', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 13:02:15', '2023-08-27 13:02:15'),
(105, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\LocalImpressora', 57, '[]', '{\"produto_id\":15,\"diretoria_id\":\"1\",\"id\":57}', 'http://localhost/produtos/15/locais', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 13:02:28', '2023-08-27 13:02:28'),
(106, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\LocalImpressora', 58, '[]', '{\"produto_id\":15,\"divisao_id\":\"15\",\"id\":58}', 'http://localhost/produtos/15/locais', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 13:02:28', '2023-08-27 13:02:28'),
(107, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 15, '{\"qntde_estoque\":0}', '{\"qntde_estoque\":2}', 'http://localhost/produtos/15/locais', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 13:02:28', '2023-08-27 13:02:28'),
(108, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Suprimento', 16, '[]', '{\"produto_id\":15,\"suprimento_id\":\"4\",\"em_uso\":\"SIM\",\"tipo_suprimento\":\"TONER\",\"id\":16}', 'http://localhost/produtos/15/suprimentos', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 13:02:55', '2023-08-27 13:02:55'),
(109, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Suprimento', 17, '[]', '{\"produto_id\":15,\"suprimento_id\":\"7\",\"em_uso\":\"SIM\",\"tipo_suprimento\":\"CILINDRO\",\"id\":17}', 'http://localhost/produtos/15/suprimentos', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 13:02:55', '2023-08-27 13:02:55'),
(110, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Suprimento', 18, '[]', '{\"produto_id\":15,\"suprimento_id\":\"3\",\"em_uso\":\"NAO\",\"tipo_suprimento\":\"TONER\",\"id\":18}', 'http://localhost/produtos/15/suprimentos', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 13:02:55', '2023-08-27 13:02:55'),
(111, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Orgao', 18, '[]', '{\"nome\":\"Tr\\u00e2nsito\",\"status\":\"ATIVO\",\"id\":18}', 'http://localhost/orgaos', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 13:09:25', '2023-08-27 13:09:25'),
(112, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Orgao', 18, '{\"status\":\"ATIVO\"}', '{\"status\":\"INATIVO\"}', 'http://localhost/orgaos/18', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 13:09:36', '2023-08-27 13:09:36'),
(113, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Orgao', 18, '{\"id\":18,\"nome\":\"Tr\\u00e2nsito\",\"status\":\"INATIVO\"}', '[]', 'http://localhost/orgaos/18', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 13:09:57', '2023-08-27 13:09:57'),
(114, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Diretoria', 30, '[]', '{\"nome\":\"UBS Guarani\",\"orgao_id\":\"1\",\"email\":\"guarani@ubs.com\",\"status\":\"ATIVO\",\"id\":30}', 'http://localhost/diretorias', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 13:12:38', '2023-08-27 13:12:38'),
(115, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Diretoria', 30, '{\"id\":30,\"nome\":\"UBS Guarani\",\"status\":\"ATIVO\",\"orgao_id\":1,\"email\":\"guarani@ubs.com\"}', '[]', 'http://localhost/diretorias/30', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 13:13:06', '2023-08-27 13:13:06'),
(116, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Divisao', 29, '[]', '{\"nome\":\"Vigil\\u00e2ncia Sanit\\u00e1ria\",\"diretoria_id\":\"1\",\"email\":null,\"status\":\"ATIVO\",\"id\":29}', 'http://localhost/divisao', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 13:14:26', '2023-08-27 13:14:26'),
(117, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Divisao', 29, '{\"status\":\"ATIVO\"}', '{\"status\":\"INATIVO\"}', 'http://localhost/divisao/29', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 13:14:39', '2023-08-27 13:14:39'),
(118, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Divisao', 29, '{\"id\":29,\"nome\":\"Vigil\\u00e2ncia Sanit\\u00e1ria\",\"status\":\"INATIVO\",\"diretoria_id\":1,\"email\":null}', '[]', 'http://localhost/divisao/29', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 13:14:53', '2023-08-27 13:14:53'),
(119, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Usuario', 103, '[]', '{\"nome\":\"Alex\",\"email\":\"alex@umuarama.com.br\",\"user_interno\":\"SIM\",\"cpf\":\"83910593482\",\"status\":\"ATIVO\",\"diretoria_id\":\"3\",\"senha_provisoria\":\"$2y$10$\\/NssyRcnfLdAP.VA98E6sOrdSuXO8WgWZdPJIbZNm8Zq9jaGbz4H6\",\"id\":103}', 'http://localhost/usuarios', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 13:18:17', '2023-08-27 13:18:17'),
(120, NULL, NULL, 'updated', 'App\\Models\\Usuario', 103, '{\"senha\":null,\"senha_provisoria\":\"$2y$10$\\/NssyRcnfLdAP.VA98E6sOrdSuXO8WgWZdPJIbZNm8Zq9jaGbz4H6\"}', '{\"senha\":\"$2y$10$EQTaw5iy4VegrqRD4tN1\\/e7WMaU7EmSepMr0q\\/7TnYin0AcACYJ5i\",\"senha_provisoria\":null}', 'http://localhost/alterar-senha/103', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 13:18:48', '2023-08-27 13:18:48'),
(121, 'App\\Models\\Usuario', 103, 'created', 'App\\Models\\Solicitacao', 64, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"103\",\"divisao_id\":null,\"diretoria_id\":\"3\",\"id\":64}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 14:32:02', '2023-08-27 14:32:02'),
(122, 'App\\Models\\Usuario', 103, 'created', 'App\\Models\\ItensSolicitacao', 61, '[]', '{\"produto_id\":\"3\",\"qntde\":\"2\",\"solicitacao_id\":64,\"id\":61}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 14:32:02', '2023-08-27 14:32:02'),
(123, 'App\\Models\\Usuario', 103, 'updated', 'App\\Models\\Produto', 3, '{\"qntde_solicitada\":2}', '{\"qntde_solicitada\":4}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 14:32:02', '2023-08-27 14:32:02'),
(124, 'App\\Models\\Usuario', 103, 'updated', 'App\\Models\\Solicitacao', 64, '{\"status\":\"ABERTO\"}', '{\"status\":\"AGUARDANDO\"}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 14:32:02', '2023-08-27 14:32:02'),
(125, 'App\\Models\\Usuario', 103, 'updated', 'App\\Models\\Solicitacao', 64, '{\"status\":\"AGUARDANDO\"}', '{\"status\":\"ENCERRADO\"}', 'http://localhost/solicitacoes/64', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 14:32:20', '2023-08-27 14:32:20'),
(126, 'App\\Models\\Usuario', 103, 'created', 'App\\Models\\Entrega', 32, '[]', '{\"itens_solicitacao_id\":61,\"qntde\":\"2\",\"observacao\":null,\"usuario_id\":103,\"id\":32}', 'http://localhost/solicitacoes/64', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 14:32:20', '2023-08-27 14:32:20'),
(127, 'App\\Models\\Usuario', 103, 'updated', 'App\\Models\\Produto', 3, '{\"qntde_estoque\":2,\"qntde_solicitada\":4}', '{\"qntde_estoque\":0,\"qntde_solicitada\":2}', 'http://localhost/solicitacoes/64', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-27 14:32:20', '2023-08-27 14:32:20'),
(128, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 1, '{\"qntde_estoque\":0}', '{\"qntde_estoque\":26}', 'http://localhost/produtos/1/locais', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:16:48', '2023-08-28 20:16:48'),
(129, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 2, '{\"qntde_estoque\":0}', '{\"qntde_estoque\":24}', 'http://localhost/produtos/2/locais', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:16:55', '2023-08-28 20:16:55'),
(130, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 65, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"6\",\"divisao_id\":null,\"diretoria_id\":\"10\",\"id\":65}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:24:58', '2023-08-28 20:24:58'),
(131, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 62, '[]', '{\"produto_id\":\"3\",\"qntde\":\"2\",\"solicitacao_id\":65,\"id\":62}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:24:58', '2023-08-28 20:24:58'),
(132, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 3, '{\"qntde_solicitada\":2}', '{\"qntde_solicitada\":4}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:24:58', '2023-08-28 20:24:58'),
(133, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 65, '{\"status\":\"ABERTO\"}', '{\"status\":\"AGUARDANDO\"}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:24:58', '2023-08-28 20:24:58'),
(134, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 66, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"62\",\"divisao_id\":\"23\",\"diretoria_id\":\"23\",\"id\":66}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:25:28', '2023-08-28 20:25:28'),
(135, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 63, '[]', '{\"produto_id\":\"5\",\"qntde\":\"2\",\"solicitacao_id\":66,\"id\":63}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:25:28', '2023-08-28 20:25:28'),
(136, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 5, '{\"qntde_solicitada\":1}', '{\"qntde_solicitada\":3}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:25:28', '2023-08-28 20:25:28'),
(137, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 66, '{\"status\":\"ABERTO\"}', '{\"status\":\"AGUARDANDO\"}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:25:28', '2023-08-28 20:25:28'),
(138, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 67, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"31\",\"divisao_id\":\"25\",\"diretoria_id\":\"26\",\"id\":67}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:25:44', '2023-08-28 20:25:44'),
(139, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 64, '[]', '{\"produto_id\":\"3\",\"qntde\":\"1\",\"solicitacao_id\":67,\"id\":64}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:25:44', '2023-08-28 20:25:44'),
(140, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 3, '{\"qntde_solicitada\":4}', '{\"qntde_solicitada\":5}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:25:44', '2023-08-28 20:25:44'),
(141, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 67, '{\"status\":\"ABERTO\"}', '{\"status\":\"AGUARDANDO\"}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:25:44', '2023-08-28 20:25:44'),
(142, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 65, '[]', '{\"produto_id\":\"7\",\"qntde\":\"1\",\"solicitacao_id\":67,\"id\":65}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:25:44', '2023-08-28 20:25:44'),
(143, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 7, '{\"qntde_solicitada\":0}', '{\"qntde_solicitada\":1}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:25:44', '2023-08-28 20:25:44'),
(144, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 68, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"1\",\"divisao_id\":\"15\",\"diretoria_id\":\"9\",\"id\":68}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:25:59', '2023-08-28 20:25:59'),
(145, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 66, '[]', '{\"produto_id\":\"4\",\"qntde\":\"1\",\"solicitacao_id\":68,\"id\":66}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:25:59', '2023-08-28 20:25:59'),
(146, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 4, '{\"qntde_solicitada\":null}', '{\"qntde_solicitada\":1}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:26:00', '2023-08-28 20:26:00'),
(147, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 69, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"24\",\"divisao_id\":null,\"diretoria_id\":\"6\",\"id\":69}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:26:42', '2023-08-28 20:26:42'),
(148, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 67, '[]', '{\"produto_id\":\"4\",\"qntde\":\"1\",\"solicitacao_id\":69,\"id\":67}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:26:42', '2023-08-28 20:26:42'),
(149, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 4, '{\"qntde_solicitada\":1}', '{\"qntde_solicitada\":2}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:26:42', '2023-08-28 20:26:42');
INSERT INTO `audits` (`id`, `usuario_type`, `usuario_id`, `event`, `auditable_type`, `auditable_id`, `old_values`, `new_values`, `url`, `ip_address`, `user_agent`, `tags`, `created_at`, `updated_at`) VALUES
(150, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 70, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"1\",\"divisao_id\":\"15\",\"diretoria_id\":\"9\",\"id\":70}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:27:11', '2023-08-28 20:27:11'),
(151, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 68, '[]', '{\"produto_id\":\"5\",\"qntde\":\"1\",\"solicitacao_id\":70,\"id\":68}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:27:11', '2023-08-28 20:27:11'),
(152, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 5, '{\"qntde_solicitada\":3}', '{\"qntde_solicitada\":4}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:27:11', '2023-08-28 20:27:11'),
(153, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 70, '{\"status\":\"ABERTO\"}', '{\"status\":\"AGUARDANDO\"}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:27:11', '2023-08-28 20:27:11'),
(154, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 71, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"13\",\"divisao_id\":null,\"diretoria_id\":\"25\",\"id\":71}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:27:39', '2023-08-28 20:27:39'),
(155, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 69, '[]', '{\"produto_id\":\"4\",\"qntde\":\"2\",\"solicitacao_id\":71,\"id\":69}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:27:39', '2023-08-28 20:27:39'),
(156, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 4, '{\"qntde_solicitada\":2}', '{\"qntde_solicitada\":4}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:27:39', '2023-08-28 20:27:39'),
(157, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 72, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"19\",\"divisao_id\":\"8\",\"diretoria_id\":\"5\",\"id\":72}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:28:17', '2023-08-28 20:28:17'),
(158, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 70, '[]', '{\"produto_id\":\"4\",\"qntde\":\"1\",\"solicitacao_id\":72,\"id\":70}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:28:17', '2023-08-28 20:28:17'),
(159, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 4, '{\"qntde_solicitada\":4}', '{\"qntde_solicitada\":5}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:28:17', '2023-08-28 20:28:17'),
(160, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 73, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"82\",\"divisao_id\":\"6\",\"diretoria_id\":\"2\",\"id\":73}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:28:38', '2023-08-28 20:28:38'),
(161, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 71, '[]', '{\"produto_id\":\"4\",\"qntde\":\"2\",\"solicitacao_id\":73,\"id\":71}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:28:38', '2023-08-28 20:28:38'),
(162, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 4, '{\"qntde_solicitada\":5}', '{\"qntde_solicitada\":7}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:28:38', '2023-08-28 20:28:38'),
(163, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 74, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"77\",\"divisao_id\":\"6\",\"diretoria_id\":\"2\",\"id\":74}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:28:52', '2023-08-28 20:28:52'),
(164, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 72, '[]', '{\"produto_id\":\"7\",\"qntde\":\"2\",\"solicitacao_id\":74,\"id\":72}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:28:52', '2023-08-28 20:28:52'),
(165, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 7, '{\"qntde_solicitada\":1}', '{\"qntde_solicitada\":3}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:28:52', '2023-08-28 20:28:52'),
(166, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 75, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"61\",\"divisao_id\":\"11\",\"diretoria_id\":\"7\",\"id\":75}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:29:14', '2023-08-28 20:29:14'),
(167, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 73, '[]', '{\"produto_id\":\"4\",\"qntde\":\"2\",\"solicitacao_id\":75,\"id\":73}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:29:14', '2023-08-28 20:29:14'),
(168, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 4, '{\"qntde_solicitada\":7}', '{\"qntde_solicitada\":9}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:29:14', '2023-08-28 20:29:14'),
(169, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 76, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"27\",\"divisao_id\":null,\"diretoria_id\":\"22\",\"id\":76}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:30:05', '2023-08-28 20:30:05'),
(170, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 74, '[]', '{\"produto_id\":\"7\",\"qntde\":\"1\",\"solicitacao_id\":76,\"id\":74}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:30:05', '2023-08-28 20:30:05'),
(171, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 7, '{\"qntde_solicitada\":3}', '{\"qntde_solicitada\":4}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:30:05', '2023-08-28 20:30:05'),
(172, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 77, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"3\",\"divisao_id\":null,\"diretoria_id\":\"10\",\"id\":77}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:30:18', '2023-08-28 20:30:18'),
(173, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 75, '[]', '{\"produto_id\":\"4\",\"qntde\":\"2\",\"solicitacao_id\":77,\"id\":75}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:30:18', '2023-08-28 20:30:18'),
(174, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 4, '{\"qntde_solicitada\":9}', '{\"qntde_solicitada\":11}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:30:18', '2023-08-28 20:30:18'),
(175, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 76, '[]', '{\"produto_id\":\"7\",\"qntde\":\"2\",\"solicitacao_id\":77,\"id\":76}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:30:18', '2023-08-28 20:30:18'),
(176, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 7, '{\"qntde_solicitada\":4}', '{\"qntde_solicitada\":6}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:30:18', '2023-08-28 20:30:18'),
(177, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 68, '{\"status\":\"ABERTO\"}', '{\"status\":\"ENCERRADO\"}', 'http://localhost/solicitacoes/68', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:30:50', '2023-08-28 20:30:50'),
(178, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Entrega', 33, '[]', '{\"itens_solicitacao_id\":66,\"qntde\":\"1\",\"observacao\":null,\"usuario_id\":1,\"id\":33}', 'http://localhost/solicitacoes/68', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:30:50', '2023-08-28 20:30:50'),
(179, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 4, '{\"qntde_estoque\":30,\"qntde_solicitada\":11}', '{\"qntde_estoque\":29,\"qntde_solicitada\":10}', 'http://localhost/solicitacoes/68', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:30:50', '2023-08-28 20:30:50'),
(180, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 78, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"56\",\"divisao_id\":\"5\",\"diretoria_id\":\"2\",\"id\":78}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:31:20', '2023-08-28 20:31:20'),
(181, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 77, '[]', '{\"produto_id\":\"7\",\"qntde\":\"1\",\"solicitacao_id\":78,\"id\":77}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:31:20', '2023-08-28 20:31:20'),
(182, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 7, '{\"qntde_solicitada\":6}', '{\"qntde_solicitada\":7}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 20:31:20', '2023-08-28 20:31:20'),
(183, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 78, '{\"status\":\"ABERTO\"}', '{\"status\":\"ENCERRADO\"}', 'http://localhost/solicitacoes/78', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:39:41', '2023-08-28 21:39:41'),
(184, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Entrega', 34, '[]', '{\"itens_solicitacao_id\":77,\"qntde\":\"1\",\"observacao\":null,\"usuario_id\":1,\"id\":34}', 'http://localhost/solicitacoes/78', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:39:41', '2023-08-28 21:39:41'),
(185, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 7, '{\"qntde_estoque\":31,\"qntde_solicitada\":7}', '{\"qntde_estoque\":30,\"qntde_solicitada\":6}', 'http://localhost/solicitacoes/78', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:39:41', '2023-08-28 21:39:41'),
(186, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 77, '{\"status\":\"ABERTO\"}', '{\"status\":\"ENCERRADO\"}', 'http://localhost/solicitacoes/77', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:39:50', '2023-08-28 21:39:50'),
(187, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Entrega', 35, '[]', '{\"itens_solicitacao_id\":75,\"qntde\":\"2\",\"observacao\":null,\"usuario_id\":1,\"id\":35}', 'http://localhost/solicitacoes/77', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:39:50', '2023-08-28 21:39:50'),
(188, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 4, '{\"qntde_estoque\":29,\"qntde_solicitada\":10}', '{\"qntde_estoque\":27,\"qntde_solicitada\":8}', 'http://localhost/solicitacoes/77', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:39:50', '2023-08-28 21:39:50'),
(189, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Entrega', 36, '[]', '{\"itens_solicitacao_id\":76,\"qntde\":\"2\",\"observacao\":null,\"usuario_id\":1,\"id\":36}', 'http://localhost/solicitacoes/77', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:39:50', '2023-08-28 21:39:50'),
(190, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 7, '{\"qntde_estoque\":30,\"qntde_solicitada\":6}', '{\"qntde_estoque\":28,\"qntde_solicitada\":4}', 'http://localhost/solicitacoes/77', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:39:50', '2023-08-28 21:39:50'),
(191, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Entrega', 37, '[]', '{\"itens_solicitacao_id\":74,\"qntde\":\"1\",\"observacao\":null,\"usuario_id\":1,\"id\":37}', 'http://localhost/solicitacoes/76', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:39:56', '2023-08-28 21:39:56'),
(192, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 7, '{\"qntde_estoque\":28,\"qntde_solicitada\":4}', '{\"qntde_estoque\":27,\"qntde_solicitada\":3}', 'http://localhost/solicitacoes/76', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:39:56', '2023-08-28 21:39:56'),
(193, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 76, '{\"status\":\"ABERTO\"}', '{\"status\":\"ENCERRADO\"}', 'http://localhost/solicitacoes/76', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:40:03', '2023-08-28 21:40:03'),
(194, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 75, '{\"status\":\"ABERTO\"}', '{\"status\":\"ENCERRADO\"}', 'http://localhost/solicitacoes/75', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:40:09', '2023-08-28 21:40:09'),
(195, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Entrega', 38, '[]', '{\"itens_solicitacao_id\":73,\"qntde\":\"2\",\"observacao\":null,\"usuario_id\":1,\"id\":38}', 'http://localhost/solicitacoes/75', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:40:09', '2023-08-28 21:40:09'),
(196, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 4, '{\"qntde_estoque\":27,\"qntde_solicitada\":8}', '{\"qntde_estoque\":25,\"qntde_solicitada\":6}', 'http://localhost/solicitacoes/75', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:40:09', '2023-08-28 21:40:09'),
(197, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 79, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"83\",\"divisao_id\":null,\"diretoria_id\":\"25\",\"id\":79}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:40:31', '2023-08-28 21:40:31'),
(198, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 78, '[]', '{\"produto_id\":\"7\",\"qntde\":\"2\",\"solicitacao_id\":79,\"id\":78}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:40:31', '2023-08-28 21:40:31'),
(199, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 7, '{\"qntde_solicitada\":3}', '{\"qntde_solicitada\":5}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:40:31', '2023-08-28 21:40:31'),
(200, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 80, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"63\",\"divisao_id\":null,\"diretoria_id\":\"4\",\"id\":80}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:40:45', '2023-08-28 21:40:45'),
(201, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 79, '[]', '{\"produto_id\":\"3\",\"qntde\":\"2\",\"solicitacao_id\":80,\"id\":79}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:40:45', '2023-08-28 21:40:45'),
(202, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 3, '{\"qntde_solicitada\":5}', '{\"qntde_solicitada\":7}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:40:45', '2023-08-28 21:40:45'),
(203, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 80, '{\"status\":\"ABERTO\"}', '{\"status\":\"AGUARDANDO\"}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:40:45', '2023-08-28 21:40:45'),
(204, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 81, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"62\",\"divisao_id\":\"23\",\"diretoria_id\":\"23\",\"id\":81}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:40:58', '2023-08-28 21:40:58'),
(205, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 80, '[]', '{\"produto_id\":\"3\",\"qntde\":\"2\",\"solicitacao_id\":81,\"id\":80}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:40:58', '2023-08-28 21:40:58'),
(206, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 3, '{\"qntde_solicitada\":7}', '{\"qntde_solicitada\":9}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:40:58', '2023-08-28 21:40:58'),
(207, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 81, '{\"status\":\"ABERTO\"}', '{\"status\":\"AGUARDANDO\"}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:40:58', '2023-08-28 21:40:58'),
(208, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 82, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"45\",\"divisao_id\":null,\"diretoria_id\":\"13\",\"id\":82}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:41:59', '2023-08-28 21:41:59'),
(209, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 81, '[]', '{\"produto_id\":\"7\",\"qntde\":\"2\",\"solicitacao_id\":82,\"id\":81}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:41:59', '2023-08-28 21:41:59'),
(210, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 7, '{\"qntde_solicitada\":5}', '{\"qntde_solicitada\":7}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 21:41:59', '2023-08-28 21:41:59'),
(211, 'App\\Models\\Usuario', 2, 'created', 'App\\Models\\Solicitacao', 83, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":2,\"divisao_id\":10,\"diretoria_id\":7,\"id\":83}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 22:02:40', '2023-08-28 22:02:40'),
(212, 'App\\Models\\Usuario', 2, 'created', 'App\\Models\\ItensSolicitacao', 82, '[]', '{\"produto_id\":\"7\",\"qntde\":\"2\",\"solicitacao_id\":83,\"id\":82}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 22:02:40', '2023-08-28 22:02:40'),
(213, 'App\\Models\\Usuario', 2, 'updated', 'App\\Models\\Produto', 7, '{\"qntde_solicitada\":7}', '{\"qntde_solicitada\":9}', 'http://localhost/solicitar', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', NULL, '2023-08-28 22:02:40', '2023-08-28 22:02:40'),
(214, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Produto', 16, '[]', '{\"tipo_produto\":\"IMPRESSORA\",\"modelo_produto\":\"teste\",\"qntde_estoque\":\"0\",\"status\":\"ATIVO\",\"descricao\":null,\"id\":16}', 'http://localhost/produtos', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/117.0', NULL, '2023-08-31 19:55:35', '2023-08-31 19:55:35'),
(215, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Produto', 16, '{\"id\":16,\"tipo_produto\":\"IMPRESSORA\",\"modelo_produto\":\"teste\",\"status\":\"ATIVO\",\"descricao\":null,\"qntde_estoque\":0,\"qntde_solicitada\":null}', '[]', 'http://localhost/produtos/16', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/117.0', NULL, '2023-08-31 19:58:18', '2023-08-31 19:58:18'),
(216, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Produto', 17, '[]', '{\"tipo_produto\":\"IMPRESSORA\",\"modelo_produto\":\"sla\",\"qntde_estoque\":\"0\",\"status\":\"INATIVO\",\"descricao\":null,\"id\":17}', 'http://localhost/produtos', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/117.0', NULL, '2023-08-31 21:06:04', '2023-08-31 21:06:04'),
(217, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\LocalImpressora', 59, '[]', '{\"produto_id\":17,\"diretoria_id\":\"4\",\"id\":59}', 'http://localhost/produtos/17/locais', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/117.0', NULL, '2023-08-31 21:06:22', '2023-08-31 21:06:22'),
(218, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 17, '{\"qntde_estoque\":0}', '{\"qntde_estoque\":1}', 'http://localhost/produtos/17/locais', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/117.0', NULL, '2023-08-31 21:06:22', '2023-08-31 21:06:22'),
(219, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Suprimento', 19, '[]', '{\"produto_id\":17,\"suprimento_id\":\"10\",\"em_uso\":\"NAO\",\"tipo_suprimento\":\"CILINDRO\",\"id\":19}', 'http://localhost/produtos/17/suprimentos', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/117.0', NULL, '2023-08-31 21:06:32', '2023-08-31 21:06:32'),
(220, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Produto', 17, '{\"id\":17,\"tipo_produto\":\"IMPRESSORA\",\"modelo_produto\":\"sla\",\"status\":\"INATIVO\",\"descricao\":null,\"qntde_estoque\":1,\"qntde_solicitada\":null}', '[]', 'http://localhost/produtos/17', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/117.0', NULL, '2023-08-31 21:06:39', '2023-08-31 21:06:39'),
(221, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Produto', 18, '[]', '{\"tipo_produto\":\"CILINDRO\",\"modelo_produto\":\"sla\",\"qntde_estoque\":\"54\",\"status\":\"ATIVO\",\"descricao\":null,\"id\":18}', 'http://localhost/produtos', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/117.0', NULL, '2023-08-31 21:06:53', '2023-08-31 21:06:53'),
(222, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Suprimento', 20, '[]', '{\"produto_id\":\"1\",\"suprimento_id\":18,\"em_uso\":\"NAO\",\"tipo_suprimento\":\"CILINDRO\",\"id\":20}', 'http://localhost/produtos/18/impressoras', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/117.0', NULL, '2023-08-31 21:07:02', '2023-08-31 21:07:02'),
(223, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Produto', 18, '{\"id\":18,\"tipo_produto\":\"CILINDRO\",\"modelo_produto\":\"sla\",\"status\":\"ATIVO\",\"descricao\":null,\"qntde_estoque\":54,\"qntde_solicitada\":null}', '[]', 'http://localhost/produtos/18', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/117.0', NULL, '2023-08-31 21:07:12', '2023-08-31 21:07:12'),
(235, 'App\\Models\\Usuario', 1, 'deleted', 'App\\Models\\Solicitacao', 84, '{\"id\":84,\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":1,\"divisao_id\":15,\"diretoria_id\":9}', '[]', 'http://localhost/solicitacoes/84', '172.20.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/117.0', NULL, '2023-09-02 02:15:58', '2023-09-02 02:15:58'),
(236, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 85, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"1\",\"divisao_id\":\"15\",\"diretoria_id\":\"9\",\"id\":85}', 'http://localhost/solicitar', '172.20.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/117.0', NULL, '2023-09-02 02:16:12', '2023-09-02 02:16:12'),
(237, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 83, '[]', '{\"produto_id\":\"3\",\"qntde\":\"1\",\"solicitacao_id\":85,\"id\":83}', 'http://localhost/solicitar', '172.20.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/117.0', NULL, '2023-09-02 02:16:12', '2023-09-02 02:16:12'),
(238, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 3, '{\"qntde_solicitada\":9}', '{\"qntde_solicitada\":10}', 'http://localhost/solicitar', '172.20.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/117.0', NULL, '2023-09-02 02:16:12', '2023-09-02 02:16:12'),
(239, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 85, '{\"status\":\"ABERTO\"}', '{\"status\":\"AGUARDANDO\"}', 'http://localhost/solicitar', '172.20.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/117.0', NULL, '2023-09-02 02:16:12', '2023-09-02 02:16:12'),
(240, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\Solicitacao', 86, '[]', '{\"status\":\"ABERTO\",\"observacao\":null,\"usuario_id\":\"35\",\"divisao_id\":\"6\",\"diretoria_id\":\"2\",\"id\":86}', 'http://localhost/solicitar', '172.20.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/117.0', NULL, '2023-09-02 02:17:00', '2023-09-02 02:17:00'),
(241, 'App\\Models\\Usuario', 1, 'created', 'App\\Models\\ItensSolicitacao', 84, '[]', '{\"produto_id\":\"5\",\"qntde\":\"1\",\"solicitacao_id\":86,\"id\":84}', 'http://localhost/solicitar', '172.20.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/117.0', NULL, '2023-09-02 02:17:00', '2023-09-02 02:17:00'),
(242, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Produto', 5, '{\"qntde_solicitada\":4}', '{\"qntde_solicitada\":5}', 'http://localhost/solicitar', '172.20.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/117.0', NULL, '2023-09-02 02:17:00', '2023-09-02 02:17:00'),
(243, 'App\\Models\\Usuario', 1, 'updated', 'App\\Models\\Solicitacao', 86, '{\"status\":\"ABERTO\"}', '{\"status\":\"AGUARDANDO\"}', 'http://localhost/solicitar', '172.20.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/117.0', NULL, '2023-09-02 02:17:00', '2023-09-02 02:17:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `diretorias`
--

CREATE TABLE `diretorias` (
  `id` bigint UNSIGNED NOT NULL,
  `nome` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('ATIVO','INATIVO') COLLATE utf8mb4_unicode_ci NOT NULL,
  `orgao_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `diretorias`
--

INSERT INTO `diretorias` (`id`, `nome`, `status`, `orgao_id`, `created_at`, `updated_at`, `email`) VALUES
(1, 'Secretaria de Saúde', 'ATIVO', 1, '2023-06-08 18:08:28', '2023-06-08 18:08:28', NULL),
(2, 'Farmácia Central', 'ATIVO', 1, '2023-06-08 18:08:28', '2023-06-08 18:08:28', NULL),
(3, 'Secretaria de Agricultura', 'ATIVO', 2, '2023-06-08 18:08:28', '2023-06-08 18:08:28', NULL),
(4, 'Atos Oficiais', 'ATIVO', 3, '2023-06-08 18:08:29', '2023-06-08 18:08:29', NULL),
(5, 'Secretaria de Habitação', 'ATIVO', 4, '2023-06-08 18:08:29', '2023-06-08 18:08:29', NULL),
(6, 'Secretaria de Fazenda', 'ATIVO', 5, '2023-06-08 18:08:29', '2023-06-08 18:08:29', NULL),
(7, 'IPTU', 'ATIVO', 5, '2023-06-08 18:08:29', '2023-06-08 18:08:29', NULL),
(8, 'Secretaria de Administração', 'ATIVO', 6, '2023-06-08 18:08:29', '2023-06-08 18:08:29', NULL),
(9, 'Diretoria de TI', 'ATIVO', 6, '2023-06-08 18:08:29', '2023-07-11 19:56:55', 'santhiago.monteiro@hotmail.com'),
(10, 'Secretaria de Obras', 'ATIVO', 7, '2023-06-08 18:08:30', '2023-06-08 18:08:30', NULL),
(11, 'Planejamento Urbano', 'ATIVO', 7, '2023-06-08 18:08:30', '2023-06-08 18:08:30', NULL),
(12, 'Projetos Técnicos', 'ATIVO', 7, '2023-06-08 18:08:30', '2023-06-08 18:08:30', NULL),
(13, 'Secretaria de Gabinete', 'ATIVO', 8, '2023-06-08 18:08:30', '2023-06-08 18:08:30', NULL),
(14, 'Gabinete do Prefeito', 'ATIVO', 8, '2023-06-08 18:08:30', '2023-06-08 18:08:30', NULL),
(15, 'Secretaria de Esportes', 'ATIVO', 9, '2023-06-08 18:08:30', '2023-06-08 18:08:30', NULL),
(16, 'Secretaria de Meio Ambiente', 'ATIVO', 10, '2023-06-08 18:08:30', '2023-06-08 18:08:30', NULL),
(17, 'Jurídico', 'ATIVO', 11, '2023-06-08 18:08:31', '2023-06-08 18:08:31', NULL),
(18, 'Secretaria de Indústria e Comércio', 'ATIVO', 12, '2023-06-08 18:08:31', '2023-06-08 18:08:31', NULL),
(19, 'Secretaria de Assistência Social', 'ATIVO', 13, '2023-06-08 18:08:31', '2023-06-08 18:08:31', NULL),
(20, 'Centro da Juventude', 'ATIVO', 13, '2023-06-08 18:08:31', '2023-06-08 18:08:31', NULL),
(21, 'Controle Interno', 'ATIVO', 14, '2023-06-08 18:08:31', '2023-06-08 18:08:31', NULL),
(22, 'Patrimônios', 'ATIVO', 14, '2023-06-08 18:08:31', '2023-06-08 18:08:31', NULL),
(23, 'Secretaria de Educação', 'ATIVO', 15, '2023-06-08 18:08:31', '2023-06-08 18:08:31', NULL),
(24, 'Escola X', 'ATIVO', 15, '2023-06-08 18:08:32', '2023-06-08 18:08:32', NULL),
(25, 'Escola Y', 'ATIVO', 15, '2023-06-08 18:08:32', '2023-06-08 18:08:32', NULL),
(26, 'Procon', 'ATIVO', 13, '2023-06-08 18:08:32', '2023-06-08 18:08:32', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `divisoes`
--

CREATE TABLE `divisoes` (
  `id` bigint UNSIGNED NOT NULL,
  `nome` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('ATIVO','INATIVO') COLLATE utf8mb4_unicode_ci NOT NULL,
  `diretoria_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `divisoes`
--

INSERT INTO `divisoes` (`id`, `nome`, `status`, `diretoria_id`, `created_at`, `updated_at`, `email`) VALUES
(1, 'COVISA', 'ATIVO', 1, '2023-06-08 18:08:32', '2023-06-08 18:08:32', NULL),
(2, 'RH Saúde', 'ATIVO', 1, '2023-06-08 18:08:32', '2023-06-08 18:08:32', NULL),
(3, 'Alta Complexidade', 'ATIVO', 1, '2023-06-08 18:08:32', '2023-06-08 18:08:32', NULL),
(4, 'Infectologia', 'ATIVO', 1, '2023-06-08 18:08:32', '2023-06-08 18:08:32', NULL),
(5, 'Remédios', 'ATIVO', 2, '2023-06-08 18:08:33', '2023-06-08 18:08:33', NULL),
(6, 'Frios', 'ATIVO', 2, '2023-06-08 18:08:33', '2023-06-08 18:08:33', NULL),
(7, 'Atendimento Habitação', 'ATIVO', 5, '2023-06-08 18:08:33', '2023-06-08 18:08:33', NULL),
(8, 'Terrenos', 'ATIVO', 5, '2023-06-08 18:08:33', '2023-06-08 18:08:33', NULL),
(9, 'Impostos', 'ATIVO', 5, '2023-06-08 18:08:33', '2023-06-08 18:08:33', NULL),
(10, 'ICMS', 'ATIVO', 7, '2023-06-08 18:08:34', '2023-06-08 18:08:34', NULL),
(11, 'Divida Ativa', 'ATIVO', 7, '2023-06-08 18:08:34', '2023-06-08 18:08:34', NULL),
(12, 'Fiscais', 'ATIVO', 7, '2023-06-08 18:08:34', '2023-06-08 18:08:34', NULL),
(13, 'Postura', 'ATIVO', 7, '2023-06-08 18:08:34', '2023-06-08 18:08:34', NULL),
(14, 'Alvará', 'ATIVO', 7, '2023-06-08 18:08:34', '2023-06-08 18:08:34', NULL),
(15, 'Divisão de Desenvolvimento', 'ATIVO', 9, '2023-06-08 18:08:34', '2023-07-11 19:57:23', 'santhiago.monteiro@hotmail.com'),
(16, 'Divisão de Infraestrutura', 'ATIVO', 9, '2023-06-08 18:08:34', '2023-06-08 18:08:34', NULL),
(17, 'Atendimento SMEL', 'ATIVO', 15, '2023-06-08 18:08:34', '2023-06-08 18:08:34', NULL),
(18, 'Conselho Tutelar', 'ATIVO', 19, '2023-06-08 18:08:34', '2023-06-08 18:08:34', NULL),
(19, 'Jurídico Assistência Social', 'ATIVO', 19, '2023-06-08 18:08:34', '2023-06-08 18:08:34', NULL),
(20, 'Atendimento CEJU', 'ATIVO', 20, '2023-06-08 18:08:34', '2023-06-08 18:08:34', NULL),
(21, 'Clínica 1', 'ATIVO', 20, '2023-06-08 18:08:34', '2023-06-08 18:08:34', NULL),
(22, 'Clínica 2', 'ATIVO', 20, '2023-06-08 18:08:34', '2023-06-08 18:08:34', NULL),
(23, 'Merenda Escolar', 'ATIVO', 23, '2023-06-08 18:08:34', '2023-06-08 18:08:34', NULL),
(24, 'Jurídico Procon', 'ATIVO', 26, '2023-06-08 18:08:34', '2023-06-08 18:08:34', NULL),
(25, 'Guichês Procon', 'ATIVO', 26, '2023-06-08 18:08:34', '2023-06-08 18:08:34', NULL),
(26, 'Secretário', 'ATIVO', 26, '2023-06-08 18:08:35', '2023-06-08 18:08:35', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `entregas`
--

CREATE TABLE `entregas` (
  `id` bigint UNSIGNED NOT NULL,
  `qntde` int NOT NULL,
  `observacao` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `itens_solicitacao_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `entregas`
--

INSERT INTO `entregas` (`id`, `qntde`, `observacao`, `usuario_id`, `itens_solicitacao_id`, `created_at`, `updated_at`) VALUES
(25, 2, NULL, 1, 39, '2023-07-11 20:26:17', '2023-07-11 20:26:17'),
(26, 2, NULL, 1, 52, '2023-07-14 18:27:16', '2023-07-14 18:27:16'),
(27, 1, NULL, 1, 54, '2023-07-15 18:20:59', '2023-07-15 18:20:59'),
(28, 1, NULL, 1, 53, '2023-07-15 18:21:14', '2023-07-15 18:21:14'),
(29, 2, NULL, 1, 51, '2023-07-15 18:21:21', '2023-07-15 18:21:21'),
(31, 2, NULL, 1, 58, '2023-08-03 20:45:52', '2023-08-03 20:45:52'),
(32, 2, NULL, 103, 61, '2023-08-27 14:32:20', '2023-08-27 14:32:20'),
(33, 1, NULL, 1, 66, '2023-08-28 20:30:50', '2023-08-28 20:30:50'),
(34, 1, NULL, 1, 77, '2023-08-28 21:39:41', '2023-08-28 21:39:41'),
(35, 2, NULL, 1, 75, '2023-08-28 21:39:50', '2023-08-28 21:39:50'),
(36, 2, NULL, 1, 76, '2023-08-28 21:39:50', '2023-08-28 21:39:50'),
(37, 1, NULL, 1, 74, '2023-08-28 21:39:56', '2023-08-28 21:39:56'),
(38, 2, NULL, 1, 73, '2023-08-28 21:40:09', '2023-08-28 21:40:09');

-- --------------------------------------------------------

--
-- Estrutura para tabela `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_solicitacoes`
--

CREATE TABLE `itens_solicitacoes` (
  `id` bigint UNSIGNED NOT NULL,
  `qntde` int NOT NULL,
  `produto_id` bigint UNSIGNED NOT NULL,
  `solicitacao_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `itens_solicitacoes`
--

INSERT INTO `itens_solicitacoes` (`id`, `qntde`, `produto_id`, `solicitacao_id`, `created_at`, `updated_at`) VALUES
(39, 2, 5, 42, '2023-07-11 20:25:59', '2023-07-11 20:25:59'),
(51, 2, 5, 54, '2023-07-12 19:08:05', '2023-07-12 19:08:05'),
(52, 2, 3, 55, '2023-07-14 18:27:07', '2023-07-14 18:27:07'),
(53, 1, 3, 56, '2023-07-15 03:22:13', '2023-07-15 03:22:13'),
(54, 1, 7, 57, '2023-07-15 03:23:13', '2023-07-15 03:23:13'),
(55, 1, 5, 58, '2023-07-15 18:22:01', '2023-07-15 18:22:01'),
(57, 2, 3, 60, '2023-08-03 20:25:08', '2023-08-03 20:25:08'),
(58, 2, 3, 61, '2023-08-03 20:26:06', '2023-08-03 20:26:06'),
(61, 2, 3, 64, '2023-08-27 14:32:02', '2023-08-27 14:32:02'),
(62, 2, 3, 65, '2023-08-28 20:24:58', '2023-08-28 20:24:58'),
(63, 2, 5, 66, '2023-08-28 20:25:28', '2023-08-28 20:25:28'),
(64, 1, 3, 67, '2023-08-28 20:25:44', '2023-08-28 20:25:44'),
(65, 1, 7, 67, '2023-08-28 20:25:44', '2023-08-28 20:25:44'),
(66, 1, 4, 68, '2023-08-28 20:25:59', '2023-08-28 20:25:59'),
(67, 1, 4, 69, '2023-08-28 20:26:42', '2023-08-28 20:26:42'),
(68, 1, 5, 70, '2023-08-28 20:27:11', '2023-08-28 20:27:11'),
(69, 2, 4, 71, '2023-08-28 20:27:39', '2023-08-28 20:27:39'),
(70, 1, 4, 72, '2023-08-28 20:28:17', '2023-08-28 20:28:17'),
(71, 2, 4, 73, '2023-08-28 20:28:38', '2023-08-28 20:28:38'),
(72, 2, 7, 74, '2023-08-28 20:28:52', '2023-08-28 20:28:52'),
(73, 2, 4, 75, '2023-08-28 20:29:14', '2023-08-28 20:29:14'),
(74, 1, 7, 76, '2023-08-28 20:30:05', '2023-08-28 20:30:05'),
(75, 2, 4, 77, '2023-08-28 20:30:18', '2023-08-28 20:30:18'),
(76, 2, 7, 77, '2023-08-28 20:30:18', '2023-08-28 20:30:18'),
(77, 1, 7, 78, '2023-08-28 20:31:20', '2023-08-28 20:31:20'),
(78, 2, 7, 79, '2023-08-28 21:40:31', '2023-08-28 21:40:31'),
(79, 2, 3, 80, '2023-08-28 21:40:45', '2023-08-28 21:40:45'),
(80, 2, 3, 81, '2023-08-28 21:40:58', '2023-08-28 21:40:58'),
(81, 2, 7, 82, '2023-08-28 21:41:59', '2023-08-28 21:41:59'),
(82, 2, 7, 83, '2023-08-28 22:02:40', '2023-08-28 22:02:40'),
(83, 1, 3, 85, '2023-09-02 02:16:12', '2023-09-02 02:16:12'),
(84, 1, 5, 86, '2023-09-02 02:17:00', '2023-09-02 02:17:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `local_impressoras`
--

CREATE TABLE `local_impressoras` (
  `id` bigint UNSIGNED NOT NULL,
  `produto_id` bigint UNSIGNED NOT NULL,
  `diretoria_id` bigint UNSIGNED DEFAULT NULL,
  `divisao_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `local_impressoras`
--

INSERT INTO `local_impressoras` (`id`, `produto_id`, `diretoria_id`, `divisao_id`, `created_at`, `updated_at`) VALUES
(1, 1, 21, NULL, '2023-06-08 18:08:52', '2023-06-08 18:08:52'),
(2, 2, 21, NULL, '2023-06-08 18:08:52', '2023-06-08 18:08:52'),
(3, 1, 5, 7, '2023-06-08 18:08:53', '2023-06-08 18:08:53'),
(4, 1, 4, NULL, '2023-06-08 18:08:53', '2023-06-08 18:08:53'),
(5, 1, 7, 10, '2023-06-08 18:08:53', '2023-06-08 18:08:53'),
(6, 2, 7, 13, '2023-06-08 18:08:53', '2023-06-08 18:08:53'),
(7, 2, 15, 17, '2023-06-08 18:08:53', '2023-06-08 18:08:53'),
(8, 2, 15, 17, '2023-06-08 18:08:53', '2023-06-08 18:08:53'),
(9, 1, 25, NULL, '2023-06-08 18:08:53', '2023-06-08 18:08:53'),
(10, 2, 24, NULL, '2023-06-08 18:08:53', '2023-06-08 18:08:53'),
(11, 2, 21, NULL, '2023-06-08 18:08:53', '2023-06-08 18:08:53'),
(12, 1, 12, NULL, '2023-06-08 18:08:54', '2023-06-08 18:08:54'),
(13, 2, 21, NULL, '2023-06-08 18:08:54', '2023-06-08 18:08:54'),
(14, 1, 12, NULL, '2023-06-08 18:08:54', '2023-06-08 18:08:54'),
(15, 1, 23, 23, '2023-06-08 18:08:54', '2023-06-08 18:08:54'),
(16, 2, 17, NULL, '2023-06-08 18:08:54', '2023-06-08 18:08:54'),
(17, 1, 26, 26, '2023-06-08 18:08:54', '2023-06-08 18:08:54'),
(18, 2, 2, 5, '2023-06-08 18:08:55', '2023-06-08 18:08:55'),
(19, 2, 1, 3, '2023-06-08 18:08:55', '2023-06-08 18:08:55'),
(20, 2, 7, 14, '2023-06-08 18:08:55', '2023-06-08 18:08:55'),
(21, 2, 24, NULL, '2023-06-08 18:08:55', '2023-06-08 18:08:55'),
(22, 1, 19, 19, '2023-06-08 18:08:55', '2023-06-08 18:08:55'),
(23, 2, 12, NULL, '2023-06-08 18:08:55', '2023-06-08 18:08:55'),
(24, 1, 12, NULL, '2023-06-08 18:08:55', '2023-06-08 18:08:55'),
(25, 2, 14, NULL, '2023-06-08 18:08:55', '2023-06-08 18:08:55'),
(26, 1, 18, NULL, '2023-06-08 18:08:56', '2023-06-08 18:08:56'),
(27, 1, 25, NULL, '2023-06-08 18:08:56', '2023-06-08 18:08:56'),
(28, 1, 4, NULL, '2023-06-08 18:08:56', '2023-06-08 18:08:56'),
(29, 1, 23, 23, '2023-06-08 18:08:56', '2023-06-08 18:08:56'),
(30, 2, 15, 17, '2023-06-08 18:08:56', '2023-06-08 18:08:56'),
(31, 1, 23, 23, '2023-06-08 18:08:56', '2023-06-08 18:08:56'),
(32, 1, 25, NULL, '2023-06-08 18:08:56', '2023-06-08 18:08:56'),
(33, 1, 8, NULL, '2023-06-08 18:08:56', '2023-06-08 18:08:56'),
(34, 2, 12, NULL, '2023-06-08 18:08:56', '2023-06-08 18:08:56'),
(35, 2, 7, 11, '2023-06-08 18:08:56', '2023-06-08 18:08:56'),
(36, 2, 26, 24, '2023-06-08 18:08:57', '2023-06-08 18:08:57'),
(37, 1, 13, NULL, '2023-06-08 18:08:57', '2023-06-08 18:08:57'),
(38, 2, 7, 13, '2023-06-08 18:08:57', '2023-06-08 18:08:57'),
(39, 2, 10, NULL, '2023-06-08 18:08:57', '2023-06-08 18:08:57'),
(40, 1, 9, 15, '2023-06-08 18:08:57', '2023-06-08 18:08:57'),
(41, 1, 1, 4, '2023-06-08 18:08:57', '2023-06-08 18:08:57'),
(42, 1, 6, NULL, '2023-06-08 18:08:57', '2023-06-08 18:08:57'),
(43, 2, 8, NULL, '2023-06-08 18:08:57', '2023-06-08 18:08:57'),
(44, 1, 16, NULL, '2023-06-08 18:08:57', '2023-06-08 18:08:57'),
(45, 2, 22, NULL, '2023-06-08 18:08:58', '2023-06-08 18:08:58'),
(46, 1, 23, 23, '2023-06-08 18:08:58', '2023-06-08 18:08:58'),
(47, 2, 15, 17, '2023-06-08 18:08:58', '2023-06-08 18:08:58'),
(48, 1, 8, NULL, '2023-06-08 18:08:58', '2023-06-08 18:08:58'),
(49, 2, 24, NULL, '2023-06-08 18:08:58', '2023-06-08 18:08:58'),
(50, 1, 19, 19, '2023-06-08 18:08:58', '2023-06-08 18:08:58'),
(51, 12, NULL, 4, '2023-08-27 12:56:28', '2023-08-27 12:56:28'),
(52, 12, 23, NULL, '2023-08-27 12:56:28', '2023-08-27 12:56:28'),
(53, 12, NULL, 3, '2023-08-27 12:56:28', '2023-08-27 12:56:28'),
(54, 14, NULL, 5, '2023-08-27 13:00:13', '2023-08-27 13:00:13'),
(55, 14, NULL, 3, '2023-08-27 13:00:13', '2023-08-27 13:00:13'),
(56, 14, 1, NULL, '2023-08-27 13:00:13', '2023-08-27 13:00:13'),
(57, 15, 1, NULL, '2023-08-27 13:02:28', '2023-08-27 13:02:28'),
(58, 15, NULL, 15, '2023-08-27 13:02:28', '2023-08-27 13:02:28');

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_04_20_192536_create_orgaos_table', 1),
(6, '2023_04_20_192722_create_diretorias_table', 1),
(7, '2023_04_20_192742_create_divisoes_table', 1),
(8, '2023_04_20_192849_create_usuarios_table', 1),
(9, '2023_04_20_192914_create_produtos_table', 1),
(10, '2023_04_20_192947_create_suprimentos_table', 1),
(11, '2023_04_20_193007_create_solicitacoes_table', 1),
(12, '2023_04_20_193022_create_itens_solicitacoes_table', 1),
(13, '2023_04_20_193047_create_entregas_table', 1),
(14, '2023_04_27_200950_alter_usuarios_table_add_usuario_interno_column', 1),
(15, '2023_05_03_152922_create_local_impressoras_table', 1),
(16, '2023_05_26_214308_alter_diretorias_divisoes_add_email_column', 1),
(17, '2023_05_29_212035_alter_tables_add_on_delete_cascade', 1),
(18, '2023_07_10_193232_alter_usuarios_table_add_senha_provisoria_column', 2),
(19, '2023_07_11_200810_alter_produtos_table_add_qntde_solicitada_column', 3),
(20, '2023_07_17_183455_create_audits_table', 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `orgaos`
--

CREATE TABLE `orgaos` (
  `id` bigint UNSIGNED NOT NULL,
  `nome` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('ATIVO','INATIVO') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `orgaos`
--

INSERT INTO `orgaos` (`id`, `nome`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Saúde', 'ATIVO', '2023-06-08 18:08:27', '2023-08-27 00:22:09'),
(2, 'Agricultura', 'ATIVO', '2023-06-08 18:08:27', '2023-06-08 18:08:27'),
(3, 'Atos Oficiais', 'ATIVO', '2023-06-08 18:08:27', '2023-06-08 18:08:27'),
(4, 'Habitação', 'ATIVO', '2023-06-08 18:08:27', '2023-06-08 18:08:27'),
(5, 'Fazenda', 'ATIVO', '2023-06-08 18:08:28', '2023-06-08 18:08:28'),
(6, 'Administração', 'ATIVO', '2023-06-08 18:08:28', '2023-06-08 18:08:28'),
(7, 'Obras', 'ATIVO', '2023-06-08 18:08:28', '2023-06-08 18:08:28'),
(8, 'Gabinete', 'ATIVO', '2023-06-08 18:08:28', '2023-06-08 18:08:28'),
(9, 'Esportes', 'ATIVO', '2023-06-08 18:08:28', '2023-06-08 18:08:28'),
(10, 'Meio Ambiente', 'ATIVO', '2023-06-08 18:08:28', '2023-06-08 18:08:28'),
(11, 'Procuradoria-Geral', 'ATIVO', '2023-06-08 18:08:28', '2023-06-08 18:08:28'),
(12, 'Indústria e Comércio', 'ATIVO', '2023-06-08 18:08:28', '2023-06-08 18:08:28'),
(13, 'Assistêcia Social', 'ATIVO', '2023-06-08 18:08:28', '2023-06-08 18:08:28'),
(14, 'Controladoria Interna', 'ATIVO', '2023-06-08 18:08:28', '2023-06-08 18:08:28'),
(15, 'Educação', 'ATIVO', '2023-06-08 18:08:28', '2023-07-13 20:43:29');

-- --------------------------------------------------------

--
-- Estrutura para tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` bigint UNSIGNED NOT NULL,
  `tipo_produto` enum('IMPRESSORA','CILINDRO','TONER','OUTROS') COLLATE utf8mb4_unicode_ci NOT NULL,
  `modelo_produto` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('ATIVO','INATIVO') COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qntde_estoque` int NOT NULL,
  `qntde_solicitada` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `tipo_produto`, `modelo_produto`, `status`, `descricao`, `qntde_estoque`, `qntde_solicitada`, `created_at`, `updated_at`) VALUES
(1, 'IMPRESSORA', 'Brother 5652', 'ATIVO', NULL, 26, NULL, '2023-06-08 18:08:51', '2023-08-28 20:16:48'),
(2, 'IMPRESSORA', 'HP P1102w', 'ATIVO', NULL, 24, NULL, '2023-06-08 18:08:51', '2023-08-28 20:16:54'),
(3, 'TONER', 'T3442 Tonali', 'ATIVO', NULL, 0, 10, '2023-06-08 18:08:51', '2023-09-02 02:16:12'),
(4, 'TONER', 'T3442 Milenium', 'ATIVO', NULL, 25, 6, '2023-06-08 18:08:51', '2023-08-28 21:40:09'),
(5, 'TONER', '285A Tonali', 'ATIVO', NULL, 0, 5, '2023-06-08 18:08:51', '2023-09-02 02:17:00'),
(6, 'TONER', '285A Milenium', 'ATIVO', NULL, 10, NULL, '2023-06-08 18:08:51', '2023-07-17 18:59:37'),
(7, 'CILINDRO', 'C3442 Tonali', 'ATIVO', NULL, 27, 9, '2023-06-08 18:08:51', '2023-08-28 22:02:40'),
(10, 'CILINDRO', 'C3442 Milenium', 'ATIVO', NULL, 29, NULL, '2023-08-22 23:55:00', '2023-08-22 23:55:00'),
(12, 'IMPRESSORA', 'HP 1102nw', 'ATIVO', NULL, 3, NULL, '2023-08-27 12:56:07', '2023-08-27 12:56:28'),
(14, 'IMPRESSORA', 'EPSON m136', 'ATIVO', NULL, 3, NULL, '2023-08-27 12:59:52', '2023-08-27 13:00:13'),
(15, 'IMPRESSORA', 'EPSON M135', 'ATIVO', NULL, 2, NULL, '2023-08-27 13:02:15', '2023-08-27 13:02:28');

-- --------------------------------------------------------

--
-- Estrutura para tabela `solicitacoes`
--

CREATE TABLE `solicitacoes` (
  `id` bigint UNSIGNED NOT NULL,
  `status` enum('AGUARDANDO','ABERTO','ENCERRADO','LIBERADO') COLLATE utf8mb4_unicode_ci NOT NULL,
  `observacao` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `divisao_id` bigint UNSIGNED DEFAULT NULL,
  `diretoria_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `solicitacoes`
--

INSERT INTO `solicitacoes` (`id`, `status`, `observacao`, `usuario_id`, `divisao_id`, `diretoria_id`, `created_at`, `updated_at`) VALUES
(42, 'ENCERRADO', NULL, 1, 15, 9, '2023-07-11 20:25:59', '2023-07-15 00:29:31'),
(54, 'ENCERRADO', NULL, 1, 15, 9, '2023-07-12 19:08:05', '2023-07-15 18:21:21'),
(55, 'ENCERRADO', NULL, 63, NULL, 4, '2023-07-14 18:27:07', '2023-07-14 18:55:47'),
(56, 'ENCERRADO', NULL, 1, 15, 9, '2023-07-15 03:22:13', '2023-07-15 18:21:14'),
(57, 'ENCERRADO', NULL, 1, 15, 9, '2023-07-15 03:23:13', '2023-07-15 18:21:08'),
(58, 'LIBERADO', NULL, 1, 15, 9, '2023-07-15 18:22:01', '2023-07-15 18:22:26'),
(60, 'LIBERADO', NULL, 1, 15, 9, '2023-08-03 20:25:08', '2023-08-03 20:44:43'),
(61, 'ENCERRADO', NULL, 1, 15, 9, '2023-08-03 20:26:06', '2023-08-03 20:45:52'),
(64, 'ENCERRADO', NULL, 103, NULL, 3, '2023-08-27 14:32:02', '2023-08-27 14:32:20'),
(65, 'AGUARDANDO', NULL, 6, NULL, 10, '2023-08-28 20:24:58', '2023-08-28 20:24:58'),
(66, 'AGUARDANDO', NULL, 62, 23, 23, '2023-08-28 20:25:28', '2023-08-28 20:25:28'),
(67, 'AGUARDANDO', NULL, 31, 25, 26, '2023-08-28 20:25:44', '2023-08-28 20:25:44'),
(68, 'ENCERRADO', NULL, 1, 15, 9, '2023-08-28 20:25:59', '2023-08-28 20:30:50'),
(69, 'ABERTO', NULL, 24, NULL, 6, '2023-08-28 20:26:42', '2023-08-28 20:26:42'),
(70, 'AGUARDANDO', NULL, 1, 15, 9, '2023-08-28 20:27:11', '2023-08-28 20:27:11'),
(71, 'ABERTO', NULL, 13, NULL, 25, '2023-08-28 20:27:39', '2023-08-28 20:27:39'),
(72, 'ABERTO', NULL, 19, 8, 5, '2023-08-28 20:28:17', '2023-08-28 20:28:17'),
(73, 'ABERTO', NULL, 82, 6, 2, '2023-08-28 20:28:38', '2023-08-28 20:28:38'),
(74, 'ABERTO', NULL, 77, 6, 2, '2023-08-28 20:28:52', '2023-08-28 20:28:52'),
(75, 'ENCERRADO', NULL, 61, 11, 7, '2023-08-28 20:29:14', '2023-08-28 21:40:09'),
(76, 'ENCERRADO', NULL, 27, NULL, 22, '2023-08-28 20:30:05', '2023-08-28 21:40:03'),
(77, 'ENCERRADO', NULL, 3, NULL, 10, '2023-08-28 20:30:18', '2023-08-28 21:39:50'),
(78, 'ENCERRADO', NULL, 56, 5, 2, '2023-08-28 20:31:20', '2023-08-28 21:39:41'),
(79, 'ABERTO', NULL, 83, NULL, 25, '2023-08-28 21:40:31', '2023-08-28 21:40:31'),
(80, 'AGUARDANDO', NULL, 63, NULL, 4, '2023-08-28 21:40:45', '2023-08-28 21:40:45'),
(81, 'AGUARDANDO', NULL, 62, 23, 23, '2023-08-28 21:40:58', '2023-08-28 21:40:58'),
(82, 'ABERTO', NULL, 45, NULL, 13, '2023-08-28 21:41:59', '2023-08-28 21:41:59'),
(83, 'ABERTO', NULL, 2, 10, 7, '2023-08-28 22:02:40', '2023-08-28 22:02:40'),
(85, 'AGUARDANDO', NULL, 1, 15, 9, '2023-09-02 02:16:12', '2023-09-02 02:16:12'),
(86, 'AGUARDANDO', NULL, 35, 6, 2, '2023-09-02 02:17:00', '2023-09-02 02:17:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `suprimentos`
--

CREATE TABLE `suprimentos` (
  `id` bigint UNSIGNED NOT NULL,
  `produto_id` bigint UNSIGNED NOT NULL,
  `suprimento_id` bigint UNSIGNED NOT NULL,
  `em_uso` enum('SIM','NAO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NAO',
  `tipo_suprimento` enum('CILINDRO','TONER') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `suprimentos`
--

INSERT INTO `suprimentos` (`id`, `produto_id`, `suprimento_id`, `em_uso`, `tipo_suprimento`, `created_at`, `updated_at`) VALUES
(8, 2, 5, 'SIM', 'TONER', '2023-07-09 21:13:13', '2023-07-10 19:07:05'),
(9, 2, 6, 'NAO', 'TONER', '2023-07-09 21:14:51', '2023-07-11 18:35:20'),
(10, 1, 3, 'SIM', 'TONER', '2023-07-14 18:26:44', '2023-07-14 18:26:44'),
(11, 1, 4, 'NAO', 'TONER', '2023-07-14 18:26:44', '2023-08-03 20:24:38'),
(12, 1, 7, 'SIM', 'CILINDRO', '2023-07-15 03:23:03', '2023-07-15 03:23:03'),
(14, 1, 10, 'NAO', 'CILINDRO', '2023-08-22 23:55:13', '2023-08-22 23:56:44'),
(16, 15, 4, 'SIM', 'TONER', '2023-08-27 13:02:55', '2023-08-27 13:02:55'),
(17, 15, 7, 'SIM', 'CILINDRO', '2023-08-27 13:02:55', '2023-08-27 13:02:55'),
(18, 15, 3, 'NAO', 'TONER', '2023-08-27 13:02:55', '2023-08-27 13:02:55');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint UNSIGNED NOT NULL,
  `nome` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('ATIVO','INATIVO') COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpf` bigint NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `senha_provisoria` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `divisao_id` bigint UNSIGNED DEFAULT NULL,
  `diretoria_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_interno` enum('SIM','NAO') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `status`, `cpf`, `email`, `senha`, `senha_provisoria`, `divisao_id`, `diretoria_id`, `created_at`, `updated_at`, `user_interno`) VALUES
(1, 'Santhiago', 'ATIVO', 10735389900, 'santhiago.monteiro@hotmail.com', '$2y$10$FGtf2peirMoNk1QtZALHR.y0Dx3N5JwXucXExwZ.BlnBSOYxgjtOi', NULL, 15, 9, '2023-06-08 18:08:35', '2023-07-11 19:48:28', 'SIM'),
(2, 'Callie', 'ATIVO', 44543180377, 'bailey.lamar@ziemann.com', '$2y$10$a56t.1Ex7Y5h66KN2GVx9OHZpSHf9fSYR6Z2/rofilhPXAluJC37a', NULL, 10, 7, '2023-06-08 18:08:41', '2023-07-10 20:55:55', 'NAO'),
(3, 'Laurence', 'ATIVO', 88540922746, 'casper.reginald@lowe.biz', '$2y$10$uY0BqM8cdvX14i9ySX/bguffIU1oEMbs/Vyu6Yu5SDsmpO3yS87V6', NULL, NULL, 10, '2023-06-08 18:08:41', '2023-06-08 18:08:41', 'SIM'),
(4, 'Cary', 'INATIVO', 14031034368, 'sean.bode@mueller.com', '$2y$10$KJhR5Dg7f.UnuvLP/Zo4U.H9IqIE/RRuvJu/j.SNHKUP93udr0SNK', NULL, 18, 19, '2023-06-08 18:08:41', '2023-07-17 19:02:34', 'NAO'),
(5, 'Jalon', 'ATIVO', 89907516273, 'cjones@yahoo.com', '$2y$10$2cYqfHLm9jl6bXNBr/PbwOFuCcfq5Ht3Lz3tNsEuahYItvOLmQ7hO', '$2y$10$XpDbDAO.mnks3/F7xMaEj.TPiUUBEtWvy.XiRGPPP0RZvU1ML5mom', 6, 2, '2023-06-08 18:08:41', '2023-07-17 19:02:55', 'SIM'),
(6, 'Angeline', 'ATIVO', 45520385920, 'crobel@gmail.com', '$2y$10$BTIbdbjV.vPvqbc5BwlUBe2E0kVytCJmAJ4bjeOpJaPf57qDzVInS', NULL, NULL, 10, '2023-06-08 18:08:41', '2023-06-08 18:08:41', 'SIM'),
(7, 'Georgianna', 'ATIVO', 81431055527, 'becker.josue@gmail.com', '$2y$10$.9MvofR5lVMq3pWTlfGKSOfZf6UcFpN1CAtNo3I0mLdFxnfUsy.fK', NULL, NULL, 13, '2023-06-08 18:08:42', '2023-06-08 18:08:42', 'SIM'),
(8, 'Fleta', 'ATIVO', 57894976470, 'odie.bernhard@gmail.com', '$2y$10$gMZl9UNXuiX8ijzUuRoPr.u9qmyk7uaqwxcuZG4P/c.CF1aRkTtzm', NULL, 16, 9, '2023-06-08 18:08:42', '2023-06-08 18:08:42', 'SIM'),
(9, 'Cherri', 'ATIVO', 63123477927, 'isidro13@hotmail.com', '$2y$10$B2BZqFZezQQu8pUKEnO8FOHwsh9rzxo8blKA2HC1ff/TD5SUOVxgu', NULL, NULL, 17, '2023-06-08 18:08:42', '2023-08-23 01:00:34', 'SIM'),
(10, 'Stevie', 'ATIVO', 94529375359, 'ramona03@hickle.com', '$2y$10$XP3UMTZ8vCXfNWeRqq9pbeDEIsoGD7bFqNDCkF/rUmtrngVc1Iw76', NULL, 12, 7, '2023-06-08 18:08:42', '2023-06-08 18:08:42', 'NAO'),
(11, 'Myra', 'ATIVO', 31348874682, 'reilly.seth@hotmail.com', '$2y$10$U7ePEHJmV6QgyxWI3cIoTu8jJb8ZC68cSYgCjhBGABPaY6Q0mjuMS', NULL, 16, 9, '2023-06-08 18:08:42', '2023-06-08 18:08:42', 'SIM'),
(12, 'Merl', 'ATIVO', 13058219410, 'kbashirian@gmail.com', '$2y$10$HERBta5VWE5ei7vSQEBvreWGeD8ZNdrzHUXNgDRK9HkVXjxNoFIzy', NULL, NULL, 17, '2023-06-08 18:08:42', '2023-06-08 18:08:42', 'NAO'),
(13, 'Olga', 'ATIVO', 70440327497, 'feeney.isaiah@hotmail.com', '$2y$10$oWEkTKIwrsZWpdYtZMqWDu2YGiy3An8tSiBis7PPojMCv5G69A5Tu', NULL, NULL, 25, '2023-06-08 18:08:42', '2023-06-08 18:08:42', 'SIM'),
(14, 'Madeline', 'ATIVO', 48225429957, 'adelbert12@raynor.com', '$2y$10$ge6i4jYz03s7UsqPOT/O7uZk0w1IO2SFJqCM.7uaIyb.cUfMZAgdW', NULL, 3, 1, '2023-06-08 18:08:42', '2023-06-08 18:08:42', 'SIM'),
(15, 'Robert', 'ATIVO', 94868976919, 'equigley@yahoo.com', '$2y$10$3Jcfphc/mXsKgvakIYFe5ezxp8VjQbab25lRqV.vcMOZQVmdX5MbK', NULL, 5, 2, '2023-06-08 18:08:42', '2023-06-08 18:08:42', 'NAO'),
(16, 'Tyreek', 'ATIVO', 46903437607, 'emmie96@wintheiser.biz', '$2y$10$q3QXMb2tb8Ktc1zPbbebH.86Wyz/tqDqgbtr508VpvJ0tVhWG7ZvG', NULL, NULL, 25, '2023-06-08 18:08:42', '2023-06-08 18:08:42', 'NAO'),
(17, 'Kasandra', 'ATIVO', 84380486933, 'uthiel@wunsch.com', '$2y$10$LKLkxfSr2EC2JoB41x2tF.0Su7Pd9C/CYeI2BTcjjDFLgKPLsTGPG', NULL, NULL, 3, '2023-06-08 18:08:42', '2023-06-08 18:08:42', 'SIM'),
(18, 'Sidney', 'ATIVO', 93716210446, 'goldner.samara@hotmail.com', '$2y$10$rl/taF8FOqSW65m1KmCwrORNcN1Tlf6IZRQiwZJALAHJVJc2Sh1EO', NULL, NULL, 8, '2023-06-08 18:08:42', '2023-06-08 18:08:42', 'SIM'),
(19, 'Cathryn', 'ATIVO', 49694918901, 'lance81@dickens.com', '$2y$10$CP4IBZ8xyH115SVLo9EqMOsipmiXuSPyFDImerqP0/gURUw11jW96', NULL, 8, 5, '2023-06-08 18:08:42', '2023-06-08 18:08:42', 'SIM'),
(20, 'Pearlie', 'ATIVO', 19563845883, 'ines39@wilkinson.net', '$2y$10$yRMPEN6TAF7RHylxKicaUuBZRkirXX8osnjBeDM96oaSshj0I9kQS', NULL, NULL, 11, '2023-06-08 18:08:42', '2023-06-08 18:08:42', 'NAO'),
(21, 'Tony', 'ATIVO', 78462462052, 'thettinger@mccullough.com', '$2y$10$sldt8P6sfep6d.cyCuI6qOLcQhYoju7Qr7NVtbklvkNzB.ISVotHS', NULL, NULL, 16, '2023-06-08 18:08:42', '2023-06-08 18:08:42', 'NAO'),
(22, 'Fredy', 'ATIVO', 12724958000, 'raina.hammes@gmail.com', '$2y$10$BvrEw0fa45OEW3U3OnseweuNM9HgBDEUJ87d52PMboqw0cPEOp3gG', NULL, NULL, 11, '2023-06-08 18:08:42', '2023-06-08 18:08:42', 'NAO'),
(23, 'Benedict', 'ATIVO', 82960240415, 'rahul17@hotmail.com', '$2y$10$A2WDRgte4BE19nk7ufioceq4.Gz12R5ymS4gj.0jyoJjXODsuJCVO', NULL, NULL, 14, '2023-06-08 18:08:42', '2023-06-08 18:08:42', 'NAO'),
(24, 'Anabelle', 'ATIVO', 23310223469, 'davis.obie@hotmail.com', '$2y$10$geXqypEjhEu3V/dmCZ8LSe6idnYMEN7w8MWybA44LKkYOsSAeCTjW', NULL, NULL, 6, '2023-06-08 18:08:43', '2023-06-08 18:08:43', 'SIM'),
(25, 'Sheila', 'ATIVO', 61854643693, 'francisco.hoeger@hotmail.com', '$2y$10$YYRwmYl9jcJJ0X.8SvGIgOgMobhrMkZXx2Uk4f1I620p1t1i/H9ky', NULL, 18, 19, '2023-06-08 18:08:43', '2023-06-08 18:08:43', 'SIM'),
(26, 'Bruce', 'ATIVO', 91920152885, 'ortiz.burdette@hoppe.info', '$2y$10$2KWDE6Na0zqdxKO8sd/pvuoD6aSDfMMpKkiDoLB.x0GI.WB0vlATy', NULL, 17, 15, '2023-06-08 18:08:43', '2023-06-08 18:08:43', 'NAO'),
(27, 'Markus', 'ATIVO', 85117727216, 'winfield96@abbott.org', '$2y$10$wQbnrfC4L4ynqIwVCl/z5uTIJ49cRlD.lhhxZzSZJSq4uTHlvzpyq', NULL, NULL, 22, '2023-06-08 18:08:43', '2023-06-08 18:08:43', 'NAO'),
(28, 'Amara', 'ATIVO', 83985876827, 'colby04@gmail.com', '$2y$10$DEoA1tyS0TPLJzBsYV8jEeauk3t90yAwvVNKyy0WM72YCbJKPBMGa', NULL, NULL, 22, '2023-06-08 18:08:43', '2023-06-08 18:08:43', 'SIM'),
(29, 'Taylor', 'ATIVO', 29492754673, 'harry78@gmail.com', '$2y$10$MH2rjD8TjxHoedKdcdeM7e1rUoiuEECKyaY64JkoUHJw/Z3bEDgQG', NULL, NULL, 6, '2023-06-08 18:08:43', '2023-06-08 18:08:43', 'SIM'),
(30, 'Dallin', 'ATIVO', 41985249726, 'luz05@yahoo.com', '$2y$10$48DcHwZzll.XqaSICKDmw.SjySBqRq86tJ.gtJcDIlF76wqvKUgmW', NULL, NULL, 16, '2023-06-08 18:08:43', '2023-06-08 18:08:43', 'SIM'),
(31, 'Reinhold', 'ATIVO', 24648009480, 'dannie.robel@gmail.com', '$2y$10$KA1an8sXRoPk/1mFMcouyObXakfuYwuHYyg29ZdFw4KL/4Po.v8y6', NULL, 25, 26, '2023-06-08 18:08:43', '2023-06-08 18:08:43', 'NAO'),
(32, 'Felipe', 'ATIVO', 18390935665, 'daufderhar@becker.com', '$2y$10$3a.CzdyVV2nVrNLnmYC6YegQD9u9PTKRYL1HOAOuz.6Vi9Gc1/WtO', NULL, 25, 26, '2023-06-08 18:08:43', '2023-06-08 18:08:43', 'NAO'),
(33, 'Demetris', 'ATIVO', 43711890781, 'santino84@gottlieb.org', '$2y$10$6HX3m5Iw.JiTF2A3IWLcXOIB0okcGMZZbcFXwFlWwOogeSGHnEjF.', NULL, 7, 5, '2023-06-08 18:08:43', '2023-06-08 18:08:43', 'SIM'),
(34, 'Halie', 'ATIVO', 21167810643, 'gbogan@gmail.com', '$2y$10$4h508DWSIWLlR1oWZldDLe6TXu7aHDHka6mhDK7ApwbfVdZ3lSmPW', NULL, 24, 26, '2023-06-08 18:08:43', '2023-06-08 18:08:43', 'SIM'),
(35, 'Maximo', 'ATIVO', 63566997461, 'ciara99@mcdermott.com', '$2y$10$RBX8G80fzhOqB4wXuvgFQevA8sJ9kg2PqMG9.57RzHFCavr5ZGjrO', NULL, 6, 2, '2023-06-08 18:08:43', '2023-06-08 18:08:43', 'SIM'),
(36, 'Zelma', 'ATIVO', 43440088466, 'asia.gislason@runolfsson.info', '$2y$10$dsyopHx.9WYRMgovRoA7euINFQK2ZHrKULfvUuvzeAMVOdS9IeDdC', NULL, NULL, 18, '2023-06-08 18:08:43', '2023-06-08 18:08:43', 'NAO'),
(37, 'Cecilia', 'ATIVO', 42189771634, 'kristoffer.schroeder@hotmail.com', '$2y$10$rM5rbhmX.DVlKf4.mnCVZeOGZFDStu5TIsbyD0mhL68Og6oziiuUC', NULL, NULL, 16, '2023-06-08 18:08:43', '2023-06-08 18:08:43', 'SIM'),
(38, 'Jackeline', 'ATIVO', 49537482335, 'imani46@torphy.com', '$2y$10$wYEewzmNpTeETZNkNQNfT.6VhepV5pv95DKfW6B824SQHE3DBB5Hm', NULL, NULL, 14, '2023-06-08 18:08:44', '2023-06-08 18:08:44', 'NAO'),
(39, 'Alexis', 'ATIVO', 63209134838, 'bailey.garry@hotmail.com', '$2y$10$wmlE7CaI3n635S7LqGbdL.d/wUkvL9LJsEo1.TE.SyAIjaHwjYHYe', NULL, 17, 15, '2023-06-08 18:08:44', '2023-06-08 18:08:44', 'SIM'),
(40, 'Idell', 'ATIVO', 15119357042, 'abe.marquardt@hotmail.com', '$2y$10$DDYohZPZlgRVDPwrmJefJusNDKRe8kohyJfSBdtkqrQrkA5rjKIvK', NULL, NULL, 24, '2023-06-08 18:08:44', '2023-06-08 18:08:44', 'SIM'),
(41, 'Quinten', 'ATIVO', 19370642399, 'lquigley@yahoo.com', '$2y$10$BmpRWXvMv5fonYXCQ98RX.rIA4Bm6D.BuWS1tneT50b7eLqDGXo8y', NULL, NULL, 16, '2023-06-08 18:08:44', '2023-06-08 18:08:44', 'NAO'),
(42, 'Jessy', 'ATIVO', 92446295430, 'becker.alberta@dickinson.com', '$2y$10$HiDFR37er/WTNXv5RRWITuSJX3.yo2UxRsF7pjLe6Cpn/sFk3Ukya', NULL, 13, 7, '2023-06-08 18:08:44', '2023-06-08 18:08:44', 'SIM'),
(43, 'Micah', 'ATIVO', 21610184565, 'mable56@ratke.net', '$2y$10$T8AYbAFFoWvUZgD/nXoS/uDaSw0erJniYrVVmAmqReCrYrctW.oJu', NULL, NULL, 24, '2023-06-08 18:08:44', '2023-06-08 18:08:44', 'NAO'),
(44, 'Rozella', 'ATIVO', 43699040961, 'camille45@hotmail.com', '$2y$10$3bn/b/wHI4F7YdDJH.UbA.R/hrHDuX0nupiz.howjyPBEZ3RWWsQu', NULL, NULL, 25, '2023-06-08 18:08:44', '2023-06-08 18:08:44', 'SIM'),
(45, 'Aryanna', 'ATIVO', 95855406831, 'trantow.carter@hotmail.com', '$2y$10$MRpx/SQCDgmQ9QUzNMXF2uACiqRx4BLoou4hPSOvDsop4QFqdx0o2', NULL, NULL, 13, '2023-06-08 18:08:44', '2023-06-08 18:08:44', 'SIM'),
(46, 'Willa', 'ATIVO', 53912997903, 'uriel00@yahoo.com', '$2y$10$4VpBXjvI6.yifSGte6DPRu2lWyD4I8XN/F0u1mJW4GyEI86P6ROfm', NULL, 14, 7, '2023-06-08 18:08:44', '2023-06-08 18:08:44', 'SIM'),
(47, 'Rick', 'ATIVO', 84994259283, 'xmarvin@kemmer.com', '$2y$10$YjKfWMIA0jpZ3f6WtEF1yOgprencwlAb/D/6b6Wt2VNcThZkgs1se', NULL, NULL, 22, '2023-06-08 18:08:45', '2023-06-08 18:08:45', 'SIM'),
(48, 'Nelle', 'ATIVO', 78378361095, 'ellie86@halvorson.com', '$2y$10$3YftOPAXo.yajqgniEOqy.2hAgBX8ipAPDwH.spUJyQGyBEFv/eUa', NULL, NULL, 24, '2023-06-08 18:08:45', '2023-06-08 18:08:45', 'NAO'),
(49, 'Manuela', 'ATIVO', 84194045587, 'marvin.angeline@hotmail.com', '$2y$10$ZdxA5HTVC8o0mFZGDV.nEeDrcDonlVTuh9TLtsd7XTTqGrLp4Sv9q', NULL, 5, 2, '2023-06-08 18:08:45', '2023-06-08 18:08:45', 'SIM'),
(50, 'Toni', 'ATIVO', 58661572136, 'hollie.monahan@miller.biz', '$2y$10$pHxuiLj2F2o860MPKNYDmeV.wBfiuCoV4XedwO6cCVQKRkKQFpRRW', NULL, NULL, 11, '2023-06-08 18:08:45', '2023-06-08 18:08:45', 'SIM'),
(51, 'Charity', 'ATIVO', 28683581442, 'russel.jones@boyle.com', '$2y$10$ivED9l1n7PGjccmCCYahjexZ7Vpq7U/8e6vNnirI.1jWvHHjVApXi', NULL, NULL, 8, '2023-06-08 18:08:45', '2023-06-08 18:08:45', 'SIM'),
(52, 'Nicolette', 'ATIVO', 85149786317, 'moen.porter@dietrich.com', '$2y$10$G608I4DwMifxzaTIvKUTn.SRR5y1SL.gnNRv9NRRGM/s0IYnbDnEq', NULL, 23, 23, '2023-06-08 18:08:45', '2023-06-08 18:08:45', 'NAO'),
(53, 'Estefania', 'ATIVO', 66175831743, 'padberg.ola@shanahan.info', '$2y$10$WRQWk0swhNwOYsoJU2x4aOkTmCk986jmJn66YPcEaxkTJaK8BkGve', NULL, NULL, 21, '2023-06-08 18:08:45', '2023-06-08 18:08:45', 'NAO'),
(54, 'Leonard', 'ATIVO', 80180526690, 'donald68@yahoo.com', '$2y$10$InVQwNpTVJO9qT7apuIchuM.AaN1JH53viu13Esz3REF6.xqA7at2', NULL, NULL, 8, '2023-06-08 18:08:45', '2023-06-08 18:08:45', 'NAO'),
(55, 'Broderick', 'ATIVO', 22614305799, 'verdie06@yahoo.com', '$2y$10$.Lg/ttbjpxn7EaG4Mbu6VOztxc6Ac9e2ZT7fEisSPn3pt/IwwJXTS', NULL, NULL, 10, '2023-06-08 18:08:45', '2023-06-08 18:08:45', 'NAO'),
(56, 'Ima', 'ATIVO', 50635643669, 'hulda.lowe@bosco.com', '$2y$10$/Sh356wE/ddc8GnVQIFKzO1Q8GSw/z26z8j92X89zUuUMejSj6b0u', NULL, 5, 2, '2023-06-08 18:08:46', '2023-06-08 18:08:46', 'NAO'),
(57, 'Golda', 'ATIVO', 48084457561, 'iherman@reynolds.org', '$2y$10$LFijpaWvgEzkCWU6g3wNrORR68Siha.8l1GwTvxQTWTsdqJV4Wovu', NULL, 14, 7, '2023-06-08 18:08:46', '2023-06-08 18:08:46', 'SIM'),
(58, 'Ernie', 'ATIVO', 66322341774, 'golda.spencer@yahoo.com', '$2y$10$Kd11IhBvX2RSsKnqkKsk9.K27Vteg6CcNVwR7kbBotwse7OQKCCC6', NULL, NULL, 11, '2023-06-08 18:08:46', '2023-06-08 18:08:46', 'NAO'),
(59, 'Lera', 'ATIVO', 82496439657, 'kwill@yahoo.com', '$2y$10$u5UTXt559r4CJpFlGfwRQe/AzIBprrSheBYG95tLu3n3SWAhvSJLK', NULL, NULL, 22, '2023-06-08 18:08:46', '2023-06-08 18:08:46', 'NAO'),
(60, 'Edward', 'ATIVO', 94318049636, 'barrows.rickey@abbott.com', '$2y$10$Ywb75Lwvd0N8JqBKrETSreSZ6qgar/xQ68nMBxXkYsRfZBYTOGTmi', NULL, NULL, 13, '2023-06-08 18:08:46', '2023-06-08 18:08:46', 'NAO'),
(61, 'Maryam', 'ATIVO', 30015532258, 'brock.barrows@thiel.com', '$2y$10$44eEMCxi1OW9wDOxikZdz.ZFRFfqVPXEFMgQacKLD8NpUhxvtVcj6', NULL, 11, 7, '2023-06-08 18:08:46', '2023-06-08 18:08:46', 'SIM'),
(62, 'Sherwood', 'ATIVO', 78051111563, 'rosenbaum.rodger@gmail.com', '$2y$10$7fEg3EGLBYKg5Nc28p5Bye4sASUWC/ld/beKxfRaxFuezsyjtz2JC', NULL, 23, 23, '2023-06-08 18:08:46', '2023-06-08 18:08:46', 'SIM'),
(63, 'Rolando', 'ATIVO', 36167647197, 'weston.mcclure@gmail.com', '$2y$10$k4/0gpdNfh3ojkz94vaf5.aARLJgO8fIJbHh.FnR0w.SMaoxxt.NG', NULL, NULL, 4, '2023-06-08 18:08:46', '2023-06-08 18:08:46', 'SIM'),
(64, 'Brendon', 'ATIVO', 81081365223, 'lemke.barton@schuster.com', '$2y$10$cBA80emC5FCWIpazZfhaK.5y0S.sXlOjQB2rqcP5OBIcvEbF1OnVq', NULL, NULL, 8, '2023-06-08 18:08:46', '2023-06-08 18:08:46', 'NAO'),
(65, 'Travon', 'ATIVO', 58214157404, 'pheathcote@yahoo.com', '$2y$10$Sz5mplo7fdz0iTp./TfGm.gtEnO0CrhSVGyvRnefmpdaDqhqJCTb6', NULL, 25, 26, '2023-06-08 18:08:47', '2023-06-08 18:08:47', 'NAO'),
(66, 'Claud', 'ATIVO', 84849805400, 'fiona32@hotmail.com', '$2y$10$QiXkfqXi1CN6P1SPG5pD6OykVl.1gd5QETZTSbgYiEvW8P7Futqy.', NULL, NULL, 13, '2023-06-08 18:08:47', '2023-06-08 18:08:47', 'NAO'),
(67, 'Jana', 'ATIVO', 53143952629, 'nikki81@hegmann.com', '$2y$10$7/cqOGK86O0A/52SPcQAzuyqvEh1xK6PGbpolYaE5fUjXcZmo4ip2', NULL, NULL, 4, '2023-06-08 18:08:47', '2023-06-08 18:08:47', 'SIM'),
(68, 'Jordyn', 'ATIVO', 53552544011, 'orlando75@gulgowski.com', '$2y$10$1.FM2mTdvpuxH278jkVjJ.IGLFioSMFb7aZhNb4Hm82VLzfl7j4xm', NULL, NULL, 25, '2023-06-08 18:08:47', '2023-06-08 18:08:47', 'SIM'),
(69, 'Alda', 'ATIVO', 72033142486, 'jena95@hotmail.com', '$2y$10$qzgDEei.dxEBZppA0DiQHeDVBq.gDh0pPiJQw3PCqU7fIcI93SucK', NULL, 12, 7, '2023-06-08 18:08:47', '2023-06-08 18:08:47', 'SIM'),
(70, 'Lawson', 'ATIVO', 29384509997, 'rbode@beer.com', '$2y$10$/OoajGFgwVKlcpOdNxx5quoyhf7O/BdqMcqh79VHSnmGtelk9OlAC', NULL, NULL, 16, '2023-06-08 18:08:47', '2023-06-08 18:08:47', 'NAO'),
(71, 'Michale', 'ATIVO', 82559999888, 'fritchie@hotmail.com', '$2y$10$fvo6vK09jTS7ED/Y8v/wReIl1P1WfrW/cZqwgJeVPkd7DctDQ/8Em', NULL, 2, 1, '2023-06-08 18:08:47', '2023-06-08 18:08:47', 'SIM'),
(72, 'Josianne', 'ATIVO', 43605741800, 'rosalyn.stokes@lind.com', '$2y$10$9OnR5fZIT5bTYxd3EKSAwugFY2/3IqjU.d2MEcdFSBFy8uiDMxj36', NULL, 23, 23, '2023-06-08 18:08:47', '2023-06-08 18:08:47', 'NAO'),
(73, 'Tabitha', 'ATIVO', 48876715390, 'sibyl.damore@graham.com', '$2y$10$Mvuq7DyUNTSBGLZu5N2NJe6KYnaruaNYnlH1jBaBV5ENsnC8ruyLm', NULL, NULL, 22, '2023-06-08 18:08:48', '2023-06-08 18:08:48', 'SIM'),
(74, 'Susanna', 'ATIVO', 90162932446, 'angel.parker@hotmail.com', '$2y$10$B47roj1POciCsLXmjTlSoeTcD83YTzbI5Xn6rcL2kJLj3IVy.Euna', NULL, 1, 1, '2023-06-08 18:08:48', '2023-06-08 18:08:48', 'SIM'),
(75, 'Wava', 'ATIVO', 85076629673, 'lueilwitz.alexanne@gerlach.info', '$2y$10$G4M.ZemaxnMt6iIq.Z9DbuHNPGaGwkHLTDb.i0pOhD.PnD7tKSpfC', NULL, 6, 2, '2023-06-08 18:08:48', '2023-06-08 18:08:48', 'NAO'),
(76, 'Dell', 'ATIVO', 20684188681, 'anika.jakubowski@witting.com', '$2y$10$o3zO622ayE6.omhhWaLOuuY3fvbzP2b8Wlcb.ghFKuvQSHAHAPpuW', NULL, NULL, 24, '2023-06-08 18:08:48', '2023-06-08 18:08:48', 'NAO'),
(77, 'Kyle', 'ATIVO', 50853207654, 'shyanne.hilpert@gmail.com', '$2y$10$pHCTOxavJHsQhMkpwnru0uTsoNOWNzQARo1CtyknGTCjSG1ONrQ6.', NULL, 6, 2, '2023-06-08 18:08:48', '2023-06-08 18:08:48', 'NAO'),
(78, 'Anabel', 'ATIVO', 93475966508, 'lempi.crist@rau.com', '$2y$10$na1CkMIH4EsE/uTpk/plseNw2CjoZbPa208OIUE9Qqbv0rPFG2mt.', NULL, NULL, 3, '2023-06-08 18:08:48', '2023-06-08 18:08:48', 'SIM'),
(79, 'Deanna', 'ATIVO', 55298663322, 'boyer.forrest@krajcik.org', '$2y$10$ToDP95SJvgNRkgLQz48oo.kx4wzHQb/lPhcLqjRF.CDKZ08srk0T6', NULL, NULL, 8, '2023-06-08 18:08:48', '2023-06-08 18:08:48', 'NAO'),
(80, 'Rod', 'ATIVO', 16017385321, 'pfannerstill.rory@hotmail.com', '$2y$10$fP8VmIbHBxni7pvaS1zcJOVFJYEBSfv7rXVAxXCfGF/wdrkKMcPya', NULL, 19, 19, '2023-06-08 18:08:48', '2023-06-08 18:08:48', 'SIM'),
(81, 'Eve', 'ATIVO', 73032075191, 'smitham.lilliana@gmail.com', '$2y$10$JrnNYeoJRm6lV8BQe/U2IuDYKxCCtekqWyUEMKn3Iikpc4nTmYkd6', NULL, NULL, 13, '2023-06-08 18:08:49', '2023-06-08 18:08:49', 'SIM'),
(82, 'Stewart', 'ATIVO', 60882008129, 'monahan.clare@bogisich.com', '$2y$10$0EDdNDDLbsI5hD/11Jfc8eWQaQr/npi0SGfz9bB73HEQvHdo9C.sm', NULL, 6, 2, '2023-06-08 18:08:49', '2023-06-08 18:08:49', 'NAO'),
(83, 'Frieda', 'ATIVO', 25109926221, 'rebecca.marquardt@jast.com', '$2y$10$.NJ5FwPfLr2YIVxV.QGFjuoHbWI4nGuceCwTKcc/oRwMBPbZls8ua', NULL, NULL, 25, '2023-06-08 18:08:49', '2023-06-08 18:08:49', 'NAO'),
(84, 'Tomas', 'ATIVO', 30211049843, 'gus19@romaguera.com', '$2y$10$07jlzmXvq.CQj/1bSUWe4uYeSGJOHCfLksQ4cV5l0szpngzPynD26', NULL, 25, 26, '2023-06-08 18:08:49', '2023-06-08 18:08:49', 'NAO'),
(85, 'Hildegard', 'ATIVO', 72239576936, 'flo.mohr@yahoo.com', '$2y$10$mwFHOTosHQFxcs92oqd9s.Mb5kG0xg9DSYMDfaBulndYDWNpsq0R6', NULL, NULL, 13, '2023-06-08 18:08:49', '2023-06-08 18:08:49', 'SIM'),
(86, 'Ola', 'ATIVO', 55987861727, 'nyasia.kuphal@conroy.com', '$2y$10$OPWlTDP9AKmhrJcvJ1YQfeTH3e0dF.FklYg1GO4kKZHtAHwEtVb0W', NULL, NULL, 12, '2023-06-08 18:08:49', '2023-06-08 18:08:49', 'NAO'),
(87, 'Ladarius', 'ATIVO', 85752039159, 'hamill.delta@gmail.com', '$2y$10$RnTg1o6b1jsttnDVE307l.Kf4lzlZ87VU0IcQHPyQcoGl02rqmf5W', NULL, NULL, 17, '2023-06-08 18:08:49', '2023-06-08 18:08:49', 'NAO'),
(88, 'Sammie', 'ATIVO', 77604644183, 'mills.roy@gmail.com', '$2y$10$w2tECtE9h4P7X7NMaTjCZupAfI6tBl3Svy2M6yt/m5bZR9rhQD.NW', NULL, NULL, 14, '2023-06-08 18:08:49', '2023-06-08 18:08:49', 'NAO'),
(89, 'Hannah', 'ATIVO', 61358328432, 'heber91@hotmail.com', '$2y$10$M/lyr6tvn.VWpu9QZ7ryWe0DZQt5QjrMQrxfNGI9PE9pnJ0IUOHWK', NULL, NULL, 10, '2023-06-08 18:08:49', '2023-06-08 18:08:49', 'SIM'),
(90, 'Howard', 'ATIVO', 75080323476, 'nolan.kailyn@weber.com', '$2y$10$faAZnlEtxON2Pbe4gI/l9ecrTOq18102pWOwwCtTRt1wapuJkDAzm', NULL, NULL, 8, '2023-06-08 18:08:50', '2023-06-08 18:08:50', 'SIM'),
(91, 'Elmo', 'ATIVO', 66002569942, 'julius.herman@bartell.com', '$2y$10$uPKFeCVXQHfRTpePTTyFUuJa5tXaCONDR/3dCw6JjPhLvraJhyCxu', NULL, 26, 26, '2023-06-08 18:08:50', '2023-06-08 18:08:50', 'NAO'),
(92, 'Antoinette', 'ATIVO', 39727738904, 'rosanna.bailey@gmail.com', '$2y$10$EUv3qzW/5.l0nVLkwqwDJOyeIuUH1myeCduoJqiIfLts1L4JlKK0q', NULL, NULL, 6, '2023-06-08 18:08:50', '2023-06-08 18:08:50', 'SIM'),
(93, 'Polly', 'ATIVO', 32208564600, 'bechtelar.lesly@gmail.com', '$2y$10$hTH0zhuGYyrgYfDJ39OE3Oklv7rgDdit9Racr0F0FpvXfMrYDLtN2', NULL, NULL, 11, '2023-06-08 18:08:50', '2023-06-08 18:08:50', 'NAO'),
(94, 'Rod', 'ATIVO', 55995888892, 'demario97@gmail.com', '$2y$10$KrNF/yqb0XR5.TPoICRKtevTMyPOylGa.cGxsQMZCXITXVOQkPJg6', NULL, 5, 2, '2023-06-08 18:08:50', '2023-06-08 18:08:50', 'SIM'),
(95, 'Junius', 'ATIVO', 94005591947, 'royce70@hotmail.com', '$2y$10$bJIRA159Fz2fUbaov9xZ2.ewzSG2DLmgTRpz4CJZcAYrTmfx11032', NULL, 16, 9, '2023-06-08 18:08:50', '2023-06-08 18:08:50', 'NAO'),
(96, 'Chadd', 'ATIVO', 44587420799, 'dolores.murray@hotmail.com', '$2y$10$Et0V4aMJ1SXRTtprbR1hpORGSo6k7kaLwU42PqYW9ImAAko/LmrRu', NULL, NULL, 6, '2023-06-08 18:08:50', '2023-06-08 18:08:50', 'SIM'),
(97, 'Marlene', 'ATIVO', 16808553646, 'yhammes@braun.com', '$2y$10$fwzlN3J9M3KUA4Jur60BLOC0GHBRgR4egvlamfevVCo1aMpfKeV2W', NULL, 20, 20, '2023-06-08 18:08:50', '2023-06-08 18:08:50', 'NAO'),
(98, 'Tia', 'ATIVO', 39156522124, 'devyn.lehner@jacobi.com', '$2y$10$yBVYpfAm0d3DG.vTfrAmhuYH/4KjIGATybhkx4oAD0UtetsHN9Ohq', NULL, NULL, 17, '2023-06-08 18:08:50', '2023-06-08 18:08:50', 'SIM'),
(99, 'Marion', 'ATIVO', 26029724258, 'hills.dock@spencer.net', '$2y$10$AJIz.8mgLQeDrRGRGmb2ZO08quAFSZISu43c7UzSyiVc0uUGXCCLG', NULL, NULL, 16, '2023-06-08 18:08:50', '2023-06-08 18:08:50', 'SIM'),
(100, 'Mercedes', 'ATIVO', 70398399148, 'abbie39@hotmail.com', '$2y$10$ku6qclKlO/2HnSOd6g9mIeybREgJWDbfNJeIC85tG3x3OF4at1Fdi', NULL, 6, 2, '2023-06-08 18:08:51', '2023-06-08 18:08:51', 'NAO'),
(103, 'Alex', 'ATIVO', 83910593482, 'alex@umuarama.com.br', '$2y$10$EQTaw5iy4VegrqRD4tN1/e7WMaU7EmSepMr0q/7TnYin0AcACYJ5i', NULL, NULL, 3, '2023-08-27 13:18:17', '2023-08-27 13:18:48', 'SIM'),
(106, 'asasdadasd', 'ATIVO', 34242242432, 'asdasasdasd@dsajdas.con', NULL, '$2y$10$qnUGjnuYZYAWtXyFQY5Phu.xjm9YIVGxfg2hIgFEzLMHu74aivH7G', 15, 9, '2023-09-02 01:49:00', '2023-09-02 01:49:00', 'SIM'),
(107, 'dasdsadasd', 'ATIVO', 23123123123, 'sdasdasd@dnadaj.com', NULL, '$2y$10$nq0LCqBum01eYCjC2zCnHuQU0hWqofRI7ZN/hzwFPlXASCnAFHJji', NULL, 11, '2023-09-02 01:50:56', '2023-09-02 01:50:56', 'SIM'),
(108, 'dasdsd', 'ATIVO', 13131233131, 'sasdad@asdjbas.com', NULL, '$2y$10$uVzxOvPsmbKN26KDF2KY3eqHLLuBSDoyriQa9EiayPXwFeyvwN5G6', 6, 2, '2023-09-02 01:51:23', '2023-09-02 01:51:23', 'SIM');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `audits`
--
ALTER TABLE `audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audits_auditable_type_auditable_id_index` (`auditable_type`,`auditable_id`),
  ADD KEY `audits_usuario_id_usuario_type_index` (`usuario_id`,`usuario_type`);

--
-- Índices de tabela `diretorias`
--
ALTER TABLE `diretorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `diretorias_nome_unique` (`nome`),
  ADD KEY `diretorias_orgao_id_foreign` (`orgao_id`);

--
-- Índices de tabela `divisoes`
--
ALTER TABLE `divisoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `divisoes_diretoria_id_foreign` (`diretoria_id`);

--
-- Índices de tabela `entregas`
--
ALTER TABLE `entregas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entregas_usuario_id_foreign` (`usuario_id`),
  ADD KEY `entregas_itens_solicitacao_id_foreign` (`itens_solicitacao_id`);

--
-- Índices de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Índices de tabela `itens_solicitacoes`
--
ALTER TABLE `itens_solicitacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `itens_solicitacoes_produto_id_foreign` (`produto_id`),
  ADD KEY `itens_solicitacoes_solicitacao_id_foreign` (`solicitacao_id`);

--
-- Índices de tabela `local_impressoras`
--
ALTER TABLE `local_impressoras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `local_impressoras_produto_id_foreign` (`produto_id`),
  ADD KEY `local_impressoras_diretoria_id_foreign` (`diretoria_id`),
  ADD KEY `local_impressoras_divisao_id_foreign` (`divisao_id`);

--
-- Índices de tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `orgaos`
--
ALTER TABLE `orgaos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orgaos_nome_unique` (`nome`);

--
-- Índices de tabela `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Índices de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `solicitacoes`
--
ALTER TABLE `solicitacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `solicitacoes_usuario_id_foreign` (`usuario_id`),
  ADD KEY `solicitacoes_diretoria_id_foreign` (`diretoria_id`),
  ADD KEY `solicitacoes_divisao_id_foreign` (`divisao_id`);

--
-- Índices de tabela `suprimentos`
--
ALTER TABLE `suprimentos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_produto_suprimento_constraint` (`produto_id`,`suprimento_id`),
  ADD KEY `suprimentos_suprimento_id_foreign` (`suprimento_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarios_divisao_id_foreign` (`divisao_id`),
  ADD KEY `usuarios_diretoria_id_foreign` (`diretoria_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `audits`
--
ALTER TABLE `audits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT de tabela `diretorias`
--
ALTER TABLE `diretorias`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `divisoes`
--
ALTER TABLE `divisoes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `entregas`
--
ALTER TABLE `entregas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `itens_solicitacoes`
--
ALTER TABLE `itens_solicitacoes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de tabela `local_impressoras`
--
ALTER TABLE `local_impressoras`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `orgaos`
--
ALTER TABLE `orgaos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `solicitacoes`
--
ALTER TABLE `solicitacoes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de tabela `suprimentos`
--
ALTER TABLE `suprimentos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `diretorias`
--
ALTER TABLE `diretorias`
  ADD CONSTRAINT `diretorias_orgao_id_foreign` FOREIGN KEY (`orgao_id`) REFERENCES `orgaos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `divisoes`
--
ALTER TABLE `divisoes`
  ADD CONSTRAINT `divisoes_diretoria_id_foreign` FOREIGN KEY (`diretoria_id`) REFERENCES `diretorias` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `entregas`
--
ALTER TABLE `entregas`
  ADD CONSTRAINT `entregas_itens_solicitacao_id_foreign` FOREIGN KEY (`itens_solicitacao_id`) REFERENCES `itens_solicitacoes` (`id`),
  ADD CONSTRAINT `entregas_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `itens_solicitacoes`
--
ALTER TABLE `itens_solicitacoes`
  ADD CONSTRAINT `itens_solicitacoes_produto_id_foreign` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `itens_solicitacoes_solicitacao_id_foreign` FOREIGN KEY (`solicitacao_id`) REFERENCES `solicitacoes` (`id`);

--
-- Restrições para tabelas `local_impressoras`
--
ALTER TABLE `local_impressoras`
  ADD CONSTRAINT `local_impressoras_diretoria_id_foreign` FOREIGN KEY (`diretoria_id`) REFERENCES `diretorias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `local_impressoras_divisao_id_foreign` FOREIGN KEY (`divisao_id`) REFERENCES `divisoes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `local_impressoras_produto_id_foreign` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `solicitacoes`
--
ALTER TABLE `solicitacoes`
  ADD CONSTRAINT `solicitacoes_diretoria_id_foreign` FOREIGN KEY (`diretoria_id`) REFERENCES `diretorias` (`id`),
  ADD CONSTRAINT `solicitacoes_divisao_id_foreign` FOREIGN KEY (`divisao_id`) REFERENCES `divisoes` (`id`),
  ADD CONSTRAINT `solicitacoes_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `suprimentos`
--
ALTER TABLE `suprimentos`
  ADD CONSTRAINT `suprimentos_produto_id_foreign` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `suprimentos_suprimento_id_foreign` FOREIGN KEY (`suprimento_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_diretoria_id_foreign` FOREIGN KEY (`diretoria_id`) REFERENCES `diretorias` (`id`),
  ADD CONSTRAINT `usuarios_divisao_id_foreign` FOREIGN KEY (`divisao_id`) REFERENCES `divisoes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
