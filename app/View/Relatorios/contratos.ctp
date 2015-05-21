<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
        Contrato
      </h3>
    </div>
  <div class="col-lg-12 pull-left filters">
    <div class="">
      <div class="row"><span class="filter-show col-lg-2" style="cursor:pointer;" onclick="javascript:$('.filters > div > .inner').toggle();">Filtros <i class="fa fa-plus-square"></i></span></div>
      <div class="row inner">
        <?php  echo $this->BootstrapForm->create(false, array('class' => 'form-inline')); ?>
        <div class="col-lg-12 filters-item">
          <div class="form-group" style="float:left;">
            <?php echo $this->BootstrapForm->input('cliente_id', array(
                              'label' => array('text' => 'Cliente: '),
                              'class' => "form-control pull-right")); ?>
          </div>
          <div id="contratoList" style="float:left;"></div>
          <div id="aditivoList" style="float:left;"></div>
          <!--div id="itemList"></div-->
        </div>
        <?php
          echo $this->BootstrapForm->button("Filtrar <i class='fa fa-search'></i>", array('type' => 'submit', 'class' => 'control-label btn btn-default pull-right'));
          echo $this->BootstrapForm->end();
        ?>
      </div>
    </div>
  </div>
</div>

<?php if($this->request->data != null): ?>
  <?php debug($this->request->data); debug($items) ?>

<?php endif; ?>

<script>

/* Lista de Contratos */
  function getContratos(cliente){
    $.ajax({
      url: <?php echo "'" . Router::url('/', true) . "'"; ?> + "contratos/optionlist?controller=relatorios&cliente=" + cliente,
      cache: false,
      success: function(html){
        $("#contratoList").html(html);

        //QUando o contrato é resgatado com sucesso trago a lista de aditivos
        $( "select#ContratoContrato" ).change(function () {
          var str = "";
          $( "select#ContratoContrato option:selected" ).each(function() {
             getAditivos($(this).val());
          })
        }).change();
      }
    });
  }

/* Lista de Aditivos */
  function getAditivos(contrato){
    $.ajax({
      url: <?php echo "'" . Router::url('/', true) . "'"; ?> + "aditivos/optionlist?controller=relatorios&contrato=" + contrato,
      cache: false,
      success: function(html){
        $("#aditivoList").html(html);
      }
    });
  }

  $(document).ready(function() {
    // Quando selecionado o Contrato
    $( "select#ContratoContrato" ).change(function () {
      var str = "";
      $( "select#ContratoContrato option:selected" ).each(function() {
         getAditivos($(this).val());
      })
    }).change();

    $( "select#cliente_id" ).change(function () {
      var str = "";
      $( "select#cliente_id option:selected" ).each(function() {
         getContratos($(this).val());
      })
    }).change();
  });
</script>


<?php
  // Circliful
  echo $this->Html->script('plugins/circliful/js/jquery.circliful.js');
  echo $this->Html->css('plugins/jquery.circliful.css');

  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
?>
