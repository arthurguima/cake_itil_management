//Resgata informações de Demandas Cadastradas no Clarity
function getClarityInfo(dm, control){
//  $.getJSON( "http://bsad225949///wsdl/sgdGetClarity.php?dmClarity=" + dm, function( data ) {
  $.getJSON( "https://www-apps/_projects/dite/wsdl/sgdGetClarity.php?dmClarity=" + dm, function( data ) {
    $.each( data, function( key, val ) {
      $('#' + control + toCamelCase(key)).val(val);
      $('.' + control + toCamelCase(key)).val(val);

      $('#' + control + toCamelCase(key)).css('border', '1px solid #4cae4c');
      $('.' + control + toCamelCase(key)).css('border', '1px solid #4cae4c');
      //console.log('#' + control + toCamelCase(key) + " - " + val);

      if(key == 'statusSGD'){
        $("#SsStatusId").val(val);
        $('#SsStatusId').css('border', '1px solid #4cae4c');
      }
    });
  });
  alert("Este processo pode demorar. Espere alguns segundos pela resposta do Clarity!");
}

function getClarityInfoOnView(dm, control){
//  $.getJSON( "http://bsad229628//wsdl/sgdGetClarity.php?dmClarity=" + dm, function( data ) {
  $.getJSON( "https://www-apps/_projects/dite/wsdl/sgdGetClarity.php?dmClarity=" + dm, function( data ) {
    $('.load').remove();
    $.each( data, function( key, val ) {
      if(key == 'dt_prevista')
        $('ul#clarity').append($('ul#clarity').val() + "<li>" + "Data Prevista: " + val +"</li>");
      else
        if (key == 'status')
          $('ul#clarity').append($('ul#clarity').val() + "<li>" + "Status: " + val +"</li>");
      //console.log(key + ' -> ' + val);
    });
  });
}


function toCamelCase(s) {
  return (s||'').toLowerCase().replace(/(\b|_)\w/g, function(m) {
    return m.toUpperCase().replace(/_/,'');
  });
}
