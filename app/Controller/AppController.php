<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

  public function saveAssociated($data = null, $options = array()) {
  	foreach ($data as $alias => $modelData) {
  		if (!empty($this->hasAndBelongsToMany[$alias])) {
  			$habtm = array();
  			$Model = ClassRegistry::init($this->hasAndBelongsToMany[$alias]['className']);
  			foreach ($modelData as $modelDatum) {
  				if (empty($modelDatum['id'])) {
  					$Model->create();
  				}
  				$Model->save($modelDatum);
  				$habtm[] = empty($modelDatum['id']) ? $Model->getInsertID() : $modelDatum['id'];
  			}
  			$data[$alias] = array($alias => $habtm);
  		}
  	}
  	return parent::saveAssociated($data, $options);
  }

  var $components = array(
      'FilterResults.Filter' => array(
          'auto' => array(
              'paginate' => true,
              'explode'  => true,  // recommended
          ),
          'explode' => array(
              'character'   => ' ',
              'concatenate' => 'AND',
          )
      ),
      'Session'
  );

  /* Variável de Sessão que controla a visão por clientes */
  /*  $this->loadModel('User');
    $this->Session->write('Person.eyeColor', $this->User->find('first', array(
      'contain' => array('Cliente' => array()),
      'conditions' => array('User.matricula =' . $_SESSION['cdUsuario'] )
    )));*/

  var $helpers = array(
      'FilterResults.Search' => array(
          'operators' => array(
              'LIKE'       => 'containing',
              'NOT LIKE'   => 'not containing',
              'LIKE BEGIN' => 'starting with',
              'LIKE END'   => 'ending with',
              '='  => 'equal to',
              '!=' => 'different',
              '>'  => 'greater than',
              '>=' => 'greater or equal to',
              '<'  => 'less than',
              '<=' => 'less or equal to'
          )
      )
  );
  function beforeFilter() {
    App::import('Vendor', 'ldapInclude', array('file' => 'ldapInclude.php'));

    if (isset($_SESSION['cdUsuario'])) {
      $this->loadModel('User');
      $user = $this->User->find('first', array(
          'contain' => array('Cliente' => array()),
          'conditions' => array('User.matricula =' . $_SESSION['cdUsuario'])
      ));
      if(sizeof($user) > 0){
        $this->Session->write('User.uid', $user['User']['id']);
        $this->Session->write('User.nome', $user['User']['nome']);
      }else{
        $this->Session->write('User.uid', '0');
      }
    }
    else{
      $this->Session->write('User.uid', '0');
    }
  }

}
