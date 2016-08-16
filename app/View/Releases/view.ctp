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
</div>

<div class="col-md-12">
  <?php
  echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-2'));
  echo $this->Html->script('getSDMInfoReleases.js');
  ?>
</dvi>
