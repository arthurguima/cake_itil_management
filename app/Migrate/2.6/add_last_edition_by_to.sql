ALTER TABLE `users` ADD `mail` VARCHAR(70) NULL DEFAULT NULL AFTER `nome`, ADD `is_admin` TINYINT(2) NOT NULL DEFAULT '0' AFTER `mail`, ADD `modified` DATETIME NOT NULL AFTER `is_admin`, ADD `last_edit_by` INT(11) NOT NULL AFTER `modified`;
ALTER TABLE `servicos` ADD `last_edit_by` INT(11) UNSIGNED NOT NULL AFTER `modified`;
ALTER TABLE `statuses` ADD `last_edit_by` INT(11) UNSIGNED NOT NULL AFTER `modified`;
ALTER TABLE `users` ADD `modified` datetime NOT NULL AFTER `is_admin`;
ALTER TABLE `users` ADD `last_edit_by` INT(11) UNSIGNED NOT NULL AFTER `modified`;
ALTER TABLE `demandas` ADD `last_edit_by` INT(11) UNSIGNED NOT NULL AFTER `modified`;
ALTER TABLE `historicos` ADD `last_edit_by` INT(11) UNSIGNED NOT NULL AFTER `modified`;
