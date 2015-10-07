<?php
  $this->Html->addCrumb("Relatórios", '');
  $this->Html->addCrumb("Releases como Timeline", '/relatorios/releases');
?>

<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">
      Releases como Timeline
    </h3>
    <div class="col-lg-12 pull-left filters">
      <div class="">
        <div class="row">
          <span class="filter-show col-lg-2" style="cursor:pointer;" onclick="javascript:$('.filters > div > .inner').toggle();">
            Filtros <i class="fa fa-plus-square"></i>
          </span>
        </div>
        <div class="row inner">
          <?php  echo $this->BootstrapForm->create(false, array('class' => 'form-inline')); ?>
          <div class="col-lg-12">
            <div class="form-group">
              <?php
                  echo $this->BootstrapForm->input('servico_id', array(
                              'label' => array('text' => 'Serviço: '),
                              'class' => 'select2 form-control',
                              'selected' => $this->request->data['servico_id'],
                              'empty' => 'Serviço'));
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
</div>

<div class="row">
  <div class="col-lg-12">
    <div role="tabpanel" class="tab-pane" id="versoes">
      <div class="error">
        <div class="well">
          <h3 class="page-header"><i class="fa fa-tags"></i> Notas:</h3>
          <ul class="timeline">
            <?php
              $invert = 'class="timeline-inverted"';
              foreach ($releases as $rel):
                $item = '<li ' . $invert  .'>
                  <div class="timeline-panel">
                    <ul class="list-unstyled spaced">
                      <li>
                        <h4 class="page-header"> <i class="ace-icon fa fa-hand-o-right"></i> Versão: ' . $rel['Release']['versao'] . '</h4>
                          <div class="personal-info"><ul>';

                foreach ($rel['Note'] as $note):
                  $item = $item . "<li>" . $note['valor'] . "</li>";
                endforeach;
                unset($note);
                $item = $item . ' </ul>';
                $item = $item . '<hr/><b>RDM:</b> ' . $rel['Rdm']['numero'] . " <span class='pull-right'>" . $rel['Rdm']['dt_executada'] . "</span>";

                $item = $item . '</div></li></ul></div></li>';
                echo $item;

                if($invert != "")
                  $invert = "";
                else
                  $invert = 'class="timeline-inverted"';

              endforeach;
              unset($rel);
            ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .nav.nav-tabs-pages>li.active>a{
      background-color: #eee !important;
  }
</style>
<?php echo $this->Html->css('plugins/timeline.css'); ?>


<script>
  $(document).ready(function() {
    $('.select2').select2({
      containerCssClass: 'select2'
    });
  });
</script>


<?php
  //-- Select2 --
  echo $this->Html->script('plugins/select2/select2.min');
  echo $this->Html->css('plugins/select2');
  echo $this->Html->script('plugins/select2/select2_locale_pt-BR');
  echo $this->Html->css('plugins/select2-bootstrap');
?>
