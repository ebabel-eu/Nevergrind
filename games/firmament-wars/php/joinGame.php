<?php
	require_once('connect1.php');
	
	$gameId = $_POST['gameId']*1;
	
	$query = "select g.name, count(p.game) activePlayers, g.max max, g.map map 
				from fwGames g 
				join fwplayers p 
				on g.row=p.game and p.timestamp > date_sub(now(), interval {$_SESSION['lag']} second)
				where g.row=? 
				group by p.game";
	$stmt = $link->prepare($query);
	$stmt->bind_param('i', $gameId);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($dgameName, $dactivePlayers, $dmax, $dmap);
	while($stmt->fetch()){
		$gameName = $dgameName;
		$activePlayers = $dactivePlayers;
		$max = $dmax;
		$map = $dmap;
	}
	
	$count = $stmt->num_rows;
	if ($activePlayers == 0){
		header('HTTP/1.1 500 All players have left the game.');
		exit;
	}
	if ($activePlayers >= $max){
		header('HTTP/1.1 500 The game is full');
		exit;
	}
	// set session values
	$_SESSION['gameId'] = $gameId;
	$_SESSION['max'] = $max;
	$_SESSION['gameName'] = $gameName;
	$_SESSION['map'] = $map;
	$_SESSION['food'] = 0;
	$_SESSION['foodMax'] = 150;
	$_SESSION['production'] = 0;
	$_SESSION['culture'] = 0;
	$_SESSION['cultureMax'] = 400;
	
	// determine player number
	$query = "select player from fwPlayers where game=?;";
	$stmt = $link->prepare($query);
	$stmt->bind_param('i', $gameId);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($player);
	$a = array();
	while($stmt->fetch()){
		array_push($a, $player);
	}
	// set player session value
	unset($_SESSION['player']);
	for ($i=1; $i <= $_SESSION['max']; $i++){
		if (!in_array($i, $a)){
			if (!isset($_SESSION['player'])){
				$_SESSION['player'] = $i;
			}
		}
	}
	// sanity check
	if ($_SESSION['player'] < 1 || $_SESSION['player'] > $_SESSION['max']){
		header('HTTP/1.1 500 Failed to join game: (player: ' . $_SESSION['player'] . ')');
		exit;
	}
	
	// get account flag
	$_SESSION['nation'] = "";
	$_SESSION['flag'] = "";

	$query = "select nation, flag from fwNations where account=?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $_SESSION['account']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($dNation, $dFlag);
	$count = $stmt->num_rows;
	if ($count < 1){
		header('HTTP/1.1 500 Cannot access nation data.');
		exit;
	}
	while($stmt->fetch()){
		$_SESSION['nation'] = $dNation;
		$_SESSION['flag'] = $dFlag;
	}
	// cleanup stale player data
	$query = "delete from fwPlayers where timestamp < date_sub(now(), interval {$_SESSION['lag']} second)";
	$stmt = $link->query($query);
	
	require('pingLobby.php');
	
	require('updateLobby.php');
?>