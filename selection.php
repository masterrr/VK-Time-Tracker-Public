<?php
class User {
	private $uid = NULL;
	private $data = NULL;
	private $alreadyexists = FALSE;
	var $name = '{name}';
	var $surname = '{surname}';
	var $sex = 0;
	var $spent = 0;
	var $online = 0;
	var $date = '{date}';
	var $social = 0;

	function __construct($id) {
		$this->uid = $id;
	}
	
	function exists() {
		if (!$this->alreadyexists) {
			$conn = DB_Instance::getDBO(); #DB Connection
			$query = $conn->prepare("SELECT COUNT(*) FROM `users` WHERE uid=$this->uid");
			$result = $query->execute();
			$temp = $query->fetch(PDO::FETCH_NUM);
			$this->alreadyexists = $temp[0];
		}
		return $this->alreadyexists; // (int)1456
		unset($temp,$result,$query);		
	}
	
	# Gathering how many time user has spent, and when he has registered
	function getuserinfo() { 
		$conn = DB_Instance::getDBO(); #DB Connection
		
		if (!$this->data) { # Caching
			$query = $conn->prepare("SELECT spent, date FROM `users` WHERE `uid`=?");
			$result = $query->execute(array($this->uid));
			$this->data = $query->fetch(PDO::FETCH_NUM);			
		}
		return array(
			'spent' => (int)($this->data[0]), # Spent time in seconds
			'datetime' => $this->data[1] # Registering datetime in 2012-02-04 22:59:55 format
		);
		unset($query, $result, $data);	
		$conn = NULL;
	}
	
	# Spent time in seconds (timestamp)
	function get_spent() { $userinfo = $this->getuserinfo(); return $userinfo['spent']; } 
	# Datetime (2012-02-04 22:59:55)
	function get_datetime() { $userinfo = $this->getuserinfo();	return $userinfo['datetime']; } 
	# When registered (timestamp)
	function get_registration_timestamp() { $timestamp = strtotime($this->get_datetime()); return $timestamp; } 	
	# Now - when registered (timestamp)
	function get_time_passed_timestamp() { $timestamp = $this -> get_registration_timestamp(); return time() - $timestamp; } 
}
class Request {
	private $all_time = 0;
	private $count_users = 0;
	
	# Counting all user's time in !minutes!
	function get_all_time() {
		if (!$this->all_time) {
			$conn = DB_Instance::getDBO(); #DB Connection
			$query = $conn->prepare("SELECT SUM(spent) FROM users");
			$result = $query->execute();
			$temp = $query->fetch(PDO::FETCH_NUM);
			$this->all_time = $temp[0];
		}
		return $this->all_time; // (int)385838 (minutes)
		unset($temp,$result,$query);		
	}
	
	# Couting users
	function count_users() {
		if (!$this->count_users) {
			$conn = DB_Instance::getDBO(); #DB Connection
			$query = $conn->prepare("SELECT COUNT(*) FROM users");
			$result = $query->execute();
			$temp = $query->fetch(PDO::FETCH_NUM);
			$this->count_users = $temp[0];
		}
		return $this->count_users; // (int)1456
		unset($temp,$result,$query);		
	}
}

