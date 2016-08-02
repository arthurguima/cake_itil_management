ALTER TABLE `servicos` ADD `clarity_id` VARCHAR(250) NOT NULL AFTER `cliente_id`, ADD `sdm_id` VARCHAR(250) NOT NULL AFTER `clarity_id`;

ALTER TABLE `rdms` DROP `responsavel`;

ALTER TABLE `servicos` ADD `responsavel_id` INT(11) UNSIGNED NULL AFTER `cliente_id`;

ALTER TABLE `servicos` CHANGE `id_sdm` `id_sdm` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `servicos` CHANGE `id_clarity` `id_clarity` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `rdms` ADD `ano` INT(6) NULL AFTER `numero`;
ALTER TABLE `rdms` ADD UNIQUE( `numero`, `ano`);
ALTER TABLE `rdms` CHANGE `rdm_tipo_id` `rdm_tipo_id` INT(11) UNSIGNED NULL;
ALTER TABLE `rdms` ADD `cab_approval` TINYINT(2) UNSIGNED NOT NULL AFTER `sucesso`;
ALTER TABLE `rdms` CHANGE `cab_approval` `cab_approval` TINYINT(2) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `servicos` CHANGE `sigla` `sigla` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `servicos` CHANGE `nome` `nome` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `users` ADD `is_admin` TINYINT(2) UNSIGNED NOT NULL DEFAULT '0' AFTER `nome`;
ALTER TABLE `releases` ADD `dt_ini_prevista` DATE NULL , ADD `dt_fim_prevista` DATE NULL , ADD `dt_fim` DATE NULL ;
