    </tbody>
        <tr>
        <form action="index.php?controller=Wallet&action=addRegister" method="post">
            <td><input class="inputMain" type="text" name="input1"></td>
            <td><input class="inputMain" type="text" name="input2"></td>
            <td><input class="inputMain" type="text" name="input3"></td>
            <td><button type="submit" class="addRegister">Add Register<span></span></button></td>
        </form>
            <!-- <td><input class="inputMain" type="text"></td>
            <td><input class="inputMain" type="text"></td>
            <td><input class="inputMain" type="text"></td>
            <td><a href="index.php?controller=Wallet&action=addRegister"><button class="addRegister">Add Register<span></span></button></a></td> -->
        </tr>
</table>
<br>
<form action="">
    <label for="search">Search concept</label>
    <input type="search" id="search" name="search">

    <input class="search" type="submit" value="Search">
</form>

<table class="res">
    <tr>
        <td><b>Total Registers</b></td>
        <td><?php if(!empty($registers)) echo count($registers["register"]); else echo 0;?></td>
    </tr>
    <tr>
        <td><b>Total Balance</b></td>
        <td><?php
        if(!empty($registers)){
            $totalBalance = 0;
            foreach ($registers["register"] as $value) {
                $totalBalance += floatval($value['amount']);
            }
            echo $totalBalance;
        } else echo 0;
        ?></td>
    </tr>
    <tr>
        <td colspan="2"><button class="seeAll">See all registers<span></span></button></td>
    </tr>
</table>
<br>