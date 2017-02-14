<?php
  $this->Html->addCrumb('Grupotarefas', '/grupotarefas');
  $this->Html->addCrumb($grupotarefa['Grupotarefa']['marcador'], array('controller' => 'grupotarefas', 'action' => 'view', $grupotarefa['Grupotarefa']['id']));
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Grupotarefa: <?php echo $grupotarefa['Grupotarefa']['marcador']; ?></h3></div>
</div>

<div class="row">
  <div class="col-lg-4">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Informações Gerais
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-edit pull-right'></i>",
                  array('controller' => 'grupotarefas', 'action' => 'edit', $grupotarefa['Grupotarefa']['id']),
                  array('escape' => false));
              }
            ?>
          </h3>
        </p>
      </div>
      <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
          <li><a><b>Nome:</b><?php echo $grupotarefa['Grupotarefa']['nome']; ?></a></li>
          <li><a><b>Marcador: </b><?php echo  $grupotarefa['Grupotarefa']['marcador']; ?></a></li>
          <li><a><b>Tipo: </b><?php echo $this->Grupotarefa->tipo($grupotarefa['Grupotarefa']['tipo']); ?></a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="panel panel-default panel-danger">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Itens
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                array('controller' => 'grupotarefaItems', 'action' => 'add','?' => array('controller' => 'grupotarefas', 'id' =>  $grupotarefa['Grupotarefa']['id'], 'action' => 'view' )),
                array('escape' => false));
              }
            ?>
            <a style="cursor:pointer;" onclick="javascript:$('div.panel-body.itens-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></a>
          </h3>
        </p>
      </div>
      <div class="panel-body itens-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-grupotarefa">
            <thead>
              <tr>
                <th>Descrição</th>
                <th>Duração</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($grupotarefa['GrupotarefaItem'] as $item): ?>
                <tr>
                  <td><?php echo $item['descricao']; ?></td>
                  <td><?php echo $item['duracao']; ?> dia(s)</td>
                  <td>
                     <?php
                        if($this->Ldap->autorizado(2)){
                          echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                array('controller' => 'grupotarefaItems', 'action' => 'edit', $item['id'], '?' => array('controller' => 'grupotarefas', 'id' =>  $grupotarefa['Grupotarefa']['id'], 'action' => 'view' )),
                                array('escape' => false));
                          echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                array('controller' => 'grupotarefaItems', 'action' => 'delete', $item['id'], '?' => array('controller' => 'grupotarefas', 'id' =>  $grupotarefa['Grupotarefa']['id'], 'action' => 'view' )),
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
</div>


<div class="col-md-12">
  <?php echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-2')); ?>
</dvi>
