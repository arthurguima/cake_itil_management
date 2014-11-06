<?php  App::import('Vendor', 'ldapInclude', array('file' => 'ldapInclude.php'));

class LdapHelper extends AppHelper {

  public function nomeUsuario(){
    return $_SESSION['nome'];
  }

  public function emailUsuario(){
    return $_SESSION['email'];
  }

  public function matriculaUsuario(){
    return $_SESSION['cdUsuario'];
  }

  public function idUsuario(){
    return $_SESSION['idFuncionario'];
  }

  public function unidadeUsuario(){
    return $_SESSION['estUser'];
  }

  public function nomeUnidadeUsuario(){
    return $_SESSION['nmUsuario'];
  }

  public function telefoneUsuario(){
    return $_SESSION['nome'];
  }

  public function redeUsuario(){
    return $_SESSION['auth_user'];
  }

}?>
