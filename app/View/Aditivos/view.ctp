<?php
  $this->Html->addCrumb('Contratos', '/contratos');
  $this->Html->addCrumb($aditivo['Contrato']['numero'], array('controller' => 'contratos', 'action' => 'view', $aditivo['Contrato']['id']));
  $this->Html->addCrumb('Aditivos', '');
  $this->Html->addCrumb($aditivo['Aditivo']['id'], array('controller' => 'items', 'action' => 'edit', $aditivo['Aditivo']['id']));
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Aditivo: <?php echo $aditivo['Aditivo']['id']; ?></h3></div>
</div>

<div class="row">
  <div class="col-lg-2">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <p>
          <b>Informações</b>
          <?php
            if($this->Ldap->autorizado(2)){
              echo $this->Html->link("<i class='fa fa-edit pull-right'></i>",
                array('controller' => 'Aditivos', 'action' => 'edit', $aditivo['Aditivo']['id']),
                array('escape' => false));
            }
          ?>
        </p>
      </div>
      <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
          <li><a><b>Data Início: </b><?php echo $aditivo['Aditivo']['dt_inicio']; ?></a></li>
          <li><a><b>Data Fim: </b><?php echo $this->Times->pastDate($aditivo['Aditivo']['dt_fim']) ?></a></li>
          <li>
            <?php echo $this->Html->link("<b>Contrato: </b> " . $aditivo['Contrato']['numero'],
                  array('controller' => 'contratos', 'action' => 'view', $aditivo['Contrato']['id']),
                  array('escape' => false)); ?>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-lg-10">
    <div class="panel panel-default panel-danger">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Itens de Contrato
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                array('controller' => 'items', 'action' => 'add','?' => array('controller' =>  'aditivos', 'id' =>  $aditivo['Aditivo']['id'], 'action' => 'view' )),
                array('escape' => false));
              }
            ?>
          </h3>
        </p>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-contrato">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Volume</th>
                <th>Métrica</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($aditivo['Item'] as $item): ?>
                <tr>
                  <td><?php echo $item['nome']; ?></td>
                  <td><?php echo $item['volume']; ?></td>
                  <td><?php echo $item['metrica']; ?></td>
                  <td>
                     <?php
                      if($this->Ldap->autorizado(2)){
                        echo $this->Html->link("<i class='fa fa-pencil'></i>",
                              array('controller' => 'items', 'action' => 'edit', $item['id'], '?' => array('action' => 'view','controller' => 'aditivos','id' =>  $aditivo['Aditivo']['id'])),
                              array('escape' => false));
                        echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                              array('controller' => 'items', 'action' => 'delete', $item['id'], '?' => array('action' => 'view','controller' => 'aditivos','id' =>  $aditivo['Aditivo']['id'])),
                              array('escape' => false), "Você tem certeza");
                      }
                     ?>
                   </td>
                </tr>
              <?php endforeach; ?>
              <?php unset($item); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-12">
    <div class="panel panel-warning">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Regras de ANS
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                array('controller' => 'regras', 'action' => 'add','?' => array('controller' => 'aditivos', 'id' =>  $aditivo['Aditivo']['id'], 'action' => 'view' )),
                array('escape' => false));
              }
            ?>
            <a style="cursor:pointer;" onclick="javascript:$('div.panel-body.regras-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></a>
          </h3>
        </p>
      </div>
      <div class="panel-body regras-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-contrato">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Serviço</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($aditivo['Regra'] as $regra): ?>
                <tr>
                  <td><?php echo $regra['nome']; ?></td>
                  <td><?php echo $regra['Servico']['nome']; ?></td>
                  <td>
                     <?php
                        echo $this->Html->link("<i class='fa fa-search-plus'></i> ",
                           array('controller' => 'regras', 'action' => 'view', $regra['id'], '?' => array('controller' => 'aditivos', 'id' =>  $aditivo['Aditivo']['id'], 'action' => 'view' )),
                           array('escape' => false));

                        if($this->Ldap->autorizado(2)){
                          echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                array('controller' => 'regras', 'action' => 'edit', $regra['id'], '?' => array('controller' => 'aditivos', 'id' =>  $aditivo['Aditivo']['id'], 'action' => 'view' )),
                                array('escape' => false));
                          echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                array('controller' => 'regras', 'action' => 'delete', $regra['id'], '?' => array('controller' => 'aditivos', 'id' =>  $aditivo['Aditivo']['id'], 'action' => 'view' )),
                                array('escape' => false), "Você tem certeza");
                        }
                     ?>
                   </td>
                </tr>
              <?php endforeach; ?>
              <?php unset($regra); debug($aditivo); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="col-md-12">
  <?php echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-2')); ?>
</dvi>
