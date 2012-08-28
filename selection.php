<?php
class User {
	private $uid = '';
	function set_id($id) {
		$this->uid = $id;
	}
	
	function getuserinfo() {
	
		#DB Connection
		$conn = DB_Instance::getDBO();
		
		# Gathering how many minutes user has spent.
		$query1 = $conn->prepare("SELECT spent FROM `users` WHERE `uid`=?");
		$result1 = $query1->execute(array($this->uid));
		$data1 = $query1->fetch(PDO::FETCH_NUM);
		$spent = (int)$data1[0]; # How many minutes user has spent.
		unset($query1, $result1, $data1);
		
		# From what date on our service?
		$query1 = $conn->prepare("SELECT date FROM `users` WHERE `uid`=?");
		$result1 = $query1->execute(array($this-uid));
		$data1 = $query1->fetch(PDO::FETCH_NUM);
		$datetime = $data1[0]; # Registering datetime in 2012-02-04 22:59:55 format
		unset($query1, $result1, $data1);
		return array(
			'spent' => $spent,
			'datetime' => $datetime
		);
		
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
		$timestamp = strtotime($datatime); # Registering datetime timestamp
		return $timestamp;	
	}
	
	function get_time_passed_timestamp() {
		$timestamp = $this -> get_registration_timestamp();	
		$time_passed = time() - $timestamp; # Seconds after registration
		return $time_passed;
	
	}
}