<h2>Pagina de pornire</h2>
<form action="" method="post" id="test_form">
    <p>Introduceti numele</p>
    <p><input type="text" name="user_name" class = "tab" value="<?=$this->user_name?>"/></p>
    <p>Tipul testului</p>
    <p><select name="type" class = "tab" ></p>
        <? foreach($this->setCategories() as $key=> $category): ?>
            <option <?=$this->isCatSelected($key)?> value="<?=$key?>"><?=$category?></option>
        <?endforeach?>
    </select>
    <br /><br /><br />
    <p><input type="button" class = "tab" value="Incepe &raquo;" onclick="doSubmit(this);"/></p>
</form>

<script type="text/javascript">
    var test_form = document.getElementById("test_form");

    function doSubmit(obj) {
        obj.disabled = "disabled";
        test_form.submit();
    }

</script>
