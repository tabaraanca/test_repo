<h2>pagina de scor</h2>
<p>numele tau este: <?=$this->user_name?></p>
<hr />
<div class="left">
    <h3>Scorul este: <?=$this->score?></h3>
</div>

<div class="left score_cat">
    <u>Scorul pe categorie:</u> <br />

    <?foreach($this->score_by_category as $item):?>
        <div class="clear <?=$this->setScoreClass($item["cat_score"])?>">
            <?=$item["cat"]?>:
            <span class="right"><?=$item["cat_score"]?></span>
        </div>
    <?endforeach?>
</div>
<br class="clear" />
<hr />
<h4>raspunsuri:</h4>

<?foreach($this->report as $question):?>
    <p>intrebare <?=$question["category"]?> (<i>scor: <?=$question["score"]?></i>) </p>
    <h4>nr. <?=$question["id"]?>
        <?=$question["text"]?>
    </h4>
    <?for($i=1;$i<=10;$i++):?>
        <?if(!empty($question["answer_".$i])):?>
            <p class="<?=$this->setClass($i,$question)?>">
                <?=$i?>. <?=$question["answer_".$i]?> <?=$this->isUserAnswer($i,$question)?>
            </p>
        <?endif?>
    <?endfor?>
    <hr />
<?endforeach?>
