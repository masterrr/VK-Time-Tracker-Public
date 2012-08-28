<?php

class User {
	private $uid = NULL;
	static $data = NULL;

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
	}
	
	function get_spent() { $userinfo = $this->getuserinfo(); return $userinfo['spent']; } # Spent time in seconds (timestamp)
	function get_datetime() { $userinfo = $this->getuserinfo();	return $userinfo['datetime']; } # Datetime (2012-02-04 22:59:55)
	function get_registration_timestamp() { $timestamp = strtotime($this->get_datetime()); return $timestamp; } # When registered (timestamp)	
	function get_time_passed_timestamp() { $timestamp = $this -> get_registration_timestamp(); return time() - $timestamp; } # Now - when registered (timestamp)
}