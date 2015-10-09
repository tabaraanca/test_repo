<?php
$str = "

1.Simptomele oboselii includ:

a) greşeli mari, un slab raţionament, decizii slabe sau indecizia
b) concentrare marita
c) reacţii încetinite, slaba coordonare ochi-mână



2.Dupa un consun exagerat de alcool,trebuie tinut cont de faptul ca alcoolul poate sa ramana in corp :

a) cel mult 8 ore
b) cel mult 24 ore
c) cel putin 30 ore

3.Corpul uman reacţionează şi la viteza unghiulară sau la acceleraţia unghiulară atunci când vă rotiţi.Într-un viraj de 60 grade, acceleraţia gravitaţională creste si ajunge la :

	a) 2G
	b) 9,8G
	c) 4G

4.Atunci când condiţiile meteo nu sunt tocmai favorabile cel mai mult contează:
a) pregătirea teoretică a pilotului
b) nivelul tehnic al pilotului
c) atitudinea pilotului

5.Absenţa oxigenului din corp (şi creier) se numeşte :
a) rau de inaltime
b) lesin
c) hipoxie

6.Hipoxia apare datorita :
a)deshidratarii
b)lipsei oxigenului
c)stresului



7.Inainte de zbor este obligatoriu:
            a) un timp de odihna de minim 8 h
            b) nu este cazul la acest tip de aeronava
            c) program de pregatire fizica



8.Echiparea cu parasuta este obligatorie:
           a) in zborurile de antrenament
          b) indiferent de inaltime
          c) nu este obligatorie, ramane la hotararea comandantului de aeronava

9.Vârsta până la care se poate practica parapantismul este:
a) 40 de ani
b) 45 de ani
c) nu există limite dacă starea de sănătate permite

10.Ce masuri sunt recomandate inaintea zborului pentru prevenirea raului de zbor ?
	a) somul suficient de noapte, de minim 8 ore
	b) o alimentatie adecvata
	c) o echipare corespunzatoare

11.Ce efect asupra organismului poate avea o succesiune de viraje cu inclinare mare ?
	a)tulburare de vedere
	b)respiratie dificila pe nas
	c)pierderea cunostintei

12.Este considerat sub influenta bauturilor alcoolice pilotul care are o imbibatie alcoolica in sange intre :
	a) 0,01 si 1
	b) 0,5 si 1
	c) peste 1

13.Este considerat in stare de ebrietate pilotul care are o imbibatie alcoolicain sange :
	a)mai mare de 0,5
	b)mai mare de 0,9
	c)mai mare de 1

14. Este important ca un elev pilot să fie odihnit înainte de a veni la cursuri de parapantism ?
a) să se simtă bine, asta e important
b) întotdeauna este bine ca un pilot să fie odihnit înainte de decolare.
c) chiar dacă nu s-a dormit o noapte, dacă este obişnuit poate face cîteva zboruri.

15.Care sunt cele mai importante decizii de luat cînd se decolează pe condiţii periculoase ?
a) menţinerea aripii deasupra capului şi conducerea aripi cu multă atenţie.
b) deschiderea paraşutei de rezerve dacă avem un incident grav.
c) nu se decolează niciodată în condiţii periculoase.

16.Organismul uman poate suporta condiţiile atmosferice întâlnite peste 5000 de m ?
a) fară echipament adecvat nu.
b) doar dacă se poartă echipament cu mască de oxigen şi haine extrem de groase.
c) Nu este recomandat să se zboare cu parapante peste altitudini mai mari de 5000 m.
17.Ce se poate întâmpla din cauza suprasarcinilor produse la manevrele de acrobaţie ?
a) pilotul îşi poate pierde cunoştinţa.
b) fara o pregătire fizică şi psihică bună nu se execută manevre de acrobaţie.
c) suprasolicitarea poate duce la deteriorarea ariipi daca acesta este uzată.

18.Instrutorul de parapantism trebuie să fie un pilot bun ?
a) trebuie să cunoască pedagogia predării dar şi să fie un pilot care să poată demonstra cea ce predă
b) există reglementări specific

19.Cum este recomandat să se încarce parapanta în zbor ?
a) se respectă tot timpul marjele de încărcare date de fabricant.
b) în funcţie de condiţiile meteo se poate zbura şi cu aripi slab încărcate ca urcă mai bine.
c) numai aripile de competiţie trebuie încărcate conform standardelor.

20.Dacă avem o aripa nouă de ultimă generaţie este nevoie de paraşută de rezervă ?
a) da  întodeauna este indicat purtarea paraşutei de rezervă.
b) dacă este o aripă de şcoală, nu.
c) numai la zborurile tandem (în dublă comandă).

21.Este riscant să folosim paraşuta de siguranţă ?
a) la nevoie se utilizează întodeauna paraşuta de rezervă.
b) numai dacă vrem să aterizăm întrun locul dorit
c) paraşuta de rezervă este doar pentru piloţii de competiţie.

22.Este foarte cald, e bine să ne suprasolicităm ca să facem cit mai  multe zboruri profitînd de vremea bună ?
a) întodeauna se decolează pentru a profita de condiţiile meteo cît mai mult.
b) numai dacă se transpiră din greu se obţin rezultate foarte rapid.
c) întotdeauna trebuie să ne cunoaştem limitele şi să nu ne suprasolicităm înainte de decolare.

23.Care este vârsta legală de la care se poate practica parapantismul:
a) 21 de ani
b) sub supravegherea unui instructor se poate practica de la vârsta de 16 ani.
";


$str = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $str);


$arr = explode(PHP_EOL,$str);
$arrInsert = array();
foreach($arr as $row) {
    if(empty($row)) continue;
    $arrRow = explode(".",$row);
    if(is_numeric($arrRow[0])) {
        if(!empty($arrQuestions))
            $arrInsert[] = $arrQuestions;
        //limita intre intrebari
        $arrQuestions = array("category"=>"Performante umane");

        $j=0;
        $arrQuestions["category_index"] = trim($arrRow[0]);
        unset($arrRow[0]);
        $arrQuestions["text"] = implode(".",$arrRow);

    } else {
        $arrRow2 = explode(")",$row);
        if(in_array(trim($arrRow2[0]),array("a","b","c"))) {
            $j++;
            unset($arrRow2[0]);
            $arrQuestions["answer_$j"] = implode(")",$arrRow2);
        } else {
            $j++;
            unset($arrRow[0]);
            $arrQuestions["answer_$j"] = implode(".",$arrRow);
        }
    }


}
if(!empty($arrQuestions))
    $arrInsert[] = $arrQuestions;


//echo "<pre>"; var_dump($arrInsert); exit;

$handler = mysqli_connect("localhost");
mysqli_select_db($handler,"test_repo");


$id = 500;
foreach($arrInsert as $data) {
    $id++;
    $query = "INSERT INTO questions SET id=$id,";
    $values = array();

    foreach($data as $field=>$value) {
        $values[] = "$field = '$value'";
    }

    $query .= implode(",",$values);
    mysqli_query($handler,$query);
    echo $query."<br />";
}

?>

