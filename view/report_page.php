<h2>Pagina de scor</h2>
<p>Numele tau este: <?=$this->user_name?></p>
<hr />
<div class="left">
    <h3>Scorul este: <?=$this->score?></h3>
</div>

<div class="left score_cat">
    <u>Scorul pe categorie:</u> <br /> <br />

    <?foreach($this->score_by_category as $item):?>
        <div class="clear <?=$this->setScoreClass($item["cat_score"])?>">
            <?=$item["cat"]?>:
            <span class="right"><?=$item["cat_score"]?></span>
        </div>
    <?endforeach?>
</div>
<br class="clear" />
<hr />
<h4>Raspunsuri:</h4>

<?foreach($this->report as $question):?>
    <p>Intrebare: <i><?=$question["category"]?></i> (<i>scor: <?=$question["score"]?></i>) </p>
    <h4>Nr. <?=$question["id"]?>
        <?=$question["text"]?>
    </h4>
    <?for($i=1;$i<=10;$i++):?>
        <?if(!empty($question["answer_".$i])):?>
            <p class="<?=$this->setClass($i,$question)?>">
                <?=$this->answer_letter[$i]?> <?=$question["answer_".$i]?> <?=$this->isUserAnswer($i,$question)?>
            </p>
        <?endif?>
    <?endfor?>
    <hr />
<?endforeach?>
