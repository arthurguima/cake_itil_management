<?php
  $this->Html->addCrumb("Relatórios", '');
  $this->Html->addCrumb("Demandas Atrasadas", '/relatorios/dematrasadas');
?>

<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">
      Demandas Internas Atrasadas
      <span style="cursor:pointer;" onclick="javascript:$('div.panel-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
    </h3>
    <div class="col-lg-12 pull-left filters">
      <div class="">
        <div class="row">
          <span class="filter-show col-lg-2" style="cursor:pointer;" onclick="javascript:$('.filters > div > .inner').toggle();">
            Filtros <i class="fa fa-plus-square"></i>
          </span>
        </div>
        <div class="row inner">
          <?php  echo $this->BootstrapForm->create(false, array('class' => 'form-inline')); ?>
          <div class="col-lg-12">
            <div class="form-group">
              <?php
                  echo $this->BootstrapForm->input('cliente_id', array(
                              'label' => array('text' => 'Cliente: '),
                              'class' => 'select2 form-control',
                              'empty' => 'Cliente'));

                  $options = array( 1 => 'Sim', 0 => 'Não');
                  echo $this->BootstrapForm->input('origem_cliente', array(
                              'label' => array('text' => 'Solicitada pelo Cliente?: '),
                              'empty' => 'Solicitada pelo Cliente',
                              'options' => $options));

                  echo $this->BootstrapForm->input('demanda_tipo_id', array(
                              'label' => array('text' => 'Tipo da Demanda: '),
                              'empty' =>  'Tipo'));

                  echo $this->BootstrapForm->input('user_id', array(
                         'class' => 'select2',
                         'label' => array('text' => 'Responsável: '),
                         'selected' => $this->Session->read('User.uid'),
                         'empty' => "Responsável"));
              ?>
            </div>
          </div>
          <?php
            echo $this->BootstrapForm->button("Filtrar <i class='fa fa-search'></i>", array('type' => 'submit', 'class' => 'control-label btn btn-default pull-right'));
            echo $this->BootstrapForm->end();
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if(isset($this->request->data['cliente_id'])): ?>
<?php $var = 0; foreach ($atrasos as $key => $atras): ?>
  <div class="row">
    <div class="col-lg-12 demandas delete-<?php echo $var; ?>">
      <div class="panel panel-default">
        <div class="panel-heading">
          <b>
            <?php echo $key; ?>
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.hide-<?php echo $var; ?>').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
            <span style="cursor:pointer;" onclick="javascript:$('div.delete-<?php echo $var; ?>').remove();"><i class="fa fa-trash-o pull-right"></i></span>
            <span style="cursor:pointer;" onclick="javascript:$('div.demandas').not('div.delete-<?php echo $var; ?>').remove();"><i class="fa fa-binoculars pull-right"></i></span>
          </b>
        </div>
        <div class="panel-body hide-<?php echo $var; ?>">
          <div class="table-responsive">
            <table class="table display table-striped table-bordered table-hover" id="dataTables-<?php echo $var; ?>">
              <thead>
                <tr>
                  <th>Serviço</th>
                  <th>Demanda</th>
                  <th>Nome</th>
                  <th>Tipo</th>
                  <th>Status</th>
                  <th>Data de Cadastro</th>
                  <th/>Data Prevista</th>
                  <th>Dias em Atraso</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($atras as $dem): ?>
                  <tr>
                    <td><?php echo $dem['Servico']['sigla']; ?></td>
                    <td style="cursor:pointer;" title="Clique para abrir a demanda no Clarity!">
                      <?php
                        echo "<a id='viewClarity' data-toggle='modal' data-target='#myModal' onclick='javascript:indexClarity(" .
                              $dem['Demanda']['clarity_id'] .")'>" . $dem['Demanda']['clarity_dm_id'] ."</a></span>"
                      ?>
                    </td>
                    <td><?php echo $this->html->link($dem['Demanda']['nome'], array('controller'=> 'demandas', 'action' => 'view', $dem['Demanda']['id'])); ?></td>
                    <td>
                      <span style="border-bottom: 3px solid #<?php echo substr(md5($dem['DemandaTipo']['nome']), 0, 6) ?>;">
                        <?php echo $dem['DemandaTipo']['nome']; ?>
                      </span>
                    </td>
                    <td><?php echo $dem['Status']['nome']; ?></td>
                    <td><?php echo $dem['Demanda']['data_cadastro']; ?></td>
                    <td><?php echo $dem['Demanda']['dt_prevista']; ?></td>
                    <td class="text-center"><?php echo $this->Times->timeLeftTo_days($dem['Demanda']['dt_prevista']);?></td>
                  </tr>
                <?php endforeach; ?>
                <?php unset($dem); ?>
              </tbody>
            </table>
          </div>
        </div>
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
      var  oTable<?php echo $var; ?> =   $('#dataTables-<?php echo $var; ?>').dataTable({
          "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            language: {
              url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
            },
          //  responsive: true,
            "dom": 'TC<"clear">lfrtip',
            "colVis": {
              "buttonText": "Esconder Colunas"
            },
            "tableTools": {
                "sSwfPath": "<?php echo Router::url('/', true);?>/js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                  {
                      "sExtends": "copy",
                      "sButtonText": "Copiar",
                      "oSelectorOpts": { filter: 'applied', order: 'current' },
                      "mColumns": "visible",
                  },
                  {
                      "sExtends": "print",
                      "sButtonText": "Imprimir",
                      "oSelectorOpts": { filter: 'applied', order: 'current' },
                      //"mColumns": [ 0,1,2,3,4,5,6,7 ]
                  },
                  {
                      "sExtends": "csv",
                      "sButtonText": "CSV",
                      "sFileName": "Demandas(<?php echo $key; ?>).csv",
                      "oSelectorOpts": { filter: 'applied', order: 'current' },
                      "mColumns": "visible",
                  },
                  {
                      "sExtends": "pdf",
                      "sButtonText": "PDF",
                      "sFileName": "Demandas(<?php echo $key; ?>).pdf",
                      "oSelectorOpts": { filter: 'applied', order: 'current' },
                      "mColumns": "visible",
                      "sPdfOrientation": "landscape",
                      "sTitle": "Demandas(<?php echo $key; ?>)",
                      "sPdfMessage": "Extraído em: <?php echo date('d/m/y')?>",
                  },
                ]
            },
        });
        var colvis = new $.fn.dataTable.ColVis( oTable<?php echo $var; ?> );

        $('#myModal').on('shown.bs.modal', function (e) {
          document.getElementById('modal-body').appendChild(
              document.getElementById('demandaFrame')
          );
          document.getElementById('demandaFrame').style.display = "block";
          //document.getElementById('demandaFrame').style.height = "720px";
        });
    });
  </script>
<?php $var++; endforeach; ?>
<?php unset($atras); ?>
<?php endif; ?>

<script>
$(document).ready(function() {
  $('.select2').select2({
    containerCssClass: 'select2'
  });
});
</script>

<?php
  //-- ClarityID
  echo $this->Html->script('getIdClarity.js');

  //-- DataTables JavaScript --
  echo $this->Html->script('plugins/dataTables/media/js/jquery.dataTables.js');
  echo $this->Html->script('plugins/dataTables/dataTables.bootstrap.js');
  echo $this->Html->css('plugins/dataTables.bootstrap.css');
  //-- DataTables --> TableTools
  echo $this->Html->script('plugins/dataTables/extensions/TableTools/js/dataTables.tableTools.min.js');
  echo $this->Html->css('plugins/dataTablesExtensions/TableTools/css/dataTables.tableTools.min.css');
  //-- DataTables --> Responsive
  echo $this->Html->script('plugins/dataTables/extensions/Responsive/js/dataTables.responsive.min.js');
  echo $this->Html->css('plugins/dataTablesExtensions/Responsive/css/dataTables.responsive.css');
  //-- DataTables --> ColVis
    echo $this->Html->script('plugins/dataTables/extensions/ColVis/js/dataTables.colVis.min.js');
    echo $this->Html->css('plugins/dataTablesExtensions/ColVis/css/dataTables.colVis.min.css');
    echo $this->Html->css('plugins/dataTablesExtensions/ColVis/css/dataTables.colvis.jqueryui.css');

  //-- Select2 --
  echo $this->Html->script('plugins/select2/select2.min');
  echo $this->Html->css('plugins/select2');
  echo $this->Html->script('plugins/select2/select2_locale_pt-BR');
  echo $this->Html->css('plugins/select2-bootstrap');
?>
