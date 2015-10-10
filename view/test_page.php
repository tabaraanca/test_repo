<?if($this->first_page):?>
    <h2>incepe testul</h2>
<?else:?>
    <h2>continua testul</h2>
<?endif?>

<p class="menu">numele tau este: <?=$this->user_name?></p>
<p class="menu">intrebarea <?=$this->current_question?> din <?=$this->total_questions?></p>
<p class="menu"><?=$this->type?></p>
<hr class="clear" />

<p>intrebare <?=$this->question["category"]?> </p>
<h4>nr. <?=$this->question["id"]?>
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
        <input type="button" disabled="disabled" value="&laquo; inapoi" />
    <?else:?>
        <input type="submit" name="back" value="&laquo; inapoi" />
    <?endif?>
    <input type="submit" name="forward" value="inainte &raquo;" />
</form>
