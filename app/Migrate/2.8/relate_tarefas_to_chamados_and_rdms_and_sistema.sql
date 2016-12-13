ALTER TABLE `subtarefas` ADD `chamado_id` INT(11) UNSIGNED NULL DEFAULT NULL AFTER `demanda_id`, ADD `rdm_id` INT(11) UNSIGNED NULL DEFAULT NULL AFTER `chamado_id`, ADD `servico_id` INT(11) UNSIGNED NULL DEFAULT NULL AFTER `rdm_id`;
ALTER TABLE `subtarefas` ADD `user_id` INT(11) UNSIGNED NOT NULL AFTER `servico_id`;
ALTER TABLE `subtarefas` CHANGE `demanda_id` `demanda_id` INT(11) UNSIGNED NULL;
ALTER TABLE `subtarefas` ADD `release_id` INT(11) UNSIGNED NULL DEFAULT NULL AFTER `rdm_id`;

/*
  * Atualizar  as tarefas antigas - Migração da versão anterior
  * UPDATE `subtarefas` SET `servico_id` = (Select `servico_id` from `demandas` where `id` = `subtarefas`.`demanda_id`) where `id` > 0;
  * UPDATE `subtarefas` SET `user_id` = (Select `user_id` from `demandas` where `id` = `subtarefas`.`demanda_id`) where `id` > 0;
  *
*/
