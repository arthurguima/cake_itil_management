<?php class User extends AppModel {

  public $hasAndBelongsToMany = array(
    'Cliente' => array()
  );

  public $validate = array(
    'nome' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 150,
        'message' => 'Campo deve ser preenchido!'
      )
    ),
    'matricula' => array(
      'empty' => array(
        'rule' => 'notempty',
        'message' => 'Campo deve ser preenchido!',
      ),
      'unique' => array(
				'rule' => 'isUnique',
				'required' => 'create',
				'message' => 'Já existe outro usuário com essa matrícula'
			)
    ),
    'Cliente' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido!'
      )
    )
  );

  public function beforeSave($options = array()){
    $this->data['User']['last_edit_by'] = $_SESSION['User']['uid'];
    return true;
  }

}?>
