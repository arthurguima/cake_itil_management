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
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <b>
            <?php
              if(isset($aditivo))
                echo "Contrato: " . $aditivo['Contrato']['numero'] . " | Aditivo: " . $aditivo['Aditivo']['dt_inicio'];
              else
                echo "Contrato: " . $contrato['numero'];
            ?>
          </b>
        </div>
        <div class="panel-body ">
          <div class="table-responsive">
            <table class="table display table-striped table-bordered table-hover" id="dataTables-contrato">
              <thead>
                <tr>
                  <th>Item de Contrato</th>
                  <th>Volume Contratado</th>
                  <th>Volume Reservado</th>
                  <th>Volume Empenhado</th>
                  <th>Volume Utilizado</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($items as $item): ?>
                  <tr>
                    <td><?php echo $item['nome']; ?></td>
                    <td><?php echo $item['volume'] . " " . $item['metrica']; ?></td>
                    <td><?php echo $item['Reservado'] . " " . $item['metrica'] . ' (' . round(($item['Reservado']/$item['volume'])*100,2) .'%)'; ?></td>
                    <td><?php echo $item['Empenhado'] . " " . $item['metrica'] . ' (' . round(($item['Empenhado']/$item['volume'])*100,2) .'%)'; ?></td>
                    <td><?php echo $item['Utilizado'] . " " . $item['metrica'] . ' (' . round(($item['Utilizado']/$item['volume'])*100,2) .'%)'; ?></td>
                  </tr>
                <?php endforeach; ?>
                <?php unset($item); ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<div class="row">
  <?php
    foreach ($items as $key => $item){
      echo '<script>

        $(document).ready(function() {
          var chart = new CanvasJS.Chart("chartContainer'. $key .'", {

            title:{
              text: "' . $item['nome'] . '",
              fontSize: 20
            },
            data: [
              {
               type: "column",
               dataPoints: [
                 { label: "Volume Total", y: ' . $item['volume'] . '},
                 { label: "Reservado", y: ' . $item['Reservado'] . ' },
                 { label: "Empenhado", y: ' . $item['Empenhado'] . ' },
                 { label: "Utilizado", y: ' . $item['Utilizado'] . ' }
               ]
             }
            ],
            /** Set axisY properties here*/
            axisY:{
              suffix: "'. $item['metrica'] .'",
              valueFormatString: "### ### ###",
            },
            axisX:{
              labelFontSize: 12,
            }
           });

          chart.render();
        });
    </script>
    <div class="col-lg-4 chart-container" id="chartContainer'. $key .'" style="height: 350px; max-width: 450px;"></div>
      ';
    }
    unset($item);
  ?>
</div>

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

  // CanvasJs
  echo $this->Html->script('plugins/canvasjs/jquery.canvasjs.min.js');

  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
?>
