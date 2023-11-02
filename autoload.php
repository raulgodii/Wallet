<?php
    spl_autoload_register(function ($class) {
        $directorio_clase = str_replace('\\', '/', $class);
        if (file_exists($directorio_clase . '.php')) {
            require $directorio_clase . '.php';
        }
    });
?>