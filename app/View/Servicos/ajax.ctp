<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover" id="dataTables-Servico">
    <thead>
      <tr>
        <th>Serviço</th>
        <th>Status</th>
        <th>Tempo de resposta</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($servicos as $servico): ?>
        <tr>
          <td><b><?php echo $servico['Servico']['sigla']; ?></b></td>
          <?php echo $this->Disponibilidade->online($servico['Servico']['url'], 'GET'); ?>
        </tr>
      <?php endforeach; ?>
      <?php unset($servico); ?>
    </tbody>
  </table>
</div>
