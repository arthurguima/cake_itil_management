<?php class HistoricosHelper extends AppHelper {

  public function findLinks($text){
      $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.*[a-zA-Z0-9]{2,5}(\/\S*)?/";
      preg_match_all($reg_exUrl, $text, $matches);
      $usedPatterns = array();
      foreach($matches[0] as $pattern){
          if(!array_key_exists($pattern, $usedPatterns)){
              $usedPatterns[$pattern]=true;
              $text = str_replace  ($pattern, "<a target='_blank' href=" . $pattern . ">" . "Link" . "</a> ", $text);
          }
      }
      return $text;
  }
}
?>
