<?php
    namespace Controllers;

    class ErrorController{
        public static function show_error404($error):string
        {
            return "<p>La página que buscas no existe: ". $error . "</p>";
        }
    }
?>