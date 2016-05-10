//Resgata informações de Incidentes Cadastradas no SDM
function getSDMInfoIndisponibilidades(sdmid, sdmano, control){
  //$.getJSON( "http://localhost//wsdl-sdm/sgdGetIndisponibilidadeSDM.php?numero=" + sdmid + "/" + sdmano, function( data ) {
  $.getJSON( "http://www-apps/_projects/dite/wsdl-sdm/sgdGetIncidenteSDM.php?numero=" + sdmid + "/" + sdmano, function( data ) {
    $.each( data, function( key, val ) {
      if(key == 'servico_id')
      {
        $("#ServicoServico").select2("val",val)
        $("#s2id_ServicoServico").css('border', '1px solid #4cae4c');
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
