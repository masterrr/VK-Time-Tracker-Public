<?php
class User {
	private $uid = '';
	function set_id($id) {
		$this->uid = $id;
	}
	
	function getuserinfo() {
	
		#DB Connection
		$conn = DB_Instance::getDBO();
		
		# Gathering how many time user has spent, and when he has registered
		$query1 = $conn->prepare("SELECT spent, date FROM `users` WHERE `uid`=?");
		$result1 = $query1->execute(array($this->uid));
		$data1 = $query1->fetch(PDO::FETCH_NUM);
		return array(
			'spent' => $data1[0], # Spent time in seconds
			'datetime' => $data1[1] # Registering datetime in 2012-02-04 22:59:55 format
		);
		unset($query1, $result1, $data1);
		
	}
	function get_spent() {
		$userinfo = $this->getuserinfo();		
		return $userinfo['spent'];
	}
	
	function get_datetime() {
		$userinfo = $this->getuserinfo();		
		return $userinfo['datetime'];
	}
	
	function get_registration_timestamp() {
		$userinfo = $this->getuserinfo();	
		$timestamp = strtotime($userinfo['datetime']); # Registering datetime timestamp
		return $timestamp;	
	}
	
	function get_time_passed_timestamp() {
		$timestamp = $this -> get_registration_timestamp();	
		$time_passed = time() - $timestamp; # Seconds after registration
		return $time_passed;
	
	}
}