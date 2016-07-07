<?php
	header('Content-Type: application/json');
	require_once('connect1.php');
	
	$query = 'select sum(food), sum(production), sum(culture) from `fwTiles` where account=? and game=? limit 1';
	$stmt = $link->prepare($query);
	$stmt->bind_param('si', $_SESSION['account'], $_SESSION['gameId']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($food, $production, $culture);
	
	$x = new stdClass();
	
	while($stmt->fetch()){
		$x->sumFood = $food;
		$x->sumProduction = $production;
		$x->sumCulture = $culture;
	}
	// set session values
	$x->food = isset($_SESSION['food']) ? $_SESSION['food'] > 9999 ? 9999 : $_SESSION['food'] : 0;
	$x->production = isset($_SESSION['production']) ? $_SESSION['production'] > 9999 ? 9999 : $_SESSION['production'] : 0;
	$x->culture = isset($_SESSION['culture']) ? $_SESSION['culture'] > 9999 ? 9999 : $_SESSION['culture'] : 0;
	$x->foodMax = isset($_SESSION['foodMax']) ? $_SESSION['foodMax'] : 0;
	$x->cultureMax = isset($_SESSION['cultureMax']) ? $_SESSION['cultureMax'] : 0;
	$x->manpower = isset($_SESSION['manpower']) ? $_SESSION['manpower'] : 0;
	$x->foodMax = isset($_SESSION['foodMax']) ? $_SESSION['foodMax'] : 50;
	
	
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