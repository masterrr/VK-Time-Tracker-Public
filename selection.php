<?php
class User {
	
	function getuserinfo($uid) {
	
		#DB Connection
		$conn = DB_Instance::getDBO();
		
		# Gathering how many minutes user has spent.
		$query1 = $conn->prepare("SELECT spent FROM `users` WHERE `uid`=?");
		$result1 = $query1->execute(array($uid));
		$data1 = $query1->fetch(PDO::FETCH_NUM);
		$spent = (int)$data1[0]; # How many minutes user has spent.
		unset($query1, $result1, $data1);
		
		# From what date on our service?
		$query1 = $conn->prepare("SELECT date FROM `users` WHERE `uid`=?");
		$result1 = $query1->execute(array($uid));
		$data1 = $query1->fetch(PDO::FETCH_NUM);
		$datetime = $data1[0]; # Registering datetime in 2012-02-04 22:59:55 format
		unset($query1, $result1, $data1);
		return array(
			'spent' => $spent,
			'datetime' => $datetime
		);
		
	}
	
	function get_spent($uid) {
		$userinfo = User::getuserinfo($uid);		
		return $userinfo['spent'];
	}
	
	function get_datetime($uid) {
		$userinfo = User::getuserinfo($uid);		
		return $userinfo['datetime'];
	}
	
	function get_registration_timestamp($uid) {
		$userinfo = User::getuserinfo($uid);	
		$timestamp = strtotime($datatime); # Registering datetime timestamp
		return $timestamp;	
	}
	
	function get_time_passed_timestamp($uid) {
		$timestamp = User::get_registration_timestamp($uid);	
		$time_passed = time() - $timestamp; # Seconds after registration
		return $time_passed;
	
	}
}