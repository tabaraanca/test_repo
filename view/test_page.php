<?if($this->first_page):?>
    <h2>Incepe testul</h2>
<?else:?>
    <h2>Continua testul</h2>
<?endif?>

<p class="menu">Numele tau este:<i> <?=$this->user_name?></i> </p>
<p class="menu">Intrebarea <?=$this->current_question?> din <?=$this->total_questions?></p>
<p class="menu"><?=$this->type?></p>
<hr class="clear" />

<p>Intrebare din <i><?=$this->question["category"]?> </i> </p>
<h4>Nr. <?=$this->question["id"]?>
    <?=$this->question["text"]?>
</h4>
<form action="" method="post">
    <?foreach($this->answers as $index => $answer):?>
        <p>
            <input type="hidden" name="answer_<?=$index?>" value="0" />
            <input type="checkbox" name="answer_<?=$index?>" <?=$this->isAnswerChecked($index)?> value="1" />
            <?=$answer?>
        </p>
    <?endforeach?>
    <hr />
    <?if($this->first_page):?>
        <input type="button" disabled="disabled" class = "tab" value="&laquo; Inapoi" />
    <?else:?>
        <input type="submit" name="back" class = "tab" value="&laquo; Inapoi" />
    <?endif?>
    <input type="submit" name="forward" class = "tab" value="Inainte &raquo;" />
</form>
