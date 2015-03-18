<?php
// app/View/Helper/TinyMCEHelper.php

/**
 * Helper para configuracao e criacao do editor usando TinyMCE version 4.0.5
 * @author: Tayron Miranda
 * @since : 10/09/2013 08:48
 * @version: 1.0
 */
class TinyMCEHelper extends AppHelper {

    var $helpers = Array('Html');

        public function inicialize( $width = 900, $heigth = 500 )
        {
                echo $this->Html->script( 'plugins/tinymce/js/tinymce/tinymce.min.js' );

                $script  = "tinyMCE.init({
                      'language' : \"pt_BR\",
                      'selector': \"textarea\",
                      'thema': \"modern\",
                      'width' : {$width},
                      'height' : {$heigth},
                      plugins: [
                          'advlist autolink lists link image charmap print preview anchor',
                          'searchreplace visualblocks code fullscreen',
                          'insertdatetime media table contextmenu paste'
                      ],
                      toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                      'autosave_ask_before_unload': false
                	 })
                ";

                echo $this->Html->scriptBlock( $script );
        }
}
?>
