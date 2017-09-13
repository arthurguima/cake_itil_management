<?php
  $this->Html->addCrumb('Chamados', '');
  $this->Html->addCrumb($chamado['Chamado']['numero'] . "/" . $chamado['Chamado']['ano'], array('controller' => 'chamados', $chamado['Chamado']['id']));
?>
<div class="col-lg-12 page-header-box">
  <div class="col-lg-12"><h3 class="page-header">Chamado: <?php echo $chamado['Chamado']['numero'] . "/" . $chamado['Chamado']['ano']; ?></h3></div>
</div>

<div class="row">
  <div class="col-lg-4">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">
            <b>Informações</b>
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-edit pull-right'></i>",
                  array('controller' => 'chamados', 'action' => 'edit', $chamado['Chamado']['id'], '?' => array('controller' => 'chamados', 'id' =>  $chamado['Chamado']['id'], 'action' => 'view' )),
                  array('escape' => false));
              }
            ?>
          </h3>
        </p>
      </div>
      <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
          <li><a><b>Nome: </b><?php echo $chamado['Chamado']['nome']; ?></a></li>
          <li><a><b>Número: </b><?php echo $chamado['Chamado']['numero'] . "/". $chamado['Chamado']['ano']; ?></a></li>
          <li><a><b>Tipo: </b><?php echo $chamado['ChamadoTipo']['nome']; ?></a></li>
          <li><a><b>Status: </b><?php echo $chamado['Status']['nome']; ?></a></li>
          <li>
            <a><b>Previsão de Atendimento: </b>
            <?php echo $this->Times->timeLeftTo($chamado['Chamado']['created'], $chamado['Chamado']['dt_prev_resolv'],
                $chamado['Chamado']['created'] . " - " . $chamado['Chamado']['dt_prev_resolv'], $chamado['Chamado']['dt_resolv']);
            ?>
            </a>
          </li>
          <li><a><b>Responsável: </b><?php echo $chamado['User']['nome']; ?></a></li>
          <li><a><b>Serviço: </b><?php echo $chamado['Servico']['nome']; ?></a></li>
          <li><a><b>Aberto?: </b><?php echo $this->Times->yesOrNo($chamado['Chamado']['aberto'])?></a></li>
          <li><a><b>Pai?: </b><?php echo $this->Times->yesOrNo($chamado['Chamado']['pai'])?></a></li>
          <?php if(isset($chamado['Demanda']['id'])): ?>
              <li>
                <a href=<?php echo Router::url('/', true) . 'demandas/view/' . $chamado['Demanda']['id']; ?>>
                <b>Demanda: </b><?php echo $chamado['Demanda']['nome'] . " <i class='fa-external-link-square fa' style='font-size: 15px !important;'></i>" ; ?></a>
              </li>
          <?php endif; ?>
          <li><a><b>Observação: </b><?php echo $chamado['Chamado']['observacao']; ?></a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="panel panel-default panel-default">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Rdms
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
              <?php foreach($chamado['Rdm'] as $rdm): ?>
                <tr>
                  <td><?php echo $rdm['nome']; ?></td>
                  <td>  <?php
                      echo $this->Html->link($rdm['numero'],
                            "http://www-sdm14/CAisd/pdmweb.exe?OP=SEARCH+SKIPLIST=1+FACTORY=chg+QBE.EQ.chg_ref_num=" . $rdm['numero'],
                            array('target' => '_blank'));
                    ?>
                  </td>
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

  <div class="col-lg-8">
    <div class="panel panel-danger">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Histórico</b>
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                array('controller' => 'historicos', 'action' => 'add','?' => array('controller' => 'chamados', 'id' =>  $chamado['Chamado']['id'], 'action' => 'view' )),
                array('escape' => false));
              }
            ?>
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.historico-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
          </h3>
        </p>
      </div>
      <div class="panel-body historico-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-contrato">
            <thead>
              <tr>
                <th>Data</th>
                <th>Descrição</th>
                <th>Analista</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($chamado['Historico'] as $hist): ?>
                  <tr>
                    <td><?php echo $hist['data']; ?></td>
                    <td><?php echo $this->Historicos->findLinks($hist['descricao']); ?></td>
                    <td><div class="small sub-17"><?php echo $hist['analista']; ?></div></td>
                    <td>
                       <?php
                        if($this->Ldap->autorizado(2)){

                          echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                array('controller' => 'historicos', 'action' => 'edit', $hist['id'], '?' => array('controller' => 'chamados', 'id' =>  $chamado['Chamado']['id'], 'action' => 'view' )),
                                array('escape' => false));
                          echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                array('controller' => 'historicos', 'action' => 'delete', $hist['id'], '?' => array('controller' => 'chamados', 'id' => $chamado['Chamado']['id'], 'action' => 'view' )),
                                array('escape' => false), "O registro será excluído, você tem certeza dessa ação?");
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

  <div class="col-lg-8 pull-right">
    <div class="panel panel-purple">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Tarefas</b>
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                array('controller' => 'subtarefas', 'action' => 'add','?' => array('servico' => $chamado['Servico']['id'], 'controller' => 'chamados', 'id' =>  $chamado['Chamado']['id'], 'action' => 'view' )),
                array('escape' => false));
              }

              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-th-large pull-right'></i>",
                array('controller' => 'grupotarefas', 'action' => 'assign','?' => array('tipo' => 4, 'attribute' => 'chamado_id', 'servico' => $chamado['Servico']['id'], 'controller' => 'chamados', 'id' =>  $chamado['Chamado']['id'], 'action' => 'view' )),
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
              <?php foreach($chamado['Subtarefa'] as $sub): ?>
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
                    <td><div class="small sub-17"><?php echo $sub['User']['nome']; ?></div></td>
                    <td id="<?php echo "sub-" . $sub['id']?>">
                      <?php
                        echo $this->Subtarefas->status($sub['check']);
                      ?>
                    </td>
                    <?php
                      echo $this->Tables->SubtarefaStatusEditable($sub['id'], "subtarefas");
                    ?>
                    <td><?php echo $sub['marcador']; ?></td>
                    <td>
                       <?php
                         if($this->Ldap->autorizado(2)){
                            echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                  array('controller' => 'subtarefas', 'action' => 'edit', $sub['id'], '?' => array('controller' => 'chamados', 'id' =>  $chamado['Chamado']['id'], 'action' => 'view' )),
                                  array('escape' => false));
                            echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                  array('controller' => 'subtarefas', 'action' => 'delete', $sub['id'], '?' => array('controller' => 'chamados', 'id' => $chamado['Chamado']['id'], 'action' => 'view' )),
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

  <div class="col-md-12">
    <?php
    echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-2'));
    echo $this->Html->script('getSDMInfoChamados.js');
    ?>
  </div>

</div>

<?php
  //-- DataTables JavaScript
  echo $this->Html->script('plugins/dataTables/media/js/jquery.dataTables.js');
  echo $this->Html->script('plugins/dataTables/dataTables.bootstrap.js');
  echo $this->Html->css('plugins/dataTables.bootstrap.css');
    //-- DataTables --> TableTools
    echo $this->Html->script('plugins/dataTables/extensions/TableTools/js/dataTables.tableTools.min.js');
    echo $this->Html->css('plugins/dataTablesExtensions/TableTools/css/dataTables.tableTools.min.css');
    //-- DataTables --> Responsive
    echo $this->Html->script('plugins/dataTables/extensions/Responsive/js/dataTables.responsive.min.js');
    echo $this->Html->css('plugins/dataTablesExtensions/Responsive/css/dataTables.responsive.css');
    //-- DataTables --> ColVis
      echo $this->Html->script('plugins/dataTables/extensions/ColVis/js/dataTables.colVis.min.js');
      echo $this->Html->css('plugins/dataTablesExtensions/ColVis/css/dataTables.colVis.min.css');
      echo $this->Html->css('plugins/dataTablesExtensions/ColVis/css/dataTables.colvis.jqueryui.css');

  //-- Jeditable
  echo $this->Html->script('plugins/jeditable/jquery.jeditable.js');
?>

<script>
  $(document).ready(function() {

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
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF",
                    "sFileName": "Tarefas.pdf",
                    "sPdfOrientation": "landscape",
                    "sTitle": "Tarefas do Chamado: "  + <?php echo "'" .$chamado['Chamado']['numero'] . "'"; ?>,
                    "sPdfMessage": "Extraído em: <?php echo date('d/m/y')?>",
                    "mColumns":  "visible"
                },
              ]
          }
      });
  });
</script>
