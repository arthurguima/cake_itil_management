<?php
  $this->Html->addCrumb('OS', '/ords');
  $this->Html->addCrumb("Editar OS", "");
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Editar OS</h3></div>
</div>

<div class="row">
  <div class="col-lg-12">
    <?php echo $this->BootstrapForm->create('Ord'); ?>
    <div class="col-lg-6">
      <?php
        echo $this->BootstrapForm->input('nome', array(
                    'label' => array('text' => 'Nome: ')));

        echo $this->BootstrapForm->input('numero', array(
                    'label' => array('text' => 'Número: ')));

        echo $this->BootstrapForm->input('ano', array(
                  'label' => array('text' => 'Ano: '),
                  'type' => 'text',
                  'id' => 'dpdecade',
                  'value' => date('Y')));

        echo $this->BootstrapForm->input('cvs_url', array(
                    'label' => array('text' => 'Url: ')));

        echo $this->BootstrapForm->input('pf', array(
                    'label' => array('text' => 'Quantidade de pontos de função: ')));

        echo $this->BootstrapForm->input('responsavel', array(
                              'label' => array('text' => 'Responsável: ')));

        echo $this->BootstrapForm->input('pe_id', array(
                    'label' => array('text' => 'PE: ')));
      ?>
    </div>
    <div class="col-lg-6">
      <?php
        echo $this->BootstrapForm->input('dt_emissao', array(
                  'label' => array('text' => 'Data de Emissão: '),
                  'type' => 'text',
                  'id' => 'dp'));

        echo $this->BootstrapForm->input('dt_recebimento', array(
                  'label' => array('text' => 'Data de Recebimento: '),
                  'type' => 'text',
                  'id' => 'dp'));

        echo $this->BootstrapForm->input('dt_deploy_homologacao', array(
                  'label' => array('text' => 'Deploy Homologação: '),
                  'type' => 'text',
                  'id' => 'dp'));

        echo $this->BootstrapForm->input('dt_deploy_producao', array(
                  'label' => array('text' => 'Deploy Produção: '),
                  'type' => 'text',
                  'id' => 'dp'));

        echo $this->BootstrapForm->input('dt_homologacao', array(
                  'label' => array('text' => 'Data de Homologação: '),
                  'type' => 'text',
                  'id' => 'dp'));

        echo $this->BootstrapForm->input('status_id', array(
                    'label' => array('text' => 'Status: ')));

        echo $this->BootstrapForm->input('id');
      ?>
    </div>
  </div>
  <div class="form-footer col-lg-12 col-md-6 pull-right">
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
    $("[id*='dpdecade']").datetimepicker({
      format: "yyyy",
        startView: "decade",
        minView: "decade",
        maxView: "decade",
        viewSelect: "decade",
        autoclose: true,
        language: 'pt-BR'
    });

    $("[id*='dp']").datetimepicker({
      format: "dd/mm/yyyy",
        minView: 2,
        autoclose: true,
        todayBtn: true,
        language: 'pt-BR'
    });
  });
</script>

<?php
  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
?>
