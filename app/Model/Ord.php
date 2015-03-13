<?php class Ord extends AppModel {

  public $belongsTo = array(
    'Servico' => array(
      'className' => 'Servico'
      //'foreignKey' => 'servico_id'
    ),
    'Ss' => array(
      'className' => 'Ss',
      'foreignKey' => 'ss_id'
    ),
    'Status' => array(
      'className' => 'Status',
    ),
    'Pe' => array(
      'className' => 'Pe',
      'foreignKey' => 'pe_id'
    )
  );

  public $hasMany = array(
    'Historico' => array(
      'className' => 'Historico',
      'order' => array("Historico.data" => "ASC")
    ),
    'ItemPe' => array(
      'className' => 'itemPe'
    )
  );

  public $validate = array(
    'nome' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido!'),
      'between' => array(
                'rule'    => array('between', 3, 120),
                'message' => 'O campo deve conter de 3 a 120 caracteres!'
    )),
    'responsavel' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido!'),
      'between' => array(
                'rule'    => array('between', 3, 200),
                'message' => 'O campo deve conter de 3 a 200 caracteres!'
    )),
    'numero' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido!'),
      'unique' => array(
        'rule' => array('checkUnique', array('numero', 'ano', 'servico_id'), false),
        'required' => 'create',
        'message' => 'Já existe outra OS com esse número, nesse ano, para esse serviço'
       ),
      'between' => array(
                'rule'    => array('between', 1, 20),
                'message' => 'O campo deve conter de 1 a 20 caracteres!'
    )),
    'ano' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido!'),
      'between' => array(
                'rule'    => array('between', 3, 20),
                'message' => 'O campo deve conter de 3 a 20 caracteres!'
    )),
  );

  public function afterFind($results, $primary = false) {
    foreach ($results as $key => $val) {
        if (isset($val['Ord']['dt_emissao'])) {
            $results[$key]['Ord']['dt_emissao'] = $this->dateFormatAfterFind(
                $val['Ord']['dt_emissao']
            );
        }
        if (isset($val['Ord']['dt_recebimento'])) {
            $results[$key]['Ord']['dt_recebimento'] = $this->dateFormatAfterFind(
                $val['Ord']['dt_recebimento']
            );
        }
        if (isset($val['Ord']['dt_deploy_homologacao'])) {
            $results[$key]['Ord']['dt_deploy_homologacao'] = $this->dateFormatAfterFind(
                $val['Ord']['dt_deploy_homologacao']
            );
        }

        if (isset($val['Ord']['dt_deploy_producao'])) {
            $results[$key]['Ord']['dt_deploy_producao'] = $this->dateFormatAfterFind(
                $val['Ord']['dt_deploy_producao']
            );
        }

        if (isset($val['Ord']['dt_homologacao'])) {
            $results[$key]['Ord']['dt_homologacao'] = $this->dateFormatAfterFind(
                $val['Ord']['dt_homologacao']
            );
        }

        if (isset($val['Ord']['dt_ini_pdd'])) {
            $results[$key]['Ord']['dt_ini_pdd'] = $this->dateFormatAfterFind(
                $val['Ord']['dt_ini_pdd']
            );
        }

        if (isset($val['Ord']['dt_fim_pdd'])) {
            $results[$key]['Ord']['dt_fim_pdd'] = $this->dateFormatAfterFind(
                $val['Ord']['dt_fim_pdd']
            );
        }

        if (isset($val['Ord']['dt_recebimento_termo'])) {
            $results[$key]['Ord']['dt_recebimento_termo'] = $this->dateFormatAfterFind(
                $val['Ord']['dt_recebimento_termo']
            );
        }

        if (isset($val['Ord']['dt_recebimento_homo'])) {
            $results[$key]['Ord']['dt_recebimento_homo'] = $this->dateFormatAfterFind(
                $val['Ord']['dt_recebimento_homo']
            );
        }

        if (isset($val['Ord']['dt_recebimento_termo_prov'])) {
            $results[$key]['Ord']['dt_recebimento_termo_prov'] = $this->dateFormatAfterFind(
                $val['Ord']['dt_recebimento_termo_prov']
            );
        }
    }
    return $results;
  }

  public function dateFormatAfterFind($dateString) {
      return date('d/m/Y', strtotime($dateString));
  }

  public function beforeValidate($options = array()){
    if(!empty($this->data['Ord']['dt_emissao'])) {
        $this->data['Ord']['dt_emissao'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Ord']['dt_emissao'])));
    }
    if(!empty($this->data['Ord']['dt_recebimento'])) {
        $this->data['Ord']['dt_recebimento'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Ord']['dt_recebimento'])));
    }
    if(!empty($this->data['Ord']['dt_deploy_homologacao'])) {
        $this->data['Ord']['dt_deploy_homologacao'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Ord']['dt_deploy_homologacao'])));
    }
    if(!empty($this->data['Ord']['dt_deploy_producao'])) {
        $this->data['Ord']['dt_deploy_producao'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Ord']['dt_deploy_producao'])));
    }
    if(!empty($this->data['Ord']['dt_homologacao'])) {
        $this->data['Ord']['dt_homologacao'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Ord']['dt_homologacao'])));
    }
    if(!empty($this->data['Ord']['dt_ini_pdd'])) {
        $this->data['Ord']['dt_ini_pdd'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Ord']['dt_ini_pdd'])));
    }
    if(!empty($this->data['Ord']['dt_fim_pdd'])) {
        $this->data['Ord']['dt_fim_pdd'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Ord']['dt_fim_pdd'])));
    }
    if(!empty($this->data['Ord']['dt_recebimento_termo'])) {
        $this->data['Ord']['dt_recebimento_termo'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Ord']['dt_recebimento_termo'])));
    }
    if(!empty($this->data['Ord']['dt_recebimento_homo'])) {
        $this->data['Ord']['dt_recebimento_homo'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Ord']['dt_recebimento_homo'])));
    }
    if(!empty($this->data['Ord']['dt_recebimento_termo_prov'])) {
        $this->data['Ord']['dt_recebimento_termo_prov'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Ord']['dt_recebimento_termo_prov'])));
    }
    return true;
  }

}
