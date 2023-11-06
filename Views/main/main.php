<?php

// <form action="index.php?controller=Wallet&action=addRegister" method="post">
// <td><input class="inputMain" type="text" name="input1"></td>
// <td><input class="inputMain" type="text" name="input2"></td>
// <td><input class="inputMain" type="text" name="input3"></td>
// <td><button type="submit" class="addRegister">Add Register<span></span></button></td>
// </form>

    if(!empty($registers)){
        foreach ($registers["register"] as $index => $register) {
            if(is_array($register)){
                if(isset($indexInput) && ($index == $indexInput[0])){
                    echo '<tr>';
                    echo '<form action="index.php?controller=Wallet&action=editNewRegister&index='.$indexInput[0].'" method="post">';
                    echo '<td>' . '<input type="text" class="edit" name="input1" value=' . $register['concept'] . '>' . '</td>';
                    echo '<td>' . '<input type="text" class="edit" name="input2" value=' . $register['date'] . '>' . '</td>';
                    echo '<td>' . '<input type="text" class="edit" name="input3" value=' . $register['amount'] . '>' . '</td>';
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
                    echo "<td>"."
                        <a href=\"index.php?controller=Wallet&action=editRegister&index=$index\">
                        <button>Edit
                            <span></span></button></a>
                        <a href=\"index.php?controller=Wallet&action=deleteRegister&index=$index\">
                        <button>Delete
                            <span></span>
                        </button>".
                            "</td>";
                    echo '</tr>';
                }
            }else{
                if(isset($indexInput) && ($index == $indexInput[0])){
                    echo '<tr>';
                    echo '<form action="index.php?controller=Wallet&action=editNewRegister&index='.$indexInput[0].'"" method="post">';
                    echo '<td>' . '<input type="text" class="edit" name="input1" value=' . $registers['register']['concept'] . '>' . '</td>';
                    echo '<td>' . '<input type="text" class="edit" name="input2" value=' . $registers['register']['date'] . '>' . '</td>';
                    echo '<td>' . '<input type="text" class="edit" name="input3" value=' . $registers['register']['amount'] . '>' . '</td>';
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