<?php
class work_class {

    public $view;
    public $session_namespace;
    public $questions_ids;
    public $current_question;
    public $score_id;
    public $user_name;
    public $type; //test type
    public $user_score=0;

    public $routes = array(
        "home" => "home",
        "pre_test" => "test_page",
        "mid_test" => "mid_test_page",
        "report" => "report_page",
        "score" => "score_page",
        "high-score" => "high-score-page"
    );

	public function isPost($name=null) {
        if($name) {
            if(!is_null($this->getPost($name))) return true;
            return false;
        }
        if(!empty($_POST)) return true;

        return false;
    }

    public function getGet($name) {
        if(isset($_GET[$name]))
            return $_GET[$name];

        return null;
    }

    public function getPost($name) {
        if(isset($_POST[$name]))
            return $_POST[$name];

        return null;
    }

    public function run() {
        if($this->route()==$this->routes["pre_test"])
            $this->preTestLogic();
        elseif($this->route()==$this->routes["mid_test"])
            $this->midTestLogic();
        elseif($this->route()==$this->routes["score"])
            $this->prepareScore();
        elseif($this->route()==$this->routes["report"])
            $this->reportLogic();
        elseif($this->route()==$this->routes["high-score"])
            $this->highScoreLogic();
        elseif($this->route()==$this->routes["home"])
            $this->homeLogic();
        else
            die("ruta nu exista!");

    }

    public function highScoreLogic() {
        $this->view->scores = $this->view->db->getHighScores();
        $this->view->loadView("high_score_page");

    }

    public function reportLogic() {
        $this->view->user_name = $this->sessionGet("user_name");
        $this->view->score = $this->sessionGet("user_score");
        $this->view->report = $this->getReport();
        $this->view->loadView("report_page");
    }

    public function getReport() {
        return $this->view->db->getReport($this->sessionGet("score_id"));
    }

    public function homeLogic() {
        $this->view->loadView("home");
    }

    public function route() {
        if ($this->isPost()) {
            if ($this->isPost("user_name")) return $this->routes["pre_test"]; //first question
            elseif ($this->isPost("answer_1")) return $this->routes["mid_test"]; //next questions
        }

        if($this->getGet("report")) return $this->routes["report"]; //report page
        if($this->getGet("score")) return $this->routes["score"]; //score page
        if($this->getGet("high-score")) return $this->routes["high-score"]; //score page

        return $this->routes["home"]; //default route
    }

    public function getUserAnswers() {
        $arr = array();
        for($i=0;$i<=10;$i++) {
            if($this->getPost("answer_$i"))
                $arr[] = $i;
        }
        return implode(",",$arr);
    }

    public function getAnswersNumber() {
        $arr = array();
        for($i=0;$i<=10;$i++) {
            if(!is_null($this->getPost("answer_$i")))
                $arr[] = $i;
        }
        return count($arr);
    }

    public function setAnswerByUser() {
        $data = array(
            "scores_id"=>$this->sessionGet("score_id"),
            "questions_id"=>$this->sessionGet("current_question"),
            "user_answers"=>$this->getUserAnswers(),
            "number_answers"=>$this->getAnswersNumber()
        );
        $this->view->db->saveAnswers($data);

        return $this;
    }

    public function preTestLogic() {
        $this->storeUsername()
            ->storeTestType()
            ->initiateTest()
            ->handleTestType()
            ->displayFirstTestPage();
        //TODO: isi dea seama de tipul de test si sa-l creeze
    }

    public function displayFirstTestPage() {
        $this->view->getQuestion($this->questions_ids[0]); //get first question
        $this->sessionSet("current_question",$this->questions_ids[0]);
        $this->view->loadView("test_page");
    }

    public function midTestLogic() {
        $this->setAnswerByUser()
            ->loadNextQuestion();
    }

    public function computeScore($data) {
        $score_sum = 0;
        foreach($data as $item) {
            $score = 0;
            if($item["user_answers"]==$item["correct"]) $score = 10;
            $this->view->db->saveScores($item["id"],$score);
            $score_sum += $score;
        }
        $this->user_score = $score_sum/count($data);
        $this->sessionSet("user_score",$this->user_score);
    }

    public function prepareScore() {
        $user_answers = $this->view->db->getCorrectAnswers($this->sessionGet("score_id"));
        if($user_answers) $this->computeScore($user_answers);

        $this->markTestAsCompleted();

        $this->view->score = $this->user_score;
        $this->loadScorePage();
    }

    public function loadScorePage() {
        $this->view->user_name = $this->sessionGet("user_name");
        $this->view->loadView("score_page");
    }

    public function loadNextQuestion() {
        $current_key = array_search($this->current_question,$this->sessionGet("questions_ids"));
        if(isset($this->questions_ids[$current_key+1])) { //there are still questions
            $this->sessionSet("current_question", $this->questions_ids[$current_key + 1]);

            $this->view->getQuestion($this->current_question);
            $this->view->loadView("test_page");
        } else { //no more questions
            $this->prepareScore();
        }
    }

    public function markTestAsCompleted() {
        $this->view->db->markTestAsCompleted($this->score_id,$this->user_score);

        return $this;
    }

    public function handleTestType() {
        if($this->questions_ids = $this->view->db->checkIfQuestionList($this->user_name)) {
            $this->sessionSet("questions_ids",$this->questions_ids);
            return $this;
        }
        //for standard type
        $this->sessionSet("questions_ids",$this->view->db->getQuestionsForStandard());
        $this->saveQuestionsIds();
        //TODO: handle also other test types
        return $this;
    }

    public function saveQuestionsIds() {
        $this->view->db->saveQuestionsIds($this->user_name,$this->questions_ids);
    }

    public function initiateTest() {
        $this->view->user_name = $this->sessionGet("user_name");
        if($score_id = $this->view->db->initDBTest($this->view->user_name)) {
            $this->sessionSet("score_id",$score_id);
        }
        if(!$score_id) die("numele exista deja");

        return $this;
    }

    public function storeTestType() {
        $this->sessionSet("type",$this->getPost("type"));

        return $this;
    }

    public function storeUsername() {
        if(!$this->getPost("user_name")) die("introdu numele");
        $this->sessionSet("user_name",$this->getPost("user_name"));

        return $this;
    }

    public function sessionGet($name) {
        if(isset($_SESSION[$this->session_namespace][$name])) {
            $this->{$name} = $_SESSION[$this->session_namespace][$name];
            return $_SESSION[$this->session_namespace][$name];
        }

        return null;
    }

    public function sessionSet($name,$value) {
        $this->{$name} = $value;
        $_SESSION[$this->session_namespace][$name] = $value;
    }

    public function sessionRem($name) {
        if(isset($_SESSION[$this->session_namespace][$name])) {
            $this->{$name} = null;
            unset($_SESSION[$this->session_namespace][$name]);
        }
    }


	
}

?>