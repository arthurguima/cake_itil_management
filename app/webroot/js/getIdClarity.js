function getID(Id) {

  var url = document.getElementById(Id+'Url').value;

  if (url==""){
    alert("Por favor, insira a URL da demanda do sistema CLARITY!");
    document.getElementById(Id).value= "";
    clearViewClarity();
  }
  else{
    var positionIni = url.indexOf("Properties&id=");
    var idClarity = (/Properties&id=([0-9]+)/).exec(url)[1];
    
    if(isNaN(idClarity)==true){
  		alert("Por favor, insira a URL da demanda do sistema CLARITY!\n\n - N�o foi poss�vel obter o ID da demanda. [ID IS NUMERIC]");
  		document.getElementById(Id+'Id').value= "";
  		clearViewClarity();
  	}
    else{
    	document.getElementById(Id+'Id').value = idClarity;
      //document.getElementsByClassName('idclarity').value = idClarity;
    	showViewClarity(idClarity);
  	}
  }
}


function getIDOnEdit(idClarity){
  showViewClarity(idClarity);
}

function indexClarity(idClarity){
  document.getElementById('demandaFrame').src = "http://www-dtpprojetos/niku/nu#action:pma.ideaProperties&id=" + idClarity;
}

function showViewClarity(idClarity){
  document.getElementById("viewClarity").innerHTML = "<i class='fa fa-expand' style='cursor:pointer;' title='Clique aqui para testar a integração da demanda com o sistema Clarity!'></i>";
  document.getElementById('demandaFrame').src = "http://www-dtpprojetos/niku/nu#action:pma.ideaProperties&id=" + idClarity;
}

function clearViewClarity(){
  document.getElementById( "viewClarity" ).innerHTML = "";
}
