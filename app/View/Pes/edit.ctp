<?php
  $this->Html->addCrumb('PAs', '/Pees');
  $this->Html->addCrumb("Editar PA", "");
?>
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">
      Editar: <?php echo $this->data['Pe']['nome']?>
      <?php
          echo $this->Html->link("<i class='fa fa-search-plus'></i>",
          array('controller' => 'Pes', 'action' => 'view', $this->data['Pe']['id']),
          array('escape' => false));
      ?>
    </h3>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <?php echo $this->BootstrapForm->create('Pe'); ?>
    <div class="col-lg-6">
      <?php
        /*echo $this->BootstrapForm->input('nome', array(
                    'label' => array('text' => 'Nome: ')));*/

        echo $this->BootstrapForm->input('numero', array(
                    'label' => array('text' => 'Número: ')));

        echo $this->BootstrapForm->input('ano', array(
                   'label' => array('text' => 'Ano: '),
                   'type' => 'text',
                   'id' => 'dpdecade'));

        echo $this->BootstrapForm->input('num_ce', array(
                    'label' => array('text' => 'Número da CE de envio: ')));

        echo $this->BootstrapForm->input('dt_emissao', array(
                   'label' => array('text' => 'Data de Emissão: '),
                   'type' => 'text',
                   'id' => 'dp'));

        echo $this->BootstrapForm->input('dt_inicio', array(
                   'label' => array('text' => 'Data de Início: '),
                   'type' => 'text',
                   'id' => 'dp'));

        echo $this->BootstrapForm->input('temp_estimado', array(
                    'label' => array('text' => 'Tempo estimado em dias: ')));

        echo $this->BootstrapForm->input('cvs_url', array(
                    'label' => array('text' => 'Url: ')));

        echo $this->BootstrapForm->input('observacao', array(
                    'label' => array('text' => 'Observação: '),
                    'type' => 'textarea'));

        echo $this->BootstrapForm->input('id');
      ?>
    </div>
    <div class="col-lg-6">
      <?php
        echo $this->BootstrapForm->input('responsavel', array(
                    'label' => array('text' => 'Responsável: ')));

        echo $this->BootstrapForm->input('status_id', array(
                  'label' => array('text' => 'Status: ')));

        echo $this->BootstrapForm->input('contrato', array(
                'label' => array('text' => 'Contrato: '),
                'input' => 'text',
                'multiple' => "false",
                'options' => $contratos));
      ?>

      <div id="aditivoList"></div>
      <div id="itemList"></div>

      <?php echo $this->BootstrapForm->input('valor_item', array('label' => array('text' => 'Volume Utilizado: '))); ?>
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
  /* Lista de Itens */
    function getItens(tipo, id){
      $.ajax({
        url: <?php echo "'" . Router::url('/', true) . "'"; ?> + "items/optionlist?controller=Pe&tipo=" + tipo + "&id=" + id,
        cache: false,
        success: function(html){
          $("#itemList").html(html);
        }
      })
    }

  /* Lista de Aditivos */
    function getAditivos(contrato){
      $.ajax({
        url: <?php echo "'" . Router::url('/', true) . "'"; ?> + "aditivos/optionlist?controller=Pe&contrato=" + contrato,
        cache: false,
        success: function(html){
          $("#aditivoList").html(html);
        }
      });
    }

  $(document).ready(function() {
    $('#myModal').on('shown.bs.modal', function (e) {
      document.getElementById('modal-body').appendChild(
          document.getElementById('demandaFrame')
      );
      document.getElementById('demandaFrame').style.display = "block";
      //document.getElementById('demandaFrame').style.height = "720px";
    });

    // Quando selecionado o Contrato
    $( "select#PeContrato" ).change(function () {
      var str = "";
      $( "select#PeContrato option:selected" ).each(function() {
         getItens("Contrato", $(this).val());
         getAditivos($(this).val());
      })
    }).change();

    // Quando selecionado o Aditivo
    $(document).on('change', $("select#AditivoAditivo"), function () {
      var str = "";
      $("select#AditivoAditivo option:selected").each(function() {
         if($(this).val() != "Aditivo"){
          getItens("Aditivo", $(this).val());
         }
      })
    });

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

    // Quando selecionado o Servico
    $( "select#PeServicoId" ).change(function () {
      var str = "";
      $( "select#PeServicoId option:selected" ).each(function() {
         getDemandas($(this).val()); //passa o valor do item do select selecionado
      })
    }).change();
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
