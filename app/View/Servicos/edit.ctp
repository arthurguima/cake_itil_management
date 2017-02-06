<?php
  $this->Html->addCrumb('Serviços', '/servicos');
  $this->Html->addCrumb($this->data['Servico']['sigla'], array('controller' => 'servicos', 'action' => 'edit', $this->data['Servico']['id']));
?>
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">
      Editar Serviço <?php //echo ": " . $this->data['Servico']['sigla']; ?>
      <?php
          echo $this->Html->link("<i class='fa fa-search-plus'></i>",
          array('controller' => 'Servicos', 'action' => 'view', $this->data['Servico']['id']),
          array('escape' => false));
      ?>
    </h3>
  </div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
        echo $this->BootstrapForm->create('Servico');
        //echo $this->BootstrapForm->hidden('last_edit_by', array('value' => $_SESSION['User.uid'], 'type'=> "hidden"));

        echo $this->BootstrapForm->input('nome', array(
                    'label' => array('text' => 'Nome:')));

         echo $this->BootstrapForm->input('sigla', array(
                    'label' => array('text' => 'Sigla:')));

        echo $this->BootstrapForm->input('url', array(
                    'label' => array('text' => 'URL:')));

         echo $this->BootstrapForm->input('tecnologia', array(
                    'label' => array('text' => 'Tecnologia:')));

        echo $this->BootstrapForm->input('cliente_id', array(
                   'label' => array('text' => 'Cliente:')));

       echo $this->BootstrapForm->input('id_clarity', array(
                 'label' => array('input' => 'text', 'text' => 'Identificador Clarity:')));

       echo $this->BootstrapForm->input('id_sdm', array(
                  'label' => array('input' => 'text', 'text' => 'Identificador SDM:')));

         echo $this->BootstrapForm->input('Area', array(
                    'label' => array('text' => 'Área(s):'),
                    'input' => 'text',
                    'multiple' => "true",
                    'options' => $areas));

         echo $this->BootstrapForm->input('Dependencia', array(
                    'label' => array('text' => 'Dependência(s):'),
                    'input' => 'text',
                    'multiple' => "true",
                    'options' => $dependencias));

        echo $this->BootstrapForm->input('responsavel_id', array(
                   'class' => 'select2',
                   'label' => array('text' => 'Lider Responsável: '),
                   'empty' => "Responsável",
                   'options' => $users));

         echo $this->BootstrapForm->input('status', array(
                    'checked' => 'checked',
                    'class' => 'col-sm-3 pull-left col-sm-offset-3',
                    'label' => array(
                      'text' => 'Ativo?',
                      'class' => 'control-label col-sm-2')));


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
    $("[id*='dp']").datetimepicker({
      format: "yyyy-mm-dd",
      autoclose: true,
      todayBtn: true,
      language: 'pt'
    });

    $('.select2').select2({
      language: "pt-BR",
      theme: "bootstrap"
    });

    $('#AreaArea').select2({
      language: "pt-BR",
      theme: "bootstrap"
    });
    $('#DependenciaDependencia').select2({
      language: "pt-BR",
      theme: "bootstrap"
    });
  });
</script>

<?php
  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');

  //-- Select2 --
  echo $this->Html->script('plugins/select2/select2.full.min');
  echo $this->Html->css('plugins/select2.min');
  echo $this->Html->css('plugins/select2-bootstrap.min');
  echo $this->Html->script('plugins/select2/pt-BR');
?>
