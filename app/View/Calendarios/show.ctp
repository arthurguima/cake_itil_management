<?php
  $this->Html->addCrumb("Calendário", '/calendarios/show');
?>

<div class="row">
    <div class="col-lg-12"><h3 class="page-header"><i class="fa fa-calendar fa-fw"></i> Calendário </h3></div>
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
                  echo $this->BootstrapForm->input('servico_id', array(
                              'label' => array('text' => 'Serviço: '),
                              'class' => 'select2 form-control',
                              'selected' => $this->params['url']['servico'],
                              'options' => $servicos,
                              'empty' => 'Serviço'));

                  if( ($id % 13 == 0) || ($id % 2 == 0)){
                    $ambientes = array(1 => 'Homologação', 2 => 'Produção', 3 => 'Treinamento', 4 => 'Sustentação', 5 => 'Desenvolvimento', 6 => 'Testes');
                    echo $this->BootstrapForm->input('ambiente', array(
                                'label' => array('text' => 'Ambiente: '),
                                'class' => 'select2 form-control',
                                'selected' => $this->params['url']['ambiente'],
                                'options' => $ambientes,
                                'empty' => 'Ambiente'));
                  }
                  if( ($id % 13 != 0)){
                    echo $this->BootstrapForm->input('cliente_id', array(
                                'label' => array('text' => 'Cliente: '),
                                'class' => 'select2 form-control',
                                'selected' => $this->params['url']['cliente'],
                                'options' => $clientes,
                                'empty' => 'Cliente'));
                  }

                  echo $this->BootstrapForm->end();
              ?>
              <div class="small" style="float: right;">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row">
  <div id='calendar' class="col-lg-12"></div>
</div>

<?php //debug($_SESSION); ?>

<?php
 // FullCalendar
 echo $this->Html->script('plugins/fullcalendar/lib/moment.min.js');
 echo $this->Html->script('plugins/fullcalendar/fullcalendar.min.js');
 echo $this->Html->script('plugins/fullcalendar/lang/pt-br.js');
 echo $this->Html->css('plugins/fullcalendar/fullcalendar.min.css');
 //-- Select2 --
 echo $this->Html->script('plugins/select2/select2.min');
 echo $this->Html->css('plugins/select2');
 echo $this->Html->script('plugins/select2/select2_locale_pt-BR');
 echo $this->Html->css('plugins/select2-bootstrap');
?>

<script>
  $(document).ready(function() {
    $('.select2').select2({
      containerCssClass: 'select2'
    });

    $('#calendar').fullCalendar({
      header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},

      views: {
        month: {
            eventLimit: 7 // adjust to 6 only for agendaWeek/agendaDay
        }
      },

      events: {
        url: "<?php
              if(isset($this->params['url']['servico']) && !isset($this->params['url']['ambiente']) && !isset($this->params['url']['cliente']))
                echo Router::url('/', true). 'calendarios/json/' . $this->request->params['pass'][0] . "?servico=". $this->params['url']['servico'];
              elseif(isset($this->params['url']['servico']) && isset($this->params['url']['ambiente']) && !isset($this->params['url']['cliente']))
                echo Router::url('/', true). 'calendarios/json/' . $this->request->params['pass'][0] . "?servico=". $this->params['url']['servico']. "&ambiente=". $this->params['url']['ambiente'];
              elseif(!isset($this->params['url']['servico']) && isset($this->params['url']['ambiente']) && !isset($this->params['url']['cliente']))
                echo Router::url('/', true). 'calendarios/json/' . $this->request->params['pass'][0] . "?ambiente=". $this->params['url']['ambiente'];
              elseif(!isset($this->params['url']['servico']) && !isset($this->params['url']['ambiente']) && isset($this->params['url']['cliente']))
                echo Router::url('/', true). 'calendarios/json/' . $this->request->params['pass'][0] . "?cliente=". $this->params['url']['cliente'];
              elseif(isset($this->params['url']['servico']) && !isset($this->params['url']['ambiente']) && isset($this->params['url']['cliente']))
                echo Router::url('/', true). 'calendarios/json/' . $this->request->params['pass'][0] . "?servico=". $this->params['url']['servico']. "&cliente=". $this->params['url']['cliente'];
              elseif(!isset($this->params['url']['servico']) && isset($this->params['url']['ambiente']) && isset($this->params['url']['cliente']))
                echo Router::url('/', true). 'calendarios/json/' . $this->request->params['pass'][0] . "?cliente=". $this->params['url']['cliente']. "&ambiente=". $this->params['url']['ambiente'];
              elseif(isset($this->params['url']['servico']) && isset($this->params['url']['ambiente']) && isset($this->params['url']['cliente']))
                echo Router::url('/', true). 'calendarios/json/' . $this->request->params['pass'][0] . "?cliente=". $this->params['url']['cliente']. "&ambiente=". $this->params['url']['ambiente']. "&servico=". $this->params['url']['servico'];
              else
                echo Router::url('/', true). 'calendarios/json/' . $this->request->params['pass'][0];
             ?>",
        //color: '#DEDEDE',   // an option!
        //textColor: 'black' // an option!
        //As cores estão vindo dos métodos que geram os arrays para cada Model
      },

      eventRender: function(event, element) {
        if(event.description != null)
          element.find('.fc-title').append("<br/>" + event.description);
      },

      dayClick: function(date, allDay, jsEvent, view) {
        $('#calendar').fullCalendar('gotoDate', date);
        $('#calendar').fullCalendar('changeView', 'basicDay');
      }

    });
  });

  $( "select#servico_id" ).change(function () {
    $( "select#servico_id option:selected" ).each(function() {
       window.location = replaceQueryParam('servico', $(this).val(), window.location.search);
    })
  });

  $( "select#ambiente" ).change(function () {
    $( "select#ambiente option:selected" ).each(function() {
       window.location = replaceQueryParam('ambiente', $(this).val(), window.location.search);;
    })
  });

  $( "select#cliente_id" ).change(function () {
    $( "select#cliente_id option:selected" ).each(function() {
       window.location = replaceQueryParam('cliente', $(this).val(), window.location.search);
    })
  });

  function replaceQueryParam(param, newval, search) {
    var regex = new RegExp("([?;&])" + param + "[^&;]*[;&]?");
    var query = search.replace(regex, "$1").replace(/&$/, '');

    return (query.length > 2 ? query + "&" : "?") + (newval ? param + "=" + newval : '');
  }
</script>
