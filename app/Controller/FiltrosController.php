<?php class FiltrosController extends AppController {

  public function update() {
    $this->layout = false;
    $data = Array();
    //debug($this->request->data);
    if ($this->request->data) {
      $data['Filtro']['valor'] = serialize($this->request->data);
      $data['Filtro']['user_id'] = $this->params['url']['user'];
      $data['Filtro']['pagina'] = $this->params['url']['page'];

      if(isset($this->params['url']['id'])){
        $this->Filtro->id = $this->params['url']['id'];
        $this->Filtro->save($data);
      }else{
        $this->Filtro->create();
        $this->Filtro->save($data);
      }
		}
  }

  public function delete() {
    $this->layout = false;
    $this->Filtro->id = $this->params['url']['id'];
    $this->Filtro->delete();

    return 200;
  }
}?>
