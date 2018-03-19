<?php class FiltrosHelper extends AppHelper {



  public function btnSave($page, $user, $id = "'null'"){

    if($id == "'null'"){
      $btn = '<span class="btn btn-default pull-right" onclick="javascript:btnSave(\''.$page.'\','.$user.', ' . $id .')">
                Favoritar <i class="fa fa-star filter-fa-star" aria-hidden="true"></i>
              </span>';

      $js = "<script>
              function btnSave(page, user, id){
                  $.post(\"" . Router::url('/', true). "filtros/update?page=\" + page + \"&user=\" + user, $(\"#form-filter-results\").serialize().replace(/[^&]+=\.?(&|$)/g, ''));
                  $(\".filter-fa-star\").css('color', 'gold');
              };
            </script>";
    }
    else{
      $btn = '<span class="btn btn-default pull-right" onclick="javascript:btnDelete(' . $id .')">
                Excluir Favorito <i class="fas fa-times filter-fa-remove" aria-hidden="true"></i>
              </span>
              <span class="btn btn-default pull-right" onclick="javascript:btnSave(\''.$page.'\','.$user.', ' . $id .')">
                Favoritar <i class="fa fa-star filter-fa-star" aria-hidden="true"></i>
              </span>
              ';

      $js = "<script>
              function btnSave(page, user, id){
                  $.post(\"" . Router::url('/', true). "filtros/update?page=\" + page + \"&user=\" + user + \"&id=\" + id, $(\"#form-filter-results\").serialize().replace(/[^&]+=\.?(&|$)/g, ''));
                  $(\".filter-fa-star\").css('color', 'gold');
              };

              function btnDelete(id){
                  $.post(\"" . Router::url('/', true). "filtros/delete?id=\" + id);
                  $(\".filter-fa-remove\").css('color', 'red');
              };
            </script>";
    }

    return $btn . $js;
  }

  public function camelCase(){
    return "
      function toCamelCase(s) {
        return (s||'').toLowerCase().replace(/(\b|_)\w/g, function(m) {
          return m.toUpperCase().replace(/_/,'');
        });
      };
    ";
  }

  public function fillForm(){
      return "
        $.each(filtro_array['filter'], function( index, value ) {
          $('#filter' + toCamelCase(index).replace(\"Between\", \"between\")).val(value).change;
          $('#filter' + toCamelCase(index).replace(\"Between\", \"between\")).val(value).change();
          $('#filter' + toCamelCase(index).replace(\"Between\", \"between\")).css('border', '2px solid #4cae4c');
        });
      ";
  }

  public function fillFormB(){
      return "
        $.each(filtro_array, function( index, value ) {
          $(\"#\" + index).val(value).change();
          $(\"#\" + index).css('border', '2px solid #4cae4c').change();
        });
      ";
  }

}?>
