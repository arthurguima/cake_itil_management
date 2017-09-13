<?php
  $this->Html->addCrumb('Relatorios', '');
  $this->Html->addCrumb('Ss', '');
  $this->Html->addCrumb('Gestão de Ss', '/gsses');
?>

<div class="col-lg-12 page-header-box">
    <div class="col-lg-12">
      <h3 class="page-header">
         SS - Gestão de Ideias
         <div class="col-lg-2 pull-right">
           <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus'></i> Nova",
                array('controller' => 'sses', 'action' => 'add'),
                array('class' => 'btn btn-sm btn-success pull-right', 'escape' => false));
              }
           ?>
         </div>
      </h3>
    </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading"><b> Lista de SS </b></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-ss">
            <thead>
              <tr>
                <th>Servico</th>
                <th class="hidden-xs hidden-sm">DM Clarity <i class='fa-expand fa' style="font-size: 15px !important;"></i></th>
                <th>Número</th>
                <th>Nome <i class="fa fa-comment-o" style="font-size: 15px !important;"></th>
                <th>Nome</th>
                <th class="hidden-xs hidden-sm"><span class="editable">Status</span></th>
                <th class="hidden-xs hidden-sm">CheckList <i class='fa-external-link-square fa' style="font-size: 15px !important;"></th>
                <th>Entrega da PA</th>
                <th>Validade do PDD</th>
                <th>C. Inicial</th>
                <th>DHI</th>
                <th>DHC</th>
                <th>C. Final</th>
                <th>Termos</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($sses as $ss): ?>
                <tr>
                  <td><?php echo $ss['Servico']['sigla']; ?></td>
                  <td class="hidden-xs hidden-sm" style="cursor:pointer;" title="Clique para abrir a demanda no Clarity!">
                      <?php echo "<a id='viewClarity' data-toggle='modal' data-target='#myModal' onclick='javascript:indexClarity(" .
                                 $ss['Ss']['clarity_id'] .")'>" . $ss['Ss']['clarity_dm_id'] ."</a></span>" ?>
                  </td>

                  <td data-order=<?php echo $ss['Ss']['ano'] . $ss['Ss']['numero']; ?>>
                    <?php echo $ss['Ss']['numero'] . "/" . $ss['Ss']['ano'] ; ?>
                  </td>
                  <td><?php echo $this->Tables->popupBox($ss['Ss']['nome'], $ss['Ss']['observacao']) ?></td>
                  <td><?php echo $ss['Ss']['nome']; ?></td>

                  <td class="hidden-xs hidden-sm">
                    <span style="cursor:pointer;" title="Clique para alterar o status!" id="<?php echo "status-" . $ss['Ss']['id'] ?>">
                    <?php echo $ss['Status']['nome']; ?></span>
                  </td>
                  <?php echo $this->Tables->SsStatusEditable($ss['Ss']['id']) ?>

                  <td class="checklist hidden-xs hidden-sm"><?php echo $this->Ss->getCheckList($ss['Ss']['dv'], $ss['Ss']['contagem']) ?></td>
                  <td class="text-center">
                    <?php echo $this->Times->timeLeftTo($ss['Ss']['dt_recebimento'], $ss['Ss']['dt_prazo'],
                             $ss['Ss']['dt_recebimento'] . " - " . $ss['Ss']['dt_prazo'],
                            ($ss['Ss']['dt_finalizada']));
                    ?>
                  </td>

                  <td class="clean-list">
                    <?php
                      foreach($ss['Pe'] as $pe){
                        if($pe['validade_pdd'] != null){
                          echo "<li>" . $pe['numero'] . "/" . $pe['ano'] . " - " . $this->Times->pastDate($pe['validade_pdd']) . "</li>";
                        }
                      }
                      unset($pe);
                    ?>
                  </td>
                  <td class="clean-list">
                    <?php
                      foreach($ss['Pe'] as $pe){
                        foreach($pe['ItemPe'] as $item):
                          echo "<li>" . $item['volume'] . '/' . $item['Item']['metrica'] . "</li>";
                        endforeach;
                        unset($item);
                      }
                      unset($pe);
                    ?>
                  </td>

                  <td class="clean-list">
                    <?php
                      foreach($ss['Ord'] as $os){
                        echo "<li>" . $this->Times->timeLeftTo($os['dt_ini_pdd'], $os['dt_homo_prev_int'],
                                  $os['dt_ini_pdd'] . " - " . $os['dt_homo_prev_int'], ($os['dt_homo_prev'])) ."</li>";
                      }
                      unset($os);
                    ?>
                  </td>

                  <td class="clean-list">
                    <?php
                      foreach($ss['Ord'] as $os){
                        echo "<li>" . $this->Times->timeLeftTo($os['dt_ini_pdd'], $os['dt_fim_pdd'],
                                  $os['dt_ini_pdd'] . " - " . $os['dt_fim_pdd'], ($os['dt_homologacao'])) ."</li>";
                      }
                      unset($os);
                    ?>
                  </td>

                  <td class="clean-list">
                    <?php
                      foreach($ss['Ord'] as $os){
                        foreach($os['ItemPe'] as $item):
                          echo "<li>" . $item['volume'] . '/' . $item['ItemPePai']['Item']['metrica'] . "</li>";
                        endforeach;
                        unset($item);
                      }
                      unset($pe);
                    ?>
                  </td>

                  <td class="clean-list checklist">
                    <?php
                      foreach($ss['Ord'] as $os){
                        echo "<li>" . $this->Ord->getCheckList($os['ths'], $os['trp'], $os['trd']) . "<br />";
                        if(isset($os['dt_homologacao']))
                          echo $this->Ord->PrazocheckList($os['dt_homologacao'], $os['trp'], $os['dt_recebimento_termo_prov'],
                              $os['ths'], $os['dt_recebimento_homo'], $os['trd'], $os['dt_recebimento_termo']) . "</li>";
                      }
                      unset($pe);
                    ?>
                  </td>

                  <td>
                    <?php
                      echo $this->Tables->getMenu('sses', $ss['Ss']['id'], 2);
                      echo "<a id='viewHistorico' data-toggle='modal' data-target='#Historico' onclick='javascript:historico(" . $ss['Ss']['id'] . ")'>
                        <i class='fa fa-history' style='margin-left: 5px;' title='Visualizar histórico'></i></a></span>";
                    ?>
                  </td>
                </tr>
              <?php endforeach; ?>
              <?php unset($ss); ?>

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

<div class="modal fade" id="Historico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body" id="modal-body">
        <iframe id="historicoFrame" name='demanda' width='100%' height='720px' frameborder='0'></iframe>
      </div>
    </div>
  </div>
</div>

<?php
  //-- ClarityID
    echo $this->Html->script('getIdClarity.js');

  //-- DataTables JavaScript -->
    echo $this->Html->script('plugins/dataTables/media/js/jquery.dataTables.js');
    echo $this->Html->script('plugins/dataTables/dataTables.bootstrap.js');
    echo $this->Html->css('plugins/dataTables.bootstrap.css');
    //-- DataTables --> TableTools
      echo $this->Html->script('plugins/dataTables/extensions/TableTools/js/dataTables.tableTools.min.js');
      echo $this->Html->css('plugins/dataTablesExtensions/TableTools/css/dataTables.tableTools.min.css');
    //-- DataTables --> ColVis
      echo $this->Html->script('plugins/dataTables/extensions/ColVis/js/dataTables.colVis.min.js');
      echo $this->Html->css('plugins/dataTablesExtensions/ColVis/css/dataTables.colVis.min.css');
      echo $this->Html->css('plugins/dataTablesExtensions/ColVis/css/dataTables.colvis.jqueryui.css');

  //Select2
    echo $this->Html->script('plugins/select2/select2.min');
    echo $this->Html->script('plugins/select2/select2_locale_pt-BR');
    echo $this->Html->css('plugins/select2');
    echo $this->Html->css('plugins/select2-bootstrap');

  //-- Jeditable
    echo $this->Html->script('plugins/jeditable/jquery.jeditable.js');
?>

<script>
  $(document).ready(function() {
    $('#myModal').on('shown.bs.modal', function (e) {
      document.getElementById('modal-body').appendChild(
          document.getElementById('demandaFrame')
      );
      document.getElementById('demandaFrame').style.display = "block";
      //document.getElementById('demandaFrame').style.height = "720px";
    });

    $('[data-toggle="popover"]').popover({trigger: 'hover','placement': 'right', html: 'true'});

  var  oTable =  $('#dataTables-ss').dataTable({
      "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
        language: {
          url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
        },
        "columnDefs": [  { "visible": false, "targets": 4 } ],
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
                  "mColumns": [ 0,1,2,4,5,6,7,8,9,10,11,12,13 ]
              },
              {
                  "sExtends": "print",
                  "sButtonText": "Imprimir",
                  "oSelectorOpts": { filter: 'applied', order: 'current' },
                  "mColumns": [ 0,1,2,4,5,6,7,8,9,10,11,12,13 ]
              },
              {
                  "sExtends": "csv",
                  "sButtonText": "CSV",
                  "sFileName": "SS.csv",
                  "oSelectorOpts": { filter: 'applied', order: 'current' },
                  "mColumns": [ 0,1,2,4,5,6,7,8,9,10,11,12,13 ]
              },
              {
                  "sExtends": "pdf",
                  "sButtonText": "PDF",
                  "sFileName": "SS.pdf",
                  "oSelectorOpts": { filter: 'applied', order: 'current' },
                  "sPdfOrientation": "landscape",
                  "mColumns": [ 0,1,2,5,6,7,8,9,10,11,12,13 ],
                  "sTitle": "Listagem de Solicitações de Serviço",
                  "sPdfMessage": "<?php echo date('d/m/y')?>",
              },
            ]
        }
    });
    var colvis = new $.fn.dataTable.ColVis( oTable );
  });

  function historico(id){
    document.getElementById('historicoFrame').src = "<?php echo(Router::url('/', true). "historicos/popup?controller=sses&id=");?>" + id;
  }
</script>
