<?php
  $this->Html->addCrumb('Áreas', '/areas');
  $this->Html->addCrumb('Visualizar', '');
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Área: <?php echo $area['Area']['nome']; ?></h3></div>
</div>

<div class="row">
  <div class="col-lg-3">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Informações
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-edit pull-right'></i>",
                  array('controller' => 'Areas', 'action' => 'edit', $area['Area']['id']),
                  array('escape' => false));
              }
            ?>
          </h3>
        </p>
      </div>
      <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
          <li><a><b>Nome: </b><?php echo $area['Area']['nome']; ?></a></li>
          <li><a><b>Sigla: </b><?php echo $area['Area']['sigla']; ?></a></li>
          <li><a><b>Cliente: </b><?php echo $area['Area']['cliente']; ?></a></li>
          <li><a><b>Status: </b><?php echo $this->Times->active($area['Area']['status']); ?></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
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
              <?php foreach($area['Servico'] as $ser): ?>
                <tr>
                  <td>
                    <?php echo $this->Html->link($ser['sigla'],
                                array('controller' => 'servicos', 'action' => 'view', $ser['id']) ); ?>
                  </td>
                  <td><?php echo $ser['nome']; ?></td>
                  <td>
                     <?php
                        if($this->Ldap->autorizado(2)){
                          echo $this->Html->link("<i class='fas fa-pencil-alt'></i>",
                                array('controller' => 'servicos', 'action' => 'edit',
                                       $ser['id'], '?' => array('area' =>  $area['Area']['id'])),
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

<?php echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-2')); ?>
