<?php  App::import('Vendor', 'ldapInclude', array('file' => 'ldapInclude.php'));

class LdapHelper extends AppHelper {

  public function nomeUsuario(){
    if(isset($_SESSION['nome'])){
      return $_SESSION['nome'];
    }
    else{
      return "";
    }
  }

  public function emailUsuario(){
    if(isset($_SESSION['email'])){
      return $_SESSION['email'];
    }
    else{
      return "";
    }
  }

  public function matriculaUsuario(){
    if(isset($_SESSION['cdUsuario'])){
      return $_SESSION['cdUsuario'];
    }
    else{
      return "";
    }
  }

  public function idUsuario(){
    if(isset($_SESSION['idFuncionario'])){
      return $_SESSION['idFuncionario'];
    }
    else{
      return "";
    }
  }

  public function unidadeUsuario(){
    if(isset($_SESSION['estUser'])){
      return $_SESSION['estUser'];
    }
    else{
      return "";
    }
  }

  public function nomeUnidadeUsuario(){
    if(isset($_SESSION['nmUsuario'])){
      return $_SESSION['nmUsuario'];
    }
    else{
      return "";
    }
  }

  public function telefoneUsuario(){
    if(isset($_SESSION['nome'])){
      return $_SESSION['nome'];
    }
    else{
      return "";
    }
  }

  public function redeUsuario(){
    if(isset($_SESSION['auth_user'])){
      return $_SESSION['auth_user'];
    }
    else{
      return "";
    }
  }

  public function autorizado(){
    if(isset($_SESSION['email'])){
      if($_SESSION['email']==='arthur.doliveira@dataprev.gov.br' || //$_SESSION['email']==='lucas.lmendonca@dataprev.gov.br' ||
        $_SESSION['email']==='humbertho.mattar@dataprev.gov.br' || $_SESSION['email']==='ynga.povoa@dataprev.gov.br' ||
        $_SESSION['email']==='rodrigo.vieira@dataprev.gov.br' ){
        return true;
      }
      else{
        return false;
      }
    }
  }

}?>
