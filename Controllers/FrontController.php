<?php
namespace Controllers;

/**
 * Clase FrontController
 * 
 * Esta clase es responsable de dirigir las solicitudes del programa web al controlador correspondiente y ejecutar la acción solicitada.
 */
class FrontController {

    /**
     * Método estático main
     * 
     * Este método es el punto de entrada del programa y maneja las solicitudes entrantes.
     * Determina el controlador y la acción a ejecutar según los parámetros GET proporcionados en la URL.
     * Si la clase del controlador y la acción existen, se crea una instancia del controlador y se llama a la acción correspondiente.
     * Si no se proporciona un controlador o una acción en los parámetros GET, se utiliza el controlador y acción predeterminados.
     * Si no se encuentra la clase del controlador o la acción solicitada, se muestra un mensaje de error 404.
     * 
     * @return void
     */
    public static function main(): void {

        if (isset($_GET['controller'])) {
            $nombre_controlador = 'Controllers\\' . $_GET['controller'] . 'Controller';
        } else {
            $nombre_controlador = 'Controllers\\' . CONTROLLER_DEFAULT;
        }

        // Si la clase del controlador existe, creamos una instancia del controlador y llamamos a la acción correspondiente
        if (class_exists($nombre_controlador)) {
            $controlador = new $nombre_controlador();
            if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
                $action = $_GET['action'];
                $controlador->$action();
            } else if (!isset($_GET['controller']) && !isset($_GET['action'])) {
                $action_default = ACTION_DEFAULT;
                $controlador->$action_default();
            } else {
                echo ErrorController::show_error404("No se ha podido encontrar la <b>[acción]</b> en el controlador \"" . $nombre_controlador . "\"");
            }
        } else {
            echo ErrorController::show_error404("No se ha podido encontrar la <b>[clase]</b> en el controlador \"" . $nombre_controlador . "\"");
        }
    }
}
?>