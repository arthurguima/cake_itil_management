CREATE TABLE `grupotarefas` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) NOT NULL,
  `tipo` tinyint(2) NOT NULL,
  `marcador` varchar(15) NULL,
  PRIMARY KEY (`id`)
);

/* Items do Grupo */
CREATE TABLE `grupotarefa_items` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `grupotarefa_id` int(11) UNSIGNED NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `duracao` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

ALTER TABLE `subtarefas` ADD `marcador` VARCHAR(15) NULL AFTER `check`;
