<?php
  $this->Html->addCrumb('Releases', '/releases');
  $this->Html->addCrumb("Visualizar","");
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header"><?php echo $release['Servico']['sigla'] . ": " . $release['Release']['versao']; ?></h3></div>
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
                  array('controller' => 'releases', 'action' => 'edit', $release['Release']['id'], '?' => array('controller' => 'releases', 'id' =>  $release['Release']['id'], 'action' => 'view' )),
                  array('escape' => false));
              }
            ?>
          </h3>
        </p>
      </div>
      <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
          <li><a><b>Servico: </b><?php echo $release['Servico']['sigla']; ?></a></li>
          <li>
            <a><b>Data de Início Prevista: </b>
              <?php
                  if($release['Release']['dt_ini_prevista'] != null){
                    echo $this->Times->pastdate($release['Release']['dt_ini_prevista']);
                  }
              ?>
            </a>
          </li>
          <li>
            <a>
              <b>Prazo: </b>
              <?php echo $this->Times->timeLeftTo($release['Release']['dt_ini_prevista'], $release['Release']['dt_fim_prevista'],
                      $release['Release']['dt_ini_prevista'] . " - " .  $release['Release']['dt_fim_prevista'],
                      ($release['Release']['dt_fim']));
              ?>
            </a>
          </li>
          <li>
            <?php
              echo $this->Html->link("<b>Rdm: </b>" . $release['Rdm']['numero'],
              array('controller' => 'rdms', 'action' => 'view', $release['Rdm']['id'] ,'?' => array('controller' => 'releases', 'id' =>  $release['Release']['id'], 'action' => 'view' )),
              array('escape' => false));
            ?>
          </li>
          <li><a><b>Data da RDM: </b><?php echo $release['Rdm']['dt_executada']; ?></a></li>
          <li><a><b>Versão: </b><?php echo $release['Release']['versao']; ?></a></li>
          <li><a><b>Observação: </b><?php echo $release['Release']['observacao']; ?></a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="panel panel-default panel-default">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Notas</b>
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                array('controller' => 'notes', 'action' => 'add','?' => array('controller' => 'releases', 'id' => $release['Release']['id'], 'action' => 'view' )),
                array('escape' => false));
              }
            ?>
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.note-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
          </h3>
        </p>
      </div>
      <div class="panel-body note-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-demandas">
            <thead>
              <tr>
                <th>Nome</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($release['Note'] as $note): ?>
                <tr>
                  <td><?php echo $note['valor']; ?></td>
                  <td><?php echo $this->Tables->getMenu('notes', $note['id'], 6); ?></td>
                </tr>
              <?php endforeach; ?>
            <?php unset($note); ?>
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
                array('controller' => 'subtarefas', 'action' => 'add','?' => array('servico' => $release['Servico']['id'], 'controller' => 'releases', 'id' =>  $release['Release']['id'], 'action' => 'view' )),
                array('escape' => false));
              }

              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-th-large pull-right'></i>",
                array('controller' => 'grupotarefas', 'action' => 'assign','?' => array('tipo' => 6, 'attribute' => 'release_id', 'servico' => $release['Servico']['id'], 'controller' => 'releases', 'id' =>  $release['Release']['id'], 'action' => 'view' )),
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
                <th>Data prevista</th>
                <th>Tarefa</th>
                <th>Responsável</th>
                <th><span class="editable">Status</span></th>
                <th>Marcador</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($release['Subtarefa'] as $sub): ?>
                  <tr>
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
                                  array('controller' => 'subtarefas', 'action' => 'edit', $sub['id'], '?' => array('controller' => 'releases', 'id' =>  $release['Release']['id'], 'action' => 'view' )),
                                  array('escape' => false));
                            echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                  array('controller' => 'subtarefas', 'action' => 'delete', $sub['id'], '?' => array('controller' => 'releases', 'id' => $release['Release']['id'], 'action' => 'view' )),
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

  <div class="col-lg-12">
    <div class="panel panel-danger">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Histórico</b>
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                array('controller' => 'historicos', 'action' => 'add','?' => array('controller' => 'releases', 'id' =>  $release['Release']['id'], 'action' => 'view' )),
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
              <?php foreach($release['Historico'] as $hist): ?>
                  <tr>
                    <td><div class="small"><?php echo $hist['data']; ?></div></td>
                    <td><?php echo $this->Historicos->findLinks($hist['descricao']); ?></td>
                    <td><div class="small sub-17"><?php echo $hist['analista']; ?></div></td>
                    <td>
                       <?php
                         if($this->Ldap->autorizado(2)){
                            echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                  array('controller' => 'historicos', 'action' => 'edit', $hist['id'], '?' => array('controller' => 'demandas', 'id' =>   $release['Release']['id'], 'action' => 'view' )),
                                  array('escape' => false));
                            echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                  array('controller' => 'historicos', 'action' => 'delete', $hist['id'], '?' => array('controller' => 'demandas', 'id' =>  $release['Release']['id'], 'action' => 'view' )),
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

  <div class="col-lg-12 panel panel-default">
    <div class="panel-heading">
      <b>
        <?php echo $release['Servico']['sigla'] . " - " .$release['Release']['versao']; ?>
      </b>
    </div>
    <div class="panel-body">
      <div class="col-lg-12">
        <div class="bs-callout bs-callout-warning col-lg-5 pull-left">
          <h4 class="normal">
            RDM: <?php echo $this->Html->link($release['Rdm']['numero'], array('controller' => 'rdms', 'action' => 'view', $release['Rdm']['id'])); ?>
             -- Data Prevista: <?php echo $release['Rdm']['dt_prevista']; ?>
             <span class="bs-callout-actions">
               <?php
                 echo $this->Tables->getMenu('rdms', $release['Rdm']['id'], 14);
                 echo "<a id='viewHistorico' data-toggle='modal' data-target='#Historico' onclick='javascript:historico(" . $release['Rdm']['id'] . ")'>
                   <i class='fa fa-history' style='margin-left: 5px;' title='Visualizar histórico'></i></a>";
               ?>
             </span>
          </h4>
        </div>
        <div class="bs-callout bs-callout-default col-lg-6 pull-right">
            <h4 class="normal">
            <?php echo $this->Times->timeLeftTo($release['Release']['dt_ini_prevista'], $release['Release']['dt_fim_prevista'],
                      $release['Release']['dt_ini_prevista'] . " - " .  $release['Release']['dt_fim_prevista'],
                      ($release['Release']['dt_fim']));
                      ?>
            </h4>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" id="dataTables-releases">
          <thead>
            <tr>
              <th>Prioridade</th>
              <th><span class="editable">Status</span></th>
              <th>Solicitada pelo Cliente?</th>
              <th>Demanda</th>
              <th>Mantis</th>
              <th>Título <i class="fa fa-comment-o" style="font-size: 15px !important;"></i></th>
              <th>Título</th>
              <th>Prazo</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($release['Rdm']['Demanda'] as $d): ?>
              <tr>
                <td class="hidden-xs hidden-sm">
                  <span style="cursor:pointer;" title="Clique para alterar a prioridade!" id="<?php echo $d['id']?>"><?php echo $d['prioridade']; ?></span>
                </td>
                <?php echo $this->Tables->PrioridadeEditable($d['id'], "demandas") ?>
                <td>
                  <span style="border-bottom: 6px solid #<?php echo substr(md5($d['Status']['nome']), 0, 6) ?>;" cursor:pointer; title="Clique para alterar o status!" id="<?php echo "status-" . $d['id'] ?>">
                    <?php echo $d['Status']['nome']; ?>
                  </span>
                </td>
                <?php echo $this->Tables->DemandaStatusEditable($d['id'], "demandas") ?>
                <td><?php echo $this->Times->yesOrNo($d['origem_cliente']); ?></td>
                <td><?php echo $d['clarity_dm_id']; ?></td>
                <td><?php echo $d['mantis_id']; ?></td>
                <td><?php echo $this->Tables->popupBox($d['nome'], $d['descricao']) ?></td>
                <td><?php echo $d['nome']; ?></td>
                <td>
                  <?php echo $this->Times->timeLeftTo($d['data_cadastro'], $d['dt_prevista'],
                         $d['data_cadastro'] . " - " . $d['dt_prevista'],
                        ($d['data_homologacao']));?>
                </td>
               <td>
                 <?php echo $this->Tables->getMenu('Demandas', $d['id'], 14);
                  echo "<a id='viewHistorico' data-toggle='modal' data-target='#Historico' onclick='javascript:historico(" . $d['id'] . ")'>
                   <i class='fa fa-history' style='margin-left: 5px;' title='Visualizar histórico'></i></a></span>";?>
               </td>
              </tr>
            <?php endforeach; ?>
            <?php unset($d); ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function() {
      $('#dataTables-releases').dataTable({
          "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
            language: {
              url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
            },
            "columnDefs": [  { "visible": false, "targets": 6 } ],
            //responsive: true,
            "dom": 'T<"clear">lfrtip',
            "tableTools": {
                "sSwfPath": "<?php echo Router::url('/', true);?>/js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                  {
                      "sExtends": "copy",
                      "sButtonText": "Copiar",
                      "oSelectorOpts": { filter: 'applied', order: 'current' },
                      "mColumns": [ 0,1,2,3,4,6,7 ]
                  },
                  {
                      "sExtends": "print",
                      "sButtonText": "Imprimir",
                      "oSelectorOpts": { filter: 'applied', order: 'current' },
                      "mColumns": [ 0,1,2,3,4,6,7 ]
                  },
                  {
                      "sExtends": "csv",
                      "sButtonText": "CSV",
                      "sFileName": "<?php echo $release['Servico']['sigla'] . " - " . $release['Release']['versao']; ?>.csv",
                      "oSelectorOpts": { filter: 'applied', order: 'current' },
                      "mColumns": [ 0,1,2,3,4,6,7 ]
                  },
                  {
                      "sExtends": "pdf",
                      "sButtonText": "PDF",
                      "sFileName": "<?php echo $release['Servico']['sigla'] . " - " . $release['Release']['versao']; ?>.pdf",
                      "oSelectorOpts": { filter: 'applied', order: 'current' },
                      "mColumns": [ 0,1,2,3,4,7 ],
                      "sTitle": "<?php echo $release['Servico']['sigla'] . " - " . $release['Release']['versao']; ?>",
                      "sPdfMessage": "Extraído em: <?php echo date('d/m/y')?>",
                  },
                ]
            }
        });

        $('[data-toggle="popover2"]').popover({trigger: 'hover','placement': 'left', html: 'true'});

        $('#dataTables-tarefas').dataTable({
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
              language: {
                url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
              },
              "dom": 'T<"clear">lfrtip',
              "tableTools": {
                  "sSwfPath": "<?php echo Router::url('/', true);?>/js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                  "aButtons": [
                    {
                        "sExtends": "copy",
                        "sButtonText": "Copiar",
                        "mColumns": [ 0,1,2,3,4 ]
                    },
                    {
                        "sExtends": "print",
                        "sButtonText": "Imprimir"
                    },
                    {
                        "sExtends": "csv",
                        "sButtonText": "CSV",
                        "sFileName": "Tarefas.csv",
                        "mColumns": [ 0,1,2,3,4 ]
                    },
                    {
                        "sExtends": "pdf",
                        "sButtonText": "PDF",
                        "sFileName": "Tarefas.pdf",
                        "sPdfOrientation": "landscape",
                        "sTitle": "Tarefas da Release: "  + <?php echo "'" .$release['Release']['versao'] . "'"; ?>,
                        "sPdfMessage": "Extraído em: <?php echo date('d/m/y')?>",
                        "mColumns": [ 0,1,2,3,4 ]
                    },
                  ]
              }
          });
    });
  </script>
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

  //-- Jeditable
  echo $this->Html->script('plugins/jeditable/jquery.jeditable.js');
?>



<div class="col-md-12">
  <?php
  echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-2'));
  echo $this->Html->script('getSDMInfoReleases.js');
  ?>
</dvi>
