//Resgata informações de Demandas Cadastradas no Clarity
function getClarityInfo(dm, control){
  $.getJSON( "http://bsad225949//wsdl/sgdGetClarity.php?dmClarity=" + dm, function( data ) {
//  $.getJSON( "http://www-apps/_projects/dite/wsdl/sgdGetClarity.php?dmClarity=" + dm, function( data ) {
    $.each( data, function( key, val ) {
      $('#' + control + toCamelCase(key)).val(val);
      $('.' + control + toCamelCase(key)).val(val);

      $('#' + control + toCamelCase(key)).css('border', '1px solid #4cae4c');
      $('.' + control + toCamelCase(key)).css('border', '1px solid #4cae4c');
      //console.log('#' + control + toCamelCase(key) + " - " + val);
    });
  });
  alert("Este processo pode demorar. Espere alguns segundos pela resposta do Clarity!");
}


function toCamelCase(s) {
  return (s||'').toLowerCase().replace(/(\b|_)\w/g, function(m) {
    return m.toUpperCase().replace(/_/,'');
  });
}
