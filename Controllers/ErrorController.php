<?php
namespace Controllers;

/**
 * Clase ErrorController
 * 
 * Esta clase maneja los errores y muestra un mensaje de error 404.
 */
class ErrorController {
    
    /**
     * Método estático show_error404
     * 
     * Este método muestra un mensaje de error 404 junto con el mensaje de error proporcionado.
     * 
     * @param string $error El mensaje de error específico.
     * @return string El mensaje de error completo con formato HTML.
     */
    public static function show_error404($error): string {
        return "<p>La página que buscas no existe: " . $error . "</p>";
    }
}
?>