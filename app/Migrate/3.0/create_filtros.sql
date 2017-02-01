DROP TABLE IF EXISTS `filtros`;
CREATE TABLE `filtros` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `pagina` varchar(20) NOT NULL,
  `valor` text NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
