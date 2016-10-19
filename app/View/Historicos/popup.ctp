<?php
  /* CSS */
  //-- Bootstrap Core CSS --
  echo $this->Html->css('bootstrap.min.css');
  //-- MetisMenu CSS --
  echo $this->Html->css('plugins/metisMenu/metisMenu.min.css');
  //-- Timeline CSS --
  //echo $this->Html->css('plugins/timeline.css');
  //-- Custom Fonts
  echo $this->Html->css('font-awesome-4.3.0/css/font-awesome.min.css');
  //-- Custom admin CSS --
  echo $this->Html->css('sb-admin-2.css');
?>

<style media="screen">
    body{
      background-color: #fff;
    }
</style>

<div style="padding: 25px 15px; border-left: 1px solid #e7e7e7;">
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-danger">
        <div class="panel-heading">
          <p>
            <h3 class="panel-title"><b>Histórico</b>
              <?php
                if($this->Ldap->autorizado(2)){
                  echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                  array('controller' => 'historicos', 'action' => 'add',
                  '?' => array('controller' => $this->params['url']['controller'], 'id' => $this->params['url']['id'], 'popup' => 'true' )),
                  array('escape' => false));
                }
              ?>
            </h3>
          </p>
        </div>
        <div class="panel-body historico-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-contrato">
              <thead>
                <tr>
                  <th>Data</th>
                  <th>Descrição</th>
                  <th>Analista</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($historicos as $hist): ?>
                    <tr>
                      <td><?php echo $hist['Historico']['data']; ?></td>
                      <td><?php echo $this->Historicos->findLinks($hist['Historico']['descricao']); ?></td>
                      <td><?php echo $hist['Historico']['analista']; ?></td>
                      <td>
                        <?php
                          if($this->Ldap->autorizado(2)){
                            echo $this->Html->link("<i class='fa fa-pencil pull-right'></i>",
                            array('controller' => 'historicos', 'action' => 'edit', $hist['Historico']['id'],
                            '?' => array('controller' => $this->params['url']['controller'], 'id' => $this->params['url']['id'], 'popup' => 'true' )),
                            array('escape' => false));
                          }
                        ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php unset($hist); ?>
            </tbody>
          </table>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
