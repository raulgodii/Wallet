<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanear los datos de entrada
        if(isset($_POST["input1"]) && isset($_POST["input2"]) && isset($_POST["input3"])){
                $input1 = filter_var($_POST["input1"], FILTER_SANITIZE_SPECIAL_CHARS);
                $input2 = filter_var($_POST["input2"], FILTER_SANITIZE_SPECIAL_CHARS);
                $input3 = filter_var($_POST["input3"], FILTER_SANITIZE_SPECIAL_CHARS);
            

            // Validación de los campos (por ejemplo, asegurándose de que no estén vacíos)
            $errors = [];
        
            if (empty($input1)) {
                $errors[] = "<b>Concept</b> is obligatory";
            } else if(!validarConcepto($input1)) {
                $errors[] = "<b>Concept</b> is not valid";
            }
        
            if (empty($input2)) {
                $errors[] = "<b>Date</b> is obligatory";
            } else if(!validarFecha($input2)) {
                $errors[] = "<b>Date</b> is not valid (must be dd/mm/yyyy)";
            }
        
            if (empty($input3)) {
                $errors[] = "<b>Amount</b> is obligatory";
            }else if(!validarCantidad($input3)) {
                $errors[] = "<b>Amount</b> is not valid";
            }
        
            // Si no hay errores, se procede
            if (empty($errors)) {
                // Luego, redirige al usuario al controlador
                header("Location:index.php?controller=Wallet&action=addRegister&input1=$input1&input2=$input2&input3=$input3");
            }
        }
    }

    function validarConcepto($concepto) {
        // Validar que el concepto solo contenga letras y espacios
        if (preg_match("/^[a-zA-Z ]+$/", $concepto)) {
            return true;
        } else {
            return false;
        }
    }

    function validarFecha($fecha) {
        // Validar el formato de fecha (YYYY-MM-DD)
        if (preg_match("/^(\d{2})\/(\d{2})\/(\d{4})$/", $fecha, $matches)) {
            // Verificar si la fecha es válida
            if (checkdate($matches[2], $matches[1], $matches[3])) {
                return true;
            }
        }
        return false;
    }

    function validarCantidad($cantidad) {
        // Validar que la cantidad sea un número flotante
        if (is_numeric($cantidad)) {
            return true;
        } else {
            return false;
        }
    }
?>
<form action="index.php" method="post">
    <tr>
        <td><input class="inputMain" type="text" name="input1"<?php if(isset($input1)) echo "value=\"$input1\""?> /></td>
        <td><input class="inputMain" type="text" name="input2"<?php if(isset($input2)) echo "value=\"$input2\""?> /></td>
        <td><input class="inputMain" type="text" name="input3"<?php if(isset($input3)) echo "value=\"$input3\""?> /></td>
        <td><button type="submit" class="addRegister">Add Register<span></span></button></td>
    </tr>
</form>
</table>
<?php
    // Muestra mensajes de error si hay alguno
    if (!empty($errors)) {
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li style='color:red'>$error</li>";
        }
        echo "</ul>";
    }
?>
<br>
<form action="index.php?controller=Wallet&action=searchConcept" method="POST">
    <label for="search">Search concept</label>
    <input type="search" id="search" name="search">

    <input class="search" type="submit" value="Search">
</form>

<table class="res">
    <tr>
        <td><b>Total Registers</b></td>
        <td><?php 
        if(!empty($registers)){
            if(is_array($register)){
                echo count($registers["register"]); 
            }else echo 1;
        }else echo 0;
        
        ?></td>
    </tr>
    <tr>
        <td><b>Total Balance</b></td>
        <td><?php
        if(!empty($registers)){
            $totalBalance = 0;
            foreach ($registers["register"] as $value) {
                if(is_array($register)){
                    $totalBalance += floatval($value['amount']);
                }else{
                    if(is_numeric($registers['register']['amount'])){
                        echo $registers['register']['amount'];
                        break;
                    } else{
                        echo 0;
                        break;
                    }
                }
            }
            if(is_array($register)) echo $totalBalance;
        } else echo 0;
        ?></td>
    </tr>
    <tr>
        <td colspan="2"><a href="index.php"><button class="seeAll">See all registers<span></span></button></a></td>
    </tr>
</table>
<br>