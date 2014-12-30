<?php
  $this->Html->addCrumb('Pes', '');
  $this->Html->addCrumb($chamado['Chamado']['id'], array('controller' => 'items', 'action' => 'edit', $chamado['Chamado']['id']));
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Pe: <?php echo $chamado['Chamado']['nome'] . " - " . $chamado['Servico']['nome']; ?></h3></div>
</div>

<div class="row">
  <div class="col-lg-4">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">
            <b>Informações</b>
            <?php
              echo $this->Html->link("<i class='fa fa-edit pull-right'></i>",
                array('controller' => 'Pes', 'action' => 'edit', $chamado['Chamado']['id']),
                array('escape' => false));
            ?>
          </h3>
        </p>
      </div>
      <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
          <li><a><b>Nome: </b><?php echo $chamado['Chamado']['nome']; ?></a></li>
          <li><a><b>Número: </b><?php echo $chamado['Chamado']['numero'] . "/". $chamado['Chamado']['ano']; ?></a></li>
          <li><a><b>Status: </b><?php echo $chamado['Status']['nome']; ?></a></li>
          <li><a><b>Responsável: </b><?php echo $chamado['Chamado']['responsavel']; ?></a></li>
          <li><a><b>Serviço: </b><?php echo $chamado['Servico']['nome']; ?></a></li>
          <li><a><b>Aberto?: </b><?php echo $this->Times->yesOrNo($chamado['Chamado']['aberto'])?></a></li>
          <li><a><b>Pai?: </b><?php echo $this->Times->yesOrNo($chamado['Chamado']['pai'])?></a></li>
          <li><a><b>Observação: </b><?php echo $chamado['Chamado']['observacao']; ?></a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="panel panel-danger panel-info">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Histórico</b>
            <?php echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
              array('controller' => 'historicos', 'action' => 'add','?' => array('controller' => 'chamados', 'id' =>  $chamado['Chamado']['id'], 'action' => 'view' )),
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
              <?php foreach($chamado['Historico'] as $hist): ?>
                  <tr>
                    <td><?php echo $hist['data']; ?></td>
                    <td><?php echo $hist['descricao']; ?></td>
                    <td><?php echo $hist['analista']; ?></td>
                    <td>
                       <?php
                          echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                array('controller' => 'historicos', 'action' => 'edit', $hist['id'], '?' => array('controller' => 'pes', 'id' =>  $chamado['Chamado']['id'], 'action' => 'view' )),
                                array('escape' => false));
                          echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                array('controller' => 'historicos', 'action' => 'delete', $hist['id'], '?' => array('controller' => 'pes', 'id' => $chamado['Chamado']['id'], 'action' => 'view' )),
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

<div class="col-md-12">
  <?php echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-2')); ?>
</dvi>
