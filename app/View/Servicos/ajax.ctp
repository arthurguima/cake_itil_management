<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover" id="dataTables-Servico">
    <thead>
      <tr>
        <th>Serviço</th>
        <th>Status - Tempo de resposta</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($servicos as $servico): ?>
        <tr>
          <td><b><?php echo $servico['Servico']['sigla']; ?></b></td>
          <td><?php echo $this->Disponibilidade->online($servico['Servico']['url'], 'GET'); ?></td>
        </tr>
      <?php endforeach; ?>
      <?php unset($servico); ?>
    </tbody>
  </table>
</div>
