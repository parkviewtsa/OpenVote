<?php
	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$db = 'openvote';
	include('./php-libs/general.php');
	
	if (!(isset($_GET['pollid']))){
echo <<<END
<!DOCTYPE html>
			<html>
				<head>
					<title>OpenVote - View Poll</title>
					<link rel="stylesheet" href="./style.css" type="text/css" />
					<script src="scripts/OpenVote.js">
					
					</script>
				</head>
				<body>
					<div id="global_nav_bar">
		<div id="global_nav_item" onmouseover="javascript:this.style.cursor='pointer'" onclick="javascript:redirect('index.php');"><span id="global_nav_text">OpenVote</span></div>
		<div id="global_nav_item" onmouseover="javascript:this.style.cursor='pointer'" onclick="javascript:redirect('vote.php');"><span id="global_nav_text">Voting Applet</span></div>
	  <div id="global_nav_item" onmouseover="javascript:this.style.cursor='pointer'" onclick="javascript:redirect('view_poll.php');"><span id="global_nav_text">View Polls</div>
		<div id="global_nav_item" onmouseover="javascript:this.style.cursor='pointer'" onclick="javascript:redirect('admin.php');" style="float:right;"><span id="global_nav_text">Admin. Page</span></div>
	</div>
					<div id="outer-cbox">
						<form action="view_poll.php" method="GET">
							<label>Choose an election to view: </label><select name="pollid">
END;
		$query = "SHOW TABLES IN openvote";
		$sql = new mysqli($host,$user,$pass,$db);
		if($sql->connect_error){
			echo $sql->connect_error;
			die(' </form>
					</div>
				</body>
			</head>
			</html>');
		}
		if(!$tables=$sql->query($query)){
			echo $sql->connect_error;
		}
		while($table=$tables->fetch_array()){
			echo '<option value="'.$table[0].'">'.$table[0].'</option>';
		}
		
echo <<<END
' </select><input type="submit" value="Submit"></form>
					</div>
				</body>
			</html>
END;
	}else{
		$ballot = $_GET['pollid'];
		$sql = new mysqli($host,$user,$pass,$db);
		if($sql->connect_error){
			echo $sql->connect_error;
			die();
		}
echo <<<END
<!DOCTYPE html>
			<html>
				<head>
					<title>OpenVote - View Poll</title>
					<link rel="stylesheet" href="./style.css" type="text/css" />
					<link rel="stylesheet" href="./view_poll.css" type="text/css" />
					<script src="scripts/OpenVote.js">
					
					</script>
				</head>
				<body>
					<div id="global_nav_bar">
		<div id="global_nav_item" onmouseover="javascript:this.style.cursor='pointer'" onclick="javascript:redirect('index.php');"><span id="global_nav_text">OpenVote</span></div>
		<div id="global_nav_item" onmouseover="javascript:this.style.cursor='pointer'" onclick="javascript:redirect('vote.php');"><span id="global_nav_text">Voting Applet</span></div>
	  <div id="global_nav_item" onmouseover="javascript:this.style.cursor='pointer'" onclick="javascript:redirect('view_poll.php');"><span id="global_nav_text">View Polls</div>
		<div id="global_nav_item" onmouseover="javascript:this.style.cursor='pointer'" onclick="javascript:redirect('admin.php');" style="float:right;"><span id="global_nav_text">Admin. Page</span></div>
	</div>
	<div id="vote-frame">
END;
		$data = $sql->query("SELECT name,votes,usr-pic FROM $ballot ORDER BY votes DESC");
		if(!($data = $sql->query("SELECT `name`,`votes`,`usr-pic` FROM `$ballot` ORDER BY votes DESC"))){
			die($sql->error);
		}
		for($i=0;$i<$data->num_rows;$i++){
			$candidate = $data->fetch_row();
			$name = $candidate[0];
			$votes = $candidate[1];
			$pic = $candidate[2];
			$place = $i+1;
			$last = substr(strval($place),-1);
			$first = substr(strval($place),0);
			if($last=='2' && $first!='1'){
				$suffix='nd';
			}else if($last=='1' && ($first!='1' || strlen(strval($place))==1)){
				$suffix='st';
			}else if($last=='3' && $first!='1'){
				$suffix='rd';
			}else{
				$suffix = 'th';
			}
echo <<<END
<div id="ballot-item">
	<span id="ballot-item-place">$place<super>$suffix</super></span><br /><br />
	<img id="ballot-item-image" src="./img/$ballot/$pic" /> <br />
	<span id="ballot-item-name">$name</span> <br />
	<span id="ballot-item-votes">$votes Votes</span>
</div>
END;
		}
echo <<<END
		</div>
	</body>
</html>
END;
	}
	$sql->close();
?>