
-- --------------------------------------------------------

--
-- Estrutura da tabela `subtarefas`
--

CREATE TABLE IF NOT EXISTS `subtarefas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `demanda_id` int(11) unsigned NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `check` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `dt_prevista` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) 
