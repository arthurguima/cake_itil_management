<?php class WorkspaceHelper extends AppHelper {

public function dataTable($table){
  switch ($table) {
    case 1:
        echo "oTable = $('#dataTables-demanda').dataTable({
    					\"lengthMenu\": [[25, 15, 50, -1], [25, 15, 50, \"Todos\"]],
    					language: {
    						url: '" . Router::url('/', true) . "js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
    					},
    					\"columnDefs\": [  { \"visible\": false, \"targets\": 5 } ],
    					\"dom\": 'TC<\"clear\">lfrtip',
    					\"colVis\": {
    						\"buttonText\": \"Esconder Colunas\"
    					},
    					\"tableTools\": {
    							\"sSwfPath\": \"" . Router::url('/', true) . "js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf\",
    							\"aButtons\": [
    								{
    										\"sExtends\": \"copy\",
    										\"sButtonText\": \"Copiar\",
    										\"oSelectorOpts\": { filter: 'applied', order: 'current' },
    										\"mColumns\": [ 0,1,2,3,5,6,7,8, ]
    								},
    								{
    										\"sExtends\": \"print\",
    										\"sButtonText\": 'Imprimir',
    										\"oSelectorOpts\": { filter: 'applied', order: 'current' },
    										\"mColumns\": [ 0,1,2,3,5,6,7,8, ]
    								},
    								{
    										\"sExtends\": \"csv\",
    										\"sButtonText\": \"CSV\",
    										\"sFileName\": \"Demandas.csv\",
    										\"oSelectorOpts\": { filter: 'applied', order: 'current' },
    										\"mColumns\": [ 0,1,2,3,5,6,7,8, ]
    								},
    								{
    										\"sExtends\": \"pdf\",
    										'sButtonText': \"PDF\",
    										\"sFileName\": \"Demandas.pdf\",
    										\"oSelectorOpts\": { filter: 'applied', order: 'current' },
    										\"sPdfOrientation\": \"landscape\",
    										\"mColumns\": [ 0,1,2,3,6,7,8 ],
    										\"sTitle\": \"Listagem de Demandas\",
    										\"sPdfMessage\": \"Extraído em: ". date('d/m/y') ."\"
    								},
    							]
    					}
    			});
    			var colvis = new $.fn.dataTable.ColVis( oTable );";
        break;
    case 2:
        echo "oTablesubtarefa =  $('#dataTables-subtarefas').dataTable({
                'lengthMenu': [[25, 15, 50, -1], [25, 15, 50, 'Todos']],
                language: {
                  url: '" . Router::url('/', true) . "js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
                },
                'columnDefs': [  { 'visible': false, 'targets': [3, 4] } ],
                'dom': 'TC<\"clear\">lfrtip',
                'colVis': {
                  'buttonText': \"Esconder Colunas\"
                },
                'tableTools': {
                    'sSwfPath': \"" . Router::url('/', true) . "/js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf\",
                    'aButtons': [
                      {
                          'sExtends': 'copy',
                          'sButtonText': 'Copiar',
                          'mColumns':  'visible'
                      },
                      {
                          'sExtends': 'csv',
                          'sButtonText': 'CSV',
                          'sFileName': 'Tarefas.csv',
                          'mColumns':  'visible'
                      },
                      {
                          'sExtends': 'pdf',
                          'sButtonText': 'PDF',
                          'sFileName': 'Tarefas.pdf',
                          'sPdfOrientation': 'landscape',
                          'sTitle': 'Lista de Tarefas',
                          'sPdfMessage': \"Extraído em: " . date('d/m/y') . "\",
                          'mColumns':  'visible'
                      },
                    ]
                }
              });";
        break;
    case 3:
        echo "
          oTableRdm =  $('#dataTables-rdm').dataTable({
  					\"lengthMenu\": [[25, 15, 50, -1], [25, 15, 50, \"Todos\"]],
  						language: {
  							url: '". Router::url('/', true) ."js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
  						},
  						\"columnDefs\": [  { \"visible\": false, \"targets\": 6 } ],
  						\"dom\": 'TC<\"clear\">lfrtip',
  						\"order\": [[ 8, \"desc\" ]],
  						\"colVis\": {
  							\"buttonText\": \"Esconder Colunas\"
  						},
  						\"tableTools\": {
  								\"sSwfPath\": \"". Router::url('/', true) ."js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf\",
  								\"aButtons\": [
  									{
  											\"sExtends\": \"copy\",
  											\"sButtonText\": \"Copiar\",
  											\"oSelectorOpts\": { filter: 'applied', order: 'current' },
  											\"mColumns\": [ 0,1,2,3,4,6,7,8,9 ]
  									},
  									{
  											\"sExtends\": \"print\",
  											\"sButtonText\": \"Imprimir\",
  											\"oSelectorOpts\": { filter: 'applied', order: 'current' },
  											\"mColumns\": [ 0,1,2,3,4,6,7,8,9 ]
  									},
  									{
  											\"sExtends\": \"csv\",
  											\"sButtonText\": \"CSV\",
  											\"sFileName\": \"RDM.csv\",
  											\"oSelectorOpts\": { filter: 'applied', order: 'current' },
  											\"mColumns\": [ 0,1,2,3,4,6,7,8,9 ]
  									},
  									{
  											\"sExtends\": \"pdf\",
  											\"sButtonText\": \"PDF\",
  											\"sFileName\": \"RDM.pdf\",
  											\"oSelectorOpts\": { filter: 'applied', order: 'current' },
  											\"mColumns\": [ 0,1,2,3,4,7,8,9 ],
  											\"sPdfOrientation\": \"landscape\",
  											\"sTitle\": \"Requisições de Mudança\",
  											\"sPdfMessage\": \"". date('d/m/y') ."\",
  									},
  								]
  						}
  				});
  				var colvis = new $.fn.dataTable.ColVis( oTableRdm );";
        break;
      case 4:
        echo "
              oTablechamado = $('#dataTables-chamado').dataTable({
        	        \"lengthMenu\": [[25, 15, 50, -1], [25, 15, 50, \"Todos\"]],
        	        language: {
        	          url: '" . Router::url('/', true) ."js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
        	        },
        	        \"dom\": 'TC<\"clear\">lfrtip',
        	        \"colVis\": {
        	          \"buttonText\": \"Esconder Colunas\"
        	        },
        	        \"tableTools\": {
        	            \"sSwfPath\": \"" . Router::url('/', true) ."js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf\",
        	            \"aButtons\": [
        	              {
        	                  \"sExtends\": \"copy\",
        	                  \"sButtonText\": \"Copiar\",
        	                  \"oSelectorOpts\": { filter: 'applied', order: 'current' },
        	                  \"mColumns\": [ 0,1,2,3,4,5,6,7 ]
        	              },
        	              {
        	                  \"sExtends\": \"print\",
        	                  \"sButtonText\": \"Imprimir\",
        	                  \"oSelectorOpts\": { filter: 'applied', order: 'current' },
        	                  \"mColumns\": [ 0,1,2,3,4,5,6,7 ]
        	              },
        	              {
        	                  \"sExtends\": \"csv\",
        	                  \"sButtonText\": \"CSV\",
        	                  \"sFileName\": \"Chamados.csv\",
        	                  \"oSelectorOpts\": { filter: 'applied', order: 'current' },
        	                  \"mColumns\": [ 0,1,2,3,4,5,6,7 ]
        	              },
        	              {
        	                  \"sExtends\": \"pdf\",
        	                  \"sButtonText\": \"PDF\",
        	                  \"sFileName\": \"Chamados.pdf\",
        	                  \"oSelectorOpts\": { filter: 'applied', order: 'current' },
        	                  \"sPdfOrientation\": \"landscape\",
        	                  \"mColumns\": [ 0,1,2,3,4,5,6,7 ],
        	                  \"sTitle\": \"Listagem de Chamados\",
        	                  \"sPdfMessage\": \"Extraído em: ". date('d/m/y') ."\"
        	              },
        	            ]
        	        }
        	    });
        	    var colvis = new $.fn.dataTable.ColVis( oTablechamado );";
        break;
      case 5:
        echo "
              oTableIndis =  $('#dataTables-indisponibilidade').dataTable({
      				\"lengthMenu\": [[25, 50, 100, -1], [25, 50, 100, \"Todos\"]],
      					language: {
      						url: '". Router::url('/', true) ."js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
      					},
      					\"columnDefs\": [  { \"visible\": false, \"targets\": 7 } ],
      					\"dom\": 'TC<\"clear\">lfrtip',
      					\"colVis\": {
      						\"buttonText\": \"Esconder Colunas\"
      					},
      					\"tableTools\": {
      							\"sSwfPath\": \"". Router::url('/', true) ."js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf\",
      							\"aButtons\": [
      								{
      										\"sExtends\": \"copy\",
      										\"sButtonText\": \"Copiar\",
      										\"oSelectorOpts\": { filter: 'applied', order: 'current' },
      										\"mColumns\": [ 0,1,2,3,4,5,7,8 ]
      								},
      								{
      										\"sExtends\": \"print\",
      										\"sButtonText\": \"Imprimir\",
      										\"oSelectorOpts\": { filter: 'applied', order: 'current' },
      										\"mColumns\": [ 0,1,2,3,4,5,7,8 ]
      								},
      								{
      										\"sExtends\": \"csv\",
      										\"sButtonText\": \"CSV\",
      										\"sFileName\": \"Indisponibilidades.csv\",
      										\"oSelectorOpts\": { filter: 'applied', order: 'current' },
      										\"mColumns\": [ 0,1,2,3,4,5,7,8 ]
      								},
      								{
      										\"sExtends\": \"pdf\",
      										\"sButtonText\": \"PDF\",
      										\"sFileName\": \"Indisponibilidades.pdf\",
      										\"oSelectorOpts\": { filter: 'applied', order: 'current' },
      										\"mColumns\": [ 0,1,2,3,4,5,7,8 ],
      										\"sPdfOrientation\": \"landscape\",
      										\"sTitle\": \"Controle de Disponibilidade\",
      										\"sPdfMessage\": \"Extraído em: ". date('d/m/y') ."\",
      								},
      							]
      					}
      			});
      			var colvis = new $.fn.dataTable.ColVis( oTableIndis );";
        break;
  }
}

} ?>
