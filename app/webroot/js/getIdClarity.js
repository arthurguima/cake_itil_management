function getID(Id) {

  var url = document.getElementById(Id+'Url').value;
  var clarity = url.indexOf("www-dtpprojetos");
  var positionIni = url.indexOf("Properties&id=");

  if (url=="" || clarity==-1 || positionIni==-1 ){
    alert("Por favor, insira a URL da demanda do sistema CLARITY!");
    document.getElementById(Id).value= "";
    clearViewClarity();
  }
  else{
    positionIni = positionIni + 14;
    var idClarity = url.substr(positionIni, 7)

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
