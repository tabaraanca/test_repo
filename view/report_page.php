<h2>Pagina de scor</h2>
<p>Numele tau este: <?=$this->user_name?></p>
<hr />
<div class="left">
    <h3>Scorul este: <?=$this->showScore($this->score)?></h3>
</div>

<div class="left score_cat">
    <u>Scorul pe categorie:</u> <br /> <br />

    <?foreach($this->score_by_category as $item):?>
        <div class="clear <?=$this->setScoreClass($item["cat_score"])?>">
            <?=$item["cat"]?>:
            <span class="right"><?=$this->showScore($item["cat_score"])?></span>
        </div>
    <?endforeach?>
</div>
<br class="clear" />
<hr />
<h4>Raspunsuri:</h4>

<?foreach($this->report as $question):?>
    <div class="<?=$this->setQuestionClass($question["score"])?>">
        <p>Intrebare: <i><?=$question["category"]?></i>
            <i class="date">(scor: <?=$this->showScore($question["score"])?>)</i>
        </p>
        <h4>Nr. <?=$question["id"]?>
            <?=$question["text"]?>
        </h4>
        <?for($i=1;$i<=10;$i++):?>
            <?if(!empty($question["answer_".$i])):?>
                <p class="<?=$this->setClass($i,$question)?>">
                    <?=$this->answer_letter[$i]?> <?=$question["answer_".$i]?>
                    <span class="user_answer"><?=$this->isUserAnswer($i,$question)?></span>
                </p>
            <?endif?>
        <?endfor?>
    </div>
    <hr />
<?endforeach?>
