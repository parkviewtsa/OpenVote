<?php
	if(empty($_POST['action'])){
		die('give an action to perform');
	}
	$rand = array();
	$sql = new mysqli('localhost','root','','openvote');
	switch ($_POST['action']){
		case 1: // Create Ballot
			for($i=0;$i<intval($_POST['candidates']);$i++){
				$rand[$i] = rand(1000,9999);
			}
			if (intval($_POST['presidential'])){
				if(!$sql->query('CREATE TABLE `p'.$_POST['ballot_id'].'` LIKE `0001`')){
					die($sql->error);
				}
				$query = 'INSERT INTO `p'.$_POST['ballot_id'].'` (`choice_id`,`name`,`votes`,`usr-pic`) VALUES ';
				$pool = 'Presidential';
			}else{
				if($sql->query('CREATE TABLE `'.$_POST['ballot_id'].'` LIKE `0001`')){
					die('could not create ballot');
				}
				$query = 'INSERT INTO `'.$_POST['ballot_id'].'` (`choice_id`,`name`,`votes`,`usr-pic`) VALUES ';
				$poll = 'General';
			}
			echo intval($_POST['candidates']);
			for($i=0;$i<intval($_POST['candidates']);$i+=1){
				// echo $i.'<br>';
				$query = $query.'('.$rand[$i].',\''.$_POST['name'.($i+1)].'\',0,\'img-001.jpg\')';
				if(!$sql->query($query)){
					die('<br>something went wrong<br>'.$sql->error);
				}
				$query = 'INSERT INTO `p'.$_POST['ballot_id'].'` (`choice_id`,`name`,`votes`,`usr-pic`) VALUES ';
			}
			$query = 0;
			
			$sql->close();
			
			break;
		
		case 2: // Delete Ballot
			$ballot = $_POST['ballot_id'];
			if($sql->query('DROP TABLE `'.$ballot.'`')){
				die($sql->error);
			}
			$sql->close();
			
			break;
		
		default: // The form returned a different action
			$sql->close();
			
	}
	header( 'Location: https://localhost/OpenVote/admin.php' );
?>