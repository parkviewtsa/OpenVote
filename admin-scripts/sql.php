<?php
	if(empty($_COOKIE['PSSID'])){
		trigger_error('Not Logged In');
		die();
	}
	function generateRandomString($length) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	function registerVoters($voters,$ballotid){
		$sql = new mysqli('localhost','root','','users');
		if($sql->connect_error){
			die("Error: " . $sql->connect_error);
		}
		if($sql->query("ALTER TABLE $voters ADD COLUMN poll$ballotid int(0)") && $sql->query("ALTER TABLE $voters ADD COLUMN gpoll$ballotid int(0)")){
			$sql->close();
			return true;
		}else{
			$sql->close();
			return false;
		}
	}
	function generateVoters($voteBatchID,$numVoters){
		$sql = new mysqli('localhost','root','','users');
		if($sql->connect_error){
			die("Error: " . $sql->connect_error);
		}
		$sql->query("CREATE TABLE IF NOT EXISTS $voteBatchID (
		id varchar(8)
		)");
		for($i=0;$i<$numVoters;$i++){
			$str = generateRandomString(8);
			$sql->query("INSERT INTO $voteBatchID VALUES ($str)");
		}
		$sql->close();
	}
	
	function createBallotSQL($ballotid,$names_p,$names_g,$c_ids_p,$c_ids_g,$u_img_p, $u_img_g){
		if(!(count($names_g)==count($c_ids_g) && count($c_ids_g)==count($u_img_g))){
			trigger_error("Inequal names and ids for general ballot");
		}
		if(!(count($names_p)==count($c_ids_p) && count($c_ids_p)==count($u_img_p))){
			trigger_error("Inequal names and ids for presidential ballot");
		}
		
		$sql = new mysqli('localhost','root','','openvote');
		if($sql->connect_error){
			trigger_error("Error: " . $sql->connect_error);
		}
		if(!($sql->query("CREATE TABLE IF NOT EXISTS $ballotid LIKE 0001"))){
			trigger_error("Cannot create table");
		} // the presidential ballot
		$sql->query("CREATE TABLE IF NOT EXISTS g$ballotid LIKE 0001"); // the general ballot
	
		for($i=0;$i<count($names_g);$i++){
			$sql->query("INSERT INTO g$ballotid VALUES ('".$c_ids_g[$i]."','".$names_g[$i]."',0,'".$u_img_g[$i]."')");
		}
		for($i=0;$i<count($names_p);$i++){
			$sql->query("INSERT INTO $ballotid VALUES ('".$c_ids_p[$i]."','".$names_p[$i]."',0,'".$u_img_p[$i]."')");
		}
		$sql->close();
	}
	
	function appendPresidentialLossesSQL($ballotid){ // Does not work
		$sql = new mysqli('localhost','root','','openvote');
		if($sql->connect_error){
			trigger_error("Error: " . $sql->connect_error);
		}
		// Algorithm:
			/*
			Find num rows in presidential ballot, copy rows 1 to n into the general poll's table
			*/
	}
?>