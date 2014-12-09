<?php
  $this->Html->addCrumb('SS', '/sses');
  $this->Html->addCrumb($ss['Ss']['nome'] , "");
?>

<div class="row">
  <div class="col-lg-12"><h3 class="page-header">SS: <?php echo ($ss['Ss']['nome'] . " - " . $ss['Servico']['nome']); ?></h3></div>
</div>

<div class="row">
  <div class="col-lg-4">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Informações
            <?php
              echo $this->Html->link("<i class='fa fa-edit pull-right'></i>",
                array('controller' => 'sses', 'action' => 'edit', $ss['Ss']['id']),
                array('escape' => false));
            ?>
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.info-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
          </h3>
        </p>
      </div>
      <div class="panel-body info-body">
        <ul class="nav nav-pills nav-stacked">
          <li><a><b>Nome: </b><?php echo $ss['Ss']['nome']; ?></a></li>
          <li><a><b>Número: </b><?php echo $ss['Ss']['numero']; ?></a></li>
          <li><a><b>Prioridade: </b><?php echo $ss['Ss']['prioridade']; ?></a></li>
          <li>
            <?php echo "<a id='viewClarity' data-toggle='modal' data-target='#myModal' onclick='javascript:indexClarity(" .
                     $ss['Ss']['clarity_id'] .")'><b>Clarity DM: </b>" . $ss['Ss']['clarity_dm_id']  .
                     "<i class='fa-expand fa' style='cursor:pointer; float:right;' title='Clique aqui para testar a integração da demanda com o sistema Clarity!'></i></a></span>" ?>
          </li>
          <li><a><b>Ano: </b><?php echo $ss['Ss']['ano']; ?></a></li>
          <li><a><b>Status: </b><?php echo $ss['Status']['nome']; ?></a></li>
          <li><a><b>Data de Recebimento da SS: </b><?php echo $this->Times->pastDate($ss['Ss']['dt_recebimento']); ?></a></li>
          <li><a><b>Prazo de entrega: </b><?php echo $this->Times->pastDate($ss['Ss']['dt_prazo']); ?></a></li>
          <li><a><b>Data Prevista: </b><?php echo $this->Times->pastDate($ss['Ss']['dt_prevista']); ?></a></li>
          <li><a><b>Prazo: </b><?php echo $this->Times->timeLeftTo($ss['Ss']['dt_recebimento'], $ss['Ss']['dt_prevista'],
                  $this->Time->format('d/m/Y', $ss['Ss']['dt_recebimento']) . " - " . $this->Time->format('d/m/Y', $ss['Ss']['dt_prevista']),
                  ($ss['Ss']['dt_finalizada'])); ?></a></li>
          <li><a><b>Responsável: </b><?php echo $ss['Ss']['responsavel']; ?></a></li>
          <li><a><b>CVS: </b><?php echo $ss['Ss']['cvs_url']; ?></a></li>
          <li><a><b>Observação: </b><?php echo $ss['Ss']['observacao']; ?></a></li>
          <li class="checklist"><a><b>Checklist: </b><?php echo $this->Ss->getCheckList($ss['Ss']['dv'], $ss['Ss']['contagem']) ?></a></td>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="panel panel-default panel-default">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Demandas Internas
            <?php echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
              array('controller' => 'demandas', 'action' => 'add','?' => array('controller' => 'sses', 'id' =>  $ss['Ss']['id'], 'action' => 'view' )),
              array('escape' => false)); ?>
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.demandas-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
          </h3>
        </p>
      </div>
      <div class="panel-body demandas-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-demandas">
            <thead>
              <tr>
                <th>Tipo</th>
                <th>Nome</th>
                <th>Clarity ID:</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($ss['Demanda'] as $dem): ?>
                <tr>
                  <td><?php echo($dem['DemandaTipo']['nome']); ?></td>
                  <td><?php echo $dem['nome']; ?></td>
                  <td class="hidden-xs hidden-sm" style="cursor:pointer;" title="Clique para abrir a demanda no Clarity!">
                      <?php echo "<a id='viewClarity' data-toggle='modal' data-target='#myModal' onclick='javascript:indexClarity(" .
                                 $dem['clarity_id'] .")'>" . $dem['clarity_dm_id'] ."</a></span>" ?>
                  </td>
                  <td><?php echo $this->Tables->getMenu('demandas', $dem['id'], 2); ?></td>
                </tr>
              <?php endforeach; ?>
            <?php unset($area); ?>
          </tbody>
        </table>
      </div>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="panel panel-danger panel-info">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Histórico</b>
            <?php echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
              array('controller' => 'historicos', 'action' => 'add','?' => array('controller' => 'sses', 'id' =>  $ss['Ss']['id'], 'action' => 'view' )),
              array('escape' => false)); ?>
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
              <?php foreach($ss['Historico'] as $hist): ?>
                  <tr>
                    <td><?php echo $hist['data']; ?></td>
                    <td><?php echo $hist['descricao']; ?></td>
                    <td><?php echo $hist['analista']; ?></td>
                    <td>
                       <?php
                          echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                array('controller' => 'historicos', 'action' => 'edit', $hist['id'], '?' => array('controller' => 'sses', 'id' =>  $ss['Ss']['id'], 'action' => 'view' )),
                                array('escape' => false));
                          echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                array('controller' => 'historicos', 'action' => 'delete', $hist['id'], '?' => array('controller' => 'sses', 'id' => $ss['Ss']['id'], 'action' => 'view' )),
                                array('escape' => false), "Você tem certeza");
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

  <div class="col-lg-8">
    <div class="panel panel-default panel-info">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>PEs</b>
            <?php echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
              array('controller' => 'pes', 'action' => 'add','?' => array('controller' => 'sses', 'id' =>  $ss['Ss']['id'], 'action' => 'view', 'servico' =>  $ss['Ss']['servico_id'] )),
              array('escape' => false)); ?>
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.pe-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
          </h3>
        </p>
      </div>
      <div class="panel-body pe-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-contrato">
            <thead>
              <tr>
                <th>Número</th>
                <th>Nome</th>
                <th>Status</th>
                <th>Responsável</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($ss['Pe'] as $pe): ?>
                  <tr>
                    <td><?php echo $pe['numero']; ?></td>
                    <td><?php echo $pe['nome']; ?></td>
                    <td><?php echo $pe['Status']['nome']; ?></td>
                    <td><?php echo $pe['responsavel']; ?></td>
                    <td>
                       <?php
                          echo $this->Html->link("<i class='fa fa-search-plus ' style='margin-right: 5px;' title='Visualizar detalhes'></i>",
                                array('controller' => 'pes', 'action' => 'view', $pe['id']), array('escape' => false));
                          echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                array('controller' => 'pes', 'action' => 'edit', $pe['id'], '?' => array('controller' => 'sses', 'id' =>  $ss['Ss']['id'], 'action' => 'view' )),
                                array('escape' => false));
                       ?>
                     </td>
                  </tr>
                <?php endforeach; ?>
              <?php unset($pe); ?>
          </tbody>
        </table>
      </div>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <?php echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-2')); ?>
  </dvi>
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
  });
</script>
