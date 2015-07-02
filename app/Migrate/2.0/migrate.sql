--
-- Table structure for table `aditivos`
--

DROP TABLE IF EXISTS `aditivos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aditivos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `dt_inicio` date default NULL,
  `dt_fim` date default NULL,
  `contrato_id` int(11) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `areas` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `cliente_id` varchar(11) NOT NULL,
  `nome` varchar(100) default NULL,
  `sigla` varchar(50) default NULL,
  `status` tinyint(1) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `areas_servicos`
--

DROP TABLE IF EXISTS `areas_servicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `areas_servicos` (
  `area_id` int(11) NOT NULL,
  `servico_id` int(11) NOT NULL,
  PRIMARY KEY  (`area_id`,`servico_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `chamado_tipos`
--

DROP TABLE IF EXISTS `chamado_tipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chamado_tipos` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `nome` varchar(100) NOT NULL,
  `servico_id` int(11) unsigned NOT NULL,
  `created` datetime default NULL,
  `updated` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `chamados`
--

DROP TABLE IF EXISTS `chamados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chamados` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `numero` varchar(50) default NULL,
  `ano` varchar(10) NOT NULL,
  `nome` varchar(100) default NULL,
  `responsavel` varchar(100) NOT NULL,
  `observacao` varchar(450) default NULL,
  `aberto` tinyint(1) default NULL,
  `pai` tinyint(11) default '0',
  `demanda_id` int(11) default NULL,
  `chamado_tipo_id` int(11) default NULL,
  `servico_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=208 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `chamados_rdms`
--

DROP TABLE IF EXISTS `chamados_rdms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chamados_rdms` (
  `chamado_id` int(11) unsigned NOT NULL,
  `rdm_id` int(11) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(80) default NULL,
  `sigla` varchar(20) NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `containers`
--

DROP TABLE IF EXISTS `containers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `containers` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `nome` varchar(30) NOT NULL,
  `url` varchar(200) NOT NULL,
  `servico_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=127 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contratos`
--

DROP TABLE IF EXISTS `contratos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contratos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `numero` varchar(45) NOT NULL,
  `data_ini` date NOT NULL,
  `data_fim` date default NULL,
  `status` tinyint(1) default '0',
  `cliente_id` int(11) NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `demanda_tipos`
--

DROP TABLE IF EXISTS `demanda_tipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `demanda_tipos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(60) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `demandas`
--

DROP TABLE IF EXISTS `demandas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `demandas` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(110) NOT NULL default 'Demanda - ',
  `clarity_id` int(20) NOT NULL,
  `clarity_dm_id` varchar(20) default NULL,
  `mantis_id` int(11) default NULL,
  `descricao` varchar(700) default NULL,
  `data_cadastro` date default NULL,
  `dt_prevista` date default NULL,
  `criador` varchar(45) default NULL,
  `origem_cliente` tinyint(3) unsigned default '0',
  `executor` varchar(45) NOT NULL,
  `data_homologacao` date default NULL,
  `servico_id` int(11) default NULL,
  `status_id` int(11) NOT NULL,
  `ss_id` int(11) default NULL,
  `demanda_tipo_id` int(11) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `prioridade` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=455 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `demandas_rdms`
--

DROP TABLE IF EXISTS `demandas_rdms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `demandas_rdms` (
  `demanda_id` int(11) default NULL,
  `rdm_id` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `demandas_sses`
--

DROP TABLE IF EXISTS `demandas_sses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `demandas_sses` (
  `demanda_id` int(11) default NULL,
  `ss_id` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dependencias`
--

DROP TABLE IF EXISTS `dependencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dependencias` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(100) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dependencias_servicos`
--

DROP TABLE IF EXISTS `dependencias_servicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dependencias_servicos` (
  `dependencia_id` int(11) default NULL,
  `servico_id` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `historicos`
--

DROP TABLE IF EXISTS `historicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historicos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `data` date default NULL,
  `descricao` text,
  `analista` varchar(50) default NULL,
  `demanda_id` int(11) default NULL,
  `ss_id` int(11) default NULL,
  `rdm_id` int(11) default NULL,
  `pe_id` int(11) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `ord_id` int(11) default NULL,
  `chamado_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=724 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `indicadores`
--

DROP TABLE IF EXISTS `indicadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `indicadores` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `mes` varchar(10) NOT NULL,
  `ano` varchar(10) NOT NULL,
  `valor` text NOT NULL,
  `contrato_id` int(11) unsigned default NULL,
  `aditivo_id` int(11) unsigned default NULL,
  `servico_id` int(11) NOT NULL,
  `regra_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `indisponibilidades`
--

DROP TABLE IF EXISTS `indisponibilidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `indisponibilidades` (
  `num_evento` varchar(30) default NULL,
  `observacao` varchar(500) default NULL,
  `motivo_id` int(11) default NULL,
  `anexo` blob,
  `dt_fim` datetime default NULL,
  `dt_inicio` datetime default NULL,
  `num_incidente` varchar(30) default NULL,
  `id` int(11) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `indisponibilidades_servicos`
--

DROP TABLE IF EXISTS `indisponibilidades_servicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `indisponibilidades_servicos` (
  `servico_id` int(11) NOT NULL,
  `indisponibilidade_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `internos`
--

DROP TABLE IF EXISTS `internos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `internos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(70) default NULL,
  `descricao` varchar(300) default NULL,
  `url` varchar(150) default NULL,
  `instrucoes` varchar(300) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `item_pes`
--

DROP TABLE IF EXISTS `item_pes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_pes` (
  `id` int(11) NOT NULL auto_increment,
  `volume` float NOT NULL,
  `contrato_id` int(11) unsigned default NULL,
  `aditivo_id` int(11) unsigned default NULL,
  `item_id` int(11) unsigned default NULL,
  `itempe_id` int(11) unsigned default NULL,
  `pe_id` int(11) NOT NULL,
  `ord_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(50) default NULL,
  `metrica` varchar(25) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `contrato_id` int(11) default NULL,
  `aditivo_id` int(11) default NULL,
  `volume` int(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `motivos`
--

DROP TABLE IF EXISTS `motivos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `motivos` (
  `id` int(11) NOT NULL auto_increment,
  `nome` varchar(45) NOT NULL,
  `ambiente` int(4) NOT NULL,
  `contavel` tinyint(1) NOT NULL,
  `created` date default NULL,
  `modified` date default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ords`
--

DROP TABLE IF EXISTS `ords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ords` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `numero` varchar(20) NOT NULL,
  `ano` varchar(20) NOT NULL,
  `dt_emissao` date default NULL,
  `dt_recebimento` date default NULL,
  `nome` varchar(120) NOT NULL,
  `cvs_url` varchar(250) default NULL,
  `pf` float default NULL,
  `dt_deploy_homologacao` date default NULL,
  `dt_deploy_producao` date default NULL,
  `dt_homologacao` date default NULL,
  `dt_execucao` date default NULL,
  `dt_ini_pdd` date default NULL,
  `dt_fim_pdd` date default NULL,
  `dt_homo_prev_int` date default NULL,
  `dt_homo_prev` date default NULL,
  `dt_recebimento_termo` date default NULL,
  `dt_recebimento_termo_prov` date default NULL,
  `dt_recebimento_homo` date default NULL,
  `ss_id` int(11) NOT NULL,
  `pe_id` int(11) NOT NULL,
  `servico_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `responsavel` varchar(200) NOT NULL,
  `observacao` varchar(500) NOT NULL,
  `ths` varchar(250) default NULL,
  `trp` varchar(250) default NULL,
  `trd` varchar(250) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pes`
--

DROP TABLE IF EXISTS `pes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(120) default NULL,
  `numero` varchar(45) default NULL,
  `ano` varchar(10) NOT NULL,
  `valor_item` varchar(11) default NULL,
  `temp_estimado` int(8) default NULL,
  `num_ce` varchar(20) default NULL,
  `cvs_url` varchar(200) default NULL,
  `responsavel` varchar(100) default NULL,
  `pf_estimado` varchar(11) default NULL,
  `dt_emissao` date default NULL,
  `validade_pdd` date default NULL,
  `observacao` varchar(500) NOT NULL,
  `dt_inicio` date default NULL,
  `os_id` int(11) default NULL,
  `ss_id` int(11) default NULL,
  `item_id` int(11) default NULL,
  `servico_id` int(11) default NULL,
  `status_id` int(11) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `procedimentos`
--

DROP TABLE IF EXISTS `procedimentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `procedimentos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(70) default NULL,
  `descricao` varchar(700) default NULL,
  `url` varchar(150) default NULL,
  `responsavel` varchar(70) default NULL,
  `dt_alteracao` date default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rdm_tipos`
--

DROP TABLE IF EXISTS `rdm_tipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rdm_tipos` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `nome` varchar(100) NOT NULL,
  `rdm_id` int(11) unsigned NOT NULL,
  `created` datetime default NULL,
  `updated` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rdms`
--

DROP TABLE IF EXISTS `rdms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rdms` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(300) default NULL,
  `observacao` varchar(350) default NULL,
  `numero` varchar(20) NOT NULL,
  `dt_prevista` date default NULL,
  `dt_executada` date default NULL,
  `versao` varchar(50) default NULL,
  `responsavel` varchar(100) NOT NULL,
  `solicitante` varchar(150) NOT NULL,
  `ambiente` int(4) NOT NULL,
  `sucesso` int(4) NOT NULL default '-1',
  `rdm_tipo_id` int(11) unsigned NOT NULL,
  `servico_id` int(11) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=351 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `regras`
--

DROP TABLE IF EXISTS `regras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regras` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `servico_id` int(11) NOT NULL,
  `aditivo_id` int(11) default NULL,
  `contrato_id` int(11) default NULL,
  `nome` varchar(200) NOT NULL,
  `modelo` text,
  `observacao` varchar(500) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `responsabilidades`
--

DROP TABLE IF EXISTS `responsabilidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `responsabilidades` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `processo` varchar(80) default NULL,
  `responsavel` varchar(80) default NULL,
  `area` varchar(80) default NULL,
  `ramal` varchar(20) default NULL,
  `email` varchar(40) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `servicos`
--

DROP TABLE IF EXISTS `servicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servicos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `url` varchar(150) NOT NULL,
  `tecnologia` varchar(45) NOT NULL,
  `sigla` varchar(20) default NULL,
  `nome` varchar(80) default NULL,
  `status` tinyint(1) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sses`
--

DROP TABLE IF EXISTS `sses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sses` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(120) default NULL,
  `servico_id` int(11) default NULL,
  `numero` varchar(45) default NULL,
  `ano` varchar(20) default NULL,
  `prioridade` int(11) default NULL,
  `clarity_id` int(11) default NULL,
  `clarity_dm_id` varchar(45) default NULL,
  `status_id` int(11) default NULL,
  `responsavel` varchar(100) default NULL,
  `valor_item` varchar(20) default NULL,
  `dv` varchar(250) default NULL,
  `contagem` varchar(250) default NULL,
  `observacao` varchar(1000) NOT NULL,
  `dt_prevista` date default NULL,
  `dt_prazo` date default NULL,
  `dt_recebimento` date NOT NULL,
  `dt_finalizada` date default NULL,
  `cvs_url` varchar(200) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `statuses`
--

DROP TABLE IF EXISTS `statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statuses` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(50) default NULL,
  `tipo` int(4) default NULL,
  `fim` tinyint(2) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-06-26  9:11:13
