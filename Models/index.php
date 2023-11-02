<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Vivienda</title>
    <style>
        h1{
            color: rgb(72, 72, 212);
        }
    </style>
</head>
<body>

    <?php
        function sanitizeFilterString($value){
            $value = strip_tags($value);
            $value = htmlspecialchars($value, ENT_QUOTES);
            return html_entity_decode($value);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //Valida tipo
            if(isset($_POST["tipo"])){
                $tipo = htmlspecialchars($_POST["tipo"]);

                // Sanear tipo
                $tipo = sanitizeFilterString($tipo);

            }

            //Valida zona
            if(isset($_POST["zona"])){
                $zona = htmlspecialchars($_POST["zona"]);

                // Sanear zona
                $zona = sanitizeFilterString($zona);

            }


            // Validar si el campo dirección está vacío
            if (empty($_POST["direccion"])) {
                $errorDireccion = "El campo Dirección es obligatorio.";
            } else {
                $direccion = htmlspecialchars($_POST["direccion"]);
                // Sanear direccion
                $direccion = sanitizeFilterString($direccion);
            }

            // Validar si el campo dormitorios está vacío
            if (empty($_POST["dormitorios"])) {
                $errorDormitorios = "Por favor, selecciona el número de dormitorios.";
            } else {
                $dormitorios = $_POST["dormitorios"];
                // Validar que el valor de dormitorios sea un número entre 1 y 5
                if (!in_array($dormitorios, array("1", "2", "3", "4", "5"))) {
                    $errorDormitorios = "Por favor, selecciona un número válido de dormitorios.";
                }
                
            }

            // Validar si el campo precio está vacío
            if (empty($_POST["precio"])) {
                $errorPrecio = "El campo Precio es obligatorio.";
            } else if(!filter_var($_POST["precio"], FILTER_VALIDATE_FLOAT)){
                $errorPrecio = "El campo Precio debe de ser numerico.";
            } else{
                $precio = htmlspecialchars($_POST["precio"]);
                // Sanear precio
                $precio = filter_var($precio, FILTER_SANITIZE_NUMBER_FLOAT);
            }

            // Validar si el campo tamaño está vacío
            if (empty($_POST["tamano"])) {
                $errorTamano = "El campo Tamaño es obligatorio.";
            } else if(!filter_var($_POST["tamano"], FILTER_VALIDATE_FLOAT)){
                $errorTamano = "El campo Tamaño debe de ser numerico.";
            } else{
                $tamano = htmlspecialchars($_POST["tamano"]);
                // Sanear tamaño
                $tamano = filter_var($tamano, FILTER_SANITIZE_NUMBER_FLOAT);
            }

            //Valida extras
            if(isset($_POST["extras"])){
                $extras = $_POST["extras"];
                $extras = implode(", ", $extras);

                // Sanear extras
                $extras = sanitizeFilterString($extras);

            }

            // Valida y guarda Foto
            if(is_uploaded_file($_FILES["foto"]["tmp_name"])){

                if($_FILES["foto"]["type"] != "image/jpeg"){
                    $errorFoto =  "ERROR: El archivo debe ser una imagen tipo JPEG";
                }elseif($_FILES["foto"]["size"] > 112000){
                    $errorFoto = "ERROR: El archivo no debe esceder de 100KB";
                }else{
                    if(!is_dir("img")){
                        mkdir("img", 0777);
                    }
                    $nombreDirectorio = "img/";
                    $nombreFichero = $_FILES["foto"]["name"];
                    $nombreCompleto = $nombreDirectorio.$nombreFichero;
                
                    if(is_file($nombreCompleto)){
                        $idUnico = time();
                        $nombreFichero = $idUnico."-".$nombreFichero;
                    }
        
                    $res = move_uploaded_file($_FILES["foto"]["tmp_name"], $nombreDirectorio.$nombreFichero);
        
                    if($res){
                        $mensajeFoto = $nombreFichero;
                    }else{
                        $errorFoto = "ERROR: No se ha podido subir la imagen";
                    }
                }
                
            } else{
                $fotoSinSubir = "No se ha subido ningún archivo.";
            }

            //Valida observaciones
            if(!empty($_POST["observaciones"])){
                $observaciones = htmlspecialchars($_POST["observaciones"]);

                // Sanear extras
                $observaciones = sanitizeFilterString($observaciones);
            }
        }
    ?>

    <?php if(isset($direccion) && isset($dormitorios) && isset($precio) && isset($tamano)) : ?>
    <h1>Inserción de vivienda</h1>
    <?php if (!empty($errorFoto)): ?>
        <p>No se ha podido realizar la inserción debido a los siguientes errores: </p>
        <ul>
            <li><?php echo '<span style="color: red;">' . $errorFoto . '</span>';?></li>
        </ul>
        <p>[<a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> Volver </a>]</p>
    <?php else:?>    
        <p>Estos son los datos introducidos: </p>
        <ul>
            <li>Tipo: <?php echo $tipo?></li>
            <li>Zona: <?php echo $zona?></li>
            <li>Direcccion: <?php echo $direccion?></li>
            <li>Numero de dormitorios: <?php echo $dormitorios?></li>
            <li>Precio: <?php echo $precio?></li>
            <li>Tamaño: <?php echo $tamano?></li>
            <li>Extras: <?php if(isset($extras)) echo $extras; else echo "Sin extras"?></li>
            <li>Foto: 
            <?php 
                if(isset($fotoSinSubir)){
                    echo "<span style=\"color:red\">".$fotoSinSubir."</span>";
                }else{
                    echo "<a href=\"img/".$mensajeFoto."\" target=\"_blank\">".$mensajeFoto."</a>";
                }
            ?>
            </li>
            <li>Observaciones: <?php if(isset($observaciones)) echo $observaciones; else echo "Sin observaciones"?></li>
        </ul>

        <p>[<a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> Insertar otra vivienda </a>]</p>

        <?php // Guardamos los datos en el archivo XML
            // Ruta del archivo XML
            $xmlFilePath = 'inmobiliaria.xml';

            
            // Verificar si el archivo XML existe
            if (file_exists($xmlFilePath)) {
                // Cargar el archivo XML existente
                $xml = simplexml_load_file($xmlFilePath);
            } else {
                // Si el archivo no existe, crear un nuevo archivo XML con los datos del formulario
                $xml = new SimpleXMLElement('<inmobiliaria></inmobiliaria>');
            }
            
            // Crear un nuevo nodo para los nuevos datos
            $nuevaVivienda = $xml->addChild('vivienda');
            $nuevaVivienda->addAttribute('tipo', $tipo);
            $nuevaVivienda->addAttribute('zona', $zona);
            $nuevaVivienda->addChild('direccion', $direccion);
            $nuevaVivienda->addChild('dormitorios', $dormitorios);
            $nuevaVivienda->addChild('precio', $precio);
            $nuevaVivienda->addChild('tamano', $tamano);

            $menosDe100 = $tamano<100 ? true:false;
            switch($zona){
                case 'Centro':
                    $menosDe100 ? $beneficio=$precio*0.3:$beneficio=$precio*0.35;
                    break;
                case 'Zaidín':
                    $menosDe100 ? $beneficio=$precio*0.25:$beneficio=$precio*0.28;
                    break;
                case 'Chana':
                    $menosDe100 ? $beneficio=$precio*0.22:$beneficio=$precio*0.25;
                    break;
                case 'Albaicín':
                    $menosDe100 ? $beneficio=$precio*0.2:$beneficio=$precio*0.35;
                    break;
                case 'Sacromonte':
                    $menosDe100 ? $beneficio=$precio*0.22:$beneficio=$precio*0.25;
                    break;
                case 'Realejo':
                    $menosDe100 ? $beneficio=$precio*0.25:$beneficio=$precio*0.28;
                    break;
                default:
                    $beneficio = 0;
                    break;
            }

            $nuevaVivienda->addChild('beneficio', $beneficio);
            if(isset($extras)){
                $nuevoExtra = $nuevaVivienda->addChild('extras');
                foreach($_POST["extras"] as $value){
                    $nuevoExtra->addChild($value);
                }
            }
            if(isset($mensajeFoto)){
                $nuevaVivienda->addChild('foto', $mensajeFoto);
            }
            if(isset($observaciones)){
                $nuevaVivienda->addChild('observaciones', $observaciones);
            }

            // Guardar el XML formateado con sangrías
            $dom = new DOMDocument("1.0");
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($xml->asXML());
            $dom->save($xmlFilePath);
        ?>
    <?php endif?>
    <?php else: ?>
        <h1>Inserción de Vivienda</h1>
    <p>Introduzca los datos de la vivienda: </p>
    <fieldset>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
            <label for="tipo">Tipo de vivienda:</label>
            <select name="tipo" id="tipo">
                <option value="Piso">Piso</option>
                <option value="Adosado">Adosado</option>
                <option value="Chalet">Chalet</option>
                <option value="Casa">Casa</option>
            </select><br><br>
    
            <label for="zona">Zona:</label>
            <select name="zona" id="zona">
                <option value="Centro">Centro</option>
                <option value="Zaidín">Zaidín</option>
                <option value="Chana">Chana</option>
                <option value="Albaicín">Albaicín</option>
                <option value="Sacromonte">Sacromonte</option>
                <option value="Realejo">Realejo</option>
            </select><br><br>
    
            <label for="direccion">* Dirección: </label>
            <input type="text" id="direccion" name="direccion" value="<?php if(isset($direccion))echo $direccion; ?>"><br>
            <?php
                // Mostrar el mensaje de error si existe
                if (!empty($errorDireccion)) {
                    echo '<div style="color: red;">' . $errorDireccion . '</div>';
                }
            ?>
            <br>
    
            <label>Dormitorios:</label><br>
            <input type="radio" id="1" name="dormitorios" value="1" <?php if (isset($dormitorios) && $dormitorios == "1") echo "checked";?>>
            <label for="1">1</label>

            <input type="radio" id="2" name="dormitorios" value="2" <?php if (isset($dormitorios) && $dormitorios == "2") echo "checked";?>>
            <label for="2">2</label>

            <input type="radio" id="3" name="dormitorios" value="3" <?php if (isset($dormitorios) && $dormitorios == "3") echo "checked";?>>
            <label for="3">3</label>

            <input type="radio" id="4" name="dormitorios" value="4" <?php if (isset($dormitorios) && $dormitorios == "4") echo "checked";?>>
            <label for="4">4</label>

            <input type="radio" id="5" name="dormitorios" value="5" <?php if (isset($dormitorios) && $dormitorios == "5") echo "checked";?>>
            <label for="5">5</label><br>
            <?php
                // Mostrar el mensaje de error si existe
                if (!empty($errorDormitorios)) {
                    echo '<div style="color: red;">' . $errorDormitorios . '</div>';
                }
            ?>
            <br>
    
            <label for="precio">Precio:</label>
            <input type="text" id="precio" name="precio" value="<?php if(isset($precio))echo $precio; ?>">
            <label for="precio">€</label><br>
            <?php
                // Mostrar el mensaje de error si existe
                if (!empty($errorPrecio)) {
                    echo '<div style="color: red;">' . $errorPrecio . '</div>';
                }
            ?>
            <br>
    
            <label for="tamano">Tamaño:</label>
            <input type="text" id="tamano" name="tamano" value="<?php if(isset($tamano))echo $tamano; ?>">
            <label for="tamano">metros cuadrados</label><br>
            <?php
                // Mostrar el mensaje de error si existe
                if (!empty($errorTamano)) {
                    echo '<div style="color: red;">' . $errorTamano . '</div>';
                }
            ?>
            <br>
    
            <label>Extras:</label><br>
            <input type="checkbox" id="piscina" name="extras[]" value="Piscina">
            <label for="piscina">Piscina</label><br>
    
            <input type="checkbox" id="jardin" name="extras[]" value="Jardín">
            <label for="jardin">Jardín</label><br>
    
            <input type="checkbox" id="garage" name="extras[]" value="Garage">
            <label for="garage">Garage</label><br><br>
    
            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto"><br><br>
    
            <label for="observaciones">Observaciones:</label><br>
            <textarea id="observaciones" name="observaciones" rows="4" cols="50"><?php if(isset($observaciones))echo $observaciones; ?></textarea><br><br>
    
            <input type="submit" value="Insertar vivienda">
        </form>
    </fieldset>
    <?php endif;?>
</body>
</html>