<?php
  $this->Html->addCrumb('Usuários', '/users');
?>
<div class="col-lg-12 page-header-box">
    <div class="col-lg-12">
      <h3 class="page-header">
        Usuários
      </h3>
    </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <b> Lista de Usuários </b>
        <div class="col-lg-2 pull-right">
          <?php
             if($this->Ldap->autorizado(2)){
               echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                 array('controller' => 'users', 'action' => 'add'),
                 array('escape' => false));
             }
           ?>
        </div>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-users">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Matrícula</th>
                <th>Clientes</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $user): ?>
                <tr>
                  <td><?php echo $user['User']['nome']; ?></td>
                  <td><?php echo $user['User']['matricula']; ?></td>
                  <td>
                    <?php
                      foreach ($user['Cliente'] as $cli){
                        echo $cli['sigla'] . ";  ";
                      }
                    ?>
                  </td>
                  <td><?php echo $this->Tables->getMenu('users', $user['User']['id'], 12); ?></td>
                </tr>
              <?php endforeach; ?>
              <?php unset($user); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- DataTables JavaScript -->
<?php
  echo $this->Html->script('plugins/dataTables/media/js/jquery.dataTables.js');
  echo $this->Html->script('plugins/dataTables/dataTables.bootstrap.js');
  echo $this->Html->css('plugins/dataTables.bootstrap.css');

//-- DataTables --> TableTools
echo $this->Html->script('plugins/dataTables/extensions/TableTools/js/dataTables.tableTools.min.js');
echo $this->Html->css('plugins/dataTablesExtensions/TableTools/css/dataTables.tableTools.min.css');

?>

<script>
  $(document).ready(function() {
    var  oTable =   $('#dataTables-users').dataTable({
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
          language: {
            url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
          },
          "dom": 'T<"clear">lfrtip',
          "tableTools": {
              "sSwfPath": "<?php echo Router::url('/', true);?>/js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
              "aButtons": [
                {
                    "sExtends": "copy",
                    "sButtonText": "Copiar"
                },
                {
                    "sExtends": "print",
                    "sButtonText": "Imprimir"
                },
                {
                    "sExtends": "csv",
                    "sButtonText": "CSV"
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF"
                },
              ]
          }
  });

  var colvis = new $.fn.dataTable.ColVis( oTable );

  $('[data-toggle="popover"]').popover({trigger: 'hover','placement': 'right', html: 'true'});

 });
</script>

<style>
div.sub-20 {
  overflow:  inherit !important;
}
</style>
