<?php
class db_class {
	public $handler;
	public $result;
    public $question_set_number = 10; //should be 10
	
	public function connect_db($host,$user,$pass) {
		$this->handler = mysqli_connect($host,$user,$pass);
		if (!$this->handler) {
			die("Connection failed: " . mysqli_connect_error());
		}
	}
	
	public function select_db($name) {
		if($this->handler) {
			$db_selected = mysqli_select_db($this->handler,$name);
			if (!$db_selected) {
				die ('Cannot conenct to db : ' . mysqli_error($this->handler));
			}
		}
	}
	
	public function run_query($query) {
		$this->result = mysqli_query($this->handler,$query);
		if (!$this->result) {
			die('Invalid query: ' . mysqli_error($this->handler)."<br />".$query);
		}
        return $this->result;
	}
	
	public function getResult() {
		return $this->result;
	}
	
	public function fetchResult($query) {
		$this->run_query($query);
		return mysqli_fetch_assoc($this->result);
	}

    public function fetchAll($query) {
        $this->run_query($query);
        $arr = array();
        while($row=mysqli_fetch_assoc($this->result)) {
            $arr[] = $row;
        }
        return $arr;
    }
	
	public function getCategories() {
        $arrResult = array();
		$result = $this->fetchResult("DESCRIBE questions category");
        if(!empty($result) && isset($result["Type"])) {
            $strCategory = str_replace(array("enum(",")"),"",$result["Type"]);
            $arrResult = explode(",",$strCategory);
            return $this->parseCategories($arrResult);
        }
        return $arrResult;
	}

    public function parseCategories($arr) {
        foreach($arr as $key=>&$category) {
            $category = str_replace("'","",$category);
            if(empty($category)) unset($arr[$key]);
        }
        return $arr;
    }

    public function getQuestion($id) {
        if(empty($id)) die("error: invalid question id");
        return $this->fetchResult("SELECT * FROM questions WHERE id = $id");
    }

    public function initDBTest($user_name,$type) {
        $user_name = $this->escape($user_name);
        $result = $this->fetchResult("SELECT name,finished FROM scores WHERE name = '$user_name' AND finished = 1");
        if($result) return false; //user already exists and has finished the quiz

        $result2 = $this->fetchResult("SELECT name,finished,id FROM scores WHERE name = '$user_name' AND finished = 0");
        if($result2) {
            return $result2["id"];
        }

        $this->run_query("INSERT INTO scores (name,criteria) VALUES ('$user_name','$type')");

        if(!empty($this->handler->insert_id))
            return $this->handler->insert_id;

        return null;
    }

    public function escape($value) {
        return mysqli_real_escape_string($this->handler,$value);
    }

    public function saveAnswers($data) {
        $condition = " WHERE scores_id = '".$data["scores_id"]."' AND questions_id = '".$data["questions_id"]."'";
        $result = $this->fetchResult("SELECT id FROM tests".$condition);

        $values = array();
        foreach($data as $field=>$value) {
            $values[] = "$field = '$value'";
        }

        if($result) { //update
            $query = "UPDATE tests SET ";
            $query .= implode(",",$values);
            $query .= $condition;
        } else { //insert
            $query = "INSERT INTO tests SET ";
            $query .= implode(",",$values);
        }

        return $this->run_query($query);
    }

    public function getQuestionsForStandard() {
        $arrIds = array();
        foreach($this->getCategories() as $category) {
            $result = $this->fetchAll("SELECT id FROM questions WHERE category = '$category' ORDER BY RAND() LIMIT ".$this->question_set_number);
            foreach($result as $item) {
                $arrIds[] = $item["id"];
            }
        }

        shuffle($arrIds);

        return $arrIds;
    }

    public function getQuestionsByCategory($cat) {
        $arrIds = array();
        $result = $this->fetchAll("SELECT id FROM questions WHERE category = '$cat' ORDER BY RAND()");
        foreach($result as $item) {
            $arrIds[] = $item["id"];
        }

        shuffle($arrIds);

        return $arrIds;
    }

    public function getQuestionsForAll() {
        $arrIds = array();
        foreach($this->getCategories() as $category) {
            $result = $this->fetchAll("SELECT id FROM questions WHERE category = '$category' ORDER BY RAND()");
            foreach($result as $item) {
                $arrIds[] = $item["id"];
            }
        }

        shuffle($arrIds);

        return $arrIds;
    }

    public function checkIfQuestionList($user_name) {
        $user_name = $this->escape($user_name);
        $result = $this->fetchResult("SELECT test_setup FROM scores WHERE name = '$user_name'");
        if($result && !empty($result["test_setup"])) return explode(",",$result["test_setup"]);

        return false;
    }

    public function getType($user_name) {
        $user_name = $this->escape($user_name);
        $result = $this->fetchResult("SELECT criteria FROM scores WHERE name = '$user_name'");
        if($result && !empty($result["criteria"])) return $result["criteria"];

        return false;
    }

    public function saveQuestionsIds($user_name,$questions) {
        $user_name = $this->escape($user_name);
        $this->run_query("UPDATE scores SET test_setup = '".implode(",",$questions)."' WHERE name = '$user_name'");
    }

    public function getCorrectAnswers($scores_id) {
        return $this->fetchAll("SELECT tests.*,questions.correct FROM `tests` LEFT JOIN questions ON tests.questions_id = questions.id WHERE scores_id = '$scores_id'");
    }

    public function saveScores($id,$score) {
        $this->run_query("UPDATE tests SET score = '$score' WHERE id = '$id'");
    }

    public function getReport($scores_id) {
        return $this->fetchAll("SELECT * FROM `tests` LEFT JOIN questions ON tests.questions_id = questions.id WHERE scores_id = '$scores_id'");
    }

    public function markTestAsCompleted($scores_id,$score) {
        $this->run_query("UPDATE scores SET score = '$score', finished = 1 WHERE id = '$scores_id'");
    }

    public function getHighScores() {
        return $this->fetchAll("SELECT * FROM scores WHERE finished = 1 ORDER BY score DESC");
    }

    public function getUserAnswers($question_id,$score_id) {
        $data = $this->fetchAll("SELECT user_answers FROM tests WHERE questions_id = $question_id AND scores_id = $score_id");
        if(is_array($data) && count($data)>0) {
            $data = reset($data);
            return explode(",",$data["user_answers"]);
        }
        return null;
    }

    public function getScoreByCategory($scores_id) {
        return $this->fetchAll("SELECT questions.category AS cat, AVG(tests.score) AS cat_score FROM `tests`
                  LEFT JOIN questions ON tests.questions_id = questions.id
                  WHERE scores_id = '$scores_id'
                  GROUP BY questions.category");

    }
	
}

?>