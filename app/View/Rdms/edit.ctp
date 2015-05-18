<?php
  $this->Html->addCrumb('RDM', '/rdms');
  $this->Html->addCrumb("Editar RDM", "");
?>
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">
      Editar RDM
      <?php
          echo $this->Html->link("<i class='fa fa-search-plus'></i>",
          array('controller' => 'Rdms', 'action' => 'view', $this->data['Rdm']['id']),
          array('escape' => false));
      ?>
    </h3>
  </div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Rdm');

      echo $this->BootstrapForm->input('nome', array(
                  'label' => array('text' => 'Nome: ')));

      echo $this->BootstrapForm->input('responsavel', array(
                 'label' => array('text' => 'Responsável: ')));

      echo $this->BootstrapForm->input('numero', array(
                  'label' => array('text' => 'Número: ')));

      echo $this->BootstrapForm->input('versao', array(
                 'label' => array('text' => 'Versão/Fase/TAG: ')));

      ?>

      <div class="form-group">
        <label for="RdmAmbiente" class="col-lg-3 control-label">Ambiente: </label>
        <div class="col-lg-9">
          <select name="data[Rdm][ambiente]" class="form-control" id="filterambiente">
            <option value="1" <?php if($this->data['Rdm']['ambiente'] == 1) echo 'selected="selected"'; ?>>Homologação</option>
            <option value="2" <?php if($this->data['Rdm']['ambiente'] == 2) echo 'selected="selected"'; ?>>Produção</option>
            <option value="3" <?php if($this->data['Rdm']['ambiente'] == 3) echo 'selected="selected"'; ?>>Treinamento</option>
            <option value="3" <?php if($this->data['Rdm']['ambiente'] == 4) echo 'selected="selected"'; ?>>Sustentação</option>
          </select>
        </div>
      </div>

      <?php
        echo $this->BootstrapForm->input('rdm_tipo_id', array(
                    'label' => array('text' => 'Tipo da RDM: ')));

        echo $this->BootstrapForm->input('dt_prevista', array(
                    'label' => array('text' => 'Data prevista: '),
                    'type' => 'text',
                    'id' => 'dp '));

        echo $this->BootstrapForm->input('dt_executada', array(
                    'label' => array('text' => 'Data de execução: '),
                    'type' => 'text',
                    'id' => 'dp '));

        ?>

       <div class="form-group">
         <label for="RdmSucesso" class="col-lg-3 control-label">Concluída?: </label>
         <div class="col-lg-9">
           <select name="data[Rdm][sucesso]" class="form-control" id="filtersucesso">
             <option  value="-1">Concluída?</option>
             <option value="0" <?php if($this->data['Rdm']['sucesso'] == 0) echo 'selected="selected"'; ?>>Não</option>
             <option value="1" <?php if($this->data['Rdm']['sucesso'] == 1) echo 'selected="selected"'; ?>>Sim</option>
             <option value="2" <?php if($this->data['Rdm']['sucesso'] == 2) echo 'selected="selected"'; ?>>Cancelada</option>
           </select>
         </div>
       </div>

       <?php

        echo $this->BootstrapForm->input('Demanda', array(
                    'label' => array('text' => 'Demanda(s): '),
                    'input' => 'text',
                    'multiple' => "true",
                    'options' => $demandas));

        echo $this->BootstrapForm->input('observacao', array(
                    'label' => array('text' => 'Observação: '),
                    'type' => 'textarea'));

        echo $this->BootstrapForm->input('id');
      ?>

    <div id="demandaList"></div>

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
      format: "dd/mm/yyyy",
        minView: 2,
        autoclose: true,
        todayBtn: true,
        language: 'pt-BR'
    });

    $('#DemandaDemanda').select2();
  });
</script>

<?php
  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');

  //-- Select2 --
  echo $this->Html->script('plugins/select2/select2.min');
  echo $this->Html->css('plugins/select2');
  echo $this->Html->script('plugins/select2/select2_locale_pt-BR');
  echo $this->Html->css('plugins/select2-bootstrap');
?>
