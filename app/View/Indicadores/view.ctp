<?php
  $this->Html->addCrumb('Contrato', '');
  $this->Html->addCrumb("Indicadores", "");
?>
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">
      <?php
        echo $indicadore['Regra']['nome'] . ": " . $indicadore['Regra']['Servico']['nome'] . " - " . $indicadore['Indicadore']['mes'] . "/" . $indicadore['Indicadore']['ano'];
      ?>
    </h3>
  </div>
</div>

<div class="row">
    <div class="col-lg-12">
      <div class="panel panel-warning">
        <div class="panel-heading">
          <p>
            <h3 class="panel-title">Valor </h3>
          </p>
        </div>
        <div class="panel-body">
          <?php
            echo $indicadore['Indicadore']['valor'];
          ?>
        </div>
      </div>
    </div>

    <div class="form-footer col-lg-10 col-md-6 pull-right">
      <?php
        echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-lg-3 col-md-6'));
      ?>
    </div>
</div>
