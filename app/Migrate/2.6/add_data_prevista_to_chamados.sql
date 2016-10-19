ALTER TABLE `chamados` ADD `dt_prev_resolv` DATE NULL AFTER `status_id`;
ALTER TABLE `indisponibilidades` ADD UNIQUE( `num_evento`, `ano`);
ALTER TABLE `indisponibilidades_servicos` ADD UNIQUE( `servico_id`, `indisponibilidade_id`);
