<!DOCTYPE html>

<html>
	<head>
		<title>OpenVote - Vote</title>
		<link href="./style.css" rel="stylesheet" type="text/css" />
	<link href="./admin.css" rel="stylesheet" type="text/css" />
	<link href="./vote.css" rel="stylesheet" type="text/css" />
	<script src="./scripts/libs/jquery-1.9.1.js">
		
	</script>
	<script src="./scripts/OpenVote.js">
	
	</script>
	<script src="./scripts/admin.js">
	
	</script>
	<script src="./scripts/vote.js">
	
	</script>
	</head>
	<body>
		<div id="global_nav_bar">
			<div id="global_nav_item" onmouseover="javascript:this.style.cursor='pointer'" onclick="javascript:redirect('index.php');"><span id="global_nav_text">OpenVote</span></div>
			<div id="global_nav_item" onmouseover="javascript:this.style.cursor='pointer'" onclick="javascript:redirect('vote.php');"><span id="global_nav_text">Voting Applet</span></div>
			<div id="global_nav_item" onmouseover="javascript:this.style.cursor='pointer'" onclick="javascript:redirect('view_poll.php');"><span id="global_nav_text">View Polls</span></div>
			<div id="global_nav_item" onmouseover="javascript:this.style.cursor='pointer'" style="float:right;" onclick="javascript:redirect('admin.php');"><span id="global_nav_text">Admin. Page</span></div>
		</div>
		<?php
			if(isset($_POST['action'])){
				if (strval($_POST['action']) == '0'){
				$sql = new mysqli('localhost','root','','openvote');
				$p = $_POST['presidential'];
				if ($p == '1'){
					var_dump($_POST);
					$choice =strval($_POST['c1']);
					if (!($votes_result = $sql->query('SELECT votes FROM '.$_POST['ballotid'].' WHERE choice_id='.$choice.''))){
						die($sql->error);
					}
					$a =$votes_result->fetch_row();
					$v = $a[0];
					$v+=1;
					$votes_result->close();
					if(!($sql->query('UPDATE '.$_POST['ballotid'].' SET votes='.$v.' WHERE choice_id='.$choice.''))){
						die($sql->error);
					}
				}
			}
			}
			else if(empty($_POST['action']) && !isset($_GET['action'])){
				$sql= new mysqli('localhost','root','','openvote');
				if($sql->connect_error){
					die($sql->connect_error);
				}
				echo '<div id="outer-cbox"><form action="vote.php"><input type="hidden" name="action" value="1" /><label>Which ballot do you want to vote for: </label><select name="ballotid">';
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
				echo '</form></div></body></html>';
				die();
			}else if(strval($_GET['action']) == '1'){
				$sql = new mysqli('localhost','root','','openvote');
				if(substr(strval($_GET['ballotid']),0) == 'p'){
					$choices = 1;
				}else{
					$choices = 7;
				}
				echo '<form action="vote.php" method="POST"><input type="hidden" name="action" value="0" />';
				echo '<input type="hidden" name="ballotid" value="'.$_GET['ballotid'].'"><input type="hidden" name="presidential" value="';
				if(substr(strval($_GET['ballotid']),0,1)[0] == 'p'){
					echo '1';
				}else{
					echo '0';
				}
				echo '" />';
				$choices = 7;
				for ($i=0;$i<$choices;$i++){
					echo ('<input type="hidden" id="c'.($i+1).'" name="c'.($i+1).'" value="0" />');
				}
				echo '<br><br><br><input type="submit" value="Submit Ballot" style="margin-left:15px;"/></form>';
				echo '<div id="vote-frame">';
		$ballot = $_GET['ballotid'];
		if(!($data = $sql->query("SELECT `name`,`usr-pic`,`choice_id` FROM `$ballot` ORDER BY votes DESC"))){
			die($sql->error);
		}
		for($i=0;$i<$data->num_rows;$i++){
			$candidate = $data->fetch_row();
			$name = $candidate[0];
			$pic = $candidate[1];
			$choice = $candidate[2];
echo <<<END
<div class="ballot-item" id="$choice" onclick="javascript:addVote('$choice')">
	<img id="ballot-item-image" src="./img/0002/$pic" /> <br />
	<span id="ballot-item-name">$name</span> <br />
</div>
END;
		}
echo <<<END
		</div>
	</body>
</html>
END;
				
			}
		?>
