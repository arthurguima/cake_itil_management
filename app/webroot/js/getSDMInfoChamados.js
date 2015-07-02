//Resgata informações de Demandas Cadastradas no Clarity
function getSDMInfoChamados(sdmid, sdmano, control){
  //alert(sdmid);
  //alert ("http://localhost//wsdl-sdm/sgdGetChamadoSDM.php?numero=" + sdmid + "/" + sdmano);
  $.getJSON( "http://localhost//wsdl-sdm/sgdGetChamadoSDM.php?numero=" + sdmid + "/" + sdmano, function( data ) {
//  $.getJSON( "http://www-apps/_projects/dite/wsdl/sgdGetClarity.php?dmClarity=" + dm, function( data ) {
    $.each( data, function( key, val ) {
      if(key == 'dt_prevista')
      {
        $('ul#rdm').append($('ul#rdm').val() + "<li>" + "Data Prevista: " + val +"</li>");
      }
      if(key == 'dt_executada')
      {
        $('ul#rdm').append($('ul#rdm').val() + "<li>" + "Data de Execução: " + val +"</li>");
      }
      if(key == 'ambiente')
      {
        $('ul#rdm').append($('ul#rdm').val() + "<option value="+ val +" selected='selected'>Produção</option>");
      }
      $('#' + control + toCamelCase(key)).val(val);
      $('.' + control + toCamelCase(key)).val(val);

      $('#' + control + toCamelCase(key)).css('border', '1px solid #4cae4c');
      $('.' + control + toCamelCase(key)).css('border', '1px solid #4cae4c');
      //console.log('#' + control + toCamelCase(key) + " - " + val);
    });
  });
  alert("Este processo pode demorar. Espere alguns segundos pela resposta do SDM!");
}

function toCamelCase(s) {
  return (s||'').toLowerCase().replace(/(\b|_)\w/g, function(m) {
    return m.toUpperCase().replace(/_/,'');
  });
}
