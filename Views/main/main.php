<?php
    $sum = 0;
    foreach($registers as $tr){
        echo "<tr>";
            foreach($tr as $i=>$td){
                echo "<td>".$td."</td>";
                if($i=="amount"){
                    $sum += $td;
                }
            }
            echo "<td>"."
            <button>Editar
                <span></span></button>
            <button>Borrar
                <span></span>
            </button>".
                "</td>";
        echo "</tr>";
    }
?>