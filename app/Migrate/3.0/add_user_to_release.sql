ALTER TABLE `releases` ADD `user_id` INT(11) UNSIGNED NULL AFTER `servico_id`;
ALTER TABLE `historicos`  ADD `release_id` INT(11) UNSIGNED NOT NULL  AFTER `demanda_id`;
