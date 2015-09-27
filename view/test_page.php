<h2>incepe testul</h2>
<p>numele tau este: <?=$this->user_name?></p>
<hr />
<p>intrebare <?=$this->question["category"]?> </p>
<h4>nr. <?=$this->question["id"]?>
    <?=$this->question["text"]?>
</h4>
<form action="" method="post">
    <?foreach($this->answers as $index => $answer):?>
        <p>
            <input type="hidden" name="answer_<?=$index?>" value="0" />
            <input type="checkbox" name="answer_<?=$index?>" value="1" />
            <?=$answer?>
        </p>
    <?endforeach?>
    <hr />
    <input type="button" value="&laquo; inapoi" />
    <input type="submit" value="inainte &raquo;" />
</form>
