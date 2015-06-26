<?php
  $this->Html->addCrumb('Usuários', '/users');
  $this->Html->addCrumb("Editar", "");
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Editar Usuário</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('User');

      echo $this->BootstrapForm->input('id');

      echo $this->BootstrapForm->input('nome', array(
                  'label' => array('text' => 'Nome: ')));

      echo $this->BootstrapForm->input('Cliente', array(
                  'label' => array('text' => 'Clientes: '),
                  'input' => 'text',
                  'multiple' => true,));
    ?>
    <div class="form-footer col-lg-10 pull-right">
      <?php
        echo $this->BootstrapForm->submit('Salvar');
        echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-3'));
        echo $this->Form->end();
      ?>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#ClienteCliente').select2();
  });
</script>

<?php
  //Select2
  echo $this->Html->script('plugins/select2/select2.min');
  echo $this->Html->script('plugins/select2/select2_locale_pt-BR');
  echo $this->Html->css('plugins/select2');
  echo $this->Html->css('plugins/select2-bootstrap');
?>
