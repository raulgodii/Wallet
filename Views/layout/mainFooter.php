    </tbody>
        <tr>
            <td><input class="inputMain" type="text"></td>
            <td><input class="inputMain" type="text"></td>
            <td><input class="inputMain" type="text"></td>
            <td><button class="addRegister">Add Register<span></span></button></td>
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
        <td><?php echo count($registers);?></td>
    </tr>
    <tr>
        <td><b>Total Balance</b></td>
        <td><?php echo $sum?></td>
    </tr>
    <tr>
        <td colspan="2"><button class="seeAll">See all registers<span></span></button></td>
    </tr>
</table>
<br>