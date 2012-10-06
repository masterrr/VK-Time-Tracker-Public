<?php
class User {
	private $uid = NULL;
	private $data = NULL;
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
	function get_all_time() {
		$conn = DB_Instance::getDBO(); #DB Connection
		$query = $conn->prepare("SELECT SUM(spent) FROM users");
		$result = $query->execute();
		if ($result) {
			 $result =  $query->fetch(PDO::FETCH_NUM);	
			 return (int)$result[0];	
		} else {
			return NULL;
		}
		unset($query, $result, $conn);
	}
	function count_users() {
		$conn = DB_Instance::getDBO();
		$query = $conn->prepare("SELECT COUNT(*) FROM users");
		$result = $query->execute();
		if ($result) {
			$result =  $query->fetch(PDO::FETCH_NUM);	
			return (int)$result[0];	
		} else {
			return NULL;
		}
	}
}

