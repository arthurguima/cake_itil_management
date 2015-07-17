<ul class="nav nav-tabs nav-tabs-black cliente" role="tabonlines">
  <?php
    $active = 0;
    foreach ($clientes as $key => $clie){
      if($active == 0){
        echo '<li role="presentation" class="active"><a href="#online-'. $key .'" aria-controls="online-'. $key .'" role="tab" data-toggle="tab">'. $key .'</a></li>';
        $active = 1;
      }
      else
        echo '<li role="presentation" ><a href="#online-'. $key .'" aria-controls="online-'. $key .'" role="tab" data-toggle="tab">'. $key .'</a></li>';
    }
  ?>
</ul>

<div class="tab-content">
  <?php $active = 0; foreach ($clientes as $key => $servicos):
      if($active == 0){
        echo '<div role="tabpanel" class="tab-pane active" id="online-'.$key.'">';
        $active = 1;
      }
      else
        echo '<div role="tabpanel" class="tab-pane" id="online-'.$key.'">';
  ?>
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover" id="dataTables-Servico">
        <thead>
          <tr style="font-size:10px;" >
            <th>Serviço</th>
            <th>Resposta</th>
            <th>
              Containers
              <i class="fa fa-refresh" style="font-size:14px;" onclick="javascript:$('.get-containers').click();"></i>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($servicos as $servico): ?>
            <tr>
              <td>
                <b>
                  <?php echo $this->Html->link($servico['Servico']['sigla'], array('controller' => 'servicos', 'action' => 'view', $servico['Servico']['id']),
                        array('style' => "font-size: 9px; color: black; text-decoration:none;", 'id' => $servico['Servico']['sigla'])); ?>
                </b>
              </td>
              <?php echo $this->Disponibilidade->online($servico['Servico']['url'], 'GET'); ?>
              <td class="get-containers" id="containers_<?php echo $servico['Servico']['sigla'] ?>"
                  onclick="javascript:refreshContainers(<?php echo $servico['Servico']['id']?>,'<?php echo $servico['Servico']['sigla'] ?>');">
                <i class="fa fa-refresh" style="font-size:13px;"></i>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php unset($servico); ?>

        </tbody>
      </table>
    </div>
  </div>
  <?php endforeach; ?>
</div>
