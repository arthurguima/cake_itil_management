<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

	public function home(){
		if($this->request->is('ajax')) {
      $this->layout = 'ajax';
  	}

		/* Lista de Servicos */
		$this->loadModel('Servico');
		$this->Servico->Behaviors->attach('Containable');
		if(date("d") < 20){
			$this->set('servicos', $this->Servico->find('all', array(
				'contain' => array(
					'Indisponibilidade' => array(
						'conditions' => array('((DATE_FORMAT(Indisponibilidade.dt_inicio,"%m") = "'.date("m").'") && (DATE_FORMAT(Indisponibilidade.dt_inicio,"%d") <= 20 )) ||
																	((DATE_FORMAT(Indisponibilidade.dt_inicio,"%m") = "'.date("m",strtotime("-1 month")).'") && (DATE_FORMAT(Indisponibilidade.dt_inicio,"%d") > 20 )) ')

					)
				)
			)));
		}
		else{
			$this->set('servicos', $this->Servico->find('all', array(
				'contain' => array(
					'Indisponibilidade' => array(
						'conditions' => array('((DATE_FORMAT(Indisponibilidade.dt_inicio,"%m") = "'.date("m").'") && (DATE_FORMAT(Indisponibilidade.dt_inicio,"%d") > 20 )) ||
																	((DATE_FORMAT(Indisponibilidade.dt_inicio,"%m") = "'.date("m",strtotime("+1 month")).'") && (DATE_FORMAT(Indisponibilidade.dt_inicio,"%d") <= 20 ))')
					)
				)
			)));
		}
		$this->Servico->recursive = 2;

		/*Lista de Demandas*/
		$this->loadModel('Demanda');
		$this->set('demandas', $this->demandasPorServico($this->Demanda->find('all'/*, APÓS DEFINIR UM PERÍODO DE TEMPO PARA MOSTRAR AS INFORMAÇÕES
			array(
				'fields' => 'Demanda.id, Servico.sigla, Status.nome',
				'conditions' => array('((DATE_FORMAT(Demanda.data_cadastro,"%m") = "'.date("m").'") && (DATE_FORMAT(Demanda.data_cadastro,"%d") <= 20 )) ||
															((DATE_FORMAT(Demanda.data_cadastro,"%m") = "'.date("m",strtotime("-1 month")).'") && (DATE_FORMAT(Demanda.data_cadastro,"%d") > 20 ))'),

			)*/))
		);

		$this->loadModel('Chamado');
		$this->set('chamados', $this->chamadosPorServico($this->Chamado->find('all')));
	}

	/*
	* Cria um array que separa as demanadas em serviços.
	* Para cada serviço as demandas são separadas em por tipo e Status
	*/
	private function demandasPorServico($demandas){
		$demandasAUX = array();

		foreach ($demandas as $dem){
			/* Contador de Demandas */
			if(isset($demandasAUX[$dem['Servico']['sigla']]['Status']['total'])){
				$demandasAUX[$dem['Servico']['sigla']]['Status']['total'] += 1;
			}else{
				$demandasAUX[$dem['Servico']['sigla']]['Status']['total'] = 1;
			}

			/* Separa as demanads por Status */
			if(!isset($demandasAUX[$dem['Servico']['sigla']]['Status'][$dem['Status']['nome']]['total'])){
				$demandasAUX[$dem['Servico']['sigla']]['Status'][$dem['Status']['nome'] ]['total'] = 1;
			}
			else{
				$demandasAUX[$dem['Servico']['sigla']]['Status'][$dem['Status']['nome']]['total'] += 1;
			}

			/* Separa as demanads por Tipo */

			if(!isset($demandasAUX[$dem['Servico']['sigla']]['Tipo'][$dem['DemandaTipo']['nome']]['total'])){
				$demandasAUX[$dem['Servico']['sigla']]['Tipo'][$dem['DemandaTipo']['nome']]['total'] = 1;
			}
			else{
				$demandasAUX[$dem['Servico']['sigla']]['Tipo'][$dem['DemandaTipo']['nome']]['total'] += 1;
			}


			/* Status de cada tipo de Demanda */
			if(!isset($demandasAUX[$dem['Servico']['sigla']]['Tipo'][$dem['DemandaTipo']['nome']][$dem['Status']['nome']])){
				$demandasAUX[$dem['Servico']['sigla']]['Tipo'][$dem['DemandaTipo']['nome']][$dem['Status']['nome']] = 1;
			}
			else{
				$demandasAUX[$dem['Servico']['sigla']]['Tipo'][$dem['DemandaTipo']['nome']][$dem['Status']['nome']] += 1;
			}
		}

		return $demandasAUX;
	}

	/*
	* Cria um array que separa os chamados em serviços.
	* Para cada serviço as chamados são separadas em por tipo e Status
	*/
	private function chamadosPorServico($chamados){
		$chamadosAUX = array();

		foreach ($chamados as $cham){
			/* Contador de chamados */
			if(isset($chamadosAUX[$cham['Servico']['sigla']]['Status']['total'])){
				$chamadosAUX[$cham['Servico']['sigla']]['Status']['total'] += 1;
			}else{
				$chamadosAUX[$cham['Servico']['sigla']]['Status']['total'] = 1;
			}

			/* Separa as demanads por Status */
			if(!isset($chamadosAUX[$cham['Servico']['sigla']]['Status'][$cham['Status']['nome']]['total'])){
				$chamadosAUX[$cham['Servico']['sigla']]['Status'][$cham['Status']['nome'] ]['total'] = 1;
			}
			else{
				$chamadosAUX[$cham['Servico']['sigla']]['Status'][$cham['Status']['nome']]['total'] += 1;
			}

			/* Separa as demanads por Tipo */

			if(!isset($chamadosAUX[$cham['Servico']['sigla']]['Tipo'][$cham['ChamadoTipo']['nome']]['total'])){
				$chamadosAUX[$cham['Servico']['sigla']]['Tipo'][$cham['ChamadoTipo']['nome']]['total'] = 1;
			}
			else{
				$chamadosAUX[$cham['Servico']['sigla']]['Tipo'][$cham['ChamadoTipo']['nome']]['total'] += 1;
			}


			/* Status de cada tipo de chamado */
			if(!isset($chamadosAUX[$cham['Servico']['sigla']]['Tipo'][$cham['ChamadoTipo']['nome']][$cham['Status']['nome']])){
				$chamadosAUX[$cham['Servico']['sigla']]['Tipo'][$cham['ChamadoTipo']['nome']][$cham['Status']['nome']] = 1;
			}
			else{
				$chamadosAUX[$cham['Servico']['sigla']]['Tipo'][$cham['ChamadoTipo']['nome']][$cham['Status']['nome']] += 1;
			}
		}

		return $chamadosAUX;
	}

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}
}
