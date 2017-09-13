<?php
  $this->Html->addCrumb('Contrato', '');
  $this->Html->addCrumb("Indicadores", "");
?>
<div class="col-lg-12 page-header-box">
  <div class="col-lg-12">
    <h3 class="page-header">
      <?php
        echo $indicadore['Indicadore']['mes'] . "/" . $indicadore['Indicadore']['ano'] . " - " . $indicadore['Regra']['nome'] . ": " . $indicadore['Regra']['Servico']['nome'];
      ?>
    </h3>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-warning">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Indicador</h3>
        </p>
      </div>
      <div class="panel-body">
        <?php
          echo $indicadore['Indicadore']['valor'];
          echo $indicadore['Regra']['observacao'];
        ?>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="form-footer col-lg-10 col-md-6 pull-right">
    <?php
      echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-lg-3 col-md-6'));
    ?>
  </div>
</div>
