<h2>clasament</h2>
<table>
    <th>Loc</th>
    <th>Nume</th>
    <th>Scor</th>
    <th>Rang</th>
<?foreach($this->scores as $index=>$score):?>
    <tr>
        <td class="number"><?=$index+1?></td>
        <td class="text"><?=$score["name"]?></td>
        <td class="number"><?=$score["score"]?></td>
        <td class="text"><?=$this->setRank($score["score"])?></td>
    </tr>
<?endforeach?>
</table>
