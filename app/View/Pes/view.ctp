<?php
  $this->Html->addCrumb('PAs', '');
  $this->Html->addCrumb($pe['Pe']['id'], array('controller' => 'items', 'action' => 'edit', $pe['Pe']['id']));
?>
<div class="col-lg-12 page-header-box">
  <div class="col-lg-12"><h3 class="page-header">PA: <?php echo $pe['Pe']['numero'] . "/" . $pe['Pe']['ano'] . " - " . $pe['Servico']['nome']; ?></h3></div>
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
                  array('controller' => 'Pes', 'action' => 'edit', $pe['Pe']['id']),
                  array('escape' => false));
              }
            ?>
          </h3>
        </p>
      </div>
      <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
          <!--li><a><b>Nome: </b><?php //echo $pe['Pe']['nome']; ?></a></li-->
          <li><a><b>Número: </b><?php echo $pe['Pe']['numero'] . "/" . $pe['Pe']['ano'] ; ?></a></li>
          <li><a><b>Número da CE de envio: </b><?php echo $pe['Pe']['num_ce']; ?></a></li>
          <li><a><b>Data de emissão: </b><?php echo $pe['Pe']['dt_emissao']; ?></a></li>
          <li><a><b>Data Prevista de Início da OS: </b><?php echo $pe['Pe']['dt_inicio']; ?></a></li>
          <li><a><b>Tempo estimado: </b><?php echo $pe['Pe']['temp_estimado']; ?></a></li>
          <li>
            <a><b>Validade do PDD: </b>
              <?php
                if($pe['Pe']['validade_pdd'] != null){
                  echo $this->Times->pastDate($pe['Pe']['validade_pdd']);
                }
              ?>
            </a>
          </li>
          <li><a><b>Responsável: </b><?php echo $pe['User']['nome']; ?></a></li>
          <li><a><b>Status: </b><?php echo $pe['Status']['nome']; ?></a></li>
          <li>
            <a href=<?php echo Router::url('/', true) . '/sses/view/' . $pe['Ss']['id']; ?>>
            <b>SS: </b><?php echo $pe['Ss']['nome'] . " <i class='fa-external-link-square fa' style='font-size: 15px !important;'></i>" ; ?></a>
          </li>
          <li><a style="overflow: auto;"><b>URL: </b><?php echo $pe['Pe']['cvs_url']; ?></a></li>
          <li><a><b>Observação: </b><?php echo $pe['Pe']['observacao']; ?></a></li>
        </ul>
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
                array('controller' => 'historicos', 'action' => 'add','?' => array('controller' => 'pes', 'id' =>  $pe['Pe']['id'], 'action' => 'view' )),
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
              <?php foreach($pe['Historico'] as $hist): ?>
                  <tr>
                    <td><?php echo $hist['data']; ?></td>
                    <td><?php echo $this->Historicos->findLinks( $hist['descricao']); ?></td>
                    <td><?php echo $hist['analista']; ?></td>
                    <td>
                       <?php
                        if($this->Ldap->autorizado(2)){
                          echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                array('controller' => 'historicos', 'action' => 'edit', $hist['id'], '?' => array('controller' => 'pes', 'id' =>  $pe['Pe']['id'], 'action' => 'view' )),
                                array('escape' => false));
                          echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                array('controller' => 'historicos', 'action' => 'delete', $hist['id'], '?' => array('controller' => 'pes', 'id' => $pe['Pe']['id'], 'action' => 'view' )),
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

  <div class="col-lg-8">
    <div class="panel panel-warning">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Itens de Contrato
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                array('controller' => 'itempes', 'action' => 'add','?' => array('controller' => 'pes', 'id' =>  $pe['Pe']['id'], 'action' => 'view' )),
                array('escape' => false));
              }
            ?>
            <a style="cursor:pointer;" onclick="javascript:$('div.panel-body.itens-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></a>
          </h3>
        </p>
      </div>
      <div class="panel-body itens-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-contrato">
            <thead>
              <tr>
                <th>Tipo</th>
                <th>Contrato</th>
                <th>Aditivo</th>
                <th>Volume</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($pe['ItemPe'] as $item): ?>
                <tr>
                  <td><?php echo $item['Item']['nome']; ?></td>
                  <td><?php echo $item['Contrato']['numero']; ?></td>
                  <td>
                    <?php
                      if(isset($item['Aditivo']['dt_inicio'])){
                          echo $item['Aditivo']['dt_inicio'];
                      }
                      else{ echo " --- ";}
                    ?>
                  </td>
                  <td><?php echo $item['volume'] . " " . $item['Item']['metrica']; ?></td>
                  <td>
                     <?php
                        if($this->Ldap->autorizado(2)){
                          echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                array('controller' => 'itempes', 'action' => 'edit', $item['id'], '?' => array('controller' => 'pes', 'id' =>  $pe['Pe']['id'], 'action' => 'view' )),
                                array('escape' => false));
                          echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                array('controller' => 'itempes', 'action' => 'delete', $item['id'], '?' => array('controller' => 'pes', 'id' =>  $pe['Pe']['id'], 'action' => 'view' )),
                                array('escape' => false), "O registro será excluído, você tem certeza dessa ação?");
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
</div>

<div class="col-md-12">
  <?php echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-2')); ?>
</dvi>
