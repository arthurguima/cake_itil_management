ALTER TABLE `rdms` ADD `autorizada` TINYINT(2) NOT NULL DEFAULT '0' AFTER `sucesso`, ADD `farm` TINYINT(2) NOT NULL DEFAULT '0' AFTER `autorizada`;
