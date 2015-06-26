CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `matricula` int(10) NOT NULL,
  `nome` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `clientes_users` (
  `cliente_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `sses` ADD `user_id` INT(11) UNSIGNED NOT NULL AFTER `responsavel`;
ALTER TABLE `pes` ADD `user_id` INT(11) UNSIGNED NOT NULL AFTER `responsavel`;
ALTER TABLE `rdms` ADD `user_id` INT(11) UNSIGNED NOT NULL AFTER `responsavel`;
ALTER TABLE `ords` ADD `user_id` INT(11) UNSIGNED NOT NULL AFTER `responsavel`;
ALTER TABLE `chamados` ADD `user_id` INT(11) UNSIGNED NOT NULL AFTER `responsavel`;
ALTER TABLE `demandas` ADD `user_id` INT(11) UNSIGNED NOT NULL AFTER `criador`;
