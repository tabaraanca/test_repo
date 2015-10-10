<h2>Pagina de pornire</h2>
<form action="" method="post">
    <p>Introduceti numele</p>
    <p><input type="text" name="user_name" class = "tab" value="<?=$this->user_name?>"/></p>
    <p>Tipul testului</p>
    <p><select name="type" class = "tab" ></p>
        <? foreach($this->setCategories() as $key=> $category): ?>
            <option <?=$this->isCatSelected($key)?> value="<?=$key?>"><?=$category?></option>
        <?endforeach?>
    </select>
    <br /><br /><br />
    <p><input type="submit" class = "tab" value="Incepe &raquo;" /></p>
</form>
