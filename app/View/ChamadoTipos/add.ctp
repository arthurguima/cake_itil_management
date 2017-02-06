<?php
  $this->Html->addCrumb('Tipos de Chamados', '/chamadotipos');
  $this->Html->addCrumb("Nova", array('controller' => 'chamadotipos', 'action' => 'add'));
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Novo Tipo de Chamado</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('ChamadoTipo');

      echo $this->BootstrapForm->input('nome', array(
                'label' => array('text' => 'Nome: ')));

      echo $this->BootstrapForm->input('servico_id', array(
                  'class' => 'select2',
                  'empty'=>'Serviço',
                  'label' => array('text' => 'Serviço: ')));
    ?>
    <div class="form-footer col-lg-10 col-md-6 pull-right">
      <?php
        echo $this->BootstrapForm->submit('Salvar');
        echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-lg-3 col-md-6'));
        echo $this->Form->end();
      ?>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('.select2').select2({
      language: "pt-BR",
      theme: "bootstrap"
    });
  });
</script>

<?php
  //-- Select2 --
  echo $this->Html->script('plugins/select2/select2.full.min');
  echo $this->Html->css('plugins/select2.min');
  echo $this->Html->css('plugins/select2-bootstrap.min');
  echo $this->Html->script('plugins/select2/pt-BR');
?>
