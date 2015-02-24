<?php
  $this->Html->addCrumb('Ords', '');
  $this->Html->addCrumb($ord['Ord']['id'], array('controller' => 'items', 'action' => 'edit', $ord['Ord']['id']));
?>
<div class="row">
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
              <b>Deploy Homologação: </b>
              <?php
                if($ord['Ord']['dt_deploy_homologacao'] != null){
                  echo $this->Times->pastDate($ord['Ord']['dt_deploy_homologacao']);
                }
               ?>
            </a>
          </li>
          <li>
            <a>
              <b>Deploy Produção: </b>
              <?php
                if($ord['Ord']['dt_deploy_producao'] != null){
                  echo $this->Times->pastDate($ord['Ord']['dt_deploy_producao']);
                }
              ?>
            </a>
          </li>
          <li>
            <a>
              <b>Data de Homologação: </b>
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
          <li><a><b>Volume Final: </b><?php echo $ord['Ord']['pf']; ?></a></li>
          <li><a><b>Status: </b><?php echo $ord['Status']['nome']; ?></a></li>
          <li><a href='/sgd/sses/view/<?php echo $ord['Ss']['id']; ?>'><b>SS: </b><?php echo $ord['Ss']['nome']; ?></a></li>
          <li><a href='/sgd/pes/view/<?php echo $ord['Pe']['id']; ?>'><b>PA: </b><?php echo $ord['Pe']['numero'] . "/" . $ord['Pe']['ano']; ?></a></li>
          <li><a style="overflow: auto;"><b>URL: </b><?php echo $ord['Ord']['cvs_url']; ?></a></li>
          <li><a><b>Termos: </b><?php echo $this->Ord->getCheckList($ord['Ord']['ths'], $ord['Ord']['trp'], $ord['Ord']['trd']) ?></li>
          <li><a><b>Observação: </b><?php echo $ord['Ord']['observacao']; ?></a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="panel panel-danger panel-info">
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
</dvi>
