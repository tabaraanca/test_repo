<?php
class view_class {
    public $db;
    public $user_name;
    public $question;
    public $answers = array();
    public $load_page = "home";
    public $rank = array(
        10=>"xc-ist",
        9=>"vultur chel",
        8=>"licentiat",
        7=>"cioara",
        6=>"gugustiuc",
        5=>"dv-ist",
        4=>"gaina",
        3=>"pui de gaina",
        2=>"pisi",
        1=>"soarec",
        0=>"bolovan"
    );

	public function loadView($name) {
        $this->load_page = $name;
        $this->loadLayout();
	}

    public function loadPage() {
        require_once "../view/".$this->load_page.".php";
    }

    public function loadLayout($name="default") {
        require_once "../view/".$name."_layout.php";
    }

    public function setCategories() {
        $arrCategory = array();
        $arrCategory["standard"] = "Examen standard";
        
        foreach($this->db->getCategories() as $category) {
            $arrCategory[$category] = "pe categorie - ".$category;
        }
        $arrCategory["all"] = "aleator, din toate intrebarile";
        return $arrCategory;
    }

    public function getQuestion($id) {
        $this->question = $this->db->getQuestion($id);
        $this->getAnswers();
    }

    public function getAnswers() {
        for($i=1;$i<=10;$i++) {
            if(!empty($this->question["answer_".$i]))
                $this->answers[$i] = $this->question["answer_".$i];
        }
    }

    public function setClass($index,$question) {
        $class = "";
        $arrUserAnswers = explode(",",$question['user_answers']);
        $arrCorrect = explode(",",$question['correct']);

        if(in_array($index,$arrCorrect)) {
            $class = "correct";
            if(in_array($index,$arrUserAnswers))
                $class .= " bold";
        } else {
            if(in_array($index,$arrUserAnswers))
                $class = "wrong";
        }

        return $class;
    }

    public function isUserAnswer($index,$question) {
        $arrUserAnswers = explode(",",$question['user_answers']);
        if(in_array($index,$arrUserAnswers)) return "<-- raspunsul tau";

        return "";
    }

    public function setRank($user_score) {
        foreach($this->rank as $score=>$rank) {
            if($user_score>=$score) return $rank;
        }
    }
}
?>