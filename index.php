<?php
	if ($_SERVER['HTTPS'] != "on") { 
    	$url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; 
    	header("Location: $url"); 
		exit; 
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>OpenVote</title>
	<script src="./scripts/libs/jquery-1.9.1.js">
		
	</script>
	<link href="./style.css" rel="stylesheet" type="text/css" />
	<script src="./scripts/OpenVote.js">
	
	</script>
</head>
<body>
	<div id="global_nav_bar">
		<div id="global_nav_item"><span id="global_nav_text" onclick="javascript:redirect('index.php');">OpenVote</span></div>
		<div id="global_nav_item" onmouseover="javascript:this.style.cursor='pointer'" onclick="javascript:redirect('vote.php');"><span id="global_nav_text">Voting Applet</span></div>
	  <div id="global_nav_item" onmouseover="javascript:this.style.cursor='pointer'" onclick="javascript:redirect('view_poll.php');"><span id="global_nav_text">View Polls</span></div>
		<div id="global_nav_item" onmouseover="javascript:this.style.cursor='pointer'" onclick="javascript:redirect('admin.php');" style="float:right;"><span id="global_nav_text">Admin. Page</span></div>
	</div>
<center>
	<div id="outer-cbox"><span id="inner-cbox-text">
    <hr>
	<form method="POST" action="admin.php">
		<p>Welcome to the OpenVote Web Application! <br>Type in your credentials to access the administrator panel.</p>
		<label>Username: </label><input type="text" name="user" value="Username" id="uname" onFocus="javascript:this.value=''" /><br /><br>
		<label>Password: </label><input type="password" name="pass" value="Turtle" id="pw" onFocus="javascript:this.value=''" /><br /><br />
		<input type="submit" value="Submit" action="submit" />
	</form>
    <hr>
    	<a href="view_poll.php?id=001" id="nodecor">View Polls</a> | 
		<a href="vote.php" id="nodecor">Vote Page</a><br/>
	</span></div>
    </center>
</body>

</html>