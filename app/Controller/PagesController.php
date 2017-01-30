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

	public function dashboard(){
		if($this->request->is('ajax')) {
      $this->layout = 'ajax';
  	}

		/* Lista de Servicos */
		$this->loadModel('Servico');
		$this->Servico->Behaviors->attach('Containable');
			$servicos_completo = Array();
		  foreach ($_SESSION['Clientes']['indisponibilidades'] as $key => $value) {
		    if(date("d") < $value+1){
		      $servicos = $this->Servico->find('all', array(
		        'conditions'=> array("Servico.cliente_id = " . $key),
		        'contain' => array(
		          'Indisponibilidade' => array(
		            'Motivo' => array(),
		            'conditions' => array('((DATE_FORMAT(Indisponibilidade.dt_inicio,"%m") = "'.
		                                    date("m").'") && (DATE_FORMAT(Indisponibilidade.dt_inicio,"%d") <= '. $value .' )) ||
		                                  ((DATE_FORMAT(Indisponibilidade.dt_inicio,"%m") = "'.
		                                    date("m",strtotime("-1 month")).'") && (DATE_FORMAT(Indisponibilidade.dt_inicio,"%d") > '. $value .' ))')


		          ),
		          'Cliente'=> array()
		        )
		      ));
		    }
		    else{
		      $servicos = $this->Servico->find('all', array(
		        'conditions'=> array("Servico.cliente_id = " . $key),
		        'contain' => array(
		          'Indisponibilidade' => array(
		            'Motivo' => array(),
		            'conditions' => array('((DATE_FORMAT(Indisponibilidade.dt_inicio,"%m") = "'.date("m").'") && (DATE_FORMAT(Indisponibilidade.dt_inicio,"%d") > '. $value .' )) ||
		                                  ((DATE_FORMAT(Indisponibilidade.dt_inicio,"%m") = "'.date("m",strtotime("+1 month")).'") && (DATE_FORMAT(Indisponibilidade.dt_inicio,"%d") <= '. $value .' ))')
		          ),
		          'Cliente'=> array()
		        )
		      ));
		    }
				$servicos_completo = array_merge($servicos_completo, $servicos);
			}
		$this->set('clientesindis', $this->servicoPorCliente($servicos_completo));
		//$this->Servico->recursive = 2;

		/*Lista de Demandas*/
		$this->loadModel('Demanda');
		$this->Demanda->Behaviors->attach('Containable');
		$demandas = $this->Demanda->find('all', array(
			'conditions'=> array("Servico.cliente_id" . $_SESSION['User']['clientes']),
      'contain' => array(
        'Servico' => array('Cliente'=> array()),
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
			'conditions'=> array("Servico.cliente_id" . $_SESSION['User']['clientes']),
      'contain' => array(
				'Servico' => array('Cliente'=> array()),
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
		    'Servico' => array('Cliente'=> array()),
				'RdmTipo' => array()
		  ),
			'conditions' => array("Servico.cliente_id" . $_SESSION['User']['clientes'] . ' && ((DATE_FORMAT(Rdm.dt_prevista,"%m") = "'.date("m").'"))')
		));
		$rdmsano = $this->Rdm->find('all', array(
		  'contain' => array(
		    'Servico' => array('Cliente'=> array()),
				'RdmTipo' => array()
		  ),
			'conditions' => array("Servico.cliente_id" . $_SESSION['User']['clientes'] . ' && ((DATE_FORMAT(Rdm.dt_prevista,"%Y") = "'.date("Y").'"))')
		));
		$this->set('rdmsmes', $this->rdmsPorCliente($rdmsmes));
		$this->set('rdmsano', $this->rdmsPorCliente($rdmsano));
	}

	public function workspace_old(){
		/*Lista de PEs*/
		$this->loadModel('Pe');
		$this->Pe->Behaviors->attach('Containable');
		$pes = $this->Pe->find('all', array(
			'contain' => array(
				'Ss' => array(),
				'Servico' => array(),
				'Status' => array(),
			),
			'conditions' => array('Pe.user_id = ' . $this->Session->read('User.uid')),
			'joins' => array(
				array(
					'table'=>'statuses',
					'alias' => 'Status_',
					'type'=>'inner',
					'conditions'=> array(
						'Status_.id = Pe.status_id',
						'Status_.fim =' => null,
					),
				)
			)
		));
		$this->set('pes', $pes);

		/*Lista de PEs*/
		$this->loadModel('Ord');
		$this->Ord->Behaviors->attach('Containable');
		$ords = $this->Ord->find('all', array(
			'contain' => array(
				'Ss' => array(),
				'Servico' => array(),
				'Status' => array(),
			),
			'conditions' => array('Ord.user_id = ' . $this->Session->read('User.uid')),
			'joins' => array(
				array(
					'table'=>'statuses',
					'alias' => 'Status_',
					'type'=>'inner',
					'conditions'=> array(
						'Status_.id = Ord.status_id',
						'Status_.fim =' => null,
					),
				)
			)
		));
		$this->set('ords', $ords);

		/*Lista de Sses*/
		$this->loadModel('Ss');
		$this->Ss->Behaviors->attach('Containable');
		$sses = $this->Ss->find('all', array(
			'contain' => array(
				'Servico' => array('Cliente'=> array()),
				'Status' => array(),
			),
			'conditions' => array('Ss.user_id = ' . $this->Session->read('User.uid')),
			'joins' => array(
				array(
					'table'=>'statuses',
					'alias' => 'Status_',
					'type'=>'inner',
					'conditions'=> array(
						'Status_.id = Ss.status_id',
						'Status_.fim =' => null,
					),
				)
			)
		));
		$this->set('sses', $sses);
	}

	public function workspace(){
		/*Lista de Chamados*/
		$this->loadModel('Chamado');
		$this->Chamado->Behaviors->attach('Containable');
		$chamados = $this->Chamado->find('all', array(
      //'group' => array('Demanda.servico_id'),
      'contain' => array(
				'Servico' => array(),
        'ChamadoTipo' => array(),
        'Status' => array(),
      ),
			'conditions' => array('Chamado.user_id = ' . $this->Session->read('User.uid')),
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
		$this->set('chamados', $chamados);

		/*Lista de Rdms*/
		$this->loadModel('Rdm');
		$this->Rdm->Behaviors->attach('Containable');
		$rdms = $this->Rdm->find('all', array(
		  'contain' => array(
		    'Servico' => array(),
				'RdmTipo' => array()
		  ),
			'conditions' => array('Rdm.sucesso = -1 && Rdm.user_id = ' . $this->Session->read('User.uid'))
		));
		$this->set('rdms', $rdms);

		/*Lista de indisponibilidades*/
		$this->loadModel('Indisponibilidade');
		$this->Indisponibilidade->Behaviors->attach('Containable');
		$indisponibilidades = $this->Indisponibilidade->find('all', array(
			'contain' => array(
				'Servico' => array(),
				'Motivo' => array()
			),
			'conditions' => array('Indisponibilidade.dt_fim IS NULL && Indisponibilidade.user_id = ' . $this->Session->read('User.uid'))
		));
		$this->set('indisponibilidades', $indisponibilidades);



		/*Lista de Demandas*/
		$this->loadModel('Demanda');
		$this->Demanda->Behaviors->attach('Containable');
		$demandas = $this->Demanda->find('all', array(
      'contain' => array(
        'Servico' => array(),
        'DemandaTipo' => array(),
        'Status' => array(),
      ),
			'conditions' => array('Demanda.user_id = ' . $this->Session->read('User.uid')),
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
		$this->set('demandas', $demandas);

		/*Lista de Subtarefas*/
		$this->loadModel('Subtarefa');
		$this->Subtarefa->Behaviors->attach('Containable');
		$subtarefas = $this->Subtarefa->find('all', array(
			'contain' => array(
				'Servico' => array(),
				'Demanda' => array(),
				'Rdm' => array(),
				'Chamado' => array(),
				'Release' => array()
			),
			'conditions' => array('Subtarefa.check = 0 && Subtarefa.user_id = ' . $this->Session->read('User.uid'))
		));
		$this->set('subtarefas', $subtarefas);

		/* Tarefas do Mês */
		/*Lista de Subtarefas*/
		/*$this->loadModel('Subtarefa');
		$subtarefas = $this->Subtarefa->find('all', array(
			'conditions' => array('Subtarefa.check = 0 && Subtarefa.user_id = ' . $this->Session->read('User.uid'))
		));
		$this->set('subtarefaMs', $subtarefasM);*/	
	}


/* Funções de Apoio */

	/*
	* Cria um array que separa os serviços por cliente.
	*/
	private function rdmsPorCliente($rdms){
		$clientes = array();
		foreach ($rdms as $rdm){
			$ambiente = $this->ambiente($rdm['Rdm']['ambiente']);
			$sucesso = $this->sucesso($rdm['Rdm']['sucesso']);
			$servico = $rdm['Servico']['sigla'];
			$tipo = $rdm['RdmTipo']['nome'];

			if(isset($rdm['Rdm']['dt_executada']))
				$mes = date('m',strtotime(preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$rdm['Rdm']['dt_executada'])));

			if(!isset($clientes[$rdm['Servico']['Cliente']['sigla']]['Total']))
				$clientes[$rdm['Servico']['Cliente']['sigla']]['Total'] = 1;
			else
				$clientes[$rdm['Servico']['Cliente']['sigla']]['Total'] += 1;

			//Ambiente
				if(isset($clientes[$rdm['Servico']['Cliente']['sigla']]['Ambiente'][$ambiente]))
					$clientes[$rdm['Servico']['Cliente']['sigla']]['Ambiente'][$ambiente] += 1;
				else
					$clientes[$rdm['Servico']['Cliente']['sigla']]['Ambiente'][$ambiente] = 1;

			//Sucesso
				if(isset($clientes[$rdm['Servico']['Cliente']['sigla']]['Sucesso'][$sucesso])){
					$clientes[$rdm['Servico']['Cliente']['sigla']]['Sucesso'][$sucesso] += 1;
				}
				else{
					$clientes[$rdm['Servico']['Cliente']['sigla']]['Sucesso'][$sucesso] = 1;
				}
				//Sucesso no mês X - se possui data de execução
				if(isset($mes)){
					if(isset($clientes[$rdm['Servico']['Cliente']['sigla']]['Mensal']['Sucesso'][$sucesso][$mes]))
						$clientes[$rdm['Servico']['Cliente']['sigla']]['Mensal']['Sucesso'][$sucesso][$mes] +=1;
					else
						$clientes[$rdm['Servico']['Cliente']['sigla']]['Mensal']['Sucesso'][$sucesso][$mes] =1;
				}

				//Serviço
				if(isset($clientes[$rdm['Servico']['Cliente']['sigla']]['Servico'][$servico]))
					$clientes[$rdm['Servico']['Cliente']['sigla']]['Servico'][$servico] += 1;
				else
					$clientes[$rdm['Servico']['Cliente']['sigla']]['Servico'][$servico] = 1;
			//Tipo
				if(isset($clientes[$rdm['Servico']['Cliente']['sigla']]['Tipo'][$tipo]))
					$clientes[$rdm['Servico']['Cliente']['sigla']]['Tipo'][$tipo] += 1;
				else
					$clientes[$rdm['Servico']['Cliente']['sigla']]['Tipo'][$tipo] = 1;

				if(isset($clientes[$rdm['Servico']['Cliente']['sigla']]['Mensal']['Sucesso'][$sucesso]))
					ksort($clientes[$rdm['Servico']['Cliente']['sigla']]['Mensal']['Sucesso'][$sucesso]);
				if(isset($mes))
					unset($mes);
		}
		return $clientes;
	}

	/*
	* Cria um array que separa as sses por clientes no ano atual
	*/
	private function ssesAnoPorCliente($sses){
		$ssesAUX = array();

	  foreach ($sses as $ss){
	    /* Cliente ao qual o serviço pertence */
	    $cliente = $ss['Servico']['Cliente']['sigla'];
			// Data em que a SS foi recebida
			$recebido = date('m', strtotime(preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$ss['Ss']['dt_recebimento'])))." ";

			if(isset($ssesAUX[$cliente]['SS(s) Recebidas'][$recebido]))
				$ssesAUX[$cliente]['SS(s) Recebidas'][$recebido] +=1;
			else
				$ssesAUX[$cliente]['SS(s) Recebidas'][$recebido] =1;

			foreach($ss['Pe'] as $pe){
				// Data em que a PA foi emitida
				$emitida = date('m', strtotime(preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$pe['dt_emissao'])))." ";

				if(isset($ssesAUX[$cliente]['PA(s) Emitida(s)'][$emitida]))
					$ssesAUX[$cliente]['PA(s) Emitida(s)'][$emitida] +=1;
				else
					$ssesAUX[$cliente]['PA(s) Emitida(s)'][$emitida] =1;
			}

			foreach($ss['Ord'] as $os){
				// Data em que a OS foi homologada
				$homologada = date('m', strtotime(preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$os['dt_homologacao'])))." ";

				if(isset($ssesAUX[$cliente]['OS(s) Homologada(s)'][$homologada]))
					$ssesAUX[$cliente]['OS(s) Homologada(s)'][$homologada] +=1;
				else
					$ssesAUX[$cliente]['OS(s) Homologada(s)'][$homologada] =1;
			}
		}

		for ($i = 1; $i <= date('m'); $i++) {
			if($i < 10)
				$pos = "0".$i." ";
			else
				$pos = $i." ";

			if(!isset($ssesAUX[$cliente]['OS(s) Homologada(s)'][$pos]))
				$ssesAUX[$cliente]['OS(s) Homologada(s)'][$pos] = 0;

			if(!isset($ssesAUX[$cliente]['PA(s) Emitida(s)'][$pos]))
				$ssesAUX[$cliente]['PA(s) Emitida(s)'][$pos] = 0;

			if(!isset($ssesAUX[$cliente]['SS(s) Recebidas'][$pos]))
				$ssesAUX[$cliente]['SS(s) Recebidas'][$pos] = 0;
		}
		ksort($ssesAUX[$cliente]['SS(s) Recebidas']);
		ksort($ssesAUX[$cliente]['PA(s) Emitida(s)']);
		ksort($ssesAUX[$cliente]['OS(s) Homologada(s)']);

		return $ssesAUX;

	}

	/*
	* Cria um array que separa as sses por clientes.
	*/
	private function ssesPorCliente($sses){
	  $ssesAUX = array();

	  foreach ($sses as $ss){
	    /* Cliente ao qual o serviço pertence */
	    $cliente = $ss['Servico']['Cliente']['sigla'];

	    /* Contador de Demandas */
	            //$ssesAUX['MTE']['PROGER']['Status']['total']
	    if(isset($ssesAUX[$cliente][$ss['Servico']['sigla']]['Status']['total'])){
	      $ssesAUX[$cliente][$ss['Servico']['sigla']]['Status']['total'] += 1;
	    }else{
	      $ssesAUX[$cliente][$ss['Servico']['sigla']]['Status']['total'] = 1;
	    }

	    /* Separa as demanads por Status */
	                //$ssesAUX['MTE']['PROGER']['Status']['Aberta']['total']
	    if( !isset( $ssesAUX[$cliente][$ss['Servico']['sigla']]['Status'][$ss['Status']['nome']]['total'] ) ){
	      $ssesAUX[$cliente][$ss['Servico']['sigla']]['Status'][$ss['Status']['nome'] ]['total'] = 1;
	    }
	    else{
	      $ssesAUX[$cliente][$ss['Servico']['sigla']]['Status'][$ss['Status']['nome']]['total'] += 1;
	    }

	    /* Demandas separadas por tipo de Atraso */
	              //$ssesAUX['MTE']['PROGER']['Atraso']['1 e 15']; $ssesAUX['MTE']['PROGER']['Atraso']['indisponível'];
	    if(isset($ss['Ss']['dt_prazo'])){
	      $t1 = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$ss['Ss']['dt_prevista']);
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

	        if(isset($ssesAUX[$cliente][$ss['Servico']['sigla']]['Atraso']['total'])){
	          $ssesAUX[$cliente][$ss['Servico']['sigla']]['Atraso']['total'] += 1;
	        }
	        else{
	          $ssesAUX[$cliente][$ss['Servico']['sigla']]['Atraso']['total'] = 1;
	        }

	        if(!isset( $ssesAUX[$cliente][$ss['Servico']['sigla']]['Atraso'][$key] )){
	          $ssesAUX[$cliente][$ss['Servico']['sigla']]['Atraso'][$key] = 1;
	        }
	        else{
	          $ssesAUX[$cliente][$ss['Servico']['sigla']]['Atraso'][$key] += 1;
	        }
	      }
	    }
	    else{
	      if(!isset( $ssesAUX[$cliente][$ss['Servico']['sigla']]['Atraso']['Sem data prevista'] )){
	        $ssesAUX[$cliente][$ss['Servico']['sigla']]['Atraso']['Sem data prevista'] = 1;
	      }
	      else{
	        $ssesAUX[$cliente][$ss['Servico']['sigla']]['Atraso']['Sem data prevista'] += 1;
	      }

	      if(isset($ssesAUX[$cliente][$ss['Servico']['sigla']]['Atraso']['total'])){
	        $ssesAUX[$cliente][$ss['Servico']['sigla']]['Atraso']['total'] += 1;
	      }
	      else{
	        $ssesAUX[$cliente][$ss['Servico']['sigla']]['Atraso']['total'] = 1;
	      }
	    }
	  }

	  return $ssesAUX;
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
			case 0:
				$sucesso = "Sem sucesso";
				break;
			case 1:
				$sucesso = "Sucesso";
				break;
			case 2:
				$sucesso = "Cancelada";
				break;
			case -1:
				$sucesso = "Indefinido";
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
			$clientes[$ser['Cliente']['sigla']][] = $ser;
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
			$cliente = $dem['Servico']['Cliente']['sigla'];

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
			$cliente = $cham['Servico']['Cliente']['sigla'];

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
