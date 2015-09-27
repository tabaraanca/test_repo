<h2>Pagina de pornire</h2>
<form action="" method="post">
    <p>Introduceti numele</p>
    <input type="text" name="user_name" />
    <p>Tipul testului</p>
    <select name="type">
        <? foreach($this->setCategories() as $key=> $category): ?>
            <option value="<?=$key?>"><?=$category?></option>
        <?endforeach?>
    </select>
    <br /><br /><br />
    <input type="submit" value="incepe" />
</form>
