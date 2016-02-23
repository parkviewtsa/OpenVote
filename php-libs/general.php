<?php
	function getVotes($ballotid, $presidential){
		$sql = new mysqli('localhost','root','','openvote');
		if($sql->connect_error){
			trigger_error("Error: " . $sql->connect_error);
		}
		if($presidential){
			$table=$sql->query("SELECT votes FROM $ballotid");
			return $table;
		}
	
	}

?>