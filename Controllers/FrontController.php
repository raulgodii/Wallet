<?php
    namespace Controllers;

    class FrontController{
        public static function main():void {

            if(isset($_GET['controller'])){
                $nombre_controlador = 'Controllers\\'.$_GET['controller'].'Controller';
            }else{
                $nombre_controlador = 'Controllers\\' . CONTROLLER_DEFAULT;
            }
            
            // Si ha ido bien creamos una instancia del controlador y llamamos a la acción
            if(class_exists($nombre_controlador)){
                $controlador = new $nombre_controlador();
                if(isset($_GET['action']) && method_exists($controlador, $_GET['action'])){
                    $action = $_GET['action'];
                    $controlador->$action();
                }else if(!isset($_GET['controller']) && !isset($_GET['action'])){
                    $action_default = ACTION_DEFAULT;
                    $controlador->$action_default();
                }else{
                    echo ErrorController::show_error404("No se ha podido encontrar la <b>[acción]</b> en el controlador \"" . $nombre_controlador . "\"");
                }
            } else{
                echo ErrorController::show_error404("No se ha podido encontrar la <b>[clase]</b> en el controlador \"" . $nombre_controlador . "\"");
            }
        }
    }
?>