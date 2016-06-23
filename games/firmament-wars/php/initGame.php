<?php
	header('Content-Type: application/json');
	require_once('connect1.php');
	
	$x = new stdClass();
	$x->food = isset($_SESSION['food']) ? $_SESSION['food'] : 0;
	$x->production = isset($_SESSION['production']) ? $_SESSION['production'] : 0;
	$x->culture = isset($_SESSION['culture']) ? $_SESSION['culture'] : 0;
	$x->gameId = 0;
	
	$query = "select game from fwPlayers where account=? and timestamp > date_sub(now(), interval {$_SESSION['lag']} second)";
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $_SESSION['account']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($gameId);
	
	if ($stmt->num_rows > 0){
		if (!isset($_SESSION['gameName'])){
			require('unsetSession.php');
		} else {
			while($stmt->fetch()){
				$x->gameId = $gameId;
			}
		}
	}
	echo json_encode($x);
?>