<?php
class view_class {
    public $db;
    public $user_name;
    public $question;
    public $answers = array();

	public function loadView($name) {
		require_once "../view/".$name.".php";
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
}
?>