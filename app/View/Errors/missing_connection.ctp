<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>

<div class="error">
	<div class="well">
		<h3 class="page-header"><i class="fa fa-plug"></i> Conexão perdida com o banco de dados</h3>
		<h4><?php echo __d('cake', 'Wooohhh....Aparentemente perdemos contato com o banco de dados!!'); ?></h4>

		<br />
		<b>Tente um dos seguintes procedimentos:</b>
		<div class="well">
			<ul class="list-unstyled spaced">
				<li>
					<i class="ace-icon fa fa-hand-o-right blue"></i>
					Tente recarregar a página novamente após alguns minutos
				</li>

				<li>
					<i class="ace-icon fa fa-hand-o-right blue"></i>
					Entre em contato com os administradores do SGD
				</li>
			</ul>
		</div>
	</div>
</div>

<?php

if (Configure::read('debug') > 0):
	echo $this->element('exception_stack_trace');
endif;
?>
