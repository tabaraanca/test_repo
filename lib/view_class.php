<?php
class view_class {
    public $db;
    public $user_name;
    public $question;
    public $answers = array();
    public $user_answer = array();
    public $score_id;
    public $first_page;
    public $score_by_category;
    public $load_page = "home";
    public $error;
    public $category;
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
    public $answer_letter = array(
        1=>"a)",
        2=>"b)",
        3=>"c)",
        4=>"d)",
        5=>"e)",
        6=>"f)",
        7=>"g)",
        8=>"h)",
        9=>"i)",
        10=>"j)"
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
            $arrCategory[$category] = "Pe categorie - ".$category;
        }
        $arrCategory["all"] = "Aleator, din toate intrebarile";
        return $arrCategory;
    }

    public function getQuestion($id) {
        $this->question = $this->db->getQuestion($id);
        if($this->score_id)
            $this->user_answer = $this->db->getUserAnswers($id,$this->score_id);
        else $this->user_answer = array();

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
        if(in_array($index,$arrUserAnswers)) return "&nbsp;&nbsp;&nbsp;&laquo;&nbsp;raspunsul&nbsp;tau";

        return "";
    }

    public function setRank($user_score) {
        foreach($this->rank as $score=>$rank) {
            if($user_score>=$score) return $rank;
        }
    }

    public function setScoreId($id) {
        $this->score_id = $id;
    }

    public function isAnswerChecked($index) {
        if(is_array($this->user_answer) && in_array($index,$this->user_answer)) return "checked='checked'";
        return "";
    }

    public function setScoreClass($score) {
        if($score==10) return "bold correct";
        if($score>=7.5) return "correct";
        return "wrong";
    }

    public function setErrorClass() {
        if($this->error) return "show";
        return "hide";
    }

    public function getError() {
        return $this->error;
    }

    public function isCatSelected($cat) {
        if($this->category==$cat) return 'selected="selected"';
        return "";
    }

    public function getType($type) {
        if($type=="all") return "Toate intrebarile";
        return $type;
    }

    public function showScore($score) {
        return number_format($score,2,","," ");
    }

    public function handleDate($date) {
        $timestamp = strtotime($date);
        date_default_timezone_set('Europe/Bucharest');
        $date = date("Y-m-d H:i:s",$timestamp);
        return $date;
    }

    public function setQuestionClass($score) {
        if($score==10) return "right_question";
        else return "wrong_question";
    }
}
?>