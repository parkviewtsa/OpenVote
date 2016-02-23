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
	if(isset($_COOKIE['PSSID'])){
		$id = $_COOKIE['PSSID'];
		$sql = new mysqli('localhost','root','','users');
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
			$location='https://localhost/openvote/index.php?e=invalidCred';
			$sql->close();
			header("Location: $location");
			exit;
			die();
		}
		}else{
			$location='https://localhost/openvote/index.php?e=invalidCred';
			header("Location: $location");
			exit;
			die();
		}	
			$ballots = '';
			$sql = new mysqli('localhost','root','','openvote');
			$query = "SHOW TABLES IN openvote";
			if($sql->connect_error){
				echo $sql->connect_error;
				die(' </form>
				</div>
				</body>
				</html>');
			}
			if(!$tables=$sql->query($query)){
				echo $sql->connect_error;
			}
			$table=$tables->fetch_array();
			while($table=$tables->fetch_array()){
				$ballots = $ballots.'<option value="'.$table[0].'">'.$table[0].'</option>';
			}
			
			$sql = new mysqli('localhost','root','','voters');
			$query = "SHOW TABLES IN `voters`";
			if($sql->connect_error){
				echo $sql->connect_error;
				die(' </form>
				</div>
				</body>
				</html>');
			}
			$voters = '';
			if(!$tables=$sql->query($query)){
				echo $sql->connect_error;
			}
			while($table=$tables->fetch_array()){
				$voters = $votes.'<option value="'.$table[0].'">'.$table[0].'</option>';
			}
			$sql->close();
}
?>
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
	<body onload="javascript:addIDs();">
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
							<li><span id="sidebar-option" onclick="javascript:changeSemper('BallotKiller');">Delete Ballot</span></li>
							
				</ul>
			</div>
			<div id="action-panel">
				<div id="action">
					<div id="Default" class="action-semper" style="display:inline">
						<center><h2>Click an Option to Get Started</h2></center>
					</div>
					<div id="BallotBuilder" class="action-semper"> <!-- Ballot Creator -->
						<center><h2> Ballot Builder </h2></center>
						<form action="action.php" method="POST">
							<input type="hidden" name="action" value="1" />
							<input type="hidden" name="ballot_id" id="ballot_id" value="0"/>
							<input type="hidden" name="candidates" id="candidates" value="1" />
							<div id="ballot-header">
								Ballot ID: <script>document.write(ballotId)</script>
								<span style="float:right;padding-right:15px;"><label>What type of ballot is this:
									<select name="presidential">
										<option value="1">Presidential</option>
										<option value="0">General</option>
									</select>
								</span>
							</div>
							<div id="ballot-creator">
								<div id="candidate1" class="candidate"><center>
									<div class="img-upload">
										<img src="img/img-001.jpg" class="candidate-img" />
										<br>
										<label>Name: </label><input type="text" id="name1" name="name1" onfocus="javascript:f('name1');" style="margin-top:15px;" value="Candidate Name..." />
									</div>
								</center></div>
							</div>
							<input type="submit" id="ballot-creator-submit-button" value="Create Ballot" />
						</form><hr /><br />
						<button onclick="javascript:addCandidate();" id="add-candidate" text="Add Candidate">Add Candidate</button>
					</div>
					<div id="BallotKiller" class="action-semper"> <!-- Ballot Killer -->
						<center><h2> Delete Ballot </h2></center>
						<form action="action.php" class="center-box" method="post">
							<input type="hidden" name="action" value="2" />
							<label>Which ballot should I delete: </label>
							<select name="ballotid">
								<?php
									$query = "SHOW TABLES IN openvote";
									if(!$tables=$sql->query($query)){
										echo $sql->connect_error;
									}
									$table=$tables->fetch_array();
									$table=$tables->fetch_array();
									while($table=$tables->fetch_array()){
										echo '<option value="'.$table[0].'">'.$table[0].'</option>';
									}
									echo '</select>';
									echo '<input type="submit" value="Go!" />';
								?>
							</select>
							<input type="submit" value="Delete Ballot" />
						</form>
					</div>
				</div>
			</div>
			
		</div>
	</body>
</html>