<h2>pagina de scor</h2>
<p>numele tau este: <?=$this->user_name?></p>
<hr />
<h3>Scorul este: <?=$this->score?></h3>
<h4>raspunsuri:</h4>
<hr />
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
