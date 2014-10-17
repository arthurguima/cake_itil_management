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

<p class="error">
<h2>	<strong><?php echo __d('cake', 'Error'); ?>: </strong>
	<?php echo __d('cake', 'Wooohhh....Aparentemente perdemos contato com o banco de dados!!'); ?><h2>
</p>
<br/><h3>Por favor, procure os responsaveis pelo sistema!!</h3><br/><br/>
<h4>Mensagem:<?php echo $message; ?></h4>
<br/><br/>
<?php

if (Configure::read('debug') > 0):
	echo $this->element('exception_stack_trace');
endif;
?>
