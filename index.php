<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Wallet</title>
</head>
<body>
    <?php
        // Incluir el archivo de autocarga de clases y la configuración
        require_once 'autoload.php';
        require_once 'config/config.php';

        // Utilizar el espacio de nombres Controllers y la clase FrontController
        use Controllers\FrontController;

        // Llamar al método estático main de la clase FrontController
        FrontController::main();
    ?>
</body>
</html>