<?php
	$host = 'localhost';
	$url = "$host/openvote";
	if ($_SERVER['HTTPS'] != "on") { 
    	$url = "https://". $_SERVER['SERVER_NAME'] . "/openvote/index.php?ssl=enabled"; 
    	header("Location: $url"); 
		exit; 
	}
	$user = 'root';
	$pass = '';
	$db = 'users';
	if(!(isset($_POST['user'],$_POST['pass'])) && !(isset($_COOKIE['PSSID']))){
		$location="https://$url/index.php?e=noArgs";
		header("Location: $location");
		
		die("Not all arguments were given");
	}else if(isset($_COOKIE['PSSID'],$_POST['user'],$_POST['pass']) || isset($_POST['user'],$_POST['pass'])){
		
	
	
	// Verify the admin's credentials
	$username = $_POST['user'];
	$password = $_POST['pass'];
	
	
	
	$sql = new mysqli($host,$user,$pass,$db);
	if($sql->connect_error){
		die('Error: '.$sql->connect_error);
	}
	$query = 'SELECT * FROM admin WHERE (Username=\''.$username.'\') AND (Password=\''.$password.'\')';
	$credArry = $sql->query($query,MYSQLI_USE_RESULT);
	
	if(!($credArry->num_rows === 0)){
		die('<html>
			<head>
				<script>
					function fail(){
						document.window = "./index.php?e=defError";
					}
					window.onload = fail();
				</script>
			</head>
			<body onload="fail()">
			</body>
		</html>');
	}
	$c = $credArry->fetch_row();
	if ($c[0] != $username || $c[1] != $password){
		$credArry->close();
		$sql->close();
		die("INCORRECT PASSWORD OR USERNAME");
	}
	setcookie("PSSID",$c[2],time()+60*30,"./",$host,true,false);
	
	
	$credArry->close();
	$sql->close();
	$location="https://$url/admin.php";
	header("Location: $location");
	exit;
	die();
}else if(isset($_COOKIE['PSSID'])){
		$id = $_COOKIE['PSSID'];
		$sql = new mysqli($host,$user,$pass,$db);
		if($sql->connect_error){
			die('Error: '.$sql->connect_error);
		}
		$query = 'SELECT * FROM admin WHERE Identifier=\''.$id.'\'';
		if (!($credArry=$sql->query($query))){
			die($sql->connect_error);	
		}
		if(!($row=$credArry->fetch_row())){
			die();
		}
		
		if(!($row[2] == $id)){
			$location="https://$url/index.php?e=invalidCred";
			header("Location: $location");
			exit;
			die();
		}
echo <<<END
<!DOCTYPE html>
<html>
	<head>
	<meta charset="UTF-8">
	<title>OpenVote - Administration</title>
	<link href="./style.css" rel="stylesheet" type="text/css" />
	<link href="./admin.css" rel="stylesheet" type="text/css" />
	<script src="./scripts/libs/jquery-1.9.1.js">
		
	</script>
	<script src="./scripts/OpenVote.js">
	
	</script>
	<script src="./scripts/admin.js">
	
	</script>
</head>
	<body>
		<div id="global_nav_bar">
			<div id="global_nav_item" onmouseover="javascript:this.style.cursor='pointer'" onclick="javascript:redirect('index.php');"><span id="global_nav_text">OpenVote</span></div>
			<div id="global_nav_item" onmouseover="javascript:this.style.cursor='pointer'" onclick="javascript:redirect('applet.htm');"><span id="global_nav_text">Voting Applet</span></div>
			<div id="global_nav_item" onmouseover="javascript:this.style.cursor='pointer'" onclick="javascript:redirect('view_poll.php');"><span id="global_nav_text">View Polls</span></div>
			<div id="global_nav_item" onmouseover="javascript:this.style.cursor='pointer'" style="float:right;" onclick="javascript:redirect('admin.php');"><span id="global_nav_text">Admin. Page</span></div>
		</div>
	
		<div id="admin-panel">
			<div id="sidebar-menue">
				<ul>
					<li><span id="sidebar-category">Ballot Actions</span></li>
						<ul>
							<li><span id="sidebar-option" onclick="javascript:changeSemper('BallotBuilder');">Create Ballot</span></li>
							<li><span id="sidebar-option" onclick="javascript:changeSemper('BallotChanger');">Edit Ballot</span></li>
							<li><span id="sidebar-option" onclick="javascript:changeSemper('BallotKiller');">Delete Ballot</span></li>
							<li><span id="sidebar-option" onclick="javascript:changeSemper('BallotActivator');">Activate Ballot</span></li>
						</ul>
					<li><span id="sidebar-category">Voter Actions</span></li>
						<ul>
							<li><span id="sidebar-option" onclick="javascript:changeSemper('VoterCreator');">Generate Voter List</span></li>
							<li><span id="sidebar-option" onclick="javascript:changeSemper('VoterPrinter');">Print Voter List</span></li>
							<li><span id="sidebar-option" onclick="javascript:changeSemper('VoterRegister');">Register Voter List</span></li>
						</ul>
					<li><span id="sidebar-category">Permissions</span></li>
						<ul>
							<li><span id="sidebar-option" onclick="javascript:changeSemper('BViewable');">Ballots Viewable</span></li>
							<li><span id="sidebar-option" onclick="javascript:changeSemper('BVotable');">Ballots Votable</span></li>
						</ul>
				</ul>
			</div>
			<div id="action-panel">
				<div id="action">
					<div id="action-semper">
						
					</div>
				</div>
			</div>
			
		</div>
	</body>
</html>
	
END;
		
	}else{
		echo "AN ERROR HAS OCCURED";
	}
	// Print the admin page

	// * Page must modify the xml file
	// * Page must be able to modify and create sql tables and entries
?>