<?php
  $this->Html->addCrumb('Contrato', '');
  $this->Html->addCrumb("Regras de ANS", "");
?>
<div class="col-lg-12 page-header-box">
  <div class="col-lg-12"><h3 class="page-header">Regra de ANS - <?php echo $regra['Servico']['nome']; ?></h3></div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="col-lg-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <p>
            <h3 class="panel-title">Informações Gerais
              <?php
                if($this->Ldap->autorizado(2)){
                  echo $this->Html->link("<i class='fa fa-edit pull-right'></i>",
                    array('controller' => 'regras', 'action' => 'edit', $regra['Regra']['id']),
                    array('escape' => false));
                }
              ?>
            </h3>
          </p>
        </div>
        <div class="panel-body">
          <ul class="nav nav-pills nav-stacked">
            <li><a><b>Nome: </b><?php echo $regra['Regra']['nome']; ?></a></li>
            <li><a><b>Serviço: </b><?php echo $regra['Servico']['nome']; ?></a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="col-lg-12">
      <div class="panel panel-warning">
        <div class="panel-heading">
          <p>
            <h3 class="panel-title">Modelo </h3>
          </p>
        </div>
        <div class="panel-body">
          <?php
            echo $regra['Regra']['modelo'];
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
