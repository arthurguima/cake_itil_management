<!--
  /*
    *  Makes a simple call to SDM using SOAP
    *  Limit: 250 registers (DoSelect Limitation)
    *  Versão: 11/07/2016
    *  Arthur Henrique Guimarães de Oliveira - 354996
  */
-->
<html>
  <head>
    <meta charset="UTF-8">
  </head>
  <body>
    <?php
    //In order to show more line using var_dump
      ini_set('xdebug.var_display_max_depth', 1000024);
      ini_set('xdebug.var_display_max_children', 1000024);
      ini_set('xdebug.var_display_max_data', 1000024);

    // Define params
      $wsdl = "http://www-sdm14/axis/services/USD_R11_WebService?wsdl";
      $username = "acesso_soap_rest";
      $password = "%Soap$#2015";
      //if Development than trace = 1 && exception = 1
        $trace = 1;
        $exception = 1;
    // END - Define params

    $args = array( 'trace' => $trace, 'exceptions' => $exception);
    $auth = array('username' => $username,'password' => $password);

    //First Step: Request Analysis
    // Each element should be used in the Method Call
      /* REQUEST FORMAT
        <element name="doSelect">
          <complexType>
            <sequence>
              <element name="sid" type="xsd:int"/>
              <element name="objectType" type="xsd:string"/>
              <element name="whereClause" type="xsd:string"/>
              <element name="maxRows" type="xsd:int"/>
              <element name="attributes" type="impl:ArrayOfString"/>
            </sequence>
          </complexType>
        </element>
      */
      //Second Step: Set the Values for elements
        $attributes = array(   /* 'chg_ref_num', //Identificador
                                'summary', //Título
                                'requestor.last_name', //Solicitante
                                'project.name', //Sistema
                                'project.system_name', //Cliente
                                'category.sym', //Categoria da Mudança
                                'chgtype', //Tipo da RDM (emergencial(300),normal(200),padrão(100))
                                'need_by', //Data Prevista (Solicitante)
                                'close_date', //Data De Fechamento
                                'description', //Descrição da requisição
                                'status.sym', //Status
                                'project.resource_contact.last_name', //Gestor do Sistema
                                'cab_approval', //Aprovada pelo CAB - 0 ou 1
                                'sched_start_date', //Data Agendada*/
                              );
        // pega o primeiro dia do mês atual no formato Unix Time que é o formato que o SDM armazena datas
          $primeiroDiaMes = mktime(0,0,0, date('m'),1,date('y'));
          $ultimoDiaMes = mktime(0,0,0, date('m')+1,1,date('y'));
          $whereClause = "ref_num = '254948/2016'";//"sched_start_date >= ".$primeiroDiaMes." and sched_start_date <= ".$ultimoDiaMes." and category.sym like '%.PRODU__O%' and project.name = 'Seguro Desemprego'";
        //chg => RDMs | in => Incidentes
        $objectType  = "in";
        $maxRows = 10;

      // Third Step: Make The Call
        try{
          # I - Creates an object of the service we will send a Request
            $client = new SoapClient($wsdl, $args);
            # I.1 Set the Header to use CA's envelope
              $header = new SOAPHeader('http://schemas.xmlsoap.org/soap/envelope', 'Auth', $auth);
              $client->__setSoapHeaders($header);
          # II - Call the method Login
            $session = $client->Login(array('username' => $username,'password' => $password));
          # III - Setup the request args
            $request = array( "sid" => $session->loginReturn,
                              "objectType" => $objectType,
                              "whereClause" => $whereClause,
                              "maxRows" => $maxRows,
                              "attributes" => array("string" => $attributes)
                            );
            $response = simplexml_load_string($client->DoSelect($request)->doSelectReturn);
            $json = json_encode($response);
            $response = json_decode($json,TRUE);
        }
        catch (Exception $e){
           echo "Error!";
           echo $e -> getMessage ();
           echo 'Last response: '. $client->__getLastResponse();
        }
        #Fourth Step: Print The Result
          //echo "<pre>" . var_dump($response) . "</pre>";
          for($i = 0; $i < $maxRows; ++$i) {
            echo "<b>RDM:</b> ";
            echo $response['UDSObject'][$i]['Attributes']['Attribute'][0]['AttrValue'];
            echo "<br /><b>  Título: </b>";
            echo $response['UDSObject'][$i]['Attributes']['Attribute'][1]['AttrValue'];
            echo "<br /><b>  Solicitante: </b>";
            echo $response['UDSObject'][$i]['Attributes']['Attribute'][2]['AttrValue'];
            echo "<br /><b>  Sistema: </b>";
            echo $response['UDSObject'][$i]['Attributes']['Attribute'][3]['AttrValue'];
            echo "<br /><b>  Cliente: </b>";
            echo $response['UDSObject'][$i]['Attributes']['Attribute'][4]['AttrValue'];
            echo "<br /><b>  Data Prevista: </b>";
            echo date("d-m-Y",$response['UDSObject'][$i]['Attributes']['Attribute'][7]['AttrValue']);
            echo "<br /><b>  Status: </b>";
            echo $response['UDSObject'][$i]['Attributes']['Attribute'][10]['AttrValue'];
            echo "<br /><br />";
          }
          //var_dump($response);

    ?>
  </body>
</html>
