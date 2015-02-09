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

  public function autorizado($tipo){
    if(isset($_SESSION['email']) && ($tipo == 1)){
      if($_SESSION['email']==='arthur.doliveira@dataprev.gov.br' || //$_SESSION['email']==='lucas.lmendonca@dataprev.gov.br' ||
        $_SESSION['email']==='humbertho.mattar@dataprev.gov.br' || //$_SESSION['email']==='ynga.povoa@dataprev.gov.br' ||
        $_SESSION['email']==='rodrigo.vieira@dataprev.gov.br' ){
        return true;
      }
      else{
        return false;
      }
    }
    if(isset($_SESSION['email']) && ($tipo == 2)){
      if($_SESSION['email']==='adriana.almeida@dataprev.gov.br' || $_SESSION['email']==='andre.garcia@dataprev.gov.br' || $_SESSION['email']==='arthur.doliveira@dataprev.gov.br'
        || $_SESSION['email']==='cesar.aguiar@dataprev.gov.br' || $_SESSION['email']==='dejanira.freitas@dataprev.gov.br' || $_SESSION['email']==='fabricio.mgomes@dataprev.gov.br' || $_SESSION['email']==='fernando.legey@dataprev.gov.br'
        || $_SESSION['email']==='helton.souza@dataprev.gov.br' || $_SESSION['email']==='humbertho.mattar@dataprev.gov.br' || $_SESSION['email']==='joaopaulo.paz@dataprev.gov.br' || $_SESSION['email']==='jose.carloslima@dataprev.gov.br'
        || $_SESSION['email']==='jose.espasandin@dataprev.gov.br' || $_SESSION['email']==='lucas.lmendonca@dataprev.gov.br' || $_SESSION['email']==='manuel.romano@dataprev.gov.br' || $_SESSION['email']==='monica.alvariz@dataprev.gov.br'
        || $_SESSION['email']==='ricardo.gomes@dataprev.gov.br' || $_SESSION['email']==='rodrigo.vieira@dataprev.gov.br' || $_SESSION['email']==='ronan.ferreira@dataprev.gov.br' || $_SESSION['email']==='sabrina.ssantos@dataprev.gov.br'
        || $_SESSION['email']==='thais.guimaraes@dataprev.gov.br' || $_SESSION['email']==='thiago.mribeiro@dataprev.gov.br' || $_SESSION['email']==='victor.pbatista@dataprev.gov.br' || $_SESSION['email']==='viviane.cesario@dataprev.gov.br'
        || $_SESSION['email']==='volney.sousa@dataprev.gov.br' || $_SESSION['email']==='ynga.povoa@dataprev.gov.br' ){
        return true;
      }
      else{
        return false;
      }
    }
  }

}?>
