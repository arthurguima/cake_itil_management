<?php
  $this->Html->addCrumb('Indisponibilidades', '/indisponibilidades');
  $this->Html->addCrumb($Indisponibilidade['Indisponibilidade']['id'], array('controller' => 'indisponibilidades', 'action' => 'view', $Indisponibilidade['Indisponibilidade']['id']));
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Indisponibilidade: </h3></div>
</div>

<div class="row">
  <div class="col-lg-5">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Informações
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-edit pull-right'></i>",
                  array('controller' => 'indisponibilidades', 'action' => 'edit', $Indisponibilidade['Indisponibilidade']['id']),
                  array('escape' => false));
              }
            ?>
          </h3>
        </p>
      </div>
      <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
          <li><a><b>Número do Evento: </b><?php echo $Indisponibilidade['Indisponibilidade']['num_evento']; ?></a></p>
          <li><a><b>Número do Incidente: </b><?php echo $Indisponibilidade['Indisponibilidade']['num_incidente']; ?></a></p>
          <li><a><b>Motivo: </b><?php echo $Indisponibilidade['Motivo']['nome']; ?></a></p>
          <li><a><b>Início: </b><?php echo $Indisponibilidade['Indisponibilidade']['dt_inicio']; ?></a></p>
          <li><a><b>Duração: </b>
              <?php if($Indisponibilidade['Indisponibilidade']['dt_fim'] != null):
                    echo $this->Times->totalTime($Indisponibilidade['Indisponibilidade']['dt_inicio'],
                                           $Indisponibilidade['Indisponibilidade']['dt_fim']);
                  endif;
            ?></a>
          </li>
          <li><a><b>Observação: </b><?php echo $Indisponibilidade['Indisponibilidade']['observacao']; ?></a></p>
          <li><a><b>Status: </b>
            <?php
              if ($Indisponibilidade['Indisponibilidade']['dt_fim'] == null):
                echo "<span class='label label-success'>Aberto</span>";
              else:
                echo "<span class='label label-default'>Fechado</span>";
              endif;
             ?></a>
          </li>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="panel panel-default panel-info">
      <div class="panel-heading"><p><h3 class="panel-title">Serviços</h3></p></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-contrato">
            <thead>
              <tr>
                <th>Sigla</th>
                <th>Nome</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($Indisponibilidade['Servico'] as $ser): ?>
                <tr>
                  <td>
                    <?php echo $this->Html->link($ser['sigla'],
                                array('controller' => 'servicos', 'action' => 'view', $ser['id']) ); ?>
                  </td>
                  <td><?php echo $ser['nome']; ?></td>
                  <td>
                     <?php
                      if($this->Ldap->autorizado(2)){
                        echo $this->Html->link("<i class='fa fa-pencil'></i>",
                              array('controller' => 'servicos', 'action' => 'edit',
                                     $ser['id'], '?' => array('indisponibilidade' =>  $Indisponibilidade['Indisponibilidade']['id'])),
                              array('escape' => false));
                      }
                     ?>
                   </td>
                </tr>
              <?php endforeach; ?>
            <?php unset($ser); ?>
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
