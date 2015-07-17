<?php
  $this->Html->addCrumb('Demandas', '/demandas');
  $this->Html->addCrumb('Atualizar', '');
?>
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">
      Atualizar Demanda
      <?php
          echo $this->Html->link("<i class='fa fa-search-plus'></i>",
          array('controller' => 'Demandas', 'action' => 'view', $this->data['Demanda']['id']),
          array('escape' => false));
      ?>
    </h3>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <?php echo $this->BootstrapForm->create('Demanda'); ?>
    <div class='col-lg-6'>
      <?php
        echo $this->BootstrapForm->input('clarity_url', array(
                   'label' => array('text' => 'URL do Clarity: '),
                   'type' => 'text',
                   'onblur' =>"getID('DemandaClarity');",
                   'value' => "http://www-dtpprojetos/niku/nu#action:pma.ideaProperties&id=" . $this->data['Demanda']['clarity_id'])); ?>

         <div class="form-group required">
           <label for="DemandaClarityId" class="control-label col-lg-3">Clarity ID: </label>
           <div class="col-lg-9">
              <div class='input-group'>
                <input name="data[Demanda][clarity_id]" style="background-color: #EEEEEE;" class="form-control" type="text" required="required" id="DemandaClarityId"
                value=
                <?php echo ("'" . $this->data['Demanda']['clarity_id'] . "'>"); ?>
                <span class='input-group-addon'>
                  <a id='viewClarity' data-toggle='modal' data-target='#myModal'>
                    <i class='fa-expand fa' style='cursor:pointer;' title='Clique aqui para testar a integração da demanda com o sistema Clarity!'></i>
                  </a>
                </span>
              </div>
           </div>
        </div>

        <?php

         echo $this->BootstrapForm->input('clarity_dm_id', array(
                    'label' => array('text' => 'DM Clarity: '),
                    'type' => 'text'));

         echo $this->BootstrapForm->input('mantis_id', array(
                    'label' => array('text' => 'Nº Mantis: '),
                    'type' => 'text'));

         echo $this->BootstrapForm->input('nome', array(
                    'label' => array('text' => 'Nome: '),
                    'type' => 'text'));


         echo $this->BootstrapForm->input('user_id', array(
               'class' => 'select2',
               'label' => array('text' => 'Responsável: '),
               'empty' => "Responsável"));

         echo $this->BootstrapForm->input('executor', array(
                     'label' => array('text' => 'Solicitante: ')));

         echo $this->BootstrapForm->input('prioridade', array(
                    'label' => array('text' => 'Prioridade: ')));


         echo $this->BootstrapForm->input('descricao', array(
                     'label' => array('text' => 'Descrição: '),
                     'type' => 'textarea'));
      ?>
    </div>
    <div class='col-lg-6'>
      <?php
        echo $this->BootstrapForm->input('demanda_tipo_id', array(
                    'label' => array('text' => 'Tipo da Demanda: ')));

        echo $this->BootstrapForm->input('servico_id', array(
                   'label' => array('text' => 'Serviço: ')));

        echo $this->BootstrapForm->input('status_id', array(
                   'label' => array('text' => 'Status: ')));

        echo $this->BootstrapForm->input('data_cadastro', array(
                  'label' => array('text' => 'Data de Cadastro: '),
                  'type' => 'text',
                  'id' => 'dp '));

        echo $this->BootstrapForm->input('dt_prevista', array(
                  'label' => array('text' => 'Previsão de Término: '),
                  'type' => 'text',
                  'id' => 'dp '));

        echo $this->BootstrapForm->input('data_homologacao', array(
                  'label' => array('text' => 'Data de Homologação: '),
                  'type' => 'text',
                  'id' => 'dp '));

        $options = array( 1 => 'Sim', 0 => 'Não');
        echo $this->BootstrapForm->input('origem_cliente', array(
                   'label' => array('text' => 'Solicitada pelo Cliente?: '),
                   'options' => $options));
      ?>
    </div>
      <?php echo $this->BootstrapForm->input('id'); ?>

    <div class="form-footer col-lg-12 col-md-6 pull-right">
      <?php
        echo $this->BootstrapForm->submit('Salvar');
        echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-lg-3 col-md-6'));
        echo $this->Form->end();
      ?>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body" id="modal-body">
      </div>
    </div>
  </div>
</div>
<iframe id="demandaFrame" style="display:none;" name='demanda' width='100%' height='720px' frameborder='0'></iframe>

<script>
  $(document).ready(function() {
    $('.select2').select2({
      containerCssClass: 'select2'
    });

    $("[id*='dp']").datetimepicker({
      format: "dd/mm/yyyy",
        minView: 2,
        autoclose: true,
        todayBtn: true,
        language: 'pt-BR'
    });

    $('#myModal').on('shown.bs.modal', function (e) {
      getIDOnEdit(<?php echo $this->data['Demanda']['clarity_id'] ?>);

      document.getElementById('modal-body').appendChild(
          document.getElementById('demandaFrame')
      );
      document.getElementById('demandaFrame').style.display = "block";
      //document.getElementById('demandaFrame').style.height = "720px";
    })

  });
</script>

<?php
  //-- ClarityID
  echo $this->Html->script('getIdClarity.js');

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
