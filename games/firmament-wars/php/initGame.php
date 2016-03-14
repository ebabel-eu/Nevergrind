<?php
	require_once('connect1.php');
	
	$query = 'select game from fwPlayers where account=?';
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $_SESSION['account']);
	$stmt->execute();
	$stmt->store_result();
	$count = $stmt->num_rows;
	if ($count > 0){
		$stmt->bind_result($gameId);
		while($stmt->fetch()){
			echo $gameId;
		}
	} else {
		echo "";
	}
?>