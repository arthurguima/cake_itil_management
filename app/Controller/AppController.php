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
    //DEBUG
      $this->Session->write('cdUsuario', '354996');
    //DEBUG 

    if (isset($_SESSION['cdUsuario'])) {
      $this->loadModel('User');
      $user = $this->User->find('first', array(
          'contain' => array('Cliente' => array()),
          'conditions' => array('User.matricula =' . $_SESSION['cdUsuario'])
      ));
      if(sizeof($user) > 0){
        $this->Session->write('User.uid', $user['User']['id']);
        $this->Session->write('User.matricula', $user['User']['matricula']);
        $this->Session->write('User.nome', $user['User']['nome']);
        $this->Session->write('User.admin', $user['User']['is_admin']);
        $this->Session->write('User.workspace', $user['User']['workspace_first']);
        //Production
          //$this->Session->write('User.auth_pass', $_SESSION['auth_pass']);
        //Production
        $clientes = "";
        $size = sizeof($user['Cliente']);
        $indisponibilidade = Array();
          foreach ($user['Cliente'] as $cliente){
            $size = $size -1;
            $clientes = $clientes . $cliente["id"];
            if($size >= 1) $clientes = $clientes . ", ";
            $indisponibilidade[$cliente["id"]] = $cliente["dt_ini_disponibilidade"];
          }
          $this->Session->write('Clientes.indisponibilidades', $indisponibilidade);
        $clientes = " IN ("  . $clientes . ") ";
        $this->Session->write('User.clientes', $clientes);
      }else{
        $this->Session->write('User.uid', '0');
        return $this->redirect("http://www-apps/");
      }
    }
    else{
      $this->Session->write('User.uid', '0');
      return $this->redirect("http://www-apps/");
    }
  }

  public function mail(Array $conf){
    $Email = new CakeEmail('apps_default');
    $Email->from(array($conf['from'][0] . "@" . $conf['from'][1] => 'SGS - Sistema de Gestão de Serviço'));

    $this->loadModel('User');
    $user = $this->User->find('first', array(
        'conditions' => array('User.id =' . $conf['to'])
    ));

    $this->loadModel('Servico');
    $servico = $this->Servico->find('first', array(
        'conditions' => array('Servico.id =' . $conf['servico_id'])
    ));

    $Email->emailFormat('html');
    $Email->to($user['User']['mail']);
    $Email->subject("[" . $servico['Servico']['sigla'] . "] " . $conf['subject']);

    $Email->config(array(
      'username' => $conf['from'][0],
      'password' => $conf['auth_pass'],
    ));

    $html =
    '
      <ul>
        <li>Serviço: '.$servico['Servico']['nome'].'</li>
        <li>Atividade: '.$conf['tipo'].'</li>
        <li>Data Prevista: '.$conf['data'].'</li>
        <li>Descrição: '.$conf['mensagem'].'</li>
      </ul>
      <img rel="shortcut icon" sizes="48x48" type="image/png" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAB50lEQVQ4T6XTTUgbQRQH8P8s66oYbCIKimIo7cEvSjFIkIKiIOLBg0Ib7EUQikiroXrwVF2h4MclNN4EWzEoRtGDKIjgoZQee2kMfpAqYmlB6kc07ppsdp+sNMGPjUo7xzfzfjNv3gzDfw52Pb/4uSgA6Sb/TOfBfewbAECswOHeAhBgIA+nJc35Z16HEmEGAFDgcA8D9OZvkszAFojgSTMnL30baVUuY3GgbKgsmxTKFEg4CQZqn6iyed5g1wMCFjli42vT7SsAozhgG7Dl88T7AKQTMYT8DdCiKYmvgeBan3Z2XinB3m9vATCqZ8m7dkT2HyUC/iiCUPzD07Z3AZAILpKZUUiq+qw9bO35rqbmRo9zcLpVZQgwoGnN65zSJy8AyW1pYqAxAEKQeDTLVhxpAo5XG0GqcB1ZWPc662PBeAmnHx7YOMZmAVi/qCa8O8uFtFMO5fDhZSAY5VlJYKLj5w1AD5y4TVk8eP1o1X3hHCzvF0HarogDBLRseJ2fDNsYC5IIPpxheR8krrtZeowd3wuQyoOAlQ1vR43euluB2KQ0bHn5VUn72LXpSI4c5UU0DoWbk2/1F3plGL7E2IqQy/z01V7lZ9/vUtfqWK9o1JJbAT1hcLAur1u2/4Ioav8E3PUjzwHhtqwRScFa2AAAAABJRU5ErkJggg==">
      <p>Acesse em: <a href="http://www-apps/">www-apps/</a> -> SGS - Sistema de Gestão de Serviço</p>
    ';

    $Email->send($html);
  }

}
