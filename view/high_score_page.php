<h2>Clasament</h2>
<table>
    <th>Loc</th>
    <th>Nume</th>
    <th>Scor</th>
    <th>Tipul testului</th>
    <th>Data</th>
<?foreach($this->scores as $index=>$score):?>
    <tr>
        <td class="number"><?=$index+1?></td>
        <td class="text"><?=$score["name"]?></td>
        <td class="number"><?=$this->showScore($score["score"])?></td>
        <td class="text"><?=$this->getType($score["criteria"])?></td>
        <td class="text date"><?=$this->handleDate($score["date"])?></td>
    </tr>
<?endforeach?>
</table>
