CREATE TABLE IF NOT EXISTS `releases` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `servico_id` int(11) unsigned NOT NULL,
  `versao` varchar(40) NOT NULL,
  `rdm_id` int(11) unsigned NOT NULL,
  `observacao` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `release_id` int(11) NOT NULL,
  `valor` varchar(350) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
