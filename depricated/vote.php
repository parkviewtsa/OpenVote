<!DOCTYPE html>
<?php
	if(!(isset($_POST['identifier']) && isset($_POST['choice']) && isset($_GET['pollid']) && isset($_GET['presidential']))){
		die("NOT ENOUGH PARAMETERS");
	}
	
	$server = 'localhost';
	$user = 'root';
	$pass = '';
	$db = 'users';
	
	$pollid = intval($_GET['pollid']);
	$choice = intval($_POST['choice']);
	$id = intval($_POST['identifier']);
	$pres = intval($_GET['presidential']);
	if($pres){
		$sql = new mysqli($server,$user,$pass,$db);

		if($sql->connect_error){
			die("Error: " . $sql->connect_error);
		}
		
		$credentialArray = $mysqli->query('SELECT * FROM users WHERE id='.$id.' AND poll'.$pollid.'=0');
		if(!($credentialArray->numRows())){
			die('Error: The credentials you provided were not been found in our database or you have not been registered for this poll: Identifier: '.$id.' Not Found');
		}
	
		$credentialArray->close();
	
		$sql->close();
		$sql = new mysqli($server,$user,$pass,'openvote');
		if($sql->connect_error){
			die("Error: " . $sql->connect_error);
		}
	
		$voteArray = $sql->query('SELECT votes FROM ' . $pollid . ' WHERE choice_id="' . $choice.'"');
		
		if(!($voteArray->num_rows())){
			die('Error: No choice "'.$choice.'" in poll "'.$pollid.'"');
		}
	
		$votes = $voteArray->fetch_array(MYSQLI_ASSOC);
		$v = intval($votes['votes']);
		$v+=1;
	
		$voteArray->close();
	
		$sql->query('UPDATE '.$pollid.' SET votes='.$v.' WHERE choice_id="'.$choice.'"');
	
		$sql->close();
		$sql = new mysqli($server,$user,$pass,$db);
		if($sql->connect_error){
			die("Error: " . $sql->connect_error);
		}
	
		$sql->query('UPDATE 0001 SET poll'.$pollid.'=1 WHERE id="'.$id.'"');
		
		$sql->close();
	}else{
		$sql = new mysqli($server,$user,$pass,$db);
		if($sql->connect_error){
			die("Error: " . $sql->connect_error);
		}
		if(!(isset($_POST['c1'],$_POST['c2'],$_POST['c3'],$_POST['c4'],$_POST['c5'],$_POST['c6'],$_POST['c7'],$_POST['c8'],$_POST['c9'],$_POST['c10'],$_POST['c11']))){
			die("Not All Choices Are Present");
		}
		
		$c_array = array(
		$_POST['c1'],
		$_POST['c2'],
		$_POST['c3'],
		$_POST['c4'],
		$_POST['c5'],
		$_POST['c6'],
		$_POST['c7']);
		
		for($i=0;$i<count($c_array);$i++){
			$voteArray = $sql->query('SELECT votes FROM ' . $pollid . ' WHERE choice_id="' . $c_array[$i].'"');
		
			if(!($voteArray->num_rows())){
				die('Error: No choice "'.$choice.'" in poll "'.$pollid.'"');
			}
	
			$votes = $voteArray->fetch_array(MYSQLI_ASSOC);
			$v = intval($votes['votes']);
			$v+=1;
	
			$voteArray->close();
	
			$sql->query('UPDATE g'.$pollid.' SET votes='.$v.' WHERE choice_id="'.$c_array[$i].'"');
		}
		$sql->close();
		$sql = new mysqli($server,$user,$pass,$db);
		if($sql->connect_error){
			die("Error: " . $sql->connect_error);
		}
	
		$sql->query('UPDATE 0001 SET gpoll'.$pollid.'=1 WHERE id="'.$id.'"');
		
		$sql->close();
		
	}
	
	
	
?>
<html>
	<head>
		<script>
			function redirect(location){
				window.location = './'+location;
			}
		</script>
	</head>
	
	<body onLoad="javascript:redirect('index.php')">
	
	</body>
</html>