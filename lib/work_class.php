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
    private $error;
    private $return_to_index;

    public $routes = array(
        "home" => "home",
        "pre_test" => "test_page",
        "mid_test" => "mid_test_page",
        "report" => "report_page",
        "score" => "score_page",
        "high-score" => "high-score-page",
        "prev_question" => "prev_question"
    );

    public $error_msg = array(
        "unfinished_test" => "A fost inceput deja un test cu acest nume, dar nu a fost finalizat. Se poate reincepe alt tip de test schimband numele.",
        "name_exists" => "Acest nume a fost folosit deja",
        "name_empty" => "Trebuie completat numele",
        "only_letters" => "Numele poate contine numai litere"
    );

    public $category_text = array(
        "standard" => "Test standard (10 intrebari din 8 categorii)",
        "category" => "Test cu intrebari din categoria ",
        "all" => "Test din toate intrebarile"
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
        $this->checkIndex();

        if($this->getError()) {
            $this->homeLogic();
            return;
        }
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
        elseif($this->route()==$this->routes["prev_question"])
            $this->prevQuestionLogic();
        else
            $this->setError("ruta nu exista!");

    }

    public function checkIndex() {
        if(strpos($_SERVER["REQUEST_URI"],"index")!==false) {
            header("Location: /");
            exit;
        }
    }

    public function prevQuestionLogic() {
        $this->current_question = $this->sessionGet("current_question");
        $current_key = array_search($this->current_question,$this->sessionGet("questions_ids"));
        $this->view->user_name = $this->sessionGet("user_name");
        $this->view->type = $this->getTestType();

        if(isset($this->questions_ids[$current_key-2])) { //there are still questions
            $this->sessionSet("current_question", $this->questions_ids[$current_key - 1]);

            $this->view->setScoreId($this->sessionGet("score_id"));
            $this->view->total_questions = count($this->questions_ids);
            $this->view->current_question = $current_key;
            $this->view->getQuestion($this->current_question);
            $this->view->loadView("test_page");
        } else { //at first question
            $this->displayFirstTestPage();
        }

    }

    public function getTestType() {
        $this->sessionGet("type");
        if($this->type=="standard") return $this->category_text["standard"];
        elseif($this->type=="all") return $this->category_text["all"];
        else return $this->category_text["category"].$this->type;
    }

    public function highScoreLogic() {
        $this->view->scores = $this->view->db->getHighScores();
        $this->view->loadView("high_score_page");

    }

    public function reportLogic() {
        $this->view->user_name = $this->sessionGet("user_name");
        $this->view->score = $this->sessionGet("user_score");
        $this->view->report = $this->getReport();
        $this->view->score_by_category = $this->getScoreByCategory();
        $this->view->loadView("report_page");
    }

    public function getScoreByCategory() {
        return $this->view->db->getScoreByCategory($this->sessionGet("score_id"));
    }

    public function getReport() {
        return $this->view->db->getReport($this->sessionGet("score_id"));
    }

    public function homeLogic() {
        $this->sessionSet("return_to_index",true);
        $this->view->category = $this->sessionGet("type");
        $this->view->user_name = $this->sessionGet("user_name");
        $this->view->loadView("home");
    }

    public function route() {
        if ($this->isPost()) {
            if ($this->isPost("user_name")) return $this->routes["pre_test"]; //first question
            elseif ($this->isPost("forward")) return $this->routes["mid_test"]; //next questions
            elseif ($this->isPost("back")) return $this->routes["prev_question"]; //prev questions
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
    }

    public function displayFirstTestPage() {
        $this->view->setScoreId($this->sessionGet("score_id"));
        $this->view->getQuestion($this->questions_ids[0]); //get first question
        $this->sessionSet("current_question",$this->questions_ids[0]);
        $this->view->total_questions = count($this->questions_ids);
        $this->view->current_question = 1;
        $this->view->first_page = true;
        $this->view->type = $this->getTestType();

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

            $this->view->user_name = $this->sessionGet("user_name");
            $this->view->total_questions = count($this->questions_ids);
            $this->view->current_question = $current_key+2;
            $this->view->setScoreId($this->sessionGet("score_id"));
            $this->view->getQuestion($this->current_question);
            $this->view->type = $this->getTestType();

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
            $this->sessionSet("type",$this->view->db->getType($this->user_name));
            if($this->sessionGet("return_to_index"))
                $this->view->error = $this->error_msg["unfinished_test"];
            return $this;
        }

        $this->selectTestType()
            ->saveQuestionsIds();

        return $this;
    }

    public function selectTestType() {
        if($this->type=="standard") {
            $this->sessionSet("questions_ids", $this->view->db->getQuestionsForStandard());
        } elseif(in_array($this->type,$this->view->db->getCategories())) {
            $this->sessionSet("questions_ids", $this->view->db->getQuestionsByCategory($this->type));
        } elseif($this->type=="all") {
            $this->sessionSet("questions_ids", $this->view->db->getQuestionsForAll());
        }
        return $this;
    }

    public function saveQuestionsIds() {
        $this->view->db->saveQuestionsIds($this->user_name,$this->questions_ids);
    }

    public function initiateTest() {
        $this->view->user_name = $this->sessionGet("user_name");
        if($score_id = $this->view->db->initDBTest($this->view->user_name,$this->type)) {
            $this->sessionSet("score_id",$score_id);
        }
        if(!$score_id) $this->setError($this->error_msg["name_exists"]);

        return $this;
    }

    public function storeTestType() {
        $this->sessionSet("type",$this->getPost("type"));

        return $this;
    }

    public function storeUsername() {
        if(!$this->getPost("user_name")) $this->setError($this->error_msg["name_empty"]);
        if(!preg_match("/^[A-Za-z ]+$/",trim($this->getPost("user_name"))))
            $this->setError($this->error_msg["only_letters"]);

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

    public function setError($error) {
        $this->sessionSet("error",$error);
        header("location: /");
        exit;
    }

    public function getError() {
        $this->view->error = $this->sessionGet("error");
        $this->sessionRem("error");
        return $this->view->error;
    }


	
}

?>