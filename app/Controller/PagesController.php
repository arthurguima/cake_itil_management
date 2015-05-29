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
		if(date("d") < 21){
			$servicos = $this->Servico->find('all', array(
				'contain' => array(
					'Indisponibilidade' => array(
						'Motivo' => array(),
						'conditions' => array('((DATE_FORMAT(Indisponibilidade.dt_inicio,"%m") = "'.date("m").'") && (DATE_FORMAT(Indisponibilidade.dt_inicio,"%d") <= 20 )) ||
																	((DATE_FORMAT(Indisponibilidade.dt_inicio,"%m") = "'.date("m",strtotime("-1 month")).'") && (DATE_FORMAT(Indisponibilidade.dt_inicio,"%d") > 20 ))')


					),
					'Area' => array('Cliente'=> array())
				)
			));
		}
		else{
			$servicos = $this->Servico->find('all', array(
				'contain' => array(
					'Indisponibilidade' => array(
						'Motivo' => array(),
						'conditions' => array('((DATE_FORMAT(Indisponibilidade.dt_inicio,"%m") = "'.date("m").'") && (DATE_FORMAT(Indisponibilidade.dt_inicio,"%d") > 20 )) ||
																	((DATE_FORMAT(Indisponibilidade.dt_inicio,"%m") = "'.date("m",strtotime("+1 month")).'") && (DATE_FORMAT(Indisponibilidade.dt_inicio,"%d") <= 20 ))')
					),
					'Area' => array('Cliente'=> array())
				)
			));
		}
		$this->set('clientesindis', $this->servicoPorCliente($servicos));
		//$this->Servico->recursive = 2;

		/*Lista de Demandas*/
		$this->loadModel('Demanda');
		$this->Demanda->Behaviors->attach('Containable');
		$demandas = $this->Demanda->find('all', array(
      'contain' => array(
        'Servico' => array('Area' => array('Cliente'=> array())),
        'DemandaTipo' => array(),
        'Status' => array(),
      ),
      'joins' => array(
        array(
          'table'=>'statuses',
          'alias' => 'Status_',
          'type'=>'inner',
          'conditions'=> array(
            'Status_.id = Demanda.status_id',
            'Status_.fim =' => null,
          ),
        )
      )
    ));
		//debug($this->demandasPorServico($demandas));
		$this->set('cliendemandas', $this->demandasPorServico($demandas));

		/*Lista de Chamados*/
		$this->loadModel('Chamado');
		$this->Chamado->Behaviors->attach('Containable');
		$chamados = $this->Chamado->find('all', array(
      //'group' => array('Demanda.servico_id'),
      'contain' => array(
				'Servico' => array('Area' => array('Cliente'=> array())),
        'ChamadoTipo' => array(),
        'Status' => array(),
      ),
      'joins' => array(
        array(
          'table'=>'statuses',
          'alias' => 'Status_',
          'type'=>'inner',
          'conditions'=> array(
            'Status_.id = Chamado.status_id',
            'Status_.fim =' => null,
          ),
        )
      )
    ));
		$this->set('clienchamados', $this->chamadosPorServico($chamados));

		/*Lista de Rdms*/
		$this->loadModel('Rdm');
		$this->Rdm->Behaviors->attach('Containable');
		$rdmsmes = $this->Rdm->find('all', array(
		  'contain' => array(
		    'Servico' => array('Area' => array('Cliente'=> array())),
				'RdmTipo' => array()
		  ),
			'conditions' => array('((DATE_FORMAT(Rdm.dt_prevista,"%m") = "'.date("m").'"))')
		));
		$rdmsano = $this->Rdm->find('all', array(
		  'contain' => array(
		    'Servico' => array('Area' => array('Cliente'=> array())),
				'RdmTipo' => array()
		  ),
			'conditions' => array('((DATE_FORMAT(Rdm.dt_prevista,"%Y") = "'.date("Y").'"))')
		));
		$this->set('rdmsmes', $this->rdmsPorCliente($rdmsmes));
		$this->set('rdmsano', $this->rdmsPorCliente($rdmsano));
	}

/* Funções de Apoio */

	/*
	* Cria um array que separa os serviços por cliente.
	*/
	private function rdmsPorCliente($rdms){
		foreach ($rdms as $rdm){
			$ambiente = $this->ambiente($rdm['Rdm']['ambiente']);
			$sucesso = $this->sucesso($rdm['Rdm']['sucesso']);
			$servico = $rdm['Servico']['sigla'];
			$tipo = $rdm['RdmTipo']['nome'];

			if(!isset($clientes[$rdm['Servico']['Area']['0']['Cliente']['sigla']]['Total']))
				$clientes[$rdm['Servico']['Area']['0']['Cliente']['sigla']]['Total'] = 1;
			else
				$clientes[$rdm['Servico']['Area']['0']['Cliente']['sigla']]['Total'] += 1;

			//Ambiente
				if(isset($clientes[$rdm['Servico']['Area']['0']['Cliente']['sigla']]['Ambiente'][$ambiente]))
					$clientes[$rdm['Servico']['Area']['0']['Cliente']['sigla']]['Ambiente'][$ambiente] += 1;
				else
					$clientes[$rdm['Servico']['Area']['0']['Cliente']['sigla']]['Ambiente'][$ambiente] = 1;
			//Sucesso
				if(isset($clientes[$rdm['Servico']['Area']['0']['Cliente']['sigla']]['Sucesso'][$sucesso]))
					$clientes[$rdm['Servico']['Area']['0']['Cliente']['sigla']]['Sucesso'][$sucesso] += 1;
				else
					$clientes[$rdm['Servico']['Area']['0']['Cliente']['sigla']]['Sucesso'][$sucesso] = 1;
			//Serviço
				if(isset($clientes[$rdm['Servico']['Area']['0']['Cliente']['sigla']]['Servico'][$servico]))
					$clientes[$rdm['Servico']['Area']['0']['Cliente']['sigla']]['Servico'][$servico] += 1;
				else
					$clientes[$rdm['Servico']['Area']['0']['Cliente']['sigla']]['Servico'][$servico] = 1;
			//Tipo
				if(isset($clientes[$rdm['Servico']['Area']['0']['Cliente']['sigla']]['Tipo'][$tipo]))
					$clientes[$rdm['Servico']['Area']['0']['Cliente']['sigla']]['Tipo'][$tipo] += 1;
				else
					$clientes[$rdm['Servico']['Area']['0']['Cliente']['sigla']]['Tipo'][$tipo] = 1;
		}
		return $clientes;
	}

	/*
	* Retorna o ambiente da RDM
	*/
	private function ambiente($amb){
		switch($amb){
			case 1:
				$ambiente = "Homologação";
				break;
			case 2:
				$ambiente = "Produção";
				break;
			case 3:
				$ambiente = "Treinamento";
				break;
			case 4:
				$ambiente = "Sustentação";
				break;
		}
		return $ambiente;
	}

	/*
	* Retorna como a rdm foi executada
	*/
	private function sucesso($suces){
		switch($suces){
			case -1:
				$sucesso = "Indefinido";
				break;
			case 0:
				$sucesso = "Sem sucesso";
				break;
			case 1:
				$sucesso = "Sucesso";
				break;
			case 2:
				$sucesso = "Cancelada";
				break;
		}
		return $sucesso;
	}

	/*
	* Cria um array que separa os serviços por cliente.
	*/
	private function servicoPorCliente($servicos){
		$clientes = array();
		foreach ($servicos as $ser){
			$clientes[$ser['Area']['0']['Cliente']['sigla']][] = $ser;
		}
		return $clientes;
	}

	/*
	* Cria um array que separa as demanadas em serviços.
	* Para cada serviço as demandas são separadas em por tipo e Status
	*/
	private function demandasPorServico($demandas){
		$demandasAUX = array();

		foreach ($demandas as $dem){
			/* Cliente ao qual o serviço pertence */
			$cliente = $dem['Servico']['Area']['0']['Cliente']['sigla'];

			/* Contador de Demandas */
							 //$demandasAUX['MTE']['PROGER']['Status']['total']
			if(isset($demandasAUX[$cliente][$dem['Servico']['sigla']]['Status']['total'])){
				$demandasAUX[$cliente][$dem['Servico']['sigla']]['Status']['total'] += 1;
			}else{
				$demandasAUX[$cliente][$dem['Servico']['sigla']]['Status']['total'] = 1;
			}

			/* Separa as demanads por Status */
									//$demandasAUX['MTE']['PROGER']['Status']['Aberta']['total']
			if( !isset( $demandasAUX[$cliente][$dem['Servico']['sigla']]['Status'][$dem['Status']['nome']]['total'] ) ){
				$demandasAUX[$cliente][$dem['Servico']['sigla']]['Status'][$dem['Status']['nome'] ]['total'] = 1;
			}
			else{
				$demandasAUX[$cliente][$dem['Servico']['sigla']]['Status'][$dem['Status']['nome']]['total'] += 1;
			}

			/* Separa as demanads por Tipo */
								 //$demandasAUX['MTE']['PROGER']['Tipo']['PDD']['total']
			if(!isset( $demandasAUX[$cliente][$dem['Servico']['sigla']]['Tipo'][$dem['DemandaTipo']['nome']]['total'] )){
				$demandasAUX[$cliente][$dem['Servico']['sigla']]['Tipo'][$dem['DemandaTipo']['nome']]['total'] = 1;
			}
			else{
				$demandasAUX[$cliente][$dem['Servico']['sigla']]['Tipo'][$dem['DemandaTipo']['nome']]['total'] += 1;
			}


			/* Status separado por cada tipo de Demanda */
								 //$demandasAUX['MTE']['PROGER']['Tipo']['PDD']['Em Atendimento']
			if(!isset( $demandasAUX[$cliente][$dem['Servico']['sigla']]['Tipo'][$dem['DemandaTipo']['nome']][$dem['Status']['nome']] )){
				$demandasAUX[$cliente][$dem['Servico']['sigla']]['Tipo'][$dem['DemandaTipo']['nome']][$dem['Status']['nome']] = 1;
			}
			else{
				$demandasAUX[$cliente][$dem['Servico']['sigla']]['Tipo'][$dem['DemandaTipo']['nome']][$dem['Status']['nome']] += 1;
			}

			/* Demandas separadas por tipo de Atraso */
								 //$demandasAUX['MTE']['PROGER']['Atraso']['1 e 15']; $demandasAUX['MTE']['PROGER']['Atraso']['indisponível'];
			if(isset($dem['Demanda']['dt_prevista'])){
				$t1 = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$dem['Demanda']['dt_prevista']);
				if(strtotime($t1) < strtotime(date('Y-m-d'))){
					$t1 = date_create($t1);
					$t2 = date_create(date('Y-m-d'));
	        $total = date_diff($t1,$t2)->days;
						if($total < 15)
							$key = 'entre 1 e 15';
						else if($total < 30)
							$key = 'entre 16 e 30';
						else if($total < 60)
							$key = 'entre 31 e 60';
						else if($total > 60)
							$key = 'há mais de 60 ';

					if(isset($demandasAUX[$cliente][$dem['Servico']['sigla']]['Atraso']['total'])){
						$demandasAUX[$cliente][$dem['Servico']['sigla']]['Atraso']['total'] += 1;
					}
					else{
						$demandasAUX[$cliente][$dem['Servico']['sigla']]['Atraso']['total'] = 1;
					}

					if(!isset( $demandasAUX[$cliente][$dem['Servico']['sigla']]['Atraso'][$key] )){
						$demandasAUX[$cliente][$dem['Servico']['sigla']]['Atraso'][$key] = 1;
					}
					else{
						$demandasAUX[$cliente][$dem['Servico']['sigla']]['Atraso'][$key] += 1;
					}
				}
			}
			else{
				if(!isset( $demandasAUX[$cliente][$dem['Servico']['sigla']]['Atraso']['Sem data prevista'] )){
					$demandasAUX[$cliente][$dem['Servico']['sigla']]['Atraso']['Sem data prevista'] = 1;
				}
				else{
					$demandasAUX[$cliente][$dem['Servico']['sigla']]['Atraso']['Sem data prevista'] += 1;
				}

				if(isset($demandasAUX[$cliente][$dem['Servico']['sigla']]['Atraso']['total'])){
					$demandasAUX[$cliente][$dem['Servico']['sigla']]['Atraso']['total'] += 1;
				}
				else{
					$demandasAUX[$cliente][$dem['Servico']['sigla']]['Atraso']['total'] = 1;
				}
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
			/* Cliente ao qual o serviço pertence */
			$cliente = $cham['Servico']['Area']['0']['Cliente']['sigla'];

			/* Contador de chamados */
			if(isset($chamadosAUX[$cliente][$cham['Servico']['sigla']]['Status']['total'])){
				$chamadosAUX[$cliente][$cham['Servico']['sigla']]['Status']['total'] += 1;
			}else{
				$chamadosAUX[$cliente][$cham['Servico']['sigla']]['Status']['total'] = 1;
			}

			/* Separa as demanads por Status */
			if(!isset($chamadosAUX[$cliente][$cham['Servico']['sigla']]['Status'][$cham['Status']['nome']]['total'])){
				$chamadosAUX[$cliente][$cham['Servico']['sigla']]['Status'][$cham['Status']['nome'] ]['total'] = 1;
			}
			else{
				$chamadosAUX[$cliente][$cham['Servico']['sigla']]['Status'][$cham['Status']['nome']]['total'] += 1;
			}

			/* Separa as demanads por Tipo */

			if(!isset($chamadosAUX[$cliente][$cham['Servico']['sigla']]['Tipo'][$cham['ChamadoTipo']['nome']]['total'])){
				$chamadosAUX[$cliente][$cham['Servico']['sigla']]['Tipo'][$cham['ChamadoTipo']['nome']]['total'] = 1;
			}
			else{
				$chamadosAUX[$cliente][$cham['Servico']['sigla']]['Tipo'][$cham['ChamadoTipo']['nome']]['total'] += 1;
			}


			/* Status de cada tipo de chamado */
			if(!isset($chamadosAUX[$cliente][$cham['Servico']['sigla']]['Tipo'][$cham['ChamadoTipo']['nome']][$cham['Status']['nome']])){
				$chamadosAUX[$cliente][$cham['Servico']['sigla']]['Tipo'][$cham['ChamadoTipo']['nome']][$cham['Status']['nome']] = 1;
			}
			else{
				$chamadosAUX[$cliente][$cham['Servico']['sigla']]['Tipo'][$cham['ChamadoTipo']['nome']][$cham['Status']['nome']] += 1;
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
