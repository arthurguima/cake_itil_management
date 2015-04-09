<?php
  $this->Html->addCrumb("Relatórios", '');
  $this->Html->addCrumb("Disponibilidade por Serviço", '/relatorios/indisponibilidades');
?>

<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
        Disponibilidade por Serviço
      </h3>
    </div>
  <div class="col-lg-12 pull-left filters">
    <div class="">
      <div class="row">
        <span class="filter-show col-lg-2" style="cursor:pointer;" onclick="javascript:$('.filters > div > .inner').toggle();">
          Filtros <i class="fa fa-plus-square"></i>
        </span>
      </div>
      <div class="row inner">
        <?php  echo $this->BootstrapForm->create(false, array('class' => 'form-inline')); ?>
        <div class="col-lg-12 filters-item">
          <div class="form-group">
            <?php echo $this->BootstrapForm->input('servico_id', array(
                              'label' => array('text' => 'Serviço: '),
                              'class' => 'select2 form-control',
                              'empty' => 'servico',
                              'selected' => $this->params['url']['servico_id'])); ?>
          </div>
          <div class="form-group">
            <?php echo $this->BootstrapForm->input('motivo_id', array(
                       'type' => 'select',
                       'label' => array('text' => 'Motivo: '),
                       'default' => 0,
                       'empty' => true )); ?>
          </div>
        </div>
        <div class="col-lg-12 filters-item">
          <div class="form-group">
            <?php
              echo $this->BootstrapForm->input('dt_inicio', array(
                          'type' => 'text',
                          'label' => array('text' => 'Data de Início:'),
                          'id' => 'dp ',
                          'value' => $this->params['url']['dt_inicio']));
            ?>
            <?php
              echo $this->BootstrapForm->input('dt_fim', array(
                          'type' => 'text',
                          'label' => array('text' => 'Data de Fim:'),
                          'id' => 'dp ',
                          'value' => $this->params['url']['dt_fim']));
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

<?php if($this->request->data != null || $this->params['url']['servico_id'] != null): ?><div class="row">
  <?php $totaltime = 0; $contatime = 0; ?>
    <div class="col-lg-9">
      <div class="panel panel-default">
        <div class="panel-heading">Lista de Indisponibilidades - <b><?php echo $servico['Servico']['nome']; ?></b></div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-Indisponibilidades">
              <thead>
                <tr>
                  <th>Nº Evento</th>
                  <th>Nº Incidente</th>
                  <th>Início</th>
                  <th>Duração</th>
                  <th>Observação</th>
                  <th>Tipo</th>
                  <th><span class="editable">Status</span></th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($servico['Indisponibilidade'] as $Indisponibilidade): ?>
                  <tr>
                    <td><?php echo $Indisponibilidade['num_evento']; ?></td>
                    <td><?php echo $Indisponibilidade['num_incidente']; ?></td>
                    <td><?php echo $Indisponibilidade['dt_inicio']; ?></td>
                    <td><!-- TODO: transformar em HELPER -->
                      <?php
                        if($Indisponibilidade['dt_fim'] != null){
                          echo $this->Times->totalTime($Indisponibilidade['dt_inicio'], $Indisponibilidade['dt_fim']);
                          $totaltime += $this->Times->diffInSec($Indisponibilidade['dt_inicio'], $Indisponibilidade['dt_fim']);

                          if($Indisponibilidade['Motivo']['contavel'] != true)
                            $contatime += $this->Times->diffInSec($Indisponibilidade['dt_inicio'], $Indisponibilidade['dt_fim']);
                        }
                        else{
                          echo $this->Times->totalTime($Indisponibilidade['dt_inicio'], date('Y-m-d'));
                          $totaltime += $this->Times->diffInSec($Indisponibilidade['dt_inicio'], date('Y-m-d'));

                          if($Indisponibilidade['Motivo']['contavel'] == true)
                            $contatime += $this->Times->diffInSec($Indisponibilidade['dt_inicio'], date('Y-m-d'));
                        }
                      ?>
                    </td>
                    <td><?php echo $this->Tables->popupBox($Indisponibilidade['observacao']) ?></td>
                    <td><?php echo $Indisponibilidade['Motivo']['nome'] ?></td>

                    <td id="<?php echo $Indisponibilidade['id']?>">
                      <?php
                        if($Indisponibilidade['dt_fim'] == null):
                          echo "<span class='label label-success'>Aberto</span>";
                          echo $this->Tables->StatusEditable($Indisponibilidade['id'], "indisponibilidades");
                        else:
                          echo "<span class='label label-default'>Fechado</span>";
                        endif;
                      ?>
                    </td>
                    <td><?php echo $this->Tables->getMenu('Indisponibilidades', $Indisponibilidade['id'], 14); ?></td>
                  </tr>
                <?php endforeach; ?>
                <?php unset($Indisponibilidade); ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <p>
            <h3 class="panel-title">Relatório de Indisponibilidade</h3>
          </p>
        </div>
        <?php if($this->request->data != null): ?>
          <div class="panel-body">
            <ul class="nav nav-pills nav-stacked">
              <li>
                <a><b>Tempo Total: </b>
                  <?php
                    echo $this->Times->totalTime(
                        $this->Times->AmericanDate($this->request->data['dt_inicio']), $this->Times->AmericanDate($this->request->data['dt_fim']));
                  ?>
                </a>

              </li>
              <li><a><b>Indisponível: </b><?php echo   $this->Times->SecToString($totaltime); ?></a></li>
              <li><a><b>Contabilizado: </b><?php echo   $this->Times->SecToString($contatime); ?></a></li>
            </ul>
            <div class='semicircle col-md-6 col-md-offset-3'>
              <?php
                $percent = ($contatime / $this->Times->diffInSec(
                        $this->Times->AmericanDate($this->request->data['dt_inicio']), $this->Times->AmericanDate($this->request->data['dt_fim'])))*100;
              ?>
              <div id='semicircle' data-dimension='100' data-width='8'
                                   data-text='<?php echo round((100 - $percent),2); ?>%'
                                   data-percent='<?php echo $percent ?>'
                                   data-fontsize='9px' data-fgcolor='#d9534f' data-bgcolor='#5CB85C' data-fill='#EEE'></div>
            </div>
          </div>
        <?php else: ?>
          <div class="panel-body">
            <ul class="nav nav-pills nav-stacked">
              <li>
                <a><b>Tempo Total: </b>
                  <?php
                    echo round($this->Times->totalTime(
                      $this->Times->AmericanDate($this->params['url']['dt_inicio']), $this->Times->AmericanDate($this->params['url']['dt_fim'])), 2);
                  ?>
                </a>
              </li>
              <li><a><b>Indisponível: </b><?php echo   $this->Times->SecToString($totaltime); ?></a></li>
              <li><a><b>Contabilizado: </b><?php echo   $this->Times->SecToString($contatime); ?></a></li>
            </ul>
            <div class='semicircle col-md-6 col-md-offset-3'>
              <?php
                $percent = ($contatime / $this->Times->diffInSec(
                        $this->Times->AmericanDate($this->params['url']['dt_inicio']), $this->Times->AmericanDate($this->params['url']['dt_fim'])))*100;
              ?>
              <div id='semicircle' data-dimension='100' data-width='8'
                                   data-text='<?php echo round((100 - $percent),2); ?>%'
                                   data-percent='<?php echo $percent ?>'
                                   data-fontsize='9px' data-fgcolor='#d9534f' data-bgcolor='#5CB85C' data-fill='#EEE'></div>
            </div>
          </div>
        <?php endif; ?>
    </div>
  </div>
</div><?php endif; ?>


<script>
  $(document).ready(function() {
    $("[id*='dp']").datetimepicker({
      format: 'dd/mm/yyyy',
      minView: 2,
      autoclose: true,
      todayBtn: true,
      language: 'pt-BR'
    });

    $('#semicircle').circliful();

    //$('.select2').select2({
    // containerCssClass: 'select2'
    //});
  });
</script>


<?php
  // Circliful
  echo $this->Html->script('plugins/circliful/js/jquery.circliful.js');
  echo $this->Html->css('plugins/jquery.circliful.css');

  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');

  //Select2
  echo $this->Html->script('plugins/select2/select2.min');
  echo $this->Html->script('plugins/select2/select2_locale_pt-BR');
  echo $this->Html->css('plugins/select2');
  echo $this->Html->css('plugins/select2-bootstrap');
?>
