<?php
  $this->Html->addCrumb("Sobre o SGS", '/pages/about');
?>

<style>
  .nav.nav-tabs-pages>li.active>a{
      background-color: #eee !important;
  }
</style>
<?php echo $this->Html->css('plugins/timeline.css'); ?>

<div class="col-lg-12 page-header-box">
    <div class="col-lg-12">
      <h3 class="page-header">
        Sistema de Gestão de Serviços
      </h3>
    </div>
</div>

<!-- Nav tabs -->
<ul class="nav nav-tabs nav-tabs-black nav-tabs-pages" role="tablist">
  <li role="presentation" class="active"><a href="#dev" aria-controls="dev" role="tab" data-toggle="tab">Desenvolvimento</a></li>
  <li role="presentation"><a href="#versoes" aria-controls="versoes" role="tab" data-toggle="tab">Versões</a></li>
  <li role="presentation"><a href="#descontinuado" aria-controls="descontinuado" role="tab" data-toggle="tab">Funções Descontinuadas</a></li>
</ul>

<div class="tab-content">
  <div role="tabpanel" class="tab-pane active" id="dev">
    <div class="col-lg-4 error">
      <div class="well">
        <h3 class="page-header"><i class="fa fa-rocket"></i> Desenvolvido por:</h3>
        <br />
        <div class="well">
          <ul class="list-unstyled spaced">
            <li>
              <h4> <i class="ace-icon far fa-hand-point-right"></i> Arthur Henrique Guimarães de Oliveira</h4>
                <div class="personal-info">
                  <b>Email:</b><a href="mailto:arthur.doliveira@dataprev.gov.br"> arthur.doliveira@dataprev.gov.br</a><br/>
                </div>
            </li>
          </ul>
        </div>
      </div>

      <div class="well">
        <h3 class="page-header"><i class="fa fa-rocket"></i> Ambiente de Desenvolvimento:</h3>
        <br />
        <div class="well">
          <ul class="list-unstyled spaced">
            <li>
              <h5> <i class="ace-icon far fa-hand-point-right"></i> CakePhp</h5>
              <h5> <i class="ace-icon far fa-hand-point-right"></i> Bootstrap 3</h5>
              <h5> <i class="ace-icon far fa-hand-point-right"></i> SBAdmin</h5>
              <h5> <i class="ace-icon far fa-hand-point-right"></i> Font Awesome</h5>
              <h5> <i class="ace-icon far fa-hand-point-right"></i> Jquery</h5>
              <h5> <i class="ace-icon far fa-hand-point-right"></i> DataTables</h5>
              <h5> <i class="ace-icon far fa-hand-point-right"></i> Circliful</h5>
              <h5> <i class="ace-icon far fa-hand-point-right"></i> CanvasJs</h5>
              <h5> <i class="ace-icon far fa-hand-point-right"></i> Fulcalendar</h5>
              <h5> <i class="ace-icon far fa-hand-point-right"></i> Jeditable</h5>
              <h5> <i class="ace-icon far fa-hand-point-right"></i> TinyMce</h5>
              <h5> <i class="ace-icon far fa-hand-point-right"></i> Vis</h5>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="col-lg-8 error">
      <div class="well">
        <h3 class="page-header"><i class="fa fa-hourglass-half" aria-hidden="true"></i> História:</h3>
        <br />
        <div class="well">
          <ul class="spaced">
            <li>O SGS surgiu no final de 2014 com o nome de SGD - Sistema de Gestão da DITE.</li>
            <li>A sua evolução pode ser acompanhada em "Mais Informações" -> "Versões";</li>
            <li>Em suas primeiras versões buscou atender necessidades tanto de negócio quanto da Gerência de serviço. Porém, por não contar com apoio suficiente voltou sua atenção apenas para a gestão de serviço.</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="col-lg-8 error">
      <div class="well">
        <h3 class="page-header"><i class="fa fa-heartbeat" aria-hidden="true"></i> Objetivo:</h3>
        <br />
        <div class="well">
          <ul class="spaced">
            <li>Eliminar o uso de planilhas locais.</li>
            <li>Manter a informação em um ambiente compartilhado pela equipe.</li>
            <li>Manter um histórico das atividades da equipe.</li>
            <li>Permitir o atendimento de uma atividade por pessoas diferentes em épocas diferentes.</li>
            <li>Associar as diferentes atividades realizadas da equipe.</li>
            <li>
              Acelerar a obtenção de dados referentes às atividades da equipe. Respondendo perguntas como:
              <ul>
                <li>Quantas RDMs foram necessárias para implantar a versão X do sistema?</li>
                <li>Qual RDM resolveu o incidente Y e qual a versão do sistema que foi implantada?</li>
                <li>Qual a média de incidentes relacionados à Extrato CNIS o Seguro Desemprego apresenta?</li>
                <li>Quantas demandas tenho sob minha responsabilidade?</li>
                <li>Quais as tarefas minha equipe realizou?</li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
</div>

  <div role="tabpanel" class="tab-pane" id="versoes">
    <div class="error">
      <div class="well">
        <h3 class="page-header"><i class="fa fa-tags"></i> Notas:</h3>
        <ul class="timeline">
          <li class="timeline-inverted">
            <div class="timeline-badge success">
              <i class="fas fa-tachometer-alt"></i>
            </div>
            <div class="timeline-panel">
              <ul class="list-unstyled spaced">
                <li>
                  <h4 class="page-header"> <i class="ace-icon far fa-hand-point-right"></i> Versão 3.5</h4>
                    <div class="personal-info">

                      <ul>
                        <li>Alterado o campo 'Finaliza Processo do Status' para 'Etapa'</li>
                        <li>Criada a Visualização Kanban para o Workspace</li>
                        <li>Removido o Menu Funções descontinuadas que agora estão no menu 'Sobre'</li>
                        <li>Removidas o Menu Dashboard que agora está em relatórios.</li>
                        <li>Atualizado Para fontawesome-5.</li>
                      </ul>
                    </div>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <div class="timeline-badge info">
              <i class="fa fa-bolt fa-fw"></i>
            </div>
            <div class="timeline-panel">
              <ul class="list-unstyled spaced">
                <li>
                  <h4 class="page-header"> <i class="ace-icon far fa-hand-point-right"></i> Versão 3.1 </h4>
                    <div class="personal-info">
                      <ul>
                        <li>Criados grupos de tarefas.</li>
                        <li>Notificações automáticas por e-mail das RDMs a serem executadas</li>
                        <li>Refatoração de layout</li>
                        <li>Melhorias nos Calendários</li>
                      </ul>
                    </div>
                </li>
              </ul>
            </div>
          </li>
          <li class="timeline-inverted">
            <div class="timeline-badge success">
              <i class="far fa-envelope fa-fw"></i>
            </div>
            <div class="timeline-panel">
              <ul class="list-unstyled spaced">
                <li>
                  <h4 class="page-header"> <i class="ace-icon far fa-hand-point-right"></i> Versão 3.0</h4>
                    <div class="personal-info">

                      <ul>
                        <li>Envio de e-mails para os responsáveis ao adicionar uma Subtarefa ou Demanda.</li>
                        <li>Filtro de Cliente e Ambiente no Calendário.</li>
                        <li>Removidas as SS(es) do Dashboard.</li>
                        <li>Possibilidade de escolher a aba inicial do Workspace.</li>
                        <li>Primeira versão dos Filtros Favoritos nos itens: Chamados, Chamados com Demandas, Demandas, Mudança e Indisponibilidades.</li>
                        <li>Refatoração das Tarefas. Criadas: data de início, fim, e o Status 'aguardando Início'.</li>
                        <li>Inclusão de guias visuais explicando as regras do sistemas (Inciado).</li>
                        <li>Inclusão das Releases no Dashboard.</li>
                        <li>Manutenção de Históricos das Releases.</li>
                        <li>Ordenação dos itens nos campos de select.</li>
                        <li>Substituídos as associações entre Rdms,Chamados, Releases,etc por chamados AJAX. (Performance e Usabilidade).</li>
                        <li>Atualizada a versão do Plugin Select2.</li>
                        <li>Informação visual das tarefas dos mês no workspace.</li>
                      </ul>
                    </div>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <div class="timeline-badge danger">
              <i class="fa fa-bolt fa-fw"></i>
            </div>
            <div class="timeline-panel">
              <ul class="list-unstyled spaced">
                <li>
                  <h4 class="page-header"> <i class="ace-icon far fa-hand-point-right"></i> Versão 2.8 </h4>
                    <div class="personal-info">
                      <ul>
                        <li>Criado o controle do período de disponibilidade por cliente (Dashboard).</li>
                        <li>A criação de tarefas foi expandida. (Sistema/Chamados/Rdms/Releases) </li>
                        <li>Criação de histórico nas indisponibilidades. </li>
                        <li>Relatório de Demandas não finalizadas por cliente. </li>
                      </ul>
                    </div>
                </li>
              </ul>
            </div>
          </li>
          <li class="timeline-inverted">
            <div class="timeline-badge warning">
              <i class="fa fa-wrench fa-fw"></i>
            </div>
            <div class="timeline-panel">
              <ul class="list-unstyled spaced">
                <li>
                  <h4 class="page-header"> <i class="ace-icon far fa-hand-point-right"></i> Versão 2.6</h4>
                    <div class="personal-info">

                      <ul>
                        <li>Removido Menu Gerencial</li>
                        <li>Demandas Internas transferidas a gestão de serviço</li>
                        <li>Mundaça de Demandas internas p/ Demandas</li>
                        <li>Controle de aprovação pelo CAB nas RDMs</li>
                        <li>Script de Carga automática de RDMs e verificação de aprovação pelo CAB</li>
                        <li>Script de Carga automática dos Incidentes</li>
                        <li>Script de Fechamento automático das Indisponibilidades</li>
                        <li>Controle de usuários 100% dinâmico</li>
                        <li>Criado o Menu Funções Descontinuadas: Menu Negócio e Base de conhecimento</li>
                        <li>Filtro no Calendário</li>
                        <li>Melhorias no Calendário de Indisponibilidades</li>
                        <li>Melhorias da Interface</li>
                        <li>Calendário de Tarefas das Demandas</li>
                        <li>Calendário de Chamados</li>
                        <li>Previsão de Atendimeno do Chamado</li>
                        <li>Flitro por Cliente na lista de Serviços</li>
                      </ul>
                    </div>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <div class="timeline-panel">
              <ul class="list-unstyled spaced">
                <li>
                  <h4 class="page-header"> <i class="ace-icon far fa-hand-point-right"></i> Versão 2.5 - SGS</h4>
                    <div class="personal-info">

                      <ul>
                        <li>Checklist de RDM</li>
                        <li>Releases dos Serviços</li>
                        <li>Visualização filtrada automaticamente por cliente</li>
                        <li>Nome alterado para Sistema de Gestão de Serviço</li>
                      </ul>
                    </div>
                </li>
              </ul>
            </div>
          </li>
          <li class="timeline-inverted">
            <div class="timeline-badge info">
              <i class="fa fa-user-plus fa-fw"></i>
            </div>
            <div class="timeline-panel">
              <ul class="list-unstyled spaced">
                <li>
                  <h4 class="page-header"> <i class="ace-icon far fa-hand-point-right"></i> Versão 2.1</h4>
                    <div class="personal-info">

                      <ul>
                        <li>Menu Gerencial</li>
                        <li>Script de atualização automática de RDM</li>
                        <li>Resgatar dados dos Chamados no SDM</li>
                        <li>Resgatar dados das RDMs no SDM</li>
                        <li>Workspace</li>
                        <li>Cadastro de demandas filhas das demandas internas</li>
                        <li>Relatório de Prioridade das Demandas</li>
                        <li>Calendário de Indisponibilidades</li>
                        <li>Subtarefas de uma Demanda</li>
                        <li>Demandas Filhas de uma Demanda</li>
                      </ul>
                    </div>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <div class="timeline-panel">
              <ul class="list-unstyled spaced">
                <li>
                  <h4 class="page-header"> <i class="ace-icon far fa-hand-point-right"></i> Versão 2.0</h4>
                    <div class="personal-info">

                      <ul>
                        <li>Dashboard Separada Por Clientes</li>
                        <li>Análise de Demandas Atrasadas no Dashboard</li>
                        <li>Análise de RDMs no Dashboard</li>
                        <li>Análise das SSes no Dashboard</li>
                        <li>Disponibilidade dos Containers de Serviço</li>
                        <li>Relatórios Separados por Clientes</li>
                        <li>Visões Gerais por clientes no Dashboard</li>
                        <li>Relatório de Contrato</li>
                        <li>Relatório de Gestão de SS</li>
                      </ul>
                    </div>
                </li>
              </ul>
            </div>
          </li>
          <li class="timeline-inverted">
            <div class="timeline-badge danger">
              <i class="fas fa-eye-dropper fa-fw"></i>
            </div>
            <div class="timeline-panel">
              <ul class="list-unstyled spaced">
                <li>
                  <h4 class="page-header"> <i class="ace-icon far fa-hand-point-right"></i> Versão 1.9.X</h4>
                    <div class="personal-info">

                      <ul>
                        <li>Timeline da SS</li>
                        <li>Resgatar dados do Clarity em Demandas Internas e SS</li>
                        <li>Registro dos Indicadores de Contrato</li>
                        <li>Melhorias de Usabilidade e Interface</li>
                        <li>Relatório de Demandas Internas Não Finalizadas</li>
                        <li>Link para as Indisponibilidades do Período na Home (SDM & Interno)</li>
                        <li>Relatório de Disponibilidade Geral</li>
                      </ul>
                    </div>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <div class="timeline-badge success">
              <i class="fa fa-calendar fa-fw"></i>
            </div>
            <div class="timeline-panel">
              <ul class="list-unstyled spaced">
                <li>
                  <h4 class="page-header"> <i class="ace-icon far fa-hand-point-right"></i> Versão 1.8.8</h4>
                    <div class="personal-info">

                      <ul>
                        <li>Calendário</li>
                        <li>Checklist de OS</li>
                        <li>Correção de Bugs</li>
                        <li>Histórico em Pop-up</li>
                        <li>Melhorias de Usabilidade e Interface</li>
                      </ul>
                    </div>
                </li>
              </ul>
            </div>
          </li>
          <li class="timeline-inverted">
            <div class="timeline-badge info">
              <i class="fa fa-exclamation-triangle"></i>
            </div>
            <div class="timeline-panel">
              <ul class="list-unstyled spaced">
                <li>
                  <h4 class="page-header"> <i class="ace-icon far fa-hand-point-right"></i> Versão 1.6</h4>
                    <div class="personal-info">

                      <ul>
                        <li>Relatório de Indisponibilidade</li>
                        <li>Correção de Bugs.</li>
                      </ul>
                    </div>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <div class="timeline-badge warning">
              <i class="fa fa-phone"></i>
            </div>
            <div class="timeline-panel">
              <ul class="list-unstyled spaced">
                <li>
                  <h4 class="page-header"> <i class="ace-icon far fa-hand-point-right"></i> Versão 1.5</h4>
                    <div class="personal-info">

                      <ul>
                        <li>Melhorias na gestão dos Chamados.</li>
                        <li>Visão dos chamados no Dashboard</li>
                        <li>Correção de Bugs.</li>
                      </ul>
                    </div>
                </li>
              </ul>
            </div>
          </li>
          <li class="timeline-inverted">
            <div class="timeline-panel">
              <ul class="list-unstyled spaced">
                <li>
                  <h4 class="page-header"> <i class="ace-icon far fa-hand-point-right"></i> Versão 1.4.2</h4>
                    <div class="personal-info">

                      <ul>
                        <li>Melhorias na gestão das RDMs.</li>
                        <li>Pequenas melhorias no Dashboard.</li>
                        <li>Registrar OS de cada SS.</li>
                        <li>Pesquisa avançada por chamados.</li>
                        <li>Correção de Bugs.</li>
                      </ul>
                    </div>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <div class="timeline-badge success">
              <i class="fa fa-briefcase fa-fw"></i>
            </div>
            <div class="timeline-panel">
              <ul class="list-unstyled spaced">
                <li>
                  <h4 class="page-header"> <i class="ace-icon far fa-hand-point-right"></i> Versão 1.4</h4>
                    <div class="personal-info">

                      <ul>
                        <li>Registrar RDMs dos diversos serviços.</li>
                        <li>Controlar quem pode remover registros do banco.</li>
                        <li>Registrar SS de cada serviço e relacioná-las com as demandas e itens de contrato.</li>
                        <li>Registrar PE de cada SS.</li>
                        <li>Nova visualização de Demandas Internas na Dashboard (TipoXStatus).</li>
                        <li>Correção de Bugs.</li>
                      </ul>
                    </div>
                </li>
              </ul>
            </div>
          </li>
          <li class="timeline-inverted">
            <div class="timeline-badge danger">
              <i class="fa fa-bomb"></i>
            </div>
            <div class="timeline-panel">
              <ul class="list-unstyled spaced">
                <li>
                  <h4 class="page-header"> <i class="ace-icon far fa-hand-point-right"></i> Versão 1.0 -  SGD</h4>
                    <div class="personal-info">
                      Esse é um novo mundo de gestão da DITE!<br/><br/> Agora você pode:<br/><br/>
                      <ul>
                        <li>Registrar Indisponibilidades dos Sistemas.</li>
                        <li>Controlar os contratos de cada cliente, seus itens e aditivos.</li>
                        <li>Controlar as áreas de cada cliente e seus serviços.</li>
                        <li>Registrar as demandas de cada serviço.</li>
                        <li>Registrar todo o conhecimento para as operações diárias no DITE.</li>
                      </ul>
                    </div>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div role="tabpanel" class="tab-pane" id="descontinuado">
    <div class="error">
      <div class="well">
        <h3 class="page-header"><i class="fa fa-exclamation-circle"></i> Funções Descontinuadas:</h3>
        <ul>
          <li>
              <?php echo $this->Html->link('<i class="fa fa-home fa-fw"></i> Workspace',
                                      Router::url('/', true) . "workspace_old", array('escape' => false)); ?>
          </li>
          <li><!-- Calendário -->
              <a href="#"><i class="fa fa-calendar fa-fw"></i> Calendários <span class="fa arrow"></span></a>
              <ul>
                <li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Previsões de Término", '/calendarios/show/1155', array('escape' => false)); ?></li>
              </ul>
          </li>
          <li> <!-- Negócio -->
              <a href="#"><i class="fa fa-briefcase fa-fw"></i> Negócio <span class="fa arrow"></span></a>
              <ul>
                <li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> SS", '/sses', array('escape' => false)); ?></li>
                <li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> PA", '/pes', array('escape' => false)); ?></li>
                <li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> OS", '/ords', array('escape' => false)); ?></li>
              </ul>
          </li>
          <li> <!-- Relatórios -->
              <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Relatórios <span class="fa arrow"></span></a>
              <ul>
                <li>
                  <a href="#"><i class='fa fa-angle-double-right'></i> Ss <span class="fa arrow"></span></a>
                  <ul class="nav nav-third-level collapse">
                    <li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Gestão de Ideias", '/relatorios/gsses', array('escape' => false)); ?></li>
                  </ul>
                </li>
                <li>
                  <li>
                    <a href="#"><i class='fa fa-angle-double-right'></i> Contrato <span class="fa arrow"></span></a>
                    <ul class="nav nav-third-level collapse">
                      <li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Consumo", '/relatorios/contratos', array('escape' => false)); ?></li>
                      <!--li><?php //echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Serviços (Em Breve)", '/relatorios/servicos', array('escape' => false)); ?></li -->
                    </ul>
                  </li>
                </li>
              </ul>
          </li>
          <li> <!-- Base de Conhecimenton -->
              <a href="#"><i class="fa fa-institution fa-fw"></i> Base de Conhecimento <span class="fa arrow"></span></a>
              <ul>
                <li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Sistemas Internos", '/internos', array('escape' => false)); ?></li>
                <li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Procedimentos", '/procedimentos', array('escape' => false)); ?></li>
                <li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Mapeamento DTP", '/responsabilidades', array('escape' => false)); ?></li>
              </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<script>
  $('#abas a').click(function (e) {
    e.preventDefault()
    $(this).tab('show')
  })
</script>
