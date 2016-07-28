<?php
  $this->Html->addCrumb("Sobre o SGD", '/pages/about');
?>

<style>
  .nav.nav-tabs-pages>li.active>a{
      background-color: #eee !important;
  }
</style>
<?php echo $this->Html->css('plugins/timeline.css'); ?>

<!-- Nav tabs -->
<ul class="nav nav-tabs nav-tabs-black nav-tabs-pages" role="tablist">
  <li role="presentation" class="active"><a href="#dev" aria-controls="dev" role="tab" data-toggle="tab">Desenvolvimento</a></li>
  <li role="presentation"><a href="#versoes" aria-controls="versoes" role="tab" data-toggle="tab">Versões</a></li>
</ul>

<div class="tab-content">
  <div role="tabpanel" class="tab-pane active" id="dev">
    <div class="error">
      <div class="well">
        <h3 class="page-header"><i class="fa fa-rocket"></i> Desenvolvido por:</h3>
        <br />
        <div class="well">
          <ul class="list-unstyled spaced">
            <li>
              <h4> <i class="ace-icon fa fa-hand-o-right"></i> Arthur Henrique Guimarães de Oliveira</h4>
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
              <h5> <i class="ace-icon fa fa-hand-o-right"></i> CakePhp</h5>
              <h5> <i class="ace-icon fa fa-hand-o-right"></i> Bootstrap 3</h5>
              <h5> <i class="ace-icon fa fa-hand-o-right"></i> SBAdmin</h5>
              <h5> <i class="ace-icon fa fa-hand-o-right"></i> Jquery</h5>
              <h5> <i class="ace-icon fa fa-hand-o-right"></i> DataTables</h5>
              <h5> <i class="ace-icon fa fa-hand-o-right"></i> Circliful</h5>
              <h5> <i class="ace-icon fa fa-hand-o-right"></i> CanvasJs</h5>
              <h5> <i class="ace-icon fa fa-hand-o-right"></i> Fulcalendar</h5>
              <h5> <i class="ace-icon fa fa-hand-o-right"></i> Jeditable</h5>
              <h5> <i class="ace-icon fa fa-hand-o-right"></i> TinyMce</h5>
              <h5> <i class="ace-icon fa fa-hand-o-right"></i> Vis</h5>
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
            <div class="timeline-badge warning">
              <i class="fa fa-wrench fa-fw"></i>
            </div>
            <div class="timeline-panel">
              <ul class="list-unstyled spaced">
                <li>
                  <h4 class="page-header"> <i class="ace-icon fa fa-hand-o-right"></i> Versão 2.6</h4>
                    <div class="personal-info">
                      Veja o que mudou:<br/><br/>
                      <ul>
                        <li>Removido Menu Gerencial</li>
                        <li>Demanads Internas Com a gestão de serviço</li>
                        <li>Controle de aprovação pelo CAB nas RDMs</li>
                        <li>Script de Carga automática de RDMs</li>
                        <li>Fim das Demandas internas -> Demandas</li>
                      </ul>
                    </div>
                </li>
              </ul>
            </div>
          </li>
          <li>
          <li>
            <div class="timeline-panel">
              <ul class="list-unstyled spaced">
                <li>
                  <h4 class="page-header"> <i class="ace-icon fa fa-hand-o-right"></i> Versão 2.5 - SGS</h4>
                    <div class="personal-info">
                      Veja o que mudou:<br/><br/>
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
                  <h4 class="page-header"> <i class="ace-icon fa fa-hand-o-right"></i> Versão 2.1</h4>
                    <div class="personal-info">
                      Veja o que mudou:<br/><br/>
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
                  <h4 class="page-header"> <i class="ace-icon fa fa-hand-o-right"></i> Versão 2.0</h4>
                    <div class="personal-info">
                      Veja o que mudou:<br/><br/>
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
              <i class="fa fa-eyedropper fa-fw"></i>
            </div>
            <div class="timeline-panel">
              <ul class="list-unstyled spaced">
                <li>
                  <h4 class="page-header"> <i class="ace-icon fa fa-hand-o-right"></i> Versão 1.9.X</h4>
                    <div class="personal-info">
                      Veja o que mudou:<br/><br/>
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
                  <h4 class="page-header"> <i class="ace-icon fa fa-hand-o-right"></i> Versão 1.8.8</h4>
                    <div class="personal-info">
                      Veja o que mudou:<br/><br/>
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
                  <h4 class="page-header"> <i class="ace-icon fa fa-hand-o-right"></i> Versão 1.6</h4>
                    <div class="personal-info">
                      Veja o que mudou:<br/><br/>
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
                  <h4 class="page-header"> <i class="ace-icon fa fa-hand-o-right"></i> Versão 1.5</h4>
                    <div class="personal-info">
                      Veja o que mudou:<br/><br/>
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
                  <h4 class="page-header"> <i class="ace-icon fa fa-hand-o-right"></i> Versão 1.4.2</h4>
                    <div class="personal-info">
                      Veja o que mudou:<br/><br/>
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
                  <h4 class="page-header"> <i class="ace-icon fa fa-hand-o-right"></i> Versão 1.4</h4>
                    <div class="personal-info">
                      Veja o que mudou:<br/><br/>
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
                  <h4 class="page-header"> <i class="ace-icon fa fa-hand-o-right"></i> Versão 1.0 -  SGD</h4>
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
</div>

<script>
  $('#abas a').click(function (e) {
    e.preventDefault()
    $(this).tab('show')
  })
</script>
