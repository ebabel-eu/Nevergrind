<?php
require_once('connect1.php');

// must be host
if ($_SESSION['player'] === 1){
	// must have 2-8 players
	$query = "select player, account, nation, flag from `fwplayers` where game=? and timestamp > date_sub(now(), interval {$_SESSION['lag']} second)";
	$stmt = $link->prepare($query);
	$stmt->bind_param('i', $_SESSION['gameId']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($dPlayer, $dAccount, $dNation, $dFlag);
	$count = $stmt->num_rows;
	
	$players = array();
	while($stmt->fetch()){
		$x = new stdClass();
		$x->player = $dPlayer;
		$x->account = $dAccount;
		$x->nation = $dNation;
		$x->flag = $dFlag;
		array_push($players, $x);
	}
	
	if ($count < 2 || $count > 8){
		header('HTTP/1.1 500 You failed to join the game.');
		exit;
	}
	// must timestamp start of game
	$query = "update fwGames set start=now() where row=?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('i', $_SESSION['gameId']);
	$stmt->execute();
	// resource functions
	function getFood(){
		$x = 2;
		$roll = rand(1, 20);
		if ($roll === 20){
			$x = 4;
		} else if ($roll >=18){
			$x = 3;
		}
		return $x;
	}
	function getProduction(){
		$x = 0;
		$roll = rand(1, 20);
		if ($roll === 20){
			$x = 5;
		} else if ($roll >=18){
			$x = 4;
		} else if ($roll >=15){
			$x = 3;
		} else if ($roll >= 10){
			$x = 2;
		}
		return $x;
	}
	function getCulture(){
		$x = 0;
		$roll = rand(1, 20);
		if ($roll === 20){
			$x = rand(5, 7);
		} else if ($roll >=17){
			$x = rand(3, 4);
		} else if ($roll >=13){
			$x = 2;
		}
		return $x;
	}
	// determine map and 8 possible start points
	$map = $_SESSION['map'];
	$maxTiles = 1;
	if ($map === "Earth Alpha"){
		$maxTiles = 83;
		// set barbarians
		for ($i = 0; $i < $maxTiles; $i++){
			$barbarianUnits = rand(0, 7) > 5 ? rand(1,2) : 0;
			$food = getFood();
			$production = getProduction();
			$culture = getCulture();
			$query = "insert into fwTiles (`game`, `tile`, `units`, `food`, `production`, `culture`) 
				VALUES (?, $i, $barbarianUnits, $food, $production, $culture)";
			$stmt = $link->prepare($query);
			$stmt->bind_param('i', $_SESSION['gameId']);
			$stmt->execute();
		}
		
		// configure player data
		$start = array(79, 24, 29, 47, 69, 52, 9, 46);
		$len = count($players);
		for ($i=0; $i<$len; $i++){
			$startLen = count($start);
			$startIndex = rand(0, $startLen-1);
			$startTile = $start[$startIndex];
			$players[$i]->start = $startTile;
			array_splice($start, $startIndex, 1);
			// set start tiles
			$query = "update fwplayers set startTile=$startTile where account=?";
			$stmt = $link->prepare($query);
			$stmt->bind_param('s', $players[$i]->account);
			$stmt->execute();
			
			// set starting units
			$query = "update fwTiles set account=?, player=?, nation=?, flag=?, units=7, food=5, production=3, culture=8 where tile=$startTile and game=?";
			$stmt = $link->prepare($query);
			$stmt->bind_param('sissi', $players[$i]->account, $players[$i]->player, $players[$i]->nation, $players[$i]->flag, $_SESSION['gameId']);
			$stmt->execute();
			
		}
		
	} else {
		// another map
	}
}
?>