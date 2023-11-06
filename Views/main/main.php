<?php
    $sum = 0;
    if(!empty($registers)){
        foreach ($registers["register"] as $index => $register) {
            echo '<tr>';
            echo '<td>' . $register['concept'] . '</td>';
            echo '<td>' . $register['date'] . '</td>';
            echo '<td>' . $register['amount'] . '</td>';
            echo "<td>"."
                <a href=\"\">
                <button>Editar
                    <span></span></button></a>
                <a href=\"index.php?controller=Wallet&action=deleteRegister&index=$index\">
                <button>Borrar
                    <span></span>
                </button></a>".
                    "</td>";
            echo '</tr>';
        }
    }
?>