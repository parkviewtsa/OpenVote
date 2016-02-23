<?php
	if(empty($_COOKIE['PSSID'])){
		trigger_error('Not Logged In');
		die();
	}
	$host = 'localhost';
	function activateBallot($id){
		$in = "/ballots/config-$id.xml";
		$out = "/applet/config/config.xml";
		if(!copy($in,$out)){
			trigger_error("IO Error");
			die();
		}
		return 0;
	}
?>