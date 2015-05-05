<?php
  $this->Html->addCrumb('Tipos de Chamados', '/chamadotipos');
  $this->Html->addCrumb($this->data['ChamadoTipo']['nome'], array('controller' => 'chamadoTipos', 'action' => 'edit', $this->data['ChamadoTipo']['id']));
?>
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">
      Editar Tipo de Chamado
    </h3>
  </div>
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

      echo $this->Form->input('id', array('type' => 'hidden'));

      echo $this->BootstrapForm->input('id');

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
      containerCssClass: 'select2'
    });
  });
</script>

<?php
  //-- Select2 --
  echo $this->Html->script('plugins/select2/select2.min');
  echo $this->Html->css('plugins/select2');
  echo $this->Html->script('plugins/select2/select2_locale_pt-BR');
  echo $this->Html->css('plugins/select2-bootstrap');
?>
