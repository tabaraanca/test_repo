<?if($this->first_page):?>
    <h2>Incepe testul</h2>
<?else:?>
    <h2>Continua testul</h2>
<?endif?>

<p class="menu">Numele tau este:<i> <?=$this->user_name?></i> </p>
<p class="menu">Intrebarea <?=$this->current_question?> din <?=$this->total_questions?></p>
<p class="menu"><?=$this->type?></p>
<hr class="clear" />

<p>Intrebare din <i><?=$this->question["category"]?> </i>
    <span class="small">(adaugata la: <?=$this->question["date"]?>)</span>
</p>
<h4>Nr. <?=$this->question["id"]?>
    <?=$this->question["text"]?>
</h4>
<form action="" method="post" id="test_form">
    <?foreach($this->answers as $index => $answer):?>
        <p>
            <input type="hidden" name="answer_<?=$index?>" value="0" />
            <input type="checkbox" name="answer_<?=$index?>" <?=$this->isAnswerChecked($index)?> value="1" />
            <?=$this->answer_letter[$index]?> <?=$answer?>
        </p>
    <?endforeach?>
    <hr />
    <?if($this->first_page):?>
        <input type="button" disabled="disabled" class = "tab" value="&laquo; Inapoi" />
    <?else:?>
        <input type="button" disabled="disabled" name="back" class = "tab" id="back" value="&laquo; Inapoi" onclick="doSubmit(this)" />
    <?endif?>
    <input type="button" disabled="disabled" name="forward" class = "tab" id="forward" value="Inainte &raquo;" onclick="doSubmit(this)" />
    <input type="hidden" name="hidden" id="action" value="1" />
</form>

<script type="text/javascript">
    var action = document.getElementById("action");
    var forward_button = document.getElementById("forward");
    var back_button = document.getElementById("back");
    var test_form = document.getElementById("test_form");

    function activateButtons() {
        if(forward_button) forward_button.disabled = "";
        if(back_button) back_button.disabled = "";
    }

    function doSubmit(obj) {
        obj.disabled = "disabled";
        action.name = obj.name;
        test_form.submit();
    }

    setTimeout("activateButtons()",2000);
</script>
