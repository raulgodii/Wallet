<?php
    namespace Lib;

    class Pages{
        /**
         * Renderiza una página con parámetros opcionales.
         *
         * @param string $pageName El nombre de la página a renderizar.
         * @param array|null $params Parámetros opcionales para la página.
         * @return void
         */
        public function render(string $pageName, array $params = null): void {
            // Verifica si $params no es nulo
            if($params != null){
                // Recorre cada par clave-valor en $params
                foreach($params as $name => $value){
                    // Crea una variable con el mismo nombre que la clave y le asigna el valor correspondiente
                    $$name = $value;
                }
            }

            // Incluye el archivo de encabezado para el diseño
            require_once "views/layout/header.php";
            // Incluye el archivo de encabezado principal para el diseño
            require_once "views/layout/mainHeader.php";
            // Incluye el archivo de contenido para la página especificada
            require_once "views/$pageName.php";
            // Incluye el archivo de pie de página principal para el diseño
            require_once "views/layout/mainFooter.php";
            // Incluye el archivo de pie de página para el diseño
            require_once "views/layout/footer.php";
        }
    }
?>