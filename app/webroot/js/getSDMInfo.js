//Resgata informações de Demandas Cadastradas no Clarity
function getSDMInfo(sdmid, control){
//  $.getJSON( "http://localhost/rotinas/getRdm.php?numero=" + sdmid, function( data ) {
  $.getJSON( "https://www-apps/_projects/dite/rotinas/getRdm.php?numero=" + sdmid, function( data ) {
    $.each( data, function( key, val ) {
      /*if(key == 'dt_prevista')
      {
        //$('ul#rdm').append($('ul#rdm').val() + "<li>" + "Data Prevista: " + val +"</li>");
      }
      if(key == 'dt_executada')
      {
        //$('ul#rdm').append($('ul#rdm').val() + "<li>" + "Data de Execução: " + val +"</li>");
      }*/
      if(key == 'ambiente')
      {
        $('#filterambiente').val(val);
        $('#filterambiente').css('border', '1px solid #4cae4c');
      }
      $('#' + control + toCamelCase(key)).val(val);
      $('#' + control + toCamelCase(key)).val(val).change();
      $('.' + control + toCamelCase(key)).val(val);

      $('#' + control + toCamelCase(key)).css('border', '1px solid #4cae4c');
      $('#' + control + toCamelCase(key)).css('border', '1px solid #4cae4c').change();
      $('.' + control + toCamelCase(key)).css('border', '1px solid #4cae4c');
      //console.log('#' + control + toCamelCase(key) + " - " + val);
    });

    if(control == "rdms"){
     getDemandas($( "select#RdmServicoId option:selected" ).val());
     getChamados($( "select#RdmServicoId option:selected" ).val());
    }
  });
  alert("Este processo pode demorar. Espere alguns segundos pela resposta do SDM!");
}

function toCamelCase(s) {
  return (s||'').toLowerCase().replace(/(\b|_)\w/g, function(m) {
    return m.toUpperCase().replace(/_/,'');
  });
}
