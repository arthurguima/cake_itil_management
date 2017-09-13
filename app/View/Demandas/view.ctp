<?php
  $this->Html->addCrumb('Demandas', '/demandas');
  $this->Html->addCrumb($demanda['Demanda']['clarity_dm_id'], array('controller' => 'demandas', 'action' => 'view', $demanda['Demanda']['id']));
?>
<div class="col-lg-12 page-header-box">
  <div class="col-lg-12"><h3 class="page-header">Demanda: <?php echo $demanda['Demanda']['clarity_dm_id'] ." - " . $demanda['Servico']['sigla'] ?></h3></div>
</div>

<div class="row">
  <div class="col-lg-5">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Informações Gerais</b>
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-edit pull-right'></i>",
                  array('controller' => 'demandas', 'action' => 'edit', $demanda['Demanda']['id']),
                  array('escape' => false));
              }
            ?>
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.info-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
          </h3>
        </p>
      </div>
      <div class="panel-body info-body">
        <ul class="nav nav-pills nav-stacked">
          <li><a><b>Nome: </b><?php echo $demanda['Demanda']['nome']; ?></a></li>
          <li>
            <?php echo "<a id='viewClarity' data-toggle='modal' data-target='#myModal' onclick='javascript:indexClarity(" .
                     $demanda['Demanda']['clarity_id'] .")'><b>Clarity DM: </b>" . $demanda['Demanda']['clarity_dm_id']  .
                     "<i class='fa-expand fa' style='cursor:pointer; float:right;' title='Clique aqui para testar a integração da demanda com o sistema Clarity!'></i></a></span>" ?>
          </li>
          <li><a><b>Mantis: </b><?php echo $demanda['Demanda']['mantis_id']; ?></a></li>
          <li>
            <a>
              <b>Prazo: </b>
              <?php echo $this->Times->timeLeftTo($demanda['Demanda']['data_cadastro'], $demanda['Demanda']['dt_prevista'],
                      $demanda['Demanda']['data_cadastro'] . " - " .  $demanda['Demanda']['dt_prevista'],
                      ($demanda['Demanda']['data_homologacao']));
              ?>
            </a>
          </li>
          <li>
            <a><b>Data Prevista: </b>
              <?php
                  if($demanda['Demanda']['dt_prevista'] != null){
                    echo $this->Times->pastdate($demanda['Demanda']['dt_prevista']);
                  }
              ?>
            </a>
          </li>
          <li>
            <a>
              <b>Data de homologação: </b>
              <?php
                if ($demanda['Demanda']['data_homologacao'] != null):
                  echo $this->Times->pastdate($demanda['Demanda']['data_homologacao']);
                endif;
              ?>
            </a>
          </li>
          <li><a><b>Serviço: </b> <?php echo $demanda['Servico']['sigla']; ?></a></li>
          <?php if(isset($demanda['DemandaPai']['id'])): ?>
              <li>
                <a href=<?php echo Router::url('/', true) . 'demandas/view/' . $demanda['DemandaPai']['id']; ?>>
                <b>Demanda Pai: </b><?php echo $demanda['DemandaPai']['nome'] . " <i class='fa-external-link-square fa' style='font-size: 15px !important;'></i>" ; ?></a>
              </li>
          <?php endif; ?>
          <li><a><b>Tipo: </b><?php echo $demanda['DemandaTipo']['nome']; ?></a></li>
          <li><a><b>Responsável: </b><?php echo $demanda['User']['nome']; ?></a></li>
          <li><a><b>Solicitada pelo Cliente: </b><?php echo $this->Times->yesOrNo($demanda['Demanda']['origem_cliente']); ?></a></li>
          <li><a><b>Executor: </b><?php echo $demanda['Demanda']['executor']; ?></a></li>

          <?php if(isset($demanda['Ss'][0])):
            foreach($demanda['Ss'] as $ss): ?>
              <li>
                <a href=<?php echo Router::url('/', true) . 'sses/view/' . $ss['id']; ?>>
                <b>SS: </b><?php echo $ss['nome'] . " <i class='fa-external-link-square fa' style='font-size: 15px !important;'></i>" ; ?></a>
              </li>
          <?php endforeach; endif; ?>

          <li><a><b>Descrição: </b><?php echo $demanda['Demanda']['descricao']; ?></a></li>
          <li><a><b>Status: </b><?php echo $demanda['Status']['nome']; ?></a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="panel panel-warning">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Demandas Filhas</b>
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                array('controller' => 'demandas', 'action' => 'add','?' => array('controller' => 'demandas', 'servico' => $demanda['Demanda']['servico_id'], 'pai' => $demanda['Demanda']['id'],'id' =>  $demanda['Demanda']['id'], 'action' => 'view' )),
                array('escape' => false));
              }
            ?>
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.demandafilha-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
          </h3>
        </p>
      </div>
      <div class="panel-body demandafilha-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-contrato">
            <thead>
              <tr>
                <th>Serviço</th>
                <th>Tipo</th>
                <th>Nome <i class="fa fa-comment-o" style="font-size: 15px !important;"></i></th>
                <th>DM Clarity <i class='fa-expand fa' style="font-size: 15px !important;"></i></th>
                <th>Prazo</th>
                <th><span class="editable">Status</span></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php  foreach($demanda['DemandaFilha'] as $dem): ?>
                <tr>
                  <td><?php echo($dem['Servico']['nome']); ?></td>
                  <td><?php echo($dem['DemandaTipo']['nome']); ?></td>
                  <td><?php echo $this->Tables->popupBox($dem['nome'], $dem['descricao']) ?></td>
                  <td style="cursor:pointer;" title="Clique para abrir a demanda no Clarity!">
                      <?php echo "<a id='viewClarity' data-toggle='modal' data-target='#myModal' onclick='javascript:indexClarity(" .
                                 $dem['clarity_id'] .")'>" . $dem['clarity_dm_id'] ."</a></span>" ?>
                  </td>
                  <td>
                    <?php echo $this->Times->timeLeftTo($dem['data_cadastro'], $dem['dt_prevista'],
                           $dem['data_cadastro'] . " - " . $dem['dt_prevista'],
                          ($dem['data_homologacao']));
                    ?>
                  </td>
                  <td>
                    <span style="cursor:pointer;" title="Clique para alterar o status!" id="<?php echo "status-" . $dem['id'] ?>"><?php echo $dem['Status']['nome']; ?></span>
                  </td>
                  <?php echo $this->Tables->DemandaStatusEditable($dem['id'], "demandas") ?>
                  <td><?php echo $this->Tables->getMenu('demandas', $dem['id'], 6); ?></td>
                </tr>
              <?php endforeach; ?>
            <?php unset($area); ?>
          </tbody>
        </table>
      </div>
      </div>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="panel panel-info">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Chamados</b>
            <?php
              if($this->Ldap->autorizado(2)){
               echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                array('controller' => 'chamados', 'action' => 'add','?' => array('controller' => 'demandas', 'id' =>  $demanda['Demanda']['id'], 'action' => 'view',
                                                                                 'servico' => $demanda['Demanda']['servico_id'] )),
                array('escape' => false));
              }
            ?>
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.chamados-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
          </h3>
        </p>
      </div>
      <div class="panel-body chamados-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-contrato">
            <thead>
              <tr>
                <th>Número</th>
                <th>Nome</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($demanda['Chamado'] as $chamado): ?>
                  <tr>
                    <td><?php echo $chamado['numero']; ?></td>
                    <td><?php echo $chamado['nome']; ?></td>
                    <td>
                       <?php
                          echo $this->Html->link("<i class='fa fa-search-plus'></i>",
                             array('controller' => 'chamados', 'action' => 'view', $chamado['id'], '?' => array('controller' => 'demandas', 'id' =>  $demanda['Demanda']['id'], 'action' => 'view' )),
                             array('escape' => false));
                        if($this->Ldap->autorizado(2)){
                          echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                array('controller' => 'chamados', 'action' => 'edit', $chamado['id'], '?' => array('controller' => 'demandas', 'id' =>  $demanda['Demanda']['id'], 'action' => 'view' )),
                                array('escape' => false));
                          echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                array('controller' => 'chamados', 'action' => 'delete', $chamado['id'], '?' => array('controller' => 'demandas', 'id' => $demanda['Demanda']['id'], 'action' => 'view' )),
                                array('escape' => false), "O registro será excluído, você tem certeza dessa ação?");
                        }
                       ?>
                     </td>
                  </tr>
                <?php endforeach; ?>
              <?php unset($chamado); ?>
          </tbody>
        </table>
      </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3">
    <div class="panel panel-success">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Clarity (Web Service)</b>
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.clarity-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
          </h3>
        </p>
      </div>
      <div class="panel-body clarity-body">
        <ul id="clarity">
          <div class="col-md-6 col-md-offset-4 load"><?php echo $this->Html->image('loading.gif', array('alt' => 'Carregando', 'width' => '30%')); ?></div>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="panel panel-default panel-default">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Rdms</b>
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.rdm-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
          </h3>
        </p>
      </div>
      <div class="panel-body rdm-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-demandas">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Número</th>
                <th>Concluída?</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($demanda['Rdm'] as $rdm): ?>
                <tr>
                  <td><?php echo $rdm['nome']; ?></td>
                  <td><?php echo $rdm['numero']; ?></td>
                  <td><?php echo $this->Rdm->sucesso($rdm['sucesso'], $rdm['dt_executada']); ?></a></td>
                  <td><?php echo $this->Tables->getMenu('rdms', $rdm['id'], 6); ?></td>
                </tr>
              <?php endforeach; ?>
            <?php unset($rdm); ?>
          </tbody>
        </table>
      </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-6 pull-right">
    <div class="panel panel-purple">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Tarefas</b>
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                array('controller' => 'subtarefas', 'action' => 'add','?' => array('servico' => $demanda['Servico']['id'], 'controller' => 'demandas', 'id' =>  $demanda['Demanda']['id'], 'action' => 'view' )),
                array('escape' => false));
              }

              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-th-large pull-right'></i>",
                array('controller' => 'grupotarefas', 'action' => 'assign','?' => array('tipo' => 1, 'attribute' => 'demanda_id', 'servico' => $demanda['Servico']['id'], 'controller' => 'demandas', 'id' =>  $demanda['Demanda']['id'], 'action' => 'view' )),
                array('escape' => false));
              }
            ?>
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.subtarefa-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
            <?php
              echo $this->Tables->popupBox2(
                "<h4>Como funcionam as Tarefas?</h4>",
                "<ul>
                  <li>Lista as tarefas relacionadas a essa atividade sob a sua responsabilidade.</li>
                  <li>As tarefas estão sempre associadas ao usuário definido e um sistema.</li>
                  <li>Elas também podem ser associadas as Demandas, RDMs, Chamados e Releases.</li>
                  <li>Caso não exista uma <b>Data Prevista de Início</b> o sistema considera a <b>Data de criação da Tarefa</b>.</li>
                  <li>Caso não exista uma <b>Data de Finalização</b> o sistema considera a <b>Data Prevista de Fim</b>.</li>
                  <li>Existem apenas 3 status para as Demandas: Aguardando Início, Em andamento, Finalizada.</li>
                  <li>
                    <b>Grupos de tarefas</b>
                    <ul>
                      <li>Os grupos são criados no Menu Admin > Grupos de Tarefas.</li>
                      <li>São um conjunto de atividades pré-definidas que visam facilitar a gestão sobre uma atividade.</li>
                      <li>Você poderá adicionar tarefas apenas dos grupos definidos para a atividade atual (Chamados, Releases, Rdms, Demandas, etc).</li>
                      <li>Você pode alterar as datas, o responsável ou qualquer outro atributo da tarefas assim como faria com qualquer tarefa criada por você.</li>
                    </ul>
                  </li>
                </ul>", "10");
            ?>
          </h3>
        </p>
      </div>
      <div class="panel-body subtarefa-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-tarefas">
            <thead>
              <tr>
                <th>Data de Início</th>
                <th>Data de Finalização</th>
                <th>Data prevista</th>
                <th>Tarefa</th>
                <th>Responsável</th>
                <th><span class="editable">Status</span></th>
                <th>Marcador</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($demanda['Subtarefa'] as $sub): ?>
                  <tr>
                    <td>
                      <?php  echo ($sub['dt_inicio'] == null) ? str_replace('-', '/', date("d-m-Y", strtotime($sub['created']))) :  $sub['dt_inicio']; ?>
                    </td>
                    <td>
                      <?php
                        if ( ($sub['dt_fim'] == null && $sub['check'] != 1))
                          echo "Previsão: " . $sub['dt_prevista'];
                        else {
                          if($sub['dt_fim'] == null && $sub['check'] == 1)
                            echo $sub['dt_prevista'];
                          else {
                            echo $sub['dt_fim'];
                          }
                        }
                      ?>
                    </td>
                    <td class="text-center">
                      <?php
                        echo $this->Subtarefas->timeLeftTo($sub['created'], $sub['dt_prevista'], $sub['check'], $sub['dt_inicio'], $sub['dt_fim']);
                      ?>
                    </td>
                    <td><?php echo $sub['descricao']; ?></td>
                    <td><div class="sub-17 small"><?php echo $sub['User']['nome']; ?></div></td>
                    <td id="<?php echo "sub-" . $sub['id']?>">
                      <?php
                        echo $this->Subtarefas->status($sub['check']);
                      ?>
                    </td>
                    <?php
                      echo $this->Tables->SubtarefaStatusEditable($sub['id'], "subtarefas");
                    ?>
                    <td class="small"><?php echo $sub['marcador']; ?></td>
                    <td>
                       <?php
                         if($this->Ldap->autorizado(2)){
                            echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                  array('controller' => 'subtarefas', 'action' => 'edit', $sub['id'], '?' => array('controller' => 'demandas', 'id' =>  $demanda['Demanda']['id'], 'action' => 'view' )),
                                  array('escape' => false));
                            echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                  array('controller' => 'subtarefas', 'action' => 'delete', $sub['id'], '?' => array('controller' => 'demandas', 'id' => $demanda['Demanda']['id'], 'action' => 'view' )),
                                  array('escape' => false), "Você tem certeza");
                         }
                       ?>
                     </td>
                  </tr>
                <?php endforeach; ?>
              <?php unset($sub); ?>
          </tbody>
        </table>
      </div>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="panel panel-danger">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Histórico</b>
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                array('controller' => 'historicos', 'action' => 'add','?' => array('controller' => 'demandas', 'id' =>  $demanda['Demanda']['id'], 'action' => 'view' )),
                array('escape' => false));
              }
            ?>
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.historico-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
          </h3>
        </p>
      </div>
      <div class="panel-body historico-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables">
            <thead>
              <tr>
                <th>Data</th>
                <th>Descrição</th>
                <th>Analista</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($demanda['Historico'] as $hist): ?>
                  <tr>
                    <td><div class="small"><?php echo $hist['data']; ?></div></td>
                    <td><?php echo $this->Historicos->findLinks($hist['descricao']); ?></td>
                    <td><div class="small sub-17"><?php echo $hist['analista']; ?></div></td>
                    <td>
                       <?php
                         if($this->Ldap->autorizado(2)){
                            echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                  array('controller' => 'historicos', 'action' => 'edit', $hist['id'], '?' => array('controller' => 'demandas', 'id' =>  $demanda['Demanda']['id'], 'action' => 'view' )),
                                  array('escape' => false));
                            echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                  array('controller' => 'historicos', 'action' => 'delete', $hist['id'], '?' => array('controller' => 'demandas', 'id' => $demanda['Demanda']['id'], 'action' => 'view' )),
                                  array('escape' => false), "Você tem certeza");
                         }
                       ?>
                     </td>
                  </tr>
                <?php endforeach; ?>
              <?php unset($hist); ?>
          </tbody>
        </table>
      </div>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <?php echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-2')); ?>
  </div>
</div>




<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body" id="modal-body">
      </div>
    </div>
  </div>
</div>
<iframe id="demandaFrame" style="display:none;" name='demanda' width='100%' height='720px' frameborder='0'></iframe>


<?php
  //-- ClarityID
  echo $this->Html->script('getIdClarity.js');

  //-- ClarityInfo
  echo $this->Html->script('getClarityInfo.js');

  //-- Jeditable
  echo $this->Html->script('plugins/jeditable/jquery.jeditable.js');

  //-- DataTables JavaScript -->
    echo $this->Html->script('plugins/dataTables/media/js/jquery.dataTables.js');
    echo $this->Html->script('plugins/dataTables/dataTables.bootstrap.js');
    echo $this->Html->css('plugins/dataTables.bootstrap.css');

    //-- DataTables --> TableTools
  echo $this->Html->script('plugins/dataTables/extensions/TableTools/js/dataTables.tableTools.min.js');
  echo $this->Html->css('plugins/dataTablesExtensions/TableTools/css/dataTables.tableTools.min.css');

  //-- DataTables --> ColVis
    echo $this->Html->script('plugins/dataTables/extensions/ColVis/js/dataTables.colVis.min.js');
    echo $this->Html->css('plugins/dataTablesExtensions/ColVis/css/dataTables.colVis.min.css');
    echo $this->Html->css('plugins/dataTablesExtensions/ColVis/css/dataTables.colvis.jqueryui.css');
?>

<script>
  $(document).ready(function() {
    $('#myModal').on('shown.bs.modal', function (e) {
      document.getElementById('modal-body').appendChild(
          document.getElementById('demandaFrame')
      );
      document.getElementById('demandaFrame').style.display = "block";
      //document.getElementById('demandaFrame').style.height = "720px";
    });

    getClarityInfoOnView('<?php echo $demanda['Demanda']['clarity_dm_id']?>', 'demandas');

    $('[data-toggle="popover2"]').popover({trigger: 'hover','placement': 'left', html: 'true'});

    $('#dataTables-tarefas').dataTable({
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
          language: {
            url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
          },
          "columnDefs": [  { "visible": false, "targets": [0, 1] } ],
          "dom": 'TC<"clear">lfrtip',
          "colVis": {
            "buttonText": "Esconder Colunas"
          },
          "tableTools": {
              "sSwfPath": "<?php echo Router::url('/', true);?>/js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
              "aButtons": [
                {
                    "sExtends": "copy",
                    "sButtonText": "Copiar",
                    //"mColumns": [ 0,1,2,3,4 ]
                    "mColumns":  "visible"
                },
                {
                    "sExtends": "print",
                    "sButtonText": "Imprimir"
                },
                {
                    "sExtends": "csv",
                    "sButtonText": "CSV",
                    "sFileName": "Tarefas.csv",
                    "mColumns":  "visible"
                    //"mColumns": [ 0,1,2,3,4 ]
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF",
                    "sFileName": "Tarefas.pdf",
                    "sPdfOrientation": "landscape",
                    "sTitle": "Tarefas da Demanda: "  + <?php echo "'" .$demanda['Demanda']['clarity_dm_id'] . "'"; ?>,
                    "sPdfMessage": "Extraído em: <?php echo date('d/m/y')?>",
                    "mColumns":  "visible"//[ 0,1,2,3,4 ]
                },
              ]
          }
      });
  });
</script>
