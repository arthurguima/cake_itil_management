<?php
  $this->Html->addCrumb('OS', '');
  $this->Html->addCrumb($ord['Ord']['numero'] . "/" . $ord['Ord']['ano'], array('controller' => 'items', 'action' => 'view', $ord['Ord']['id']));
?>
<div class="col-lg-12 page-header-box">
  <div class="col-lg-12"><h3 class="page-header">OS: <?php echo $ord['Ord']['numero'] . "/" . $ord['Ord']['ano'] . " - " . $ord['Servico']['nome']; ?></h3></div>
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
                  array('controller' => 'Ords', 'action' => 'edit', $ord['Ord']['id']),
                  array('escape' => false));
              }
            ?>
          </h3>
        </p>
      </div>
      <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
          <!--li><a><b>Nome: </b><?php //echo $ord['Ord']['nome']; ?></a></li-->
          <li><a><b>Número: </b><?php echo $ord['Ord']['numero'] . "/" . $ord['Ord']['ano'] ; ?></a></li>
          <li><a><b>Data de emissão: </b><?php echo $this->Times->pastDate($ord['Ord']['dt_emissao']); ?></a></li>
          <li><a><b>Data de recebimento: </b><?php echo $this->Times->pastDate($ord['Ord']['dt_recebimento']); ?></a></li>
          <li>
            <a>
              <b>Data de prevista para a Homologação (Interna): </b>
              <?php
                if($ord['Ord']['dt_homo_prev_int'] != null){
                  echo $this->Times->pastDate($ord['Ord']['dt_homo_prev_int']);
                }
               ?>
            </a>
          </li>
          <li>
            <a>
              <b>Data de Homologação (Interna): </b>
              <?php
                if($ord['Ord']['dt_homo_prev'] != null){
                  echo $this->Times->pastDate($ord['Ord']['dt_homo_prev']);
                }
               ?>
            </a>
          </li>
          <li>
            <a>
              <b>Data de prevista para a Homologação (Cliente): </b>
              <?php
                if($ord['Ord']['dt_fim_pdd'] != null){
                  echo $this->Times->pastDate($ord['Ord']['dt_fim_pdd']);
                }
              ?>
            </a>
          </li>
          <li>
            <a>
              <b>Data de Homologação(Cliente): </b>
              <?php
                if($ord['Ord']['dt_homologacao'] != null){
                  echo $this->Times->pastDate($ord['Ord']['dt_homologacao']);
                }
              ?>
            </a>
          </li>
          <li>
            <a>
              <b>Prazo: </b>
              <?php
                if($ord['Ord']['dt_ini_pdd'] != null){
                  echo $this->Times->timeLeftTo($ord['Ord']['dt_ini_pdd'], $ord['Ord']['dt_fim_pdd'],
                        $ord['Ord']['dt_ini_pdd'] . " - " . $ord['Ord']['dt_fim_pdd'],
                        ($ord['Ord']['dt_homologacao']));
                }
              ?>
            </a>
          </li>
          <!--li><a><b>Volume Final: </b><?php// echo $ord['Ord']['pf']; ?></a></li-->
          <li><a><b>Responsável: </b><?php echo $ord['User']['nome']; ?></a></li>
          <li><a><b>Status: </b><?php echo $ord['Status']['nome']; ?></a></li>
          <li>
            <a href=<?php echo Router::url('/', true) . '/sses/view/' . $ord['Ss']['id']; ?>>
            <b>SS: </b><?php echo $ord['Ss']['nome'] . " <i class='fa-external-link-square fa' style='font-size: 15px !important;'></i>"; ?></a>
          </li>
          <li><a style="overflow: auto;"><b>URL: </b><?php echo $ord['Ord']['cvs_url']; ?></a></li>
          <li><a><b>Termos: </b><?php echo $this->Ord->getCheckList($ord['Ord']['ths'], $ord['Ord']['trp'], $ord['Ord']['trd']) ?></li>
          <li><a><b>Observação: </b><?php echo $ord['Ord']['observacao']; ?></a></li>
        </ul>
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
                array('controller' => 'itempes', 'action' => 'add','?' => array(
                  'controller' => 'ords', 'id' =>  $ord['Ord']['id'], 'action' => 'view', 'pe' => $ord['Ord']['pe_id'] )),
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
              <?php /*debug($ord);*/ foreach($ord['ItemPe'] as $item): ?>
                <tr>
                  <td><?php echo $item['ItemPePai']['Item']['nome']; ?></td>
                  <td><?php echo $item['ItemPePai']['Contrato']['numero']; ?></td>
                  <td>
                    <?php
                      if(isset($item['ItemPePai']['Aditivo']['dt_inicio'])){
                          echo $item['ItemPePai']['Aditivo']['dt_inicio'];
                      }
                      else{ echo " --- ";}
                    ?>
                  </td>
                  <td><?php echo $item['volume'] . " " . $item['ItemPePai']['Item']['metrica']; ?></td>
                  <td>
                     <?php
                        if($this->Ldap->autorizado(2)){
                          echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                array('controller' => 'itempes', 'action' => 'edit', $item['id'], '?' => array('controller' => 'ords', 'id' =>  $ord['Ord']['id'], 'action' => 'view', 'pe_id' => $ord['Ord']['pe_id'] )),
                                array('escape' => false));
                          echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                array('controller' => 'itempes', 'action' => 'delete', $item['id'], '?' => array('controller' => 'ords', 'id' =>  $ord['Ord']['id'], 'action' => 'view' )),
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

  <div class="col-lg-8">
    <div class="panel panel-danger">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Histórico</b>
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                array('controller' => 'historicos', 'action' => 'add','?' => array('controller' => 'ords', 'id' =>  $ord['Ord']['id'], 'action' => 'view' )),
                array('escape' => false));
              }
            ?>
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.historico-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
          </h3>
        </p>
      </div>
      <div class="panel-body historico-body">
        <div class="table-responsive">
          <table class="table table-striordd table-bordered table-hover" id="dataTables-contrato">
            <thead>
              <tr>
                <th>Data</th>
                <th>Descrição</th>
                <th>Analista</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($ord['Historico'] as $hist): ?>
                  <tr>
                    <td><?php echo $hist['data']; ?></td>
                    <td><?php echo $this->Historicos->findLinks($hist['descricao']); ?></td>
                    <td><?php echo $hist['analista']; ?></td>
                    <td>
                       <?php
                        if($this->Ldap->autorizado(2)){
                          echo $this->Html->link("<i class='fa fa-ordncil'></i>",
                                array('controller' => 'historicos', 'action' => 'edit', $hist['id'], '?' => array('controller' => 'ords', 'id' =>  $ord['Ord']['id'], 'action' => 'view' )),
                                array('escape' => false));
                          echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                array('controller' => 'historicos', 'action' => 'delete', $hist['id'], '?' => array('controller' => 'ords', 'id' => $ord['Ord']['id'], 'action' => 'view' )),
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

<div class="col-md-12">
  <?php echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-2')); ?>
</dvi>
