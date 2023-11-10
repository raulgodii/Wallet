<?php
    // Registro de autocarga de clases utilizando la función anónima de spl_autoload_register
    spl_autoload_register(function ($class) {
        // Reemplazar barras invertidas (\) con barras normales (/) en el nombre de la clase
        $directorio_clase = str_replace('\\', '/', $class);

        // Verificar si el archivo de la clase existe y cargarlo si es así
        if (file_exists($directorio_clase . '.php')) {
            require $directorio_clase . '.php';
        }
    });
?>