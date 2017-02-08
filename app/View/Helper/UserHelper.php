<?php class UserHelper extends AppHelper {

  public function select2(){
    return "
      $(\".select2user\").select2({
        placeholder: \"Usuário\",
        minimumInputLength: 3,
        width: \"100%\",
        ajax: {
            url: '". Router::url('/', true) ."' + 'users/json',
            dataType: 'json',
            delay: 250,
            data: function (params) {
              return {
                q: params.term, // search term
              };
            },
            processResults: function (data, params) {
              return {
                results: data,
              };
            },
            cache: true
        },
      });
    ";
  }

}?>
