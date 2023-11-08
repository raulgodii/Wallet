<?php
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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanear los datos de entrada
        if(isset($_POST["edit1"]) && isset($_POST["edit2"]) && isset($_POST["edit3"])){
                $edit1 = filter_var($_POST["edit1"], FILTER_SANITIZE_SPECIAL_CHARS);
                $edit2 = filter_var($_POST["edit2"], FILTER_SANITIZE_SPECIAL_CHARS);
                $edit3 = filter_var($_POST["edit3"], FILTER_SANITIZE_SPECIAL_CHARS);
                $index = $_GET["index"];

            // Validación de los campos (por ejemplo, asegurándose de que no estén vacíos)
            $errors = [];
        
            if (empty($edit1)) {
                $errors[] = "<b>Concept</b> is obligatory";
            } else if(!validarConcepto($edit1)) {
                $errors[] = "<b>Concept</b> is not valid";
            }
        
            if (empty($edit2)) {
                $errors[] = "<b>Date</b> is obligatory";
            } else if(!validarFecha($edit2)) {
                $errors[] = "<b>Date</b> is not valid (must be dd/mm/yyyy)";
            }
        
            if (empty($edit3)) {
                $errors[] = "<b>Amount</b> is obligatory";
            }else if(!validarCantidad($edit3)) {
                $errors[] = "<b>Amount</b> is not valid";
            }
        
            // Si no hay errores, se procede
            if (empty($errors)) {
                // Luego, redirige al usuario al controlador
                header("Location:index.php?controller=Wallet&action=editNewRegister&input1=$edit1&input2=$edit2&input3=$edit3&index=$index");
            }
        }
    }


    if(!empty($registers)){
        foreach ($registers["register"] as $index => $register) {
            if(is_array($register)){
                if(isset($indexInput) && ($index == $indexInput[0])){
                    echo '<tr>';
                    echo '<form action="index.php?index='.$indexInput[0].'" method="POST">';
                    echo '<td>' . '<input type="text" style="border: 1px solid black" name="edit1" value=' . $register['concept']; if(isset($edit1)) echo $edit1; echo '>' . '</td>';
                    echo '<td>' . '<input type="text" style="border: 1px solid black" name="edit2" value=' . $register['date']; if(isset($edit2)) echo $edit; echo '>' . '</td>';
                    echo '<td>' . '<input type="text" style="border: 1px solid black" name="edit3" value=' . $register['amount']; if(isset($edit3)) echo $edit3; echo '>' . '</td>';
                    echo "<td>"."
                        <button>Confirm
                            <span></span>
                        </button>".
                            "</td>";
                    echo '</form>';
                    echo '</tr>';
                }else{
                    echo '<tr>';
                    echo '<td>' . $register['concept'] . '</td>';
                    echo '<td>' . $register['date'] . '</td>';
                    echo '<td>' . $register['amount'] . '</td>';
                    echo "<td><a href=\"index.php?controller=Wallet&action=editRegister&index=$index\">";
                    echo "<button>Edit";
                    echo "<span></span>";
                    echo "</button></a>";
                    echo "<a href=\"index.php?controller=Wallet&action=deleteRegister&index=$index\">";
                    echo "<button>Delete";
                    echo "<span></span>";
                    echo "</button></a></td>";
                    echo '</tr>';
                }
            }else{
                if(isset($indexInput) && ($index == $indexInput[0])){
                    echo '<tr>';
                    echo '<form action="index.php?index='.$indexInput[0].'" method="POST">';
                    echo '<td>' . '<input type="text" style="border: 1px solid black" name="edit1" value=' . $registers['register']['concept']; if(isset($edit1)) echo $edit1; echo '>' . '</td>';
                    echo '<td>' . '<input type="text" style="border: 1px solid black" name="edit2" value=' . $registers['register']['date']; if(isset($edit2)) echo $edit2; echo '>' . '</td>';
                    echo '<td>' . '<input type="text" style="border: 1px solid black" name="edit3" value=' . $registers['register']['amount']; if(isset($edit3)) echo $edit3; echo '>' . '</td>';
                    echo "<td>"."
                        <button>Confirm
                            <span></span>
                        </button>".
                            "</td>";
                    echo '</form>';
                    echo '</tr>';
                    break;
                }else{
                    echo '<tr>';
                    echo '<td>' . $registers['register']['concept'] . '</td>';
                    echo '<td>' . $registers['register']['date'] . '</td>';
                    echo '<td>' . $registers['register']['amount'] . '</td>';
                    echo "<td>"."
                        <a href=\"index.php?controller=Wallet&action=editRegister&index=$index\">
                        <button>Edit
                            <span></span></button></a>
                        <a href=\"index.php?controller=Wallet&action=deleteRegister&index=$index\">
                        <button>Delete
                            <span></span>
                        </button></a>".
                            "</td>";
                    echo '</tr>';
                    break;
                }
            }
        }
    }
?>