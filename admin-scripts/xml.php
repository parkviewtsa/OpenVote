<?php
	if(empty($_COOKIE['PSSID'])){
		trigger_error('Not Logged In');
		die();
	}
	
?>
