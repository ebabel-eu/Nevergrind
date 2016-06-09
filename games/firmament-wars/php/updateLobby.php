<?php
	header('Content-Type: application/json');
	require_once('connect1.php');
	
	require('pingLobby.php');

	$query = "select account, nation, flag, player from fwPlayers where game=? and timestamp > date_sub(now(), interval {$_SESSION['lag']} second) order by player";
	
	$stmt = $link->prepare($query);
	$stmt->bind_param('i', $_SESSION['gameId']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($account, $nation, $flag, $player);
	
	$x = new stdClass();
	$x->lobbyData = "";
	$x->hostFound = false;
	$totalPlayers = 0;
	while($stmt->fetch()){
		$totalPlayers++;
		if ($player === 1){
			$x->hostFound = true;
		}
		$x->lobbyData .= 
		"<div class='row lobbyRow'>
			<div class='col-xs-3'>";
		if ($flag != "Default.jpg"){
			$x->lobbyData .= "<img src='images/flags/{$flag}' class='player{$player} w100 block center'>";
		} else {
			$x->lobbyData .= "<img src='images/flags/Player{$player}.jpg' class='player{$player} w100 block center'>";
		}
		$x->lobbyData .= 
			"</div>
			<div class='col-xs-9 text-center lobbyNationInfo'>
				<div class='text-warning'>{$account}</div>
				<div class='lobbyNationName'>{$nation}</div>
			</div>
		</div>";
	}
	// is my gameId started?
	$query = "SELECT row FROM `fwgames` where row=? and start > 0";
	$stmt = $link->prepare($query);
	$stmt->bind_param('i', $_SESSION['gameId']);
	$stmt->execute();
	$stmt->store_result();
	$startedGame = $stmt->num_rows;
	
	$x->name = $_SESSION['gameName'];
	$x->max = $_SESSION['max'];
	$x->timer = $_SESSION['timer'];
	$x->map = $_SESSION['map'];
	$x->player = $_SESSION['player'];
	$x->gameStarted = $startedGame;
	$x->totalPlayers = $totalPlayers;
	echo json_encode($x);
?>