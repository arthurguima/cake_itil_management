<?php
  $this->Html->addCrumb("Kanban (Demandas)", '/kanban');
?>

<div class="col-lg-12 page-header-box">
    <div class="col-lg-12">
      <h3 class="page-header">
        Funcionalidade em versão Beta - β
      </h3>
    </div>
</div>

<div class="row">
  <div class="col-lg-12 pull-left filters">
    <div class="">
      <div class="row">
        <span class="filter-show col-lg-2" style="cursor:pointer;" onclick="javascript:$('.filters > div > .inner').toggle();">
          Filtros <i class="fa fa-plus-square"></i>
        </span>
      </div>
      <div class="row inner" style="display: none;">
        <?php  echo $this->BootstrapForm->create(false, array('class' => 'form-inline')); ?>
        <div class="col-lg-12">
          <div class="form-group">
            <?php
              $options = array( 1 => 'Demandas', 0 => 'Tarefas');
              echo $this->BootstrapForm->input('tipo_atividade', array(
                          'label' => array('text' => 'Atividade: '),
                          //'disabled' => 'disabled',
                          'options' => $options));

            ?>
          </div>
        </div>
        <?php
          echo $this->BootstrapForm->button("Filtrar <i class='fa fa-search'></i>", array('type' => 'submit', 'class' => 'control-label btn btn-default pull-right'));
          echo $this->BootstrapForm->end();
        ?>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Atividades Finalizadas -->
  <div class="col-lg-4 error kanban-step">
    <h3 class="kanban-title">
      Recebido
      <?php
        if(!isset($this->request->data['tipo_atividade']) || $this->request->data['tipo_atividade'] == 0)
          $recebido_ajuda = array("<h4>Tarefas Recebidas</h4>",
  				"<ul>
  					<li>São Atividades cujo Status é igual a 'Aguardando Início'</li>
            <li>O ícone <i class='fa-external-link-square-alt fas'></i> abre a página da Atividade no Clarity/SDM</li>
  				</ul>");
        else
          $recebido_ajuda = array("<h4>Demandas Recebidas</h4>",
          "<ul>
            <li>São Atividades cuja etapa definida para o Status atual é igual a 'Inicia/Recebe o processo'</li>
            <li>Em tese, são atividades que estão com a equipe mas ainda não foram iniciadas</li>
            <li>O ícone <i class='fa-external-link-square-alt fas'></i> abre a página da Atividade no Clarity/SDM</li>
          </ul>");

      echo $this->Tables->popupBox2($recebido_ajuda[0], $recebido_ajuda[1]);
			?>
    </h3>
    <div class="kanban-itens-box">
      <?php foreach ($recebidas as $r): ?>
        <div class="kaban-item">
          <h3 class="kanban-item-title">
            <?php
              if(($r['TipoTarefa'] == "subtarefas")){
                echo $this->Html->link($r['Servico'] . ' <i class="fa fa-search-plus fa-sm"  title="Visualizar detalhes"></i>', array('controller' => $r['TipoTarefa'], 'action' => 'edit', $r['Atividade_id']), array('escape' => false));
              }
              else{
                $tarefa = $r['Servico'] . " - " . $r['Demanda'];
                if(($r['Atividade'] == "Demanda") || ($r['TipoTarefa'] == "Demandas")){
                  echo $this->Html->link($tarefa . ' <i class="fa fa-search-plus fa-sm"  title="Visualizar detalhes"></i>', array('controller' => 'Demandas', 'action' => 'view', $r['Atividade_id']), array('escape' => false));
                  echo '<a id="viewClarity" href="https://projetos.dataprev.gov.br/niku/nu#action:pma.ideaProperties&id='. $r['Demanda_clarity'] .'" target="_blank"><i class="fa-external-link-square-alt fas pull-right"></i></a>';
                }
                else
                  echo $this->Html->link($tarefa . ' <i class="fa fa-search-plus fa-sm"  title="Visualizar detalhes"></i>', array('controller' => $r['TipoTarefa'], 'action' => 'view', $r['Atividade_id']), array('escape' => false));
              }
            ?>
          </h3>
          <div class="kanban-item-box">
            <li class="kanban-item-box-title"><?php echo $r['Atividade_desc']; ?></li>
            <li><?php echo '<span style="border-bottom: 2px solid #' . substr(md5($r['Status']), 0, 6) . '">'.$r['Status'] . "</span>"; ?></li>
            <li>Prazo: <?php echo $this->Times->timeLeftTo($r['Data_inicio'], $r['Data_prevista'],
                     $r['Data_inicio'] . " - " . $r['Data_prevista'],
                    ($r['Data_homologacao']));
              ?>
            </li>
          </div>
        </div>
      <?php endforeach; unset($r); ?>
    </div>
  </div>

  <!-- Atividades em Andamento -->
  <div class="col-lg-4 kanban-step">
    <h3 class="kanban-title">
      Em andamento
      <?php
        if(!isset($this->request->data['tipo_atividade']) || $this->request->data['tipo_atividade'] == 0)
          $a_ajuda = array("<h4>Tarefas Recebidas Em andamento</h4>",
          "<ul>
  					<li>São Atividades cuja etapa é igual a 'Em andamento'</li>
            <li>Em tese, são atividades que estão sendo realizadas pela equipe</li>
            <li>O ícone <i class='fa-external-link-square-alt fas'></i> abre a página da Atividade no Clarity/SDM</li>
  				</ul>");
        else
          $a_ajuda = array("<h4>Demandas Em andamento</h4>",
          "<ul>
  					<li>São Atividades cuja etapa definida para o Status atual é igual a 'Processo em Andamento'</li>
            <li>Em tese, são atividades que estão sendo realizadas pela equipe</li>
            <li>Caso uma atividade esteja em um status que finaliza o processo mas não tenha uma Data de Homologação ela também aparece aqui</li>
            <li>O ícone <i class='fa-external-link-square-alt fas'></i> abre a página da Atividade no Clarity/SDM</li>
  				</ul>");

      echo $this->Tables->popupBox2($a_ajuda[0], $a_ajuda[1]);
			?>
    </h3>
    <div class="kanban-itens-box">
      <?php foreach ($andamento as $a): ?>
        <div class="kaban-item">
          <h3 class="kanban-item-title">
            <?php
              if(($a['TipoTarefa'] == "Tarefas")){
                echo $this->Html->link($a['Servico'] . ' <i class="fa fa-search-plus fa-sm"  title="Visualizar detalhes"></i>', array('controller' => $a['TipoTarefa'], 'action' => 'view', $a['Atividade_id']), array('escape' => false));
              }
              else{
                $tarefa = $a['Servico'] . " - " . $a['Demanda'];
                if(($a['Atividade'] == "Demanda") || ($a['TipoTarefa'] == "Demandas")){
                  echo $this->Html->link($tarefa . ' <i class="fa fa-search-plus fa-sm"  title="Visualizar detalhes"></i>', array('controller' => 'Demandas', 'action' => 'view', $a['Atividade_id']), array('escape' => false));
                  echo '<a id="viewClarity" href="https://projetos.dataprev.gov.br/niku/nu#action:pma.ideaProperties&id='. $a['Demanda_clarity'] .'" target="_blank"><i class="fa-external-link-square-alt fas pull-right"></i></a>';
                }
                else
                  echo $this->Html->link($tarefa . ' <i class="fa fa-search-plus fa-sm"  title="Visualizar detalhes"></i>', array('controller' => $a['TipoTarefa'], 'action' => 'view', $a['Atividade_id']), array('escape' => false));
              }
            ?>
          </h3>
          <div class="kanban-item-box">
            <li class="kanban-item-box-title"><?php echo $a['Atividade_desc']; ?></li>
            <li><?php echo '<span style="border-bottom: 2px solid #' . substr(md5($a['Status']), 0, 6) . '">'.$a['Status'] . "</span>"; ?></li>
            <li>Prazo: <?php echo $this->Times->timeLeftTo($a['Data_inicio'], $a['Data_prevista'],
                     $a['Data_inicio'] . " - " . $a['Data_prevista'],
                    ($a['Data_homologacao']));
              ?>
            </li>
          </div>
        </div>
      <?php endforeach; unset($a); ?>
    </div>
  </div>

  <!-- Atividades Finalizadas -->
  <div class="col-lg-4 error kanban-step">
    <h3 class="kanban-title">
      Finalizado
      <?php
        if(!isset($this->request->data['tipo_atividade']) || $this->request->data['tipo_atividade'] == 0)
          $a_ajuda = array("<h4>Tarefas Finalizadas</h4>",
          "<ul>
  					<li>São Atividades cujo Status atual é igual a 'Finalizado'</li>
            <li>São atividades que estão foram finalizadas nos ultimos 10 dias</li>
            <li>O ícone <i class='fa-external-link-square-alt fas'></i> abre a página da Atividade no Clarity/SDM</li>
  				</ul>");
        else
          $a_ajuda = array("<h4>Demandas Finalizadas</h4>",
          "<ul>
  					<li>São Atividades cuja etapa definida para o Status atual é igual a 'Finaliza o Processo'</li>
            <li>São atividades que estão foram finalizadas nos ultimos 60 dias</li>
            <li>Caso uma atividade esteja em um status que finaliza o processo mas não tenha uma Data de Homologação ela aparece no bloco 'Em Andamento'</li>
            <li>O ícone <i class='fa-external-link-square-alt fas'></i> abre a página da Atividade no Clarity/SDM</li>
  				</ul>");

      echo $this->Tables->popupBox2($a_ajuda[0], $a_ajuda[1]);
			?>
    </h3>
    <div class="kanban-itens-box">
      <?php foreach ($finalizado as $f): ?>
        <div class="kaban-item">
          <h3 class="kanban-item-title">
            <?php
              if(($f['TipoTarefa'] == "Tarefas")){
                echo $this->Html->link($f['Servico'] . ' <i class="fa fa-search-plus fa-sm"  title="Visualizar detalhes"></i>', array('controller' => $f['TipoTarefa'], 'action' => 'view', $f['Atividade_id']), array('escape' => false));
              }
              else{
                $tarefa = $f['Servico'] . " - " . $f['Demanda'];
                if(($f['Atividade'] == "Demanda") || ($f['TipoTarefa'] == "Demandas")){
                  echo $this->Html->link($tarefa . ' <i class="fa fa-search-plus fa-sm"  title="Visualizar detalhes"></i>', array('controller' => 'Demandas', 'action' => 'view', $f['Atividade_id']), array('escape' => false));
                  echo '<a id="viewClarity" href="https://projetos.dataprev.gov.br/niku/nu#action:pma.ideaProperties&id='. $f['Demanda_clarity'] .'" target="_blank"><i class="fa-external-link-square-alt fas pull-right"></i></a>';
                }
                else
                  echo $this->Html->link($tarefa . ' <i class="fa fa-search-plus fa-sm"  title="Visualizar detalhes"></i>', array('controller' => $f['TipoTarefa'], 'action' => 'view', $f['Atividade_id']), array('escape' => false));
              }
            ?>
          </h3>
          <div class="kanban-item-box">
            <li class="kanban-item-box-title"><?php echo $f['Atividade_desc']; ?></li>
            <li><?php echo '<span style="border-bottom: 2px solid #' . substr(md5($f['Status']), 0, 6) . '">'.$f['Status'] . "</span>"; ?></li>
            <li>Prazo: <?php echo $this->Times->timeLeftTo($f['Data_inicio'], $f['Data_prevista'],
                     $f['Data_inicio'] . " - " . $f['Data_prevista'],
                    ($f['Data_homologacao']));
              ?>
            </li>
          </div>
        </div>
      <?php endforeach; unset($f); ?>
    </div>
  </div>
</div>



<?php
	
?>

<script>

</script>
