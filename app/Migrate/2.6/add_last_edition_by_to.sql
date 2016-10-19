ALTER TABLE `servicos` ADD `last_edit_by` INT(11) UNSIGNED NOT NULL AFTER `modified`;
ALTER TABLE `statuses` ADD `last_edit_by` INT(11) UNSIGNED NOT NULL AFTER `modified`;
ALTER TABLE `users` ADD `modified` datetime NOT NULL AFTER `is_admin`;
ALTER TABLE `users` ADD `last_edit_by` INT(11) UNSIGNED NOT NULL AFTER `modified`;
ALTER TABLE `demandas` ADD `last_edit_by` INT(11) UNSIGNED NOT NULL AFTER `modified`;
ALTER TABLE `historicos` ADD `last_edit_by` INT(11) UNSIGNED NOT NULL AFTER `modified`;
