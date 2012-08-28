<?php
class Selection {
	function getusertime($uid) {
	
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
		$datatime = $data1[0]; # Registering datetime in 2012-02-04 22:59:55 format
		unset($query1, $result1, $data1);
		$timestamp = strtotime($datatime); # Registering datetime timestamp
		$time_passed = time() - $timestamp; # Seconds after registration
		# var_dump($spent, $datatime, $timestamp, $time_passed);
	}
}