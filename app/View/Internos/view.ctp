<?php
  $this->Html->addCrumb('Sistemas Internos', '/internos');
  $this->Html->addCrumb('Visualizar', '');
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Sistema Interno</h3></div>
</div>

<div class="row">
  <div class="col-lg-3">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Informações Gerais</b>
            <?php
              echo $this->Html->link("<i class='fa fa-edit pull-right'></i>",
                array('controller' => 'internos', 'action' => 'edit', $interno['Interno']['id']),
                array('escape' => false));
            ?>
          </h3>
        </p>
      </div>
      <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
          <li><a><b>Nome: </b><?php echo $interno['Interno']['nome']; ?></a></li>
          <li><a><b>Descrição: </b> <?php echo $interno['Interno']['descricao']; ?></a></li>
          <li><a><b>Instruções: </b><?php echo $interno['Interno']['instrucoes']; ?></a></li>
          <li><?php echo $this->Html->link("<b>URL: </b>" . $interno['Interno']['url'], $interno['Interno']['url'], array('escape' => false, 'target'=>'_blank'))	; ?></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<?php echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-2')); ?>
