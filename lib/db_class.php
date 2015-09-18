<?php
class db_class {
	public $handler;
	public $result;
	
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
			die('Invalid query: ' . mysqli_error($this->handler));
		}
	}
	
	public function getResult() {
		return $this->result;
	}
	
	public function fetchResult($query) {
		$this->run_query($query);
		return mysqli_fetch_assoc($this->result);
	}
	
	public function getCategories() {
		return $this->fetchResult("SELECT * FROM questions");
	}
	
}

?>